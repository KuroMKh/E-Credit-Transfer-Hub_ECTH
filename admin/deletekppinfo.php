<?php
// Include necessary files
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

// Check if the KPP ID is set and not empty
if (isset($_POST['kppID']) && !empty($_POST['kppID'])) {
    // Get the KPP ID from the form
    $kppID = $_POST['kppID'];

    // Prepare the SQL query to delete the KPP entry
    $query = "DELETE FROM kpplogin WHERE ID = $kppID";

    // Execute the SQL query
    $result = mysqli_query($conn, $query);

    // Check if the deletion was successful
    if ($result) {
        // Set response variables for success
        $_SESSION['response_type'] = 'success';
        $_SESSION['response_text'] = 'KPP deleted successfully.';
    } else {
        // Set response variables for error
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Error deleting KPP.';
    }

    // Redirect back to admin home page
    header("Location: adminhome.php");
    exit();
} else {
    // If KPP ID is not set or empty, redirect back to admin home page
    header("Location: adminhome.php");
    exit();
}
