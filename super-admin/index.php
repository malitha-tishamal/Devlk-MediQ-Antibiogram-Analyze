<?php
session_start();

require_once '../includes/db-conn.php';

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

/** Handle POST input */
$input_text='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    if(!empty($_FILES['datafile']['tmp_name'])) $input_text=file_get_contents($_FILES['datafile']['tmp_name']);
    elseif(!empty($_POST['pasted'])) $input_text=$_POST['pasted'];
}

$summary=[]; $antibiotics=[]; $organism_list=[]; $raw_rows=[];

if(!empty($input_text)){
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
}

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
        <h1>Home</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card p-2">
                        <h5 class="card-title"><i class="bi bi-upload me-2"></i>Upload Data</h5>
                    
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data" id="uploadForm">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Upload CSV/TSV File</label>
                                <div class="upload-area">
                                    <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                                    <p class="text-muted">Drag & drop your file here or click to browse</p>
                                    <input class="form-control d-none" type="file" name="datafile" id="datafile" accept=".csv,.tsv,.txt">
                                    <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('datafile').click()">
                                        <i class="bi bi-folder2-open me-2"></i>Browse Files
                                    </button>
                                    <div class="mt-2" id="fileName"></div>
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
                                    <?php if(!empty($summary)): ?>
                                    <button class="btn btn-success ms-2" type="submit" name="download_csv">
                                        <i class="bi bi-download me-2"></i>Export CSV
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if(!empty($summary)): ?>
                                <div class="d-flex">
                                    <div class="stat-card me-3">
                                        <div class="stat-number"><?php echo count($organism_list); ?></div>
                                        <div class="stat-label">Organisms</div>
                                    </div>
                                    <div class="stat-card">
                                        <div class="stat-number"><?php echo count($antibiotics); ?></div>
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
                    <p class="mb-1">- Upload a CSV/TSV file or paste tabular data with organism names and antibiotic susceptibility results</p>
                    <p class="mb-1">- The system will automatically detect the organism column and antibiotic columns</p>
                    <p class="mb-0">- Supported susceptibility formats: "Sensitive", "Resistant", "S", "R", "I", "Intermediate", or patterns like "S:5 I:0 R:2 /7"</p>
                </div>
                
                <?php if(!empty($summary)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-table me-2"></i>Antibiogram Summary</h5>
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
                                                <?php foreach($antibiotics as $ab): ?>
                                                <th style="min-width: 100px; text-align: center;"><?php echo htmlspecialchars($ab); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($organism_list as $org): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($org); ?></strong></td>
                                                <?php foreach($antibiotics as $ab):
                                                $cell = $summary[$org][$ab]; 
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
                                                <?php foreach($antibiotics as $ab): ?>
                                                <th style="min-width: 100px; text-align: center;"><?php echo htmlspecialchars($ab); ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($organism_list as $org): ?>
                                            <tr>
                                                <td><strong><?php echo htmlspecialchars($org); ?></strong></td>
                                                <?php foreach($antibiotics as $ab):
                                                $cell = $summary[$org][$ab]; 
                                                ?>
                                                <td style="text-align: center;">
                                                    <?php echo $cell['tested'] . ' / ' . $cell['susc']; ?>
                                                </td>
                                                <?php endforeach; ?>
                                            </tr>
                                            <?php endforeach; ?>
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
            </div>
        </div>
    </div>

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
    <?php include_once("../includes/footer2.php") ?>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
</a>
<?php include_once("../includes/js-links-inc.php") ?>

</body>
</html>