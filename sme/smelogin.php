<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="x-icon" href="../images/Tab_Icon.png">
    <title>SME Login | ECTH</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/kpplogin.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../JS/kpppassword.js"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_SESSION['response_type']) && $_SESSION['response_type'] != '') {
        $bootstrap_class = ($_SESSION['response_type'] == 'warning') ? 'alert-warning' : 'alert-danger';
        echo '<div id="alert" class="alert ' . $bootstrap_class . ' alert-dismissible fade show" role="alert">';
        echo $_SESSION['response_text'];
        echo '<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        echo '</div>';

        $_SESSION['response_type'] = '';
        $_SESSION['response_text'] = '';
    }
    ?>

    <form action="smeloginprocess.php" method="post">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                    <div class="card border border-light-subtle rounded-3 shadow-sm">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <h2 class="text-center">Welcome back to ECTH!</h2>
                            <div class="text-center mb-3">
                                <a href="#!">
                                    <img src="../images/smelogo.png" alt="logo" width="145" height="145" />
                                </a>
                            </div>
                            <div class="col-12 position-relative">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="smeemail" id="email"
                                        placeholder="Sme Number (6 Digit)" required autocomplete="off"
                                        pattern="[0-9]{6}" value="<?php if (isset($_COOKIE["smeemail"])) {
                                            echo $_COOKIE["smeemail"];
                                        } ?>" maxlength="6" />
                                </div>
                            </div>
                            <div class="col-12 position-relative">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="smepassword"
                                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$" id="password" value="<?php if (isset($_COOKIE["smepassword"])) {
                                            echo $_COOKIE["smepassword"];
                                        } ?>" placeholder="Password" required autocomplete="off" />
                                    <span class="toggle-password fas fa-eye-slash"
                                        onclick="togglePasswordVisibility()"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex gap-2 justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" name="remember"
                                            id="remember" />
                                        <label class="form-check-label text-secondary">Remember
                                            Me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-grid my-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit" name="login">
                                        Log in
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
    $(document).ready(function () {
        // Dismiss alert when close button is clicked
        $('.alert .close').on('click', function () {
            $(this).parent().alert('close');
        });
    });
</script>

</html>