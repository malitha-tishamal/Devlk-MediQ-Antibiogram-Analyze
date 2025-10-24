<?php
require_once 'includes/db-conn.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    // ✅ Check if email exists in any user-related table
    $tables = ['admins', 'users'];
    $emailExists = false;

    foreach ($tables as $table) {
        $stmt = $conn->prepare("SELECT email FROM $table WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $emailExists = true;
            $stmt->close();
            break;
        }
        $stmt->close();
    }

    if ($emailExists) {
        // ✅ Generate secure token and expiry time
        $token = bin2hex(random_bytes(32));
        $expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // ✅ Store token in password_resets table
        $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $token, $expires_at);
        $stmt->execute();
        $stmt->close();

        // ✅ Create reset link
        $reset_link = "https://mediq.42web.io/karapitiya/reset-password.php?token=" . $token;

        // ✅ You can enable mail() when hosting supports it
        // $subject = "Mediq Password Reset Link";
        // $message = "Hello,\n\nClick below to reset your password:\n$reset_link\n\nThis link expires in 1 hour.\n\n- Mediq Team";
        // $headers = "From: no-reply@mediq.42web.io";
        // mail($email, $subject, $message, $headers);

        // ✅ Show reset link directly on success (for testing)
        $_SESSION['success_message'] = "Your password reset link (valid for 1 hour):<br>
        <a href='$reset_link' target='_blank'>$reset_link</a>";
    } else {
        $_SESSION['error_message'] = "Email not found in the system.";
    }

    header("Location: forgot-password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password - Mediq</title>
  <link rel="icon" href="assets/images/logos/favicon.png">
  <?php include_once("includes/css-links-inc.php"); ?>
</head>
<body>
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <img src="assets/images/logos/mediq-logo.png" alt="Mediq Logo" style="max-height: 180px; margin-bottom: 20px;">
        
        <div class="col-lg-4 col-md-6 card p-4 shadow">
          <h5 class="text-center mb-3">Forgot Password</h5>

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
              <label for="email" class="form-label">Enter Your Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="example@email.com" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Send Reset Link</button>
          </form>
        </div>

        <?php include_once("includes/footer3.php"); ?>
      </section>
    </div>
  </main>

  <?php include_once("includes/js-links-inc.php"); ?>
</body>
</html>
