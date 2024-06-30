<?php
// Include authentication and database configuration files
include '../config/kppauthentication.php';
include '../config/DbConfig.php';

// Check if 'matrix' is set in POST request
if (isset($_POST['matrix'])) {
    $matrix = $_POST['matrix'];
    $_SESSION['matrix'] = $matrix;

    // Query to fetch course details based on the matrix number
    $query = "SELECT DISTINCT d.uniszacoursecode AS degree_uniszacoursecode,
                 d.uniszacoursename AS degree_uniszacoursename,
                 d.uniszacredithour AS degree_uniszacredithour,
                 dip.dipcoursecode AS diploma_dipcoursecode,
                 dip.dipcoursename AS diploma_dipcoursename,
                 dip.dipcredithour AS diploma_dipcredithour,
                 dip.dipgrade AS diploma_dipgrade,
                 dip.dipfile AS diploma_dipfile,
                 d.status AS degree_status
          FROM degcourse d
          LEFT JOIN dipcourse dip ON d.id = dip.id
          WHERE d.matrixnumber = '" . $matrix . "'";
    // Execute the SQL query
    $result = mysqli_query($conn, $query);

    // Initialize an empty array to store the fetched data
    $data = array();

    // Fetch data from the result set and store it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

// Initialize an array to store SME (Subject Matter Expert) information
$smeInfo = array();

// Query to fetch SME information from the 'smelogin' and 'smesubject' tables
$query = "SELECT smelogin.*, smesubject.subject FROM smelogin LEFT JOIN smesubject ON smelogin.ID = smesubject.smeid";

// Execute the SQL query
$result = mysqli_query($conn, $query);

// Fetch data from the result set and store it in the array
while ($row = mysqli_fetch_assoc($result)) {
    // Store SME information in the array
    $smeID = $row['ID'];
    $subject = $row['subject'];

    // Check if the SME already exists in the array
    if (!isset($smeInfo[$smeID])) {
        // If not, initialize an array for the SME
        $smeInfo[$smeID] = array(
            'fullname' => $row['fullname'],
            'subjects' => array()
        );
    }

    // Add subject to the SME's subjects array
    if (!empty($subject)) {
        $smeInfo[$smeID]['subjects'][] = $subject;

        // Check if the subject matches the desired degree course code
        if ($subject === $_GET['degcoursecode']) {
            // Add SME to the list of available SMEs
            $availableSMEs[] = $smeInfo[$smeID];
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Kpp Assign Task</title>

    <!-- External CSS libraries -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/kppassigntask.css" />

    <!-- External JavaScript libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <!-- Page Content -->
    <div id="content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <!-- Form to redirect to course request page with matrix number -->
                <form action="kppviewcourse.php" method="POST">
                    <input type="text"
                        value="<?php echo isset($_GET['matrix']) ? htmlspecialchars($_GET['matrix']) : ''; ?>" hidden
                        id="matrix" name="matrix" readonly>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-book"></i>
                        <span>Course Request</span>
                    </button>
                </form>
                <div class="d-flex ms-auto">
                    <!-- Form to redirect to home page -->
                    <form action="kpphome.php" method="POST">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-home"></i>
                            <span>Home</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <?php
        // Displaying alerts if any response is set in the session
        if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
            $bootstrap_class = '';

            // Determine the Bootstrap alert class based on response type
            switch ($_SESSION['response_type']) {
                case 'success':
                    $bootstrap_class = 'alert-success';
                    break;
                case 'error':
                    $bootstrap_class = 'alert-danger';
                    break;
                case 'warning':
                    $bootstrap_class = 'alert-warning';
                    break;
                default:
                    $bootstrap_class = 'alert-info';
                    break;
            }

            // Display the alert with a close button
            echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'; // Close button
            echo $_SESSION['response_text'];
            echo '</div>';

            // Clear the session variables for response
            $_SESSION['response_type'] = '';
            $_SESSION['response_text'] = '';
        }
        ?>

        <?php
        $matrix = isset($_GET['matrix']) ? $conn->real_escape_string($_GET['matrix']) : '';

        if ($matrix) {
            $sql = "SELECT studID FROM login WHERE matrixnumber = '$matrix'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    $studID = htmlspecialchars($row['studID']);
                }
            } else {
                $studID = "No results found";
            }
        } else {
            $studID = "Matrix value not set";
        }
        // Retrieve course and previous institution/program details from GET request
        $degcoursecode = isset($_GET['degcoursecode']) ? htmlspecialchars($_GET['degcoursecode']) : '';
        $degcoursename = isset($_GET['degcoursename']) ? htmlspecialchars($_GET['degcoursename']) : '';
        $degcredithour = isset($_GET['degcredithour']) ? htmlspecialchars($_GET['degcredithour']) : '';
        $degcourse_value = trim($degcoursecode . ' - ' . $degcoursename . ' - ' . $degcredithour . ' Credit Hour');

        $dipcoursecode = isset($_GET['dipcoursecode']) ? htmlspecialchars($_GET['dipcoursecode']) : '';
        $dipcoursename = isset($_GET['dipcoursename']) ? htmlspecialchars($_GET['dipcoursename']) : '';
        $dipcredithour = isset($_GET['dipcredithour']) ? htmlspecialchars($_GET['dipcredithour']) : '';
        $dipcourse_value = trim($dipcoursecode . ' - ' . $dipcoursename . ' - ' . $dipcredithour . ' Credit Hour');

        $prevInst = isset($_GET['prevInst']) ? htmlspecialchars($_GET['prevInst']) : '';
        $prevProg = isset($_GET['prevProg']) ? htmlspecialchars($_GET['prevProg']) : '';
        ?>

        <!-- Form to submit task assignment -->
        <form action="kppassigntaskprocess.php" method="post" enctype="multipart/form-data" id="submitForm">
            <div class="container mt-5 shadow-lg">
                <!-- Unisza Course Section -->
                <!-- To send studID from get from table login then send  to table similarity column studID -->
                <input type="text" value="<?php echo isset($studID) ? $studID : ''; ?>" id="studID" name="studID" hidden
                    readonly>
                <div class="row mb-3">
                    <div class="col">
                        <h4>Unisza Course</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3 d-flex align-items-start">
                                <!-- Input box for degree course details -->
                                <div class="input-group">
                                    <input type="text" id="degcourseinput" name="degcourseinput" class="form-control"
                                        value="<?php echo $degcourse_value; ?>" readonly required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-start">
                                <!-- File input for degree course document -->
                                <input type="file" id="fileUpload1" name="degdci" class="form-control" accept=".pdf"
                                    required />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Diploma Course Section -->
                <div class="row mb-3">
                    <div class="col">
                        <h4>Diploma Course</h4>
                        <div class="input-group">
                            <!-- Input box for previous institution -->
                            <input type="text" id="previnstInput" name="previnstInput" class="form-control"
                                value="<?php echo $prevInst; ?>" readonly required />
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="input-group">
                            <!-- Input box for previous program -->
                            <input type="text" id="prevprogInput" name="prevprogInput" class="form-control"
                                value="<?php echo $prevProg; ?>" readonly required />
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6 mb-3 d-flex align-items-start">
                                <div class="input-group">
                                    <!-- Input box for diploma course details -->
                                    <input type="text" id="dipcourseInput" name="dipcourseinput" class="form-control"
                                        value="<?php echo $dipcourse_value; ?>" readonly required />
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 d-flex align-items-start">
                                <?php
                                $dipfile = isset($_GET['dipfile']) ? urldecode($_GET['dipfile']) : '';
                                // Construct the full URL for the diploma file
                                $FileUrl = "http://localhost/FYP(CTA)/$dipfile";
                                ?>
                                <!-- Button to view diploma DCI file -->
                                <div class="col-md-6 mb-3 d-flex align-items-start">
                                    <a href="<?php echo $FileUrl; ?>" target="_blank" class="btn btn-primary"
                                        id="downloadButton">Check Diploma DCI: <?php echo $dipcoursecode ?> </a>
                                    <!-- Hidden input to store the file URL -->
                                    <input type="hidden" name="dipfile"
                                        value="<?php echo htmlspecialchars($dipfile); ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <h4>Assign SME</h4>
                </div>
                <?php
                // Initialize an array to keep track of SMEs already added
                $addedSMEs = array();

                echo '<div class="row mb-3">';
                echo '<div class="col-md-6 mb-3 d-flex align-items-start">';
                // First SME dropdown
                echo '<select id="dropdown5" name="firstsmeselection" class="form-select mb-3" required>';
                echo '<option value="" disabled selected>Assign 1st SME</option>';

                // Loop through SME information array to generate options for the first dropdown
                foreach ($smeInfo as $smeID => $sme) {
                    if (isset($availableSMEs[0]) && $availableSMEs[0]['fullname'] == $sme['fullname'])
                        echo '<option selected value="' . $smeID . '">' . $sme['fullname'] . ' </option>';
                    else
                        echo '<option value="' . $smeID . '">' . $sme['fullname'] . ' </option>';
                    // Check if the SME ID is not already added
                    if (!in_array($smeID, $addedSMEs)) {
                        $addedSMEs[] = $smeID;
                    }
                }

                echo '</select>';
                echo '</div>';

                echo '<div class="col-md-6 d-flex align-items-start">';
                // Second SME dropdown
                echo '<select id="dropdown6" name="secondsmeselection" class="form-select mb-3" required>';
                echo '<option value="" disabled selected>Assign 2nd SME</option>';

                // Reset the added SMEs array
                $addedSMEs = array();
                // Loop through SME information array again to populate the second dropdown
                foreach ($smeInfo as $smeID => $sme) {
                    if (isset($availableSMEs[1]) && $availableSMEs[1]['fullname'] == $sme['fullname'])
                        echo '<option selected value="' . $smeID . '">' . $sme['fullname'] . '</option>';
                    else
                        echo '<option value="' . $smeID . '">' . $sme['fullname'] . ' </option>';
                    if (!in_array($smeID, $addedSMEs)) {
                        $addedSMEs[] = $smeID;
                    }
                }

                echo '</select>';
                echo '</div>';
                echo '</div>';
                ?>

                <!-- Submit button and confirmation modal -->
                <div class="row mb-3">
                    <div class="col text-end">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal" id="showConfirmationModal">
                            Assign
                        </button>
                    </div>
                </div>

            </div>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">
                                Confirm task assignment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to assign this task?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-success" name="submit" id="confirmSubmit">
                                Yes, Assign
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>
<script>
    var button = document.getElementById("backButton");

    // Add click event listener to redirect to profile page
    button.addEventListener("click", function () {
        window.location.href = "kppviewprofile.php";
    });

    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(function () {
            var alert = document.getElementById("responseAlert");
            if (alert) {
                alert.style.display = "none";
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    });

    // JavaScript to handle dismissal when close button is clicked
    document.querySelectorAll(".btn-close").forEach(function (btn) {
        btn.addEventListener("click", function () {
            var alert = this.closest(".alert");
            if (alert) {
                alert.style.display = "none";
            }
        });
    });
</script>

</html>