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
$sql = "SELECT name, email, nic, mobile,profile_picture FROM admins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Add New Ward - Mediq</title>
    <?php include_once("../includes/css-links-inc.php"); ?>
    <style>
        /* Styling for the popup */
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

    <?php include_once("../includes/header.php"); ?>
    <?php include_once("../includes/sadmin-sidebar.php"); ?>

    <!-- Displaying the message from the session -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>

        <script>
            document.getElementById('popup-alert').style.display = 'block';

            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) {
                    popupAlert.style.display = 'none';
                }
            }, 500);

            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(function() {
                    //window.location.href = 'pages-add-new-ward.php';
                }, 500);
            <?php endif; ?>
        </script>

        <?php
        // Clear session variables after showing the message
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add New Ward</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Add New Ward</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Ward</h5>
                            <form id="ward-form" action="add_ward.php" method="POST" class="mb-4">
                                <div class="mb-3">
                                    <label for="ward_name" class="form-label">Ward Name:</label>
                                    <input type="text" id="ward_name" name="ward_name" class="form-control w-75" placeholder="e.g., 3 & 5 (Surgical prof.)" required>
                                </div>

                                <div class="mb-3">
                                    <label for="manage" class="form-label">Managed By (Team): </label>
                                    <input type="text" id="team" name="team" class="form-control w-75" placeholder="Team" required>
                                </div>

                                <div class="mb-3">
                                    <label for="manage" class="form-label">Managed By (Docters Name)</label>
                                    <input type="text" id="manage" name="manage" class="form-control w-75" placeholder="Dr. Name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category:</label>
                                    <select id="category" name="category" class="form-select w-75" required>
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="Pediatrics">Pediatrics</option>
                                        <option value="Medicine">Medicine</option>
                                        <option value="ICU">ICU </option>
                                        <option value="Surgery">Surgery </option>
                                        <option value="Medicine Subspecialty">Medicine Subspecialty</option>
                                        <option value="Surgery Subspecialty">Surgery Subspecialty</option>
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="description" class="form-label">Description:</label>
                                    <textarea id="description" name="description" class="form-control w-75" placeholder="Any Notice Details"></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Add Ward</button>
                                <button type="reset" class="btn btn-danger">Clear</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer.php"); ?>
    <?php include_once("../includes/js-links-inc.php") ?>

    <script>
       $(document).ready(function() {
        $("#ward-form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: "add_ward.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {
                    let popupAlert = $("#popup-alert");

                    if (response.status === "success") {
                        popupAlert.removeClass("error-popup").addClass("popup-message").html(response.message);
                    } else {
                        popupAlert.addClass("error-popup").html(response.message);
                    }

                    popupAlert.show();

                    setTimeout(function() {
                        popupAlert.fadeOut();
                    }, 1500);

                    if (response.status === "success") {
                        setTimeout(function() {
                            window.location.href = "pages-add-new-ward.php";
                        }, 1500);
                    }
                },
                error: function(xhr, status, error) {
                    alert("AJAX Error: " + xhr.responseText);
                }
            });
        });
    });

    </script>
</body>
</html>
