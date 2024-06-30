<?php
// Include necessary files
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

// Check if the smeID is set and not empty
if (isset($_POST['smeID']) && !empty($_POST['smeID'])) {
    // Get the smeID from the form
    $smeID = $_POST['smeID'];

    // Begin a transaction
    mysqli_begin_transaction($conn);

    try {
        // Prepare the SQL query to delete the related entries from smesubject
        $query1 = "DELETE FROM smesubject WHERE smeid = $smeID";
        mysqli_query($conn, $query1);

        // Prepare the SQL query to delete the entry from smelogin
        $query2 = "DELETE FROM smelogin WHERE ID = $smeID";
        mysqli_query($conn, $query2);

        // Commit the transaction
        mysqli_commit($conn);

        // Set response variables for success
        $_SESSION['response_type'] = 'success';
        $_SESSION['response_text'] = 'SME deleted successfully.';
    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($conn);

        // Set response variables for error
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Error deleting SME.';
    }

    // Redirect back to admin home page
    header("Location: adminhome.php");
    exit();
} else {
    // If smeID is not set or empty, redirect back to admin home page
    header("Location: adminhome.php");
    exit();
}
