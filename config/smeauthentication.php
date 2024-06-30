<?php
session_start();

// Check if the kpp is logged in
if (!isset($_SESSION['logged_in_sme'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}
