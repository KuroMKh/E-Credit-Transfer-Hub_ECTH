<?php
// Include the file containing the database configuration
include '../config/DbConfig.php';
// Start a new session
session_start();

// Check if the login form is submitted
if (isset($_POST['login'])) {

    // Get the email and password from the login form
    $adminemail = $_POST['adminemail'] . "@staff.unisza.edu.my";
    $adminpassword = $_POST['adminpassword'];

    // Check if there is a user with the provided email in the database
    $result = mysqli_query($conn, "SELECT * from admin WHERE adminemail='$adminemail'");
    // Check if the user is found
    $admin_matched = mysqli_num_rows($result);
    if ($admin_matched == 0) {
        // If no user found, show an error message and redirect back to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No admin found with email: ' . $adminemail . '';
        header("Location: adminlogin.php");
        exit();
    }

    // Get the stored password of the user
    $row = mysqli_fetch_assoc($result);
    $admin_password = $row['password'];


    // If 'Remember Me' option is checked, store username and password in cookies
    if (isset($_POST["remember"])) {
        setcookie("adminemail", $_POST["adminemail"], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("adminpassword", $_POST["adminpassword"], time() + (10 * 365 * 24 * 60 * 60));
    }

    // Compare the entered password with the stored password
    if (!password_verify($adminpassword, $admin_password)) {
        // If passwords don't match, show a warning message and redirect back to the login page
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password does not match.';
        header("Location: adminlogin.php");
        exit();
    }

    // Set session variables for the logged-in kpp
    $_SESSION['logged_in_admin'] = $row['adminnum'];
    $_SESSION['adminemail'] = $row['adminemail'];



    header('Location: adminhome.php');
}
