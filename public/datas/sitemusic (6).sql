-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 02 août 2022 à 15:12
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
-- Base de données : `sitemusic`
--

-- --------------------------------------------------------

--
-- Structure de la table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_alone` tinyint(1) NOT NULL,
  `looking_for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `advertisement`
--

INSERT INTO `advertisement` (`id`, `user_id`, `title`, `is_alone`, `looking_for`, `city`, `description`, `date`, `status`) VALUES
(1, 3, 'test', 0, 'pianiste', 'Honfleur', 'test 1', '2022-07-21 00:00:00', 1),
(2, 3, 'groupe rock', 1, 'guitariste', 'Caen', 'on va tout déchirer', '2022-07-21 12:12:56', 1),
(4, 3, 'group trompette', 1, 'saxophoniste', 'Rouen', 'test pour lister les annonces', '2022-07-22 11:30:42', 1),
(6, 3, 'qsdqsdsq', 1, 'chanteur', 'Rouen', 'qsdqsdqs', '2022-07-27 18:19:53', 1),
(7, 3, 'qsdsqdqsd', 1, 'pianiste', 'Lyon', 'qsdqsdqsd', '2022-07-27 18:25:49', 1);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20220718100143', '2022-07-18 12:02:08', 51),
('DoctrineMigrations\\Version20220718143040', '2022-07-18 16:31:00', 40),
('DoctrineMigrations\\Version20220720132903', '2022-07-20 15:29:22', 250),
('DoctrineMigrations\\Version20220721100944', '2022-07-21 12:10:19', 303);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instrument` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style_music` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`, `instrument`, `city`, `style_music`, `book`, `avatar`, `date`, `last_login`, `level`, `status`, `description`, `google_id`) VALUES
(1, 'test.test@gmail.com', '[]', '$2y$13$.HegEfHql1TtF8kF/QXdEO0ZbjJ3u2uj7Xkq8cBwU5dak0.jAqzLS', NULL, NULL, NULL, NULL, NULL, NULL, '2022-07-18 00:00:00', NULL, NULL, NULL, NULL, NULL),
(2, 'occelli.hugo@hotmail.fr', '[\"ROLE_USER\"]', '$2y$13$VmnmCBnPlMKC9fr0WSBLJuJCrYzuBgTZ6N4EI1wLVejZJ6OtnMP3S', 'test', NULL, NULL, NULL, NULL, NULL, '2022-07-18 00:00:00', NULL, NULL, NULL, NULL, '117625216443440853615'),
(3, 'test.test2@hotmail.com', '[\"ROLE_USER\"]', '$2y$13$U6avR6RDYU1H7T85IG/uuuFxexjx0QQOd41gHGZCRCuRGFb1OpVTm', 'test6', NULL, 'Honfleur', NULL, NULL, NULL, '2022-07-19 00:00:00', NULL, NULL, NULL, NULL, NULL),
(5, 'paul.hugo@hotmail.fr', '[\"ROLE_USER\"]', '$2y$13$WOES17sX2X4hwjwLfu7hMeplSxQg5BYxO8LamkjIAJv4NzOppM6QS', NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-02 11:26:00', NULL, NULL, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C95F6AEE9D86650F` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `advertisement`
--
ALTER TABLE `advertisement`
  ADD CONSTRAINT `FK_C95F6AEE9D86650F` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
