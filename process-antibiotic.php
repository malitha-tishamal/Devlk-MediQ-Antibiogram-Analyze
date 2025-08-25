<?php
// Include the database connection file
require_once "includes/db-conn.php";  

// Check if the search term is provided
if (isset($_GET['term'])) {
    $term = trim($_GET['term']); // Trim whitespace

    // Query the database for matching antibiotics
    $query = "SELECT name FROM antibiotics WHERE name LIKE ? LIMIT 10"; // Limit for performance
    $stmt = $conn->prepare($query);
    $searchTerm = "%" . $term . "%"; // Wildcard for partial matching
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the results as an array
    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['name']; // Only return raw names
    }

    // Close database connection
    $stmt->close();
    $conn->close();

    // Return JSON response
    echo json_encode($suggestions);
}
?>
