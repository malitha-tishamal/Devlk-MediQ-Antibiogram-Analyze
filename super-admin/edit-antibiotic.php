<?php
session_start();
require_once '../includes/db-conn.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid antibiotic ID!';
    header("Location: pages-manage-antibiotic.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['admin_id'];
$sql = "SELECT name, email, nic, mobile, profile_picture FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$antibiotic_id = $_GET['id'];

// Fetch antibiotic name and category
$sql = "SELECT name, category FROM antibiotics WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $antibiotic_id);
$stmt->execute();
$result = $stmt->get_result();
$antibiotic = $result->fetch_assoc();
$stmt->close();

// Fetch dosages with STV numbers
$dosages = [];
$sql = "SELECT id, dosage, stv_number FROM dosages WHERE antibiotic_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $antibiotic_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $dosages[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Antibiotic</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>

<?php include_once("../includes/header.php"); ?>
<?php include_once("../includes/sadmin-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit Antibiotic</h1>
    </div>

    <section class="section">
        <div class="card p-4">
            <form action="update-data-antibiotic.php" method="POST">
                <input type="hidden" name="antibiotic_id" value="<?= $antibiotic_id ?>">

                <div class="mb-3">
                    <label class="form-label">Antibiotic Name</label>
                    <input type="text" name="antibiotic_name" class="form-control w-75" required value="<?= htmlspecialchars($antibiotic['name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select w-50" required>
                        <option value="">-- Select Category --</option>
                        <option value="Access" <?= ($antibiotic['category'] == 'Access') ? 'selected' : '' ?>>Access</option>
                        <option value="Watch" <?= ($antibiotic['category'] == 'Watch') ? 'selected' : '' ?>>Watch</option>
                        <option value="Reserve" <?= ($antibiotic['category'] == 'Reserve') ? 'selected' : '' ?>>Reserve</option>
                        <option value="Other" <?= ($antibiotic['category'] == 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <h5>Dosages and STV Numbers</h5>
                <div id="dosageFields">
                    <?php foreach ($dosages as $d): ?>
                        <div class="row mb-2">
                            <input type="hidden" name="dosage_ids[]" value="<?= $d['id'] ?>">
                            <div class="col-md-5">
                                <input type="text" name="dosage[]" class="form-control" value="<?= htmlspecialchars($d['dosage']) ?>" >
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="stv[]" class="form-control" value="<?= htmlspecialchars($d['stv_number']) ?>" >
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-success">Update Antibiotic</button>
                <a href="pages-manage-antibiotic.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </section>
</main>

<?php include_once("../includes/footer.php"); ?>
<?php include_once("../includes/js-links-inc.php"); ?>

</body>
</html>
