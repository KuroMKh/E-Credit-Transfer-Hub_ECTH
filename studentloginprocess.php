<?php

// Include the file containing the database configuration
include 'config/DbConfig.php';

// Start a new session
session_start();

// Check if the login form is submitted
if (isset($_POST['login'])) {

    // Get the email and password from the login form
    $uniszaemail = $_POST['uniszaemail'] . "@putra.unisza.edu.my";
    $password = $_POST['password'];

    // Check if there is a user with the provided email in the database
    $result = mysqli_query($conn, "SELECT * from login WHERE uniszaemail='$uniszaemail'");
    // Check if the user is found
    $student_matched = mysqli_num_rows($result);
    if ($student_matched == 0) {
        // If no user found, show an error message and redirect back to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No student found with email: ' . $uniszaemail . '';
        header("Location: studentlogin.php");
        exit();
    }

    // Get the stored password of the user
    $row = mysqli_fetch_assoc($result);
    $student_password = $row['password'];

    // If 'Remember Me' option is checked, store username and password in cookies
    if (!empty($_POST["remember"])) {
        setcookie("studmatrix", $_POST["uniszaemail"], time() + (10 * 365 * 24 * 60 * 60));
        setcookie("studpassword", $_POST["password"], time() + (10 * 365 * 24 * 60 * 60));
    }

    // Compare the entered password with the stored password
    if (!password_verify($password, $student_password)) {
        // If passwords don't match, show a warning message and redirect back to the login page
        $_SESSION['response_type'] = 'warning';
        $_SESSION['response_text'] = 'Password does not match.';
        header("Location: studentlogin.php");
        exit();
    }

    // Set session variables for the logged-in user
    $_SESSION['logged_in_user'] = $row['studID'];
    $_SESSION['matrixnumber'] = $row['matrixnumber'];
    $_SESSION['academic_id'] = $row['academic_id'];
    $_SESSION['response_type'] = 'success';
    $_SESSION['response_text'] = 'Welcome, ' . $uniszaemail . '!';

    // Get additional information about the student from the 'student' table
    $matrixnumber = $_SESSION['matrixnumber'];
    $result = mysqli_query($conn, "SELECT * from student WHERE matrixnumber='$matrixnumber'");
    $student_matched = mysqli_num_rows($result);
    if ($student_matched == 0) {
        // If student information not found, show an error message and redirect back to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No student found with email: ' . $uniszaemail . '';
        header("Location: studentlogin.php");
        exit();
    }

    // Store student information in session variables
    $row = mysqli_fetch_assoc($result);
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['icnumber'] = $row['icnumber'];
    $_SESSION['numbphone'] = $row['numbphone'];
    $_SESSION['picture'] = $row['picture'];
    $_SESSION['status'] = $row['status'];

    // Get academic information about the student
    $result = mysqli_query($conn, "SELECT * from academic WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['adm_session'] = $row['adm_session'];
    $_SESSION['year_sem'] = $row['year_sem'];
    $_SESSION['programme'] = $row['programme'];
    $_SESSION['faculty'] = $row['faculty'];
    $_SESSION['campus'] = $row['campus'];

    // Get the student's email from the 'login' table
    $result = mysqli_query($conn, "SELECT * from login WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['uniszaemail'] = $row['uniszaemail'];

    // Get address information of the student
    $result = mysqli_query($conn, "SELECT * from address WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['permanent'] = $row['permanent'];
    $_SESSION['current'] = $row['current'];

    // Get previous diploma information of the student
    $result = mysqli_query($conn, "SELECT * from diploma WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['prev_inst'] = $row['prev_inst'];
    $_SESSION['prev_prog'] = $row['prev_prog'];
    $_SESSION['file'] = $row['file'];

    $result = mysqli_query($conn, "SELECT * from degcourse WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['uniszacoursecode'] = $row['uniszacoursecode'];
    $_SESSION['uniszacoursename'] = $row['uniszacoursename'];
    $_SESSION['uniszacredithour'] = $row['uniszacredithour'];

    $result = mysqli_query($conn, "SELECT * from dipcourse WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['dipcoursecode'] = $row['dipcoursecode'];
    $_SESSION['dipcoursename'] = $row['dipcoursename'];
    $_SESSION['dipcredithour'] = $row['dipcredithour'];
    $_SESSION['dipgrade'] = $row['dipgrade'];
    $_SESSION['dipfile'] = $row['dipfile'];


    // Redirect to the home page after successful login
    header('Location: Home.php');
}
