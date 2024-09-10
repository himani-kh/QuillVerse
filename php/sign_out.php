<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Unset the session cookie by setting its expiration time to a past value
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/');
}

// Redirect the user to the login page or any other page
header("Location: ../php/index.php");
exit();
?>
