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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Development Team - MediQ</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php include_once ("../includes/css-links-inc.php"); ?>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --info: #4895ef;
            --warning: #f72585;
            --danger: #e63946;
            --light: #f8f9fa;
            --dark: #212529;
        }
        
        .page-title {
            color: #343a40;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .breadcrumb-item a:hover {
            color: var(--secondary);
        }
        
        .team-section {
            padding: 20px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .section-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 1rem;
        }
        
        .section-title p {
            color: #6c757d;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .team-card {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            text-align: center;
            margin-bottom: 2rem;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid rgba(67, 97, 238, 0.1);
            height: 100%;
        }
        
        .team-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .team-card img {
            border-radius: 50%;
            width: 180px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .team-card:hover img {
            border-color: var(--primary);
        }
        
        .team-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #343a40;
        }
        
        .team-card h4 {
            font-size: 1.1rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }
        
        .team-card .role {
            font-size: 1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
            padding: 0.4rem 1rem;
            background: rgba(67, 97, 238, 0.1);
            border-radius: 20px;
            display: inline-block;
        }
         .team-card img {
    border-radius: 50%;
    width: 230px;
    height: 230px;
    object-fit: cover;
    margin-bottom: 15px;
}
  
        
        .team-card p {
            color: #6c757d;
            margin-bottom: 1.5rem;
            min-height: 72px;
        }
        
        .team-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 1.5rem;
        }
        
        .team-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            color: #495057;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .team-icons a:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        .status-badge {
            display: block;
            margin-top: 10px;
            font-size: 0.85rem;
        }
        
        .dev-footer {
            text-align: center;
            margin-top: 4rem;
            padding: 2rem;
            background: #f8f9fa;
            border-radius: 12px;
        }
        
        .dev-footer p {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }
        
        .dev-footer a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s;
        }
        
        .dev-footer a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .section-title h1 {
                font-size: 2rem;
            }
            
            .team-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

<?php include_once("../includes/header.php") ?>
<?php include_once("../includes/sadmin-sidebar.php") ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1 class="page-title">Development Team</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Development Team</li>
            </ol>
        </nav>
    </div>

    <section class="team-section">
        <div class="container">
            <div class="section-title">
                <h1>Our Development Team</h1>
                <p>The talented individuals who brought MediQ to life with their expertise and dedication</p>
            </div>
            
            <div class="row justify-content-center">
                <!-- Team Member 1 -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card">
                        <img src="../assets/images/Developers/malitha3.jpg" alt="Malitha Tishmal">
                        <h3>Malitha Tishmal</h3>
                        <h4>Lucifer23</h4>
                        <span class="role">Full Stack Developer</span>
                        <p>Lead developer with expertise in both frontend and backend technologies</p>
                        <div class="team-icons">
                            <a href="https://malithatishamal.42web.io" target="_blank" title="Portfolio">
                                <i class="bi bi-globe"></i>
                            </a>
                            <a href="https://github.com/malitha-tishamal" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://www.facebook.com/malitha.tishamal" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="mailto:malithatishamal@gmail.com" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 2 -->
                <!--div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card">
                        <img src="../assets/images/Developers/684c0f0cbbca3-1.jpg" alt="Malith Sandeepa">
                        <h3>Malith Sandeepa</h3>
                        <h4>KVMSANDEEPA</h4>
                        <span class="role">Frontend Developer</span>
                        <p>Specializes in creating responsive and user-friendly interfaces with quality assurance</p>
                        <div class="team-icons">
                            <a href="#" target="_blank" title="Portfolio">
                                <i class="bi bi-globe"></i>
                            </a>
                            <a href="https://github.com/KVMSANDEEPA" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="www.linkedin.com/in/malith-sandeepa" target="_blank" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=100071177107363" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="mailto:malithsandeepa1081@gmail.com" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 3 -->
                <!--div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card">
                        <img src="../assets/images/Developers/tharidu.jpg" alt="Tharindu Sampath">
                        <h3>Tharindu Sampath</h3>
                        <h4>VgTharindu</h4>
                        <span class="role">Frontend Developer</span>
                        <p>Focuses on creating intuitive user experiences and system administration</p>
                        <div class="team-icons">
                            <a href="#" target="_blank" title="Portfolio">
                                <i class="bi bi-globe"></i>
                            </a>
                            <a href="https://github.com/VgTharindu" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/vg-tharindu-0b0158272?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://www.facebook.com/share/1Dd22cM9oN/" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="mailto:vgtharindu165@gmail.com" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 4 -->
                <!--div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card">
                        <img src="../assets/images/Developers/nishara.jpg" alt="Nishara de Silva">
                        <h3>Nishara de Silva</h3>
                        <h4>Tharu003</h4>
                        <span class="role">Frontend Developer</span>
                        <p>Creates engaging user interfaces with attention to detail and system administration</p>
                        <div class="team-icons">
                            <a href="#" target="_blank" title="Portfolio">
                                <i class="bi bi-globe"></i>
                            </a>
                            <a href="https://github.com/Tharu003" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/nishara-de-silva-992409329/" target="_blank" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="mailto:tharushinishara2003@gmail.com" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Team Member 5 -->
                <!--div class="col-lg-4 col-md-6 mb-4">
                    <div class="team-card">
                        <img src="../assets/images/Developers/amandi.jpg" alt="Amandi Kaushalya">
                        <h3>Amandi Kaushalya</h3>
                        <h4>Amandi-Kaushalya</h4>
                        <span class="role">Frontend Developer</span>
                        <p>Specializes in responsive design and creating user-friendly system interfaces</p>
                        <div class="team-icons">
                            <a href="#" target="_blank" title="Portfolio">
                                <i class="bi bi-globe"></i>
                            </a>
                            <a href="https://github.com/Amandi-Kaushalya-Dewmini" target="_blank" title="GitHub">
                                <i class="bi bi-github"></i>
                            </a>
                            <a href="www.linkedin.com/in/amandi-kaushalya-dewmini-4059b5352" target="_blank" title="LinkedIn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://www.facebook.com/profile.php?id=100090649864805&mibextid=ZbWKwL" target="_blank" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="mailto:dewmikaushalya112@gmail.com" title="Email">
                                <i class="bi bi-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div-->
            
            <div class="dev-footer">
                <p>MediQ - Antibiogram Analyze System</p>
                <p>© 2025 MediQ. All rights reserved.</p>
                <p>For technical support, contact: <a href="malithatishamal@gmail.com">DevLK-Team</a></p>
            </div>
        </div>
    </section>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<?php include_once("../includes/js-links-inc.php") ?>

</body>

</html>