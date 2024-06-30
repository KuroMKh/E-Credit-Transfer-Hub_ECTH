<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $kppnum = $_POST['kppnum'];
    $kppemail = $kppnum . "@staff.unisza.edu.my";
    $kpppassword = $_POST['kpppassword'];
    $c_kpppassword = $_POST['c_kpppassword'];

    // Check if passwords match
    if ($kpppassword !== $c_kpppassword) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Passwords do not match.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($kpppassword, PASSWORD_DEFAULT);

    // Check if kppemail already exists
    $checkEmailQuery = "SELECT * FROM kpplogin WHERE kppemail = '$kppemail'";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Email already exists.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // Check if password already exists (this check assumes passwords are not stored in plain text)
    $checkPasswordQuery = "SELECT * FROM kpplogin WHERE password = '$hashedPassword'";
    $checkPasswordResult = mysqli_query($conn, $checkPasswordQuery);

    if (mysqli_num_rows($checkPasswordResult) > 0) {
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password already exists.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // File upload handling
    $targetDirectory = "../uploads/kppprofilepicture/"; // Directory where you want to store uploaded files
    $targetFileName = $targetDirectory . basename($_FILES["kppprofilepicture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFileName, PATHINFO_EXTENSION));

    // Check if image file is an actual image
    $check = getimagesize($_FILES["kppprofilepicture"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'File is not an image.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // Check file size
    if ($_FILES["kppprofilepicture"]["size"] > 500000) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, your file is too large.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // Allow certain file formats
    $allowedFileTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedFileTypes)) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }

    // Move uploaded file to desired directory
    if (move_uploaded_file($_FILES["kppprofilepicture"]["tmp_name"], $targetFileName)) {
        // Insert data into the database
        $query = "INSERT INTO kpplogin (kppnum, fullname, kppemail, password, kppprofilepic) VALUES ('$kppnum','$fullname','$kppemail', '$hashedPassword', '$targetFileName')";

        if (mysqli_query($conn, $query)) {
            // Insertion successful, you can redirect or display a success message
            $_SESSION['response_type'] = 'success';
            $_SESSION['response_text'] = 'KPP created successfully.';
            header('Location: createkpp.php'); // Redirect to admin home page
            exit();
        } else {
            // Insertion failed, you can display an error message
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Failed to create KPP. Please try again.';
            header('Location: createkpp.php'); // Redirect back to create KPP page
            exit();
        }
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Sorry, there was an error uploading your file.';
        header('Location: createkpp.php'); // Redirect back to create KPP page
        exit();
    }
}
