<?php
session_start();
require_once 'includes/db-conn.php';

// ✅ Composer autoload (PhpSpreadsheet use කරන්න)
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// --- Upload & Import Excel ---
if (isset($_POST['upload'])) {
    if (isset($_FILES['excel']['tmp_name']) && $_FILES['excel']['tmp_name'] != "") {
        $file = $_FILES['excel']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheetData as $index => $row) {
                if ($index == 0) continue; // header row skip

                $date       = $row[0] ?? null;
                $patient    = $row[1] ?? null;
                $organism   = $row[2] ?? null;
                $antibiotic = $row[3] ?? null;
                $result     = $row[4] ?? null;

                if ($date && $patient) {
                    $stmt = $conn->prepare("
                        INSERT INTO antibiotic_data (test_date, patient_id, organism, antibiotic, result) 
                        VALUES (?, ?, ?, ?, ?)
                    ");
                    $stmt->bind_param("sssss", $date, $patient, $organism, $antibiotic, $result);
                    $stmt->execute();
                }
            }

            $msg = "Excel file imported successfully!";

        } catch (Exception $e) {
            $msg = "Error loading file: " . $e->getMessage();
        }
    } else {
        $msg = "Please upload a valid Excel file.";
    }
}

// --- Fetch Data from DB ---
$sql = "SELECT * FROM antibiotic_data ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Excel Upload & Analyze</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-3">Upload & Analyze Excel Data</h2>

    <?php if (!empty($msg)): ?>
      <div class="alert alert-info"><?= $msg; ?></div>
    <?php endif; ?>

    <!-- Upload Form -->
    <form method="post" enctype="multipart/form-data" class="mb-4">
      <div class="mb-3">
        <input type="file" name="excel" class="form-control" required>
      </div>
      <button type="submit" name="upload" class="btn btn-primary">Upload & Import</button>
    </form>

    <!-- Show Data -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Test Date</th>
          <th>Patient ID</th>
          <th>Organism</th>
          <th>Antibiotic</th>
          <th>Result</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id']; ?></td>
              <td><?= $row['test_date']; ?></td>
              <td><?= $row['patient_id']; ?></td>
              <td><?= $row['organism']; ?></td>
              <td><?= $row['antibiotic']; ?></td>
              <td><?= $row['result']; ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="6" class="text-center">No data found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
