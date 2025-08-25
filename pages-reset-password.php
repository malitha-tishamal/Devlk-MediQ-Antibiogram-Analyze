<?php
session_start();
require_once("includes/db-conn.php"); // Database connection

$token = $_GET['token'] ?? '';

// Verify token
if (!empty($token)) {
    $query = "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        $_SESSION['message'] = "Invalid or expired token.";
        $_SESSION['status'] = 'danger';
        header("Location: pages-forgotten-password.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Get email from token
    $query = "SELECT email FROM password_resets WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $resetRequest = $result->fetch_assoc();
    $email = $resetRequest['email'];
    
    // Update password in both tables (admin and user)
    $query = "UPDATE admins SET password = ? WHERE email = ?;
              UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $password, $email, $password, $email);
    $stmt->execute();
    
    // Delete the token
    $query = "DELETE FROM password_resets WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $_SESSION['message'] = "Password updated successfully. You can now login with your new password.";
    $_SESSION['status'] = 'success';
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Reset Password - MediQ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once("includes/css-links-inc.php"); ?>
</head>
<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            
                            <div class="d-flex justify-content-center py-4">
                                <a href="index.php" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/images/logos/mediq-logo.png" alt="" style="max-height:130px;">
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
                                    </div>

                                    <!-- Session Messages Display -->
                                    <?php if (isset($_SESSION['message'])): ?>
                                        <div class="alert alert-<?php echo ($_SESSION['status'] == 'success') ? 'success' : 'danger'; ?> text-center">
                                            <?php echo $_SESSION['message']; ?>
                                        </div>
                                        <?php unset($_SESSION['message']); unset($_SESSION['status']); ?>
                                    <?php endif; ?>

                                    <form action="pages-reset-password.php" method="POST" class="row g-3 needs-validation" novalidate>
                                        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                                        
                                        <div class="col-12">
                                            <label for="password" class="form-label">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                            <div class="invalid-feedback">Please enter a new password!</div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                            <div class="invalid-feedback">Please confirm your password!</div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <input type="submit" class="btn btn-primary w-100" value="Reset Password">
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <?php include_once("includes/footer3.php"); ?>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main> 

    <?php include_once("includes/js-links-inc.php"); ?>
    <script>
    // Client-side password validation
    (function () {
        'use strict'
        
        const form = document.querySelector('.needs-validation')
        const password = document.getElementById('password')
        const confirmPassword = document.getElementById('confirm_password')
        
        form.addEventListener('submit', function (event) {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity("Passwords don't match");
                confirmPassword.reportValidity();
                event.preventDefault()
                event.stopPropagation()
            } else {
                confirmPassword.setCustomValidity('')
            }
            
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            
            form.classList.add('was-validated')
        }, false)
    })()
    </script>
</body>
</html>