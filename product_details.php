<?php
session_start();

require_once './config/dbconnect.php';

// Check if product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details based on the ID
    $productQuery = "SELECT * FROM product WHERE product_id = $productId";
    $productResult = $conn->query($productQuery);

    // Check if the product is found
    if ($productResult->num_rows == 1) {
        $product = $productResult->fetch_assoc();
    } else {
        // Redirect or handle the case where the product is not found
        header('Location: main_page.php');
        exit();
    }
} else {
    // Redirect or handle the case where no product ID is provided
    header('Location: main_page.php');
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['product_name']; ?> Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
        }

        h1 {
            color: #333;
            margin: 20px 0;
        }

        .product-details {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin: 20px;
            box-sizing: border-box;
            max-width: 600px; /* Adjust the maximum width as needed */
            text-align: center;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .price {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }

        .description {
            color: #555;
            margin-bottom: 20px;
        }

        .add-to-cart-btn {
            background-color: #4caf50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .add-to-cart-btn:hover {
            background-color: #45a049;
        }

        /* Add your existing CSS styles here */

    </style>
</head>

<body>

    <header>
        <h2><?php echo $product['product_name']; ?> Details</h2>
    </header>

    <div class="product-details">
        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
        <h1><?php echo $product['product_name']; ?></h1>
        <p class="price">Price: $<?php echo $product['price']; ?></p>
        <p class="description"><?php echo $product['product_desc']; ?></p>

        <!-- Add to Cart button -->
        <button class="add-to-cart-btn" onclick="addToCart(<?php echo $product['product_id']; ?>)">Add to Cart</button>

        <!-- User Authentication Check -->
        <?php
        if (isset($_SESSION['user_id'])) {
            echo 'Welcome, User!';
        } else {
            echo 'Please log in to access more features. <a href="login.php">Login</a>';
        }
        ?>

        <!-- Product Reviews Display -->
        <div class="product-reviews">
            <h2>Product Reviews</h2>
            <!-- Fetch and display product reviews from the database here -->
        </div>
        

        <!-- Add more details or formatting as needed -->
    </div>

    <!-- Add more content or functionality as needed -->

    <!-- JavaScript for Add to Cart functionality -->
    <script>
        function addToCart(productId) {
            // You can use AJAX to send the product ID to a PHP script that handles adding to the cart
            // For simplicity, I'll provide a basic example using a JavaScript alert
            alert('Product added to cart. Product ID: ' + productId);
        }
    </script>

</body>

</html>
