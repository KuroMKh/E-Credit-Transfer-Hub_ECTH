<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $smenum = $_POST['smenum'];
    $smeemail = $smenum . "@staff.unisza.edu.my";
    $smepassword = $_POST['smepassword'];
    $c_smepassword = $_POST['c_smepassword'];

    // Check if passwords match
    if ($smepassword !== $c_smepassword) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Passwords do not match.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($smepassword, PASSWORD_DEFAULT);

    // Check if smeemail already exists
    $checkEmailQuery = "SELECT * FROM smelogin WHERE smeemail = '$smeemail'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Email already exists.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // Check if password already exists (this check assumes passwords are not stored in plain text)
    $checkPasswordQuery = "SELECT * FROM smelogin WHERE password = '$hashedPassword'";
    $checkPasswordResult = mysqli_query($conn, $checkPasswordQuery);

    if (mysqli_num_rows($checkPasswordResult) > 0) {
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password already exists.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // File upload handling
    $targetDirectory = "../uploads/smeprofilepicture/"; // Directory where you want to store uploaded files
    $targetFileName = $targetDirectory . basename($_FILES["smeprofilepicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["smeprofilepicture"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'File is not an image.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // Check file size
    if ($_FILES["smeprofilepicture"]["size"] > 500000) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, your file is too large.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // Allow certain file formats
    $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFileTypes)) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }

    // Move uploaded file to desired directory
    if (move_uploaded_file($_FILES["smeprofilepicture"]["tmp_name"], $targetFileName)) {
        // Insert data into the database
        $query = "INSERT INTO smelogin (smenum, fullname, smeemail, password,smeprofilepic) VALUES ('$smenum','$fullname','$smeemail', '$hashedPassword', '$targetFileName')";

        if (mysqli_query($conn, $query)) {
            // Insertion successful, you can redirect or display a success message
            $_SESSION['response_type'] = 'success';
            $_SESSION['response_text'] = 'sme created successfully.';
            header('Location: createsme.php'); // Redirect to admin home page
            exit();
        } else {
            // Insertion failed, you can display an error message
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Failed to create sme. Please try again.';
            header('Location: createsmep.php'); // Redirect back to create sme page
            exit();
        }
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, there was an error uploading your file.';
        header('Location: createsme.php'); // Redirect back to create sme page
        exit();
    }
}
