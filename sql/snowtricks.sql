-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 19 mars 2022 à 00:26
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `libelle` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_cat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`, `description_cat`) VALUES
(5, 'Grabs', 'Un grab consiste à attraper la planche avec la main pendant le saut.'),
(6, 'Rotations', 'Le principe est d\'effectuer une rotation horizontale pendant le saut, puis d\'attérir en position switch ou normal.'),
(7, 'Slides', 'Un slide consiste à glisser sur une barre de slide. Le slide se fait soit avec la planche dans l\'axe de la barre, soit perpendiculaire, soit plus ou moins désaxé.'),
(8, 'Flips', 'Un flip est une rotation verticale.');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `figures_id` int DEFAULT NULL,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int NOT NULL,
  `username` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BC5C7F3A37` (`figures_id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `figures_id`, `contenu`, `created_at`, `user_id`, `username`, `photo`) VALUES
(48, 12, 'Très belle figure', '2022-03-19 00:07:23', 1, 'mialy', NULL),
(50, 12, 'Super figure', '2022-03-19 00:16:08', 1, 'mialy', '6c40c6c22039230c0273856fe46017b2.jpg'),
(51, 11, 'Top figure', '2022-03-19 00:21:17', 2, 'edene', '28c718bd7f46773a5f427d700ed9657d.jpg'),
(52, 11, 'Belle figure', '2022-03-19 00:21:39', 2, 'edene', NULL),
(53, 12, 'Excellente figure', '2022-03-19 00:22:20', 2, 'edene', NULL),
(54, 11, 'Impressionnant', '2022-03-19 00:23:09', 2, 'edene', 'd71d3730bc85c383fef92232b51fb393.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `figure`
--

DROP TABLE IF EXISTS `figure`;
CREATE TABLE IF NOT EXISTS `figure` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imagetop` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2F57B37ABCF5E72D` (`categorie_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `figure`
--

INSERT INTO `figure` (`id`, `categorie_id`, `nom`, `description`, `imagetop`, `user_id`, `slug`) VALUES
(11, 5, 'Style week', 'Saisie de la carre backside de la planche, entre les deux pieds, avec la main avant.', 'd6ca9007f2413c315ad3ede143fdbe78.jpg', 1, 'style-week'),
(12, 5, 'STALEFISH', 'Consiste à saisir la carre backside de la planche entre les deux pieds avec la main arrière ;', '3146355cface21ddfca557ff762c4941.jpg', 1, 'stalefish'),
(13, 5, 'Tail grab', 'Saisie de la partie arrière de la planche, avec la main arrière.', 'f309893f0fadb9a2e7eb126b4d8f5890.jpg', 1, 'tail-grab'),
(14, 5, 'Japan air', 'Saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.', '531938dc5bfa5cde19fe9d6ae1dcce1b.jpg', 1, 'japan-air'),
(15, 6, 'Rotation frontside', 'Une rotation frontside se fait dans le sens inverse des aiguilles d\'une montre.', '7fa6feb58acdc81e86bf04ca0d16daa9.jpg', 1, 'rotation-frontside'),
(16, 6, 'Rotation backside', 'On désigne par le mot « rotation » uniquement des rotations horizontales.', '8d3c0af8613b61057fbf730ecabbf218.jpg', 1, 'rotation-backside'),
(17, 7, 'Nose slide', 'Avant de la planche sur la barre.', 'ee9eb892a9f09551a15220067419c27a.jpg', 1, 'nose-slide'),
(18, 7, 'Tail slide', 'Arrière de la planche sur la barre.', 'f5efc86672f3e0eb4ed4c45424a5a2eb.jpg', 1, 'tail-slide'),
(19, 8, 'Front flip', 'Un front flip est une rotation en avant.', 'f4e292fdeebe9d57e098729c82811ca4.jpg', 1, 'front-flip'),
(20, 8, 'Back flip', 'Un back flip est une rotation en arrière.', '1ba08a286cb14701a91c75565ba622d4.jpg', 1, 'back-flip'),
(94, 7, 'Figure test final2', 'derniere fig', '941c21901dfb32bfbce1339cc435f75b.jpg', 1, 'Figure-test-final2');

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

DROP TABLE IF EXISTS `image`;
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `figures_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045F5C7F3A37` (`figures_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `figures_id`, `name`) VALUES
(103, 11, 'd305c2e0eaa377067d5b42aee6539f65.jpg'),
(104, 11, '5b6439ea62049d68e54086086bf676a0.jpg'),
(105, 11, '6a01a56ecb2b91b66d22e6757f367a3b.jpg'),
(106, 11, '7b3be704b90dc69d0e8491e406d99348.jpg'),
(107, 11, '6f32dec2a85c905330bdbde60e68f3fe.jpg'),
(108, 11, 'ba88451f06bbc4fbb0b39b51ca133e06.jpg'),
(109, 12, 'f724cd3d315009d71a4e46033e523ba8.jpg'),
(110, 12, '3e4f134042ebf33731d2af0eea95e32f.jpg'),
(111, 12, '3684b03f22185051ff9044f3fe2b278c.jpg'),
(112, 12, 'ae913839b93f1d3c0f9e34e9d969d361.jpg'),
(113, 13, 'ed1c0cfd9bc63f010fa4839383b9df23.jpg'),
(114, 13, 'f4f805b27fb5824c6761dc239b357612.jpg'),
(115, 13, '0e05c6cfded8871824e8af184ff452f8.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `activation_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `figure_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `figure_id` (`figure_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `password`, `roles`, `email`, `activation_token`, `reset_token`, `figure_id`) VALUES
(1, 'mialy', '$2y$13$7bHKxPxe7FjBQ.aDuAg3G.fo1yRrcQzkibPIRu8TUSWQsnm/oo/TK', 'ROLE_ADMIN', '', NULL, NULL, NULL),
(2, 'edene', '$2y$13$s4Ew2HGzqenS8wN6VLobGup2cFiC6SM3dtM63l9mat6dYFBb/WHl2', 'ROLE_USER', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video` (
  `id` int NOT NULL AUTO_INCREMENT,
  `URL` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `figures_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `figures_id` (`figures_id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `URL`, `figures_id`) VALUES
(243, 'https://www.youtube.com/embed/JCjmmlvVnc8', 11),
(244, 'https://www.youtube.com/embed/JCjmmlvVnc8', 11),
(245, 'https://www.youtube.com/embed/SFYYzy0UF-8', 11),
(246, 'https://www.youtube.com/embed/SFYYzy0UF-8', 12),
(247, 'https://www.youtube.com/embed/dSZ7_TXcEdM', 12),
(248, 'https://www.youtube.com/embed/dSZ7_TXcEdM', 13),
(249, 'https://www.youtube.com/embed/YsQNexgjgzY', 12),
(250, 'https://www.youtube.com/embed/3NgUgh8fyRI', 13);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC5C7F3A37` FOREIGN KEY (`figures_id`) REFERENCES `figure` (`id`),
  ADD CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `figure`
--
ALTER TABLE `figure`
  ADD CONSTRAINT `FK_2F57B37ABCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045F5C7F3A37` FOREIGN KEY (`figures_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`figure_id`) REFERENCES `figure` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`figures_id`) REFERENCES `figure` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
