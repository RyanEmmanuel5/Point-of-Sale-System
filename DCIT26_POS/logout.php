<?php
session_start(); // Start the session

// Destroy the session
session_unset();
session_destroy();

// Redirect to the login page or any other page (e.g., sweetthumb.php)
header('Location: sweetthumb.php');
exit();
?>
