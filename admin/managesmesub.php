<?php
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

$subjects = array();

if (isset($_POST['smeID']) && !empty($_POST['smeID'])) {
    // Get the smeID from the form
    $smeID = $_POST['smeID'];

    // Prepare the SQL query to fetch data for the specific ID
    $query = "SELECT * FROM smesubjects WHERE smeID = $smeID"; // Assuming the table is 'smesubjects' and it has 'smeID' column

    // Executing the SQL query
    $result = mysqli_query($conn, $query);

    // Fetching data from the result set and storing it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $subjects[] = $row['subject']; // Assuming the column name is 'subject'
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Admin: Managing SME Subjects</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../CSS/managesmesub.css" />
</head>

<body>
    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <form action="managesmeinfo.php" method="post">
                    <input type="text"
                        value="<?php echo isset($_GET['smeID']) ? htmlspecialchars($_GET['smeID']) : ''; ?>" hidden
                        id="smeID" name="smeID" readonly>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-user"></i> Sme Profile</button>
                </form>
                <div class="navbar-brand"><strong>Manage Subject</strong></div>
                <div class="text-end d-lg-inline-block">
                    <form action="adminhome.php">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-home"></i> Home</button>
                    </form>
                </div>
            </div>
        </nav>

        <?php
        if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
            $bootstrap_class = '';

            // Determining the Bootstrap alert class based on response type
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

            // Displaying the alert with close button
            echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show" role="alert" id="responseAlert">';
            echo $_SESSION['response_text'];
            echo '<button type="button" class="close" aria-label="Close" id="closeAlert">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';

            // Clearing the session variables for response
            $_SESSION['response_type'] = '';
            $_SESSION['response_text'] = '';
        }
        ?>

        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="profile-container">
                        <form action="managesmesubprocess.php" method="post" enctype="multipart/form-data"
                            id="submitform">
                            <input type="hidden" value="<?php echo $_GET['smeID'] ?? ''; ?>" name="smeID">
                            <h4 class="text-primary"><strong>Create Subject</strong></h4>
                            <hr />

                            <div id="textboxContainer">
                                <!-- Display existing subjects from database -->
                                <div class="textbox-group">
                                    <input type="text" class="form-control" name="subject"
                                        placeholder="CSF 11603 - Discrete Mathematics"
                                        pattern="^[A-Z]{1,4} \d{1,6} - [A-Za-z ]+$"
                                        title="Please use the format 'CSF 11603 - Discrete Mathematics'" required />
                                    <div class="btn-group">
                                        <!-- Add Button -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#confirmationModal"><i class="fas fa-cog"></i> Set</button>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="confirmationModal" tabindex="-1"
                                aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="confirmationModalLabel">Confirmation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Is this aligned with the SME specialization?
                                        </div>
                                        <div class="modal-footer">
                                            <!-- Button to cancel and dismiss the modal -->
                                            <button type="button" class="btn btn-danger"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <!-- Button to submit the form -->
                                            <button type="submit" form="submitform"
                                                class="btn btn-success">Confirm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript to close the alert box -->
    <script>
        // Add an event listener to the close button
        document.getElementById('closeAlert').addEventListener('click', function () {
            // Hide the alert box
            document.getElementById('responseAlert').style.display = 'none';
        });
    </script>
</body>

</html>