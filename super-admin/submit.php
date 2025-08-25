<?php
session_start();
require_once "../includes/db-conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $antibiotic_name = trim($_POST['antibiotic_name']);
    $category = trim($_POST['category'] ?? '');
    $dosages = $_POST['dosage'] ?? [];
    $stv_numbers = $_POST['stv'] ?? [];

    if (empty($antibiotic_name) || empty($category) || empty($stv_numbers)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Please enter the antibiotic name, category, and at least one STV number.';
        header("Location: pages-add-antibiotic.php");
        exit();
    }

    // Check for duplicate STV numbers within the form
    if (count($stv_numbers) !== count(array_unique($stv_numbers))) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Duplicate STV numbers entered in the form!';
        header("Location: pages-add-antibiotic.php");
        exit();
    }

    // Check for STV numbers already in the database
    $placeholders = implode(',', array_fill(0, count($stv_numbers), '?'));
    $types = str_repeat('s', count($stv_numbers));
    $check_sql = "SELECT stv_number FROM dosages WHERE stv_number IN ($placeholders)";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param($types, ...$stv_numbers);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $existing_stvs = [];
    while ($row = $result->fetch_assoc()) {
        $existing_stvs[] = $row['stv_number'];
    }
    if (!empty($existing_stvs)) {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'These STV numbers already exist: ' . implode(', ', $existing_stvs);
        header("Location: pages-add-antibiotic.php");
        exit();
    }

    // Insert antibiotic with category
    $sql = "INSERT INTO antibiotics (name, category) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $antibiotic_name, $category);
        if ($stmt->execute()) {
            $antibiotic_id = $stmt->insert_id;

            $dosage_sql = "INSERT INTO dosages (antibiotic_id, dosage, stv_number) VALUES (?, ?, ?)";
            $dosage_stmt = $conn->prepare($dosage_sql);

            for ($i = 0; $i < count($stv_numbers); $i++) {
                $dosage = !empty($dosages[$i]) ? trim($dosages[$i]) : 'No dosage available';
                $stv = trim($stv_numbers[$i]);

                $dosage_stmt->bind_param("iss", $antibiotic_id, $dosage, $stv);
                $dosage_stmt->execute();
            }

            $_SESSION['status'] = 'success';
            $_SESSION['message'] = 'Antibiotic and STV numbers saved successfully!';
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Failed to insert antibiotic.';
        }
        $stmt->close();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Database error: ' . $conn->error;
    }

    header("Location: pages-add-antibiotic.php");
    exit();
}
?>
