<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid ward ID!';
    header("Location: pages-manage-wards.php");
    exit();
}

$ward_id = intval($_GET['id']);

// Delete query
$sql = "DELETE FROM ward WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ward_id);

if ($stmt->execute()) {
    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Ward deleted successfully!';
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Failed to delete ward!';
}
$stmt->close();
header("Location: pages-manage-wards.php");
exit();
?>
