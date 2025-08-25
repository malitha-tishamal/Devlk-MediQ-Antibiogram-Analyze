<?php
session_start();
require_once 'includes/db-conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Unauthorized access!';
        header("Location: user-profile.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $nic = trim($_POST['nic']);
    $mobile = trim($_POST['mobile']);
    $system_name = trim($_POST['system_name']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid email format!';
        header("Location: user-profile.php");
        exit();
    }

    // Update user details in the database including system_name
    $sql = "UPDATE users SET name = ?, email = ?, nic = ?, mobile = ?, system_name = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssssi", $name, $email, $nic, $mobile, $system_name, $user_id);
        if ($stmt->execute()) {
            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Profile updated successfully!';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to update profile!';
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error!';
    }

    // Redirect back to profile page
    header("Location: user-profile.php");
    exit();
}
?>
