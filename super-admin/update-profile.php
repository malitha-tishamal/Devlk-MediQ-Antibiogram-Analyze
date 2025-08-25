<?php
session_start();
require_once '../includes/db-conn.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['admin_id'])) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Unauthorized access!';
        header("Location: user-profile.php");
        exit();
    }

    $user_id = $_SESSION['admin_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $nic = trim($_POST['nic']);
    $mobile = trim($_POST['mobile']);
    

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Invalid email format!';
        header("Location: user-profile.php");
        exit();
    }

    // Update user details in the database
    $sql = "UPDATE admins SET name = ?, email = ?, nic = ?, mobile = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssi", $name, $email, $nic, $mobile, $user_id);
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
