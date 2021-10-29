-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 25 oct. 2021 à 20:05
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `waribana`
--

-- --------------------------------------------------------

--
-- Structure de la table `cahier_compte_tontines`
--

DROP TABLE IF EXISTS `cahier_compte_tontines`;
CREATE TABLE IF NOT EXISTS `cahier_compte_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` float NOT NULL,
  `index_ouverture` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cahier_compte_tontines`
--

INSERT INTO `cahier_compte_tontines` (`id`, `id_tontine`, `id_menbre`, `montant`, `index_ouverture`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 336.6, 1, '2021-10-08 15:58:30', '2021-10-08 15:36:36'),
(2, 1, 1, 336.6, 1, '2021-10-08 15:58:33', '2021-10-08 15:36:36'),
(3, 1, 1, 336.6, 2, '2021-10-08 16:51:45', '2021-10-08 16:51:45');

-- --------------------------------------------------------

--
-- Structure de la table `cahier_retrait_solde_menbres`
--

DROP TABLE IF EXISTS `cahier_retrait_solde_menbres`;
CREATE TABLE IF NOT EXISTS `cahier_retrait_solde_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant_retirer` int(11) NOT NULL,
  `solde_avant` int(11) NOT NULL,
  `solde_apres` int(11) NOT NULL,
  `statut` enum('REFUSED','ACCEPTED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cahier_retrait_solde_menbres`
--

INSERT INTO `cahier_retrait_solde_menbres` (`id`, `id_menbre`, `montant_retirer`, `solde_avant`, `solde_apres`, `statut`, `created_at`, `updated_at`) VALUES
(2, 2, 500, 1500, 1000, 'ACCEPTED', '2021-10-08 15:02:40', '2021-10-08 15:02:40'),
(3, 15, 500, 1500, 1000, 'ACCEPTED', '2021-10-08 15:02:40', '2021-10-08 15:02:40');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_tontines`
--

DROP TABLE IF EXISTS `caisse_tontines`;
CREATE TABLE IF NOT EXISTS `caisse_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL DEFAULT '0',
  `montant_objectif` int(11) NOT NULL,
  `frais_de_gestion` int(11) NOT NULL DEFAULT '1',
  `montant_a_verser` float NOT NULL,
  `id_menbre_qui_prend` int(11) NOT NULL,
  `index_menbre_qui_prend` int(11) NOT NULL DEFAULT '0',
  `index_ouverture` int(11) NOT NULL DEFAULT '1',
  `prochaine_date_encaissement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_tontines`
--

INSERT INTO `caisse_tontines` (`id`, `id_tontine`, `montant`, `montant_objectif`, `frais_de_gestion`, `montant_a_verser`, `id_menbre_qui_prend`, `index_menbre_qui_prend`, `index_ouverture`, `prochaine_date_encaissement`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 340, 1, 336.6, 2, 1, 2, '21-10-2021', '2021-10-07 14:16:36', '2021-10-08 16:51:45'),
(2, 3, 0, 40000, 400, 39600, 4, 0, 1, '28-10-2021', '2021-10-13 11:17:53', '2021-10-13 11:17:53'),
(3, 8, 0, 300000, 3000, 297000, 3, 0, 1, '15-11-2021', '2021-10-16 19:58:45', '2021-10-16 19:58:45'),
(4, 18, 500, 1000, 10, 990, 15, 0, 1, '02-11-2021', '2021-10-19 14:48:18', '2021-10-23 19:02:25'),
(5, 20, 0, 1000, 10, 990, 16, 0, 1, '27-10-2021', '2021-10-20 16:54:25', '2021-10-20 16:54:25');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_waricrowds`
--

DROP TABLE IF EXISTS `caisse_waricrowds`;
CREATE TABLE IF NOT EXISTS `caisse_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant_objectif` int(11) NOT NULL,
  `montant` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_waricrowds`
--

INSERT INTO `caisse_waricrowds` (`id`, `id_waricrowd`, `montant_objectif`, `montant`, `created_at`, `updated_at`) VALUES
(1, 1, 2322, 0, '2021-10-07 15:07:12', '2021-10-07 15:07:12'),
(2, 2, 50000000, 987, '2021-10-13 11:13:01', '2021-10-18 17:35:50'),
(3, 3, 2332, 0, '2021-10-18 03:25:35', '2021-10-18 03:25:35'),
(4, 5, 5698, 0, '2021-10-18 13:05:49', '2021-10-18 13:05:49'),
(5, 6, 5000, 700, '2021-10-18 13:15:27', '2021-10-23 19:12:18'),
(6, 7, 560000, 0, '2021-10-18 16:46:20', '2021-10-19 14:50:50'),
(7, 8, 58003, 0, '2021-10-18 17:05:51', '2021-10-20 17:08:59'),
(8, 9, 569, 0, '2021-10-20 17:23:18', '2021-10-20 17:55:11'),
(9, 10, 3223, 0, '2021-10-22 00:23:42', '2021-10-22 00:23:42'),
(10, 11, 4545, 0, '2021-10-22 00:32:27', '2021-10-22 00:32:27'),
(11, 12, 4545, 0, '2021-10-22 00:32:50', '2021-10-22 00:32:50'),
(12, 13, 3434, 0, '2021-10-22 00:33:44', '2021-10-22 00:33:44'),
(13, 14, 65, 0, '2021-10-22 00:35:33', '2021-10-22 00:35:33');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_waricrowds`
--

DROP TABLE IF EXISTS `categorie_waricrowds`;
CREATE TABLE IF NOT EXISTS `categorie_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categorie_waricrowds_titre_unique` (`titre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_waricrowds`
--

INSERT INTO `categorie_waricrowds` (`id`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Economie', '2021-10-07 12:44:47', '2021-10-07 12:44:47'),
(2, 'Informatique', '2021-10-07 12:44:59', '2021-10-07 12:44:59'),
(3, 'Agroalimentaire', '2021-10-14 16:17:52', '2021-10-14 16:17:52');

-- --------------------------------------------------------

--
-- Structure de la table `chat_tontine_messages`
--

DROP TABLE IF EXISTS `chat_tontine_messages`;
CREATE TABLE IF NOT EXISTS `chat_tontine_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chat_tontine_messages`
--

INSERT INTO `chat_tontine_messages` (`id`, `id_tontine`, `id_menbre`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'ice ou pas', '2021-10-07 16:31:20', '2021-10-07 16:31:20'),
(2, 1, 1, 'un peu lowcost mais on apprécie l\'effort', '2021-10-07 16:32:02', '2021-10-07 16:32:02'),
(3, 2, 3, 'Salut a tous', '2021-10-12 00:13:52', '2021-10-12 00:13:52'),
(4, 3, 4, 'Bonjour à tous', '2021-10-12 17:20:01', '2021-10-12 17:20:01'),
(5, 5, 4, 'Bonjour<br/>', '2021-10-13 11:08:31', '2021-10-13 11:08:31'),
(6, 8, 3, 'Bonjour', '2021-10-16 19:59:21', '2021-10-16 19:59:21'),
(7, 8, 13, 'Slt', '2021-10-16 19:59:56', '2021-10-16 19:59:56'),
(8, 8, 3, 'Salut', '2021-10-16 20:02:01', '2021-10-16 20:02:01'),
(9, 8, 3, 'Test', '2021-10-16 20:02:32', '2021-10-16 20:02:32'),
(10, 8, 12, 'Aaaaa', '2021-10-16 20:02:47', '2021-10-16 20:02:47');

-- --------------------------------------------------------

--
-- Structure de la table `compte_menbres`
--

DROP TABLE IF EXISTS `compte_menbres`;
CREATE TABLE IF NOT EXISTS `compte_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `solde` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_menbres`
--

INSERT INTO `compte_menbres` (`id`, `id_menbre`, `solde`, `created_at`, `updated_at`) VALUES
(1, 1, 7005, '2021-10-07 13:01:48', '2021-10-23 23:24:47'),
(2, 2, 1000, '2021-10-07 14:12:09', '2021-10-08 15:02:40'),
(3, 3, 0, '2021-10-08 09:59:01', '2021-10-08 09:59:01'),
(4, 4, 0, '2021-10-09 19:12:43', '2021-10-09 19:12:43'),
(5, 5, 0, '2021-10-11 09:57:59', '2021-10-11 09:57:59'),
(6, 6, 0, '2021-10-11 10:13:21', '2021-10-11 10:13:21'),
(7, 7, 0, '2021-10-11 11:06:54', '2021-10-11 11:06:54'),
(8, 8, 0, '2021-10-13 08:38:36', '2021-10-13 08:38:36'),
(9, 9, 0, '2021-10-14 14:40:12', '2021-10-14 14:40:12'),
(10, 10, 0, '2021-10-14 15:00:13', '2021-10-14 15:00:13'),
(11, 11, 0, '2021-10-14 15:29:53', '2021-10-14 15:29:53'),
(12, 12, 0, '2021-10-16 19:52:25', '2021-10-16 19:52:25'),
(13, 13, 0, '2021-10-16 19:53:48', '2021-10-16 19:53:48'),
(14, 14, 0, '2021-10-18 00:41:43', '2021-10-18 00:41:43'),
(15, 15, 2828, '2021-10-19 14:26:51', '2021-10-23 23:24:43'),
(16, 16, 0, '2021-10-20 15:50:47', '2021-10-20 15:50:47');

-- --------------------------------------------------------

--
-- Structure de la table `devises`
--

DROP TABLE IF EXISTS `devises`;
CREATE TABLE IF NOT EXISTS `devises` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monaie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devises_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `devises`
--

INSERT INTO `devises` (`id`, `code`, `symbole`, `monaie`) VALUES
(1, 'XOF', 'FCFA', 'FCFA'),
(2, 'USD', '$', 'dollards'),
(3, 'EUR', '€', 'euros');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

DROP TABLE IF EXISTS `invitations`;
CREATE TABLE IF NOT EXISTS `invitations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_inviter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `menbre_qui_invite` bigint(20) UNSIGNED NOT NULL,
  `etat` enum('attente','invitation envoyee','acceptee','refusee','expiree') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `invitations`
--

INSERT INTO `invitations` (`id`, `email_inviter`, `id_tontine`, `menbre_qui_invite`, `etat`, `created_at`, `updated_at`) VALUES
(1, 'yvessantoz@gmail.com', 1, 1, 'acceptee', '2021-10-07 14:13:19', '2021-10-07 14:14:55'),
(3, 'Willy.houed@gmail.com', 3, 4, 'refusee', '2021-10-12 17:20:48', '2021-10-13 09:19:06'),
(18, 'w.houedanou@bloomfield-investment.com', 5, 4, 'attente', '2021-10-13 11:07:52', '2021-10-13 11:07:52'),
(19, '2250565327653', 4, 5, 'invitation envoyee', '2021-10-13 13:13:24', '2021-10-13 13:13:24'),
(20, 'yves.ladde@akassoh.ci', 4, 5, 'attente', '2021-10-13 13:13:34', '2021-10-13 13:13:34'),
(21, '2250103570000', 6, 10, 'invitation envoyee', '2021-10-14 15:10:55', '2021-10-14 15:10:55'),
(22, 'salame.industry@gmail.com', 6, 10, 'attente', '2021-10-14 15:14:54', '2021-10-14 15:14:54'),
(23, 'vvjv@xhcj.cvkhl', 17, 14, 'attente', '2021-10-18 02:38:19', '2021-10-18 02:38:19'),
(24, '2250778735784', 17, 14, 'attente', '2021-10-18 02:41:58', '2021-10-18 02:41:58'),
(25, 'vjvh@gh.vjj', 17, 14, 'attente', '2021-10-18 02:42:20', '2021-10-18 02:42:20'),
(26, '2250778735784', 17, 14, 'invitation envoyee', '2021-10-18 02:48:07', '2021-10-18 02:48:07'),
(27, 'yvessantoz@gmail.com', 18, 15, 'expiree', '2021-10-19 14:33:37', '2021-10-19 14:45:58'),
(28, '2250565327653', 18, 15, 'invitation envoyee', '2021-10-19 14:33:54', '2021-10-19 14:33:54'),
(30, '2250565327653', 19, 15, 'invitation envoyee', '2021-10-19 14:47:03', '2021-10-19 14:47:03'),
(31, '22555994041', 19, 16, 'invitation envoyee', '2021-10-20 16:08:59', '2021-10-20 16:08:59'),
(32, '2250555994041', 19, 16, 'invitation envoyee', '2021-10-20 16:09:59', '2021-10-20 16:09:59'),
(33, '2250778735784', 19, 16, 'invitation envoyee', '2021-10-20 16:12:28', '2021-10-20 16:12:28'),
(34, 'yvessantoz@gmail.com', 20, 16, 'acceptee', '2021-10-20 16:22:46', '2021-10-20 16:29:32'),
(35, '2250555994041', 20, 16, 'invitation envoyee', '2021-10-20 16:23:18', '2021-10-20 16:23:18'),
(36, '2250565327653', 21, 16, 'invitation envoyee', '2021-10-20 16:51:03', '2021-10-20 16:51:03'),
(37, '2250555994041', 17, 14, 'invitation envoyee', '2021-10-20 16:53:44', '2021-10-20 16:53:44'),
(38, 'ice@gmail.com', 17, 14, 'acceptee', '2021-10-20 16:55:39', '2021-10-20 17:02:29');

-- --------------------------------------------------------

--
-- Structure de la table `menbres`
--

DROP TABLE IF EXISTS `menbres`;
CREATE TABLE IF NOT EXISTS `menbres` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_complet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` enum('attente','actif','suspendu') COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_derniere_visite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `devise` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_de_confirmation` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat_us` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `menbres_telephone_unique` (`telephone`),
  UNIQUE KEY `menbres_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbres`
--

INSERT INTO `menbres` (`id`, `nom_complet`, `telephone`, `email`, `mot_de_passe`, `etat`, `motif_intervention_admin`, `date_derniere_visite`, `devise`, `code_de_confirmation`, `created_at`, `updated_at`, `pays`, `ville`, `adresse`, `etat_us`, `code_postal`) VALUES
(1, 'utilisateur deux', '2250778735784', NULL, '233c7f5cf0ce82ef72556d8fd4f5426a', 'actif', NULL, '07-10-2021 16:56:26', '2', 1387, '2021-10-07 13:01:48', '2021-10-23 20:29:54', 'ci', 'abidjan', 'cocody palmeraie', NULL, NULL),
(2, 'yves santoz', '2250987654333', 'oyvessantoz@gmail.com', 'e3122587250f1537b2c4129c0031dcba', 'actif', NULL, '07-10-2021 16:32:46', '1', 1542, '2021-10-07 14:12:09', '2021-10-08 16:55:02', 'CI', 'Abidjan', 'bingervillle', NULL, NULL),
(3, 'Salame nayef', '2250103570000', 'recyplast.ci@gmail.com', 'efedd54f262d8129cf744dc3196b6324', 'actif', NULL, '16-10-2021 20:02:52', '1', 3992, '2021-10-08 09:59:01', '2021-10-16 20:02:52', 'CI', 'Abidjan', 'Abidjan cocody', NULL, NULL),
(4, 'Wilfried HOUEDANOU', '2250709779787', 'whouedanou@gmail.com', '201dd75c02cc2cab01d63d752d364016', 'actif', NULL, '13-10-2021 11:08:25', '1', 84216, '2021-10-09 19:12:43', '2021-10-13 11:08:25', 'CI', 'AbidjaN', 'Cocody', NULL, NULL),
(5, 'hi boy', '22505653jjk29653', 'newsmsapi@gmail.com', '3b29f690be41036e1ca16033556f2400', 'actif', NULL, NULL, '1', 9175, '2021-10-11 09:57:59', '2021-10-11 16:04:33', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(6, 'sandra', '2250789588653', 'lagoma.business@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'actif', NULL, NULL, NULL, 6804, '2021-10-11 10:13:21', '2021-10-11 10:15:16', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(7, 'Huberson Kouakou', '2250758187266', 'huberson.kouakou@yahoo.com', 'c2fc7bd2b1011f30954b4455e74bb74d', 'actif', NULL, NULL, '1', 2518, '2021-10-11 11:06:54', '2021-10-11 11:09:39', 'CI', 'Abidjan', 'Abidjan', NULL, NULL),
(8, 'Koffi josephine', '2250748216712', 'willy.houed@gmail.com', '201dd75c02cc2cab01d63d752d364016', 'actif', NULL, NULL, '1', 6732, '2021-10-13 08:38:36', '2021-10-13 08:39:44', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(10, 'ALAN', '2250707255244', 'hexagonegroupe@gmail.com', 'e18900207d2584a1c7615316e28a2443', 'actif', NULL, '14-10-2021 15:13:40', '1', 4526, '2021-10-14 15:00:13', '2021-10-14 15:13:40', 'CI', 'abidjan', 'cocody', NULL, NULL),
(11, 'Huberson Kouakou', '22558187266', 'huberson.kouakou@akassoh.ci', 'c2fc7bd2b1011f30954b4455e74bb74d', 'attente', NULL, NULL, NULL, 7942, '2021-10-14 15:29:53', '2021-10-14 15:29:53', 'CI', 'Abidjan', 'Abidjan', NULL, NULL),
(12, 'Mohamed EL ZEIN', '2250707091982', 'mohamedelzein78@gmail.com', '40641914166f1cba1d06c020e462ff8e', 'actif', NULL, '16-10-2021 20:02:39', '1', 5989, '2021-10-16 19:52:25', '2021-10-16 20:02:39', 'CI', 'Abidjan', 'Cocody', NULL, NULL),
(13, 'Nadim hoballah', '2250700780738', 'nym8@hotmail.com', '335cf4508dd597be4bfc9caa3e08b901', 'actif', NULL, '16-10-2021 20:04:42', '1', 3976, '2021-10-16 19:53:48', '2021-10-16 20:04:42', 'CI', 'Abidjan', 'CocoDy', NULL, NULL),
(14, 'PERSONNE PERSONNE', '2250555994042', 'yvessantoz@gmail.com', '4124bc0a9335c27f086f24ba207a4912', 'actif', NULL, NULL, '3', 4049, '2021-10-18 00:41:43', '2021-10-19 11:20:50', 'CI', 'ABIDJAN', 'PERSONNE', NULL, NULL),
(15, 'BUT IT WORK 2', '2250555994041', 'yvessantow2@gmail.com', '4124bc0a9335c27f086f24ba207a4912', 'actif', NULL, NULL, '3', 113352, '2021-10-19 14:26:51', '2021-10-19 23:16:32', 'FR', 'ABIDJAN DEH', 'KOUMASSI ICE', 'Alabama', '639'),
(16, 'MÊME PAS VRAI', '2250565327653', 'ice@gmail.com', '4124bc0a9335c27f086f24ba207a4912', 'actif', NULL, NULL, '2', 66444, '2021-10-20 15:50:46', '2021-10-20 16:55:22', 'CI', 'YAKRO', 'UN QUARTIER', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `menbre_tontine`
--

DROP TABLE IF EXISTS `menbre_tontine`;
CREATE TABLE IF NOT EXISTS `menbre_tontine` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tontine_id` bigint(20) UNSIGNED NOT NULL,
  `menbre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbre_tontine`
--

INSERT INTO `menbre_tontine` (`id`, `tontine_id`, `menbre_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2021-10-07 14:10:25', '2021-10-07 14:10:25'),
(2, 1, 2, '2021-10-07 14:14:55', '2021-10-07 14:14:55'),
(3, 2, 3, '2021-10-12 00:11:21', '2021-10-12 00:11:21'),
(4, 3, 4, '2021-10-12 17:19:36', '2021-10-12 17:19:36'),
(5, 3, 8, '2021-10-13 08:40:44', '2021-10-13 08:40:44'),
(6, 4, 5, '2021-10-13 09:06:41', '2021-10-13 09:06:41'),
(7, 5, 4, '2021-10-13 09:20:50', '2021-10-13 09:20:50'),
(8, 6, 10, '2021-10-14 15:09:27', '2021-10-14 15:09:27'),
(9, 7, 3, '2021-10-16 19:48:42', '2021-10-16 19:48:42'),
(10, 8, 3, '2021-10-16 19:52:36', '2021-10-16 19:52:36'),
(11, 8, 12, '2021-10-16 19:57:07', '2021-10-16 19:57:07'),
(12, 8, 13, '2021-10-16 19:57:50', '2021-10-16 19:57:50'),
(13, 9, 10, '2021-10-18 00:40:33', '2021-10-18 00:40:33'),
(14, 10, 10, '2021-10-18 00:51:42', '2021-10-18 00:51:42'),
(15, 11, 10, '2021-10-18 00:54:05', '2021-10-18 00:54:05'),
(16, 12, 10, '2021-10-18 00:57:44', '2021-10-18 00:57:44'),
(17, 13, 10, '2021-10-18 00:59:05', '2021-10-18 00:59:05'),
(18, 14, 10, '2021-10-18 01:01:45', '2021-10-18 01:01:45'),
(19, 15, 14, '2021-10-18 01:31:45', '2021-10-18 01:31:45'),
(20, 16, 14, '2021-10-18 01:36:51', '2021-10-18 01:36:51'),
(21, 17, 14, '2021-10-18 01:38:33', '2021-10-18 01:38:33'),
(22, 18, 15, '2021-10-18 01:39:02', '2021-10-18 01:39:02'),
(25, 18, 14, '2021-10-19 14:45:58', '2021-10-19 14:45:58'),
(26, 19, 16, '2021-10-20 15:58:47', '2021-10-20 15:58:47'),
(27, 20, 16, '2021-10-20 16:22:20', '2021-10-20 16:22:20'),
(28, 20, 14, '2021-10-20 16:29:32', '2021-10-20 16:29:32'),
(29, 21, 16, '2021-10-20 16:35:17', '2021-10-20 16:35:17'),
(30, 17, 16, '2021-10-20 16:55:54', '2021-10-20 16:55:54'),
(31, 22, 15, '2021-10-22 00:23:07', '2021-10-22 00:23:07');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_09_13_162717_create_sessions_table', 1),
(7, '2021_09_14_102159_create_menbres_table', 1),
(8, '2021_09_14_133811_create_tontines_table', 1),
(9, '2021_09_14_160126_create_invitations_table', 1),
(10, '2021_09_14_174326_create_menbre_tontine_table', 1),
(11, '2021_09_15_110733_create_transactions_table', 1),
(12, '2021_09_15_112553_create_caisse_tontines_table', 1),
(13, '2021_09_15_164113_create_compte_menbres_table', 1),
(14, '2021_09_15_164217_create_cahier_compte_tontines_table', 1),
(15, '2021_09_16_111919_create_waricrowds_table', 1),
(16, '2021_09_16_112237_create_transaction_waricrowds_table', 1),
(17, '2021_09_16_112255_create_caisse_waricrowds_table', 1),
(18, '2021_09_16_145804_create_waricrowd_menbres_table', 1),
(19, '2021_09_20_110724_create_sms_contenu_notifications_table', 1),
(20, '2021_09_20_120009_create_statistique_frequentations_table', 1),
(21, '2021_09_20_124438_create_categorie_waricrowds_table', 1),
(22, '2021_09_23_120824_create_chat_tontine_messages_table', 1),
(23, '2021_10_04_013522_create_devises_table', 1),
(25, '2021_10_06_123738_create_cahier_retrait_solde_menbres_table', 2),
(26, '2021_10_22_161920_create_transaction_waribanks_table', 3),
(29, '2021_10_23_071247_create_transaction_rechargement_waribanks_table', 4),
(32, '2021_10_23_203927_create_transaction_transfert_waribanks_table', 5);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('6XXMXo9FnQS9rFAgNsf26eVJKkepciYET0P5hNHI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:93.0) Gecko/20100101 Firefox/93.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHZBU0tsdHZJRTViUHJROUFYdENTcHZ2bHJaREV2QkRyZ1lIYmpicSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lc3BhY2UtbWVuYnJlL21vbi1jb21wdGUtd2FyaWJhbmsvMTUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjI1OiJtZW5icmVfd2FyaWJhbmFfY29ubmVjdGVyIjthOjQ6e3M6MjoiaWQiO2k6MTU7czoxMToibm9tX2NvbXBsZXQiO3M6MTM6IkJVVCBJVCBXT1JLIDIiO3M6NjoiZGV2aXNlIjtzOjU6ImV1cm9zIjtzOjExOiJjb2RlX2RldmlzZSI7czozOiJFVVIiO319', 1635037074),
('Pqbsvfp644tPZdpVIABzdytSYxNSgfS4BRoBHyGg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/95.0.4638.54 Safari/537.36 Edg/95.0.1020.30', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiejhoSkN3M2pnWlhXTk5BdTNObFpDZnBoZGxidlYzTHYwVklVYmE1UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lc3BhY2UtbWVuYnJlL21vbi1jb21wdGUtd2FyaWJhbmsvMSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjU6Im1lbmJyZV93YXJpYmFuYV9jb25uZWN0ZXIiO2E6NDp7czoyOiJpZCI7aToxO3M6MTE6Im5vbV9jb21wbGV0IjtzOjE2OiJ1dGlsaXNhdGV1ciBkZXV4IjtzOjY6ImRldmlzZSI7czo4OiJkb2xsYXJkcyI7czoxMToiY29kZV9kZXZpc2UiO3M6MzoiVVNEIjt9fQ==', 1635029403);

-- --------------------------------------------------------

--
-- Structure de la table `sms_contenu_notifications`
--

DROP TABLE IF EXISTS `sms_contenu_notifications`;
CREATE TABLE IF NOT EXISTS `sms_contenu_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `confirmation_compte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_waricowd` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitation_recue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_tontine` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `virement_compte_menbre_qui_prend` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `retard_paiement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sms_contenu_notifications`
--

INSERT INTO `sms_contenu_notifications` (`id`, `confirmation_compte`, `etat_waricowd`, `invitation_recue`, `etat_tontine`, `virement_compte_menbre_qui_prend`, `retard_paiement`, `created_at`, `updated_at`) VALUES
(1, 'Bienvenu(e) sur waribana, votre code de confirmation est le suivant $code$', 'Bonjour votre waricrowd intitule <<$titre$>> a été : $etat$ $motif$', 'Bonjour, le menbre $nom_complet$ de waribana vous invite a rejoindre la tontine << $titre_tontine$ >>, Connectez vous inscrivez-vous pour repondre a son invitation', 'Bonjour votre tontine intitule <<$titre$>> est : $etat$ $motif$', 'Bonjour, montant de cotisation atteinds sur tontine << $titre_tontine$ >>, virement effectue au menbre : $nom_menbre_qui_prend$', 'Bonjour, des cotisations en retard sur la tontine << $titre$ >>; retardataires : $liste_retardataires$', '2021-10-07 12:44:03', '2021-10-07 15:46:23');

-- --------------------------------------------------------

--
-- Structure de la table `statistique_frequentations`
--

DROP TABLE IF EXISTS `statistique_frequentations`;
CREATE TABLE IF NOT EXISTS `statistique_frequentations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mois_annee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visiteur` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `statistique_frequentations_slug_unique` (`slug`),
  UNIQUE KEY `statistique_frequentations_mois_annee_unique` (`mois_annee`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statistique_frequentations`
--

INSERT INTO `statistique_frequentations` (`id`, `slug`, `mois_annee`, `visiteur`, `created_at`, `updated_at`) VALUES
(1, '10/2021', '10/2021', 581, '2021-10-07 12:35:00', '2021-10-24 00:44:00');

-- --------------------------------------------------------

--
-- Structure de la table `tontines`
--

DROP TABLE IF EXISTS `tontines`;
CREATE TABLE IF NOT EXISTS `tontines` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `identifiant_adhesion` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequence_depot_en_jours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_participant` int(11) NOT NULL,
  `etat` enum('constitution','prete','ouverte','terminer','fermee','suspendue') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tontines`
--

INSERT INTO `tontines` (`id`, `identifiant_adhesion`, `titre`, `montant`, `frequence_depot_en_jours`, `nombre_participant`, `etat`, `id_menbre`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(1, 396, 'tontine test', '170', '7', 2, 'ouverte', 1, NULL, '2021-10-07 14:10:25', '2021-10-07 14:34:27'),
(2, 2645, 'Totine de nayef', '100000', '7', 2, 'constitution', 3, NULL, '2021-10-12 00:11:21', '2021-10-12 00:13:23'),
(3, 2985, 'TONTINE WILFRIED', '20000', '15', 2, 'ouverte', 4, NULL, '2021-10-12 17:19:36', '2021-10-13 11:17:53'),
(4, 1653, 'test22', '34545', '4', 2, 'constitution', 5, NULL, '2021-10-13 09:06:41', '2021-10-13 09:06:41'),
(5, 5984, 'VOYAGE D\'AFFAIRE', '1000000', '30', 5, 'constitution', 4, NULL, '2021-10-13 09:20:50', '2021-10-13 09:20:50'),
(6, 4739, 'financement personnel', '1000', '7', 2, 'constitution', 10, NULL, '2021-10-14 15:09:27', '2021-10-14 15:09:27'),
(7, 3068, 'La tontine de nayef', '100000', '7', 2, 'constitution', 3, NULL, '2021-10-16 19:48:42', '2021-10-16 19:48:42'),
(17, 5580, 'tt', '55', '88', 55, 'constitution', 14, NULL, '2021-10-18 01:38:32', '2021-10-18 01:38:32'),
(18, 6212, 'first tontine', '500', '14', 2, 'ouverte', 15, NULL, '2021-10-19 14:31:12', '2021-10-19 14:48:18'),
(20, 977, 'seond', '500', '7', 2, 'ouverte', 16, NULL, '2021-10-20 16:22:20', '2021-10-20 16:54:25'),
(21, 6206, 'hdh', '7689', '0 0', 8909, 'constitution', 16, NULL, '2021-10-20 16:35:17', '2021-10-20 16:35:17'),
(22, 7016, 'dsd', '32', '2', 3, 'constitution', 15, NULL, '2021-10-22 00:23:07', '2021-10-22 00:23:07');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_menbre_qui_prend` bigint(20) UNSIGNED NOT NULL,
  `index_ouverture` int(11) NOT NULL DEFAULT '1',
  `trans_id` text COLLATE utf8mb4_unicode_ci,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `id_tontine`, `id_menbre`, `montant`, `statut`, `id_menbre_qui_prend`, `index_ouverture`, `trans_id`, `token`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633617613', 'ad84e9e47692b6de75e9e1ef612e2f013abf9d42c2721a1c776cd0c997b25b72afa2fa9219752747e863fc0ea3ccc0810310e82961989d', '2021-10-07 14:40:13', '2021-10-07 14:40:36'),
(2, 1, 1, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633618026', '1c875637befb3082ba1ac5aa86a79b8d2cce814c0e6e4763c91a5b598f6fd6fc28d1d5e649cad6ad4df94c01fcbdb69e8bcf7c08d6a0d7', '2021-10-07 14:47:07', '2021-10-07 14:47:27'),
(3, 1, 1, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633618428', 'dd5c613c82515a7880d8575cc29274f127564a100cf2cf736f381995be335e0329cbc601afd78293d8cf1ac13f32753107bd089aadfff8', '2021-10-07 14:53:48', '2021-10-07 14:54:10'),
(4, 1, 1, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633618549', '11c20f348c8454f285833f9fe08b639a585b5175d4e9c7ab94d1740758ab537e3e28db51ffd678cfb9bf3871420454fc8f664387ea89a5', '2021-10-07 14:55:49', '2021-10-07 14:56:05'),
(5, 1, 1, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633618625', 'bcefec388f38042cb0f3cb83798b2d96fad20f8693343ca62affab711227a9a9fc5352424ac17418c471549282e02d42ef0e69248189e5', '2021-10-07 14:57:05', '2021-10-07 14:57:19'),
(6, 1, 2, 170, 'REFUSED', 1, 1, 'waribana-tontine-1633710317', '6708be385bfc2f4f5736e81670fd03816a5ba8fefd4b42330a5d7d324f4246eb7bb2842b6e987a5e285d5c53e3affd2aa5f86bbce01b78', '2021-10-08 16:25:17', '2021-10-08 16:25:32'),
(7, 1, 2, 170, 'ACCEPTED', 1, 1, 'waribana-tontine-1633710459', 'b9f801d8593bd45ff6925c6c18efc4d59f887774941cfc3f11e056926ee83612bce331d023b360c7f94e8111dcc950da85214e53589918', '2021-10-08 16:27:39', '2021-10-08 16:51:15'),
(8, 1, 2, 170, 'ACCEPTED', 1, 1, 'waribana-tontine-1633711245', '42055d9a40f465cef0f789961f78e201fb05b6c491bf88641f21e855fe79b90242d9d6a55659cea9304e77197273b36e450f0b4035a154', '2021-10-08 16:40:46', '2021-10-08 16:41:02'),
(9, 1, 1, 170, 'PENDING', 1, 2, 'waribana-tontine-1633711551', 'e9f2a4efe7b1015c8c15040b4b36a7c5e8bdbf23499532fad1dce4c68c5a8529b9d2cddc0de59f831e2a30943d313213a4802631856be0', '2021-10-08 16:45:51', '2021-10-08 16:45:51'),
(10, 1, 2, 170, 'PENDING', 2, 2, 'waribana-tontine-1633713112', '47f518034c0679d5d5b5577b12c640d1a8d997b36a6ee2a1445895a53e7007ceb98aae866543f713fd5f5f896ea41bc1ed8200f17b18c1', '2021-10-08 17:11:53', '2021-10-08 17:11:53'),
(11, 3, 4, 20000, 'PENDING', 4, 1, 'waribana-tontine-1634123889', '8d070b710ce1c68199332fe5f26e3feac2fd4f300653d9a44ea78d076d8e8b7e9a02e06dfab0a8be8009604fd347520c8a6e94169b94f9', '2021-10-13 11:18:10', '2021-10-13 11:18:10'),
(12, 1, 1, 170, 'REFUSED', 2, 2, 'waribana-tontine-1634222657', '01098daf6d4c12e552ed8aead17e92dd64edc30f7e90460ed2075ade747639e8e9a7d14241a532c05751e391ee37397533308b624028aa', '2021-10-14 14:44:17', '2021-10-14 14:47:52'),
(14, 20, 16, 500, 'PENDING', 16, 1, 'waribana-tontine-1634749379', '6b3d5a10d11ed1e237dedc1993b672745f8baf4190cd7ed3247cdb486fb1e2dd889ba85f4b3be7d89501610c75d9150043f2619bb9ba4b', '2021-10-20 17:03:00', '2021-10-20 17:03:00'),
(15, 20, 16, 500, 'PENDING', 16, 1, 'waribana-tontine-1634749470', 'b4b7bff09e57460f2faf4d27f007116721a8ca16b4f8f212ac161e8de202bb400f5c108c5b71112e5c49f5e0bab60dcbfa9061c0e352b6', '2021-10-20 17:04:31', '2021-10-20 17:04:31'),
(16, 20, 16, 500, 'PENDING', 16, 1, 'waribana-tontine-1634749514', 'c8905e4aa1cdd6486886bdcc0db58e91a556670a8ef3b4deb9910c2a16dc3abcf4eba5f57f64910d7a98fe50fd3fc53fa9103301b91d9d', '2021-10-20 17:05:15', '2021-10-20 17:05:15'),
(17, 18, 15, 500, 'ACCEPTED', 15, 1, NULL, NULL, '2021-10-23 19:02:25', '2021-10-23 19:02:25');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_rechargement_waribanks`
--

DROP TABLE IF EXISTS `transaction_rechargement_waribanks`;
CREATE TABLE IF NOT EXISTS `transaction_rechargement_waribanks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menbre` int(11) NOT NULL,
  `solde_avant` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `solde_apres` int(11) NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('PENDING','ACCEPTED','REFUSED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_rechargement_waribanks`
--

INSERT INTO `transaction_rechargement_waribanks` (`id`, `id_menbre`, `solde_avant`, `montant`, `solde_apres`, `trans_id`, `statut`, `created_at`, `updated_at`) VALUES
(1, 15, 10972, 9, 10981, 'waribana-rechargement1634987572', 'ACCEPTED', '2021-10-23 11:12:57', '2021-10-23 18:50:51');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_transfert_waribanks`
--

DROP TABLE IF EXISTS `transaction_transfert_waribanks`;
CREATE TABLE IF NOT EXISTS `transaction_transfert_waribanks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_menbre` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_monaie_expediteur` int(11) NOT NULL,
  `montant_equivalent_destinataire` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_transfert_waribanks`
--

INSERT INTO `transaction_transfert_waribanks` (`id`, `id_menbre`, `id_destinataire`, `telephone`, `montant_monaie_expediteur`, `montant_equivalent_destinataire`, `created_at`, `updated_at`) VALUES
(1, 15, 1, '0778735784', 500, 583, '2021-10-23 22:27:46', '2021-10-23 22:27:46'),
(2, 15, 1, '0778735784', 481, 560, '2021-10-23 22:46:48', '2021-10-23 22:46:48'),
(3, 15, 1, '0778735784', 560, 652, '2021-10-23 22:49:35', '2021-10-23 22:49:35'),
(4, 15, 1, '0778735784', 100, 117, '2021-10-23 22:51:17', '2021-10-23 22:51:17'),
(5, 15, 1, '0778735784', 100, 117, '2021-10-23 22:52:28', '2021-10-23 22:52:28'),
(6, 15, 1, '0778735784', 100, 117, '2021-10-23 22:52:58', '2021-10-23 22:52:58'),
(7, 15, 1, '2250778735784', 450, 524, '2021-10-23 23:24:11', '2021-10-23 23:24:11'),
(8, 15, 1, '2250778735784', 450, 524, '2021-10-23 23:24:50', '2021-10-23 23:24:50');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_waricrowds`
--

DROP TABLE IF EXISTS `transaction_waricrowds`;
CREATE TABLE IF NOT EXISTS `transaction_waricrowds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_waricrowds`
--

INSERT INTO `transaction_waricrowds` (`id`, `id_menbre`, `id_waricrowd`, `montant`, `statut`, `trans_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 234, 'REFUSED', 'waribana-waricrowd-1633619304', '2021-10-07 15:08:25', '2021-10-07 15:08:39'),
(2, 1, 1, 700, 'REFUSED', 'waribana-waricrowd-1633619883', '2021-10-07 15:18:04', '2021-10-07 15:18:24'),
(3, 1, 1, 555, 'REFUSED', 'waribana-waricrowd-1633619947', '2021-10-07 15:19:08', '2021-10-07 15:19:46'),
(4, 1, 1, 555, 'PENDING', 'waribana-waricrowd-1633620032', '2021-10-07 15:20:33', '2021-10-07 15:20:33'),
(5, 1, 1, 555, 'PENDING', 'waribana-waricrowd-1633621107', '2021-10-07 15:38:27', '2021-10-07 15:38:27'),
(6, 2, 1, 500, 'PENDING', 'waribana-waricrowd-1633696608', '2021-10-08 12:36:48', '2021-10-08 12:36:48'),
(7, 2, 1, 500, 'PENDING', 'waribana-waricrowd-1633696943', '2021-10-08 12:42:23', '2021-10-08 12:42:23'),
(8, 2, 1, 500, 'PENDING', 'waribana-waricrowd-1633697150', '2021-10-08 12:45:50', '2021-10-08 12:45:50'),
(9, 14, 6, 23, 'ACCEPTED', 'waribana-waricrowd-1634565109', '2021-10-18 13:51:50', '2021-10-18 13:51:50'),
(10, 14, 6, 400, 'PENDING', 'waribana-waricrowd-1634577244', '2021-10-18 17:14:06', '2021-10-18 17:14:06'),
(11, 14, 6, 800, 'PENDING', 'waribana-waricrowd-1634577464', '2021-10-18 17:17:45', '2021-10-18 17:17:45'),
(12, 14, 6, 900, 'PENDING', 'waribana-waricrowd-1634577559', '2021-10-18 17:19:21', '2021-10-18 17:19:21'),
(13, 14, 2, 987, 'ACCEPTED', NULL, '2021-10-18 17:35:50', '2021-10-18 17:35:50'),
(14, 14, 2, 800, 'PENDING', 'waribana-waricrowd-1634579500', '2021-10-18 17:51:41', '2021-10-18 17:51:41'),
(15, 14, 2, 900, 'PENDING', 'waribana-waricrowd-1634579551', '2021-10-18 17:52:32', '2021-10-18 17:52:32'),
(16, 14, 2, 980, 'PENDING', 'waribana-waricrowd-1634580539', '2021-10-18 18:09:00', '2021-10-18 18:09:00'),
(17, 16, 9, 698, 'PENDING', 'waribana-waricrowd-1634751033', '2021-10-20 17:30:33', '2021-10-20 17:30:33'),
(18, 16, 9, 80, 'PENDING', 'waribana-waricrowd-1634752984', '2021-10-20 18:03:04', '2021-10-20 18:03:04'),
(19, 16, 9, 80, 'PENDING', 'waribana-waricrowd-1634753129', '2021-10-20 18:05:30', '2021-10-20 18:05:30'),
(20, 15, 1, 500, 'PENDING', 'waribana-waricrowd-1634919068', '2021-10-22 16:11:08', '2021-10-22 16:11:08'),
(21, 15, 6, 700, 'ACCEPTED', NULL, '2021-10-23 19:12:18', '2021-10-23 19:12:18');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$/2A6Yb79Fvi02yik95Ojq.Zv8YuYZrf.119U3jqEP/ljI2gPWP7C2', NULL, NULL, NULL, NULL, NULL, '2021-10-05 11:05:22', '2021-10-07 15:52:08');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowds`
--

DROP TABLE IF EXISTS `waricrowds`;
CREATE TABLE IF NOT EXISTS `waricrowds` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_courte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_complete` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_objectif` int(11) DEFAULT NULL,
  `lien_pitch_video` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_illustration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'images/waricrowd/statiques/crowfunding.png',
  `etat` enum('attente','valider','recaler','terminer','annuler') COLLATE utf8mb4_unicode_ci NOT NULL,
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowds`
--

INSERT INTO `waricrowds` (`id`, `id_categorie`, `id_menbre`, `titre`, `description_courte`, `description_complete`, `montant_objectif`, `lien_pitch_video`, `image_illustration`, `etat`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'jcvck', 'Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page', 'here are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.\r\n\r\nhere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 2322, 'https://www.youtube.com/embed/DzH5aRoMYLw', 'images/waricrowd/111222.png', 'valider', NULL, '2021-10-07 15:07:12', '2021-10-07 15:08:02'),
(2, '1', 4, 'TEST ECONOMIE', 'Juste un test', 'ceci est un test, Juste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un test', 50000000, 'https://www.youtube.com/embed/fyqQmh35vQc&list=RDfyqQmh35vQc&start_radio=1', 'images/waricrowd/111222.png', 'valider', 'Excellent projet', '2021-10-13 11:13:01', '2021-10-14 16:18:27'),
(3, '2', 14, 'dfsd', '23', 'assa', 2332, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-18 03:25:35', '2021-10-18 03:25:35'),
(5, '1', 14, 'titr', 'gjjhlm courte', 'hvjjnbj complète', 5698, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-18 13:05:49', '2021-10-18 13:05:49'),
(6, '3', 14, 'agro', 'desc courte', 'desc long', 5000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-10-18 13:15:27', '2021-10-18 13:50:01'),
(7, '2', 15, 'WC informatique', 'hjk', 'hvvu uuNkkk kllkk nkl kl', 560000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-19 14:50:50', '2021-10-19 14:50:50'),
(9, '3', 16, 'hnk xx', 'jb', 'ggj', 569, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-10-20 17:23:18', '2021-10-20 17:55:11'),
(14, '2', 15, 'dfg', 'fg', 'gf', 65, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-22 00:35:33', '2021-10-22 00:35:33');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowd_menbres`
--

DROP TABLE IF EXISTS `waricrowd_menbres`;
CREATE TABLE IF NOT EXISTS `waricrowd_menbres` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `menbre_id` bigint(20) UNSIGNED NOT NULL,
  `waricrowd_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowd_menbres`
--

INSERT INTO `waricrowd_menbres` (`id`, `menbre_id`, `waricrowd_id`, `created_at`, `updated_at`) VALUES
(1, 14, 2, '2021-10-18 17:35:50', '2021-10-18 17:35:50'),
(2, 16, 2, '2021-10-18 17:35:50', '2021-10-18 17:35:50'),
(3, 16, 9, '2021-10-18 17:35:50', '2021-10-18 17:35:50'),
(4, 15, 6, '2021-10-23 19:12:18', '2021-10-23 19:12:18');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
