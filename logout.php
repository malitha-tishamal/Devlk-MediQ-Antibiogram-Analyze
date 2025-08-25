<?php
session_start();
require_once 'includes/db-conn.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Sri Lanka timezone
    date_default_timezone_set('Asia/Colombo');
    $logout_time = date("Y-m-d H:i:s");

    // Update logout_time column
    $sql = "UPDATE users SET logout_time = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $logout_time, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Clear session
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.php");
exit();
?>
