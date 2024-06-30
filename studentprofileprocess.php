<?php
// Including database configuration file
include 'config/DbConfig.php';

// Starting session
session_start();

// Checking if user is logged in
if (isset ($_SESSION['matrixnumber'])) {

    // Retrieving matrix number from session
    $matrixnumber = $_SESSION['matrixnumber'];

    // Querying the database to check if a student exists with the provided matrix number
    $result = mysqli_query($conn, "SELECT * FROM student WHERE matrixnumber='$matrixnumber'");

    // Checking if a student with the given matrix number exists
    $student_matched = mysqli_num_rows($result);

    // If no student is found, redirecting to login page with an error message
    if ($student_matched == 0) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'No student found with matrix number: ' . $matrixnumber;
        header("Location: studentlogin.php");
        exit();
    }

    // Fetching student's details from the database
    $row = mysqli_fetch_assoc($result);
    $_SESSION['fullname'] = $row['fullname'];
    $_SESSION['icnumber'] = $row['icnumber'];
    $_SESSION['numbphone'] = $row['numbphone'];
    $_SESSION['picture'] = $row['picture'];

    // Retrieving academic details from the database
    $result = mysqli_query($conn, "SELECT * FROM academic WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['adm_session'] = $row['adm_session'];
    $_SESSION['year_sem'] = $row['year_sem'];
    $_SESSION['programme'] = $row['programme'];
    $_SESSION['faculty'] = $row['faculty'];
    $_SESSION['campus'] = $row['campus'];

    // Retrieving login details for profile picture from the database
    $result = mysqli_query($conn, "SELECT * FROM login WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['uniszaemail'] = $row['uniszaemail'];

    // Retrieving address details from the database
    $result = mysqli_query($conn, "SELECT * FROM address WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['permanent'] = $row['permanent'];
    $_SESSION['current'] = $row['current'];

    // Retrieving diploma details from the database
    $result = mysqli_query($conn, "SELECT * FROM diploma WHERE matrixnumber='$matrixnumber'");
    $row = mysqli_fetch_assoc($result);
    $_SESSION['prev_inst'] = $row['prev_inst'];
    $_SESSION['prev_prog'] = $row['prev_prog'];
    $_SESSION['file'] = $row['file'];

    // Redirecting to student profile page
    header('Location: studentprofile.php');
}
