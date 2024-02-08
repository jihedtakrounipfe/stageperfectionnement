<?php
session_start();

// Include database connection details
include_once './config/dbconnect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];

// Use prepared statement to prevent SQL injection
$userQuery = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
$userQuery->bind_param('i', $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
} else {
    // Handle the case where user details are not found
    header("Location: login.php");
    exit();
}

// Fetch products from the database
$productsQuery = "SELECT * FROM product";
$productsResult = $conn->query($productsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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

        h1 {
            text-align: center;
            color: #000000;
            margin-bottom: 20px;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .price {
            font-weight: bold;
        }

        .logout-btn {
            background-color: #ff0000;
            color: #ffffff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <h1>Welcome, <?php echo $user['first_name']; ?>!</h1>

    <!-- Display all products and prices -->
    <?php if ($productsResult->num_rows > 0): ?>
        <h2>All Products:</h2>
        <?php while ($product = $productsResult->fetch_assoc()): ?>
            <div class="product">
                <h3><?php echo $product['product_name']; ?></h3>
                <p class="price">Price: $<?php echo $product['price']; ?></p>
                <!-- Add more details or formatting as needed -->
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>

    <!-- Logout button -->
    <form method="post" action="logout.php">
        <button type="submit" class="logout-btn">Logout</button>
    </form>

    <!-- Add more content or functionality as needed -->

</body>
</html>
