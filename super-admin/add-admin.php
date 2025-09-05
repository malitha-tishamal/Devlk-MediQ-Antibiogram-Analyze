<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Fetch admin details
$user_id = $_SESSION['admin_id'];
$sql = "SELECT name, email, nic, mobile, profile_picture FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

// Fetch admins from the database
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Management - MediQ</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
    
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .card {
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: none;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }
        
        .card-body {
            padding: 1.5rem 2rem;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
            background-color: #f8f9fa;
            padding: 1rem 0.75rem;
        }
        
        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 10%;
            object-fit: cover;
            border: 2px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .btn-action {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.2s ease;
        }
        
        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .page-title {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb-item a:hover {
            color: var(--secondary);
        }
        
        .search-box {
            position: relative;
            max-width: 300px;
        }
        
        .search-box input {
            border-radius: 50px;
            padding-left: 2.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        .filter-select {
            border-radius: 50px;
            padding: 0.5rem 1.5rem 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            transition: all 0.3s;
        }
        
        .filter-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .table-container {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .table-hover tbody tr {
            transition: background-color 0.2s;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .stats-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 10px;
            background: white;
            box-shadow: var(--card-shadow);
            transition: transform 0.3s;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-card i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .stats-card h3 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .stats-card p {
            color: #6c757d;
            margin-bottom: 0;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }
            
            .btn-action {
                margin-bottom: 5px;
            }
            
            .table-responsive {
                overflow-x: auto;
            }
            
            .search-box {
                max-width: 100%;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body>

    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/sadmin-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="page-title">Admin Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item">Admin Management</li>
                    <li class="breadcrumb-item active">Manage Admins</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <i class="bi bi-people"></i>
                        <?php
                        $totalAdmins = $result->num_rows;
                        $result->data_seek(0); // Reset pointer to reuse result
                        ?>
                        <h3><?php echo $totalAdmins; ?></h3>
                        <p>Total Admins</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <i class="bi bi-check-circle"></i>
                        <?php
                        $activeCount = 0;
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()) {
                            if (strtolower($row['status']) === 'active' || strtolower($row['status']) === 'approved') {
                                $activeCount++;
                            }
                        }
                        $result->data_seek(0);
                        ?>
                        <h3><?php echo $activeCount; ?></h3>
                        <p>Active Admins</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <i class="bi bi-clock-history"></i>
                        <?php
                        $pendingCount = 0;
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()) {
                            if (strtolower($row['status']) === 'pending') {
                                $pendingCount++;
                            }
                        }
                        $result->data_seek(0);
                        ?>
                        <h3><?php echo $pendingCount; ?></h3>
                        <p>Pending Admins</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="stats-card">
                        <i class="bi bi-x-circle"></i>
                        <?php
                        $disabledCount = 0;
                        $result->data_seek(0);
                        while ($row = $result->fetch_assoc()) {
                            if (strtolower($row['status']) === 'disabled' || strtolower($row['status']) === 'rejected') {
                                $disabledCount++;
                            }
                        }
                        $result->data_seek(0);
                        ?>
                        <h3><?php echo $disabledCount; ?></h3>
                        <p>Disabled Admins</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="card-title mb-0">Admin Accounts</h5>
                                <div class="d-flex gap-2 flex-wrap">
                                    <div class="search-box">
                                        <i class="bi bi-search"></i>
                                        <input type="text" class="form-control" placeholder="Search admins..." id="searchInput">
                                    </div>
                                    <select class="filter-select" id="statusFilter">
                                        <option value="">All Status</option>
                                        <option value="active">Active</option>
                                        <option value="pending">Pending</option>
                                        <option value="disabled">Disabled</option>
                                    </select>
                                    <a href="add-admin.php" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i> Add New Admin
                                    </a>
                                </div>
                            </div>
                            <p class="text-muted">Manage admin accounts and their permissions</p>

                            <!-- Table with admin data -->
                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="adminsTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Admin</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">ID No</th>
                                                <th scope="col">Mobile</th>
                                                <th scope="col">Last Login</th>
                                                <th scope="col">Status</th>
                                                <th scope="col" class="text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    echo "<tr>";
                                                    echo "<td>
                                                            <div class='d-flex align-items-center'>
                                                                <img src='uploads/" . htmlspecialchars($row["profile_picture"]) . "' class='profile-img me-3'>
                                                                <div>
                                                                    <div class='fw-semibold'>" . htmlspecialchars($row['name']) . "</div>
                                                                </div>
                                                            </div>
                                                          </td>";
                                                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['nic']) . "</td>";
                                                    echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                                                    echo "<td>" . ($row['last_login'] ? date('M j, Y g:i A', strtotime($row['last_login'])) : 'Never') . "</td>";

                                                    // Status Column
                                                    echo "<td>";
                                                    $status = strtolower($row['status']);
                                                    if ($status === 'active' || $status === 'approved') {
                                                        echo "<span class='badge bg-success status-badge'>Active</span>";
                                                    } elseif ($status === 'disabled') {
                                                        echo "<span class='badge bg-danger status-badge'>Disabled</span>";
                                                    } elseif ($status === 'pending') {
                                                        echo "<span class='badge bg-warning status-badge'>Pending</span>";
                                                    } else {
                                                        echo "<span class='badge bg-secondary status-badge'>" . ucfirst($row['status']) . "</span>";
                                                    }
                                                    echo "</td>";

                                                    // Action Buttons
                                                    $approveDisabled = ($status === 'active' || $status === 'approved') ? "disabled" : "";
                                                    $disableDisabled = ($status === 'disabled') ? "disabled" : "";
                                                    $isCurrentUser = ($row['id'] == $_SESSION['admin_id']);
                                                    $isMainAdmin = ($row['id'] == 1); // Assuming ID 1 is the main admin

                                                    echo "<td class='text-center'>
                                                            <div class='d-flex justify-content-center'>
                                                                <button class='btn btn-success btn-sm btn-action approve-btn' data-id='" . $row['id'] . "' $approveDisabled data-bs-toggle='tooltip' title='Approve Admin' " . ($isCurrentUser || $isMainAdmin ? "disabled" : "") . ">
                                                                    <i class='bi bi-check-lg'></i>
                                                                </button>
                                                                <button class='btn btn-warning btn-sm btn-action disable-btn' data-id='" . $row['id'] . "' $disableDisabled data-bs-toggle='tooltip' title='Disable Admin' " . ($isCurrentUser || $isMainAdmin ? "disabled" : "") . ">
                                                                    <i class='bi bi-slash-circle'></i>
                                                                </button>
                                                                <button class='btn btn-danger btn-sm btn-action delete-btn' data-id='" . $row['id'] . "' data-bs-toggle='tooltip' title='Delete Admin' " . ($isCurrentUser || $isMainAdmin ? "disabled" : "") . ">
                                                                    <i class='bi bi-trash'></i>
                                                                </button>
                                                                <a href='edit-super-admin.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm btn-action' data-bs-toggle='tooltip' title='Edit Admin'>
                                                                    <i class='bi bi-pencil-square'></i>
                                                                </a>
                                                            </div>
                                                          </td>";
                                                    echo "</tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center py-4 text-muted'>No admins found.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- End Table with admin data -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once("../includes/js-links-inc.php") ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Search functionality
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const table = document.getElementById('adminsTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const statusValue = statusFilter.value.toLowerCase();
                
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let showRow = true;
                    
                    // Search text filter
                    if (searchText) {
                        let rowContainsText = false;
                        for (let j = 0; j < cells.length; j++) {
                            if (cells[j].textContent.toLowerCase().includes(searchText)) {
                                rowContainsText = true;
                                break;
                            }
                        }
                        showRow = rowContainsText;
                    }
                    
                    // Status filter
                    if (showRow && statusValue) {
                        const statusCell = cells[5]; // Status is in the 6th column (index 5)
                        const statusText = statusCell.textContent.toLowerCase();
                        showRow = statusText.includes(statusValue);
                    }
                    
                    rows[i].style.display = showRow ? '' : 'none';
                }
            }
            
            searchInput.addEventListener('keyup', filterTable);
            statusFilter.addEventListener('change', filterTable);
            
            // Action buttons functionality
            document.querySelectorAll('.approve-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const adminId = this.getAttribute('data-id');
                    if (!this.disabled) {
                        if (confirm("Are you sure you want to approve this admin?")) {
                            window.location.href = `process-action-superadmin.php?approve_id=${adminId}`;
                        }
                    }
                });
            });
            
            document.querySelectorAll('.disable-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const adminId = this.getAttribute('data-id');
                    if (!this.disabled) {
                        if (confirm("Are you sure you want to disable this admin?")) {
                            window.location.href = `process-action-superadmin.php?disable_id=${adminId}`;
                        }
                    }
                });
            });
            
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const adminId = this.getAttribute('data-id');
                    if (!this.disabled) {
                        if (confirm("Are you sure you want to delete this admin? This action cannot be undone.")) {
                            window.location.href = `process-action-superadmin.php?delete_id=${adminId}`;
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>

<?php
// Close database connection
$conn->close();
?>