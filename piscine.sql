-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 23 déc. 2019 à 12:45
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `piscine`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `id_compte` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `est_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_compte`),
  UNIQUE KEY `mail` (`mail`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `nom`, `prenom`, `mail`, `mdp`, `est_admin`) VALUES
(25, 'Eric', 'Pierre', 'pierre.eric@etu.umontpellier.fr', '$2y$10$rMEE7Uh7n4j2vrIMULwi4.5lev1h0UbMfWWg74VFhYiB3klEcl8gm', 0),
(26, 'test', 'test', 'test@etu.umontpellier.fr', '$2y$10$zD8CToK4Crq1mu.DlAs8yOTxYYTa7d8hRveMPVsoeSY.PjCi0F/Ui', 0),
(27, 'Lilian', 'Lilian', 'lilian@etu.umontpellier.fr', '$2y$10$2FU.8i52P9Q8KpQxeQ73Ke4.cs9N6jNP201YKChos29CBpEfLAj7m', 0),
(28, 'lilian', 'lilian', 'lilian2@etu.umontpellier.fr', '$2y$10$.3V/Cndaz84LgvM8jgwgUevpMDz19w1NtFi9uXjmuo0GhRL6F7E2G', 0),
(30, 'azerty', 'azerty', 'azertyu@etu.umontpellier.fr', '$2y$10$mgFuK7t3XGxZfQJ/mfhpEeXiA8Ve4eEiMq65lgCJoT0uO5zb4pUs6', 0);

-- --------------------------------------------------------

--
-- Structure de la table `est_de_groupe`
--

DROP TABLE IF EXISTS `est_de_groupe`;
CREATE TABLE IF NOT EXISTS `est_de_groupe` (
  `id_compte` int(11) NOT NULL,
  `id_grp` int(255) NOT NULL,
  KEY `id_compte` (`id_compte`),
  KEY `id_grp` (`id_grp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `est_de_groupe`
--

INSERT INTO `est_de_groupe` (`id_compte`, `id_grp`) VALUES
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(30, 1);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

DROP TABLE IF EXISTS `groupe`;
CREATE TABLE IF NOT EXISTS `groupe` (
  `id_grp` int(11) NOT NULL AUTO_INCREMENT,
  `id_spe` varchar(255) NOT NULL,
  `num_grp` int(255) NOT NULL,
  PRIMARY KEY (`id_grp`),
  KEY `id_spe` (`id_spe`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`id_grp`, `id_spe`, `num_grp`) VALUES
(1, 'IG3', 1),
(2, 'IG3', 2),
(3, 'IG4', 1),
(4, 'IG4', 2);

-- --------------------------------------------------------

--
-- Structure de la table `participe`
--

DROP TABLE IF EXISTS `participe`;
CREATE TABLE IF NOT EXISTS `participe` (
  `id_grp` int(255) NOT NULL,
  `id_session` int(11) NOT NULL,
  KEY `id_session` (`id_session`),
  KEY `id_grp` (`id_grp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

DROP TABLE IF EXISTS `question`;
CREATE TABLE IF NOT EXISTS `question` (
  `num_question` int(11) NOT NULL,
  `reponse` varchar(1) NOT NULL,
  `id_sujet` int(11) NOT NULL,
  PRIMARY KEY (`num_question`),
  KEY `id_sujet` (`id_sujet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `question`
--

INSERT INTO `question` (`num_question`, `reponse`, `id_sujet`) VALUES
(1, 'A', 1),
(2, 'A', 1),
(3, 'A', 1),
(4, 'A', 1),
(5, 'A', 1),
(6, 'A', 1),
(7, 'A', 1),
(8, 'A', 1),
(9, 'A', 1),
(10, 'A', 1),
(11, 'A', 1),
(12, 'A', 1),
(13, 'A', 1),
(14, 'A', 1),
(15, 'A', 1),
(16, 'A', 1),
(17, 'A', 1),
(18, 'A', 1),
(19, 'A', 1),
(20, 'A', 1),
(21, 'A', 1),
(22, 'A', 1),
(23, 'A', 1),
(24, 'A', 1),
(25, 'A', 1),
(26, 'A', 1),
(27, 'A', 1),
(28, 'A', 1),
(29, 'A', 1),
(30, 'A', 1),
(31, 'A', 1),
(32, 'A', 1),
(33, 'A', 1),
(34, 'A', 1),
(35, 'A', 1),
(36, 'A', 1),
(37, 'A', 1),
(38, 'A', 1),
(39, 'A', 1),
(40, 'A', 1),
(41, 'A', 1),
(42, 'A', 1),
(43, 'A', 1),
(44, 'A', 1),
(45, 'A', 1),
(46, 'A', 1),
(47, 'A', 1),
(48, 'A', 1),
(49, 'A', 1),
(50, 'A', 1),
(51, 'A', 1),
(52, 'A', 1),
(53, 'A', 1),
(54, 'A', 1),
(55, 'A', 1),
(56, 'A', 1),
(57, 'A', 1),
(58, 'A', 1),
(59, 'A', 1),
(60, 'A', 1),
(61, 'A', 1),
(62, 'A', 1),
(63, 'A', 1),
(64, 'A', 1),
(65, 'A', 1),
(66, 'A', 1),
(67, 'A', 1),
(68, 'A', 1),
(69, 'A', 1),
(70, 'A', 1),
(71, 'A', 1),
(72, 'A', 1),
(73, 'A', 1),
(74, 'A', 1),
(75, 'A', 1),
(76, 'A', 1),
(77, 'A', 1),
(78, 'A', 1),
(79, 'A', 1),
(80, 'A', 1),
(81, 'A', 1),
(82, 'A', 1),
(83, 'A', 1),
(84, 'A', 1),
(85, 'A', 1),
(86, 'A', 1),
(87, 'A', 1),
(88, 'A', 1),
(89, 'A', 1),
(90, 'A', 1),
(91, 'A', 1),
(92, 'A', 1),
(93, 'A', 1),
(94, 'A', 1),
(95, 'A', 1),
(96, 'A', 1),
(97, 'A', 1),
(98, 'A', 1),
(99, 'A', 1),
(100, 'A', 1),
(101, 'A', 1),
(102, 'A', 1),
(103, 'A', 1),
(104, 'A', 1),
(105, 'A', 1),
(106, 'A', 1),
(107, 'A', 1),
(108, 'A', 1),
(109, 'A', 1),
(110, 'A', 1),
(111, 'A', 1),
(112, 'A', 1),
(113, 'A', 1),
(114, 'A', 1),
(115, 'A', 1),
(116, 'A', 1),
(117, 'A', 1),
(118, 'A', 1),
(119, 'A', 1),
(120, 'A', 1),
(121, 'A', 1),
(122, 'A', 1),
(123, 'A', 1),
(124, 'A', 1),
(125, 'A', 1),
(126, 'A', 1),
(127, 'A', 1),
(128, 'A', 1),
(129, 'A', 1),
(130, 'A', 1),
(131, 'A', 1),
(132, 'A', 1),
(133, 'A', 1),
(134, 'A', 1),
(135, 'A', 1),
(136, 'A', 1),
(137, 'A', 1),
(138, 'A', 1),
(139, 'A', 1),
(140, 'A', 1),
(141, 'A', 1),
(142, 'A', 1),
(143, 'A', 1),
(144, 'A', 1),
(145, 'A', 1),
(146, 'A', 1),
(147, 'A', 1),
(148, 'A', 1),
(149, 'A', 1),
(150, 'A', 1),
(151, 'A', 1),
(152, 'A', 1),
(153, 'A', 1),
(154, 'A', 1),
(155, 'A', 1),
(156, 'A', 1),
(157, 'A', 1),
(158, 'A', 1),
(159, 'A', 1),
(160, 'A', 1),
(161, 'A', 1),
(162, 'A', 1),
(163, 'A', 1),
(164, 'A', 1),
(165, 'A', 1),
(166, 'A', 1),
(167, 'A', 1),
(168, 'A', 1),
(169, 'A', 1),
(170, 'A', 1),
(171, 'A', 1),
(172, 'A', 1),
(173, 'A', 1),
(174, 'A', 1),
(175, 'A', 1),
(176, 'A', 1),
(177, 'A', 1),
(178, 'A', 1),
(179, 'A', 1),
(180, 'A', 1),
(181, 'A', 1),
(182, 'A', 1),
(183, 'A', 1),
(184, 'A', 1),
(185, 'A', 1),
(186, 'A', 1),
(187, 'A', 1),
(188, 'A', 1),
(189, 'A', 1),
(190, 'A', 1),
(191, 'A', 1),
(192, 'A', 1),
(193, 'A', 1),
(194, 'A', 1),
(195, 'A', 1),
(196, 'A', 1),
(197, 'A', 1),
(198, 'A', 1),
(199, 'A', 1),
(200, 'A', 1);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `date_session` date NOT NULL,
  `id_sujet` int(11) NOT NULL,
  PRIMARY KEY (`id_session`),
  KEY `id_sujet` (`id_sujet`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id_session`, `date_session`, `id_sujet`) VALUES
(6, '2019-12-29', 1),
(7, '2019-12-27', 1);

-- --------------------------------------------------------

--
-- Structure de la table `sous_partie`
--

DROP TABLE IF EXISTS `sous_partie`;
CREATE TABLE IF NOT EXISTS `sous_partie` (
  `num_sp` int(11) NOT NULL,
  `note_sp` int(11) NOT NULL,
  `id_compte` int(11) NOT NULL,
  `id_session` int(11) NOT NULL,
  PRIMARY KEY (`num_sp`),
  KEY `id_compte` (`id_compte`),
  KEY `id_session` (`id_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

DROP TABLE IF EXISTS `specialite`;
CREATE TABLE IF NOT EXISTS `specialite` (
  `id_spe` varchar(255) NOT NULL,
  PRIMARY KEY (`id_spe`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `specialite`
--

INSERT INTO `specialite` (`id_spe`) VALUES
('GBA3'),
('GBA4'),
('GBA5'),
('IG3'),
('IG4'),
('IG5'),
('MEA3'),
('MEA4'),
('MEA5'),
('MI3'),
('MI4'),
('MI5'),
('PEIP1'),
('PEIP2'),
('STE3'),
('STE4'),
('STE5');

-- --------------------------------------------------------

--
-- Structure de la table `sujet_toeic`
--

DROP TABLE IF EXISTS `sujet_toeic`;
CREATE TABLE IF NOT EXISTS `sujet_toeic` (
  `id_sujet` int(11) NOT NULL AUTO_INCREMENT,
  `nom_sujet` varchar(255) NOT NULL,
  PRIMARY KEY (`id_sujet`),
  UNIQUE KEY `nom_sujet` (`nom_sujet`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sujet_toeic`
--

INSERT INTO `sujet_toeic` (`id_sujet`, `nom_sujet`) VALUES
(1, 'test');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `est_de_groupe`
--
ALTER TABLE `est_de_groupe`
  ADD CONSTRAINT `est_de_groupe_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`) ON DELETE CASCADE,
  ADD CONSTRAINT `est_de_groupe_ibfk_2` FOREIGN KEY (`id_grp`) REFERENCES `groupe` (`id_grp`);

--
-- Contraintes pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD CONSTRAINT `groupe_ibfk_1` FOREIGN KEY (`id_spe`) REFERENCES `specialite` (`id_spe`);

--
-- Contraintes pour la table `participe`
--
ALTER TABLE `participe`
  ADD CONSTRAINT `participe_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`),
  ADD CONSTRAINT `participe_ibfk_3` FOREIGN KEY (`id_grp`) REFERENCES `groupe` (`id_grp`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`id_sujet`) REFERENCES `sujet_toeic` (`id_sujet`) ON DELETE CASCADE;

--
-- Contraintes pour la table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`id_sujet`) REFERENCES `sujet_toeic` (`id_sujet`);

--
-- Contraintes pour la table `sous_partie`
--
ALTER TABLE `sous_partie`
  ADD CONSTRAINT `sous_partie_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`),
  ADD CONSTRAINT `sous_partie_ibfk_2` FOREIGN KEY (`id_session`) REFERENCES `session` (`id_session`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
