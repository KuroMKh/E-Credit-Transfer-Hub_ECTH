<?php
include '../config/smeauthentication.php';
include '../config/DbConfig.php';

$smeID = $_SESSION['smeID'];
$query = "
    SELECT 
        similarity.*, 
        smelogin1.fullname AS fullname1, 
        smelogin2.fullname AS fullname2 
    FROM 
        similarity 
    LEFT JOIN 
        smelogin AS smelogin1 ON similarity.sme1 = smelogin1.ID 
    LEFT JOIN 
        smelogin AS smelogin2 ON similarity.sme2 = smelogin2.ID 
    WHERE 
        similarity.sme1 = ? OR similarity.sme2 = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $smeID, $smeID);
$stmt->execute();
$result = $stmt->get_result();


// Function to get diploma course name
function getDiplomaCourseInfo($conn, $courseCode)
{
    $query = "SELECT DISTINCT dipcoursename, dipfile FROM dipcourse WHERE dipcoursecode LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $courseCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $courseInfo = $result->fetch_assoc();
    return $courseInfo;
}

// Check if the course code is set in POST request
if (isset($_POST['subjectB'])) {
    $dipCourseCode = $_POST['subjectB'];
    // Save the course code to the session
    $_SESSION['subjectB'] = $dipCourseCode;
} else {
    // If not in POST request, get it from the session
    $dipCourseCode = isset($_SESSION['subjectB']) ? $_SESSION['subjectB'] : '';
}


// Assume that $_POST['subjectB'] contains the course code.
$courseData = getDiplomaCourseInfo($conn, $dipCourseCode);

$dipCourseName = $courseData['dipcoursename'];
// $dipDCI = $courseData['dipdci'];
$dipDCI = basename($courseData['dipfile']); // Extract the basename of the DCI file

$baseURLdip = "http://localhost/FYP(CTA)/uploads/dipdci/";


function getDegreeCourseNameAndDCI($conn, $courseCode)
{
    $query = "
        SELECT DISTINCT d.uniszacoursename, a.degdci 
        FROM degcourse d 
        LEFT JOIN assigntask a ON d.uniszacoursecode = a.degcode 
        WHERE d.uniszacoursecode LIKE ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $courseCode);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    return $data;
}

// Check if the course code is set in POST request
if (isset($_POST['subjectA'])) {
    $degCourseCode = $_POST['subjectA'];
    // Save the course code to the session
    $_SESSION['subjectA'] = $degCourseCode;
} else {
    // If not in POST request, get it from the session
    $degCourseCode = isset($_SESSION['subjectA']) ? $_SESSION['subjectA'] : '';
}
// Assume that $_POST['subjectB'] contains the course code.
$courseData = getDegreeCourseNameAndDCI($conn, $degCourseCode);

$degCourseName = $courseData['uniszacoursename'];
// $degDCI = $courseData['degdci'];
$degDCI = basename($courseData['degdci']); // Extract the basename of the DCI file

$baseURLdeg = "http://localhost/FYP(CTA)/uploads/taskdci/";


function getPrevInst($conn, $studID)
{
    $query = "SELECT prev_inst FROM `diploma` JOIN login on diploma.matrixnumber = login.matrixnumber WHERE login.studID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $studID);
    $stmt->execute();
    $result = $stmt->get_result();
    $uni = $result->fetch_assoc()['prev_inst'];
    return $uni;
}

$taskId = isset($_POST['taskId']) ? $_POST['taskId'] : (isset($_SESSION['taskId']) ? $_SESSION['taskId'] : '');
$_SESSION['taskId'] = $taskId;

if (!empty($taskId)) {
    $stmt = $conn->prepare("SELECT * FROM `similarity` WHERE ID = ?");
    $stmt->bind_param("s", $taskId);
    $stmt->execute();
    $result = $stmt->get_result();
    $simID = $result->fetch_assoc();
    $stmt->close();
    $sme1Status = isset($simID['sme1status']) ? $simID['sme1status'] : '';
    $sme2Status = isset($simID['sme2status']) ? $simID['sme2status'] : '';
} else {
    $simID = null;
    $sme1Status = '';
    $sme2Status = '';
}

// Check if the course code is set in POST request
if (isset($_POST['studID'])) {
    $studID = $_POST['studID'];
    // Save the course code to the session
    $_SESSION['studID'] = $studID;
} else {
    // If not in POST request, get it from the session
    $studID = isset($_SESSION['studID']) ? $_SESSION['studID'] : '';
}
// Assume that $_POST['subjectB'] contains the course code.
// $studID = isset($_POST['studID']) ? $_POST['studID'] : ''; // default value for testing
$uni = getPrevInst($conn, $studID);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ECTH | Task</title>
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../CSS/smeviewtask.css" />
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

</head>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow mb-3 mx-auto">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div>
                <form action="smehome.php">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-home"></i> Home
                    </button>
                </form>
            </div>
            <div class="text-center h4-container">
                <h4>
                    <strong>Received Task Details</strong>
                </h4>
            </div>
        </div>
    </nav>

    <?php
    // Displaying alerts if any response is set in the session
    if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
        $alert_type = '';
        $alert_title = '';

        // Determine the SweetAlert type and title based on response type
        switch ($_SESSION['response_type']) {
            case 'success':
                $alert_type = 'success';
                $alert_title = 'Success!';
                break;
            case 'error':
                $alert_type = 'error';
                $alert_title = 'Error!';
                break;
            case 'warning':
                $alert_type = 'warning';
                $alert_title = 'Warning!';
                break;
            default:
                $alert_type = 'info';
                $alert_title = 'Info';
                break;
        }

        // Display the SweetAlert
        echo '<script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
            Swal.fire({
                title: "' . $alert_title . '",
                text: "' . $_SESSION['response_text'] . '",
                icon: "' . $alert_type . '",
                confirmButtonText: "OK"
            });
        });
    </script>';

        // Clear the session variables for response
        $_SESSION['response_type'] = '';
        $_SESSION['response_text'] = '';
    }
    ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background-color: #002d72; color: white;">
                <h6 class="card-title mb-0"><strong>DCI Details</strong></h6>
                <button type="button" class="btn btn-light" id="toggleButton">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div id="cardBody" class="collapsible">
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6><b>Previous Institution: <?php echo $uni; ?></b></h6>
                                </div>
                                <div class="d-flex flex-column mt-2">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="mr-mb-0" style="width: 625px;"><b>Diploma Course:
                                                <?php echo htmlspecialchars($dipCourseCode . ' - ' . htmlspecialchars($dipCourseName)); ?></b>
                                        </h6>
                                        <a href="<?php echo htmlspecialchars($baseURLdip . $dipDCI); ?>" target="_blank"
                                            class="btn btn-light">
                                            <i class="fa fa-file-text"></i> View Diploma DCI
                                        </a>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <h6 class="mr-2 mb-0" style="width: 625px;"><b>Degree Course:
                                                <?php echo $degCourseCode . ' - ' . $degCourseName; ?></b></h6>
                                        <a href="<?php echo htmlspecialchars($baseURLdeg . $degDCI); ?>" target="_blank"
                                            class="btn btn-light">
                                            <i class="fa fa-file-text"></i> View Degree DCI
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="table-container mb-3">
                    <table class="table" id="similarityTable">
                        <thead>
                            <tr>
                                <th scope="col">Degree Course</th>
                                <th scope="col">Diploma Course</th>
                                <th scope="col">Similarity Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td contenteditable="true" id="text1" rows="4" cols="30">
                                    <?php if (isset($_POST['text1']))
                                        echo $_POST['text1']; ?>
                                </td>
                                <td contenteditable="true" id="text2" rows="4" cols="30">
                                    <?php if (isset($_POST['text2']))
                                        echo $_POST['text2']; ?>
                                </td>
                                <td>
                                    <span class="text-center similarity-result">0 %</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary" onclick="calculateSimilarity()">Calculate</button>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background-color: #002d72; color: white;">
                <h6 class="card-title mb-0"><strong>Feedback of the DCI Match</strong></h6>
            </div>
            <div class="card-body">

                <div class="d-flex flex-column mt-2">
                    <?php
                    $sme1Color = $sme1Status == 'VERIFIED' ? '#00ff00' : '#ffd700';
                    $sme2Color = $sme2Status == 'VERIFIED' ? '#00ff00' : '#ffd700';
                    ?>

                    <table style="width: 50%; border-collapse: collapse; margin: 0 auto;">
                        <tr>
                            <th style="border: 1px solid black; padding: 8px; text-align: center; width: 65%;">
                                SME
                            </th>
                            <th style="border: 1px solid black; padding: 8px; text-align: center;">
                                Similarity Verification Status
                            </th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 8px; text-align: center;">
                                <strong>SME 1</strong>
                            </td>
                            <td
                                style="border: 1px solid black; padding: 8px; text-align: center; color: <?= $sme1Color; ?>;">
                                <strong><?= $sme1Status; ?></strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid black; padding: 8px; text-align: center;">
                                <strong>SME 2</strong>
                            </td>
                            <td
                                style="border: 1px solid black; padding: 8px; text-align: center; color: <?= $sme2Color; ?>;">
                                <strong><?= $sme2Status; ?></strong>
                            </td>
                        </tr>
                    </table>
                </div>

                <form action="smesubmitprocess.php" method="post" enctype="multipart/form-data" id="submitForm">
                    <table class="table mt-4">
                        <thead>
                            <tr>
                                <th scope="col">Review</th>
                                <th scope="col" class="text-center">Similarity Percentage</th>
                                <th scope="col" class="text-center">Decision</th>
                                <th scope="col" class="text-center">Submit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <input type="hidden" name="smeID" class="text-center"
                                    value="<?php echo isset($smeID) ? htmlspecialchars($smeID) : ''; ?>" readonly>

                                <input type="hidden" name="simID" class="text-center"
                                    value="<?php echo isset($simID['ID']) ? htmlspecialchars($simID['ID']) : ''; ?>"
                                    readonly>
                                <td>
                                    <textarea class="form-control" id="reviewInput" name="reviewInput"
                                        required></textarea>
                                </td>
                                <td class="text-center">
                                    <input type="text" class="form-control form-control-sm text-center"
                                        id="similarityResultInput" name="similarityResultInput" required>
                                </td>
                                <td class="text-center">
                                    <select class="form-control" id="decisionDropdown" name="decisionDropdown" required>
                                        <option value="APPROVED">Approved</option>
                                        <option value="REJECTED">Rejected</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#confirmationModal" id="showConfirmationModal">
                                        Submit
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1"
                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">
                                        Confirm Your Decision
                                    </h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fa fa-close"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Are you confirmed in your decision?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                        No, Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success" name="submit" id="confirmSubmit">
                                        Yes, Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        document.getElementById('toggleButton').addEventListener('click', function () {
            var cardBody = document.getElementById('cardBody');
            var icon = this.querySelector('i');
            cardBody.classList.toggle('show');
            if (cardBody.classList.contains('show')) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        });

        function calculateSimilarity() {
            var text1 = document.getElementById('text1').innerText;
            var text2 = document.getElementById('text2').innerText;

            fetch('http://localhost:5000/calculate_similarity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ text1: text1, text2: text2 }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    document.querySelector('.similarity-result').innerText = data.similarity;
                    document.getElementById('similarityResultInput').value = data.similarity;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>

</html>