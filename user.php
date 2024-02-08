<?php
session_start();

require_once './config/dbconnect.php';

// Vérification de la session
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

// Récupération des informations de l'utilisateur
$username = $_SESSION['username'];

// Nombre maximum de produits par page
$productsPerPage = 9;

// Récupération du numéro de page actuel
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Calcul de l'offset pour la requête SQL
$offset = ($currentPage - 1) * $productsPerPage;

// Requête pour obtenir les produits avec pagination
$productsQuery = "SELECT * FROM product LIMIT $offset, $productsPerPage";
$productsResult = $conn->query($productsQuery);

// Requête pour obtenir les informations de l'utilisateur
$userQuery = "SELECT * FROM users WHERE email = '$username'";
$userResult = $conn->query($userQuery);

// Vérification si les informations de l'utilisateur sont récupérées avec succès
if ($userResult->num_rows == 1) {
    $user = $userResult->fetch_assoc();
} else {
    // Gérer le cas où les informations de l'utilisateur ne sont pas trouvées
    echo "User information not found.";
    exit();
}

// Requête pour obtenir le nombre total de produits
$totalProductsQuery = "SELECT COUNT(*) as total FROM product";
$totalProductsResult = $conn->query($totalProductsQuery);
$totalProducts = $totalProductsResult->fetch_assoc()['total'];

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
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            color: #000000;
            margin: 20px 0;
        }

        .products-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: calc(33.33% - 20px); /* Adjust width for 3 products in a row */
            box-sizing: border-box;
        }

        .product img {
    max-width: 100%;
    max-height: 150px; /* Ajustez la hauteur maximale selon vos besoins */
    margin-bottom: 10px;
    width: 100%;
    height: auto;
    object-fit: cover; /* Pour conserver les proportions de l'image */
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
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
        }

        .pagination a {
            margin: 0 5px;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #f1f1f1;
            color: #000;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>

    <header>
        <h2>Catalogs</h2>
        <form method="post" action="deconnexion.php">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <h1>Welcome, <?php echo $user['first_name']; ?>!</h1>

    <!-- Display all products in a row with images -->
    <div class="products-container">
    <?php if ($productsResult->num_rows > 0): ?>
        <?php while ($product = $productsResult->fetch_assoc()): ?>
            <div class="product">
                <a href="product_details.php?id=<?php echo $product['product_id']; ?>">
                    <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
                </a>
                <h3><?php echo $product['product_name']; ?></h3>
                <p class="price">Price: $<?php echo $product['price']; ?></p>
                <!-- Add more details or formatting as needed -->
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No products found.</p>
    <?php endif; ?>
</div>

    <!-- Pagination links -->
    <?php
    $totalPages = ceil($totalProducts / $productsPerPage);

    echo '<div class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<a href="?page=' . $i . '" ' . ($currentPage == $i ? 'class="active"' : '') . '>' . $i . '</a>';
    }
    echo '</div>';
    ?>

    <!-- Add more content or functionality as needed -->

</body>

</html>
