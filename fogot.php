<?php
session_start();
require_once("includes/db-conn.php"); // Database connection
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    
    // Check in both admin and user tables
    $query = "SELECT * FROM admins WHERE email = ? UNION SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        
        // Store token in database (you might need a password_resets table)
        $query = "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?) 
                 ON DUPLICATE KEY UPDATE token = ?, expires_at = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssss", $email, $token, $expires, $token, $expires);
        $stmt->execute();
        
        // Send email with reset link
        $resetLink = "https://mediq.42web.io/pages-reset-password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Hello {$user['name']},\n\n";
        $message .= "You requested a password reset. Click the link below to reset your password:\n";
        $message .= "$resetLink\n\n";
        $message .= "This link will expire in 1 hour.\n";
        $message .= "If you didn't request this, please ignore this email.\n";
        
        $headers = "From: no-reply@mediq.com";
        
        if (mail($email, $subject, $message, $headers)) {
            $_SESSION['message'] = "Password reset link has been sent to your email.";
            $_SESSION['status'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to send reset email. Please try again.";
            $_SESSION['status'] = 'danger';
        }
    } else {
        $_SESSION['message'] = "No account found with that email address.";
        $_SESSION['status'] = 'danger';
    }
    
    header("Location: pages-forgotten-password.php");
    exit();
}
?>