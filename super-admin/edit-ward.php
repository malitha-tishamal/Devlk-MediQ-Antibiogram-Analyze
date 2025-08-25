<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
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

// Get ward ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid ward ID!';
    header("Location: pages-manage-wards.php");
    exit();
}

$ward_id = intval($_GET['id']);

// Fetch existing ward details
$sql = "SELECT * FROM ward WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ward_id);
$stmt->execute();
$result = $stmt->get_result();
$ward = $result->fetch_assoc();
$stmt->close();

// If ward not found, redirect back
if (!$ward) {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Ward not found!';
    header("Location: pages-manage-wards.php");
    exit();
}

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ward_name = trim($_POST['ward_name']);
    $team = trim($_POST['team']);
    $managed_by = trim($_POST['managed_by']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    $sql = "UPDATE ward SET ward_name = ?, team = ?, managed_by = ?, description = ?, category = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $ward_name, $team, $managed_by, $description, $category, $ward_id);

    if ($stmt->execute()) {
        $_SESSION['status'] = 'success';
        $_SESSION['message'] = 'Ward updated successfully!';
        header("Location: pages-manage-wards.php");
        exit();
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Failed to update ward!';
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Edit Ward - Mediq</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
</head>
<body>

    <?php include_once("../includes/header.php"); ?>
    <?php include_once("../includes/sadmin-sidebar.php"); ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Ward</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="pages-manage-wards.php">Manage Wards</a></li>
                    <li class="breadcrumb-item active">Edit Ward</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Edit Ward</h5>
                            
                            <!-- Error Message -->
                            <?php if (isset($_SESSION['message'])): ?>
                                <div class="alert <?php echo $_SESSION['status'] == 'success' ? 'alert-success' : 'alert-danger'; ?>">
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                                <?php unset($_SESSION['message']); unset($_SESSION['status']); ?>
                            <?php endif; ?>

                            <form method="POST">
                                <div class="mb-3">
                                    <label for="ward_name" class="form-label">Ward Name:</label>
                                    <input type="text" id="ward_name" name="ward_name" class="form-control" 
                                        value="<?php echo htmlspecialchars($ward['ward_name']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="team" class="form-label">Managed By (Team):</label>
                                    <input type="text" id="team" name="team" class="form-control" 
                                        value="<?php echo htmlspecialchars($ward['team']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="managed_by" class="form-label">Managed By (Doctor Name):</label>
                                    <input type="text" id="managed_by" name="managed_by" class="form-control" 
                                        value="<?php echo htmlspecialchars($ward['managed_by']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category:</label>
                                    <select id="category" name="category" class="form-select" required>
                                        <option value="">-- Select Category --</option>
                                        <option value="Pediatrics" <?php if ($ward['category'] == 'Pediatrics') echo 'selected'; ?>>Pediatrics</option>
                                        <option value="Medicine" <?php if ($ward['category'] == 'Medicine') echo 'selected'; ?>>Medicine</option>
                                         <option value="ICU" <?php if ($ward['category'] == 'ICU') echo 'selected'; ?>>ICU</option>
                                        <option value="Medicine Subspecialty" <?php if ($ward['category'] == 'Medicine Subspecialty') echo 'selected'; ?>>Medicine Subspecialty</option>
                                        <option value="Surgery" <?php if ($ward['category'] == 'Surgery') echo 'selected'; ?>>Surgery </option>
                                        <option value="Surgery Subspecialty" <?php if ($ward['category'] == 'Surgery Subspecialty') echo 'selected'; ?>>Surgery Subspecialty</option>

                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($ward['description']); ?></textarea>
                                </div>

                                <button type="submit" class="btn btn-success">Save Changes</button>
                                <a href="pages-manage-wards.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php"); ?>
    <?php include_once("../includes/js-links-inc.php"); ?>
</body>
</html>
