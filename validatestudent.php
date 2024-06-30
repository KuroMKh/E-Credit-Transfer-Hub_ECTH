<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="x-icon" href="images/Tab_Icon.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="CSS/validate.css">
    <title>Validate | ECTH</title>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
        $bootstrap_class = ($_SESSION['response_type'] == 'warning') ? 'alert-warning' : 'alert-danger';
        echo '<div class="alert ' . $bootstrap_class . ' alert-dismissible fade show">';
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">';
        echo '</button>';
        echo $_SESSION['response_text'];
        echo '</div>';

        $_SESSION['response_type'] = '';
        $_SESSION['response_text'] = '';
    }
    ?>
    <form action="validatestudentprocess.php" method="post">

        <!-- Main Container -->
        <div class="container d-flex justify-content-center align-items-center min-vh-100 fixed-container">

            <!-- Signup Container -->
            <div class="row border rounded-5 p-3 bg-white shadow box-area">

                <!-- Right Box (Signup Form) -->
                <div class="col-md-12">
                    <div class="row align-items-center">
                        <div class="header-text mb-3"> <!-- Adjusted margin here -->
                            <h2>Validate Account</h2>
                        </div>
                        <!-- Image Div -->
                        <div class="text-center mb-3">
                            <img src="images/StudVal.png" alt="Image description" class="img-fluid"
                                style="max-width: 100%;">
                        </div>
                        <!-- End Image Div -->

                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Matrix number (6 Digit)" pattern="[0-9]{6}" name="uniszaemail"
                                maxlength="6" required autocomplete="off">
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password (ex: KassimBaba@00)"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" name="password" required
                                autocomplete="off">
                            <span class="input-group-text" id="password-toggle"><i class="bi bi-eye-slash"
                                    id="password-icon"></i></span>
                        </div>


                        <div class="input-group mb-3">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Confirm Password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                name="c_password" required autocomplete="off">
                            <span class="input-group-text" id="c-password-toggle"><i class="bi bi-eye-slash"
                                    id="c-password-icon"></i></span>
                        </div>

                        <div class="input-group mb-3">
                            <button type="submit" name="validate" class="btn btn-lg btn-primary w-100 fs-6">Validate
                                Now</button>
                        </div>
                        <div class="row text-center">
                            <small>Already Validated? <a href="studentlogin.php">Login here</a></small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <script src="JS/password.js"></script>
</body>

</html>