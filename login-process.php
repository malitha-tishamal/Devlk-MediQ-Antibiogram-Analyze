<?php
session_start();
require_once 'includes/db-conn.php'; // Ensure database connection

// Set timezone to Sri Lanka
date_default_timezone_set('Asia/Colombo');
$conn->query("SET time_zone = '+05:30'");

// Initialize login attempts
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_stage'] = 0;
    $_SESSION['last_attempt_time'] = time();
}

// Lockout durations (in seconds)
$lockout_durations = [5 * 60, 10 * 60, 20 * 60, 60 * 60]; // 5m, 10m, 20m, 60m

// Check if locked out
if ($_SESSION['login_attempts'] >= 3) {
    $stage = $_SESSION['lockout_stage'];
    $timeout = $lockout_durations[$stage] ?? end($lockout_durations);
    $remaining = ($_SESSION['last_attempt_time'] + $timeout) - time();

    if ($remaining > 0) {
        $_SESSION['error_message'] = "Too many failed attempts. Try again in " . ceil($remaining / 60) . " minute(s).";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lockout_stage'] += 1;
    }
}

if (isset($_POST['submit'])) {
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];

    // === Check in Admins ===
    $sql_admin = "SELECT * FROM admins WHERE email = ?";
    if ($stmt = $conn->prepare($sql_admin)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        if ($admin && password_verify($password, $admin['password'])) {
            if ($admin['status'] == 'approved') {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['success_message'] = "Welcome Admin!";
                $_SESSION['login_attempts'] = 0;
                $_SESSION['lockout_stage'] = 0;

                // Update last login
                $current_time = date("Y-m-d H:i:s");
                $update = $conn->prepare("UPDATE admins SET last_login = ? WHERE id = ?");
                $update->bind_param("si", $current_time, $admin['id']);
                $update->execute();

                header("Location: super-admin/user-profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Your account has not been approved yet.";
                header("Location: index.php");
                exit();
            }
        }
    }

    // === Check in Users ===
    $sql_user = "SELECT * FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql_user)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] == 'approved') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['success_message'] = "Welcome back! You're logged in.";
                $_SESSION['login_attempts'] = 0;
                $_SESSION['lockout_stage'] = 0;

                // Update last login
                $current_time = date("Y-m-d H:i:s");
                $update = $conn->prepare("UPDATE users SET last_login = ? WHERE id = ?");
                $update->bind_param("si", $current_time, $user['id']);
                $update->execute();

                header("Location: user-profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Your account has not been approved yet.";
                header("Location: index.php");
                exit();
            }
        }
    }

    // === If login fails ===
    $_SESSION['login_attempts'] += 1;
    $_SESSION['last_attempt_time'] = time();

    if ($_SESSION['login_attempts'] % 3 == 0) {
        $_SESSION['lockout_stage'] += 1;
    }

    $_SESSION['error_message'] = "Invalid email or password.";
    header("Location: index.php");
    exit();
}
?>
