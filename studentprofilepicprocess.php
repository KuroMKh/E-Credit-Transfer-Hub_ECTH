<?php
// Including database configuration
include 'config/DbConfig.php';

// Starting session for the user
session_start();

// Handling form submission
if (isset($_POST['submit'])) {
    // Fetching user's matrix number from session
    $matrixnumber = $_SESSION['matrixnumber'];

    // Checking if a new profile image has been uploaded
    if (isset($_FILES['newProfileImage']) && $_FILES['newProfileImage']['error'] === UPLOAD_ERR_OK) {

        // Validating file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png'];
        $file_type = $_FILES['newProfileImage']['type'];

        // Making sure the uploaded file is an image (JPEG, JPG, or PNG)
        if (!in_array($file_type, $allowed_types)) {
            // Handling case where an invalid file type is uploaded
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = 'Invalid file type. Only JPEG, JPG, and PNG are allowed.';
            header("Location: studentprofile.php");
            exit();
        }

        // Generating a unique filename for the uploaded image
        $timestamp = time();
        $file_extension = pathinfo($_FILES['newProfileImage']['name'], PATHINFO_EXTENSION);
        $filename = "profile_" . $matrixnumber . "_" . $timestamp . "." . $file_extension;

        // Specifying the directory where the image will be stored
        $upload_directory = 'uploads/profilepicture/';
        $target_path = $upload_directory . $filename;

        // Moving the uploaded file to the destination directory
        if (move_uploaded_file($_FILES['newProfileImage']['tmp_name'], $target_path)) {
            // Updating the user's profile image in the session
            $_SESSION['picture'] = $target_path;

            // Updating the database with the new profile image path
            $updateQuery = "UPDATE student SET picture = '$target_path' WHERE matrixnumber = '$matrixnumber'";
            $result = mysqli_query($conn, $updateQuery);

            // Checking if the database update was successful
            if ($result) {
                // Displaying success message if the update was successful
                $_SESSION['response_type'] = 'success';
                $_SESSION['response_text'] = 'Profile picture updated successfully.';
                header("Location: studentprofile.php");
                exit();
            } else {
                // Displaying error message if the database update failed
                $_SESSION['response_type'] = 'error';
                $_SESSION['response_text'] = 'Error updating the database.';
                header("Location: studentprofile.php");
                exit();
            }
        } else {
            // Handling case where file upload fails
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Error uploading the file.';
            header("Location: studentprofile.php");
            exit();
        }
    }
}

// Redirecting back to the profile page if no changes were made or an error occurred
header("Location: studentprofile.php");
exit();
