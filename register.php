<?php
session_start();

// Check if the user is already logged in, redirect to index.php
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include the database connection code
include_once './config/dbconnect.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if the username is already taken
        $checkStmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $checkStmt->bind_param('s', $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Username is already taken, redirect with an error message
            redirectToRegisterPageWithError(1);
        }

        // Insert the new user into the database
        $insertStmt = $conn->prepare("INSERT INTO users (email, password, isAdmin) VALUES (?, ?, 0)");
        $insertStmt->bind_param('ss', $username, $hashedPassword);
        $insertStmt->execute();

        // Registration successful, set user session
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = false;

        // Redirect to the login page
        header("Location: login.php");
        exit();
    } catch (Exception $e) {
        // Log the error to a file or a log table in the database
        error_log("Registration error: " . $e->getMessage(), 0);
        redirectToRegisterPageWithError(2);
    }
}

function redirectToRegisterPageWithError($errorCode) {
    // Redirect to the register page with an error code
    header("Location: register.php?error=$errorCode");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your Community</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 40px;
            width: 320px;
            font-family: 'Roboto', sans-serif;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: #333;
            text-align: center;
        }

        label {
            margin-bottom: 5px;
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            font-weight: 700;
            font-size: 16px;
        }

        button:hover {
            background-color: #0069d9;
        }

        p.error {
            color: #dc3545;
            margin-top: 10px;
            text-align: center;
            font-size: 14px;
        }

        .info {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Join Our Community</h2>

    <?php
    // Display error messages if any
    if (isset($_GET['error']) && $_GET['error'] == 1) {
        echo "<p class='error'>Username is already taken. Please choose another.</p>";
    } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
        echo "<p class='error'>An error occurred during registration. Please try again later.</p>";
    }
    ?>

    <form method="post" action="">
        <label for="username">Email:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Register</button>
    </form>

    <p class="info">Already have an account? <a href="login.php">Log in here.</a></p>
</div>

</body>
</html>
