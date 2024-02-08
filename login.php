<?php
session_start();

include_once './config/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    try {
        $stmt = $conn->prepare("SELECT user_id, email, password, isAdmin FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userRow = $result->fetch_assoc();

        if ($userRow && password_verify($password, $userRow['password'])) {
            $_SESSION['username'] = $email;
            $_SESSION['is_admin'] = (bool) $userRow['isAdmin'];

            if ($_SESSION['is_admin']) {
                header("Location: index.php");
            } else {
                header("Location: user.php");
            }
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } catch (Exception $e) {
        error_log("Authentication error: " . $e->getMessage(), 0);
        header("Location: login.php?error=2");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #000000;
            margin-bottom: 50px;
        }

        form {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #2ecc71;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #27ae60;
        }

        button + button {
            margin-top: 10px;
            background-color: #3498db;
        }

        button + button:hover {
            background-color: #2980b9;
        }

        p.error {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
        .login-container {
            background-color: #fbfbfb;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 40px;
            width: 320px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Roboto', sans-serif;
        }
    </style>
    <script>
        // Disable the back button
        history.pushState(null, null, document.URL);
        window.addEventListener('popstate', function () {
            history.pushState(null, null, document.URL);
        });
    </script>
</head>
<body>

<div class="login-container">
    <h2>Secure Login</h2>

    <form method="post" action="">
        <label for="username">Email:</label>
        <input type="text" name="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <?php
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo "<p class='error'>Invalid username or password. Please try again.</p>";
        } elseif (isset($_GET['error']) && $_GET['error'] == 2) {
            echo "<p class='error'>An error occurred during authentication. Please try again later.</p>";
        }
        ?>

        <button type="submit" name="login">Login</button>
        <button type="submit" name="register">Register</button>
    </form>
</div>

</body>
</html>
