<?php
session_start();

if (isset($_POST['yes'])) {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
} else {
    header('Location: ../Home.php');
}