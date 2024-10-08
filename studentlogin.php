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
    <link rel="stylesheet" href="CSS/login.css">
    <title>Log In | ECTH</title>
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

    <form action="studentloginprocess.php" method="post">

        <!----------------------- Main Container -------------------------->
        <div class="container d-flex justify-content-center align-items-center min-vh-100">

            <!----------------------- Login Container -------------------------->
            <div class="row border rounded-5 p-3 bg-white shadow box-area">

                <!--------------------------- Left Box ----------------------------->
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box"
                    style="background: #103cbe;">
                    <div class="featured-image mb-3">
                        <img src="images/courses.png" class="img-fluid" style="width: 250px;">
                    </div>
                    <p class="text-white fs-2"
                        style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Verified Credits</p>
                    <small class="text-white text-wrap text-center"
                        style="width: 17rem;font-family: 'Courier New', Courier, monospace;">Enhancing Your Academic
                        Experience.</small>
                </div>

                <!-------------------- ------ Right Box ---------------------------->
                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        <div class="header-text mb-4">
                            <h2>Hello Again!</h2>
                            <p>Welcome to Credit Transfer Hub.</p>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" name="uniszaemail"
                                placeholder="Matrix Number (6 Digit)" pattern="[0-9]{6}" maxlength="6" value="<?php if (isset($_COOKIE["studmatrix"])) {
                                    echo $_COOKIE["studmatrix"];
                                } ?>" required autocomplete="off">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6"
                                placeholder="Password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                value="<?php if (isset($_COOKIE["studpassword"])) {
                                    echo $_COOKIE["studpassword"];
                                } ?>" required autocomplete="off">
                            <span class="input-group-text" id="password-toggle"><i class="bi bi-eye-slash"
                                    id="password-icon"></i></span>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember
                                        Me</small></label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="login" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                        <div class="row">
                            <small>Thinking Transfer? <a href="validatestudent.php">Validate Account</a></small>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
    <script src="JS/password.js"></script>
</body>

</html>