<?php
session_start();
require_once '../includes/db-conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $antibiotic_id = intval($_POST['antibiotic_id']);
    $antibiotic_name = trim($_POST['antibiotic_name']);
    $category = trim($_POST['category']);
    $dosage_ids = $_POST['dosage_ids'];
    $dosages = $_POST['dosage'];
    $stv_numbers = $_POST['stv'];

    if (empty($antibiotic_name) || empty($category) || empty($dosages) || empty($stv_numbers)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'All fields are required.';
        header("Location: edit-antibiotic.php?id=" . $antibiotic_id);
        exit();
    }

    // Check for duplicate STV numbers excluding current rows
    foreach ($stv_numbers as $index => $stv) {
        $check_sql = "SELECT id FROM dosages WHERE stv_number = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $stv, $dosage_ids[$index]);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = "Duplicate STV Number found: " . htmlspecialchars($stv);
            header("Location: edit-antibiotic.php?id=" . $antibiotic_id);
            exit();
        }
        $check_stmt->close();
    }

    // Update antibiotic name and category
    $update_name_sql = "UPDATE antibiotics SET name = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($update_name_sql);
    $stmt->bind_param("ssi", $antibiotic_name, $category, $antibiotic_id);
    $stmt->execute();
    $stmt->close();

    // Update each dosage record
    for ($i = 0; $i < count($dosage_ids); $i++) {
        $dosage = trim($dosages[$i]);
        $stv = trim($stv_numbers[$i]);
        $id = intval($dosage_ids[$i]);

        $update_dosage_sql = "UPDATE dosages SET dosage = ?, stv_number = ? WHERE id = ?";
        $stmt = $conn->prepare($update_dosage_sql);
        $stmt->bind_param("ssi", $dosage, $stv, $id);
        $stmt->execute();
        $stmt->close();
    }

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Antibiotic updated successfully!';
    header("Location: pages-manage-antibiotic.php");
    exit();
}
?>
