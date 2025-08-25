<?php
session_start();
require_once "../includes/db-conn.php";

// Check if the POST data is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $antibiotic_id = $_POST['antibiotic_id'];
    $antibiotic_name = trim($_POST['antibiotic_name']);
    $dosages = $_POST['dosage'];  // Array of dosages

    // Validate input
    if (empty($antibiotic_name) || empty($dosages)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Please fill in all fields.';
        header("Location: edit-antibiotic.php?id=$antibiotic_id");
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update antibiotic name
        $sql = "UPDATE antibiotics SET name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Error: Could not prepare update antibiotic query.');
        }
        $stmt->bind_param("si", $antibiotic_name, $antibiotic_id);
        if (!$stmt->execute()) {
            throw new Exception('Error: Could not update antibiotic name.');
        }

        // Delete existing dosages
        $delete_dosages_sql = "DELETE FROM dosages WHERE antibiotic_id = ?";
        $delete_dosages_stmt = $conn->prepare($delete_dosages_sql);
        if ($delete_dosages_stmt === false) {
            throw new Exception('Error: Could not prepare delete dosages query.');
        }
        $delete_dosages_stmt->bind_param("i", $antibiotic_id);
        if (!$delete_dosages_stmt->execute()) {
            throw new Exception('Error: Could not delete old dosages.');
        }

        // Insert new dosages
        $dosage_sql = "INSERT INTO dosages (antibiotic_id, dosage) VALUES (?, ?)";
        $dosage_stmt = $conn->prepare($dosage_sql);
        if ($dosage_stmt === false) {
            throw new Exception('Error: Could not prepare dosage insert query.');
        }

        foreach ($dosages as $dosage) {
            $dosage = trim($dosage);  // Sanitize dosage values
            if (!empty($dosage)) {
                $dosage_stmt->bind_param("is", $antibiotic_id, $dosage);
                if (!$dosage_stmt->execute()) {
                    throw new Exception('Error: Could not insert dosage.');
                }
            }
        }

        // Commit the transaction
        $conn->commit();

        // Success message
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Antibiotic updated successfully!';
        header("Location: pages-manage-antibiotic.php");
        exit();
    } catch (Exception $e) {
        // If any error occurs, rollback the transaction
        $conn->rollback();

        // Error message
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = $e->getMessage();
        header("Location: edit-antibiotic.php?id=$antibiotic_id");
        exit();
    }
}
?>
