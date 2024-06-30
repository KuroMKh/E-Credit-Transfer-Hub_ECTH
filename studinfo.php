<?php include 'config/authentication.php';
include 'config/navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="x-icon" href="images/Tab_Icon.png">
    <title>Student Information | ECTH</title>
    <link rel="stylesheet" href="CSS/studinfo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="JS/confirmation.js"></script>
</head>

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
    <form action="studinfoprocces.php" method="post" enctype="multipart/form-data" id="submitForm">
        <div class="wrapper rounded bg-white">
            <div class="h3">Student Information</div>
            <div class="form">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Full Name</label>
                        <input type="text" class="form-control" name="fullname" placeholder="Enter Your Full name"
                            value="<?php if (isset($_SESSION['fullname']))
                                echo $_SESSION['fullname']; ?>" required />
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Matrix Number</label>
                        <input type="text" class="form-control" name="matrixnumber" value="<?php if (isset($_SESSION['matrixnumber'])) {
                            echo $_SESSION['matrixnumber'];
                        } ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Ic Number</label>
                        <input type="text" class="form-control" name="icnumber" placeholder="e.g., 123456789012" value="<?php if (isset($_SESSION['icnumber']))
                            echo $_SESSION['icnumber']; ?>" required />
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="numbphone" placeholder="e.g., 012-xxxx" value="<?php if (isset($_SESSION['numbphone']))
                            echo $_SESSION['numbphone']; ?>" required />

                    </div>
                </div>
            </div>

            <div class="form">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Admission Session</label>
                        <input type="text" class="form-control" name="adm_session" placeholder="e.g., 2021 / 2022"
                            value="<?php if (isset($_SESSION['adm_session'])) {
                                echo $_SESSION['adm_session'];
                            } ?>" required>
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Academic Year/Semester</label>
                        <input type="text" class="form-control" name="year_sem" placeholder="e.g., Tahun 1 / Semester 1"
                            value="<?php if (isset($_SESSION['year_sem'])) {
                                echo $_SESSION['year_sem'];
                            } ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Programme</label>
                        <select id="sub" name="programme" class="form-control" style="width: 207%;" required>
                            <option value="" <?php if (isset($_SESSION['programme']) && $_SESSION['programme'] == 'NULL')
                                echo 'selected'; ?> hidden>Select Programme</option>
                            <option value="ISMSKPP" <?php if (isset($_SESSION['programme']) && $_SESSION['programme'] == 'ISMSKPP')
                                echo 'selected'; ?>>ISMSKPP</option>
                            <option value="ISMSKKI" <?php if (isset($_SESSION['programme']) && $_SESSION['programme'] == 'ISMSKKI')
                                echo 'selected'; ?>>ISMSKKI</option>
                            <option value="ISMSKKRK" <?php if (isset($_SESSION['programme']) && $_SESSION['programme'] == 'ISMSKKRK')
                                echo 'selected'; ?>>ISMSKKRK</option>
                            <option value="ISMTMIM" <?php if (isset($_SESSION['programme']) && $_SESSION['programme'] == 'ISMTMIM')
                                echo 'selected'; ?>>ISMTMIM</option>
                        </select>

                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Faculty</label>
                        <input type="text" class="form-control" name="faculty"
                            placeholder="e.g., Fakulti Informatik dan Komputeran" value="<?php if (isset($_SESSION['faculty'])) {
                                echo $_SESSION['faculty'];
                            } ?>" required>
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Campus</label>
                        <input type="text" class="form-control" name="campus" placeholder="e.g., Besut" value="<?php if (isset($_SESSION['campus'])) {
                            echo $_SESSION['campus'];
                        } ?>" required>
                    </div>
                </div>
            </div>

            <div class="form">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Permanent Address</label>
                        <textarea class="form-control" name="perm_address"
                            placeholder="e.g., 123 Jalan Utama, Bandar, Negeri" required><?php if (isset($_SESSION['permanent'])) {
                                echo $_SESSION['permanent'];
                            } ?></textarea>
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Current Address</label>
                        <textarea class="form-control" name="curr_address"
                            placeholder="e.g., 123 Jalan Utama, Bandar, Negeri" required><?php if (isset($_SESSION['current'])) {
                                echo $_SESSION['current'];
                            } ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form">
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Previous Institution Name</label>
                        <input type="text" class="form-control" name="prev_inst"
                            placeholder="e.g., Politeknik Kuching Sarawak" value="<?php if (isset($_SESSION['prev_inst'])) {
                                echo $_SESSION['prev_inst'];
                            } ?>" required>
                    </div>
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Previous Programme</label>
                        <input type="text" class="form-control" name="prev_prog"
                            placeholder="e.g., Diploma Teknologi Maklumat" value="<?php if (isset($_SESSION['prev_prog'])) {
                                echo $_SESSION['prev_prog'];
                            } ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-md-0 mt-3">
                        <label>Upload Academic Transcript</label>
                        <input type="file" class="form-control" name="pdf_file" accept=".pdf" />
                        <small class="form-text text-muted">PDF Only (e.g., transcript_matrixnumber.pdf)</small>
                    </div>
                </div>
            </div>


            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                data-bs-target="#confirmationModal" id="showConfirmationModal">Update</button>

            <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmationModalLabel">Update it?</h5>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to proceed with the update?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No,
                                Cancel!</button>
                            <button type="submit" class="btn btn-success" name="submit" id="confirmSubmit">Yes,
                                Update
                                it!</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</body>

</html>