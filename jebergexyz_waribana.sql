-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 27 sep. 2021 à 17:29
-- Version du serveur :  10.3.31-MariaDB-cll-lve
-- Version de PHP : 7.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `jebergexyz_waribana`
--

-- --------------------------------------------------------

--
-- Structure de la table `cahier_compte_tontines`
--

CREATE TABLE `cahier_compte_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cahier_compte_tontines`
--

INSERT INTO `cahier_compte_tontines` (`id`, `id_tontine`, `id_menbre`, `montant`, `created_at`, `updated_at`) VALUES
(1, 6, 4, 1440000, '2021-09-15 17:03:15', '2021-09-15 17:03:15'),
(2, 10, 2, 1000, '2021-09-15 19:01:52', '2021-09-15 19:01:52'),
(3, 10, 4, 1000, '2021-09-15 19:03:21', '2021-09-15 19:03:21'),
(4, 13, 2, 6425, '2021-09-22 10:45:31', '2021-09-22 10:45:31'),
(5, 13, 4, 6425, '2021-09-22 10:49:28', '2021-09-22 10:49:28'),
(6, 14, 2, 138600, '2021-09-23 14:59:54', '2021-09-23 14:59:54'),
(7, 18, 11, 990, '2021-09-24 22:43:45', '2021-09-24 22:43:45'),
(8, 19, 13, 1980, '2021-09-25 11:13:53', '2021-09-25 11:13:53');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_tontines`
--

CREATE TABLE `caisse_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL DEFAULT 0,
  `montant_objectif` int(11) NOT NULL,
  `frais_de_gestion` int(11) NOT NULL,
  `montant_a_verser` int(11) NOT NULL,
  `id_menbre_qui_prend` int(11) NOT NULL,
  `index_menbre_qui_prend` int(11) NOT NULL DEFAULT 0,
  `prochaine_date_encaissement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_tontines`
--

INSERT INTO `caisse_tontines` (`id`, `id_tontine`, `montant`, `montant_objectif`, `frais_de_gestion`, `montant_a_verser`, `id_menbre_qui_prend`, `index_menbre_qui_prend`, `prochaine_date_encaissement`, `created_at`, `updated_at`) VALUES
(1, 6, 0, 1440000, 0, 0, 4, 1, '08-09-2021', '2021-09-15 12:54:44', '2021-09-15 17:03:15'),
(2, 7, 0, 30000, 0, 0, 2, 1, '30-09-2021', '2021-09-15 14:39:12', '2021-09-15 14:49:44'),
(3, 10, 0, 1000, 0, 0, 4, 1, '29-09-2021', '2021-09-15 18:58:53', '2021-09-15 19:03:22'),
(4, 9, 0, 1200, 0, 0, 7, 0, '08-09-2021', '2021-09-17 16:23:41', '2021-09-17 16:23:41'),
(5, 11, 78500, 157000, 0, 0, 2, 0, '08-09-2021', '2021-09-21 14:35:55', '2021-09-21 16:38:47'),
(6, 13, 3245, 6490, 65, 6425, 2, 1, '06-10-2021', '2021-09-22 10:38:48', '2021-09-22 14:21:26'),
(7, 14, 560000, 140000, 1400, 138600, 4, 1, '07-10-2021', '2021-09-23 14:55:42', '2021-09-24 18:07:17'),
(8, 18, 500, 1000, 10, 990, 12, 1, '08-10-2021', '2021-09-24 22:39:10', '2021-09-24 22:55:44'),
(9, 19, 0, 2000, 20, 1980, 4, 1, '09-10-2021', '2021-09-25 11:12:49', '2021-09-25 11:13:53');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_waricrowds`
--

CREATE TABLE `caisse_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant_objectif` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_waricrowds`
--

INSERT INTO `caisse_waricrowds` (`id`, `id_waricrowd`, `montant_objectif`, `montant`, `created_at`, `updated_at`) VALUES
(1, 9, 4500000, 973192, '2021-09-16 13:27:28', '2021-09-17 16:13:19'),
(2, 10, 678678, 531223, '2021-09-16 16:47:07', '2021-09-24 17:03:14'),
(3, 11, 5700000, 150000, '2021-09-17 17:44:29', '2021-09-17 17:47:06'),
(4, 12, 3423, 0, '2021-09-20 13:29:15', '2021-09-20 13:29:15'),
(5, 13, 4346565, 0, '2021-09-20 13:30:09', '2021-09-20 13:30:09'),
(6, 14, 23432432, 0, '2021-09-20 13:46:58', '2021-09-20 13:46:58'),
(7, 15, 390000, 0, '2021-09-24 17:58:52', '2021-09-24 17:58:52'),
(8, 16, 150000, 0, '2021-09-24 23:16:39', '2021-09-24 23:16:39'),
(9, 17, 2000, 100, '2021-09-25 11:16:20', '2021-09-25 11:23:02');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_waricrowds`
--

CREATE TABLE `categorie_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_waricrowds`
--

INSERT INTO `categorie_waricrowds` (`id`, `slug`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Lourde categorie', 'deuxieme categorie', '2021-09-20 12:57:52', '2021-09-20 13:16:25'),
(3, 'Categorie de batard', 'Categorie 1', '2021-09-20 12:57:52', '2021-09-24 17:59:59'),
(4, 'Lourde categorie 1', 'troisieme categorie', '2021-09-24 18:00:16', '2021-09-24 18:00:32');

-- --------------------------------------------------------

--
-- Structure de la table `chat_tontine_messages`
--

CREATE TABLE `chat_tontine_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chat_tontine_messages`
--

INSERT INTO `chat_tontine_messages` (`id`, `id_tontine`, `id_menbre`, `message`, `created_at`, `updated_at`) VALUES
(1, 13, 2, 'dfgfjhfd', '2021-09-23 12:14:27', '2021-09-23 12:14:27'),
(2, 13, 4, 'what do you think about ça', '2021-09-23 12:19:45', '2021-09-23 12:19:45'),
(3, 13, 4, 'sdgdfsj', '2021-09-23 12:26:08', '2021-09-23 12:26:08'),
(4, 13, 4, 'sdhdfsj', '2021-09-23 12:26:59', '2021-09-23 12:26:59'),
(5, 13, 2, 'sdjhsdfhds', '2021-09-23 12:27:23', '2021-09-23 12:27:23'),
(6, 13, 2, 'uiweuew', '2021-09-23 12:28:03', '2021-09-23 12:28:03'),
(7, 12, 2, 'autre cote', '2021-09-23 12:29:53', '2021-09-23 12:29:53'),
(8, 12, 2, 'autre cote', '2021-09-23 12:40:04', '2021-09-23 12:40:04'),
(9, 13, 4, 'ice', '2021-09-23 12:40:13', '2021-09-23 12:40:13'),
(10, 13, 4, 'ice 2<br/>', '2021-09-23 12:40:38', '2021-09-23 12:40:38'),
(11, 13, 2, 'swagg 3', '2021-09-23 12:40:47', '2021-09-23 12:40:47'),
(12, 13, 4, 'avec le temps', '2021-09-23 12:46:01', '2021-09-23 12:46:01'),
(13, 13, 4, 'avec timestamps', '2021-09-23 12:46:52', '2021-09-23 12:46:52'),
(14, 13, 4, 'ds', '2021-09-23 12:54:22', '2021-09-23 12:54:22'),
(15, 13, 4, 'dssd', '2021-09-23 12:56:16', '2021-09-23 12:56:16'),
(16, 13, 4, 'dssd', '2021-09-23 12:57:03', '2021-09-23 12:57:03'),
(17, 13, 4, 'dfdssd', '2021-09-23 12:58:08', '2021-09-23 12:58:08'),
(18, 13, 2, 'un peu ice ou pas ?', '2021-09-23 13:58:07', '2021-09-23 13:58:07'),
(19, 13, 4, 'elegant j\'avoue', '2021-09-23 13:58:18', '2021-09-23 13:58:18'),
(20, 13, 4, 'dfgdg', '2021-09-23 14:52:00', '2021-09-23 14:52:00'),
(21, 13, 2, '&é\"\'(§', '2021-09-23 14:52:07', '2021-09-23 14:52:07'),
(22, 11, 4, 'salut', '2021-09-24 17:30:19', '2021-09-24 17:30:19'),
(23, 11, 4, 'Je teste ce chat afin de m\'assurer qu\'il fonctionne correctement.', '2021-09-24 17:32:28', '2021-09-24 17:32:28'),
(24, 16, 9, 'ghfgfgvgj', '2021-09-24 17:55:28', '2021-09-24 17:55:28'),
(25, 16, 2, 'hkf', '2021-09-24 17:55:43', '2021-09-24 17:55:43'),
(26, 18, 11, 'klk', '2021-09-24 22:57:59', '2021-09-24 22:57:59'),
(27, 19, 13, 'jjjjjjjj', '2021-09-25 11:28:48', '2021-09-25 11:28:48');

-- --------------------------------------------------------

--
-- Structure de la table `compte_menbres`
--

CREATE TABLE `compte_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `solde` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_menbres`
--

INSERT INTO `compte_menbres` (`id`, `id_menbre`, `solde`, `created_at`, `updated_at`) VALUES
(1, 4, 7425, '2021-09-15 17:03:15', '2021-09-22 10:49:28'),
(2, 6, 0, '2021-09-15 17:17:22', '2021-09-15 17:17:22'),
(3, 2, 145025, '2021-09-15 17:17:22', '2021-09-23 14:59:54'),
(4, 7, 0, '2021-09-15 18:20:06', '2021-09-15 18:20:06'),
(5, 8, 0, '2021-09-16 16:09:47', '2021-09-16 16:09:47'),
(6, 9, 0, '2021-09-24 17:36:14', '2021-09-24 17:36:14'),
(7, 10, 0, '2021-09-24 18:22:27', '2021-09-24 18:22:27'),
(8, 11, 990, '2021-09-24 22:01:29', '2021-09-24 22:43:45'),
(9, 12, 0, '2021-09-24 22:23:40', '2021-09-24 22:23:40'),
(10, 13, 1980, '2021-09-25 10:53:31', '2021-09-25 11:13:53'),
(11, 14, 0, '2021-09-25 11:03:49', '2021-09-25 11:03:49');

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_inviter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `menbre_qui_invite` bigint(20) UNSIGNED NOT NULL,
  `etat` enum('attente','acceptee','refusee','expiree') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `invitations`
--

INSERT INTO `invitations` (`id`, `email_inviter`, `id_tontine`, `menbre_qui_invite`, `etat`, `created_at`, `updated_at`) VALUES
(1, 'yvessantoz@gmail.com', 1, 2, 'acceptee', '2021-09-14 16:38:22', '2021-09-14 17:38:07'),
(2, 'adresse2@gmail.com', 1, 2, 'attente', '2021-09-14 16:38:22', '2021-09-14 16:38:22'),
(5, 'adresse1@gmail.com', 6, 2, 'expiree', '2021-09-15 10:05:20', '2021-09-15 10:39:41'),
(6, 'yvessantoz@gmail.com', 6, 2, 'acceptee', '2021-09-15 10:05:20', '2021-09-15 10:45:35'),
(7, '786santoz@gmail.com', 6, 2, 'expiree', '2021-09-15 10:05:20', '2021-09-15 10:39:41'),
(8, 'yvessantoz@gmail.com', 7, 4, 'expiree', '2021-09-15 14:36:21', '2021-09-21 14:28:26'),
(9, 'admin@gmail.com', 10, 2, 'acceptee', '2021-09-15 18:46:31', '2021-09-15 18:58:09'),
(10, 'admin@gmail.com', 11, 2, 'acceptee', '2021-09-21 14:32:28', '2021-09-21 14:35:27'),
(11, 'yvesladde@gmail.com', 11, 2, 'attente', '2021-09-21 14:32:28', '2021-09-21 14:32:28'),
(12, 'admin@gmail.com', 14, 2, 'expiree', '2021-09-23 14:54:56', '2021-09-23 14:55:16'),
(13, 'yvessantoz@gmail.com', 18, 11, 'attente', '2021-09-24 22:12:07', '2021-09-24 22:12:07'),
(14, 'onepersonne@gmail.com', 18, 11, 'acceptee', '2021-09-24 22:24:51', '2021-09-24 22:29:23'),
(15, 'w.houedanou@gmail.com', 19, 13, 'attente', '2021-09-25 10:59:10', '2021-09-25 10:59:10');

-- --------------------------------------------------------

--
-- Structure de la table `menbres`
--

CREATE TABLE `menbres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_complet` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` enum('attente','actif','suspendu') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'attente',
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code_de_confirmation` int(11) NOT NULL,
  `date_derniere_visite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbres`
--

INSERT INTO `menbres` (`id`, `nom_complet`, `telephone`, `email`, `mot_de_passe`, `etat`, `motif_intervention_admin`, `code_de_confirmation`, `date_derniere_visite`, `created_at`, `updated_at`) VALUES
(1, 'personne personne', '0707070707', NULL, '3852a674667c45dd847a12eebd5a7104', 'actif', NULL, 9789, '', '2021-09-14 11:13:10', '2021-09-14 11:13:10'),
(2, 'yves santoz', '55994041', 'yvessantoz@gmail.com', 'e3122587250f1537b2c4129c0031dcba', 'actif', NULL, 8769, '24-09-2021 17:58:37', '2021-09-14 11:17:42', '2021-09-24 17:58:37'),
(4, 'Element 21', '231212215', 'admin@gmail.com', '75d23af433e0cea4c0e45a56dba18b30', 'actif', NULL, 6768, '25-09-2021 11:11:59', '2021-09-14 17:39:53', '2021-09-25 11:11:59'),
(6, 'sdf dsds', '45365645', '32873@jds.sdkdj', 'd4f5d7b0bd382c1d6efcf4a4dc4e4b1a', 'actif', NULL, 2765, '', '2021-09-15 17:17:22', '2021-09-15 17:17:22'),
(7, 'yhuih gf', '435', 'ydty4@fhg.i', 'a1d5cd022eb7051293472062a73bf091', 'actif', NULL, 5765, '', '2021-09-15 18:20:03', '2021-09-15 18:20:03'),
(8, 'hjk', '754567689', 'hjh', '81dc9bdb52d04dc20036dbd8313ed055', 'actif', NULL, 9765, '', '2021-09-16 16:09:47', '2021-09-16 16:09:47'),
(9, 'diva sandrine', '0789588653', 'lagama.coulibaly@akassoh.ci', '1163581528792693f8471c9e6d75063b', 'actif', NULL, 3078, '24-09-2021 18:03:27', '2021-09-24 17:36:14', '2021-09-24 18:03:27'),
(11, 'un utilisateur', '0748485959', 'unutilisateur@gmail.com', 'e30fc3e88cbee6f3c76a4330d2a6ee23', 'actif', NULL, 8071, '24-09-2021 23:15:40', '2021-09-24 22:01:29', '2021-09-24 23:15:40'),
(12, 'one personne', '56424548', 'onepersonne@gmail.com', '68d04bc9a6e1da3ab764f2d127a52933', 'actif', NULL, 4531, '24-09-2021 23:20:19', '2021-09-24 22:23:40', '2021-09-24 23:20:19'),
(13, 'wilfried', '0758187266', 'huberson.kouakou@akassoh.ci', '65c1d8a54edb47acbd69f392ae53440b', 'actif', NULL, 9509, '25-09-2021 11:46:55', '2021-09-25 10:53:31', '2021-09-25 11:46:55'),
(14, 'Wilfried HOUEDANOU', '0709779787', 'whouedanou@gmail.com', '201dd75c02cc2cab01d63d752d364016', 'attente', NULL, 8002, NULL, '2021-09-25 11:03:49', '2021-09-25 11:03:49');

-- --------------------------------------------------------

--
-- Structure de la table `menbre_tontine`
--

CREATE TABLE `menbre_tontine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tontine_id` bigint(20) UNSIGNED NOT NULL,
  `menbre_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbre_tontine`
--

INSERT INTO `menbre_tontine` (`id`, `tontine_id`, `menbre_id`, `created_at`, `updated_at`) VALUES
(4, 6, 2, '2021-09-14 21:44:25', '2021-09-14 21:44:25'),
(5, 6, 4, '2021-09-14 21:46:39', '2021-09-14 21:46:39'),
(7, 7, 4, '2021-09-15 14:30:18', '2021-09-15 14:30:18'),
(8, 7, 2, '2021-09-15 14:36:48', '2021-09-15 14:36:48'),
(9, 8, 4, '2021-09-15 15:05:23', '2021-09-15 15:05:23'),
(10, 9, 7, '2021-09-15 18:21:08', '2021-09-15 18:21:08'),
(11, 10, 2, '2021-09-15 18:22:41', '2021-09-15 18:22:41'),
(12, 10, 4, '2021-09-15 18:58:09', '2021-09-15 18:58:09'),
(13, 11, 2, '2021-09-21 14:29:12', '2021-09-21 14:29:12'),
(14, 11, 4, '2021-09-21 14:35:27', '2021-09-21 14:35:27'),
(15, 12, 2, '2021-09-21 15:15:28', '2021-09-21 15:15:28'),
(16, 8, 2, '2021-09-22 09:46:35', '2021-09-22 09:46:35'),
(17, 13, 2, '2021-09-22 09:55:44', '2021-09-22 09:55:44'),
(23, 13, 4, '2021-09-22 10:15:49', '2021-09-22 10:15:49'),
(24, 14, 2, '2021-09-23 14:54:46', '2021-09-23 14:54:46'),
(25, 14, 4, '2021-09-23 14:55:16', '2021-09-23 14:55:16'),
(26, 15, 4, '2021-09-24 17:40:43', '2021-09-24 17:40:43'),
(27, 16, 2, '2021-09-24 17:47:31', '2021-09-24 17:47:31'),
(28, 16, 9, '2021-09-24 17:54:25', '2021-09-24 17:54:25'),
(29, 17, 2, '2021-09-24 17:59:08', '2021-09-24 17:59:08'),
(30, 18, 11, '2021-09-24 22:09:45', '2021-09-24 22:09:45'),
(31, 18, 12, '2021-09-24 22:29:23', '2021-09-24 22:29:23'),
(32, 19, 13, '2021-09-25 10:56:39', '2021-09-25 10:56:39'),
(33, 19, 4, '2021-09-25 11:11:16', '2021-09-25 11:11:16');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(8, '2021_09_14_102159_create_menbres_table', 2),
(9, '2021_09_14_133811_create_tontines_table', 3),
(10, '2021_09_14_160126_create_invitations_table', 4),
(13, '2021_09_14_174326_create_menbre_tontine_table', 5),
(16, '2021_09_15_110733_create_transactions_table', 6),
(17, '2021_09_15_112553_create_caisse_tontines_table', 6),
(18, '2021_09_15_164113_create_compte_menbres_table', 7),
(19, '2021_09_15_164217_create_cahier_compte_tontines_table', 7),
(29, '2021_09_16_111919_create_waricrowds_table', 8),
(30, '2021_09_16_112237_create_transaction_waricrowds_table', 8),
(31, '2021_09_16_112255_create_caisse_waricrowds_table', 8),
(32, '2021_09_16_145804_create_waricrowd_menbres_table', 9),
(33, '2021_09_20_110724_create_sms_contenu_notifications_table', 10),
(35, '2021_09_20_120009_create_statistique_frequentations_table', 11),
(37, '2021_09_20_124438_create_categorie_waricrowds_table', 12),
(38, '2021_09_23_120824_create_chat_tontine_messages_table', 13);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('1O9sk3ktD347vJQxiCTAyohBlhZWJuY74Ofn1N4t', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVB3ZWtJYm1FZzRlZEVXM1REZ3VNUGp0OE5JVjJTbmE0Q1ZKU1Z5NyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632747331),
('35Dgsa5FnuLq6Rc6p2GlDaqRaxCvFpzmEKSaEw6m', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUpNclQyWXhIZEpadmpHUGJwVWZ0WWtHWFdZT3E0SjZYV09DM0tnTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755621),
('7WmiRrQSS6ckEWB07jFLVziP6kMqefnRvc6G1hCa', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWRMTGxQYndNRWF0WkJubU1zcGtVa1hFSnZXNzZ3SnVSbHoxa1VDNSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632756268),
('8EXYTN5qdP27eFdtz4sVQyoeW3af3dIF35l6WPEX', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUndRZWsyY1QyeXQ0eWhnTnBUQklybUJtdFdaNWM2dUQ1S3o3WnZWTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632753986),
('A8ghuMhD6wgG6hO2Iyi9RhoP304vDz3PAmX0SbhT', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYXpZY2Jzb0c1ZWd1QmdFaEdCYk1DYmJ0ZTNCbnFDSWVSQ3BSeTRjWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755836),
('ahsYIZJkD672Lrp7hxf0XaVccsK6DCVVw98hSKS1', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQXRjTTVsejJ3bzlWYW5NU3Q0YWRLRjhmYXQ3Y1ZnZGtETXFhWXVBaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632753877),
('DHGCIOQ1x928aP1iFHg5zy74apwR0inMTcW12qp5', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMXNDeE84aEVqbERqclFZeWlSa3RxVWRNNm1SQkQ1ajJwSHBLalR0USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632754131),
('gQkop2nwaqClJ3MnUGcXttvnSWXLmtnwfM0Q7r38', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejlJMko0TU5oeEthMkNGSkJ4bUxNekw1MmxIR0N6SnhyY2FCZVpiVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632756313),
('hkeymfPwvnR3nDd4StNqbb7RySUAmBpp19e60gFw', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHN3YlVPNk1OY1N5TUR6eDJkTlJ3MHk3aEFXMEU2NkczNGJXbzRZOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632747467),
('I0O5H852fkhaUr4Q5sPsXQlNgZGZCdSFjyx3nJi5', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnlwQXZISnJ1MUlIVW50WXZvQWVEbzlSdzFnNmN0eUl6VEJLM3lUUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755329),
('I7CSfRSwkoXSyxaCcrqHqKFYymxSxBMLTxloLtfm', NULL, '160.155.231.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUJEaEN5ZmczNUdydGlaN3VoR3lkNkpyeTNFTnA4T3Y0ZUtKZHdiRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjI1OiJtZW5icmVfd2FyaWJhbmFfY29ubmVjdGVyIjthOjI6e3M6MjoiaWQiO2k6MTE7czoxMToibm9tX2NvbXBsZXQiO3M6MTQ6InVuIHV0aWxpc2F0ZXVyIjt9fQ==', 1632748064),
('iD5xpsnjBkCTxXivcCK5OmvivlJUpWDCizBMyzeV', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTG12SmN6ZWttNVY3Uk1zQ1ZGV3pUUExxc3Z1c05uNlBtdzZOWmc0WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632758783),
('idi5P6lwr43t3N8uMeVrqRSlc5TSEgNPSezbTcDr', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2hzRVJIZ0NUREpJSGx0RldoUHF5Qk9BeWt0Sk44NDRmNk1mTm16WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755892),
('Imbu2brDccZcCSYPPmJGPwF87MiUsO0cWBcmvh1p', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYndMclRkZFdnY0xuOTRsZHJwSmphRnpQU3lmOGNXODFHM3FQMnVHVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755406),
('k5h0uAXyT7Ycd18HU7Hf3cLYlZmqrWgpTP8GF1H1', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSDgwVWt4MnVOdXZMOFhBbmN3Q2d5SUtEMzdJMFl6UmJYd3FWWjF2MSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632756051),
('lQjdowVCJEzB5IYQCzyFdminIeDdoQbF1nqLckOR', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUJXUktnem1ua3RWdWdBVGdjSE9DYnVYVzFlUG9UZ21ZeUhBS0k0dCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755746),
('mfxrF1i50P26CayC4tvlhPvEMKVhAWt0n1PyPOt9', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYTVqTHV2anlSSGZHRzJRYjNqclNVNmNQNVdlRW41YlF0clN3NU5aOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632756523),
('mynhdd4FehQ0tNjeeXJa0poXZhGz6TvIdogl4uLC', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1VkY0NtTFcyUFcxTDZJb3RkQjZlOXBONDFwZ0pTQWowMUQ4V1VBbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632754200),
('OnyX0n8SEuHhUZ14TWrLL9WwKeSEwqQ7GLLyl3VA', NULL, '160.155.231.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZUZ2RUFyREw0aFlIOUYwdXhUM2dJNGhPRXlkbnVvZnVKY1BVNURsRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjI6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXovZXNwYWNlLW1lbmJyZS9kZXRhaWxzLXRvbnRpbmVzLzE0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoyNToibWVuYnJlX3dhcmliYW5hX2Nvbm5lY3RlciI7YToyOntzOjI6ImlkIjtpOjExO3M6MTE6Im5vbV9jb21wbGV0IjtzOjE0OiJ1biB1dGlsaXNhdGV1ciI7fX0=', 1632760496),
('s01SbTPjiF7sywZMYCFVlIksr8wZrLCP1jilYmhM', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMVIyZGN1azRkYTFVOGd3Y2w3cVNBNjYyY01CR201WE53eGR1UVNuZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632755559),
('wssNhikR5tQwCgmN0IqqIMz45vcb5Hek6zlOwvkd', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSE1BV3BMUERYR2UxZ3Yzd2pITkMxMmJLWmRkMVpNSFA0TWNYY2IwRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632754377),
('Wzx6NJk3yr3Y1DhBoi4dginSkK4JWsS8bilBDkxd', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMkxHd1hsSkJDc2hDbXJSOTdkNGNGdE9Qc3dEOTcxamxMcEVGR3F2SCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632756391),
('ysct6SsDjsliG0syOpOQodcgUQSmxreLHtWd7aX8', NULL, '145.239.141.54', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDN2T3lPVE1ZVUFncnVNRGtrbThDQU5Xd3B1RnZoV3RhdGNwVFFoRCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd2FyaWJhbmEuamViZXJnZS54eXoiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1632753131);

-- --------------------------------------------------------

--
-- Structure de la table `sms_contenu_notifications`
--

CREATE TABLE `sms_contenu_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `confirmation_compte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `retard_paiement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sms_contenu_notifications`
--

INSERT INTO `sms_contenu_notifications` (`id`, `confirmation_compte`, `retard_paiement`, `created_at`, `updated_at`) VALUES
(1, 'Bienvenu(e) sur waribana, votre code de confirmation est le suivant : $code$', 'Bonjour $nom_complet$, Vous avez un paiement de $montant_paiement$ en retard sur la tontine $nom_tontine$', '2021-09-20 11:33:17', '2021-09-21 15:20:20');

-- --------------------------------------------------------

--
-- Structure de la table `statistique_frequentations`
--

CREATE TABLE `statistique_frequentations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mois_annee` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `visiteur` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statistique_frequentations`
--

INSERT INTO `statistique_frequentations` (`id`, `slug`, `mois_annee`, `visiteur`, `created_at`, `updated_at`) VALUES
(1, '08/2021', '08/2021', 3, '2021-09-20 12:35:59', '2021-09-20 12:36:41'),
(3, '09/2021', '09/2021', 148, '2021-09-20 12:37:27', '2021-09-27 16:06:23');

-- --------------------------------------------------------

--
-- Structure de la table `tontines`
--

CREATE TABLE `tontines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `identifiant_adhesion` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequence_depot_en_jours` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_participant` int(11) NOT NULL,
  `etat` enum('constitution','prete','ouverte','fermee','suspendue') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tontines`
--

INSERT INTO `tontines` (`id`, `identifiant_adhesion`, `titre`, `montant`, `frequence_depot_en_jours`, `nombre_participant`, `etat`, `id_menbre`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(6, 3656, 'dfsd', '720000', '21', 2, 'fermee', 2, '', '2021-09-14 21:46:39', '2021-09-17 12:23:12'),
(7, 7865, 'Prommotion !!!', '15000', '5', 2, 'fermee', 4, '', '2021-09-15 14:30:18', '2021-09-15 14:49:44'),
(8, 987, 'Prommotion !!!', '500', '3', 2, 'constitution', 4, '', '2021-09-15 15:05:23', '2021-09-15 15:08:21'),
(9, 2734, 'tontine 1', '600', '7', 2, 'ouverte', 7, '', '2021-09-15 18:21:08', '2021-09-17 16:23:42'),
(10, 9876, 'dfsd 4', '500', '7', 2, 'fermee', 2, '', '2021-09-15 18:22:41', '2021-09-15 19:03:22'),
(11, 3546, 'TOTINE ICE', '78500', '9', 2, 'ouverte', 2, '', '2021-09-21 14:29:12', '2021-09-21 14:40:22'),
(12, 976, 'Kia 12', '78994', '4', 2, 'constitution', 2, '', '2021-09-21 15:15:28', '2021-09-21 15:15:28'),
(13, 0, 'un  lourd article lorem ipsum un lourd article lorem urd article lore', '3245', '14', 2, 'ouverte', 2, NULL, '2021-09-22 09:55:44', '2021-09-22 12:16:02'),
(14, 3706, 'RAPPORT CGES', '70000', '7', 2, 'ouverte', 2, NULL, '2021-09-23 14:54:46', '2021-09-23 14:55:42'),
(15, 536, 'Tontine test', '50000', '30', 2, 'constitution', 4, NULL, '2021-09-24 17:40:43', '2021-09-24 17:40:43'),
(16, 212, 'tortor vitae faucibus placerat', '500', '1', 2, 'constitution', 2, NULL, '2021-09-24 17:47:31', '2021-09-24 17:54:50'),
(17, 2362, 'cartable 1', '5000', '7', 2, 'constitution', 2, NULL, '2021-09-24 17:59:08', '2021-09-24 17:59:08'),
(18, 3461, 'Une tontine elegante', '500', '7', 2, 'ouverte', 11, NULL, '2021-09-24 22:09:45', '2021-09-24 22:39:10'),
(19, 2337, 'Vente d\'habits', '1000', '7', 2, 'ouverte', 13, NULL, '2021-09-25 10:56:39', '2021-09-25 11:12:49');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_menbre_qui_prend` bigint(20) UNSIGNED NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transactions`
--

INSERT INTO `transactions` (`id`, `id_tontine`, `id_menbre`, `montant`, `statut`, `id_menbre_qui_prend`, `trans_id`, `created_at`, `updated_at`) VALUES
(2, 6, 2, 720000, NULL, 2, NULL, '2021-09-15 13:25:38', '2021-09-15 13:25:38'),
(5, 7, 4, 15000, NULL, 4, NULL, '2021-09-15 14:40:08', '2021-09-15 14:40:08'),
(9, 7, 2, 15000, NULL, 4, NULL, '2021-09-15 14:49:17', '2021-09-15 14:49:17'),
(10, 7, 2, 15000, NULL, 2, NULL, '2021-09-15 14:49:26', '2021-09-15 14:49:26'),
(11, 7, 4, 15000, NULL, 2, NULL, '2021-09-15 14:49:44', '2021-09-15 14:49:44'),
(18, 6, 4, 720000, NULL, 4, NULL, '2021-09-15 17:02:02', '2021-09-15 17:02:02'),
(19, 6, 2, 720000, NULL, 4, NULL, '2021-09-15 17:02:15', '2021-09-15 17:02:15'),
(20, 6, 2, 720000, NULL, 4, NULL, '2021-09-15 17:03:15', '2021-09-15 17:03:15'),
(21, 10, 2, 500, NULL, 2, NULL, '2021-09-15 18:59:51', '2021-09-15 18:59:51'),
(22, 10, 4, 500, NULL, 2, NULL, '2021-09-15 19:01:52', '2021-09-15 19:01:52'),
(23, 10, 4, 500, NULL, 4, NULL, '2021-09-15 19:02:18', '2021-09-15 19:02:18'),
(24, 10, 2, 500, NULL, 4, NULL, '2021-09-15 19:03:20', '2021-09-15 19:03:20'),
(38, 11, 2, 78500, NULL, 2, NULL, '2021-09-21 16:38:47', '2021-09-21 16:38:47'),
(48, 13, 2, 3245, NULL, 2, NULL, '2021-09-22 14:21:26', '2021-09-22 14:21:26'),
(49, 14, 2, 70000, NULL, 2, NULL, '2021-09-23 14:57:06', '2021-09-23 14:57:06'),
(50, 14, 4, 70000, 'REFUSED', 2, NULL, '2021-09-23 14:59:54', '2021-09-24 12:13:43'),
(54, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 12:58:59', '2021-09-24 12:58:59'),
(55, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 13:04:29', '2021-09-24 13:04:29'),
(57, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 13:56:01', '2021-09-24 13:56:01'),
(58, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 16:35:48', '2021-09-24 16:35:48'),
(59, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 16:36:15', '2021-09-24 16:36:15'),
(60, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 16:36:49', '2021-09-24 16:36:49'),
(61, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:06:18', '2021-09-24 17:06:18'),
(62, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:07:38', '2021-09-24 17:07:38'),
(63, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:08:35', '2021-09-24 17:08:35'),
(64, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:09:44', '2021-09-24 17:09:44'),
(65, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:10:57', '2021-09-24 17:10:57'),
(66, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:13:02', '2021-09-24 17:13:02'),
(67, 14, 2, 70000, 'REFUSED', 4, NULL, '2021-09-24 17:45:56', '2021-09-24 17:45:56'),
(68, 14, 2, 70000, NULL, 4, NULL, '2021-09-24 18:07:11', '2021-09-24 18:07:11'),
(69, 14, 2, 70000, NULL, 4, NULL, '2021-09-24 18:07:17', '2021-09-24 18:07:17'),
(70, 18, 11, 500, NULL, 11, NULL, '2021-09-24 22:41:09', '2021-09-24 22:41:09'),
(71, 18, 12, 500, NULL, 11, NULL, '2021-09-24 22:43:44', '2021-09-24 22:43:44'),
(73, 19, 13, 1000, NULL, 13, NULL, '2021-09-25 11:13:04', '2021-09-25 11:13:04'),
(81, 19, 4, 1000, 'ACCEPTED', 13, NULL, '2021-09-25 11:13:04', '2021-09-25 11:13:04'),
(82, 90, 95, 400, NULL, 98, NULL, '2021-09-27 10:23:34', '2021-09-27 10:23:34'),
(83, 90, 95, 400, NULL, 98, NULL, '2021-09-27 10:24:16', '2021-09-27 10:24:16'),
(84, 90, 95, 400, NULL, 98, NULL, '2021-09-27 10:36:25', '2021-09-27 10:36:25'),
(85, 890, 220, 5000, 'REFUSED', 902, NULL, '2021-09-27 11:03:59', '2021-09-27 11:03:59'),
(86, 90, 95, 400, NULL, 98, NULL, '2021-09-27 11:31:33', '2021-09-27 11:31:33'),
(87, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:06:26', '2021-09-27 12:06:26'),
(88, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:07:12', '2021-09-27 12:07:12'),
(93, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:14:19', '2021-09-27 12:14:19'),
(94, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:15:38', '2021-09-27 12:15:38'),
(95, 1190, 1195, 11400, NULL, 1198, NULL, '2021-09-27 12:55:22', '2021-09-27 12:55:22'),
(96, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:55:24', '2021-09-27 12:55:24'),
(97, 1190, 1195, 11400, NULL, 1198, NULL, '2021-09-27 12:55:43', '2021-09-27 12:55:43'),
(98, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:57:22', '2021-09-27 12:57:22'),
(99, 1190, 1195, 11400, NULL, 1198, NULL, '2021-09-27 12:57:58', '2021-09-27 12:57:58'),
(100, 14, 11, 70000, 'REFUSED', 4, NULL, '2021-09-27 12:59:21', '2021-09-27 12:59:21'),
(108, 5995, 5995, 696, NULL, 8008, '$trans_id', '2021-09-27 15:18:21', '2021-09-27 15:18:21'),
(109, 5995, 5995, 696, NULL, 8008, '$request->input()', '2021-09-27 15:25:21', '2021-09-27 15:25:21'),
(110, 5995, 5995, 696, NULL, 8008, '{\"cpm_site_id\":\"750304\",\"cpm_trans_id\":\"waribana-transaction-20210927152628\",\"cpm_trans_date\":\"2021-09-27 15:26:28\",\"cpm_amount\":\"70000\",\"cpm_currency\":\"XOF\",\"signature\":\"46d109cd37790fd51e0b08b56bccea1bb429b62ccf6ef66fbb3c548d0890236b24075\",\"payment_method\":\"MOMO\",\"cel_phone_num\":\"0555994041\",\"cpm_phone_prefixe\":\"225\",\"cpm_language\":\"fr\",\"cpm_version\":\"V1\",\"cpm_payment_config\":\"SINGLE\",\"cpm_page_action\":\"PAYMENT\",\"cpm_custom\":\"id_menbre=11&id_tontine=14&id_menbre_qui_prend=4\"}', '2021-09-27 15:26:38', '2021-09-27 15:26:38'),
(111, 5995, 5995, 696, NULL, 8008, '\"waribana-transaction-20210927152840\"', '2021-09-27 15:28:57', '2021-09-27 15:28:57'),
(112, 5995, 5995, 696, NULL, 8008, '163275877720210927160617', '2021-09-27 16:06:35', '2021-09-27 16:06:35');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_waricrowds`
--

CREATE TABLE `transaction_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_waricrowds`
--

INSERT INTO `transaction_waricrowds` (`id`, `id_menbre`, `id_waricrowd`, `montant`, `statut`, `created_at`, `updated_at`) VALUES
(2, 2, 9, 76000, NULL, '2021-09-16 14:43:29', '2021-09-16 14:43:29'),
(3, 2, 9, 76000, NULL, '2021-09-16 14:46:42', '2021-09-16 14:46:42'),
(4, 2, 9, 76000, NULL, '2021-09-16 14:47:55', '2021-09-16 14:47:55'),
(5, 2, 9, 32323, NULL, '2021-09-16 15:05:19', '2021-09-16 15:05:19'),
(6, 2, 9, 32323, NULL, '2021-09-16 15:07:42', '2021-09-16 15:07:42'),
(7, 2, 9, 670000, NULL, '2021-09-16 16:56:38', '2021-09-16 16:56:38'),
(8, 2, 9, 234432, NULL, '2021-09-16 17:46:45', '2021-09-16 17:46:45'),
(9, 2, 10, 231223, NULL, '2021-09-16 17:55:45', '2021-09-16 17:55:45'),
(10, 2, 9, 57760, NULL, '2021-09-17 16:12:45', '2021-09-17 16:12:45'),
(11, 2, 9, 11000, NULL, '2021-09-17 16:13:19', '2021-09-17 16:13:19'),
(12, 4, 11, 150000, NULL, '2021-09-17 17:47:06', '2021-09-17 17:47:06'),
(13, 2, 10, 80000, NULL, '2021-09-22 12:27:59', '2021-09-22 12:27:59'),
(14, 2, 10, 40000, NULL, '2021-09-22 14:22:07', '2021-09-22 14:22:07'),
(15, 2, 10, 40000, NULL, '2021-09-22 14:22:23', '2021-09-22 14:22:23'),
(16, 2, 10, 10000, NULL, '2021-09-24 09:26:21', '2021-09-24 09:26:21'),
(17, 2, 10, 10000, NULL, '2021-09-24 09:34:11', '2021-09-24 09:34:11'),
(18, 2, 10, 10000, NULL, '2021-09-24 09:43:32', '2021-09-24 09:43:32'),
(19, 2, 10, 10000, NULL, '2021-09-24 09:44:08', '2021-09-24 09:44:08'),
(20, 2, 11, 10000, 'REFUSED', '2021-09-24 16:16:35', '2021-09-24 16:16:35'),
(21, 2, 10, 10000, 'REFUSED', '2021-09-24 16:34:15', '2021-09-24 16:34:15'),
(22, 2, 10, 40000, 'REFUSED', '2021-09-24 16:38:12', '2021-09-24 16:38:12'),
(23, 2, 10, 10000, 'REFUSED', '2021-09-24 16:49:14', '2021-09-24 16:49:14'),
(24, 2, 10, 10000, 'REFUSED', '2021-09-24 16:50:18', '2021-09-24 16:50:18'),
(25, 2, 10, 10000, 'REFUSED', '2021-09-24 16:52:24', '2021-09-24 16:52:24'),
(26, 2, 10, 10000, 'REFUSED', '2021-09-24 16:54:02', '2021-09-24 16:54:02'),
(27, 2, 10, 10000, 'REFUSED', '2021-09-24 16:57:35', '2021-09-24 16:57:35'),
(28, 2, 10, 10000, 'REFUSED', '2021-09-24 16:58:43', '2021-09-24 16:58:43'),
(29, 2, 10, 10000, 'REFUSED', '2021-09-24 16:59:40', '2021-09-24 16:59:40'),
(30, 2, 10, 10000, 'REFUSED', '2021-09-24 17:00:11', '2021-09-24 17:00:11'),
(31, 2, 10, 10000, 'REFUSED', '2021-09-24 17:00:34', '2021-09-24 17:00:34'),
(32, 2, 10, 10000, 'REFUSED', '2021-09-24 17:01:57', '2021-09-24 17:01:57'),
(33, 2, 10, 10000, 'REFUSED', '2021-09-24 17:02:20', '2021-09-24 17:02:20'),
(34, 2, 10, 10000, 'REFUSED', '2021-09-24 17:03:14', '2021-09-24 17:03:14'),
(35, 2, 10, 10000, 'REFUSED', '2021-09-24 17:31:33', '2021-09-24 17:31:33'),
(36, 2, 10, 10000, 'REFUSED', '2021-09-24 17:35:23', '2021-09-24 17:35:23'),
(37, 2, 10, 100, 'REFUSED', '2021-09-24 17:44:48', '2021-09-24 17:44:48'),
(38, 12, 16, 100, 'REFUSED', '2021-09-24 23:27:43', '2021-09-24 23:27:43'),
(39, 13, 17, 100, 'ACCEPTED', '2021-09-25 11:23:02', '2021-09-25 11:23:02');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$FE6/Jk//Gjr6c3uKhzA5PuLt5D9bsUZRZAlK/wXjedC.5SX0Q6SXu', NULL, NULL, 'NGPhSM83H6641KFKKnNOEiBND0FAwMFq82HtnCgY1Kj00sFB8l5kqHVGhSLz', NULL, NULL, '2021-09-17 10:52:15', '2021-09-17 10:52:15');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowds`
--

CREATE TABLE `waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowds`
--

INSERT INTO `waricrowds` (`id`, `id_categorie`, `id_menbre`, `titre`, `description_courte`, `description_complete`, `montant_objectif`, `lien_pitch_video`, `image_illustration`, `etat`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(9, '3', 2, 'Un projet Ice', 'All controllers should extend the base controller class.', 'All controllers should extend the base controller class.All controllers should extend the base controller class.\r\n\r\n-All controllers should extend the base controller class.All controllers should extend the base controller class.\r\n\r\n-All controllers should extend the base controller class.All controllers should extend the base controller class.\r\n\r\n-All controllers should extend the base controller class.All controllers should extend the base controller class.', 4500000, 'https://www.youtube.com/embed/Z-QK1xS9ALU', 'images/waricrowd/Capture2.PNG', 'valider', NULL, '2021-09-16 13:27:28', '2021-09-17 16:12:02'),
(10, '1', 2, 'djhjkjh klkjklj jklkjklj', 'jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk', 'jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  \r\njklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  \r\njklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  \r\n\r\n\r\n\r\njklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  \r\n\r\njklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk  \r\njklkhklhhjlk jklkhklhhjlk  jklkhklhhjlk jklkhklhhjlk', 678678, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-09-16 16:47:07', '2021-09-20 13:50:44'),
(11, '3', 2, 'waricrowd 2', 'description courte', 'complete', 5700000, 'https://www.youtube.com/embed/JfDO44x4qQ4', 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-09-17 17:44:29', '2021-09-17 17:44:29'),
(12, '3', 2, 'un  lourd article lorem ipsum un lourd article lorem urd article lore', '23423', '234342', 3423, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-09-20 13:29:15', '2021-09-20 13:29:15'),
(13, '3', 2, 'Duplex sicogi', 'sdfsd', 'sdfsd', 4346565, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-09-20 13:30:09', '2021-09-20 13:44:16'),
(14, '3', 2, 'un  lourd article lorem ipsum un lourd article lorem urd article lore', 'sdfsd', 'sdfdfs', 23432432, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-09-20 13:46:58', '2021-09-20 13:46:58'),
(15, '1', 4, 'Waricrowd test', 'test', 'test', 390000, NULL, 'images/waricrowd/home5.jpeg', 'attente', NULL, '2021-09-24 17:58:52', '2021-09-24 17:58:52'),
(16, '3', 11, 'waricrowd 2', 'lkds', 'dslkdsk', 150000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-09-24 23:16:39', '2021-09-24 23:24:24'),
(17, '3', 13, 'Aide projet', 'Aide projetAide projetAide projetAide projetAide projetAide projetAide projetAide projet', 'Aide projetAide projetAide projetAide projetAide projetAide projetAide projetAide projetAide projet', 2000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', 'Top', '2021-09-25 11:16:20', '2021-09-25 11:18:23');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowd_menbres`
--

CREATE TABLE `waricrowd_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menbre_id` bigint(20) UNSIGNED NOT NULL,
  `waricrowd_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowd_menbres`
--

INSERT INTO `waricrowd_menbres` (`id`, `menbre_id`, `waricrowd_id`, `created_at`, `updated_at`) VALUES
(1, 2, 9, '2021-09-16 15:07:42', '2021-09-16 15:07:42'),
(2, 2, 10, '2021-09-16 17:55:45', '2021-09-16 17:55:45'),
(3, 4, 11, '2021-09-17 17:47:06', '2021-09-17 17:47:06'),
(4, 13, 17, '2021-09-25 11:23:02', '2021-09-25 11:23:02');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cahier_compte_tontines`
--
ALTER TABLE `cahier_compte_tontines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisse_tontines`
--
ALTER TABLE `caisse_tontines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `caisse_waricrowds`
--
ALTER TABLE `caisse_waricrowds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_waricrowds`
--
ALTER TABLE `categorie_waricrowds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie_waricrowds_slug_unique` (`slug`),
  ADD UNIQUE KEY `categorie_waricrowds_titre_unique` (`titre`);

--
-- Index pour la table `chat_tontine_messages`
--
ALTER TABLE `chat_tontine_messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compte_menbres`
--
ALTER TABLE `compte_menbres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `invitations`
--
ALTER TABLE `invitations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `menbres`
--
ALTER TABLE `menbres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menbres_telephone_unique` (`telephone`),
  ADD UNIQUE KEY `menbres_email_unique` (`email`);

--
-- Index pour la table `menbre_tontine`
--
ALTER TABLE `menbre_tontine`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `sms_contenu_notifications`
--
ALTER TABLE `sms_contenu_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statistique_frequentations`
--
ALTER TABLE `statistique_frequentations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `statistique_frequentations_slug_unique` (`slug`),
  ADD UNIQUE KEY `statistique_frequentations_mois_annee_unique` (`mois_annee`);

--
-- Index pour la table `tontines`
--
ALTER TABLE `tontines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transaction_waricrowds`
--
ALTER TABLE `transaction_waricrowds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Index pour la table `waricrowds`
--
ALTER TABLE `waricrowds`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `waricrowd_menbres`
--
ALTER TABLE `waricrowd_menbres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cahier_compte_tontines`
--
ALTER TABLE `cahier_compte_tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `caisse_tontines`
--
ALTER TABLE `caisse_tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `caisse_waricrowds`
--
ALTER TABLE `caisse_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `categorie_waricrowds`
--
ALTER TABLE `categorie_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `chat_tontine_messages`
--
ALTER TABLE `chat_tontine_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `compte_menbres`
--
ALTER TABLE `compte_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `menbres`
--
ALTER TABLE `menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `menbre_tontine`
--
ALTER TABLE `menbre_tontine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sms_contenu_notifications`
--
ALTER TABLE `sms_contenu_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `statistique_frequentations`
--
ALTER TABLE `statistique_frequentations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `tontines`
--
ALTER TABLE `tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT pour la table `transaction_waricrowds`
--
ALTER TABLE `transaction_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `waricrowds`
--
ALTER TABLE `waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `waricrowd_menbres`
--
ALTER TABLE `waricrowd_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
