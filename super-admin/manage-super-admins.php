<?php
session_start();
require_once '../includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

// Current logged-in admin ID
$currentAdminId = $_SESSION['admin_id'];

// Fetch user details
$sql = "SELECT name, email, nic, mobile, profile_picture FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $currentAdminId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch all admins
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Management - Mediq</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
</head>

<body>
    <?php include_once("../includes/header.php") ?>
    <?php include_once("../includes/sadmin-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Manage Admins</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Manage Admins</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Admin Management</h5>
                            <p>Manage Admins here.</p>

                            <table class="table datatable">
                                <thead class="align-middle text-center">
                                    <tr>
                                        <th class="text-center">Profile Picture</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">ID-No</th>
                                        <th class="text-center">Mobile No</th>
                                        <th class="text-center">Last LogIn</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" colspan="3">Actions</th>
                                    </tr>
                                    <tr>
                                        <th colspan="6"></th>
                                        <th class="text-center">Approve</th>
                                        <th class="text-center">Disable</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td><img src='uploads/" . htmlspecialchars($row["profile_picture"]) . "' alt='Profile' width='120'></td>";
                                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nic']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['mobile']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['last_login']) . "</td>";

                                            // Status Column with Color
                                            $status = strtolower($row['status']);
                                            if ($status === 'active' || $status === 'approved') {
                                                $statusDisplay = "<span class='btn btn-success btn-sm w-100 text-center'>Approved</span>";
                                            } elseif ($status === 'disabled') {
                                                $statusDisplay = "<span class='btn btn-danger btn-sm w-100 text-center'>Disabled</span>";
                                            } elseif ($status === 'pending') {
                                                $statusDisplay = "<span class='btn btn-warning btn-sm w-100 text-center'>Pending</span>";
                                            } else {
                                                $statusDisplay = "<span class='btn btn-secondary btn-sm w-100 text-center'>" . ucfirst($row['status']) . "</span>";
                                            }
                                            echo "<td>$statusDisplay</td>";

                                            // Disable action buttons for current logged-in user
                                            $isCurrentUser = ($row['id'] == $currentAdminId);
                                            $approveDisabled = ($status === 'active' || $status === 'approved' || $isCurrentUser) ? "disabled style='opacity:0.5;pointer-events:none;'" : "";
                                            $disableDisabled = ($status === 'disabled' || $isCurrentUser) ? "disabled style='opacity:0.5;pointer-events:none;'" : "";
                                            $deleteDisabled = $isCurrentUser ? "disabled style='opacity:0.5;pointer-events:none;'" : "";

                                            echo "<td class='text-center'>
                                                    <button class='btn btn-success btn-sm w-100 approve-btn' data-id='" . $row['id'] . "' $approveDisabled>Approve</button>
                                                  </td>";
                                            echo "<td class='text-center'>
                                                    <button class='btn btn-warning btn-sm w-100 disable-btn' data-id='" . $row['id'] . "' $disableDisabled>Disable</button>
                                                  </td>";
                                            echo "<td class='text-center'>
                                                    <button class='btn btn-danger btn-sm w-100 delete-btn' data-id='" . $row['id'] . "' $deleteDisabled>Delete</button>
                                                  </td>";

                                            // Edit button
                                            echo "<td class='text-center'>
                                                    <a href='edit-super-admin.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm w-100'>Edit</a>
                                                  </td>";

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='text-center'>No users found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer2.php") ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include_once("../includes/js-links-inc.php") ?>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function () {
        const approveButtons = document.querySelectorAll('.approve-btn');
        const disableButtons = document.querySelectorAll('.disable-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        approveButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                window.location.href = `process-action-superadmin.php?approve_id=${userId}`;
            });
        });

        disableButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                window.location.href = `process-action-superadmin.php?disable_id=${userId}`;
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.getAttribute('data-id');
                if (confirm("Are you sure you want to delete this user?")) {
                    window.location.href = `process-action-superadmin.php?delete_id=${userId}`;
                }
            });
        });
      });
    </script>

</body>
</html>

<?php
$conn->close();
?>
