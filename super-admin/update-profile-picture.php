<?php
session_start();
require_once '../includes/db-conn.php'; 

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['admin_id'];
    
    // Handle file upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = $_FILES['profile_picture']['name'];
        $fileSize = $_FILES['profile_picture']['size'];
        $fileType = $_FILES['profile_picture']['type'];
        
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($fileType, $allowedTypes)) {
            // Generate a unique filename to prevent overwriting
            $newFileName = uniqid() . '-' . basename($fileName);
            $uploadDir = 'uploads/';
            $destPath = $uploadDir . $newFileName;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                // Update the database with the new profile picture
                $sql = "UPDATE admins SET profile_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $newFileName, $user_id);
                if ($stmt->execute()) {
                    $_SESSION['status'] = 'success';
                    $_SESSION['message'] = 'Profile picture updated successfully!';
                } else {
                    $_SESSION['status'] = 'error';
                    $_SESSION['message'] = 'Error updating profile picture.';
                }
                $stmt->close();
            } else {
                $_SESSION['status'] = 'error';
                $_SESSION['message'] = 'Error uploading the image.';
            }
        } else {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Only JPG, PNG, or GIF files are allowed.';
        }
    } else {
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Please select an image to upload.';
    }

    header("Location: user-profile.php"); // Redirect back to the profile page
    exit();
}
?>
