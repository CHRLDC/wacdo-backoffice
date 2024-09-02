-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le :  lun. 02 sep. 2024 à 12:37
-- Version du serveur :  10.3.39-MariaDB-0+deb10u2
-- Version de PHP :  7.3.31-1~deb10u7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `projets_exam-back_cdacosta`
--

-- --------------------------------------------------------

--
-- Structure de la table `Account_manage`
--

CREATE TABLE `Account_manage` (
  `id` int(11) NOT NULL,
  `User` int(11) DEFAULT NULL,
  `date_token_mail` datetime DEFAULT NULL,
  `date_validation_mail` datetime DEFAULT NULL,
  `status` enum('active','blocked','invalid') DEFAULT NULL,
  `token_reset_mdp` varchar(255) DEFAULT NULL,
  `compteur_echec` int(11) DEFAULT 0,
  `date_creation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Account_manage`
--

INSERT INTO `Account_manage` (`id`, `User`, `date_token_mail`, `date_validation_mail`, `status`, `token_reset_mdp`, `compteur_echec`, `date_creation`) VALUES
(1, 1, '2024-08-31 17:11:42', '2024-08-25 12:04:00', 'active', '995716ecde7794452413f8e8c13802e8', 0, '2024-08-25 12:00:00'),
(2, 3, '2024-08-29 14:31:28', NULL, NULL, '70bd115a81bd02a1e298fbca76d56417', NULL, '2024-08-29 12:21:11'),
(3, 4, '2024-08-29 13:36:35', NULL, NULL, '7f1b84f3cf94de401962947af87674d6', NULL, '2024-08-29 13:36:17');

-- --------------------------------------------------------

--
-- Structure de la table `Category`
--

CREATE TABLE `Category` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Category`
--

INSERT INTO `Category` (`id`, `title`, `image_path`) VALUES
(1, 'menus', '/categories/menus.png'),
(2, 'boissons', '/categories/boissons.png'),
(3, 'burgers', '/categories/burgers.png'),
(4, 'frites', '/categories/frites.png'),
(5, 'encas', '/categories/encas.png'),
(6, 'wraps', '/categories/wraps.png'),
(7, 'salades', '/categories/salades.png'),
(8, 'desserts', '/categories/desserts.png'),
(9, 'sauces', '/categories/sauces.png');

-- --------------------------------------------------------

--
-- Structure de la table `Element`
--

CREATE TABLE `Element` (
  `id` int(11) NOT NULL,
  `type` enum('menu','item') DEFAULT NULL,
  `size_menu` enum('maxi','normal') DEFAULT NULL,
  `size_item` enum('30Cl','50Cl') DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Element`
--

INSERT INTO `Element` (`id`, `type`, `size_menu`, `size_item`, `quantity`, `price`) VALUES
(182, 'menu', 'maxi', NULL, 1, '8.80'),
(183, 'item', NULL, '50Cl', 2, '1.90'),
(184, 'item', NULL, NULL, 2, '3.20'),
(185, 'item', NULL, '50Cl', 2, '2.30'),
(186, 'item', NULL, NULL, 1, '4.20'),
(187, 'item', NULL, NULL, 1, '4.40'),
(188, 'menu', 'maxi', NULL, 1, '8.80'),
(189, 'item', NULL, NULL, 1, '6.80'),
(190, 'item', NULL, NULL, 1, '6.80'),
(191, 'item', NULL, NULL, 1, '2.60'),
(192, 'item', NULL, '50Cl', 2, '1.00'),
(193, 'menu', 'maxi', NULL, 1, '8.00'),
(194, 'item', NULL, NULL, 1, '2.60'),
(195, 'menu', 'maxi', NULL, 1, '8.80'),
(196, 'menu', 'maxi', NULL, 1, '8.00'),
(197, 'item', NULL, NULL, 2, '6.80'),
(198, 'item', NULL, NULL, 5, '3.10'),
(199, 'menu', 'normal', NULL, 1, '8.80'),
(200, 'item', NULL, '50Cl', 1, '1.90'),
(201, 'item', NULL, NULL, 1, '2.60'),
(202, 'item', NULL, '50Cl', 2, '1.90'),
(203, 'item', NULL, NULL, 1, '8.80'),
(204, 'item', NULL, NULL, 1, '4.20'),
(205, 'menu', 'maxi', NULL, 1, '8.80'),
(206, 'item', NULL, NULL, 1, '3.30'),
(207, 'menu', 'maxi', NULL, 1, '8.80'),
(208, 'item', NULL, NULL, 1, '3.10'),
(209, 'menu', 'normal', NULL, 1, '10.60'),
(210, 'item', NULL, NULL, 1, '2.75'),
(211, 'item', NULL, NULL, 1, '3.10'),
(212, 'item', NULL, NULL, 1, '3.30'),
(213, 'item', NULL, NULL, 1, '3.10'),
(214, 'item', NULL, '50Cl', 1, '1.90'),
(215, 'item', NULL, '50Cl', 2, '1.90'),
(216, 'menu', 'maxi', NULL, 1, '8.80'),
(217, 'item', NULL, NULL, 1, '3.30');

-- --------------------------------------------------------

--
-- Structure de la table `Element_Product`
--

CREATE TABLE `Element_Product` (
  `id` int(11) NOT NULL,
  `Element` int(11) DEFAULT NULL,
  `Product` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Element_Product`
--

INSERT INTO `Element_Product` (`id`, `Element`, `Product`) VALUES
(133, 182, 1),
(134, 182, 53),
(135, 182, 37),
(136, 182, 27),
(137, 183, 27),
(138, 184, 41),
(139, 185, 34),
(140, 186, 42),
(141, 186, 54),
(142, 187, 50),
(143, 188, 1),
(144, 188, 53),
(145, 188, 27),
(146, 189, 14),
(147, 190, 14),
(148, 191, 44),
(150, 192, 27),
(151, 193, 1),
(152, 193, 53),
(153, 193, 37),
(154, 193, 27),
(155, 194, 65),
(156, 195, 1),
(157, 195, 53),
(158, 195, 60),
(159, 195, 27),
(160, 196, 1),
(161, 196, 53),
(162, 196, 35),
(163, 196, 27),
(164, 197, 14),
(165, 198, 63),
(166, 199, 1),
(167, 199, 53),
(168, 199, 35),
(169, 199, 27),
(170, 200, 27),
(171, 201, 40),
(172, 202, 28),
(173, 203, 62),
(174, 204, 42),
(175, 204, 54),
(176, 205, 1),
(177, 205, 53),
(178, 205, 27),
(179, 206, 64),
(180, 207, 1),
(181, 207, 53),
(182, 207, 27),
(183, 208, 45),
(184, 209, 2),
(185, 209, 53),
(186, 209, 35),
(187, 209, 27),
(188, 210, 36),
(189, 211, 46),
(190, 212, 60),
(191, 213, 45),
(192, 214, 28),
(193, 215, 27),
(194, 216, 1),
(195, 216, 54),
(196, 216, 37),
(197, 216, 28),
(198, 217, 60);

-- --------------------------------------------------------

--
-- Structure de la table `Order`
--

CREATE TABLE `Order` (
  `id` int(11) NOT NULL,
  `number` varchar(255) DEFAULT NULL,
  `place_number` int(11) DEFAULT NULL,
  `orderType` enum('eatIn','takeOut') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `status` enum('standby','delivered','prepared','canceled','inProgress') DEFAULT NULL,
  `User` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Order`
--

INSERT INTO `Order` (`id`, `number`, `place_number`, `orderType`, `amount`, `status`, `User`, `created_date`, `delivered_date`) VALUES
(141, '2024-080001', NULL, 'takeOut', '19.00', 'delivered', 1, '2024-08-28 17:31:57', '2024-09-02 10:23:13'),
(142, '55', 532, 'eatIn', '23.50', 'delivered', NULL, '2024-08-30 09:06:11', '2024-09-01 10:36:55'),
(143, '31', NULL, 'takeOut', '6.80', 'delivered', NULL, '2024-08-30 09:06:35', '2024-09-02 10:22:29'),
(144, '28', 255, 'eatIn', '6.80', 'delivered', NULL, '2024-08-30 14:06:29', '2024-09-01 10:39:22'),
(145, '2024-080029', NULL, 'eatIn', '2.60', 'standby', 1, '2024-08-31 13:41:22', NULL),
(146, '2024-080030', NULL, 'takeOut', '2.00', 'inProgress', 1, '2024-08-31 13:46:43', NULL),
(147, '2024-080031', NULL, 'eatIn', '2.00', 'standby', 1, '2024-08-31 13:50:12', NULL),
(148, '2024-080032', NULL, 'takeOut', '8.00', 'canceled', 1, '2024-08-31 13:51:49', NULL),
(149, '84', 910, 'eatIn', '11.90', 'inProgress', NULL, '2024-08-31 14:08:06', NULL),
(150, '2024-080085', NULL, 'eatIn', '8.00', 'inProgress', 1, '2024-08-31 14:29:56', NULL),
(151, '2024-090086', NULL, 'takeOut', '13.60', 'prepared', 1, '2024-09-01 11:18:43', NULL),
(152, '2024-090087', NULL, 'takeOut', '24.30', 'standby', 1, '2024-09-01 11:42:13', NULL),
(153, '2024-090088', NULL, 'eatIn', '1.90', 'standby', 1, '2024-09-01 11:42:33', NULL),
(154, '82', 534, 'eatIn', '2.60', 'standby', NULL, '2024-09-01 18:34:53', NULL),
(155, '46', 975, 'eatIn', '27.10', 'delivered', NULL, '2024-09-01 18:40:53', '2024-09-02 12:15:19'),
(156, '22', 450, 'eatIn', '12.60', 'standby', NULL, '2024-09-02 10:33:33', NULL),
(157, '2024-090023', NULL, 'takeOut', '13.70', 'standby', 1, '2024-09-02 10:34:39', NULL),
(158, '96', 255, 'eatIn', '2.75', 'standby', NULL, '2024-09-02 10:35:40', NULL),
(159, '2024-090097', NULL, 'takeOut', '24.00', 'standby', 1, '2024-09-02 11:55:28', NULL),
(160, '2024-090098', NULL, 'eatIn', '3.30', 'standby', 4, '2024-09-02 12:15:12', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `Order_Element`
--

CREATE TABLE `Order_Element` (
  `id` int(11) NOT NULL,
  `Order` int(11) DEFAULT NULL,
  `Element` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Order_Element`
--

INSERT INTO `Order_Element` (`id`, `Order`, `Element`) VALUES
(192, 141, 182),
(193, 141, 183),
(194, 141, 184),
(195, 142, 185),
(196, 142, 186),
(197, 142, 187),
(198, 142, 188),
(199, 143, 189),
(200, 144, 190),
(201, 145, 191),
(203, 147, 192),
(204, 148, 193),
(205, 149, 194),
(206, 149, 195),
(207, 150, 196),
(208, 151, 197),
(209, 152, 198),
(210, 152, 199),
(211, 153, 200),
(212, 154, 201),
(213, 155, 202),
(214, 155, 203),
(215, 155, 204),
(216, 155, 205),
(217, 156, 206),
(218, 156, 207),
(219, 157, 208),
(220, 157, 209),
(221, 158, 210),
(222, 159, 211),
(223, 159, 212),
(224, 159, 213),
(225, 159, 214),
(226, 159, 215),
(227, 159, 216),
(228, 160, 217);

-- --------------------------------------------------------

--
-- Structure de la table `Product`
--

CREATE TABLE `Product` (
  `id` int(11) NOT NULL,
  `Category` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` enum('available','unavailable') DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `Product`
--

INSERT INTO `Product` (`id`, `Category`, `name`, `description`, `price`, `status`, `image_path`) VALUES
(1, 1, 'Menu Le 280', '', '8.80', 'available', '/burgers/280.png'),
(2, 1, 'Menu Big Tasty', '', '10.60', 'available', '/burgers/BIG_TASTY_1_VIANDE.png'),
(3, 1, 'Menu Big Tasty Bacon', '', '10.90', 'available', '/burgers/BIG_TASTY_BACON_1_VIANDE.png'),
(4, 1, 'Menu Big Mac', '', '8.00', 'available', '/burgers/BIGMAC.png'),
(5, 1, 'Menu CBO', NULL, '10.90', 'available', '/burgers/CBO.png'),
(6, 1, 'Menu MC Chicken', '', '9.30', 'available', '/burgers/MCCHICKEN.png'),
(7, 1, 'Menu MC Crispy', '', '7.20', 'available', '/burgers/MCCRISPY.png'),
(8, 1, 'Menu MC Fish', '', '7.20', 'available', '/burgers/MCFISH.png'),
(9, 1, 'Menu Royal Bacon', '', '7.05', 'available', '/burgers/ROYALBACON.png'),
(10, 1, 'Menu Royal Cheese', '', '6.40', 'available', '/burgers/ROYALCHEESE.png'),
(11, 1, 'Menu Royal Deluxe', '', '7.40', 'available', '/burgers/ROYALDELUXE.png'),
(12, 1, 'Menu Signature BBQ Beef 2 viandes', '', '13.50', 'available', '/burgers/SIGNATURE_BBQ_BEEF_(2_VIANDES).png'),
(13, 1, 'Menu Signature Beef BBQ', '', '11.90', 'available', '/burgers/SIGNATURE_BEEF_BBQ_BURGER_(1_VIANDE).png'),
(14, 3, 'Le 280', '', '6.80', 'available', '/burgers/280.png'),
(15, 3, 'Big Tasty', '', '8.60', 'available', '/burgers/BIG_TASTY_1_VIANDE.png'),
(16, 3, 'Big Tasty Bacon', '', '8.90', 'available', '/burgers/BIG_TASTY_BACON_1_VIANDE.png'),
(17, 3, 'Big Mac', '', '6.00', 'available', '/burgers/BIGMAC.png'),
(18, 3, 'CBO', '', '8.90', 'available', '/burgers/CBO.png'),
(19, 3, 'MC Chicken', '', '7.30', 'available', '/burgers/MCCHICKEN.png'),
(20, 3, 'MC Crispy', '', '5.30', 'available', '/burgers/MCCRISPY.png'),
(21, 3, 'MC Fish', '', '4.85', 'available', '/burgers/MCFISH.png'),
(22, 3, 'Royal Bacon', '', '5.10', 'available', '/burgers/ROYALBACON.png'),
(23, 3, 'Royal Cheese', '', '4.40', 'available', '/burgers/ROYALCHEESE.png'),
(24, 3, 'Royal Deluxe', '', '5.40', 'available', '/burgers/ROYALDELUXE.png'),
(25, 3, 'Signature BBQ Beef 2 viandes', '', '11.40', 'available', '/burgers/SIGNATURE_BBQ_BEEF_(2_VIANDES).png'),
(26, 3, 'Signature Beef BBQ', '', '10.30', 'available', '/burgers/SIGNATURE_BEEF_BBQ_BURGER_(1_VIANDE).png'),
(27, 2, 'Coca Cola', '', '1.90', 'available', '/boissons/coca-cola.png'),
(28, 2, 'Coca Sans Sucres', '', '1.90', 'available', '/boissons/coca-sans-sucres.png'),
(29, 2, 'Eau', '', '1.00', 'available', '/boissons/eau.png'),
(30, 2, 'Fanta Orange', '', '1.90', 'available', '/boissons/fanta.png'),
(31, 2, 'Ice Tea Pêche', '', '1.90', 'available', '/boissons/ice-tea-peche.png'),
(32, 2, 'Ice Tea Citron', '', '1.90', 'available', '/boissons/the-vert-citron-sans-sucres.png'),
(33, 2, 'Jus d\'Orange', '', '2.10', 'available', '/boissons/jus-orange.png'),
(34, 2, 'Jus de Pommes Bio', '', '2.30', 'available', '/boissons/jus-pomme-bio.png'),
(35, 4, 'Petite Frite', '', '1.45', 'available', '/frites/PETITE_FRITE.png'),
(36, 4, 'Moyenne Frite', '', '2.75', 'available', '/frites/MOYENNE_FRITE.png'),
(37, 4, 'Grande Frite', '', '3.50', 'available', '/frites/GRANDE_FRITE.png'),
(38, 4, 'Potatoes', '', '2.15', 'available', '/frites/POTATOES.png'),
(39, 4, 'Grande Potatoes', '', '3.40', 'available', '/frites/GRANDE_POTATOES.png'),
(40, 5, 'Cheeseburger', '', '2.60', 'available', '/encas/cheeseburger.png'),
(41, 5, 'Croc MCdo', '', '3.20', 'available', '/encas/croc-mc-do.png'),
(42, 5, 'Nuggets x4', '', '4.20', 'available', '/encas/nuggets_4.png'),
(43, 5, 'Nuggets x20', '', '13.00', 'available', '/encas/nuggets_20.png'),
(44, 8, 'Brownie', '', '2.60', 'available', '/desserts/brownies.png'),
(45, 8, 'Cheesecake chocolat M et M\'S', '', '3.10', 'available', '/desserts/cheesecake_choconuts_M_M_s.png'),
(46, 8, 'Cheesecake Fraise', '', '3.10', 'available', '/desserts/cheesecake_fraise.png'),
(47, 8, 'Cookie', '', '3.20', 'available', '/desserts/cookie.png'),
(48, 8, 'Donut', '', '2.60', 'available', '/desserts/doghnut.png'),
(49, 8, 'Macarons', '', '2.70', 'available', '/desserts/macarons.png'),
(50, 8, 'MC Fleury', '', '4.40', 'available', '/desserts/MCFleury.png'),
(51, 8, 'Muffin', '', '3.60', 'available', '/desserts/muffin.png'),
(52, 8, 'Sunday', '', '1.00', 'available', '/desserts/sunday.png'),
(53, 9, 'Classic Barbecue', '', '0.70', 'available', '/sauces/classic-barbecue.png'),
(54, 9, 'Classic Moutarde', '', '0.70', 'available', '/sauces/classic-moutarde.png'),
(55, 9, 'Creamy Deluxe', '', '0.70', 'available', '/sauces/cremy-deluxe.png'),
(56, 9, 'Ketchup', '', '0.70', 'available', '/sauces/ketchup.png'),
(57, 9, 'Chinoise', '', '0.70', 'available', '/sauces/sauce-chinoise.png'),
(58, 9, 'Curry', '', '0.70', 'available', '/sauces/sauce-curry.png'),
(59, 9, 'Pommes Frites', '', '0.70', 'available', '/sauces/sauce-pommes-frite.png'),
(60, 7, 'Petite Salade', '', '3.30', 'available', '/salades/PETITE-SALADE.png'),
(61, 7, 'Cesar Classic', '', '8.80', 'available', '/salades/SALADE_CLASSIC_CAESAR.png'),
(62, 7, 'Italienne Mozza', '', '8.80', 'available', '/salades/SALADE_ITALIAN_MOZZA.png'),
(63, 6, 'MC Wrap chevre', '', '3.10', 'available', '/wraps/mcwrap-chevre.png'),
(64, 6, 'MC Wrap Poulet Bacon', '', '3.30', 'available', '/wraps/MCWRAP-POULET-BACON.png'),
(65, 6, 'Ptit Wrap Chevre', '', '2.60', 'available', '/wraps/PTIT_WRAP_CHEVRE.png'),
(66, 6, 'Ptit Wrap Ranch', '', '2.60', 'available', '/wraps/PTIT_WRAP_RANCH.png');

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `mail` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','preparer','reception') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Déchargement des données de la table `User`
--

INSERT INTO `User` (`id`, `name`, `first_name`, `mail`, `password`, `role`) VALUES
(1, 'Ronald', 'Mac', 'ronald@test.fr', '$2y$10$evNYDhKIyKtOyvq02usSc./6lUjESv58NXFEFN8G0.oJhNk446tOO', 'admin'),
(3, 'Christian', 'Durand', 'christian@wacdo.fr', '$2y$10$lpSzqc0i08f6TKbBgHGjku7U.XEditJ.jtxoUNgWVdWRu8/cJJPwa', 'preparer'),
(4, 'Christelle', 'Fruzte', 'christelle@wacdo.fr', '$2y$10$8XCOjvgh7NZprVQUBQwWNORa9WN456U4RFtUprbJiRveCr/JuUjDa', 'reception');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Account_manage`
--
ALTER TABLE `Account_manage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User` (`User`);

--
-- Index pour la table `Category`
--
ALTER TABLE `Category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Element`
--
ALTER TABLE `Element`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `Element_Product`
--
ALTER TABLE `Element_Product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Element` (`Element`),
  ADD KEY `Product` (`Product`);

--
-- Index pour la table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `number` (`number`),
  ADD KEY `User` (`User`);

--
-- Index pour la table `Order_Element`
--
ALTER TABLE `Order_Element`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Order` (`Order`),
  ADD KEY `Element` (`Element`);

--
-- Index pour la table `Product`
--
ALTER TABLE `Product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Category` (`Category`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Account_manage`
--
ALTER TABLE `Account_manage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `Category`
--
ALTER TABLE `Category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `Element`
--
ALTER TABLE `Element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- AUTO_INCREMENT pour la table `Element_Product`
--
ALTER TABLE `Element_Product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT pour la table `Order`
--
ALTER TABLE `Order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT pour la table `Order_Element`
--
ALTER TABLE `Order_Element`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT pour la table `Product`
--
ALTER TABLE `Product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Account_manage`
--
ALTER TABLE `Account_manage`
  ADD CONSTRAINT `Account_manage_ibfk_1` FOREIGN KEY (`User`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `Element_Product`
--
ALTER TABLE `Element_Product`
  ADD CONSTRAINT `Element_Product_ibfk_1` FOREIGN KEY (`Element`) REFERENCES `Element` (`id`),
  ADD CONSTRAINT `Element_Product_ibfk_2` FOREIGN KEY (`Product`) REFERENCES `Product` (`id`);

--
-- Contraintes pour la table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `Order_ibfk_1` FOREIGN KEY (`User`) REFERENCES `User` (`id`);

--
-- Contraintes pour la table `Order_Element`
--
ALTER TABLE `Order_Element`
  ADD CONSTRAINT `Order_Element_ibfk_1` FOREIGN KEY (`Order`) REFERENCES `Order` (`id`),
  ADD CONSTRAINT `Order_Element_ibfk_2` FOREIGN KEY (`Element`) REFERENCES `Element` (`id`);

--
-- Contraintes pour la table `Product`
--
ALTER TABLE `Product`
  ADD CONSTRAINT `Product_ibfk_1` FOREIGN KEY (`Category`) REFERENCES `Category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
