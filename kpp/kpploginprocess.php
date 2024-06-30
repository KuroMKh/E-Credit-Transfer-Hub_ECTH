<?php
// Include the file containing the database configuration
include '../config/DbConfig.php';
// Start a new session
session_start();

// Check if the login form is submitted
if (isset($_POST['login'])) {

    // Get the email and password from the login form
    $kppemail = $_POST['kppemail'] . "@staff.unisza.edu.my";
    $kpppassword = $_POST['kpppassword'];

    // Check if there is a user with the provided email in the database
    $result = mysqli_query($conn, "SELECT * from kpplogin WHERE kppemail='$kppemail'");
    // Check if the user is found
    $kpp_matched = mysqli_num_rows($result);
    if ($kpp_matched == 0) {
        // If no user found, show an error message and redirect back to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No kpp found with email: ' . $kppemail . '';
        header("Location: kpplogin.php");
        exit();
    }

    // Get the stored password of the user
    $row = mysqli_fetch_assoc($result);
    $kpp_password = $row['password'];


    // If 'Remember Me' option is checked, store username and password in cookies
    if (isset($_POST["remember"])) {
        setcookie("kppemail", $_POST["kppemail"], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("kpppassword", $_POST["kpppassword"], time() + (10 * 365 * 24 * 60 * 60));
    }

    // Compare the entered password with the stored password
    if (!password_verify($kpppassword, $kpp_password)) {
        // If passwords don't match, show a warning message and redirect back to the login page
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password does not match.';
        header("Location: kpplogin.php");
        exit();
    }

    // Set session variables for the logged-in kpp
    $_SESSION['logged_in_kpp'] = $row['kppnum'];
    $_SESSION['kppemail'] = $row['kppemail'];
    $_SESSION['kppprofilepic'] = $row['kppprofilepic'];


    header('Location: kpphome.php');
}
