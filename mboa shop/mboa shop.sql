-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 10 juil. 2022 à 03:00
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mboa shop`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'image/',
  `prix` float NOT NULL DEFAULT 0,
  `quantite` int(11) NOT NULL,
  `vendu` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `boutique` varchar(255) NOT NULL,
  `date_entree` datetime NOT NULL DEFAULT current_timestamp(),
  `solde` varchar(10) NOT NULL DEFAULT '0',
  `likes` int(11) NOT NULL,
  `statut` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `nom`, `description`, `image`, `prix`, `quantite`, `vendu`, `type`, `boutique`, `date_entree`, `solde`, `likes`, `statut`) VALUES
(2, 'koln moun', 'stay cool', 'image/baniere.jpg', 65000, 50, 0, 'pull', '1', '2022-06-16 06:17:01', '0.0', 81, 'actif'),
(3, 'super jeans', 'liberty', 'image/baniere.jpg', 57800, 50, 1, 'pantalon', '1', '2022-06-16 06:17:01', '0', 1, 'actif'),
(5, 'colier d\'argent', 'easy\r\n', 'image/baniere.jpg', 20000, 50, 1, 'bijoux', '2', '2022-06-16 06:17:01', '0', 0, 'actif'),
(6, 'boucle en diamant', 'fine', 'image/baniere.jpg', 78000, 50, 1, 'bijoux', '1', '2022-06-16 06:17:01', '0.0', 1, 'actif'),
(7, 'short storm', '95% coton', 'image/images (1).jpeg', 45000, 50, 4, 'short', '1', '2022-06-20 21:59:07', '0.01', 0, 'actif'),
(8, 'jack shoes', 'flexible et legere', 'image/images (2).jpeg', 45000, 50, 0, 'chaussure', '2', '2022-06-22 12:20:32', '0', 0, 'actif'),
(10, 'hidden hat', 'das ist sehr gute idee', 'image/images (4).jpeg', 54000, 20, 0, 'chapeau', '1', '2022-06-24 20:19:49', '0.0', 0, 'actif'),
(11, 'range rover', '1er classe', 'image/images (6).jpeg', 34000, 30, 0, 'pull over', '1', '2022-06-24 21:02:43', '0', 0, 'actif'),
(12, 'drone hat', 'super', 'image/téléchargement (1).jpeg', 53000, 50, 0, 'chapeau', '2', '2022-06-26 13:12:26', '0.0', 0, 'actif'),
(13, 'pureer', 'pureer', 'image/code plarium.png', 67890, 50, 0, 'haut', '1', '2022-06-26 13:19:48', '0.0', 0, 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `boutique`
--

CREATE TABLE `boutique` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'image/',
  `description` varchar(255) NOT NULL,
  `proprietaire` varchar(255) NOT NULL,
  `validiter` datetime DEFAULT NULL,
  `tarif` varchar(11) NOT NULL DEFAULT '20 000 FRS ',
  `statut` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `boutique`
--

INSERT INTO `boutique` (`id`, `nom`, `image`, `description`, `proprietaire`, `validiter`, `tarif`, `statut`) VALUES
(1, 'Adonix Shop', 'image/images (4).jpeg', 'boutique pour homme', 'adonix', NULL, '20000', 'actif'),
(4, 'Tokyo Shop', 'image/images (1).jpeg', 'super', 'maoh yang', '2022-07-26 18:19:28', '20000', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tel` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `quartier` varchar(255) NOT NULL,
  `id_melange` varchar(255) NOT NULL,
  `quantite` varchar(255) NOT NULL,
  `prix_total` varchar(255) NOT NULL,
  `livraison` varchar(20) NOT NULL,
  `statut` varchar(20) NOT NULL DEFAULT 'non-valider',
  `livreur` varchar(4) NOT NULL,
  `date_commande` datetime NOT NULL DEFAULT current_timestamp(),
  `date_livraison` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `id_utilisateur`, `nom`, `mail`, `tel`, `region`, `ville`, `quartier`, `id_melange`, `quantite`, `prix_total`, `livraison`, `statut`, `livreur`, `date_commande`, `date_livraison`) VALUES
(1, 0, 'super', 'sup@cvb.com', '678900987', 'ouest', 'bahouan', 'nkometou', '2,1', '4,3', '21500,98000', 'oui', 'livrer', '3', '2022-06-02 12:25:47', '2022-06-19 21:07:37'),
(2, 2, '', '', '930303', 'kdkdkd', 'kmddmd', 'wmmdwmkw', '2', '1', '18750', 'oui', 'valider', '3', '2022-06-14 20:58:08', '2022-06-14 22:15:33'),
(3, 2, '', '', '789009', 'ngousso', 'biam', 'secdy', '3', '3', '29400', 'oui', 'valider', '3', '2022-06-15 22:55:32', '2022-06-18 17:25:21'),
(12, 2, '', '', '789009', 'ngousso', 'biam', 'secdy', '3', '1', '9800', 'oui', 'valider', '3', '2022-06-15 23:38:54', '2022-06-18 18:23:26'),
(13, 2, '', '', '546789', 'ngousso', 'biam', 'secdy', '2,3', '5,5', '93750,49000', 'oui', 'livrer', '3', '2022-06-15 23:40:50', '2022-06-19 14:54:56'),
(14, 2, '', '', '789009', 'ngousso', 'biam', 'secdy', '3', '5', '49000', 'oui', 'valider', '0', '2022-06-15 23:41:49', '2022-06-18 18:23:26'),
(15, 2, '', '', '678099876', 'centre', 'yaounde', 'ngousso', '3', '4', '231200', 'oui', 'en cour', 'a3', '2022-06-17 03:20:39', '2022-07-10 01:44:40'),
(16, 2, '', '', '678099876', 'centre', 'yaounde', 'ngousso', '3', '4', '231200', 'non', 'valider', '0', '2022-06-17 03:22:41', '2022-06-18 18:23:26'),
(17, 2, '', '', '546789', 'centre', 'yaounde', 'ngousso', '3,5', '1,3', '57800,60000', 'non', 'valider', '0', '2022-06-17 03:27:53', '2022-06-18 20:23:59'),
(18, 2, '', '', '789009', 'centre', 'yaounde', 'ngousso', '6', '1', '20000', 'non', 'valider', '0', '2022-06-17 03:31:52', '2022-06-18 20:24:06'),
(19, 2, '', '', '546789', 'centre', 'yaounde', 'ngousso', '4', '3', '105000', 'non', 'non-valider', '0', '2022-06-17 03:35:56', NULL),
(20, 0, 'cabrel', 'cabrel@gmail.com', '546789', 'centre', 'yaounde', 'secdy', '3', '3', '173400', 'oui', 'non-valider', '0', '2022-06-17 04:00:37', NULL),
(21, 2, '', '', '789009', 'centre', 'yaounde', 'ngousso', '3', '3', '173400', 'oui', 'non-valider', '0', '2022-06-17 15:26:25', NULL),
(22, 2, '', '', '789009', 'ouest', 'bafoussam', 'secdy', '3,8,6', '4,2,2', '231200,19600,40000', 'oui', 'non-valider', '0', '2022-06-17 16:47:59', NULL),
(23, 2, '', '', '693775420', 'littoral', 'douala', 'Nsam', '2', '4', '39200', 'oui', 'non-valider', '0', '2022-06-17 23:08:06', NULL),
(24, 2, '', '', '897689', 'centre', 'yaounde', 'jio', '11', '3', '56250', 'oui', 'non-valider', '0', '2022-06-17 23:38:40', NULL),
(25, 2, '', '', '693775420', 'centre', 'yaounde', 'Nkolfoulou ', '11', '3', '56250', 'oui', 'non-valider', '0', '2022-06-18 10:15:48', NULL),
(26, 1, '', '', '677547020', 'centre', 'yaounde', 'nsam', '11,13', '2,2', '89100,89100', 'oui', 'non-valider', 'aucu', '2022-06-20 22:02:42', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `dates` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `forum`
--

INSERT INTO `forum` (`id`, `id_utilisateur`, `titre`, `message`, `dates`) VALUES
(1, 1, 'salutation', 'hallo, wie geht\'s ihnen', '2022-05-12 17:55:20'),
(2, 2, 'gut', 'hjdjsksss', '2022-05-26 18:37:23'),
(3, 2, 'gut', 'hjdjsksss', '2022-05-26 18:37:55'),
(4, 2, '', '690986578', '2022-05-28 15:58:37'),
(5, 2, '', '69090509595003', '2022-05-28 15:59:05'),
(6, 2, '', '69090509595003', '2022-05-28 16:00:51'),
(7, 2, '', ' 690896745\r\n', '2022-05-28 16:22:44'),
(8, 2, '', ' 690896745\r\n', '2022-05-28 16:23:32'),
(9, 2, '', ' 690896745\r\n', '2022-05-28 16:25:42'),
(10, 2, '', 'slt', '2022-05-28 21:03:08'),
(11, 2, '', 'bae', '2022-05-29 07:38:06'),
(12, 2, 'Salutations ', 'Bienvenue sur mboa SHOP online ', '2022-06-17 23:02:43'),
(13, 2, 'Salutations ', 'Bienvenue sur mboa SHOP online ', '2022-06-17 23:06:48'),
(14, 2, 'Salutations ', 'Bonjour à tous ', '2022-06-18 10:16:10');

-- --------------------------------------------------------

--
-- Structure de la table `melange`
--

CREATE TABLE `melange` (
  `id` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'image/',
  `couleur` varchar(20) NOT NULL,
  `taille` varchar(5) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 0,
  `vendu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `melange`
--

INSERT INTO `melange` (`id`, `id_article`, `image`, `couleur`, `taille`, `quantite`, `vendu`) VALUES
(2, 2, 'image/images (1).jpeg', 'rouge', 'ml', 50, 1),
(3, 3, 'image/images (1).jpeg', 'rouge', 'xxl', 50, 1),
(5, 5, 'image/images (1).jpeg', 'argente', '20', 50, 1),
(6, 6, 'image/images (1).jpeg', 'rouge', '5kara', 50, 1),
(11, 7, 'image/images (1).jpeg', 'vert', '15', 15, 2),
(12, 7, 'image/images (1).jpeg', 'violet', '20', 20, 0),
(13, 7, 'image/images (1).jpeg', 'or', '15', 15, 2),
(14, 8, 'image/images (1).jpeg', 'bleu', '34', 20, 0),
(15, 8, 'image/images (1).jpeg', 'bleu', '38', 10, 0),
(16, 8, 'image/images (1).jpeg', 'rouge', '40', 20, 0),
(22, 10, 'image/images (5).jpeg', 'jaune', '35', 20, 0),
(23, 11, 'image/téléchargement (1)7.jpeg', 'noir', '25', 15, 0),
(24, 11, 'image/images (6).jpeg', 'bleu', '25', 15, 0),
(26, 12, 'image/téléchargement (1)7.jpeg', 'noir', '25', 15, 0),
(27, 13, 'image/images (1).jpeg', 'noir', 'xl', 25, 0),
(28, 13, 'image/images (4).jpeg', 'noir', 'xxl', 25, 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `tel1` varchar(20) NOT NULL,
  `tel2` varchar(20) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'actif',
  `likes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `pass`, `mail`, `tel1`, `tel2`, `statut`, `likes`) VALUES
(2, 'super', '9b8eb8d32ce6169360a7460efdfea4441d243e1b', 'woguecabrel@gmail.com', '693775420', '673723738', 'actif', ',3,4,6'),
(3, 'adonix', 'af0ff2785179afbb53667d03e6bbc64715fe398e', 'adonix.com', '58595', '494033', 'gerant', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_admin`
--

CREATE TABLE `utilisateurs_admin` (
  `id` varchar(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mot` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `tel1` int(30) NOT NULL,
  `tel2` int(30) NOT NULL,
  `statut` varchar(30) NOT NULL,
  `action` varchar(20) NOT NULL DEFAULT 'libre'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs_admin`
--

INSERT INTO `utilisateurs_admin` (`id`, `nom`, `mail`, `mot`, `pass`, `tel1`, `tel2`, `statut`, `action`) VALUES
('1', 'Adonix', 'adonix@gmail.com', 'adonix', 'de494759c6ab6b5a29f293ac388221240d41dacb', 678900987, 654322345, 'gerant', 'actif'),
('2', 'mboa shop', 'mboashop@gmail.com', 'mboa shop', 'ac722d908218f4f92fec1ef26c6e1c5ae76e059b', 678787878, 687878787, 'admin', 'libre'),
('3', 'jordan', 'jordan@mail.com', 'jordan', '1cb5bd5a9e45420321f44c72da5d90d7f0432ffb', 909099090, 90909090, 'livreur', 'actif'),
('4', 'sting', 'tokyoshop@gmail.com', 'sting', '63ee1a073aae9c67f5adf5741948820ce8c1c13d', 345654323, 234543234, 'gerant', 'actif'),
('5', 'murielle', 'murielle', 'murielle', 'a84894f0570002d164a8d18fa44786ae323bd1fa', 345, 3452, 'secretaire', 'actif'),
('a3', 'john', 'john', 'john', 'a51dda7c7ff50b61eaea0444371f4a6a9301e501', 99404, 3930404, 'livreur', 'en cour:15');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `boutique`
--
ALTER TABLE `boutique`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `melange`
--
ALTER TABLE `melange`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs_admin`
--
ALTER TABLE `utilisateurs_admin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `boutique`
--
ALTER TABLE `boutique`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `melange`
--
ALTER TABLE `melange`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
