<?php
/* LOGOUT PROCESS */
session_start(); // Start the session

// Unset session variable stdID
unset($_SESSION["stdID"]);

// Destroy the session
session_destroy();

// Remove the session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie("rememberUser", "", time() - 3600, "/"); // Set cookie expirationn to 1 hour ago
}

header("Location: ../loginPage.php"); // Redirect to login page
exit;
?>
