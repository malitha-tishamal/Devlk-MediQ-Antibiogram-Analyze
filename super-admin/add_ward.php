<?php
session_start();
header('Content-Type: application/json'); // Ensure JSON response

require_once '../includes/db-conn.php'; // Database connection

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['status'] = "error";
    $_SESSION['message'] = "Unauthorized access!";
    echo json_encode(["status" => "error", "message" => $_SESSION['message']]);
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ward_name = trim($_POST['ward_name']);
    $team = trim($_POST['team']);
    $manage = trim($_POST['manage']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);

    // Validate required fields
    if (empty($ward_name) || empty($team) || empty($manage) || empty($category)) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = "All fields are required!";
        echo json_encode(["status" => "error", "message" => $_SESSION['message']]);
        exit();
    }

    try {
        // Check for duplicate ward name
        $check_sql = "SELECT id FROM ward WHERE ward_name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $ward_name);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Ward Name already exists!";
            echo json_encode(["status" => "error", "message" => $_SESSION['message']]);
            $check_stmt->close();
            exit();
        }
        $check_stmt->close();

        // Insert new ward
        $sql = "INSERT INTO ward (ward_name, team, managed_by, category, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $ward_name, $team, $manage, $category, $description);

        if ($stmt->execute()) {
            $_SESSION['status'] = "success";
            $_SESSION['message'] = "Ward added successfully!";
            echo json_encode(["status" => "success", "message" => $_SESSION['message']]);
        } else {
            throw new Exception('Database error: ' . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "error";
        $_SESSION['message'] = $e->getMessage();
        echo json_encode(["status" => "error", "message" => $_SESSION['message']]);
    } finally {
        if (isset($stmt)) $stmt->close();
        $conn->close();
    }
}
exit();
?>
