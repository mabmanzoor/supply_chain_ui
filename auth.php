<?php
// auth.php
session_start();

// Agar login nahi kia hua:
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
