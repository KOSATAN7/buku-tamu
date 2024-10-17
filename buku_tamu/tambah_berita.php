<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    // If not logged in, redirect to login page
    header("Location: login.php");
    exit;
}
?>