<?php
session_start();
date_default_timezone_set('Asia/Colombo'); // ✅ Set Sri Lanka Time Zone

require_once 'includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch active book numbers for dropdown
$bookOptions = [];
$bookQuery = $conn->query("SELECT id, book_number FROM book_transactions WHERE status = 'active' ORDER BY book_number ASC");
while ($row = $bookQuery->fetch_assoc()) {
    $bookOptions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dispensing Antibiotics - Mediq</title>

    <?php include_once("includes/css-links-inc.php"); ?>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <style>
        /* Custom style for suggestion list */
        .autocomplete-list {
            position: absolute;
            z-index: 1000;
            width: 80%;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .autocomplete-list li {
            padding: 8px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }

        .autocomplete-list li:hover {
            background-color: #f1f1f1;
        }
    </style>
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

            // Automatically hide the popup after 1 seconds
            setTimeout(function() {
                const popupAlert = document.getElementById('popup-alert');
                if (popupAlert) {
                    popupAlert.style.display = 'none';
                }
            }, 1000);

            // If success message, redirect to index.php after 10 seconds
            <?php if ($_SESSION['status'] == 'success'): ?>
                setTimeout(function() {
                    //window.location.href = 'pages-release-antibiotic.php'; // Redirect after 10 seconds
                }, 1000); // Delay 1 seconds before redirecting
            <?php endif; ?>
        </script>
        <?php
        // Clear session variables after showing the message
        unset($_SESSION['status']);
        unset($_SESSION['message']);
        ?>
    <?php endif; ?>

    <?php include_once("includes/header.php"); ?>
    <?php include_once("includes/user-sidebar.php"); ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dispensing Antibiotics</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item">Pages</li>
                    <li class="breadcrumb-item active">Dispensing Antibiotics</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Dispensing Antibiotics</h5>

                            <div class="container mt-3">
                                <form action="update_release.php" method="POST" id="releaseForm">
                                    <!-- Hidden field for antibiotic and ward IDs -->
                                    <input type="hidden" id="antibiotic_id" name="antibiotic_id">
                                    <input type="hidden" id="ward_id" name="ward_id">

                                    <div class="mb-3 position-relative">
                                        <label for="antibiotic" class="form-label">Select Antibiotic:</label>
                                        <input type="text" id="antibiotic" name="antibiotic_name" class="form-control w-100" placeholder="Type antibiotic name...(Name Auto Suggest Typing)" autocomplete="off" required>
                                        <ul id="autocomplete-antibiotic" class="autocomplete-list"></ul>
                                    </div>

                                    <div class="mb-3">
                                        <label for="dosage" class="form-label">Dosage:</label>
                                        <input type="text" id="dosage" name="dosage" class="form-control w-75" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="ward" class="form-label">Release Ward:</label>
                                        <input type="text" id="ward" name="ward" class="form-control w-100" placeholder="Type ward name...(Name Auto Suggest Typing)" autocomplete="off">
                                        <ul id="autocomplete-ward" class="autocomplete-list"></ul>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select Date & Time:</label><br>

                                        <input type="radio" name="datetime_option" id="useCurrent" value="current" checked>
                                        <label for="useCurrent">Use current system date & time</label><br>

                                        <input type="radio" name="datetime_option" id="useManual" value="manual">
                                        <label for="useManual">Enter manually</label>

                                        <!-- Hidden field for current datetime -->
                                        <input type="hidden" name="current_datetime" id="currentDateTime">

                                        <!-- Manual input (hidden by default) -->
                                        <input type="datetime-local" name="manual_datetime" id="manualDateTime" class="form-control w-100 mt-2" style="display: none;">
                                    </div>
                                    <script>
                                        // Set current datetime in hidden input
                                        function setCurrentDateTime() {
                                            const now = new Date();
                                            const formatted = now.toISOString().slice(0, 16); // "yyyy-MM-ddThh:mm"
                                            document.getElementById("currentDateTime").value = formatted;
                                        }

                                        // Toggle manual datetime input
                                        document.getElementById("useCurrent").addEventListener("change", function () {
                                            document.getElementById("manualDateTime").style.display = "none";
                                        });

                                        document.getElementById("useManual").addEventListener("change", function () {
                                            document.getElementById("manualDateTime").style.display = "block";
                                        });

                                        // Initialize current datetime on page load
                                        window.addEventListener("DOMContentLoaded", setCurrentDateTime);
                                    </script>

                                    <!-- Book Number Select -->
                                    <div class="mb-3">
                                        <label for="book_number_select" class="form-label">Select Book Number (Active Only):</label>
                                        <select name="book_number_select" id="book_number_select" class="form-select w-50">
                                            <option value="">-- Select Book Number --</option>
                                            <?php foreach ($bookOptions as $book): ?>
                                                <option value="<?= $book['book_number'] ?>"><?= htmlspecialchars($book['book_number']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Page Number Input -->
                                    <div class="mb-3">
                                        <label for="page_number_manual" class="form-label">Enter Page Number:</label>
                                        <input type="text" name="page_number_manual" id="page_number_manual" class="form-control w-50" placeholder="Enter page number here">
                                    </div>



                                    <div class="mb-3">
                                        <label for="itemCount" class="form-label">Item Count:</label>
                                        <input type="number" id="itemCount" name="item_count" class="form-control w-50" placeholder="Enter item count" required>
                                    </div>

                                    <!--div class="mb-3">
                                        <label for="option" class="form-label">Route:</label>
                                        <select name="ant_type" id="" class="form-select w-50" required>
                                            <option >--Select Route--</option>
                                            <option value="oral">Oral</option>
                                            <option value="intravenous">Intravenous</option>
                                            <option value="topical">Topical</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div-->

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Stock of Antibiotic:</label>
                                        <br>
                                        <label for="type" class="form-label">MSD</label>
                                        <input type="radio" id="" name="type" class="" value="msd">
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label for="type" class="form-label">LP</label>
                                        <input type="radio" id="" name="type" class="" value="lp" >
                                    </div>

                                    <button type="submit" class="btn btn-success mt-3">Update Database</button>
                                    <button type="reset" class="btn btn-danger mt-3">Clear</button>
                                    

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include_once("includes/footer.php"); ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once("includes/js-links-inc.php"); ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Function to setup autocomplete for both antibiotic and ward fields
            function setupAutocomplete(inputFieldId, hiddenFieldId, url, dosageFieldId = null) {
                const inputField = document.getElementById(inputFieldId);
                const hiddenField = document.getElementById(hiddenFieldId);
                const autocompleteList = document.getElementById(`autocomplete-${inputFieldId}`);

                inputField.addEventListener("keyup", function () {
                    const searchTerm = this.value.trim();

                    // Suggest immediately after the first character
                    if (searchTerm.length < 1) {
                        autocompleteList.innerHTML = "";
                        return;
                    }

                    fetch(`${url}?term=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            autocompleteList.innerHTML = "";
                            if (data.length === 0) {
                                autocompleteList.innerHTML = `<li class="list-group-item text-muted">No results found</li>`;
                                return;
                            }

                            data.forEach(item => {
                                const li = document.createElement("li");
                                li.className = "list-group-item list-group-item-action";
                                li.innerHTML = `<strong>${item.name}</strong> ${dosageFieldId ? `(${item.dosage})` : ''}`;
                                li.addEventListener("click", function () {
                                    inputField.value = item.name;
                                    hiddenField.value = item.id;
                                    if (dosageFieldId) {
                                        document.getElementById(dosageFieldId).value = item.dosage;
                                    }
                                    autocompleteList.innerHTML = "";
                                });
                                autocompleteList.appendChild(li);
                            });
                        })
                        .catch(error => console.error("Error fetching data:", error));
                });

                document.addEventListener("click", function (event) {
                    if (!inputField.contains(event.target) && !autocompleteList.contains(event.target)) {
                        autocompleteList.innerHTML = "";
                    }
                });
            }

            // Setup autocomplete for antibiotic and ward
            setupAutocomplete("antibiotic", "antibiotic_id", "get_antibiotics.php", "dosage");
            setupAutocomplete("ward", "ward_id", "get_wards.php");

            // Prevent form submission if antibiotic or ward is not selected
            document.getElementById("releaseForm").addEventListener("submit", function (e) {
                if (!document.getElementById("antibiotic_id").value || !document.getElementById("ward_id").value) {
                    alert("Please select an antibiotic and a ward from the suggestions.");
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>
