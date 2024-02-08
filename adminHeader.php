<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
include_once "./config/dbconnect.php";
?>

<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #89cac7;">

    <a class="navbar-brand ml-5" href="./index.php">
        <img src="./assets/images/logo.png" width="80" height="80" alt="Swiss Collection">
    </a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>

    <div class="user-cart">
        <?php
        if (isset($_SESSION['username'])) {
            ?>
            <a href="" style="text-decoration:none;">
                <i class="fa fa-user mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>
            <!-- Add the "Déconnexion" button here -->
            <a href="deconnexion.php" style="text-decoration:none;">
                <i class="fa fa-sign-out mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>
        <?php
        } else {
            ?>
            <a href="" style="text-decoration:none;">
                <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>
        <?php
        } ?>
    </div>
</nav>
