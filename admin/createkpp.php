<?php
include '../config/adminauthentication.php';
include '../config/DbConfig.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>ECTH | Admin Create KPP</title>
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
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src="../images/navicon.png" width="30" height="30" /> ECTH</h3>
                <small>E-Credit Transfer Hub</small>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="adminhome.php"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="active">
                    <a href="createkpp.php"><i class="fa fa-briefcase"></i> Create KPP</a>
                </li>
                <li>
                    <a href="createsme.php"><i class="fa fa-users"></i> Create SME</a>
                </li>
            </ul>
            <ul class="list-unstyled CTAs">
                <li>
                    <a class="logout" data-toggle="modal" data-target="#exampleModalCenter">
                        <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out
                    </a>
                </li>
            </ul>
        </nav>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa fa-sign-out"></i>Logout?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">Are you sure you want to logout?</div>
                    <div class="modal-footer">
                        <form action="../config/adminlogoutconfig.php" method="post">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                No, Cancel
                            </button>
                            <button type=" button" class="btn btn-success" name="yes">
                                Yes, Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info" style="background-color: #103cbe">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <h6 class="ml-auto">
                        <?php if (isset($_SESSION['adminemail']))
                            echo $_SESSION['adminemail']; ?>
                    </h6>
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
                            <form action="createkppprocess.php" method="post" enctype="multipart/form-data"
                                id="submitform">

                                <h4 class="text-primary"><strong>Create KPP</strong></h4>
                                <hr />
                                <div class="row">
                                    <!-- left column -->
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            <img id="previewImage" src="../images/userpeople.png"
                                                class="avatar img-circle img-thumbnail" alt="avatar" />
                                            <h6>Upload a different photo...</h6>
                                            <input type="file" class="form-control mb-3 mb-md-0"
                                                name="kppprofilepicture" accept="image/*" onchange="previewFile(this)"
                                                required />
                                        </div>
                                    </div>

                                    <!-- edit form column -->
                                    <div class="col-md-6 personal-info">
                                        <!--<form class="form-horizontal" role="form"> -->
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <input class="form-control" type="text" placeholder="Fullname"
                                                    name="fullname" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <input class="form-control" type="text" placeholder="6-Digit ID"
                                                    name="kppnum" pattern="[0-9]{6}" maxlength="6" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <input id="password" class="form-control" type="password"
                                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                                        placeholder="Password" name="kpppassword" required />
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
                                                        placeholder="Confirm Password" name="c_kpppassword" required />
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
                                                    data-target="#confirmationModal">Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to create this Kpp?
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