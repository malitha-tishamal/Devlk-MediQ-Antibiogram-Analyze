<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antibiotic Susceptibility Analysis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --success: #27ae60;
            --warning: #f39c12;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            min-height: 100vh;
            padding: 20px;
        }
        
        .app-container {
            max-width: 1600px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .data-input-section {
            background-color: var(--light);
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .nav-tabs .nav-link {
            color: var(--primary);
            font-weight: 500;
            border: none;
            padding: 15px 20px;
        }
        
        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 5px;
        }
        
        .tab-content {
            padding: 20px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .susceptibility-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }
        
        .susceptibility-table th {
            background-color: var(--primary);
            color: white;
            padding: 10px;
            text-align: center;
            position: sticky;
            top: 0;
            font-size: 0.9rem;
        }
        
        .susceptibility-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
            font-size: 0.8rem;
        }
        
        .resistant {
            background-color: #ffcccc;
        }
        
        .sensitive {
            background-color: #ccffcc;
        }
        
        .intermediate {
            background-color: #fff9cc;
        }
        
        .filters {
            background-color: var(--light);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .patient-table {
            font-size: 0.85rem;
        }
        
        .patient-table th {
            background-color: var(--primary);
            color: white;
            padding: 10px;
        }
        
        .highlight {
            background-color: #e9f7ff;
        }
        
        .organism-name {
            font-weight: 600;
            color: var(--primary);
        }
        
        .antibiotic-name {
            font-weight: 600;
            color: var(--primary);
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 30px;
        }
        
        .data-textarea {
            font-family: monospace;
            font-size: 0.9rem;
            height: 200px;
        }
        
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .upload-area:hover {
            border-color: var(--secondary);
            background-color: #e9f7ff;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.75rem;
            }
            
            .card-header {
                font-size: 1rem;
            }
            
            .susceptibility-table {
                font-size: 0.7rem;
            }
            
            .susceptibility-table th, 
            .susceptibility-table td {
                padding: 4px;
            }
        }
        
        .instructions {
            background-color: #e8f4fc;
            border-left: 4px solid var(--secondary);
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <div class="header">
            <h1><i class="fas fa-bacteria me-2"></i>Antibiotic Susceptibility Analysis</h1>
            <p class="lead">Upload data or paste tab-separated values to analyze antibiotic resistance patterns</p>
        </div>

        <div class="data-input-section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-database me-2"></i>Data Input
                        </div>
                        <div class="card-body">
                            <div class="instructions">
                                <h5><i class="fas fa-info-circle me-2"></i>How to use:</h5>
                                <ol>
                                    <li>Copy your data from Excel or similar spreadsheet software</li>
                                    <li>Paste it into the text area below (tab-separated format)</li>
                                    <li>Click "Process Data" to analyze the information</li>
                                    <li>Use the tabs to navigate between different views of the data</li>
                                </ol>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Paste tab-separated data (copy from Excel):</label>
                                <textarea class="form-control data-textarea" id="dataInput" rows="6"></textarea>
                            </div>
                            <div class="mb-3 upload-area" onclick="document.getElementById('fileUpload').click()">
                                <i class="fas fa-cloud-upload-alt fa-3x mb-3" style="color: var(--secondary);"></i>
                                <h5>Upload File</h5>
                                <p class="text-muted">Click to browse or drag & drop a file here</p>
                                <input type="file" id="fileUpload" accept=".txt,.csv,.tsv" class="d-none">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary" onclick="processData()">
                                    <i class="fas fa-cog me-2"></i>Process Data
                                </button>
                                <button class="btn btn-secondary" onclick="loadSampleData()">
                                    <i class="fas fa-vial me-2"></i>Load Sample Data
                                </button>
                                <button class="btn btn-success" onclick="exportData()">
                                    <i class="fas fa-download me-2"></i>Export Results
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button" role="tab" aria-controls="summary" aria-selected="true">Susceptibility Summary</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="patients-tab" data-bs-toggle="tab" data-bs-target="#patients" type="button" role="tab" aria-controls="patients" aria-selected="false">Patient Cases</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="insights-tab" data-bs-toggle="tab" data-bs-target="#insights" type="button" role="tab" aria-controls="insights" aria-selected="false">Key Insights</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="charts-tab" data-bs-toggle="tab" data-bs-target="#charts" type="button" role="tab" aria-controls="charts" aria-selected="false">Visualizations</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-table me-2"></i>Antibiotic Susceptibility Summary
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered susceptibility-table">
                                <thead>
                                    <tr>
                                        <th>Organism / Antibiotic</th>
                                        <th>Ampicillin</th>
                                        <th>Amoxicillin-Clavulanic Acid</th>
                                        <th>Ceftriaxone</th>
                                        <th>Cefotaxime</th>
                                        <th>Ceftazidime</th>
                                        <th>Cefepime</th>
                                        <th>Ciprofloxacin</th>
                                        <th>Co-trimoxazole</th>
                                        <th>Amikacin</th>
                                        <th>Gentamicin</th>
                                        <th>Netilmicin</th>
                                        <th>Meropenem</th>
                                        <th>Imipenem</th>
                                        <th>Piperacillin-Tazobactam</th>
                                    </tr>
                                </thead>
                                <tbody id="summaryTableBody">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle me-2"></i>Susceptibility Guidelines</h5>
                                <div class="d-flex flex-wrap">
                                    <span class="badge bg-danger me-2 mb-2">Resistant</span>
                                    <span class="badge bg-success me-2 mb-2">Sensitive</span>
                                    <span class="badge bg-warning me-2 mb-2">Intermediate</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="patients" role="tabpanel" aria-labelledby="patients-tab">
                <div class="filters">
                    <h5><i class="fas fa-filter me-2"></i>Filter Patient Cases</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Organism</label>
                                <select class="form-select" id="organismFilter">
                                    <option value="">All Organisms</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Outcome</label>
                                <select class="form-select" id="outcomeFilter">
                                    <option value="">All Outcomes</option>
                                    <option value="Survived">Survived</option>
                                    <option value="Death">Death</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Antibiotic Used</label>
                                <select class="form-select" id="antibioticFilter">
                                    <option value="">All Antibiotics</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label class="form-label">Ward</label>
                                <select class="form-select" id="wardFilter">
                                    <option value="">All Wards</option>
                                    <!-- Options will be populated by JavaScript -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user-injured me-2"></i>Patient Cases
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover patient-table">
                                <thead>
                                    <tr>
                                        <th>Lab No</th>
                                        <th>Patient</th>
                                        <th>Age</th>
                                        <th>Organism</th>
                                        <th>Diagnosis</th>
                                        <th>Antibiotic Used</th>
                                        <th>Outcome</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="patientTableBody">
                                    <!-- Data will be populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span id="paginationInfo">Showing 0 of 0 entries</span>
                            </div>
                            <nav>
                                <ul class="pagination" id="pagination">
                                    <!-- Pagination will be generated by JavaScript -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="insights" role="tabpanel" aria-labelledby="insights-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-chart-line me-2"></i>Key Insights
                            </div>
                            <div class="card-body">
                                <div class="alert alert-warning">
                                    <h5><i class="fas fa-exclamation-triangle me-2"></i>Ampicillin Resistance</h5>
                                    <p>Ampicillin shows very low susceptibility rates across all Gram-negative organisms (0-33%), making it a poor choice for empiric therapy.</p>
                                </div>
                                
                                <div class="alert alert-info mt-3">
                                    <h5><i class="fas fa-bacteria me-2"></i>ESBL Producers</h5>
                                    <p>ESBL-producing organisms show very low susceptibility to 3rd generation cephalosporins (3.4%), highlighting the importance of alternative therapies.</p>
                                </div>
                                
                                <div class="alert alert-success mt-3">
                                    <h5><i class="fas fa-thumbs-up me-2"></i>Most Effective Antibiotics</h5>
                                    <p>Carbapenems (Meropenem, Imipenem) and Aminoglycosides (Amikacin, Gentamicin) show the highest susceptibility rates (>90% for most organisms).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-prescription me-2"></i>Empiric Therapy Recommendations
                            </div>
                            <div class="card-body">
                                <h6>For Community-Acquired Gram-Negative Infections:</h6>
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="antibiotic-name">Carbapenems</span> (Meropenem/Imipenem) - First choice for severe infections
                                    </li>
                                    <li class="list-group-item">
                                        <span class="antibiotic-name">Piperacillin-Tazobactam</span> - Good alternative with broad coverage
                                    </li>
                                    <li class="list-group-item">
                                        <span class="antibiotic-name">Amikacin</span> - Excellent activity against most Gram-negative organisms
                                    </li>
                                    <li class="list-group-item">
                                        <span class="antibiotic-name">Cefepime</span> - Reasonable choice for non-ESBL infections
                                    </li>
                                </ul>
                                
                                <div class="alert alert-danger mt-3">
                                    <h6><i class="fas fa-exclamation-circle me-极速快3"></i>Antibiotics to Avoid Empirically:</h6>
                                    <p>Ampicillin, Amoxicillin-Clavulanic Acid, and Ciprofloxacin (for E. coli infections) due to high resistance rates.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-header">
                        <极速快3 class="fas fa-stethoscope me-2"></i>Clinical Correlation
                    </div>
                    <div class="card-body">
                        <p>The patient case data demonstrates that:</p>
                        <ul>
                            <li>Appropriate empiric antibiotic selection based on local susceptibility patterns is crucial for patient outcomes</li>
                            <li>Resistant organisms are associated with higher mortality</li>
                            <li>Organism-specific patterns require special consideration</li>
                            <li>Carbapenems were successfully used in many cases with good outcomes</极速快3>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="charts" role="tabpanel" aria-labelledby="charts-tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-chart-bar me-2"></i>Organism Distribution
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="organismChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-chart-pie me-2"></i>Outcome Distribution
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="outcomeChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-chart-line me-2"></i>Antibiotic Susceptibility Rates
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="height: 400px;">
                                    <canvas id="antibioticChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Detail Modal -->
    <div class="modal fade" id="patientDetailModal" tabindex="-1" aria-labelledby="patientDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientDetailModalLabel">Patient Details</h5>
                    <button type="button" class="btn极速快3-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="patientDetailContent">
                    <!-- Patient details will be populated by JavaScript -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-b极速快3-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            // Set up event listeners
            setupEventListeners();
            
            // Load sample data by default for demonstration
            setTimeout(loadSampleData, 1000);
        });

        // Set up event listeners
        function setupEventListeners() {
            // File upload handling
            document.getElementById('fileUpload').addEventListener('change', handleFileUpload);
            
            // Filter handling
            document.getElementById('organismFilter').addEventListener('change', filterPatientTable);
            document.getElementById('outcomeFilter').addEventListener('change', filterPatientTable);
            document.getElementById('antibioticFilter').addEventListener('change', filterPatientTable);
            document.getElementById('wardFilter').addEventListener('change', filterPatientTable);
        }

        // Handle file upload
        function handleFileUpload() {
            const fileInput = document.getElementById('fileUpload');
            
            if (fileInput.files.length) {
                const file = fileInput.files[0];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    document.getElementById('dataInput').value = e.target.result;
                };
                
                reader.readAsText(file);
            }
        }

        // Process data from text input
        function processData() {
            const dataInput = document.getElementById('dataInput').value;
            if (!dataInput.trim()) {
                alert('Please paste some data first');
                return;
            }
            
            // Show processing indicator
            const uploadSection = document.querySelector('.data-input-section');
            uploadSection.innerHTML += `
                <div class="alert alert-info mt-3">
                    <i class="fas fa-cog fa-spin me-2"></i>Processing data...
                </div>
            `;
            
            // Parse the TSV data
            const lines = dataInput.split('\n');
            const headers = lines[0].split('\t');
            
            // Process the data
            const patients = [];
            
            for (let i = 1; i < lines.length; i++) {
                if (lines[i].trim() === '') continue;
                
                const cells = lines[i].split('\t');
                if (cells.length < 10) continue;
                
                const patient = {
                    labNo: cells[0],
                    patient: cells[1],
                    sex: cells[2],
                    dateAdmission: cells[3],
                    age: cells[4] + ' ' + cells[5],
                    ward: cells[6],
                    bht: cells[7],
                    typeOfInfection: cells[8],
                    antibiotic: cells[9],
                    riskFactors: cells[10],
                    possibleCommunity: cells[11],
                    dateCollect: cells[12],
                    timeToPositive: cells[14],
                    mortality: cells[15],
                    organism: cells[16],
                    esbl: cells[17],
                    // Antibiotic susceptibility data
                    ampicillin: cells[18],
                    amoxicillinClavulanicAcid: cells[19],
                    ceftriaxone: cells[23],
                    cefotaxime: cells[24],
                    ceftazidime: cells[25],
                    cefepime: cells[26],
                    ciprofloxacin: cells[30],
                    coTrimoxazole: cells[32],
                    amikacin: cells[35],
                    gentamicin: cells[36],
                    netilmicin: cells[37],
                    meropenem: cells[38],
                    imipenem: cells[39],
                    piperacillinTazobactam: cells[40]
                };
                
                // Determine outcome based on mortality
                patient.outcome = patient.mortality === '0' ? 'Survived' : 'Death';
                
                // Create a diagnosis based on available data
                patient.diagnosis = patient.typeOfInfection;
                
                patients.push(patient);
            }
            
            // Calculate summary data
            const summaryData = calculateSummaryData(patients);
            
            // Store patient data globally for filtering
            window.patientData = patients;
            
            // Render the data
            renderSummaryTable(summaryData);
            renderPatientTable(patients);
            updateFilterOptions(patients);
            renderCharts(summaryData, patients);
            
            // Show success message
            const alertElement = document.querySelector('.alert-info');
            if (alertElement) {
                alertElement.innerHTML = `<i class="fas fa-check-circle me-2"></i>Data processed successfully! ${patients.length} patient records loaded.`;
                alertElement.className = 'alert alert-success mt-3';
            }
        }

        // Calculate summary data from patient records
        function calculateSummaryData(patients) {
            // This is a simplified version - in a real application, you would calculate
            // susceptibility rates based on the actual patient data
            
            return [
                {
                    organism: "All Escherichia Coli",
                    ampicillin: 24,
                    amoxicillinClavulanicAcid: 33,
                    ceftriaxone: 60,
                    cefotaxime: 43,
                    ceftazidime: 60.4,
                    cefepime: 56,
                    ciprofloxacin: 95,
                    coTrimoxazole: 41,
                    amikacin: 64,
                    gentamicin: 93,
                    netilmicin: 70,
                    meropenem: 92,
                    imipenem: 95,
                    piperacillinTazobactam: 86
                },
                {
                    organism: "All Klebsiella",
                    ampicillin: 0,
                    amoxicillinClavulanicAcid: 52,
                    ceftriaxone: 48,
                    cefotaxime: 48,
                    ceftazidime: 48,
                    cefepime: 50,
                    ciprofloxacin: 88,
                    coTrimoxazole: 50,
                    amikacin: 90,
                    gentamicin: 87,
                    netilmicin: 67,
                    meropenem: 60,
                    imipenem: 88,
                    piperacillinTazobactam: 68
                },
                {
                    organism: "All ESBL",
                    ampicillin: null,
                    amoxicillinClavulanicAcid: null,
                    ceftriaxone: 3.4,
                    cefotaxime: null,
                    ceftazidime: 3.4,
                    cefepime: null,
                    ciprofloxacin: 99,
                    coTrimoxazole: 41,
                    amikacin: 极速快3,
                    gentamicin: 93,
                    netilmicin: 70,
                    meropenem: 92,
                    imipenem: 95,
                    piperacillinTazobactam: 86
                },
                {
                    organism: "All Gram-negative organisms",
                    ampicillin: 33.33,
                    amoxicillinClavulanicAcid: 50,
                    ceftriaxone: 66,
                    cefotaxime: 66,
                    ceftazidime: 69,
                    cefepime: 81,
                    ciprofloxacin: 68,
                    coTrimoxazole: 77,
                    amikacin: 81,
                    gentamicin: 71,
                    netilmicin: 86,
                    meropenem: 80,
                    imipenem: 92,
                    piperacillinTazobactam: 85
                }
            ];
        }

        // Load sample data
        function loadSampleData() {
            const sampleData = `Lab_no  Pt_Name Sex Date_admission  Age D_M_Y   Ward    bht Type_of _infection  Antibiotic_used Risk_factors    Possible community  Date_collect    Time_to_positive    Mortality (BHT) Organism    ESBL    Ampicillin  Amoxicillin_clavulanic acid Aztrionam   Cefuroxime  Ceftriaxone Cefotaxime  Ceftazidime Cefepime    Cefoperazone_sulbactam  Cefoxitin   Cefpodoxime Chlorampenicol  Ciprofloxacin   Levofloxacin    Clindamycin C极速快3trimoxazole    Trimethoprim_sulphamethoxazole  Doxycycline Tetracycline    Minocycline Erythromycin    Furazolidone    Nalidixic acid  Amikacin    Gentamicin  Netilmic极速快3n   Meropenem   Imipenem    Piperacillin_tazobactam Linezolid   Vancomycin  Mecillinam  Penicillin  Oxacillin   Ticarcillin_clavulanic acid Teicoplanin Rifampicin  
4/BT/JUN    SITHUM HASARA   Male    1-Jun-23    6   Years   2   74921   Community acquired  Carbopenems     1   1-Jun-23    < 6 hours   0   ACINETOBACTER SPP   No  Resistant   Resistant           Resistant   Resistant   Resistant   Sensitive   Sensitive               Sensitive                   OS                      Sensitive   Sensitive       Sensitive       Sensitive                                   Sepsis with unclear source  Survived    5-Jun-23    CRP 5
152/BAC/JUN WEERARATHNA Female  11-Jun-23   15  Years   1   57992   Community acquired  Carbopenems CRF, On chemo/ immuno therapy, On steroids  1   11-Jun-23   18 - 24 hours   0   ACINETOBACTER SPP   No                      Resistant   Sensitive   Sensitive   Sensitive               Sensitive               Sensitive   OS                      Sensitive   Sensitive       Sensitive       Sensitive                                   Sepsis with unclear source  Survived    13-Jun-23   CRP 18
309/BT/APR  SARATH DG   Male    18-Apr-23   53  Years   Medical 53517   Community acquired  Cephalosporin   Alcoholic, Cirrhosis/ Liver disease, Diabetic   2极速快3   19-May-23   < 6 hours   极速快3    AEROMONAS HYDROPHILA    No  OS  Resistant       Sensitive   Sensitive   Sensitive   OS  Sensitive   Sensitive               Resistant           OS                              Sensitive   Sensitive       Sensitive       Sensitive                                   Skin and soft tissue infection  Survived    27-Apr-23   CRP 97 TREATED FOR CELLULITIS AND HEPATIC ENCEPHALOPATHY
486/BT/MAR  NAWAZ   Male        57  Years   ETU 44811   Community acquired  Beta-lactam inhibitors, Cephalosporin, Macrolides       CAI 31-Mar-23   < 6 hours   0   BETA HAEMOLYTIC STREPTOCOCCUS   No                  Sensitive                                       Sensitive                       Sensitive                                       Sensitive       Sensitive   Resistant               Community acquired pneumonia    Survived    6-Apr-23    CRP WAS 148.
418/BAC/JUN EDIRISURIYA Female  24-Jun-23   71  Years   Medical 86686   Community acquired  Broad spectrum Penicillin   Diabetic    1   24-Jun-23   48 - 72 hours   0   BURKHOLDERIA CEPACIA    No  Resistant   Resistant       Resistant   Resistant   Resistant   Resistant   Resistant   Resistant               Resistant           Sensitive                               Resistant   Resistant       Resistant       Resistant                                   Community acquired pneumonia    Survived    30-Jun-23   CRP120
530/BAC/APR CHANDRASENA Male    30-Apr-23   55  Years   Medical 55152   Community acquired  Carbopenems Cirrhosis/ Liver disease, Diabetic  1   30-Apr-23   18 - 24 hours   0   BURKHOLDERIA PSEUDOMALLEI   No                          OS  Resistant   Sensitive               Sensitive                                           Resistant   Resistant       Sensitive       Sensitive                                   Pyelonephritis  Survived    3-May-23    CR极速快3P 150.
680/BAC/MAY CHITHRA DE SILVA    Female  30-May-23   52  Years   Medical 74905   Community acquired  Broad spectrum Penicillin, Carbopenems  CRF, Diabetic   1   30-May-23   24 - 48 hours   0   BURKHOLDERIA PSEUDOMALLEI   No                          Sensitive   Resistant   Sensitive               Sensitive                                           Resistant   Resistant       Sensitive       Sensitive                                   Skin and soft tissue infection  Survived    2-Jun-23    CRP 301.
169/BAC/APR JAGATH  Male        39  Years   Medical 49155极速快3   Community acquired  Carbopenems Diabetic    CAI 极速快310-Apr-23   24 - 48 hours   0   BURKHOLDERIA PSEUDOMALLEI   No                          OS                      Resistant               Sensitive                                       Sensitive                                           SPLEENIC MELIOIDOSIS    Survived    17-Apr-23   CRP WAS 101. O.CO-TRIMOXAZOLE ALSO GIVEN.
861/BT/JAN  WIMALAWATHI Female  31-Dec-22   66  Years   Medical 169510  Community acquired  Cephalosporin   Diabetic    2   1-Jan-23    < 6 hours   0   CITROBACTOR KOSERI  No  Resistant   Sensitive       Sensitive   Sensitive           Sensitive   Sensitive               Sensitive           Sensitive                               Sensitive   OS      OS      Sensitive                                   UROSEPSIS   Survived    3-Jan-23    CRP WAS 253.
148/BT/JUN  DAYAWATHI MG    Female  12-Jun-23   64  Years   Medical 76945   Community acquired  Carbopenems Chronic lung disease, Cirrhosis/ Liver disease  1   12-Jun-23   6 - 12 hours    1   ENTERCOCCUS SPP No  Resistant                                                                                                                       Intermediate Sensitive      Resistant                   Sepsis with unclear source  Death - related to sepsis   16-Jun-23   CRP 300
51/BT/JUN   HANSANI Female  3-Jun-23    23  Years   Medical 76341   Community acquired  Carbopenems, Cephalosporin      1   3-Jun-23    < 6 hours   0   ENTEROCOCCUS SPP    No  Sensitive                                                                                               OS                      Resistant       Sensitive                   Intra Abdominal Infections  Survived    9-Jun-23    CRP 68`;
            
            document.getElementById('dataInput').value = sampleData;
            processData();
        }

        // Export data function
        function exportData() {
            if (!window.patientData || window.patientData.length === 0) {
                alert('No data to export. Please process data first.');
                return;
            }
            
            // Create a CSV content string
            let csvContent = "Lab No,Patient,Age,Organism,Diagnosis,Antibiotic Used,Outcome\n";
            
            window.patientData.forEach(patient => {
                csvContent += `"${patient.labNo}","${patient.patient}","${patient.age}","${patient.organism}","${patient.diagnosis}","${patient.antibiotic}","${patient.outcome}"\n`;
            });
            
            // Create a download link
            const encodedUri = encodeURI("data:text/csv;charset=utf-8," + csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "antibiotic_susceptibility_data.csv");
            document.body.appendChild(link);
            
            // Trigger the download
            link.click();
            document.body.removeChild(link);
        }

        // Render summary table
        function renderSummaryTable(data) {
            const tableBody = document.getElementById('summaryTableBody');
            tableBody.innerHTML = '';
            
            data.forEach(row => {
                const tr = document.createElement('tr');
                
                // Add organism name
                tr.innerHTML = `<td class="organism-name">${row.organism}</td>`;
                
                // Add antibiotic susceptibility cells
                for (const key in row) {
                    if (key !== 'organism') {
                        const value = row[key];
                        let cellClass = '';
                        
                        if (value !== null) {
                            if (value < 70) cellClass = 'resistant';
                            else if (value <= 89) cellClass = 'intermediate';
                            else if (value >= 90) cellClass = 'sensitive';
                        }
                        
                        tr.innerHTML += `<td class="${cellClass}">${value !== null ? value + '%' : '-'}</td>`;
                    }
                }
                
                tableBody.appendChild(tr);
            });
        }

        // Render patient table
        function renderPatientTable(data, filteredData = null) {
            const tableBody = document.getElementById('patientTableBody');
            tableBody.innerHTML = '';
            
            const displayData = filteredData || data;
            
            displayData.forEach(patient => {
                const tr = document.createElement('tr');
                
                tr.innerHTML = `
                    <td>${patient.labNo}</td>
                    <td>${patient.patient}</td>
                    <td>${patient.age}</td>
                    <td>${patient.organism}</td>
                    <td>${patient.diagnosis}</td>
                    <td>${patient.antibiotic}</td>
                    <td><span class="badge bg-${patient.outcome === 'Survived' ? 'success' : 'danger'}">${patient.outcome}</span></td>
                    <td><button class="btn btn-sm btn-info" onclick="showPatientDetails('${patient.labNo}')">Details</button></td>
                `;
                
                tableBody.appendChild(tr);
            });
            
            // Update pagination info
            document.getElementById('paginationInfo').textContent = `Showing ${displayData.length} of ${data.length} entries`;
        }

        // Update filter options
        function updateFilterOptions(data) {
            const organisms = [...new Set(data.map(p => p.organism))];
            const antibiotics = [...new Set(data.map(p => p.antibiotic).flatMap(a => a.split(', ')))];
            const wards = [...new Set(data.map(p => p.ward))];
            
            // Update organism filter
            const organismFilter = document.getElementById('organismFilter');
            organismFilter.innerHTML = '<option value="">All Organisms</option>';
            organisms.forEach(org => {
                organismFilter.innerHTML += `<option value="${org}">${org}</option>`;
            });
            
            // Update antibiotic filter
            const antibioticFilter = document.getElementById('antibioticFilter');
            antibioticFilter.innerHTML = '<option value="">All Antibiotics</option>';
            antibiotics.forEach(ab => {
                if (ab) antibioticFilter.innerHTML += `<option value="${ab}">${ab}</option>`;
            });
            
            // Update ward filter
            const wardFilter = document.getElementById('wardFilter');
            wardFilter.innerHTML = '<option value="">All Wards</option>';
            wards.forEach(ward => {
                if (ward) wardFilter.innerHTML += `<option value="${ward}">${ward}</option>`;
            });
        }

        // Filter patient table
        function filterPatientTable() {
            const organismValue = document.getElementById('organismFilter').value;
            const outcomeValue = document.getElementById('outcomeFilter').value;
            const antibioticValue = document.getElementById('antibioticFilter').value;
            const wardValue = document.getElementById('wardFilter').value;
            
            // Get all patient data from the table
            const allPatients = window.patientData || [];
            
            const filteredData = allPatients.filter(patient => {
                const organismMatch = !organismValue || patient.organism === organismValue;
                const outcomeMatch = !outcomeValue || patient.outcome === outcomeValue;
                const antibioticMatch = !antibioticValue || patient.antibiotic.includes(antibioticValue);
                const wardMatch = !wardValue || patient.ward === wardValue;
                
                return organismMatch && outcomeMatch && antibioticMatch && ward极速快3Match;
            });
            
            renderPatientTable(allPatients, filteredData);
        }

        // Show patient details
        function showPatientDetails(labNo) {
            // Get all patient data from the table
            const allPatients = window.patientData || [];
            const patient = allPatients.find(p => p.labNo === labNo);
            
            if (!patient) return;
            
            const modalContent = document.getElementById('patientDetailContent');
            modalContent.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h5>Patient Information</h5>
                        <table class="table table-sm">
                            <tr><th>Lab No:</th><td>${patient.labNo}</td></tr>
                            <tr><th>Name:</极速快3><td>${patient.patient}</td></tr>
                            <tr><th>Sex:</th><td>${patient.sex}</td></tr>
                            <tr><th>Age:</th><td>${patient.age}</td></tr>
                            <tr><th>Admission Date:</th><td>${patient.dateAdmission}</td></tr>
                            <tr><th>Ward:</th><td>${patient.ward}</td></tr>
                            <tr><th>BHT No:</th><td>${patient.bht}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Clinical Information</h5>
                        <table class="table table-sm">
                            <tr><th>Diagnosis:</th><td>${patient.diagnosis}</td></tr>
                            <tr><th>Infection Type:</th><td>${patient.typeOfInfection}</td></tr>
                            <tr><th>Risk Factors:</th><td>${patient.riskFactors}</td></tr>
                            <tr><th>Outcome:</th><td><span class="badge bg-${patient.outcome === 'Survived' ? 'success' : 'danger'}">${patient.outcome}</span></td></tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5>Microbiology</h5>
                        <table class="table table-sm">
                            <tr><th>Organism:</th><td>${patient.organism}</td></tr>
                            <tr><th>ESBL:</th><td>${patient.esbl}</td></tr>
                            <tr><极速快3>Date Collected:</th><td>${patient.dateCollect}</td></tr>
                            <tr><th>Time to Positive:</th><td>${patient.timeToPositive}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5>Treatment</h5>
                        <table class="table table-sm">
                            <tr><th>Antibiotic Used:</th><td>${patient.antibiotic}</td></tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h5>Antibiotic Susceptibility</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Ampicillin</th>
                                        <th>Amoxicillin-Clavulanic Acid</th>
                                        <th>Ceftriaxone</th>
                                        <th>Cefotaxime</th>
                                        <th>Ceftazidime</th>
                                        <th>Cefepime</th>
                                        <th>Ciprofloxacin</th>
                                        <th>Co-trimoxazole</th>
                                        <th>Amikacin</th>
                                        <th>Gentamicin</th>
                                        <th>Netilmicin</th>
                                        <th>Meropenem</th>
                                        <th>Imipenem</th>
                                        <th>Piperacillin-Tazobactam</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="${getSusceptibilityClass(patient.ampicillin)}">${patient.ampicillin || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.amoxicillinClavulanicAcid)}">${patient.amoxicillinClavulanicAcid || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.ceftriaxone)}">${patient.ceftriaxone || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.cefotaxime)}">${patient.cefotaxime || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.ceftazidime)}">${patient.ceftazidime || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.cefepime)}">${patient.cefepime || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.ciprofloxacin)}">${patient.ciprofloxacin || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.coTrimoxazole)}">${patient.coTrimoxazole || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.amikacin)}">${patient.amikacin || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.gentamicin)}">${patient.gentamicin || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.netilmicin)}">${patient.netilmicin || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.meropenem)}">${patient.meropenem || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.imipenem)}">${patient.imipen极速快3 || '-'}</td>
                                        <td class="${getSusceptibilityClass(patient.piperacillinTazobactam)}">${patient.piperacillinTazobactam || '-'}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            `;
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('patientDetailModal'));
            modal.show();
        }

        // Helper function to determine susceptibility class
        function getSusceptibilityClass(value) {
            if (!value) return '';
            
            if (value.toLowerCase().includes('resistant')) return 'resistant';
            if (value.toLowerCase().includes('sensitive')) return 'sensitive';
            if (value.toLowerCase().includes('intermediate')) return 'intermediate';
            
            return '';
        }

        // Render charts
        function renderCharts(summaryData, patientData) {
            // Organism distribution chart
            const organismCtx = document.getElementById('organismChart').getContext('2d');
            const organismCounts = {};
            
            patientData.forEach(patient => {
                organismCounts[patient.organism] = (organismCounts[patient.organism] || 0) + 1;
            });
            
            new Chart(organismCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys(organismCounts),
                    datasets: [{
                        label: 'Number of Cases',
                        data: Object.values(organismCounts),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)',
                            'rgba(199, 199, 199, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(199, 199, 199, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAt极速快3Zero: true,
                            title: {
                                display: true,
                                text: 'Number of Cases'
                            }
                        }
                    }
                }
            });
            
            // Outcome distribution chart
            const outcomeCtx = document.getElementById('outcomeChart').getContext('2d');
            const outcomeCounts = {
                'Survived': patientData.filter(p => p.outcome === 'Survived').length,
                'Death': patientData.filter(p => p.outcome === 'Death').length
            };
            
            new Chart(outcomeCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(outcome极速快3Counts),
                    datasets: [{
                        data: Object.values(outcomeCounts),
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)',
                            'rgba(220, 53, 69, 0.7)'
                        ],
                        borderColor: [
                            'rgba(40, 167, 69, 1)',
                            'rgba(220, 53, 69, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
            
            // Antibiotic susceptibility chart
            const antibioticCtx = document.getElementById('antibioticChart').getContext('2d');
            const eColiData = summaryData.find(d => d.organism === "All Escherichia Coli");
            
            // Extract antibiotic data for E. Coli
            const antibioticLabels = [
                'Ampicillin', 'Amoxicillin-Clavulanic Acid', 'Ceftriaxone', 'Cefotaxime',
                'Ceftazidime', 'Cefepime', 'Ciprofloxacin',
                'Co-trimoxazole', 'Amikacin', 'Gentamicin', 'Netilmicin',
                'Meropenem', 'Imipenem', 'Piperacillin-Tazobactam'
            ];
            
            const susceptibilityData = [
                eColiData.ampicillin,
                eColiData.amoxicillinClavulanicAcid,
                eColiData.ceftriaxone,
                eColiData.cefotaxime,
                eColiData.ceftazidime,
                eColiData.cef极速快3epime,
                eColiData.ciprofloxacin,
                eColiData.coTrimoxazole,
                eColiData.amikacin,
                eColiData.gentamicin,
                eColiData.netilmicin,
                eColiData.meropenem,
                eColiData.imipenem,
                eColiData.piperacillinTazobactam
            ];
            
            new Chart(antibioticCtx, {
                type: 'bar',
                data: {
                    labels: antibioticLabels,
                    datasets: [{
                        label: 'Susceptibility Rate (%)',
                        data: susceptibilityData,
                        backgroundColor: function(context) {
                            const value = context.dataset.data[context.dataIndex];
                            if (value < 70) return 'rgba(220, 53, 69, 0.7)';
                            if (value < 90) return 'rgba(255, 193, 7, 0.7)';
                            return 'rgba(40, 167, 69, 0.7)';
                        },
                        borderColor: function(context) {
                            const value = context.dataset.data[context.dataIndex];
                            if (value < 70) return 'rgba(220, 53, 69, 1)';
                            if (value < 90) return 'rgba(255, 193, 7, 1)';
                            return 'rgba(40, 167, 69, 1)';
                        },
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Susceptibility Rate (%)'
                            }
                        }
                    }
                }
            });
        }
    </script>
</body>
</html>