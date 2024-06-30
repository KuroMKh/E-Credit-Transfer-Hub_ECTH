<?php
// Include the file containing the database configuration
include '../config/DbConfig.php';
// Start a new session
session_start();

// Check if the login form is submitted
if (isset($_POST['login'])) {

    // Get the email and password from the login form
    $smeemail = $_POST['smeemail'] . "@staff.unisza.edu.my";
    $smepassword = $_POST['smepassword'];

    // Check if there is a user with the provided email in the database
    $result = mysqli_query($conn, "SELECT * from smelogin WHERE smeemail='$smeemail'");
    // Check if the user is found
    $sme_matched = mysqli_num_rows($result);
    if ($sme_matched == 0) {
        // If no user found, show an error message and redirect back to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No sme found with email: ' . $smeemail . '';
        header("Location: smelogin.php");
        exit();
    }

    // Get the stored password of the user
    $row = mysqli_fetch_assoc($result);
    $sme_password = $row['password'];


    // If 'Remember Me' option is checked, store username and password in cookies
    if (isset($_POST["remember"])) {
        setcookie("smeemail", $_POST["smeemail"], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("smepassword", $_POST["smepassword"], time() + (10 * 365 * 24 * 60 * 60));
    }

    // Compare the entered password with the stored password
    if (!password_verify($smepassword, $sme_password)) {
        // If passwords don't match, show a warning message and redirect back to the login page
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password does not match.';
        header("Location: smelogin.php");
        exit();
    }

    // Set session variables for the logged-in sme
    $_SESSION['smeID'] = $row['ID'];
    $_SESSION['logged_in_sme'] = $row['smenum'];
    $_SESSION['smeemail'] = $row['smeemail'];
    $_SESSION['smeprofilepic'] = $row['smeprofilepic'];
    header('Location: smehome.php');
}
