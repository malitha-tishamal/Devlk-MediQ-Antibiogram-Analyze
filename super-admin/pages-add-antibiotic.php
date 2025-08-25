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
$sql = "SELECT name, email, nic,mobile,profile_picture FROM admins WHERE id = ?";
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

    <title>Add Antibiotic - Mediq</title>

    <?php include_once("../includes/css-links-inc.php"); ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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
            display: none; /* Hidden by default */
            z-index: 9999;
        }

        .error-popup {
            background-color: #dc3545;
        }
        .gramint {
            margin-right: 8px;
        }
    </style>
    
</head>

<body>

    <!-- Displaying the message from the session -->
    <?php if (isset($_SESSION['status'])): ?>
        <div class="popup-message <?php echo ($_SESSION['status'] == 'success') ? '' : 'error-popup'; ?>" id="popup-alert">
            <?php echo $_SESSION['message']; ?>
        </div>

        <script>
            // Display the popup message
            document.getElementById('popup-alert').style.display = 'block';

            // Automatically hide the popup after 10 seconds
            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) {
                    popupAlert.style.display = 'none';
                }
            }, 500);

            // If success message, redirect to index.php after 10 seconds
            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(function() {
                    //window.location.href = 'pages-add-antibiotic.php'; // Redirect after 10 seconds
                }, 500); // Delay 10 seconds before redirecting
            <?php endif; ?>
        </script>

        <?php
        // Clear session variables after showing the message
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>


    <?php include_once("../includes/header.php") ?>

    <?php include_once("../includes/sadmin-sidebar.php") ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add Antibiotic</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Add Antibiotic</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="p-3">
                        <h5 class="text-danger">Gram to Milligram Converter</h5>
                        <div class="d-flex">
                            <input type="number" class="gramint form-control w-50" id="gramInput" placeholder="Enter grams">
                            <p class="output form-control w-50" id="mgresult">Output: </p>
                        </div>

                        <script>
                            document.getElementById("gramInput").addEventListener("keyup", function() {
                                let grams = parseFloat(this.value);
                                if (!isNaN(grams) && grams >= 0) {
                                    let mg = grams * 1000;
                                    document.getElementById("mgresult").textContent = grams + "g (" + mg + "mg)";
                                } else {
                                    document.getElementById("mgresult").textContent = "Output: ";
                                }
                            });
                        </script>
                    </div>
                </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add New Antibiotic</h5>
                            <p>Add Antibiotic here.</p>

                            <div class="container mt-4">
                                 <form action="submit.php" method="POST">
                                    <div class="col-md-4 mb-3">
                                        <label for="antibioticName" class="form-label">Antibiotic Name</label>
                                        <input type="text" class="form-control" id="antibioticName" name="antibiotic_name" placeholder="eg: Amoxicillin" required>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="category" class="form-label">Category</label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="" selected disabled>Select Category</option>
                                            <option value="Access">Access</option>
                                            <option value="Watch">Watch</option>
                                            <option value="Reserve">Reserve</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <!-- First Dosage and STV pair -->
                                    <div id="dosageFields" class="mb-3">
                                        <div class="row align-items-end mb-2">
                                            <div class="col-md-4">
                                                <label class="form-label">Dosage</label>
                                                <input type="text" class="form-control" name="dosage[]" placeholder="eg: 10mg" >
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">SR Number</label>
                                                <input type="text" class="form-control" name="stv[]" placeholder="eg: 12345" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex mt-3">
                                        <button type="button" class="btn btn-primary me-3" id="addDosageBtn">Add Another Dosage</button>
                                        <button type="submit" class="btn btn-success me-3">Submit</button>
                                        <button type="reset" class="btn btn-danger">Clear</button>
                                    </div>
                                </form>

                                <script>
                                document.getElementById('addDosageBtn').addEventListener('click', function() {
                                    const dosageFields = document.getElementById('dosageFields');

                                    // New row for Dosage + STV
                                    const newRow = document.createElement('div');
                                    newRow.classList.add('row', 'align-items-end', 'mb-2');

                                    // Dosage input
                                    const dosageCol = document.createElement('div');
                                    dosageCol.classList.add('col-md-4');
                                    dosageCol.innerHTML = `
                                        <label class="form-label">Dosage</label>
                                        <input type="text" class="form-control" name="dosage[]" placeholder="eg: 10mg" required>
                                    `;

                                    // STV input
                                    const stvCol = document.createElement('div');
                                    stvCol.classList.add('col-md-4');
                                    stvCol.innerHTML = `
                                        <label class="form-label">SR Number</label>
                                        <input type="text" class="form-control" name="stv[]" placeholder="eg: 12345" required>
                                    `;

                                    // Remove button column
                                    const removeCol = document.createElement('div');
                                    removeCol.classList.add('col-md-2');
                                    const removeButton = document.createElement('button');
                                    removeButton.type = 'button';
                                    removeButton.classList.add('btn', 'btn-danger', 'btn-sm');
                                    removeButton.textContent = 'Remove';
                                    removeButton.style.width = '100px';
                                    removeButton.style.height = '38px';

                                    removeButton.addEventListener('click', function() {
                                        dosageFields.removeChild(newRow);
                                    });

                                    removeCol.appendChild(removeButton);

                                    // Append all cols to row
                                    newRow.appendChild(dosageCol);
                                    newRow.appendChild(stvCol);
                                    newRow.appendChild(removeCol);

                                    dosageFields.appendChild(newRow);
                                });
                                </script>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("../includes/footer2.php") ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <?php include_once("../includes/js-links-inc.php") ?>
    
    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // On form submit
            $("#signup-form").submit(function(event) {
                event.preventDefault(); // Prevent form submission

                $.ajax({
                    url: "submit.php", // Send form data to register.php
                    type: "POST",
                    data: $(this).serialize(), // Serialize the form data
                    dataType: "json", // Expect JSON response
                    success: function(response) {
                        let popupAlert = $("#popup-alert");

                        // Set the message class and text based on the response status
                        if (response.status === "success") {
                            popupAlert.removeClass("alert-error").addClass("alert-success").html(response.message);
                        } else {
                            popupAlert.removeClass("alert-success").addClass("alert-error").html(response.message);
                        }

                        // Show the alert
                        popupAlert.show();

                        // Hide the alert after 10 seconds
                        setTimeout(function() {
                            popupAlert.fadeOut();
                        }, 10000);

                        // If success, redirect after message disappears
                        if (response.status === "success") {
                            setTimeout(function() {
                                window.location.href = "pages-add-antibiotic.php"; // Change this to your target redirect URL
                            }, 10000); // Same 10 seconds delay before redirect
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX Error: " + xhr.responseText); // Handle AJAX error
                    }
                });
            });
        });
    </script>



</body>

</html>
