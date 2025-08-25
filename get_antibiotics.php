<?php
// Include the database connection
require_once "includes/db-conn.php";  

// Set response type to JSON
header('Content-Type: application/json');

if (isset($_GET['term'])) {
    $term = trim($_GET['term']); 

    // Query to fetch antibiotic names and their corresponding dosages from the correct table
    $query = "
        SELECT a.id, a.name, d.dosage 
        FROM antibiotics a
        LEFT JOIN dosages d ON a.id = d.antibiotic_id
        WHERE a.name LIKE ?
        LIMIT 10
    ";

    $stmt = $conn->prepare($query);
    $searchTerm = "%" . $term . "%"; 
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = [
            "id" => $row['id'],
            "name" => $row['name'],
            "dosage" => $row['dosage'] ?: "No dosage available" // Default if no dosage exists
        ];
    }

    $stmt->close();
    $conn->close();

    echo json_encode($suggestions);
}
?>
