<?php
session_start();
require_once "../includes/db-conn.php";

// Check if the ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Antibiotic ID not provided.';
    header("Location: pages-manage-antibiotic.php");
    exit();
}

$antibiotic_id = $_GET['id'];

// Delete dosages related to this antibiotic
$delete_dosages_sql = "DELETE FROM dosages WHERE antibiotic_id = ?";
$delete_dosages_stmt = $conn->prepare($delete_dosages_sql);
$delete_dosages_stmt->bind_param("i", $antibiotic_id);
$delete_dosages_stmt->execute();

// Delete the antibiotic itself
$delete_sql = "DELETE FROM antibiotics WHERE id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $antibiotic_id);
if ($delete_stmt->execute()) {
    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Antibiotic deleted successfully!';
} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Error: Could not delete antibiotic.';
}

header("Location: pages-manage-antibiotic.php");
exit();
?>
