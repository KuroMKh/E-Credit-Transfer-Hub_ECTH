<?php
include '../config/adminauthentication.php';
include '../config/DbConfig.php';

if (isset($_POST['kppID']) && !empty($_POST['kppID'])) {
    // Get the courseID from the form
    $kppID = $_POST['kppID'];

    // Prepare the SQL query to fetch data for the specific ID
    $query = "SELECT * FROM kpplogin WHERE ID = $kppID";

    // Executing the SQL query
    $result = mysqli_query($conn, $query);

    // Initializing an empty array to store the fetched data
    $data = array();

    // Fetching data from the result set and storing it in the array
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Admin Manage KPP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../CSS/admincreatekpp.css" />

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../JS/adminhome.js"></script>
</head>

<body>


    <div id="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <div class="container-fluid">
                <div class="navbar-brand"><strong>Manage KPP</strong></div>
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
            echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show" role="alert">';
            echo $_SESSION['response_text'];
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
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
                        <form action="managekppinfoprocess.php" method="post" enctype="multipart/form-data"
                            id="submitform">
                            <input type="hidden" value="<?php echo $_POST['kppID'] ?? ''; ?>" name="kppID">
                            <h4 class="text-primary"><strong>Manage KPP Profile</strong></h4>
                            <hr />
                            <div class="row">
                                <!-- left column -->
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <img id="previewImage"
                                            src="<?php echo isset($data[0]["kppprofilepic"]) ? htmlspecialchars($data[0]["kppprofilepic"]) : '../images/userpeople.png'; ?>"
                                            class="avatar img-circle img-thumbnail" alt="avatar" />
                                        <h6>Upload a different photo...</h6>
                                        <input type="file" class="form-control mb-3 mb-md-0" name="kppprofilepicture"
                                            accept="image/*" onchange="previewFile(this)" />
                                    </div>
                                </div>

                                <!-- edit form column -->
                                <div class="col-md-6 personal-info">
                                    <!--<form class="form-horizontal" role="form"> -->
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" placeholder="Fullname"
                                                name="fullname"
                                                value="<?php echo htmlspecialchars($data[0]["fullname"]); ?>"
                                                required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" placeholder="6-Digit ID"
                                                name="kppnum" pattern="[0-9]{6}" maxlength="6"
                                                value="<?php echo htmlspecialchars($data[0]["kppnum"]); ?>" required />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input id="password" class="form-control" type="password"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                                    placeholder="New Password" name="kpppassword" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i id="togglePassword" class="fas fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="input-group">
                                                <input id="confirmPassword" class="form-control" type="password"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                                    placeholder="Confirm New Password" name="c_kpppassword" />
                                                <div class="input-group-append">
                                                    <span class="input-group-text">
                                                        <i id="toggleConfirmPassword" class="fas fa-eye-slash"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group align-self-end">
                                        <div class="col-lg-12">

                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#confirmationModal"> <i class="fas fa-cog"></i>
                                                Edit</button>

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#deleteConfirmationModal">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Edit KPP -->
                            <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Edit Confirmation?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to edit this Kpp?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="modalSubmitBtn"
                                                name="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!--Delete KPP -->
                        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Delete Confirmation?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this Kpp?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <form action="deletekppinfo.php" method="post">
                                            <input type="hidden" name="kppID"
                                                value="<?php echo htmlspecialchars($data[0]["ID"]); ?>">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function togglePasswordVisibility(inputId, toggleIconId) {
            var passwordInput = document.getElementById(inputId);
            var toggleIcon = document.getElementById(toggleIconId);

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }

        document.getElementById("togglePassword").addEventListener("click", function () {
            togglePasswordVisibility("password", "togglePassword");
        });

        document.getElementById("toggleConfirmPassword").addEventListener("click", function () {
            togglePasswordVisibility("confirmPassword", "toggleConfirmPassword");
        });
    </script>
</body>

</html>