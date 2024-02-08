-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 jan. 2024 à 14:57
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `swiss_collection`
--

-- --------------------------------------------------------

--
-- Structure de la table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`cart_id`),
  UNIQUE KEY `uc_cart` (`user_id`,`variation_id`),
  KEY `variation_id` (`variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(150) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Tops'),
(2, 'Dresses'),
(3, 'Pants'),
(15, 'shoes'),
(24, 'shoes');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivered_to` varchar(150) NOT NULL,
  `phone_no` varchar(10) NOT NULL,
  `deliver_address` varchar(255) NOT NULL,
  `pay_method` varchar(50) NOT NULL,
  `pay_status` int(11) NOT NULL,
  `order_status` int(11) NOT NULL DEFAULT '0',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `delivered_to`, `phone_no`, `deliver_address`, `pay_method`, `pay_status`, `order_status`, `order_date`) VALUES
(1, 2, 'Self', '9802234675', 'Matepani-12', 'Cash', 0, 0, '2022-04-09 22:00:00'),
(3, 2, 'Test  Firstuser', '980098322', 'matepani-12', 'Khalti', 1, 0, '2022-04-17 22:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `variation_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `variation_id` (`variation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `variation_id`, `quantity`, `price`) VALUES
(1, 1, 1, 1, 500),
(3, 3, 3, 1, 890);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(200) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `uploaded_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_desc`, `product_image`, `price`, `category_id`, `uploaded_date`) VALUES
(1, 'V Neck Crop Top', 'V neckline and Drawstring style make you more sexy Match well with your skinny leggings, pants or jeans for a fashion look Suitable for casual, home.', './uploads/v-neck.jpg', 300, 1, '2022-03-27 22:00:00'),
(2, 'Off Shoulder Crop Top', 'Crop Tops for Women Basic Off Shoulder Sexy Print V Neck Slim Shirt Vest with Button at Swiss Collecttion.', './uploads/offshoulder.jpg', 890, 1, '2022-04-03 22:00:00'),
(3, 'Off Shoulder Tops', 'Tops for Women Basic Off Shoulder V Neck Slim Shirt Vest with Button at Swiss Collecttion.', './uploads/tops.jpg', 600, 1, '2022-04-03 22:00:00'),
(4, 'Printed Crop Top', 'Cute Crop Tops for Women Basic Off Shoulder Sexy Print V Neck Slim Shirt Vest with Button at Swiss Collecttion.', './uploads/croptop.jpg', 700, 1, '2022-04-03 22:00:00'),
(5, 'Shirtdress', 'Shirt Dresses for Women Basic dresses with Button at Swiss Collecttion.', './uploads/shirtdress.jpg', 1850, 2, '2022-04-03 22:00:00'),
(6, 'Check Strappy Dress', 'Check Strappy Dresses for Women Basic dresses with Button at Swiss Collecttion.', './uploads/check-strappy-dress.jpg', 1250, 2, '2022-03-23 23:00:00'),
(7, 'Floral Dress', 'Floral Dresses for Women Basic dresses with Button at Swiss Collecttion.', './uploads/dress.jpg', 1500, 2, '2022-04-03 22:00:00'),
(9, 'Floral Dress', 'Floral Dresses for Women Basic dresses with Button at Swiss Collecttion.', './uploads/27496570_1290814924398478_1391309720_n - Copie.jpg', 1500, 2, '2024-01-31 14:50:51'),
(10, 'Floral Dress', 'Floral Dresses for Women Basic dresses with Button at Swiss Collecttion.', './uploads/27497226_1290815664398404_613740604_n - Copie.jpg', 1500, 3, '2024-01-31 14:52:06');

-- --------------------------------------------------------

--
-- Structure de la table `product_size_variation`
--

DROP TABLE IF EXISTS `product_size_variation`;
CREATE TABLE IF NOT EXISTS `product_size_variation` (
  `variation_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `quantity_in_stock` int(11) NOT NULL,
  PRIMARY KEY (`variation_id`),
  UNIQUE KEY `uc_ps` (`product_id`,`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `product_size_variation`
--

INSERT INTO `product_size_variation` (`variation_id`, `product_id`, `size_id`, `quantity_in_stock`) VALUES
(1, 1, 4, 8),
(2, 2, 3, 9),
(3, 2, 2, 3),
(6, 3, 3, 6),
(7, 4, 2, 8),
(8, 5, 4, 8),
(9, 6, 2, 10),
(10, 7, 2, 10),
(11, 3, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `review_desc` text NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `review`
--

INSERT INTO `review` (`review_id`, `user_id`, `product_id`, `review_desc`) VALUES
(1, 2, 2, 'Comfortable and stylish. I loved it.'),
(2, 2, 5, 'Perfect dress for summer.');

-- --------------------------------------------------------

--
-- Structure de la table `sizes`
--

DROP TABLE IF EXISTS `sizes`;
CREATE TABLE IF NOT EXISTS `sizes` (
  `size_id` int(11) NOT NULL AUTO_INCREMENT,
  `size_name` varchar(100) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`) VALUES
(1, 'S'),
(2, 'L'),
(3, 'M'),
(4, 'Free'),
(6, 'xl'),
(8, 'XXL');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(150) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `registered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  `user_address` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `contact_no`, `registered_at`, `isAdmin`, `user_address`) VALUES
(1, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$j9OXXIYS0CG5AYuks62YMeDvuIpo2hZEN4CqfJfujt1yPMnoUq5C6', '9810283472', '2022-04-09 22:00:00', 1, 'newroad'),
(2, 'Test ', 'Firstuser', 'test@gmail.com', '$2y$10$DJOdhZy1InHTKQO6whfyJexVTZCDTlmIYGCXQiPTv7l82AdC9bWHO', '980098322', '2022-04-09 22:00:00', 0, 'matepani-12');

-- --------------------------------------------------------

--
-- Structure de la table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `wish_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  PRIMARY KEY (`wish_id`),
  UNIQUE KEY `uc_wish` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
