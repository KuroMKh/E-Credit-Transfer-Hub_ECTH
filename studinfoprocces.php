<?php
// Include the database configuration file and start a session
include 'config/DbConfig.php';
session_start();

// Check if the submit button is pressed
if (isset($_POST['submit'])) {

    // Check if the user is logged in
    if (isset($_SESSION['logged_in_user'])) {

        // Check if the user has a profile picture
        if (empty($_SESSION['picture'])) {
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = 'You must upload a profile picture before updating your information.';
            header('Location: studinfo.php');
            exit();
        }
        // Check if the user has uploaded a transcript
        /*if (empty($_SESSION['file'])) {
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = 'Transcript file is required before updating.';
            header('Location: studinfo.php');
            exit();
        }*/

        // Initialize or retrieve the update count and timestamps from the session
        $updateCount = isset($_SESSION['update_count']) ? $_SESSION['update_count'] : 0;
        $updateTimestamps = isset($_SESSION['update_timestamps']) ? $_SESSION['update_timestamps'] : [];

        // Check if the user has reached the update limit
        $maxUpdates = 3; // Maximum allowed updates
        if ($updateCount >= $maxUpdates) {
            $cooldownDuration = 120; // Cooldown period in seconds (2 minutes)
            $timeSinceLastUpdate = time() - end($updateTimestamps);

            // If cooldown period hasn't passed, display an error message
            if ($timeSinceLastUpdate < $cooldownDuration) {
                $_SESSION['response_type'] = 'warning';
                $_SESSION['response_text'] = 'You have reached the update limit. Please wait ' . ($cooldownDuration - $timeSinceLastUpdate) . ' seconds before updating again.';
                header('Location: studinfo.php');
                exit();
            } else {
                // If cooldown period has passed, reset the update count
                $updateCount = 0;
                $_SESSION['update_count'] = $updateCount;
            }
        }

        // Retrieve data from the form
        $fullname = $_POST['fullname'];
        $matrixnumber = $_POST['matrixnumber'];
        $icnumber = $_POST['icnumber'];
        $numbphone = $_POST['numbphone'];
        $adm_session = $_POST['adm_session'];
        $acad_yearsem = $_POST['year_sem'];
        $programme = $_POST['programme'];
        $faculty = $_POST['faculty'];
        $campus = $_POST['campus'];
        $perm_address = $_POST['perm_address'];
        $curr_address = $_POST['curr_address'];
        $prev_inst = $_POST['prev_inst'];
        $prev_prog = $_POST['prev_prog'];

        // Set the target directory for file uploads
        $targetDirectory = "uploads/transcript/";
        $targetFile = $targetDirectory . basename($_FILES["pdf_file"]["name"]);
        $uploadOk = 1;

        // Check if the matrix number already exists in the database
        $check_matrix_query = "SELECT matrixnumber FROM student WHERE matrixnumber = '$matrixnumber'";
        $result_check_matrix = mysqli_query($conn, $check_matrix_query);

        // If matrix number doesn't exist, show a warning and redirect
        if (mysqli_num_rows($result_check_matrix) == 0) {
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = 'Matrix number does not exist.';
            header('Location: studinfo.php');
            exit();
        }

        // Check file type and size for uploaded PDF file
        if ($_FILES["pdf_file"]["size"] > 0) {
            $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // If file type is not PDF or size exceeds 10MB, show an error and redirect
            if ($fileType != "pdf" || $_FILES["pdf_file"]["size"] > 10000000) {
                $_SESSION['response_type'] = 'error';
                $_SESSION['response_text'] = 'Only PDF files are allowed, and the file size should be less than 10MB.';
                header('Location: studinfo.php');
                exit();
            }

            // If the file already exists, delete it
            if (file_exists($targetFile)) {
                unlink($targetFile);
            }

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFile)) {
                // Update diploma data in the database with the new file information
                $result_diploma = mysqli_query($conn, "UPDATE diploma SET prev_inst='$prev_inst', prev_prog='$prev_prog', file='$targetFile' WHERE matrixnumber='$matrixnumber'");
            } else {
                $_SESSION['response_type'] = 'error';
                $_SESSION['response_text'] = 'Error uploading file.';
                header('Location: studinfo.php');
                exit();
            }
        } else {
            // If no file is uploaded, update other data without changing the file information
            $result_diploma = mysqli_query($conn, "UPDATE diploma SET prev_inst='$prev_inst', prev_prog='$prev_prog' WHERE matrixnumber='$matrixnumber'");
        }

        // Update student data in the database
        $result_student = mysqli_query($conn, "UPDATE student SET fullname = '$fullname', icnumber = '$icnumber', numbphone = '$numbphone' WHERE matrixnumber = '$matrixnumber'");

        // Update academic data in the database
        $result_academic = mysqli_query($conn, "UPDATE academic SET adm_session='$adm_session', year_sem='$acad_yearsem', programme='$programme', faculty='$faculty', campus='$campus' WHERE matrixnumber='$matrixnumber'");

        // Update address data in the database
        $result_address = mysqli_query($conn, "UPDATE address SET permanent='$perm_address', current='$curr_address' WHERE matrixnumber='$matrixnumber'");

        // Check if all updates were successful
        if ($result_student && $result_academic && $result_address && $result_diploma) {
            $_SESSION['response_type'] = 'success';
            $_SESSION['response_text'] = 'Data submitted successfully.';
        } else {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Error inserting data into the database. Please try again.';
        }

        // Update the timestamp and count in the session
        $updateCount++;
        $updateTimestamps[] = time();
        $_SESSION['update_count'] = $updateCount;
        $_SESSION['update_timestamps'] = $updateTimestamps;

        // Set a session variable to indicate the form submission
        $_SESSION['form_submitted'] = true;

        // Redirect to the student information page
        header('Location: studinfo.php');
        exit();

    } else {
        // If the user is not logged in, show an error and redirect to the login page
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'User not logged in.';
        header('Location: studentlogin.php');
        exit();
    }
}

