<?php
require_once '../includes/db-conn.php';

if (!isset($_GET['antibiotic_name'])) {
    echo json_encode([]);
    exit();
}

$antibiotic = $_GET['antibiotic_name'];

$stmt = $conn->prepare("SELECT DISTINCT dosage FROM releases WHERE antibiotic_name = ?");
$stmt->bind_param("s", $antibiotic);
$stmt->execute();
$result = $stmt->get_result();

$dosages = [];
while ($row = $result->fetch_assoc()) {
    $dosages[] = $row['dosage'];
}

echo json_encode($dosages);
