<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Assurez-vous que l'utilisateur est authentifié avant d'accéder au tableau de bord
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: connexion.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
</head>
<body>
    <h2>Bienvenue sur le tableau de bord, <?php echo $_SESSION['username']; ?>!</h2>
    <!-- Ajoutez ici le contenu de votre tableau de bord -->
    <p><a href="deconnexion.php">Déconnexion</a></p>
</body>
</html>
