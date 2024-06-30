<?php
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

// Check if the delete button is clicked and if the record_id is set
if (isset($_POST['delete_record']) && isset($_POST['record_id'])) {
    // Get the record ID from the request and escape it
    $record_id = mysqli_real_escape_string($conn, $_POST['record_id']);

    // SQL queries to delete the record
    $query1 = "DELETE FROM assigntask WHERE ID = $record_id";
    $query2 = "DELETE FROM similarity WHERE ID = $record_id";

    // Execute the first query
    if (mysqli_query($conn, $query1)) {
        // Execute the second query
        if (mysqli_query($conn, $query2)) {
            // Records deleted successfully
            $_SESSION['response_type'] = 'success';
            $_SESSION['response_text'] = "DCI match successfully deleted.";
        } else {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = "Error: Operation failed. " . mysqli_error($conn);
        }
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = "Error: Operation failed. " . mysqli_error($conn);
    }

    // Redirect back to the task management page
    header("Location: kpptaskmanagement.php");
    exit;
} else {
    // If the delete button is not clicked or if the record_id is not set, redirect back to the task management page
    header("Location: kpptaskmanagement.php");
    exit;
}
