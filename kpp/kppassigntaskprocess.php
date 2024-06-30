<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['submit'])) {
    // Extract the degree course information
    $degcourse_value = $_POST['degcourseinput'];
    $degcourse_parts = explode(' - ', $degcourse_value);
    $degcourse = isset($degcourse_parts[0]) ? $degcourse_parts[0] : '';
    $degname = isset($degcourse_parts[1]) ? $degcourse_parts[1] : '';
    $dipprevinst_value = $_POST['previnstInput'];
    $dipprevprog_value = $_POST['prevprogInput'];
    $dipcourse_value = $_POST['dipcourseinput'];
    $dipcourse_parts = explode(' - ', $dipcourse_value);
    $dipcourse = isset($dipcourse_parts[0]) ? $dipcourse_parts[0] : '';
    $dipname = isset($dipcourse_parts[1]) ? $dipcourse_parts[1] : '';
    $dipcredithour = isset($dipcourse_parts[2]) ? trim(str_replace(' Credit Hour', '', $dipcourse_parts[2])) : '';
    $dipdci = isset($_POST['dipfile']) ? $_POST['dipfile'] : '';
    $first_sme_id = isset($_POST['firstsmeselection']) ? $_POST['firstsmeselection'] : '';
    $second_sme_id = isset($_POST['secondsmeselection']) ? $_POST['secondsmeselection'] : '';
    $studID = $_POST['studID'];

    // Check if sme1 and sme2 are selected and not the same person
    if (empty($first_sme_id) || empty($second_sme_id) || $first_sme_id === $second_sme_id) {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = "Please select both SMEs, and they cannot be the same person.";
        header("Location: " . $_SESSION['current_url']);
        exit();
    }


    // Handle the file upload
    $degdci = '';
    if (isset($_FILES['degdci']) && $_FILES['degdci']['error'] == 0) {
        $target_dir = "../uploads/taskdci/";
        $target_file = $target_dir . basename($_FILES["degdci"]["name"]);
        if (move_uploaded_file($_FILES["degdci"]["tmp_name"], $target_file)) {
            $degdci = $target_file;
        } else {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = "Sorry, there was an error uploading your file.";
            header("Location: " . $_SESSION['current_url']);
            exit();
        }
    }

    // Insert data into the assigntask table
    $query_assigntask = "INSERT INTO assigntask (degcode, degcourse, degdci, dipprev_inst, dipprev_prog, dipcode, dipcourse, dipcredithour, dipdci, firstsme, secsme, datetime) VALUES ('$degcourse', '$degname', '$degdci', '$dipprevinst_value', '$dipprevprog_value', '$dipcourse', '$dipname', '$dipcredithour', '$dipdci', '$first_sme_id', '$second_sme_id', NOW())";
    if (mysqli_query($conn, $query_assigntask)) {
        // Task assigned successfully
        $_SESSION['response_type'] = 'success';
        $_SESSION['response_text'] = "Task assigned, record updated";

        // Insert data into the similarity table
        $query_similarity = "INSERT INTO similarity (SubjectA, SubjectB, sme1, sme2, studID) VALUES ('$degcourse', '$dipcourse', '$first_sme_id', '$second_sme_id', '$studID')";
        if (!mysqli_query($conn, $query_similarity)) {
            $_SESSION['response_type'] = 'error';
            $_SESSION['response_text'] = "Error: " . $query_similarity . "<br>" . mysqli_error($conn);
        }
    } else {
        // Error in task assignment
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = "Error: " . $query_assigntask . "<br>" . mysqli_error($conn);
    }



    header("Location: kpptaskmanagement.php");
    exit();
}
