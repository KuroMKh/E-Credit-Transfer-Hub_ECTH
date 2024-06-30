<?php
include 'config/DbConfig.php';
session_start();

// Checking if form is submitted
if (isset($_POST['submit'])) {
    // Checking if user is logged in
    if (isset($_SESSION['matrixnumber'])) {
        // Retrieving form data
        $matrixnumber = $_SESSION['matrixnumber'];
        $uniszacoursecode = $_POST['uniszacoursecode'];
        $uniszacoursename = $_POST['uniszacoursename'];
        $uniszacredithour = $_POST['uniszacredithour'];
        $dipcoursecode = $_POST['dipcoursecode'];
        $dipcoursename = $_POST['dipcoursename'];
        $dipcredithour = $_POST['dipcredithour'];
        $dipgrade = $_POST['dipgrade'];
        $dipfile = $_FILES['dipfile'];

        // Loop through the arrays to insert multiple data at once for degree course
        foreach ($uniszacoursecode as $key => $value) {
            // Inserting data into degree course table
            $degcourseQuery = "INSERT INTO degcourse (matrixnumber, uniszacoursecode, uniszacoursename, uniszacredithour) VALUES ('$matrixnumber','$value', '{$uniszacoursename[$key]}', '{$uniszacredithour[$key]}')";
            $degcourseResult = mysqli_query($conn, $degcourseQuery);
            if (!$degcourseResult) {
                // Setting error message for degree course insertion failure
                $_SESSION['response_type'] = 'error';
                $_SESSION['response_text'] = 'Error inserting degree course data into the database. Please try again.';
                header('Location: courseapp.php');
                exit();
            }
        }
        // Loop through the arrays to insert multiple data at once for diploma course
        foreach ($dipcoursecode as $key => $value) {
            // Checking if file is uploaded
            if ($dipfile['size'][$key] > 0) {
                // Defining target directory and file
                $targetDirectory = "uploads/dipdci/";
                $targetFile = $targetDirectory . basename($dipfile['name'][$key]);

                // Moving uploaded file to target directory
                if (move_uploaded_file($dipfile['tmp_name'][$key], $targetFile)) {
                    // Inserting data into diploma course table
                    $dipcourseQuery = "INSERT INTO dipcourse (matrixnumber, dipcoursecode, dipcoursename, dipcredithour, dipgrade, dipfile) VALUES ('$matrixnumber','$value', '{$dipcoursename[$key]}', '{$dipcredithour[$key]}', '{$dipgrade[$key]}', '$targetFile')";

                    $dipcourseResult = mysqli_query($conn, $dipcourseQuery);
                    if (!$dipcourseResult) {
                        // Setting error message for diploma course insertion failure
                        $_SESSION['response_type'] = 'error';
                        $_SESSION['response_text'] = 'Error inserting diploma course data into the database. Please try again.';
                        header('Location: courseapp.php');
                        exit();
                    }
                } else {
                    // Setting error message for file upload failure and redirecting
                    $_SESSION['response_type'] = 'error';
                    $_SESSION['response_text'] = 'Error uploading file.';
                    header('Location: courseapp.php');
                    exit();
                }
            }
        }


        // Setting success message
        $_SESSION['response_type'] = 'success';
        $_SESSION['response_text'] = 'Transfer request submitted.';
        header('Location: courseapp.php');
        exit();
    }
}
