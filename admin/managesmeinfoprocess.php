<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $smenum = $_POST['smenum'];
    $smeemail = $kppnum . "@staff.unisza.edu.my";
    $password = $_POST['smepassword'];
    $c_password = $_POST['c_smepassword'];
    $smeID = $_POST['smeID']; // Assuming smeID is passed via the form

    // Check if a file was uploaded
    if (isset($_FILES["smeprofilepicture"]) && !empty($_FILES["smeprofilepicture"]["tmp_name"])) {
        // File upload logic
        $targetDirectory = "../uploads/smeprofilepicture/"; // Directory where you want to store uploaded files
        $targetFileName = $targetDirectory . basename($_FILES["smeprofilepicture"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION));

        // Check if image file is an actual image
        $check = getimagesize($_FILES["smeprofilepicture"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'File is not an image.';
            header('Location: managesmeinfo.php'); // Redirect back to edit SME page
            exit();
        }

        // Check file size
        if ($_FILES["smeprofilepicture"]["size"] > 500000) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Sorry, your file is too large.';
            header('Location: managesmeinfo.php'); // Redirect back to edit SME page
            exit();
        }

        // Allow certain file formats
        $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($imageFileType, $allowedFileTypes)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
            header('Location: managesmeinfo.php'); // Redirect back to edit SME page
            exit();
        }

        // Move uploaded file to desired directory
        if (!move_uploaded_file($_FILES["smeprofilepicture"]["tmp_name"], $targetFileName)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Error uploading file.';
            header('Location: managesmeinfo.php'); // Redirect back to edit SME page
            exit();
        }

        // Update the image path in the database
        $imagePath = basename($_FILES["smeprofilepicture"]["name"]);
        $query = "UPDATE smelogin SET fullname='$fullname', smenum='$smenum', smeprofilepic='$targetFileName' WHERE ID = $smeID";
        mysqli_query($conn, $query);
    } else {
        // No file was uploaded
        // Check if passwords match
        if ($password === $c_password) {
            // Check if other fields have changed
            $query = "SELECT * FROM smelogin WHERE ID = $smeID";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);

            // Update only the fields that have changed
            $updateFields = [];
            if ($fullname !== $row['fullname']) {
                $updateFields[] = "fullname='$fullname'";
            }
            if ($smenum !== $row['smenum']) {
                $updateFields[] = "smenum='$smenum'";
            }
            // Add password update only if it's not empty and has changed
            if (!empty($password) && !password_verify($password, $row['password'])) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $updateFields[] = "password='$hashed_password'";
            }
            if (!empty($updateFields)) {
                $updateString = implode(', ', $updateFields);
                $query = "UPDATE smelogin SET $updateString WHERE ID = $smeID";
                mysqli_query($conn, $query);
            }
        } else {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Passwords do not match.';
            header('Location: managesmeinfo.php'); // Redirect back to edit SME page
            exit();
        }
    }

    $_SESSION['response_type'] = 'success';
    $_SESSION['response_text'] = "Record Information for Sme Name: <strong>$fullname</strong> with Staff ID: <strong>$smenum</strong> has been updated successfully.";
    header("Location: adminhome.php");
    exit();
} else {
    $_SESSION['response_type'] = 'error';
    $_SESSION['response_text'] = "Record Information for Sme Name: <strong>$fullname</strong> with Staff ID: <strong>$smenum</strong> Failed.";

    // Redirect back to the form page
    header("Location: managesmeinfo.php");
    exit();
}
