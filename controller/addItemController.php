<?php
include_once "../config/dbconnect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    isset($_POST['p_name'], $_POST['p_price'], $_POST['p_desc'], $_POST['category'])) {

    $ProductName = $_POST['p_name'];
    $desc = $_POST['p_desc'];
    $price = $_POST['p_price'];
    $category = $_POST['category'];

    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];

        $location = "./uploads/";
        $image = $location . $name;

        $target_dir = "../uploads/";
        $finalImage = $target_dir . $name;

        // Déplacer le fichier téléchargé vers le répertoire final
        if (move_uploaded_file($temp, $finalImage)) {
            // Insérer le produit dans la base de données
            $insert = mysqli_query(
                $conn,
                "INSERT INTO product (product_name, product_image, price, product_desc, category_id) 
                VALUES ('$ProductName', '$image', $price, '$desc', '$category')"
            );

            if (!$insert) {
                echo "Erreur lors de l'insertion dans la base de données: " . mysqli_error($conn);
            } else {
                echo "Enregistrements ajoutés avec succès.";
                header("Location: ../index.php?poduct=success");
            }
        } else {
            echo "Erreur lors du déplacement du fichier vers le répertoire final.";
        }
    } else {
        echo "Veuillez sélectionner un fichier valide.";
    }
} else {
    echo "Veuillez fournir toutes les données nécessaires.";
}
?>
