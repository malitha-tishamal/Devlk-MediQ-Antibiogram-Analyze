<?php
session_start();
require_once 'includes/db-conn.php';

// Redirect if not logged in as admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch admin user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, nic, mobile, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch all antibiotics with dosages and their STV numbers
$sql = "SELECT a.id, a.name, a.category, GROUP_CONCAT(CONCAT(d.dosage, ' (SR: ', d.stv_number, ')') SEPARATOR '|') AS dosages
        FROM antibiotics a
        LEFT JOIN dosages d ON a.id = d.antibiotic_id
        GROUP BY a.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Antibiotics Details - Mediq</title>
    <?php include_once("includes/css-links-inc.php"); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .popup-message {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px;
            background-color: #28a745;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            display: none;
            z-index: 9999;
        }
        .error-popup {
            background-color: #dc3545;
        }
    </style>
</head>

<body>

    <?php include_once("includes/header.php"); ?>
    <?php include_once("includes/user-sidebar.php"); ?>

    <!-- Display session messages -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>
        <script>
            document.getElementById('popup-alert').style.display = 'block';
            setTimeout(() => { document.getElementById('popup-alert').style.display = 'none'; }, 5000);
            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(() => { window.location.href = 'pages-manage-antibiotic.php'; }, 5000);
            <?php endif; ?>
        </script>
        <?php unset($_SESSION['status'], $_SESSION['message']); ?>
    <?php endif; ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Antibiotics </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Antibiotics Details</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Antibiotic List</h5>
                            <table class="table datatable">
                                <thead class="align-middle text-center">
                                    <tr>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Dosages & SR Numbers</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result && $result->num_rows > 0): ?>
                                        <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['name']) ?></td>
                                                <td><?= htmlspecialchars($row['category'] ?? '-') ?></td>
                                                <td>
                                                    <?php
                                                    if (!empty($row['dosages'])) {
                                                        $pairs = explode('|', $row['dosages']);
                                                        foreach ($pairs as $pair) {
                                                            echo htmlspecialchars($pair) . "<br>";
                                                        }
                                                    } else {
                                                        echo "No dosages found";
                                                    }
                                                    ?>
                                                </td>
                                                
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr><td colspan="3" class="text-center">No antibiotics found.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("includes/footer.php"); ?>
    <?php include_once("includes/js-links-inc.php"); ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</body>
</html>
