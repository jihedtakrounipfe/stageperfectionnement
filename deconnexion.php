<?php
session_start();
session_destroy(); // Destroy the session

// Redirect to the login page after logout
header("Location: login.php");
exit();
echo '<script>window.location.replace("login.php");</script>';
exit();
?>
