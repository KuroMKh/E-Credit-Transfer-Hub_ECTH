<?php
session_start();

// Check if the kpp is logged in
if (!isset($_SESSION['logged_in_kpp'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}

$_SESSION['current_url'] = $_SERVER['REQUEST_URI'];
