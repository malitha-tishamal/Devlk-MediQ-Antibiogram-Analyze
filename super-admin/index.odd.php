<?php
session_start();

require_once '../includes/db-conn.php';

require_once '../includes/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['admin_id'];
$sql = "SELECT name, email, nic, mobile, profile_picture FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Create tables if they don't exist
$create_tables_sql = "
CREATE TABLE IF NOT EXISTS antibiogram_reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id INT NOT NULL,
    original_filename VARCHAR(255) NULL,
    file_path VARCHAR(500) NULL,
    pasted_data TEXT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES admins(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS antibiogram_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    report_id INT NOT NULL,
    organism VARCHAR(255) NOT NULL,
    antibiotic VARCHAR(255) NOT NULL,
    tested_count INT NOT NULL,
    susceptible_count INT NOT NULL,
    percentage FLOAT NULL,
    FOREIGN KEY (report_id) REFERENCES antibiogram_reports(id) ON DELETE CASCADE
);
";

$conn->multi_query($create_tables_sql);
// Clear any remaining results
while ($conn->next_result()) {;}

/** Normalize a single cell to S/R/null */
function normalize_result($val) {
    if ($val === null) return null;
    $v = trim(strtolower($val));
    if ($v === '' || $v === '-' || $v === 'os' || $v === 'nt') return null; // not tested

    $sus_patterns = ['sensitive', 'intermediate', 'intermediate sensitive', 's', 'i'];
    $res_patterns = ['resistant','r'];

    foreach ($sus_patterns as $p) if(strtolower($v)===strtolower($p)) return 'S';
    foreach ($res_patterns as $p) if(strtolower($v)===strtolower($p)) return 'R';

    return null;
}

/** Auto-detect delimiter */
function detect_delimiter($text) {
    $lines = preg_split("/\r\n|\n|\r/", $text);
    $candidates = [",","\t",";","|"];
    $best = ",";
    $bestScore = 0;
    foreach ($candidates as $d) {
        $score = 0;
        foreach (array_slice($lines,0,5) as $l) $score += substr_count($l,$d);
        if ($score > $bestScore) { $bestScore=$score; $best=$d; }
    }
    return $best;
}

/** Parse table text */
function parse_table_text($text) {
    $del = detect_delimiter($text);
    $lines = preg_split("/\r\n|\n|\r/", trim($text));
    $data=[]; $header=null;
    foreach ($lines as $i=>$line) {
        $cells = str_getcsv($line,$del);
        if ($i===0){ $header=array_map('trim',$cells); continue; }
        if(count($cells)<count($header)) $cells=array_pad($cells,count($header),'');
        elseif(count($cells)>count($header)) $cells=array_slice($cells,0,count($header));
        $data[]=array_combine($header,$cells);
    }
    return [$header,$data];
}

/** Parse Excel file */
function parse_excel_file($file_path) {
    try {
        $spreadsheet = IOFactory::load($file_path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
        
        if (empty($rows)) {
            return [[], []];
        }
        
        $header = array_map('trim', array_shift($rows));
        $data = [];
        
        foreach ($rows as $row) {
            if (count($row) < count($header)) {
                $row = array_pad($row, count($header), '');
            } elseif (count($row) > count($header)) {
                $row = array_slice($row, 0, count($header));
            }
            $data[] = array_combine($header, $row);
        }
        
        return [$header, $data];
    } catch (Exception $e) {
        return [[], []];
    }
}

/** Save report to database */
function save_report_to_db($conn, $user_id, $original_filename, $file_path, $pasted_data, $summary, $organism_list, $antibiotics) {
    // Insert report metadata
    $stmt = $conn->prepare("INSERT INTO antibiogram_reports (admin_id, original_filename, file_path, pasted_data) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $original_filename, $file_path, $pasted_data);
    $stmt->execute();
    $report_id = $stmt->insert_id;
    $stmt->close();
    
    // Insert summary data
    $stmt = $conn->prepare("INSERT INTO antibiogram_data (report_id, organism, antibiotic, tested_count, susceptible_count, percentage) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($organism_list as $org) {
        foreach ($antibiotics as $ab) {
            $data = $summary[$org][$ab];
            $tested = $data['tested'];
            $susc = $data['susc'];
            $pct = $data['pct'];
            
            $stmt->bind_param("issiid", $report_id, $org, $ab, $tested, $susc, $pct);
            $stmt->execute();
        }
    }
    
    $stmt->close();
    return $report_id;
}

/** Get user's report history */
function get_report_history($conn, $user_id) {
    $stmt = $conn->prepare("SELECT id, original_filename, file_path, upload_date FROM antibiogram_reports WHERE admin_id = ? ORDER BY upload_date DESC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reports = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    return $reports;
}

/** Get report data */
function get_report_data($conn, $report_id, $user_id) {
    // Verify user owns this report
    $stmt = $conn->prepare("SELECT id FROM antibiogram_reports WHERE id = ? AND admin_id = ?");
    $stmt->bind_param("ii", $report_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        return null;
    }
    
    // Get report metadata
    $stmt = $conn->prepare("
        SELECT r.original_filename, r.file_path, r.pasted_data, r.upload_date, 
               a.name as admin_name 
        FROM antibiogram_reports r 
        JOIN admins a ON r.admin_id = a.id 
        WHERE r.id = ?
    ");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report_meta = $result->fetch_assoc();
    $stmt->close();
    
    // Get report data
    $stmt = $conn->prepare("
        SELECT organism, antibiotic, tested_count, susceptible_count, percentage 
        FROM antibiogram_data 
        WHERE report_id = ? 
        ORDER BY organism, antibiotic
    ");
    $stmt->bind_param("i", $report_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $report_data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    
    // Organize data by organism
    $organized_data = [];
    $antibiotics = [];
    
    foreach ($report_data as $row) {
        $org = $row['organism'];
        $ab = $row['antibiotic'];
        
        if (!in_array($ab, $antibiotics)) {
            $antibiotics[] = $ab;
        }
        
        if (!isset($organized_data[$org])) {
            $organized_data[$org] = [];
        }
        
        $organized_data[$org][$ab] = [
            'tested' => $row['tested_count'],
            'susc' => $row['susceptible_count'],
            'pct' => $row['percentage']
        ];
    }
    
    $organism_list = array_keys($organized_data);
    sort($organism_list);
    
    return [
        'meta' => $report_meta,
        'data' => $organized_data,
        'organisms' => $organism_list,
        'antibiotics' => $antibiotics
    ];
}

/** Handle POST input */
$input_text='';
$upload_error = '';
$report_id = null;

// Check if viewing a saved report
$view_report_id = isset($_GET['view_report']) ? intval($_GET['view_report']) : null;
$saved_report = null;

if ($view_report_id) {
    $saved_report = get_report_data($conn, $view_report_id, $user_id);
}

if($_SERVER['REQUEST_METHOD']==='POST' && !isset($_POST['download_csv'])){
    if(!empty($_FILES['datafile']['tmp_name'])) {
        $file = $_FILES['datafile'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $original_filename = $file['name'];
        
        // Handle Excel files
        if (in_array($file_ext, ['xlsx', 'xls'])) {
            list($header, $rows) = parse_excel_file($file['tmp_name']);
            
            if (!empty($header) && !empty($rows)) {
                // Convert the data to text format for compatibility with existing code
                $input_text = implode(",", $header) . "\n";
                foreach ($rows as $row) {
                    $input_text .= implode(",", $row) . "\n";
                }
                
                // Save the uploaded file
                $upload_dir = '../uploads/antibiogram/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                $file_path = $upload_dir . time() . '_' . $original_filename;
                move_uploaded_file($file['tmp_name'], $file_path);
            } else {
                $upload_error = "Failed to parse the Excel file. Please check the format.";
            }
        } 
        // Handle CSV/TSV files
        else if (in_array($file_ext, ['csv', 'tsv', 'txt'])) {
            $input_text = file_get_contents($file['tmp_name']);
            
            // Save the uploaded file
            $upload_dir = '../uploads/antibiogram/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $file_path = $upload_dir . time() . '_' . $original_filename;
            move_uploaded_file($file['tmp_name'], $file_path);
        } 
        // Unknown file type
        else {
            $upload_error = "Unsupported file format. Please upload CSV, TSV, or Excel files.";
        }
    }
    elseif(!empty($_POST['pasted'])) {
        $input_text=$_POST['pasted'];
        $pasted_data = $input_text;
        $original_filename = null;
        $file_path = null;
    }
}

$summary=[]; $antibiotics=[]; $organism_list=[]; $raw_rows=[];

if(!empty($input_text) && empty($upload_error)){
    list($header,$rows)=parse_table_text($input_text);
    $raw_rows=$rows;

    // find Organism column
    $organism_col=null;
    foreach($header as $h) if(preg_match('/organism/i',$h)){$organism_col=$h; break;}
    if($organism_col===null){ $organism_col=$header[ array_search('Organism',$header) ] ?? null; }

    // antibiotic columns (skip meta)
    $meta_patterns='/lab_no|pt_name|age|sex|date|admission|ward|bht|esbl|organism_type|organism id/i';
    foreach($header as $h){ if(preg_match($meta_patterns,$h)) continue; if(trim($h)==='') continue; $antibiotics[]=$h; }
    if(($k=array_search($organism_col,$antibiotics))!==false) array_splice($antibiotics,$k,1);

    // stats
    $stats=[];
    foreach($rows as $r){
        $org=trim($r[$organism_col]??'');
        if($org==='') continue;
        $org=preg_replace('/\s+/',' ',$org);
        $org_key=$org;
        if(!isset($stats[$org_key])){
            $stats[$org_key]=[];
            foreach($antibiotics as $ab) $stats[$org_key][$ab]=['tested'=>0,'susc'=>0];
        }
        foreach($antibiotics as $ab){
            $cell = $r[$ab] ?? '';
            // parse if S/I/R counts exist (e.g., S:5 I:0 /5)
            if(preg_match('/S:(\d+)/i',$cell,$m)){
                $susc=intval($m[1]);
                if(preg_match('/\/(\d+)/',$cell,$n)) $tested=intval($n[1]);
                else $tested=$susc;
                $stats[$org_key][$ab]['tested']+=$tested;
                $stats[$org_key][$ab]['susc']+=$susc;
            } else {
                $norm=normalize_result($cell);
                if($norm===null) continue;
                $stats[$org_key][$ab]['tested']++;
                if($norm==='S') $stats[$org_key][$ab]['susc']++;
            }
        }
    }

    // summary % with tested counts
    foreach($stats as $org=>$vals){
        foreach($vals as $ab=>$v){
            $tested=$v['tested']; $susc=$v['susc'];
            $pct=$tested>0?($susc/$tested*100):null;
            $summary[$org][$ab]=['tested'=>$tested,'susc'=>$susc,'pct'=>$pct];
        }
    }

    $organism_list=array_keys($summary);
    sort($organism_list);
    
    // Save to database
    $pasted_data = isset($pasted_data) ? $pasted_data : null;
    $report_id = save_report_to_db($conn, $user_id, $original_filename, $file_path, $pasted_data, $summary, $organism_list, $antibiotics);
}

// Get user's report history
$report_history = get_report_history($conn, $user_id);

// download CSV
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['download_csv']) && !empty($summary)){
    header('Content-Type:text/csv;charset=utf-8');
    header('Content-Disposition:attachment;filename=antibiogram_summary.csv');
    $out=fopen('php://output','w');
    fputcsv($out,array_merge(['Organism'],$antibiotics));
    foreach($organism_list as $org){
        $line=[$org];
        foreach($antibiotics as $ab){
            $s=$summary[$org][$ab];
            $line[]= $s['pct']===null?'':round($s['pct'],0).'%';
        }
        fputcsv($out,$line);
    }
    fclose($out); exit;
}

function pct_class($pct){
    if($pct===null) return '';
    if($pct<70) return 'bg-danger';
    if($pct<90) return 'bg-warning';
    return 'bg-success';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antibiogram Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <?php include_once("../includes/css-links-inc.php"); ?>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
        }
        
        .card-header {
            background-color: var(--primary);
            color: white;
            border-radius: 10px 10px 0 0 !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        
        .btn-success {
            background-color: #27ae60;
            border-color: #27ae60;
        }
        
        .table th {
            background-color: var(--primary);
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
            border-radius: 5px;
        }
        
        .percentage-cell {
            font-weight: 600;
            text-align: center;
            cursor: pointer;
        }
        
        .bg-success {
            background-color: rgba(39, 174, 96, 0.15) !important;
            color: #27ae60;
        }
        
        .bg-warning {
            background-color: rgba(241, 196, 15, 0.15) !important;
            color: #f39c12;
        }
        
        .bg-danger {
            background-color: rgba(231, 76, 60, 0.15) !important;
            color: #e74c3c;
        }
        
        .instructions {
            background-color: #f8f9fa;
            border-left: 4px solid var(--secondary);
            padding: 15px;
            font-size: 0.9rem;
        }
        
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
            background-color: #f8f9fa;
        }
        
        .upload-area:hover {
            border-color: var(--secondary);
            background-color: #e8f4ff;
        }
        
        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            background-color: white;
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        .tooltip-inner {
            background-color: var(--dark);
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 0.85rem;
        }
        
        .tab-pane {
            padding: 20px 0;
        }
        
        .nav-tabs .nav-link {
            color: var(--dark);
            font-weight: 500;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--secondary);
            font-weight: 600;
            border-bottom: 3px solid var(--secondary);
        }
        
        .history-table {
            font-size: 0.9rem;
        }
        
        .history-table tr:hover {
            background-color: #f5f5f5;
            cursor: pointer;
        }
        
        .saved-report-info {
            background-color: #e8f4ff;
            border-left: 4px solid var(--secondary);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        @media (max-width: 768px) {
            .table-container {
                max-height: 50vh;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/sadmin-sidebar.php") ?>
    <main id="main" class="main">
    <div class="pagetitle">
        <h1>Antibiogram Generator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Antibiogram Generator</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2">
                    <h5 class="card-title"><i class="bi bi-upload me-2"></i>Upload Data</h5>
                    
                    <div class="card-body">
                        <?php if (!empty($upload_error)): ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($upload_error); ?></div>
                        <?php endif; ?>
                        
                        <?php if ($saved_report): ?>
                        <div class="saved-report-info">
                            <h5>Viewing Saved Report</h5>
                            <p><strong>Uploaded on:</strong> <?php echo date('F j, Y, g:i a', strtotime($saved_report['meta']['upload_date'])); ?></p>
                            <?php if ($saved_report['meta']['original_filename']): ?>
                            <p><strong>File:</strong> <?php echo htmlspecialchars($saved_report['meta']['original_filename']); ?></p>
                            <?php endif; ?>
                            <p><strong>Generated by:</strong> <?php echo htmlspecialchars($saved_report['meta']['admin_name']); ?></p>
                            <a href="antibiogram.php" class="btn btn-sm btn-primary">Back to New Upload</a>
                        </div>
                        <?php endif; ?>
                        
                        <form method="post" enctype="multipart/form-data" id="uploadForm">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Upload CSV/TSV/Excel File</label>
                                <div class="upload-area">
                                    <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                                    <p class="text-muted">Drag & drop your file here or click to browse</p>
                                    <input class="form-control d-none" type="file" name="datafile" id="datafile" accept=".csv,.tsv,.txt,.xlsx,.xls">

                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('datafile').click()">
                                        <i class="bi bi-folder2-open me-2"></i>Browse Files
                                    </button>
                                    <div class="mt-2" id="fileName"></div>
                                    <small class="text-muted mt-2">Supported formats: CSV, TSV, XLSX, XLS</small>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Or Paste Data Directly</label>
                                <textarea class="form-control" name="pasted" rows="6" placeholder="Paste tabular data here..."><?php echo htmlspecialchars($input_text); ?></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="bi bi-gear-fill me-2"></i>Process Data
                                    </button>
                                    <?php if(!empty($summary) || $saved_report): ?>
                                    <button class="btn btn-success ms-2" type="submit" name="download_csv">
                                        <i class="bi bi-download me-2"></i>Export CSV
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if(!empty($summary) || $saved_report): 
                                    $display_organisms = $saved_report ? $saved_report['organisms'] : $organism_list;
                                    $display_antibiotics = $saved_report ? $saved_report['antibiotics'] : $antibiotics;
                                ?>
                                <div class="d-flex">
                                    <div class="stat-card me-3">
                                        <div class="stat-number"><?php echo count($display_organisms); ?></div>
                                        <div class="stat-label">Organisms</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-number"><?php echo count($display_antibiotics); ?></div>
                                        <div class="stat-label">Antibiotics</div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="instructions mb-4">
                    <h6><i class="bi bi-info-circle me-2"></i>Instructions</h6>
                    <p class="mb-1">- Upload a CSV/TSV/Excel file or paste tabular data with organism names and antibiotic susceptibility results</p>
                    <p class="mb-1">- The system will automatically detect the organism column and antibiotic columns</p>
                    <p class="mb-0">- Supported susceptibility formats: "Sensitive", "Resistant", "S", "R", "I", "Intermediate", or patterns like "S:5 I:0 R:2 /7"</p>
                </div>
                
                <?php if(!empty($summary) || $saved_report): 
                    $display_data = $saved_report ? $saved_report['data'] : $summary;
                    $display_organisms = $saved_report ? $saved_report['organisms'] : $organism_list;
                    $display_antibiotics = $saved_report ? $saved_report['antibiotics'] : $antibiotics;
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Antibiogram Summary</h5>
                        <?php if(!$saved_report && $report_id): ?>
                        <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Saved to history</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="percentage-tab" data-bs-toggle="tab" data-bs-target="#percentage" type="button" role="tab">Percentage View</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="counts-tab" data-bs-toggle="tab" data-bs-target="#counts" type="button" role="tab">Raw Counts</button>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="percentage" role="tabpanel">
                                <div class="table-container mt-3">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 200px; background-color: #2c3e50; color: white;">Organism</th>
                                                <?php foreach($display_antibiotics as $ab): ?>
                                                <th style="min-width: 100px; text-align: center;"><?php echo htmlspecialchars($ab); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($display_organisms as $org): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($org); ?></strong></td>
                                                <?php foreach($display_antibiotics as $ab):
                                                $cell = $display_data[$org][$ab]; 
                                                $pct = $cell['pct'];
                                                ?>
                                                <td class="percentage-cell <?php echo pct_class($pct); ?>" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Tested: <?php echo $cell['tested']; ?>, Susceptible: <?php echo $cell['susc']; ?>">
                                                    <?php echo $pct === null ? 'N/A' : round($pct) . '%'; ?>
                                                </td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="counts" role="tabpanel">
                                <div class="table-container mt-3">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 200px; background-color: #2c3e50; color: white;">Organism</th>
                                                <?php foreach($display_antibiotics as $ab): ?>
                                                <th style="min-width: 100px; text-align: center;"><?php echo htmlspecialchars($ab); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($display_organisms as $org): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($org); ?></strong></td>
                                                <?php foreach($display_antibiotics as $ab):
                                                $cell = $display_data[$org][$ab]; 
                                                ?>
                                                <td style="text-align: center;">
                                                    <?php echo $cell['tested'] . ' / ' . $cell['susc']; ?>
                                                </td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="d-flex">
                                <div class="me-3"><span class="badge bg-success p-2">≥90% Susceptible</span></div>
                                <div class="me-3"><span class="badge bg-warning p-2">70-89% Susceptible</span></div>
                                <div><span class="badge bg-danger p-2"><70% Susceptible</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- History Section -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Upload History</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($report_history)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover history-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Filename</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($report_history as $report): ?>
                                    <tr onclick="window.location='?view_report=<?php echo $report['id']; ?>'" style="cursor: pointer;">
                                        <td><?php echo date('M j, Y g:i A', strtotime($report['upload_date'])); ?></td>
                                        <td>
                                            <?php if ($report['original_filename']): ?>
                                            <?php echo htmlspecialchars($report['original_filename']); ?>
                                            <?php else: ?>
                                            <em>Pasted Data</em>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($report['file_path']): ?>
                                                <?php 
                                                $ext = pathinfo($report['original_filename'], PATHINFO_EXTENSION);
                                                echo strtoupper($ext);
                                                ?>
                                            <?php else: ?>
                                                Text
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="?view_report=<?php echo $report['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-3">No history yet. Process some data to see it here.</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // File input display
        document.getElementById('datafile').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.getElementById('fileName').innerHTML = '<div class="alert alert-info mt-3 py-2"><i class="bi bi-file-earmark-text me-2"></i>' + fileName + '</div>';
        });
        
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Drag and drop functionality
        var uploadArea = document.querySelector('.upload-area');
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-primary');
        });
        
        uploadArea.addEventListener('dragleave', function() {
            this.classList.remove('border-primary');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-primary');
            
            var files = e.dataTransfer.files;
            if (files.length) {
                document.getElementById('datafile').files = files;
                document.getElementById('fileName').innerHTML = '<div class="alert alert-info mt-3 py-2"><i class="bi bi-file-earmark-text me-2"></i>' + files[0].name + '</div>';
            }
        });
    </script>
    <?php include_once("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <?php include_once("../includes/js-links-inc.php") ?>

</body>
</html>