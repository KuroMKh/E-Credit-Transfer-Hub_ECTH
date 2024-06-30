<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    $smeID = mysqli_real_escape_string($conn, $_POST['smeID']);
    $simID = mysqli_real_escape_string($conn, $_POST['simID']);
    $similarityResultInput = mysqli_real_escape_string($conn, $_POST['similarityResultInput']);
    $reviewInput = mysqli_real_escape_string($conn, $_POST['reviewInput']);
    $decisionDropdown = mysqli_real_escape_string($conn, $_POST['decisionDropdown']);

    // Check if $smeID exists in column sme1 or sme2
    $sql_check_sme1 = "SELECT * FROM similarity WHERE sme1 = '$smeID' AND ID = '$simID'";
    $result_sme1 = mysqli_query($conn, $sql_check_sme1);
    $row_sme1 = mysqli_fetch_assoc($result_sme1);

    $sql_check_sme2 = "SELECT * FROM similarity WHERE sme2 = '$smeID' AND ID = '$simID'";
    $result_sme2 = mysqli_query($conn, $sql_check_sme2);
    $row_sme2 = mysqli_fetch_assoc($result_sme2);

    // Prepare and execute SQL query based on smeID
    if ($row_sme1) {
        $sql = "UPDATE similarity 
                SET review1 = '$reviewInput', 
                    decision1 = '$decisionDropdown', 
                    similaritypercent = '$similarityResultInput', 
                    sme1status = 'VERIFIED', 
                    sme2status = sme2status -- To ensure sme2status retains its existing value
                WHERE ID = '$simID'";
    } elseif ($row_sme2) {
        $sql = "UPDATE similarity 
                SET review2 = '$reviewInput', 
                    decision2 = '$decisionDropdown', 
                    similaritypercent = '$similarityResultInput', 
                    sme2status = 'VERIFIED', 
                    sme1status = sme1status -- To ensure sme1status retains its existing value
                WHERE ID = '$simID'";
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Invalid smeID or simID';
        header('Location: smeviewtask.php');
        exit(); // Exit script if smeID is invalid
    }

    // Execute SQL query
    if (mysqli_query($conn, $sql)) {
        // Check the decisions and update status accordingly
        $sql_check_status = "SELECT decision1, decision2 FROM similarity WHERE ID = '$simID'";
        $result_status = mysqli_query($conn, $sql_check_status);
        $row_status = mysqli_fetch_assoc($result_status);

        // Set status based on decisions
        if ($row_status['decision1'] == 'APPROVED' && $row_status['decision2'] == 'APPROVED') {
            $sql_update_status = "UPDATE similarity SET status = 'APPROVED' WHERE ID = '$simID'";
        } elseif ($row_status['decision1'] == 'REJECTED' || $row_status['decision2'] == 'REJECTED') {
            $sql_update_status = "UPDATE similarity SET status = 'REJECTED' WHERE ID = '$simID'";
        } elseif (($row_status['decision1'] == 'APPROVED' || $row_status['decision1'] == 'REJECTED') && is_null($row_status['decision2'])) {
            $sql_update_status = "UPDATE similarity SET status = 'PENDING' WHERE ID = '$simID'";
        } elseif (is_null($row_status['decision1']) && ($row_status['decision2'] == 'APPROVED' || $row_status['decision2'] == 'REJECTED')) {
            $sql_update_status = "UPDATE similarity SET status = 'PENDING' WHERE ID = '$simID'";
        }

        // Execute the status update query if set
        if (isset($sql_update_status) && !mysqli_query($conn, $sql_update_status)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = 'Error updating status: ' . mysqli_error($conn);
            header('Location: smeviewtask.php');
            exit();
        }

        $_SESSION['response_type'] = 'success';
        $_SESSION['response_text'] = 'Record updated successfully';
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = 'Error updating record: ' . mysqli_error($conn);
    }

    header('Location: smeviewtask.php');
    exit();
} else {
    $_SESSION['response_type'] = 'error';
    $_SESSION['response_text'] = 'Invalid request';
    header('Location: smeviewtask.php');
    exit();
}
