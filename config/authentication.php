<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in_user'])) {
    // If not logged in, redirect to the login page
    header("Location: index.php");
    exit();
}
