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
    <title>Antibiogram Generator | Lab Information System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php include_once("../includes/css-links-inc.php"); ?>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            color: #495057;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: none;
            transition: var(--transition);
        }
        
        .card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }
        
        .btn-success {
            background-color: #2ecc71;
            border-color: #2ecc71;
            border-radius: 8px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            transform: translateY(-2px);
        }
        
        .table th {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
            font-weight: 500;
            padding: 0.75rem;
        }
        
        .table td {
            padding: 0.75rem;
            vertical-align: middle;
        }
        
        .table-container {
            max-height: 70vh;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .percentage-cell {
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            border-radius: 4px;
            transition: var(--transition);
        }
        
        .percentage-cell:hover {
            transform: scale(1.05);
        }
        
        .bg-success {
            background-color: rgba(46, 204, 113, 0.15) !important;
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
            background-color: #e8f4fc;
            border-left: 4px solid var(--info);
            padding: 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }
        
        .upload-area {
            border: 2px dashed #ced4da;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
            background-color: #f8f9fa;
            cursor: pointer;
        }
        
        .upload-area:hover, .upload-area.dragover {
            border-color: var(--primary);
            background-color: #e8f4ff;
            transform: translateY(-3px);
        }
        
        .stat-card {
            text-align: center;
            padding: 1rem;
            border-radius: 12px;
            background: linear-gradient(120deg, #f8f9fa, #e9ecef);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #6c757d;
            font-weight: 500;
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            padding: 0.75rem 1.25rem;
            border-radius: 8px 8px 0 0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary);
            font-weight: 600;
            border-bottom: 3px solid var(--primary);
            background-color: transparent;
        }
        
        .history-table {
            font-size: 0.9rem;
        }
        
        .history-table tr {
            transition: var(--transition);
        }
        
        .history-table tr:hover {
            background-color: #f1f5f9;
            transform: translateX(4px);
        }
        
        .saved-report-info {
            background-color: #e8f4ff;
            border-left: 4px solid var(--info);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
        }
        
        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .breadcrumb-item a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        .section-title {
            position: relative;
            padding-left: 1rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .section-title:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 24px;
            width: 4px;
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            border-radius: 4px;
        }
        
        @media (max-width: 768px) {
            .table-container {
                max-height: 50vh;
            }
            
            .stat-number {
                font-size: 1.5rem;
            }
            
            .upload-area {
                padding: 1.5rem;
            }
        }
        
        .badge {
            font-weight: 500;
            padding: 0.5em 0.8em;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem 1.25rem;
        }
        
        .feature-icon {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
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
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon">
                                    <i class="bi bi-upload"></i>
                                </div>
                                <h5 class="card-title mb-0">Upload Data</h5>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <?php if (!empty($upload_error)): ?>
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?php echo htmlspecialchars($upload_error); ?></div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($saved_report): ?>
                            <div class="saved-report-info">
                                <h5 class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-text me-2"></i>Viewing Saved Report
                                </h5>
                                <p class="mb-1"><strong>Uploaded on:</strong> <?php echo date('F j, Y, g:i a', strtotime($saved_report['meta']['upload_date'])); ?></p>
                                <?php if ($saved_report['meta']['original_filename']): ?>
                                <p class="mb-1"><strong>File:</strong> <?php echo htmlspecialchars($saved_report['meta']['original_filename']); ?></p>
                                <?php endif; ?>
                                <p class="mb-2"><strong>Generated by:</strong> <?php echo htmlspecialchars($saved_report['meta']['admin_name']); ?></p>
                                <a href="antibiogram.php" class="btn btn-sm btn-primary">
                                    <i class="bi bi-arrow-left me-1"></i>Back to New Upload
                                </a>
                            </div>
                            <?php endif; ?>
                            
                            <form method="post" enctype="multipart/form-data" id="uploadForm">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Upload CSV/TSV/Excel File</label>
                                    <div class="upload-area" id="dropZone">
                                        <i class="bi bi-cloud-upload display-4 text-primary mb-3"></i>
                                        <p class="text-muted">Drag & drop your file here or click to browse</p>
                                        <input class="form-control d-none" type="file" name="datafile" id="datafile" accept=".csv,.tsv,.txt,.xlsx,.xls">

                                        <button type="button" class="btn btn-outline-primary rounded-pill" onclick="document.getElementById('datafile').click()">
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
                                        <button class="btn btn-primary rounded-pill" type="submit">
                                            <i class="bi bi-gear-fill me-2"></i>Process Data
                                        </button>
                                        <?php if(!empty($summary) || $saved_report): ?>
                                        <button class="btn btn-success rounded-pill ms-2" type="submit" name="download_csv">
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
                    
                    <div class="instructions">
                        <h6 class="d-flex align-items-center mb-3">
                            <i class="bi bi-info-circle me-2"></i>Instructions
                        </h6>
                        <ul class="mb-0 ps-3">
                            <li>Upload a CSV/TSV/Excel file or paste tabular data with organism names and antibiotic susceptibility results</li>
                            <li>The system will automatically detect the organism column and antibiotic columns</li>
                            <li>Supported susceptibility formats: "Sensitive", "Resistant", "S", "R", "I", "Intermediate", or patterns like "S:5 I:0 R:2 /7"</li>
                        </ul>
                    </div>
                    
                    <?php if(!empty($summary) || $saved_report): 
                        $display_data = $saved_report ? $saved_report['data'] : $summary;
                        $display_organisms = $saved_report ? $saved_report['organisms'] : $organism_list;
                        $display_antibiotics = $saved_report ? $saved_report['antibiotics'] : $antibiotics;
                    ?>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon">
                                    <i class="bi bi-table"></i>
                                </div>
                                <h5 class="card-title mb-0">Antibiogram Summary</h5>
                            </div>
                            <?php if(!$saved_report && $report_id): ?>
                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Saved to history</span>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="percentage-tab" data-bs-toggle="tab" data-bs-target="#percentage" type="button" role="tab">
                                        <i class="bi bi-percent me-1"></i>Percentage View
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="counts-tab" data-bs-toggle="tab" data-bs-target="#counts" type="button" role="tab">
                                        <i class="bi bi-list-ol me-1"></i>Raw Counts
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="percentage" role="tabpanel">
                                    <div class="table-container mt-3">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 200px;">Organism</th>
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
                                                    <th style="min-width: 200px;">Organism</th>
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
                                <h6 class="mb-2">Susceptibility Interpretation:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>≥90% Susceptible</span>
                                    <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle me-1"></i>70-89% Susceptible</span>
                                    <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i><70% Susceptible</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- History Section -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h5 class="card-title mb-0">Upload History</h5>
                            </div>
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
                                        <tr onclick="window.location='?view_report=<?php echo $report['id']; ?>'">
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
    </main>

    <script>
        // File input display
        document.getElementById('datafile').addEventListener('change', function(e) {
            var fileName = e.target.files[0].name;
            document.getElementById('fileName').innerHTML = '<div class="alert alert-info mt-3 py-2 d-flex align-items-center"><i class="bi bi-file-earmark-text me-2"></i>' + fileName + '</div>';
        });
        
        // Enable tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Drag and drop functionality
        var dropZone = document.getElementById('dropZone');
        var fileInput = document.getElementById('datafile');
        
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
        });
        
        dropZone.addEventListener('dragleave', function() {
            this.classList.remove('dragover');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
            
            var files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files;
                document.getElementById('fileName').innerHTML = '<div class="alert alert-info mt-3 py-2 d-flex align-items-center"><i class="bi bi-file-earmark-text me-2"></i>' + files[0].name + '</div>';
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