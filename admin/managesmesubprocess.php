<?php
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if smeID and subject are set
    if (isset($_POST['smeID']) && isset($_POST['subject'])) {
        // Get the smeID and subject from the form
        $smeID = $_POST['smeID'];
        $subject = $_POST['subject'];

        // Validate the input
        if (!empty($smeID) && !empty($subject)) {
            // Explode the subject into two parts using the '-' delimiter
            $subject_parts = explode('-', $subject);

            // Trim whitespace from the parts
            $subjectCode = trim($subject_parts[0]);
            $subjectName = trim($subject_parts[1]);

            // Escape special characters to prevent SQL injection
            $smeID = mysqli_real_escape_string($conn, $smeID);
            $subjectCode = mysqli_real_escape_string($conn, $subjectCode);
            $subjectName = mysqli_real_escape_string($conn, $subjectName);

            // Prepare the SQL query to check for existing records
            $check_query = "SELECT * FROM smesubject WHERE smeID = '$smeID' AND subject = '$subjectCode'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                $_SESSION['response_type'] = 'warning';
                $_SESSION['response_text'] = 'Subject already registered for this SME.';
            } else {
                // Prepare the SQL query to insert data into the smesubjects table
                $insert_query = "INSERT INTO smesubject (smeID, subject, subjectname) VALUES ('$smeID', '$subjectCode', '$subjectName')";

                // Execute the query
                if (mysqli_query($conn, $insert_query)) {
                    $_SESSION['response_type'] = 'success';
                    $_SESSION['response_text'] = 'Subject added successfully!';
                } else {
                    $_SESSION['response_type'] = 'error';
                    $_SESSION['response_text'] = 'Failed to add subject. Please try again.';
                }
            }
        } else {
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = 'Both SME ID and Subject are required.';
        }

        // Redirect back to the form page
        header('Location: managesmesub.php?smeID=' . $smeID);
        exit();
    }
}
