<?php
require_once 'includes/db-conn.php';
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get token from URL
$token = $_GET['token'] ?? '';

if (empty($token)) {
    die("<div style='text-align:center; margin-top:50px;'>
            <h3>Invalid or missing token.</h3>
            <a href='forgot-password.php'>Go back</a>
        </div>");
}

// Check token validity
$stmt = $conn->prepare("SELECT email, expires_at FROM password_resets WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();
$reset = $result->fetch_assoc();
$stmt->close();

if (!$reset) {
    die("<div style='text-align:center; margin-top:50px;'>
            <h3>Invalid reset link.</h3>
            <a href='forgot-password.php'>Try again</a>
        </div>");
}

if (strtotime($reset['expires_at']) < time()) {
    die("<div style='text-align:center; margin-top:50px;'>
            <h3>Reset link expired.</h3>
            <a href='forgot-password.php'>Request a new link</a>
        </div>");
}

// Handle password reset form
if (isset($_POST['submit'])) {
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = "Passwords do not match.";
    } elseif (strlen($new_password) < 6) {
        $_SESSION['error_message'] = "Password must be at least 6 characters.";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $email = $reset['email'];

        // Try updating both tables
        $tables = ['admins', 'users'];
        $updated = false;

        foreach ($tables as $table) {
            $stmt = $conn->prepare("UPDATE $table SET password = ? WHERE email = ?");
            $stmt->bind_param("ss", $hashed_password, $email);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $updated = true;
                $stmt->close();
                break;
            }
            $stmt->close();
        }

        if ($updated) {
            // Delete used token
            $stmt = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->close();

            $_SESSION['success_message'] = "Password reset successful! You can now log in.";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Something went wrong while resetting your password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reset Password - MediQ</title>
  <link rel="icon" href="assets/images/logos/favicon.png">
  <?php include_once("includes/css-links-inc.php"); ?>
</head>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
          <img src="assets/images/logos/mediq-logo.png" alt="" style="max-height:180px;">
        <div class="col-lg-4 col-md-6 card p-4">
          <h5 class="text-center mb-3">Reset Your Password</h5>

          <?php if (isset($_SESSION['success_message'])): ?>
              <div class="alert alert-success">
                  <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
              </div>
          <?php elseif (isset($_SESSION['error_message'])): ?>
              <div class="alert alert-danger">
                  <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
              </div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label>New Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Confirm New Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Reset Password</button>
          </form>
        </div>
          <?php include_once ("includes/footer3.php") ?>

    <?php include_once ("includes/js-links-inc.php") ?>
      </section>
       
    </div>
  </main>
</body>
</html>
