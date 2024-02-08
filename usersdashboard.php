<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();

// Check if the user is already logged in, redirect to index.php
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Validate and sanitize user input
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Include your existing database connection code here

try {
    // Example authentication logic using prepared statements
    $stmt = $pdo->prepare("SELECT id, username, password_hash, is_admin FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $userRow = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userRow && password_verify($password, $userRow['password_hash'])) {
        // Authentication successful, set user session and check if admin
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = (bool) $userRow['is_admin'];

        // Redirect to the appropriate dashboard (admin or regular user)
        header($_SESSION['is_admin'] ? "Location: index.php" : "Location: usersdashboard.php");
        exit();
    } else {
        // Authentication failed, redirect to the login page with an error message
        header("Location: connexion.html?error=1");
        exit();
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>
