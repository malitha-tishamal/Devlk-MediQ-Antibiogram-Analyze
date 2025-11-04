<?php
session_start();

require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Generate CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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

// Handle form submissions
$message = '';
$message_type = '';

// Add new organism
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_organism'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }
    
    $group_name = trim($_POST['group_name']);
    $group_type = trim($_POST['group_type']);
    $organism_name = trim(strtoupper($_POST['organism_name'])); // Convert to uppercase
    
    // Validate inputs
    if (empty($group_name) || empty($group_type) || empty($organism_name)) {
        $message = 'All fields are required!';
        $message_type = 'error';
    } else {
        // Check if organism already exists
        $check_stmt = $conn->prepare("SELECT id FROM organism_groups WHERE group_type = ? AND organism_name = ?");
        $check_stmt->bind_param("ss", $group_type, $organism_name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $message = 'Organism already exists in this group!';
            $message_type = 'error';
        } else {
            // Insert new organism
            $insert_stmt = $conn->prepare("INSERT INTO organism_groups (group_name, group_type, organism_name) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $group_name, $group_type, $organism_name);
            
            if ($insert_stmt->execute()) {
                $message = 'Organism added successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error adding organism: ' . $conn->error;
                $message_type = 'error';
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}

// Edit organism
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_organism'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }
    
    $organism_id = intval($_POST['organism_id']);
    $group_name = trim($_POST['group_name']);
    $group_type = trim($_POST['group_type']);
    $organism_name = trim(strtoupper($_POST['organism_name'])); // Convert to uppercase
    
    // Validate inputs
    if (empty($group_name) || empty($group_type) || empty($organism_name)) {
        $message = 'All fields are required!';
        $message_type = 'error';
    } else {
        // Check if organism already exists (excluding current record)
        $check_stmt = $conn->prepare("SELECT id FROM organism_groups WHERE group_type = ? AND organism_name = ? AND id != ?");
        $check_stmt->bind_param("ssi", $group_type, $organism_name, $organism_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $message = 'Organism already exists in this group!';
            $message_type = 'error';
        } else {
            // Update organism
            $update_stmt = $conn->prepare("UPDATE organism_groups SET group_name = ?, group_type = ?, organism_name = ? WHERE id = ?");
            $update_stmt->bind_param("sssi", $group_name, $group_type, $organism_name, $organism_id);
            
            if ($update_stmt->execute()) {
                $message = 'Organism updated successfully!';
                $message_type = 'success';
            } else {
                $message = 'Error updating organism: ' . $conn->error;
                $message_type = 'error';
            }
            $update_stmt->close();
        }
        $check_stmt->close();
    }
}

// Delete organism
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_organism'])) {
    // Verify CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token validation failed");
    }
    
    $organism_id = intval($_POST['organism_id']);
    
    $delete_stmt = $conn->prepare("DELETE FROM organism_groups WHERE id = ?");
    $delete_stmt->bind_param("i", $organism_id);
    
    if ($delete_stmt->execute()) {
        $message = 'Organism deleted successfully!';
        $message_type = 'success';
    } else {
        $message = 'Error deleting organism: ' . $conn->error;
        $message_type = 'error';
    }
    $delete_stmt->close();
}

// Fetch all organism groups
$organism_groups = [];
$result = $conn->query("SELECT * FROM organism_groups ORDER BY group_type, organism_name");
if ($result) {
    $organism_groups = $result->fetch_all(MYSQLI_ASSOC);
}

// Get unique group types for dropdown
$group_types = [];
$type_result = $conn->query("SELECT DISTINCT group_type, group_name FROM organism_groups ORDER BY group_type");
if ($type_result) {
    $group_types = $type_result->fetch_all(MYSQLI_ASSOC);
}

// If editing, get the organism data
$edit_organism = null;
if (isset($_GET['edit'])) {
    $edit_id = intval($_GET['edit']);
    $stmt = $conn->prepare("SELECT * FROM organism_groups WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $edit_organism = $result->fetch_assoc();
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Organism Groups | Lab Information System</title>
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
        
        .btn-warning {
            background-color: #f39c12;
            border-color: #f39c12;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-warning:hover {
            background-color: #e67e22;
            border-color: #e67e22;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background-color: #e74c3c;
            border-color: #e74c3c;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
            transform: translateY(-2px);
        }
        
        .table th {
            background: linear-gradient(120deg, var(--primary), var(--secondary));
            color: white;
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
        
        .badge-gram-negative {
            background: linear-gradient(120deg, #48cae4, #0096c7);
            color: white;
        }
        
        .badge-gram-positive {
            background: linear-gradient(120deg, #9d4edd, #7b2cbf);
            color: white;
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
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/sadmin-sidebar.php") ?>
    
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Manage Organism Groups</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="antibiogram.php">Antibiogram</a></li>
                    <li class="breadcrumb-item active">Organism Groups</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <i class="bi <?php echo $message_type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'; ?> me-2"></i>
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Add/Edit Form -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon">
                                    <i class="bi <?php echo $edit_organism ? 'bi-pencil' : 'bi-plus'; ?>"></i>
                                </div>
                                <h5 class="card-title mb-0">
                                    <?php echo $edit_organism ? 'Edit Organism' : 'Add New Organism'; ?>
                                </h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" id="organismForm">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                <?php if ($edit_organism): ?>
                                <input type="hidden" name="organism_id" value="<?php echo $edit_organism['id']; ?>">
                                <?php endif; ?>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Group Name</label>
                                            <input type="text" class="form-control" name="group_name" 
                                                   value="<?php echo $edit_organism ? htmlspecialchars($edit_organism['group_name']) : ''; ?>" 
                                                   required>
                                            <small class="text-muted">Display name for the group</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Group Type</label>
                                            <select class="form-select" name="group_type" required>
                                                <option value="">Select Group Type</option>
                                                <option value="gram_negative" <?php echo ($edit_organism && $edit_organism['group_type'] === 'gram_negative') ? 'selected' : ''; ?>>Gram Negative</option>
                                                <option value="gram_positive" <?php echo ($edit_organism && $edit_organism['group_type'] === 'gram_positive') ? 'selected' : ''; ?>>Gram Positive</option>
                                            </select>
                                            <small class="text-muted">Type of organism group</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Organism Name</label>
                                            <input type="text" class="form-control text-uppercase" name="organism_name" 
                                                   value="<?php echo $edit_organism ? htmlspecialchars($edit_organism['organism_name']) : ''; ?>" 
                                                   required>
                                            <small class="text-muted">Organism name in CAPITAL LETTERS</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <?php if ($edit_organism): ?>
                                        <button type="submit" name="edit_organism" class="btn btn-warning">
                                            <i class="bi bi-check-circle me-2"></i>Update Organism
                                        </button>
                                        <a href="pages-manage-organism.php" class="btn btn-secondary ms-2">
                                            <i class="bi bi-x-circle me-2"></i>Cancel
                                        </a>
                                        <?php else: ?>
                                        <button type="submit" name="add_organism" class="btn btn-primary">
                                            <i class="bi bi-plus-circle me-2"></i>Add Organism
                                        </button>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <?php if ($edit_organism): ?>
                                    <div>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="bi bi-trash me-2"></i>Delete Organism
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Organism Groups Table -->
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div class="feature-icon">
                                    <i class="bi bi-table"></i>
                                </div>
                                <h5 class="card-title mb-0">Organism Groups</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($organism_groups)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Group Name</th>
                                            <th>Group Type</th>
                                            <th>Organism Name</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($organism_groups as $organism): ?>
                                        <tr>
                                            <td><?php echo $organism['id']; ?></td>
                                            <td><?php echo htmlspecialchars($organism['group_name']); ?></td>
                                            <td>
                                                <span class="badge <?php echo $organism['group_type'] === 'gram_negative' ? 'badge-gram-negative' : 'badge-gram-positive'; ?>">
                                                    <?php echo $organism['group_type'] === 'gram_negative' ? 'Gram Negative' : 'Gram Positive'; ?>
                                                </span>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($organism['organism_name']); ?></strong></td>
                                            <td><?php echo date('M j, Y g:i A', strtotime($organism['created_at'])); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="?edit=<?php echo $organism['id']; ?>" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil me-1"></i>Edit
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-3">No organism groups found. Add some using the form above.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Delete Confirmation Modal -->
    <?php if ($edit_organism): ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the organism <strong>"<?php echo htmlspecialchars($edit_organism['organism_name']); ?>"</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="post" style="display: inline;">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input type="hidden" name="organism_id" value="<?php echo $edit_organism['id']; ?>">
                        <button type="submit" name="delete_organism" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
        // Auto-uppercase for organism name field
        document.querySelector('input[name="organism_name"]').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });
        
        // Show delete modal confirmation
        function confirmDelete(organismId, organismName) {
            if (confirm('Are you sure you want to delete the organism "' + organismName + '"?')) {
                document.getElementById('deleteForm-' + organismId).submit();
            }
        }
    </script>
    
    <?php include_once("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    <?php include_once("../includes/js-links-inc.php") ?>
</body>
</html>