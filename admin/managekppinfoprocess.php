<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $kppnum = $_POST['kppnum'];
    $kppemail = $kppnum . "@staff.unisza.edu.my";
    $password = $_POST['kpppassword'];
    $c_password = $_POST['c_kpppassword'];
    $kppID = $_POST['kppID']; // Assuming kppID is passed via the form

    // Check if a file was uploaded
    if (isset($_FILES["kppprofilepicture"]) && !empty($_FILES["kppprofilepicture"]["tmp_name"])) {
        // File upload logic

        $targetDirectory = "../uploads/kppprofilepicture/"; // Directory where you want to store uploaded files
        $targetFileName = $targetDirectory . basename($_FILES["kppprofilepicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["kppprofilepicture"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'File is not an image.';
            header('Location: managekppinfo.php'); // Redirect back to edit KPP page
            exit();
        }

        // Check file size
        if ($_FILES["kppprofilepicture"]["size"] > 500000) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Sorry, your file is too large.';
            header('Location: managekppinfo.php'); // Redirect back to edit KPP page
            exit();
        }

        // Allow certain file formats
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFileTypes)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            header('Location: managekppinfo.php'); // Redirect back to edit KPP page
            exit();
        }

        // Move uploaded file to desired directory
        if (!move_uploaded_file($_FILES["kppprofilepicture"]["tmp_name"], $targetFileName)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Error uploading file.';
            header('Location: managekppinfo.php'); // Redirect back to edit KPP page
            exit();
        }

        // Update the image path in the database
        $imagePath = basename($_FILES["kppprofilepicture"]["name"]);
        $query = "UPDATE kpplogin SET fullname='$fullname', kppnum='$kppnum', kppprofilepic='$targetFileName' WHERE ID = $kppID";
        mysqli_query($conn, $query);
    } else {
        // No file was uploaded
        // Check if passwords match
        if ($password === $c_password) {
            // Check if other fields have changed
            $query = "SELECT * FROM kpplogin WHERE ID = $kppID";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // Update only the fields that have changed
            $updateFields = [];
            if ($fullname !== $row['fullname']) {
                $updateFields[] = "fullname='$fullname'";
            }
            if ($kppnum !== $row['kppnum']) {
                $updateFields[] = "kppnum='$kppnum'";
            }
            // Add password update only if it's not empty and has changed
            if (!empty($password) && $password !== $row['password']) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $updateFields[] = "password='$hashed_password'";
            }
            if (!empty($updateFields)) {
                $updateString = implode(', ', $updateFields);
                $query = "UPDATE kpplogin SET $updateString WHERE ID = $kppID";
                mysqli_query($conn, $query);
            }
        } else {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Passwords do not match.';
            header('Location: managekppinfo.php'); // Redirect back to edit KPP page
            exit();
        }
    }

    $_SESSION['response_type'] = 'success';
    $_SESSION['response_text'] = "Record Information for Kpp Name: <strong>$fullname</strong> with Staff ID: <strong>$kppnum</strong> has been updated successfully.";
    exit();
} else {
    $_SESSION['response_type'] = 'error';
    $_SESSION['response_text'] = "Record Information for Kpp Name: <strong>$fullname</strong> with Staff ID: <strong>$kppnum</strong> Failed.";

    // Redirect back to the form page
    header("Location: managekppinfo.php");
    exit();
}
