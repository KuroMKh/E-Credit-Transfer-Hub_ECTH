<?php
include 'config/authentication.php';
include 'config/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Profile | ECTH</title>
        <link rel="stylesheet" href="CSS/studentprofile.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="JS/changepicture.js"></script>

<body>
        <?php
        if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
                $bootstrap_class = '';

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

                echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show">';
                echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">';
                echo '</button>';
                echo $_SESSION['response_text'];
                echo '</div>';

                $_SESSION['response_type'] = '';
                $_SESSION['response_text'] = '';

        }
        ?>
        <div class="container-xl px-4 mt-4">
                <div class="row">
                        <div class="col-xl-4">
                                <!-- Profile picture card-->
                                <form action="studentprofilepicprocess.php" method="post" enctype="multipart/form-data"
                                        id="submitForm">
                                        <div class="card mb-4 mb-xl-0">
                                                <div class="card-header">Profile Picture</div>
                                                <div class="card-body text-center">
                                                        <!-- Student Profile image-->
                                                        <img class="img-account-profile rounded-circle mb-2"
                                                                id="profileImage" src="<?php if (isset($_SESSION['picture'])) {
                                                                        echo $_SESSION['picture'];
                                                                } else {
                                                                        echo 'uploads/profilepicture/studentprofile.png';
                                                                } ?>" alt="Student Profile Icon" width="150"
                                                                height="150">
                                                        <!-- Student Profile picture help block-->
                                                        <div class="small font-italic text-muted mb-4">
                                                                <?php echo $_SESSION['uniszaemail']; ?>
                                                        </div>
                                                        <!-- Hidden file input to select a new image -->
                                                        <input type="file" name="newProfileImage"
                                                                accept=".jpeg, .jpg, .png" style="display: none;"
                                                                id="fileInput" onchange="displaySelectedImage()">
                                                        <!-- Button to trigger the file input -->
                                                        <button class="btn btn-primary" type="button"
                                                                onclick="triggerFileInput()">Change Picture</button>
                                                        <div class="mt-2"></div>
                                                        <!-- Submit button to trigger the form submission -->
                                                        <button class="btn btn-success" type="submit" name="submit">Save
                                                                Changes</button>
                                                </div>
                                        </div>
                                </form>
                        </div>
                        <div class="col-xl-8">
                                <!-- Student's Details card-->
                                <div class="card mb-4">
                                        <div class="card-header">Student's Details</div>
                                        <div class="card-body">
                                                <div class="row gx-3 mb-3">
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Full Name</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['fullname'])) {
                                                                                echo $_SESSION['fullname'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Matrix Number</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['matrixnumber'])) {
                                                                                echo $_SESSION['matrixnumber'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Ic Number</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['icnumber'])) {
                                                                                echo $_SESSION['icnumber'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Phone Number</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['numbphone'])) {
                                                                                echo $_SESSION['numbphone'];
                                                                        } ?>" readonly>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <!-- UniSZA's Academic Details card-->
                                <div class="card mb-4">
                                        <div class="card-header">UniSZA's Academic Details</div>
                                        <div class="card-body">
                                                <div class="row gx-3 mb-3">
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Admission Session</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['adm_session'])) {
                                                                                echo $_SESSION['adm_session'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Academic Year/Semester</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['year_sem'])) {
                                                                                echo $_SESSION['year_sem'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Programme</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['programme'])) {
                                                                                echo $_SESSION['programme'];
                                                                        } ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Faculty</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['faculty'])) {
                                                                                echo $_SESSION['faculty'];
                                                                        } ?>" readonly>
                                                        </div>

                                                        <div class="col-md-6">
                                                                <label class="small mb-1">Campus</label>
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['campus'])) {
                                                                                echo $_SESSION['campus'];
                                                                        } ?>" readonly>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                                <!-- Student's Address Details card-->
                                <div class="card mb-4">
                                        <div class="card-header">Student's Address Details</div>
                                        <div class="card-body">
                                                <div class="mb-3">
                                                        <label class="small mb-1">Permanent Address</label>
                                                        <textarea class="form-control" placeholder="--Null--"
                                                                readonly><?php echo isset($_SESSION['permanent']) ? $_SESSION['permanent'] : ''; ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                        <label class="small mb-1">Current Address</label>
                                                        <textarea class="form-control" placeholder="--Null--"
                                                                readonly><?php echo isset($_SESSION['current']) ? $_SESSION['current'] : ''; ?></textarea>
                                                </div>
                                        </div>
                                </div>
                                <!-- Previous Academic Details card-->
                                <div class="card mb-4">
                                        <div class="card-header">Previous Academic Details</div>
                                        <div class="card-body">
                                                <div class="mb-3">
                                                        <label class="small mb-1">Previous Institution Name</label>
                                                        <input class="form-control" type="text" placeholder="--Null--"
                                                                value="<?php if (isset($_SESSION['prev_inst'])) {
                                                                        echo $_SESSION['prev_inst'];
                                                                } ?>" readonly>
                                                </div>
                                                <div class="mb-3">
                                                        <label class="small mb-1">Previous Programme</label>
                                                        <input class="form-control" type="text" placeholder="--Null--"
                                                                value="<?php if (isset($_SESSION['prev_prog'])) {
                                                                        echo $_SESSION['prev_prog'];
                                                                } ?>" readonly>
                                                </div>

                                                <div class="mb-3">
                                                        <label class="small mb-1">Previous Academic Transcript</label>
                                                        <div class="d-flex">
                                                                <input class="form-control" type="text"
                                                                        placeholder="--Null--" value="<?php if (isset($_SESSION['file'])) {
                                                                                echo basename($_SESSION['file']);
                                                                        } ?>" readonly>

                                                                <div class="ml-2">
                                                                        <a href="<?php if (isset($_SESSION['file'])) {
                                                                                echo $_SESSION['file'];
                                                                        } ?>" target="_blank"
                                                                                class="btn btn-sm btn-primary">Open
                                                                                PDF</a>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>
                                </div>
                        </div>


                </div>

        </div>
</body>

</html>