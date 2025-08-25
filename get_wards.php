<?php
require_once 'includes/db-conn.php';

if (isset($_GET['term'])) {
    $term = "%" . $_GET['term'] . "%"; // SQL wildcard search

    $stmt = $conn->prepare("SELECT id, ward_name FROM ward WHERE ward_name LIKE ?");
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $wards = [];
    while ($row = $result->fetch_assoc()) {
        $wards[] = ["id" => $row["id"], "name" => $row["ward_name"]];
    }

    echo json_encode($wards);
    $stmt->close();
}

$conn->close();
?>
