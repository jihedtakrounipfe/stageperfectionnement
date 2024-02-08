<?php
// auth_functions.php

// Include necessary files
include_once "./config/dbconnect.php";

// Function to check if the user is logged in
function isUserLoggedIn()
{
    return isset($_SESSION['user']);
}

// Function to authenticate user
function authenticateUser($conn, $username, $password)
{
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user'] = $row['username'];
        return true;
    } else {
        return false;
    }
}
?>
