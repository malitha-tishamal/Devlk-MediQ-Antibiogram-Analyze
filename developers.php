<?php
session_start();
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Developer Team - MediQ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <?php include_once ("includes/css-links-inc.php"); ?>

    <style>
        .team-card img{
            width :180px;
            height :180px;
        }
    </style>


</head>

<body>
    <?php include_once ("includes/header.php") ?>
    <?php include_once ("includes/user-sidebar.php") ?>
    <!-- ======= Header ======= -->
    <!-- Team Section -->
    <section class="team-section container">
        <h1 class="mb-5 text-primary fw-bold">Our Team</h1>
        <div class="row g-4 justify-content-center">
             <!-- Team Member 1-->
            <!--div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\supun.jpg" alt="Team Member">
                    <h4 class="fw-bold">Supun Charuka</h4>
                    <p>Full Stack Developer</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </div-->

            <!-- Team Member 2 -->
            <div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\malitha3.jpg" alt="Team Member">
                    <h5 class="fw-bold">Malitha Tishmal</h5>
                    <p><b>Full Stack Developer</b>
                        <br>Quality Assuarance
                        <br>System Administrator</p>
                    <div class="team-icons">
                        <a href="https://malithatishamal.42web.io/" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/malitha-tishamal" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/malitha.tishamal" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:malithatishamal@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\684c0f0cbbca3-1.jpg" alt="Team Member">
                    <h5 class="fw-bold">Malith Sandeepa</h5>
                    <p><b>Frontend Developer</b>
                       <br>Quality Assuarance
                        <br>System Administrator
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/KVMSANDEEPA" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="www.linkedin.com/in/malith-sandeepa" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100071177107363" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:malithsandeepa1081@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                     <!--span class="text-center text-danger"><b>Not Active</b></span-->
                     <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\tharidu.jpg" alt="Team Member">
                    <h5 class="fw-bold">Tharindu Sampath</h5>
                    <p><b>Frontend Developer</b>
                        <br>System Administrator<br>
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/VgTharindu" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="https://www.linkedin.com/in/vg-tharindu-0b0158272?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/share/1Dd22cM9oN/" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:vgtharindu165@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div>

            <!-- Team Member 4 -->
            <div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\nishara.jpg" alt="Team Member">
                    <h5 class="fw-bold">Nishara de Silva</h5>
                    <p><b>Frontend Developer</b>
                        <br>System Administrator
                        <br>
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/Tharu003" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="https://www.linkedin.com/in/nishara-de-silva-992409329/" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:tharushinishara2003@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div>

            <!--div class="col-md-3">
                <div class="team-card text-center">
                    <img src="../assets\images\Developers\684ec27f3fb39-img.jpg" alt="Team Member">
                    <h5 class="fw-bold">Matheesha Nihari</h5>
                    <p><b>Frontend Developer</b>
                        <br>System Administrator
                        <br>
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/Matheesha-Nihari" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="https://www.linkedin.com/in/matheesha-nihari-4a6913350/" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/share/12KZGoMHc3H/?mibextid=LQQJ4d" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:matheenihari13@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div-->

            <div class="col-md-3">
                <div class="team-card text-center">
                    <img src="assets\images\Developers\amandi.jpg" alt="Team Member">
                    <h5 class="fw-bold">Amandi Kaushalya</h5>
                    <p><b>Frontend Developer</b>
                        <br>System Administrator
                        <br>
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/Amandi-Kaushalya-Dewmini" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="www.linkedin.com/in/amandi-kaushalya-dewmini-4059b5352" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100090649864805&mibextid=ZbWKwL" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:dewmikaushalya112@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div>

            <!--div class="col-md-3">
                <div class="team-card text-center">
                    <img src="../assets\images\Developers\Image 2025-06-15 at 18.38.05_2c0b2056.jpg" alt="Team Member">
                    <h5 class="fw-bold">Ewni Akithma</h5>
                    <p><b>Frontend Developer</b>
                        <br>System Administrator
                        <br>
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="htthttps://github.com/Ewni01" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="http://www.linkedin.com/in/ewniakithma" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/share/19EmESN9qT/?mibextid=wwXIfr" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:ewniakithma@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                    <span class="text-center text-danger"><b>&nbsp;</b></span>
                </div>
            </div-->

            <!-- Team Member 3 -->
            <!--div class="col-md-3">
                <div class="team-card text-center">
                    <img src="../assets\images\Developers\sandeepa.jpg" alt="Team Member">
                    <h5 class="fw-bold">Malith Sandeepa</h5>
                    <p><b>Frontend Developer</b>
                       <br>Quality Assuarance
                        <br>System Administrator
                        &nbsp;</p>
                    <div class="team-icons">
                        <a href="#" target="_blank"><i class="bi bi-globe"></i></a>
                        <a href="https://github.com/KVMSANDEEPA" target="_blank"><i class="bi bi-github"></i></a>
                        <a href="www.linkedin.com/in/malith-sandeepa" target="_blank"><i class="bi bi-linkedin"></i></a>
                        <a href="https://www.facebook.com/profile.php?id=100071177107363" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="mailto:malithsandeepa1081@gmail.com" ><i class="bi bi-envelope"></i></a>
                    </div>
                     <!--span class="text-center text-danger"><b>Not Active</b></span>
                     <span class="text-center text-danger"><b>&nbsp;</b></span-->
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once ("includes/footer2.php") ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php include_once ("includes/js-links-inc.php") ?>

</body>

</html>
