<?php
include '../config/DbConfig.php';
session_start();

if (isset($_POST['update_status']) && $_POST['update_status'] == '1') {
    $matrix = $_POST['matrixnumb'];
    $_SESSION['matrix'] = $matrix;
    $message = "";

    // Create a temporary table to hold the SELECT query results
    $createTempTableQuery = "
        CREATE TEMPORARY TABLE TempDegreeStatus AS
        SELECT DISTINCT 
            d.uniszacoursecode AS degree_uniszacoursecode,
            CASE 
                WHEN s.status IS NOT NULL THEN s.status
                ELSE 'PENDING'
            END AS degree_status
        FROM 
            degcourse d
        LEFT JOIN 
            dipcourse dip ON d.id = dip.id
        LEFT JOIN
            similarity s ON d.uniszacoursecode = s.subjectA AND dip.dipcoursecode = s.subjectB
        WHERE 
            d.matrixnumber = '$matrix'
    ";

    if (mysqli_query($conn, $createTempTableQuery)) {
        // Check if there are any 'PENDING' statuses
        $checkPendingQuery = "
            SELECT 1
            FROM TempDegreeStatus
            WHERE degree_status = 'PENDING'
            LIMIT 1
        ";

        $pendingResult = mysqli_query($conn, $checkPendingQuery);

        if (mysqli_num_rows($pendingResult) == 0) {
            // No 'PENDING' statuses, proceed with updates
            // Update the degcourse table based on the TempDegreeStatus table for APPROVED status
            $updateApprovedQuery = "
                UPDATE degcourse d
                SET d.status = 'APPROVED'
                WHERE d.matrixnumber = '$matrix'
                AND EXISTS (
                    SELECT 1
                    FROM TempDegreeStatus t
                    WHERE t.degree_uniszacoursecode = d.uniszacoursecode
                    AND t.degree_status = 'APPROVED'
                )
            ";

            if (!mysqli_query($conn, $updateApprovedQuery)) {
                $message .= "Error updating approved status: " . mysqli_error($conn) . " ";
            }

            // Update the degcourse table based on the TempDegreeStatus table for REJECTED status
            $updateRejectedQuery = "
                UPDATE degcourse d
                SET d.status = 'REJECTED'
                WHERE d.matrixnumber = '$matrix'
                AND EXISTS (
                    SELECT 1
                    FROM TempDegreeStatus t
                    WHERE t.degree_uniszacoursecode = d.uniszacoursecode
                    AND t.degree_status = 'REJECTED'
                )
            ";

            if (!mysqli_query($conn, $updateRejectedQuery)) {
                $message .= "Error updating rejected status: " . mysqli_error($conn);
            }

            // Update the student table based on the updated degcourse table
            $updateStudentStatusQuery = "
                UPDATE student s
                SET s.status =
                    CASE
                        WHEN (
                            SELECT COUNT(*)
                            FROM degcourse d
                            WHERE d.matrixnumber = '$matrix' AND d.status = 'APPROVED'
                        ) = (
                            SELECT COUNT(*)
                            FROM degcourse d
                            WHERE d.matrixnumber = '$matrix'
                        ) THEN 'APPROVED'
                        WHEN (
                            SELECT COUNT(*)
                            FROM degcourse d
                            WHERE d.matrixnumber = '$matrix' AND d.status = 'REJECTED'
                        ) = (
                            SELECT COUNT(*)
                            FROM degcourse d
                            WHERE d.matrixnumber = '$matrix'
                        ) THEN 'REJECTED'
                        ELSE 'PARTIAL APPROVED'
                    END,
                    s.confirmationstatus = 'COMPLETED'
                WHERE s.matrixnumber = '$matrix'
            ";

            if (!mysqli_query($conn, $updateStudentStatusQuery)) {
                $message .= "Error updating student status: " . mysqli_error($conn);
            }

            if (empty($message)) {
                $_SESSION['response_type'] = 'success';
                $_SESSION['response_text'] = "Student <b>$matrix</b> application has been updated.";
            } else {
                $_SESSION['response_type'] = 'error';
                $_SESSION['response_text'] = $message;
            }
        } else {
            // There are 'PENDING' statuses, do not update
            $_SESSION['response_type'] = 'warning';
            $_SESSION['response_text'] = "Status cannot be changed as there are pending statuses for student <b>$matrix.</b>";
        }

        // Drop the temporary table as it is no longer needed
        $dropTempTableQuery = "DROP TEMPORARY TABLE TempDegreeStatus";
        mysqli_query($conn, $dropTempTableQuery);
    } else {
        $_SESSION['response_type'] = 'error';
        $_SESSION['response_text'] = "Error creating temporary table: " . mysqli_error($conn);
    }

    // Redirect to display the message
    header("Location: kpphome.php");
    exit;
}
