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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Add Admin - MediQ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once ("../includes/css-links-inc.php"); ?>
    
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
            padding: 2rem;
        }
        
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.2s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
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
        
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #e2e8f0;
            border-radius: 8px 0 0 8px;
        }
        
        .input-group .form-control {
            border-radius: 0 8px 8px 0;
        }
        
        /* Alert styling */
        .alert {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 1.5rem;
        }
        
        .alert-success {
            background: linear-gradient(45deg, #2ecc71, #27ae60);
            color: white;
        }
        
        .alert-danger {
            background: linear-gradient(45deg, #e74c3c, #c0392b);
            color: white;
        }
        
        .password-toggle {
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .password-toggle:hover {
            color: var(--primary);
        }
        
        /* Modal styling */
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            border-bottom: 1px solid #e2e8f0;
            padding: 1.5rem;
        }
        
        .modal-body, .modal-footer {
            padding: 1.5rem;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }
            
            .col-form-label {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>

    <?php include_once ("../includes/header.php") ?>
    <?php include_once ("../includes/sadmin-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1 class="page-title">Add Admin</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="manage-super-admins.php">Admin Management</a></li>
                    <li class="breadcrumb-item active">Add Admin</li>
                </ol>
            </nav>
        </div>

        <!-- Alert Messages -->
        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-<?php echo ($_SESSION['status'] == 'success') ? 'success' : 'danger'; ?> alert-dismissible fade show m-3" role="alert">
                <i class="bi <?php echo ($_SESSION['status'] == 'success') ? 'bi-check-circle' : 'bi-exclamation-octagon'; ?> me-2"></i>
                <?php echo $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <?php
            // Clear session variables after showing the message
            unset($_SESSION['status']);
            unset($_SESSION['message']);
            ?>
        <?php endif; ?>

        <section class="section">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Create New Admin Account</h5>
                            <p class="text-muted">Fill in the details below to create a new admin account</p>

                            <form action="admin-register-process2.php" method="POST" class="needs-validation" novalidate>
                                <div class="row mb-3">
                                    <label for="nicNumber" class="col-lg-3 col-md-4 col-form-label">NIC Number</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" id="nicNumber" name="nic" placeholder="Enter NIC number" oninput="this.value = this.value.toUpperCase(); validateNic(this);" required>
                                        <div class="invalid-feedback" id="nicErrorMessage">
                                            Please enter a valid NIC number
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-lg-3 col-md-4 col-form-label">Full Name</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name" required>
                                        <div class="invalid-feedback">
                                            Please enter the admin's name
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-lg-3 col-md-4 col-form-label">Email</label>
                                    <div class="col-lg-9 col-md-8">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid email address
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="mobileNumber" class="col-lg-3 col-md-4 col-form-label">Mobile Number</label>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text">+94</span>
                                            <input type="tel" class="form-control" id="mobileNumber" name="mobile" placeholder="712345678" oninput="validateMobile(this)" required>
                                            <div class="invalid-feedback" id="numberErrorMessage">
                                                Please enter a valid mobile number
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 
                                <div class="row mb-4">
                                    <label for="password" class="col-lg-3 col-md-4 col-form-label">Password</label>
                                    <div class="col-lg-9 col-md-8">
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                            <span class="input-group-text">
                                                <i class="bi bi-eye-slash password-toggle" onclick="togglePasswordVisibility('password')"></i>
                                            </span>
                                            <div class="invalid-feedback">
                                                Please enter a password
                                            </div>
                                        </div>
                                        <div class="form-text">Use a strong password with at least 8 characters</div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmSubmitModal">
                                        <i class="bi bi-person-plus me-1"></i> Create Account
                                    </button>
                                    <a href="manage-super-admins.php" class="btn btn-outline-secondary ms-2">
                                        <i class="bi bi-arrow-left me-1"></i> Back to Admins
                                    </a>
                                </div>

                                <!-- Confirmation Modal -->
                                <div class="modal fade" id="confirmSubmitModal" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Account Creation</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to create this admin account?</p>
                                                <div class="alert alert-info">
                                                    <i class="bi bi-info-circle me-2"></i>
                                                    The new admin will need to verify their email before accessing the system.
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary" name="create_account">
                                                    <i class="bi bi-check-circle me-1"></i> Confirm Creation
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once ("../includes/footer.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once ("../includes/js-links-inc.php") ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            forms.forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
            
            // Password visibility toggle
            window.togglePasswordVisibility = function(inputId) {
                const passwordInput = document.getElementById(inputId);
                const toggleIcon = passwordInput.parentNode.querySelector('.password-toggle');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                }
            };
            
            // NIC validation
            window.validateNic = function(input) {
                const nic = input.value;
                const errorElement = document.getElementById('nicErrorMessage');
                
                // Old NIC format: 9 digits + V or 12 digits
                const oldFormat = /^[0-9]{9}[Vv]$/;
                const newFormat = /^[0-9]{12}$/;
                
                if (nic && !oldFormat.test(nic) && !newFormat.test(nic)) {
                    input.setCustomValidity('Please enter a valid NIC number (e.g., 123456789V or 123456789012)');
                    errorElement.textContent = 'Please enter a valid NIC number (e.g., 123456789V or 123456789012)';
                } else {
                    input.setCustomValidity('');
                    errorElement.textContent = 'Please enter the NIC number';
                }
            };
            
            // Mobile number validation
            window.validateMobile = function(input) {
                const number = input.value;
                const errorElement = document.getElementById('numberErrorMessage');
                
                // Sri Lankan mobile numbers: 7 followed by 8 digits
                const mobilePattern = /^[0-9]{9}$/;
                
                if (number && !mobilePattern.test(number)) {
                    input.setCustomValidity('Please enter a valid 9-digit mobile number (e.g., 712345678)');
                    errorElement.textContent = 'Please enter a valid 9-digit mobile number (e.g., 712345678)';
                } else {
                    input.setCustomValidity('');
                    errorElement.textContent = 'Please enter the mobile number';
                }
            };
            
            // Auto-dismiss alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>

</body>

</html>