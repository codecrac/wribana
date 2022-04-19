-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 19 avr. 2022 à 19:14
-- Version du serveur :  10.3.34-MariaDB-cll-lve
-- Version de PHP : 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `waribana_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `cahier_compte_tontines`
--

CREATE TABLE `cahier_compte_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` float NOT NULL,
  `index_ouverture` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cahier_compte_tontines`
--

INSERT INTO `cahier_compte_tontines` (`id`, `id_tontine`, `id_menbre`, `montant`, `index_ouverture`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 336.6, 1, '2021-10-08 15:58:30', '2021-10-08 15:36:36'),
(2, 1, 1, 336.6, 1, '2021-10-08 15:58:33', '2021-10-08 15:36:36'),
(3, 1, 19, 336.6, 1, '2021-10-26 17:30:16', '2021-10-08 16:51:45'),
(4, 22, 15, 63, 1, '2021-10-27 10:08:48', '2021-10-27 10:08:48'),
(5, 22, 19, 63, 1, '2021-10-27 10:23:20', '2021-10-27 10:23:20'),
(6, 49, 4, 49.5, 1, '2022-02-02 09:16:37', '2022-02-02 09:16:37'),
(7, 49, 8, 49.5, 1, '2022-02-02 09:18:36', '2022-02-02 09:18:36'),
(8, 50, 8, 49, 1, '2022-02-02 09:30:28', '2022-02-02 09:30:28'),
(9, 50, 4, 49, 1, '2022-02-02 09:34:50', '2022-02-02 09:34:50'),
(10, 51, 8, 49, 1, '2022-02-02 11:41:59', '2022-02-02 11:41:59'),
(11, 51, 4, 49, 1, '2022-02-20 13:39:02', '2022-02-20 13:39:02');

-- --------------------------------------------------------

--
-- Structure de la table `cahier_retrait_solde_menbres`
--

CREATE TABLE `cahier_retrait_solde_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant_retirer` int(11) NOT NULL,
  `solde_avant` int(11) NOT NULL,
  `solde_apres` int(11) NOT NULL,
  `statut` enum('REFUSED','ACCEPTED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cahier_retrait_solde_menbres`
--

INSERT INTO `cahier_retrait_solde_menbres` (`id`, `id_menbre`, `montant_retirer`, `solde_avant`, `solde_apres`, `statut`, `created_at`, `updated_at`) VALUES
(2, 2, 500, 1500, 1000, 'ACCEPTED', '2021-10-08 15:02:40', '2021-10-08 15:02:40'),
(3, 15, 500, 1500, 1000, 'ACCEPTED', '2021-10-08 15:02:40', '2021-10-08 15:02:40'),
(4, 1, 200, 8693, 8493, 'ACCEPTED', '2022-02-09 16:21:49', '2022-02-09 16:21:49'),
(5, 1, 200, 8493, 8293, 'ACCEPTED', '2022-02-09 16:25:35', '2022-02-09 16:25:35'),
(6, 15, 200, 1938, 1738, 'ACCEPTED', '2022-02-09 16:28:59', '2022-02-09 16:28:59'),
(7, 1, 200, 8293, 8093, 'ACCEPTED', '2022-02-09 16:31:30', '2022-02-09 16:31:30'),
(8, 15, 200, 1738, 1538, 'ACCEPTED', '2022-02-09 16:33:43', '2022-02-09 16:33:43'),
(9, 15, 250, 1538, 1288, 'ACCEPTED', '2022-02-09 21:52:39', '2022-02-09 21:52:39'),
(10, 15, 400, 1288, 888, 'ACCEPTED', '2022-02-10 07:56:43', '2022-02-10 07:56:43'),
(11, 15, 200, 888, 688, 'ACCEPTED', '2022-02-10 09:12:58', '2022-02-10 09:12:58'),
(12, 19, 200, 142470, 142270, 'ACCEPTED', '2022-02-10 10:24:02', '2022-02-10 10:24:02'),
(13, 7, 200, 21510, 21310, 'ACCEPTED', '2022-02-10 10:30:29', '2022-02-10 10:30:29'),
(14, 3, 200, 420, 220, 'ACCEPTED', '2022-02-10 11:50:49', '2022-02-10 11:50:49'),
(15, 8, 200, 318, 118, 'ACCEPTED', '2022-02-10 14:11:45', '2022-02-10 14:11:45'),
(16, 7, 200, 21310, 21110, 'ACCEPTED', '2022-02-10 18:21:08', '2022-02-10 18:21:08'),
(17, 15, 200, 688, 488, 'ACCEPTED', '2022-02-17 16:25:34', '2022-02-17 16:25:34'),
(18, 7, 200, 20110, 19910, 'ACCEPTED', '2022-02-21 19:56:52', '2022-02-21 19:56:52');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_tontines`
--

CREATE TABLE `caisse_tontines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `montant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `montant_objectif` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frais_de_gestion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_a_verser` float NOT NULL,
  `id_menbre_qui_prend` int(11) NOT NULL,
  `index_menbre_qui_prend` int(11) NOT NULL DEFAULT 0,
  `index_ouverture` int(11) NOT NULL DEFAULT 1,
  `prochaine_date_encaissement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_tontines`
--

INSERT INTO `caisse_tontines` (`id`, `id_tontine`, `montant`, `montant_objectif`, `frais_de_gestion`, `montant_a_verser`, `id_menbre_qui_prend`, `index_menbre_qui_prend`, `index_ouverture`, `prochaine_date_encaissement`, `created_at`, `updated_at`) VALUES
(1, 1, '0', '340', '1', 336.6, 2, 1, 2, '21-10-2021', '2021-10-07 14:16:36', '2021-10-08 16:51:45'),
(2, 3, '0', '40000', '400', 39600, 4, 0, 1, '28-10-2021', '2021-10-13 11:17:53', '2021-10-13 11:17:53'),
(3, 8, '0', '300000', '3000', 297000, 3, 0, 1, '15-11-2021', '2021-10-16 19:58:45', '2021-10-16 19:58:45'),
(4, 18, '500', '1000', '10', 990, 15, 0, 1, '02-11-2021', '2021-10-19 14:48:18', '2021-10-23 19:02:25'),
(6, 23, '0', '50000', '500', 49500, 4, 0, 1, '05-11-2021', '2021-10-26 19:30:07', '2021-10-26 19:30:07'),
(7, 22, '0', '64', '1', 63, 19, 1, 1, '31-10-2021', '2021-10-27 09:33:19', '2021-10-27 10:23:22'),
(8, 32, '0', '60000', '600', 59400, 4, 0, 3, '10-11-2021', '2021-10-31 19:56:22', '2021-10-31 19:56:48'),
(9, 28, '100', '200', '2', 198, 15, 0, 2, '09-11-2021', '2021-11-02 12:28:20', '2021-11-18 12:43:21'),
(10, 48, '50', '100', '1', 99, 4, 0, 1, '27-01-2022', '2022-01-26 12:42:07', '2022-01-26 12:42:18'),
(11, 49, '0', '50', '1', 49.5, 8, 1, 1, '04-02-2022', '2022-02-02 09:07:10', '2022-02-02 09:18:39'),
(12, 50, '0', '50', '1', 49, 8, 1, 2, '03-02-2022', '2022-02-02 09:29:23', '2022-02-02 10:38:45'),
(13, 2, '100', '200', '2000', 198, 3, 0, 1, '09-02-2022', '2022-02-02 09:41:06', '2022-02-02 09:42:23'),
(14, 51, '0', '50', '1', 49, 4, 1, 1, '04-02-2022', '2022-02-02 11:40:23', '2022-02-20 13:39:04'),
(15, 52, '8', '16', '0', 16, 15, 0, 1, '12-02-2022', '2022-02-04 10:41:42', '2022-02-04 11:00:47'),
(19, 54, '0', '10', '0', 10, 15, 0, 1, '17-02-2022', '2022-02-09 13:36:43', '2022-02-09 13:36:43'),
(20, 58, '1000', '2000', '20', 1980, 7, 0, 1, '12-02-2022', '2022-02-10 18:55:50', '2022-02-10 18:56:44');

-- --------------------------------------------------------

--
-- Structure de la table `caisse_waricrowds`
--

CREATE TABLE `caisse_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant_objectif` int(11) NOT NULL,
  `montant` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `caisse_waricrowds`
--

INSERT INTO `caisse_waricrowds` (`id`, `id_waricrowd`, `montant_objectif`, `montant`, `created_at`, `updated_at`) VALUES
(1, 1, 2322, 0, '2021-10-07 15:07:12', '2021-10-07 15:07:12'),
(2, 2, 50000000, 12350, '2021-10-13 11:13:01', '2021-12-09 10:08:45'),
(3, 3, 2332, 0, '2021-10-18 03:25:35', '2021-10-18 03:25:35'),
(4, 5, 5698, 0, '2021-10-18 13:05:49', '2021-10-18 13:05:49'),
(5, 6, 5000, 1831, '2021-10-18 13:15:27', '2021-12-01 10:48:17'),
(6, 7, 560000, 0, '2021-10-18 16:46:20', '2021-10-19 14:50:50'),
(7, 8, 58003, 0, '2021-10-18 17:05:51', '2021-10-20 17:08:59'),
(8, 9, 569, 0, '2021-10-20 17:23:18', '2021-10-20 17:55:11'),
(9, 10, 3223, 0, '2021-10-22 00:23:42', '2021-10-22 00:23:42'),
(10, 11, 4545, 0, '2021-10-22 00:32:27', '2021-10-22 00:32:27'),
(11, 12, 4545, 0, '2021-10-22 00:32:50', '2021-10-22 00:32:50'),
(12, 13, 3434, 0, '2021-10-22 00:33:44', '2021-10-22 00:33:44'),
(13, 14, 65, 0, '2021-10-22 00:35:33', '2021-10-22 00:35:33'),
(14, 15, 150000, 0, '2021-10-29 13:53:04', '2021-10-29 13:53:04'),
(15, 16, 500, 0, '2021-11-01 16:39:34', '2021-11-01 16:39:34'),
(16, 17, 500000, 0, '2021-11-11 09:59:48', '2021-11-11 09:59:48'),
(17, 18, 1000000, 0, '2021-11-24 10:58:18', '2021-11-24 10:58:18'),
(18, 19, 4000, 0, '2021-12-09 10:14:36', '2021-12-09 10:14:36'),
(19, 20, 50000000, 0, '2021-12-14 22:49:02', '2021-12-14 22:49:02'),
(20, 21, 10000000, 50, '2021-12-14 22:54:30', '2022-01-26 12:47:40'),
(21, 22, 200000000, 0, '2022-01-13 18:35:47', '2022-01-13 18:35:47'),
(22, 23, 10000000, 10, '2022-02-02 09:37:33', '2022-02-02 09:50:32'),
(23, 24, 100, 105, '2022-02-02 09:56:31', '2022-02-07 16:33:08'),
(24, 25, 100, 0, '2022-02-02 11:51:15', '2022-02-02 11:51:15'),
(25, 26, 7899, 1575, '2022-02-04 12:00:38', '2022-02-07 17:26:25'),
(26, 27, 7565, 0, '2022-02-08 15:45:26', '2022-02-08 15:45:26'),
(27, 28, 7565, 0, '2022-02-08 15:45:26', '2022-02-08 15:45:26'),
(28, 29, 985, 0, '2022-02-09 00:24:12', '2022-02-09 00:24:12'),
(29, 30, 55, 0, '2022-02-09 13:35:29', '2022-02-09 13:35:29');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_waricrowds`
--

CREATE TABLE `categorie_waricrowds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_waricrowds`
--

INSERT INTO `categorie_waricrowds` (`id`, `titre`, `created_at`, `updated_at`) VALUES
(1, 'Economie', '2021-10-07 12:44:47', '2021-10-07 12:44:47'),
(2, 'Informatique', '2021-10-07 12:44:59', '2021-10-07 12:44:59'),
(3, 'Agroalimentaire', '2021-10-14 16:17:52', '2021-10-14 16:17:52'),
(4, 'Univers bébé', '2021-12-14 22:52:14', '2021-12-14 22:52:14'),
(5, 'Pétrolier', '2022-02-02 10:41:14', '2022-02-02 10:41:14');

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
(1, 1, 2, 'ice ou pas', '2021-10-07 16:31:20', '2021-10-07 16:31:20'),
(2, 1, 1, 'un peu lowcost mais on apprécie l\'effort', '2021-10-07 16:32:02', '2021-10-07 16:32:02'),
(3, 2, 3, 'Salut a tous', '2021-10-12 00:13:52', '2021-10-12 00:13:52'),
(4, 3, 4, 'Bonjour à tous', '2021-10-12 17:20:01', '2021-10-12 17:20:01'),
(5, 5, 4, 'Bonjour<br/>', '2021-10-13 11:08:31', '2021-10-13 11:08:31'),
(6, 8, 3, 'Bonjour', '2021-10-16 19:59:21', '2021-10-16 19:59:21'),
(7, 8, 13, 'Slt', '2021-10-16 19:59:56', '2021-10-16 19:59:56'),
(8, 8, 3, 'Salut', '2021-10-16 20:02:01', '2021-10-16 20:02:01'),
(9, 8, 3, 'Test', '2021-10-16 20:02:32', '2021-10-16 20:02:32'),
(10, 8, 12, 'Aaaaa', '2021-10-16 20:02:47', '2021-10-16 20:02:47'),
(11, 28, 15, 'sdfsd', '2021-10-29 15:45:53', '2021-10-29 15:45:53'),
(12, 24, 4, 'Bonjour <br/>ceci est un test', '2021-10-31 18:31:48', '2021-10-31 18:31:48'),
(13, 34, 4, 'Bonjour à tous', '2021-11-01 12:13:27', '2021-11-01 12:13:27'),
(14, 45, 4, 'Bonjour à tous,<br/>Bienvenue à a tontine vacances.<br/><br/>Pour vous permettre de pouvoir faire vos vacances', '2022-01-13 18:38:23', '2022-01-13 18:38:23'),
(15, 49, 4, 'Bonjour à tous', '2022-02-02 08:52:20', '2022-02-02 08:52:20'),
(16, 58, 7, 'check', '2022-02-10 19:01:29', '2022-02-10 19:01:29'),
(17, 57, 15, 'asd', '2022-02-21 12:47:26', '2022-02-21 12:47:26');

-- --------------------------------------------------------

--
-- Structure de la table `compte_menbres`
--

CREATE TABLE `compte_menbres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `solde` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `compte_menbres`
--

INSERT INTO `compte_menbres` (`id`, `id_menbre`, `solde`, `created_at`, `updated_at`) VALUES
(1, 1, '8093', '2021-10-07 13:01:48', '2022-02-09 16:31:30'),
(2, 2, '1000', '2021-10-07 14:12:09', '2021-10-08 15:02:40'),
(3, 3, '220', '2021-10-08 09:59:01', '2022-02-10 11:50:49'),
(4, 4, '118', '2021-10-09 19:12:43', '2022-04-13 11:48:09'),
(5, 5, '0', '2021-10-11 09:57:59', '2021-10-11 09:57:59'),
(6, 6, '0', '2021-10-11 10:13:21', '2021-10-11 10:13:21'),
(7, 7, '19910', '2021-10-11 11:06:54', '2022-02-21 19:56:52'),
(8, 8, '43', '2021-10-13 08:38:36', '2022-04-13 11:48:09'),
(9, 9, '0', '2021-10-14 14:40:12', '2021-10-14 14:40:12'),
(10, 10, '0', '2021-10-14 15:00:13', '2021-10-14 15:00:13'),
(11, 11, '50000', '2021-10-14 15:29:53', '2021-10-14 15:29:53'),
(12, 12, '0', '2021-10-16 19:52:25', '2021-10-16 19:52:25'),
(13, 13, '0', '2021-10-16 19:53:48', '2021-10-16 19:53:48'),
(14, 14, '0', '2021-10-18 00:41:43', '2021-10-18 00:41:43'),
(15, 15, '488', '2021-10-19 14:26:51', '2022-02-17 16:25:34'),
(17, 17, '76000', '2021-10-26 09:45:26', '2021-11-11 09:50:04'),
(18, 18, '0', '2021-10-26 09:59:12', '2021-10-26 09:59:12'),
(19, 19, '142270', '2021-10-26 11:23:30', '2022-02-10 10:24:02'),
(20, 20, '0', '2021-10-31 19:01:10', '2021-10-31 19:01:10'),
(21, 21, '0', '2021-11-01 18:26:43', '2021-11-01 18:26:43'),
(22, 22, '0', '2021-11-04 16:23:21', '2021-11-04 16:23:21'),
(23, 23, '0', '2021-11-08 09:38:34', '2021-11-08 09:38:34'),
(24, 24, '0', '2021-11-08 09:41:51', '2021-11-08 09:41:51'),
(25, 25, '0', '2021-11-15 13:30:08', '2021-11-15 13:30:08'),
(26, 26, '0', '2021-11-18 13:09:59', '2021-11-18 13:09:59'),
(27, 27, '0', '2022-02-02 08:47:32', '2022-02-02 08:47:32'),
(28, 28, '16922.24', '2022-02-07 16:23:19', '2022-02-07 17:26:25'),
(29, 29, '200', '2022-02-10 11:45:08', '2022-02-10 11:50:01');

-- --------------------------------------------------------

--
-- Structure de la table `devises`
--

CREATE TABLE `devises` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `symbole` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `monaie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Structure de la table `historique_modif_profil_membres`
--

CREATE TABLE `historique_modif_profil_membres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` int(11) NOT NULL,
  `modif` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historique_modif_profil_membres`
--

INSERT INTO `historique_modif_profil_membres` (`id`, `id_menbre`, `modif`, `created_at`, `updated_at`) VALUES
(1, 1, ' Nom \r\nAncien : utilisateur deux \r\nNouveau : utilisateur deux\r\n                        ', '2022-02-09 12:02:23', '2022-02-09 12:02:23'),
(2, 1, 'Email \r\nAncien :  \r\nNouveau : 0778735784', '2022-02-09 12:05:23', '2022-02-09 12:05:23'),
(3, 1, ' Email \nAncien : 0778735784 \nNouveau : ', '2022-02-09 12:05:52', '2022-02-09 12:05:52'),
(4, 1, ' Nom \nAncien : utilisateur deux 45 \nNouveau : utilisateur deux 458', '2022-02-09 12:06:48', '2022-02-09 12:06:48'),
(5, 1, 'a changer son Adresse Email \nAncien :  \nNouveau : 5544@dff.hgf', '2022-02-09 12:08:29', '2022-02-09 12:08:29'),
(6, 1, 'a changer son Nom d\'utilisateur\nAncien : utilisateur deux 45856 \nNouveau : utilisateur deux 45\na changer son Adresse Email \nAncien : 5544@dff.hgf \nNouveau : 5544@dff.hgf4', '2022-02-09 12:09:21', '2022-02-09 12:09:21'),
(7, 1, 'a changer son Numero de Telephone\r\nAncien : 2250778735784 \r\nNouveau : 2250778735784\r\n                ', '2022-02-09 12:19:18', '2022-02-09 12:19:18');

-- --------------------------------------------------------

--
-- Structure de la table `invitations`
--

CREATE TABLE `invitations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email_inviter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `menbre_qui_invite` bigint(20) UNSIGNED NOT NULL,
  `etat` enum('attente','invitation envoyee','acceptee','refusee','expiree') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `invitations`
--

INSERT INTO `invitations` (`id`, `email_inviter`, `id_tontine`, `menbre_qui_invite`, `etat`, `created_at`, `updated_at`) VALUES
(1, 'yvessantoz@gmail.com', 1, 1, 'acceptee', '2021-10-07 14:13:19', '2021-10-07 14:14:55'),
(3, 'Willy.houed@gmail.com', 3, 4, 'refusee', '2021-10-12 17:20:48', '2021-10-13 09:19:06'),
(18, 'w.houedanou@bloomfield-investment.com', 5, 4, 'attente', '2021-10-13 11:07:52', '2021-10-13 11:07:52'),
(20, 'yves.ladde@akassoh.ci', 4, 5, 'attente', '2021-10-13 13:13:34', '2021-10-13 13:13:34'),
(22, 'salame.industry@gmail.com', 6, 10, 'attente', '2021-10-14 15:14:54', '2021-10-14 15:14:54'),
(23, 'vvjv@xhcj.cvkhl', 17, 14, 'attente', '2021-10-18 02:38:19', '2021-10-18 02:38:19'),
(24, '2250778735784', 17, 14, 'attente', '2021-10-18 02:41:58', '2021-10-18 02:41:58'),
(25, 'vjvh@gh.vjj', 17, 14, 'attente', '2021-10-18 02:42:20', '2021-10-18 02:42:20'),
(27, 'yvessantoz@gmail.com', 18, 15, 'expiree', '2021-10-19 14:33:37', '2021-10-19 14:45:58'),
(34, 'yvessantoz@gmail.com', 20, 16, 'acceptee', '2021-10-20 16:22:46', '2021-10-20 16:29:32'),
(38, 'ice@gmail.com', 17, 14, 'acceptee', '2021-10-20 16:55:39', '2021-10-20 17:02:29'),
(40, 'yves.ladde@akassoh.ci', 22, 15, 'acceptee', '2021-10-27 09:29:29', '2021-10-27 09:32:22'),
(42, 'wilfriedhouedanou@yahoo.fr', 26, 4, 'attente', '2021-10-27 12:24:40', '2021-10-27 12:24:40'),
(43, 'whouedanou@gmail.com', 28, 15, 'acceptee', '2021-10-29 10:50:04', '2021-10-30 16:57:47'),
(44, 'yvessantow2@gmail.com', 28, 15, 'expiree', '2021-10-29 11:06:07', '2021-10-30 16:57:47'),
(45, 'huberson.kouakou@akassoh.ci', 30, 17, 'expiree', '2021-10-29 13:04:12', '2021-10-29 13:20:14'),
(46, ' hubersonk11@gmail.com', 30, 17, 'expiree', '2021-10-29 13:04:12', '2021-10-29 13:20:14'),
(51, 'yvessantoz@gmail.com', 39, 15, 'expiree', '2021-11-02 11:23:36', '2021-12-09 10:09:50'),
(53, '2250555994041', 39, 15, 'acceptee', '2021-11-02 11:23:36', '2021-11-02 11:33:35'),
(54, '2250555994041', 39, 15, 'acceptee', '2021-11-03 11:02:02', '2021-11-05 19:06:17'),
(55, 'willy.houed@gmail.com', 41, 4, 'acceptee', '2021-11-05 19:11:03', '2022-02-02 11:39:44'),
(56, '2250709779787', 41, 4, 'refusee', '2021-11-05 19:11:39', '2021-11-07 20:45:54'),
(57, 'hubersonk11@gmail.com', 43, 7, 'acceptee', '2021-11-11 09:54:53', '2022-02-10 18:52:40'),
(58, '0170214740', 43, 7, 'invitation envoyee', '2021-11-11 09:55:52', '2021-11-11 09:55:52'),
(59, '2250170214740', 43, 7, 'acceptee', '2021-11-11 09:56:21', '2022-02-10 18:52:50'),
(60, '2250555994041', 39, 15, 'refusee', '2021-11-11 10:54:29', '2021-11-18 12:10:58'),
(61, '2250555994041', 39, 15, 'refusee', '2021-11-18 11:25:02', '2021-12-02 13:26:46'),
(62, 'willy.houed@gmail.com', 44, 4, 'refusee', '2021-11-24 11:02:44', '2022-02-02 11:54:03'),
(63, '2250102277154', 44, 4, 'invitation envoyee', '2021-11-24 11:03:28', '2021-11-24 11:03:28'),
(64, '2250758187266', 39, 15, 'acceptee', '2021-11-29 11:23:47', '2021-12-09 10:09:50'),
(65, '2250748216712', 46, 4, 'invitation envoyee', '2022-01-14 10:23:57', '2022-01-14 10:23:57'),
(66, '2250748216712', 48, 4, 'invitation envoyee', '2022-01-26 12:26:45', '2022-01-26 12:26:45'),
(67, '2250709779787', 2, 3, 'acceptee', '2022-02-01 22:31:06', '2022-02-01 22:32:36'),
(68, '2250748216712', 49, 4, 'acceptee', '2022-02-02 09:05:43', '2022-02-02 09:06:21'),
(69, '2250709779787', 50, 8, 'acceptee', '2022-02-02 09:27:20', '2022-02-02 09:28:33'),
(70, '2250709779787', 51, 8, 'acceptee', '2022-02-02 11:37:07', '2022-02-02 11:38:53');

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
  `etat` enum('attente','actif','suspendu','banni') COLLATE utf8mb4_unicode_ci NOT NULL,
  `incitation_mdp` enum('non','oui') COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbres`
--

INSERT INTO `menbres` (`id`, `nom_complet`, `telephone`, `email`, `mot_de_passe`, `etat`, `incitation_mdp`, `motif_intervention_admin`, `date_derniere_visite`, `devise`, `code_de_confirmation`, `created_at`, `updated_at`, `pays`, `ville`, `adresse`, `etat_us`, `code_postal`) VALUES
(1, 'utilisateur deux 45', '2250778735784', '5544@dff.hgf4', 'd9fc3b8d1297f1049c51ba671ee8357f', 'actif', 'oui', 'Pour rien cohan', '07-10-2021 16:56:26', '1', 88260, '2021-10-07 13:01:48', '2022-02-09 12:18:59', 'ci', 'abidjan', 'cocody palmeraie', NULL, NULL),
(2, 'yves santoz', '2250987654333', 'oyvessantoz@gmail.com', 'e3122587250f1537b2c4129c0031dcba', 'actif', 'non', NULL, '07-10-2021 16:32:46', '1', 1542, '2021-10-07 14:12:09', '2021-10-08 16:55:02', 'CI', 'Abidjan', 'bingervillle', NULL, NULL),
(3, 'Salame nayef', '2250103570000', 'recyplast.ci@gmail.com', '38ba2a9f6362c4dbfb387304fc22cb3c', 'actif', 'non', NULL, '16-10-2021 20:02:52', '1', 3992, '2021-10-08 09:59:01', '2022-02-01 22:51:41', 'CI', 'Abidjan', 'Abidjan cocody', NULL, NULL),
(4, 'Wilfried G. HOUEDANOU', '2250709779787', 'whouedanou@gmail.com', 'a482270563625e6e1ad53562d6891ea3', 'actif', 'non', NULL, '02-02-2022 08:52:12', '1', 84216, '2021-10-09 19:12:43', '2022-02-22 13:39:02', 'CI', 'AbidjaN', 'Cocody', NULL, NULL),
(5, 'hi boy', '22505653jjk29653', 'newsmsapi@gmail.com', '3b29f690be41036e1ca16033556f2400', 'actif', 'non', NULL, NULL, '1', 9175, '2021-10-11 09:57:59', '2021-10-11 16:04:33', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(6, 'sandra', '2250789588653', 'lagoma.business@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'actif', 'non', NULL, NULL, NULL, 6804, '2021-10-11 10:13:21', '2021-10-11 10:15:16', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(7, 'HUBERSON KOUAKOU', '2250758187266', 'huberson.kouakou@yahoo.com', 'c2fc7bd2b1011f30954b4455e74bb74d', 'actif', 'non', NULL, '10-02-2022 19:01:09', '1', 28620, '2021-10-11 11:06:54', '2022-02-10 19:01:09', 'CI', 'ABIDJAN', 'ABIDJAN', NULL, '000'),
(8, 'Koffi josephine', '2250748216712', 'willy.houed@gmail.com', '201dd75c02cc2cab01d63d752d364016', 'actif', 'non', 'bon payeur', NULL, '1', 79752, '2021-10-13 08:38:36', '2022-02-02 11:53:10', 'CI', 'Abidjan', 'cocody', NULL, NULL),
(10, 'ALAN', '2250707255244', 'hexagonegroupe@gmail.com', 'e18900207d2584a1c7615316e28a2443', 'actif', 'non', NULL, '14-10-2021 15:13:40', '1', 4526, '2021-10-14 15:00:13', '2021-10-14 15:13:40', 'CI', 'abidjan', 'cocody', NULL, NULL),
(11, 'Huberson Kouakou', '22558187266', 'huberson.kouakou@akassoh.ci', 'c2fc7bd2b1011f30954b4455e74bb74d', 'suspendu', 'non', 'POUR DES RAISON DE TEST', NULL, NULL, 7942, '2021-10-14 15:29:53', '2022-02-08 12:44:41', 'CI', 'Abidjan', 'Abidjan', NULL, NULL),
(12, 'Mohamed EL ZEIN', '2250707091982', 'mohamedelzein78@gmail.com', '40641914166f1cba1d06c020e462ff8e', 'actif', 'non', NULL, '16-10-2021 20:02:39', '1', 5989, '2021-10-16 19:52:25', '2021-10-16 20:02:39', 'CI', 'Abidjan', 'Cocody', NULL, NULL),
(13, 'Nadim hoballah', '2250700780738', 'nym8@hotmail.com', '335cf4508dd597be4bfc9caa3e08b901', 'actif', 'non', NULL, '16-10-2021 20:04:42', '1', 3976, '2021-10-16 19:53:48', '2021-10-16 20:04:42', 'CI', 'Abidjan', 'CocoDy', NULL, NULL),
(14, 'PERSONNE PERSONNE', '2250555994042', 'yvessanto546z@gmail.com', '95a63b20434119e0ec95de3d73b08b20', 'actif', 'non', NULL, NULL, '3', 4049, '2021-10-18 00:41:43', '2021-11-04 10:44:56', 'CI', 'ABIDJAN', 'PERSONNE', NULL, NULL),
(15, 'BUT IT WORK 24', '2250555994041', 'yvessantoz@gmail.com', 'b5f9c9014803d3376aa00f4c6e659be0', 'actif', 'non', NULL, '21-02-2022 12:47:16', '1', 62100, '2021-10-19 14:26:51', '2022-02-21 12:47:16', 'CI', 'ABIDJAN DEH', 'KOUMASSI ICE', 'Alabama', '639'),
(17, 'Huberson Kouakou', '2250170214740', 'hubersonk11@gmail.com', 'c2fc7bd2b1011f30954b4455e74bb74d', 'actif', 'non', NULL, NULL, '1', 9880, '2021-10-26 09:45:26', '2021-10-29 12:52:18', 'CI', 'Abidjan', 'Abidjan', NULL, NULL),
(18, 'Salame nayef fayad', '2250101999901', 'Salame.industry@gmail.com', '30f78822c1dfaeb08ed321406810b68d', 'attente', 'non', NULL, NULL, NULL, 1675, '2021-10-26 09:59:12', '2022-01-29 22:26:40', 'CI', 'Abidjan côte divoire', 'Cocody riviera', NULL, NULL),
(19, 'WITH HTTPS BABE', '2250565327653', 'yves.ladde@akassoh.ci', '678d4873e8a2079ddb4bd4438523e597', 'actif', 'oui', NULL, NULL, '1', 6552, '2021-10-26 11:23:30', '2022-02-10 09:51:58', 'CI', 'YAMOUSSOUKRO', 'FORWHAT', NULL, NULL),
(20, 'Kevin houedanou', '2250758449332', 'ja.attebiserge@gmail.com', '201dd75c02cc2cab01d63d752d364016', 'actif', 'non', NULL, NULL, '1', 5356, '2021-10-31 19:01:10', '2021-10-31 19:03:03', 'xx', 'ABIDJAN', 'plateau dokui', NULL, NULL),
(21, 'Steven ahuie', '2250708887605', 'Stevenahuie@gmail.com', 'b2fac54cebba6cc991cd145adfab0489', 'actif', 'non', NULL, NULL, '1', 5028, '2021-11-01 18:26:43', '2021-11-01 18:27:42', 'CI', 'Abidjan', 'Cocody angre', NULL, NULL),
(22, 'DDS', '22585544', 'fdz@ks.dls', '4124bc0a9335c27f086f24ba207a4912', 'attente', 'non', NULL, NULL, NULL, 5236, '2021-11-04 16:23:21', '2021-11-04 16:23:21', 'CI', 'WS', 'SS', NULL, NULL),
(23, 'NGUESSAN', '2250708655362', 'wilfriedn@akassoh.net', 'ab4f63f9ac65152575886860dde480a1', 'attente', 'non', NULL, NULL, NULL, 4546, '2021-11-08 09:38:34', '2021-11-08 09:39:27', 'CI', 'ABIDJAN', '28 BP 173', NULL, NULL),
(24, 'NGUESSAN', '2250554549054', 'wilfriedn@akassoh.ci', 'ab4f63f9ac65152575886860dde480a1', 'actif', 'non', NULL, NULL, '1', 5144, '2021-11-08 09:41:51', '2021-11-11 10:55:27', 'CI', 'ABIDJAN', '28 BP 173', NULL, NULL),
(25, 'ezzat fakhry', '33689115678', 'fakhryfield@hotmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'actif', 'non', NULL, NULL, '3', 9191, '2021-11-15 13:30:08', '2021-11-15 13:31:36', 'FR', 'Paris', '14 Rue du Dobropol', NULL, NULL),
(26, 'YVES SANTOZ', '22508090', NULL, '25ed1bcb423b0b7200f485fc5ff71c8e', 'attente', 'non', NULL, NULL, NULL, 1266, '2021-11-18 13:09:59', '2021-11-18 13:13:29', 'CI', 'VILLE', 'ADRESSE', NULL, NULL),
(27, 'HUBERSON KOFFI', '2250544444451', NULL, '74b87337454200d4d33f80c4663dc5e5', 'attente', 'non', NULL, NULL, NULL, 4714, '2022-02-02 08:47:32', '2022-02-02 08:47:32', 'CI', 'Abidjan', 'PALMERAIE', NULL, NULL),
(28, 'AutoMarket', '2250707012782', 'personnepersonnepersonneperson@gmail.com', 'b909a104bd69119364fe1090182ce1fd', 'actif', 'oui', NULL, NULL, '1', 8843, '2022-02-07 16:23:18', '2022-02-07 18:08:55', 'CI', 'abidjan', 'abidjan 22e arrondissemnt', NULL, NULL),
(29, 'leonce konan', '2250141863114', 'lmkonan@gmail.com', 'ace31f6a6371093f65de06610a575da6', 'actif', 'non', NULL, NULL, '1', 9850, '2022-02-10 11:45:08', '2022-02-10 11:47:46', 'CI', 'Abidjan', 'cocody angre', NULL, NULL);

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
(28, 20, 14, '2021-10-20 16:29:32', '2021-10-20 16:29:32'),
(29, 21, 16, '2021-10-20 16:35:17', '2021-10-20 16:35:17'),
(30, 17, 16, '2021-10-20 16:55:54', '2021-10-20 16:55:54'),
(31, 22, 15, '2021-10-22 00:23:07', '2021-10-22 00:23:07'),
(32, 23, 4, '2021-10-26 19:26:08', '2021-10-26 19:26:08'),
(33, 23, 8, '2021-10-26 19:29:09', '2021-10-26 19:29:09'),
(34, 22, 19, '2021-10-27 09:32:22', '2021-10-27 09:32:22'),
(35, 24, 4, '2021-10-27 11:20:17', '2021-10-27 11:20:17'),
(36, 25, 4, '2021-10-27 11:22:49', '2021-10-27 11:22:49'),
(37, 26, 4, '2021-10-27 11:25:21', '2021-10-27 11:25:21'),
(38, 27, 8, '2021-10-27 12:25:18', '2021-10-27 12:25:18'),
(39, 28, 15, '2021-10-29 10:49:37', '2021-10-29 10:49:37'),
(40, 29, 7, '2021-10-29 12:36:04', '2021-10-29 12:36:04'),
(41, 30, 17, '2021-10-29 12:55:11', '2021-10-29 12:55:11'),
(42, 30, 7, '2021-10-29 13:20:14', '2021-10-29 13:20:14'),
(43, 28, 4, '2021-10-30 16:57:47', '2021-10-30 16:57:47'),
(44, 31, 4, '2021-10-31 18:30:57', '2021-10-31 18:30:57'),
(45, 32, 4, '2021-10-31 18:33:22', '2021-10-31 18:33:22'),
(46, 32, 8, '2021-10-31 19:15:53', '2021-10-31 19:15:53'),
(47, 32, 20, '2021-10-31 19:47:28', '2021-10-31 19:47:28'),
(48, 33, 4, '2021-10-31 20:04:33', '2021-10-31 20:04:33'),
(49, 34, 20, '2021-10-31 20:06:04', '2021-10-31 20:06:04'),
(50, 34, 4, '2021-10-31 20:21:30', '2021-10-31 20:21:30'),
(51, 34, 8, '2021-10-31 20:22:39', '2021-10-31 20:22:39'),
(52, 35, 4, '2021-11-01 14:17:14', '2021-11-01 14:17:14'),
(53, 36, 19, '2021-11-01 18:26:42', '2021-11-01 18:26:42'),
(54, 37, 21, '2021-11-01 18:28:21', '2021-11-01 18:28:21'),
(55, 38, 19, '2021-11-01 19:07:51', '2021-11-01 19:07:51'),
(56, 39, 15, '2021-11-02 10:17:53', '2021-11-02 10:17:53'),
(57, 40, 7, '2021-11-03 17:57:36', '2021-11-03 17:57:36'),
(58, 39, 4, '2021-11-05 19:06:17', '2021-11-05 19:06:17'),
(59, 41, 4, '2021-11-05 19:08:40', '2021-11-05 19:08:40'),
(60, 42, 7, '2021-11-11 09:52:15', '2021-11-11 09:52:15'),
(61, 43, 7, '2021-11-11 09:52:26', '2021-11-11 09:52:26'),
(62, 44, 4, '2021-11-24 11:01:30', '2021-11-24 11:01:30'),
(63, 39, 7, '2021-12-09 10:09:50', '2021-12-09 10:09:50'),
(64, 45, 4, '2022-01-13 18:37:26', '2022-01-13 18:37:26'),
(65, 46, 4, '2022-01-14 10:21:18', '2022-01-14 10:21:18'),
(66, 47, 15, '2022-01-20 11:11:53', '2022-01-20 11:11:53'),
(67, 48, 4, '2022-01-26 12:26:03', '2022-01-26 12:26:03'),
(68, 48, 8, '2022-01-26 12:39:52', '2022-01-26 12:39:52'),
(69, 2, 4, '2022-02-01 22:32:36', '2022-02-01 22:32:36'),
(70, 49, 4, '2022-02-02 08:51:17', '2022-02-02 08:51:17'),
(71, 49, 8, '2022-02-02 09:06:21', '2022-02-02 09:06:21'),
(72, 50, 8, '2022-02-02 09:26:14', '2022-02-02 09:26:14'),
(73, 50, 4, '2022-02-02 09:28:33', '2022-02-02 09:28:33'),
(74, 51, 8, '2022-02-02 11:30:18', '2022-02-02 11:30:18'),
(75, 51, 4, '2022-02-02 11:38:53', '2022-02-02 11:38:53'),
(76, 41, 8, '2022-02-02 11:39:44', '2022-02-02 11:39:44'),
(77, 52, 15, '2022-02-04 10:26:44', '2022-02-04 10:26:44'),
(78, 52, 15, '2022-02-04 10:26:44', '2022-02-04 10:26:44'),
(79, 53, 15, '2022-02-07 13:11:27', '2022-02-07 13:11:27'),
(80, 54, 15, '2022-02-07 13:11:27', '2022-02-07 13:11:27'),
(81, 54, 15, '2022-02-07 13:11:27', '2022-02-07 13:11:27'),
(82, 55, 15, '2022-02-08 22:58:27', '2022-02-08 22:58:27'),
(83, 56, 15, '2022-02-08 23:23:21', '2022-02-08 23:23:21'),
(84, 57, 15, '2022-02-09 13:35:50', '2022-02-09 13:35:50'),
(85, 43, 17, '2022-02-10 18:52:40', '2022-02-10 18:52:40'),
(86, 58, 7, '2022-02-10 18:54:16', '2022-02-10 18:54:16'),
(87, 58, 17, '2022-02-10 18:55:28', '2022-02-10 18:55:28'),
(88, 59, 4, '2022-02-22 13:40:45', '2022-02-22 13:40:45');

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
(32, '2021_10_23_203927_create_transaction_transfert_waribanks_table', 5),
(33, '2022_02_07_110434_create_parametres_table', 6),
(34, '2022_02_09_114838_create_historique_modif_profil_membres_table', 7);

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pourcentage_frais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `parametres`
--

INSERT INTO `parametres` (`id`, `pourcentage_frais`) VALUES
(1, 1);

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
('5aWyc0u31e5Lu8Lb2dSLerYXg3rUHQhbpTdWdzJ7', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0xKZlpVVXlLQ0xIbDh4VmtuRUpRU2EzZHJrUzhieDhWZUJEbUhTZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650387610),
('A7QOxGNCQi1TLq9zEUDIOueLKv3tszo1B2yUtGRH', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmg1RGs0cEdqTUlFclRicmU3dGt3MWx1cDBTOTR0NVpBNU5SN0hWNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650389409),
('aap45wdVYTtPgiMNogLJUAf9U2XCkzbGopMoKZqV', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUFOcHljSThFYUtQYTRJaHdDRzBSdlZ3MHd2OVRaWnVIeVdUWGpweSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650393008),
('BOOKB2bzopYp1AJu7Mi4zkUSHofmOiO00yvDC3U1', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSzFld3Y4SnplVmhtYjZ2RXRTMThsd0w3SzgyUGhJdW5PbXA0SGF5VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650391205),
('GdYWqFAPawG25ichpKNaZMjqRS4plf0zSvYWNWfy', NULL, '18.206.55.48', 'Apache-HttpClient/5.1.2 (Java/11.0.14.1)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUo5a1RITHk5MXQ4TEZTOW5Ea1RJejVCb0ZseGh1cUxBRUlFVThUSiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd2FyaWJhbmEubmV0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650390694),
('GNjsEdmSKDvM6uptG9YVPw5oIVnWQVJwEfio9Trz', NULL, '54.227.32.154', 'Mozilla/5.0 (Windows NT 10.0; rv:91.0) Gecko/20100101 Firefox/91.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidzN3VnVzaGtOaVFTdXNHck5TNE9OWmxIbnlxZllyemFBbm9DWDJyNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd2FyaWJhbmEubmV0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650391466),
('hcm7hOvO5VGpFh5zKdb7IT44QPQPF5Biqhj4Jdkd', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTjZ3MFJvMm42OXVhSWpjTEtjOGlsRTZKakdlR05MZ0taQmxQT1RzMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650384010),
('jvh1NKam7d9xpOSHYFQtOkrBdOXeOyk3KKCF1Kd3', NULL, '163.172.220.203', 'Mozilla/5.0 (Linux; U; Android 2.2; en-us; Droid Build/FRG22D) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNFltQllqZlM0RG1uWENXSEZTVjdVanNhaVBXblAzVkJXSHgxV3k1WiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd2FyaWJhbmEubmV0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650385166),
('kbOg25GLxlSD6ivqCPZ7V4IgRgGlP9STN8zmtyXD', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnExZmNOZUtNNkpiWFhhY3lEc0M1TEZ4eno3dTBKbXBZaUlpdGczQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650394811),
('n25wMsQuOOzLMD4aUwtHE2htXPUvX5vpfLPdfmqR', NULL, '18.206.55.48', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.106 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTW53VTByQkl2ZldidFBLYnVMdmlZYmJrQ1R5RlJQWUR5ZU1oNElUeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjA6Imh0dHBzOi8vd2FyaWJhbmEubmV0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650390695),
('oaR3qiViVvaihzULfR5T1Fzkn3knRHOCuXwPet6f', NULL, '161.97.166.187', 'curl/7.29.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiczZUYzdMc01yV2pJbjJEREZJRzdITGxjcXVvOGhOcHlyMzBlSHFJUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xpbmtzdG9yYWdlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1650385809);

-- --------------------------------------------------------

--
-- Structure de la table `sms_contenu_notifications`
--

CREATE TABLE `sms_contenu_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `confirmation_compte` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_waricowd` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invitation_recue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat_tontine` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `virement_compte_menbre_qui_prend` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `retard_paiement` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sms_contenu_notifications`
--

INSERT INTO `sms_contenu_notifications` (`id`, `confirmation_compte`, `etat_waricowd`, `invitation_recue`, `etat_tontine`, `virement_compte_menbre_qui_prend`, `retard_paiement`, `created_at`, `updated_at`) VALUES
(1, 'Bienvenu(e) sur waribana, votre code de confirmation est le suivant $code$', 'Bonjour votre waricrowd intitule <<$titre$>> a été : $etat$ $motif$', 'Bonjour, le menbre $nom_complet$ de waribana vous invite a rejoindre la tontine << $titre_tontine$ >>, Connectez vous inscrivez-vous pour repondre a son invitation', 'Bonjour,\r\nvotre tontine intitulée <$titre$> est : $etat$ $motif$', 'Bonjour,\r\nLe montant de cotisation de la tontine << $titre_tontine$ >>  a été atteint. Et, le virement a été effectué sur le compte de : $nom_menbre_qui_prend$', 'Bonjour,\r\nVous avez des cotisations en retard sur la tontine << $titre$ >>;\r\nLes retardataires : $liste_retardataires$', '2021-10-07 12:44:03', '2022-02-02 10:54:21');

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
(1, '10/2021', '10/2021', 877, '2021-10-07 12:35:00', '2021-10-31 23:37:31'),
(2, '11/2021', '11/2021', 670, '2021-11-01 01:10:28', '2021-11-30 20:39:50'),
(3, '12/2021', '12/2021', 314, '2021-12-01 02:23:05', '2021-12-31 23:44:08'),
(4, '01/2022', '01/2022', 308, '2022-01-01 00:55:22', '2022-01-31 21:49:32'),
(5, '02/2022', '02/2022', 473, '2022-02-01 02:34:26', '2022-02-28 19:11:07'),
(6, '03/2022', '03/2022', 504, '2022-03-01 01:52:13', '2022-03-31 22:55:19'),
(7, '04/2022', '04/2022', 253, '2022-04-01 02:16:22', '2022-04-19 18:04:26');

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
  `etat` enum('constitution','prete','ouverte','terminer','fermee','suspendue') COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `motif_intervention_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tontines`
--

INSERT INTO `tontines` (`id`, `identifiant_adhesion`, `titre`, `montant`, `frequence_depot_en_jours`, `nombre_participant`, `etat`, `id_menbre`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(1, 396, 'tontine test', '170', '7', 2, 'ouverte', 1, NULL, '2021-10-07 14:10:25', '2021-10-07 14:34:27'),
(2, 2645, 'Totine de nayef', '100', '7', 2, 'ouverte', 3, NULL, '2021-10-12 00:11:21', '2022-02-02 09:42:02'),
(3, 2985, 'TONTINE WILFRIED', '20000', '15', 2, 'ouverte', 4, NULL, '2021-10-12 17:19:36', '2021-10-13 11:17:53'),
(4, 1653, 'test22', '34545', '4', 2, 'constitution', 5, NULL, '2021-10-13 09:06:41', '2021-10-13 09:06:41'),
(6, 4739, 'financement personnel', '1000', '7', 2, 'constitution', 10, NULL, '2021-10-14 15:09:27', '2021-10-14 15:09:27'),
(17, 5580, 'tt', '55', '88', 55, 'constitution', 14, NULL, '2021-10-18 01:38:32', '2021-10-18 01:38:32'),
(22, 7016, 'dsd', '32', '2', 2, 'terminer', 15, NULL, '2021-10-22 00:23:07', '2021-10-27 10:23:22'),
(24, 973, 'TEST TONTINE AUJOURD\'HUI', '-5', '30000', 10, 'constitution', 4, NULL, '2021-10-27 11:20:17', '2021-10-27 11:20:17'),
(25, 5796, 'TONTINE MONTANT NEGATIF', '-50000', '1', 10, 'constitution', 4, NULL, '2021-10-27 11:22:49', '2021-10-27 11:22:49'),
(26, 1869, 'test', '5', '1', 5, 'constitution', 4, NULL, '2021-10-27 11:25:21', '2021-10-27 11:25:21'),
(27, 672, 'Tontine Hart', '20000', '10', 10, 'constitution', 8, NULL, '2021-10-27 12:25:18', '2021-10-27 12:25:18'),
(28, 1735, 'Demo invitations', '100', '7', 2, 'ouverte', 15, NULL, '2021-10-29 10:49:37', '2021-11-02 12:34:52'),
(29, 579, 'Tontine huber', '25000', '2', 3, 'constitution', 7, NULL, '2021-10-29 12:36:04', '2021-10-29 12:36:04'),
(30, 1847, 'tontine huber Moov', '1000', '2', 2, 'prete', 17, NULL, '2021-10-29 12:55:11', '2021-10-29 13:20:14'),
(33, 4585, 'TEST INVITATION', '10000', '10', 3, 'constitution', 4, NULL, '2021-10-31 20:04:33', '2021-10-31 20:04:33'),
(34, 1725, 'TOTINE INVITATION KEVIN', '10000', '30', 3, 'prete', 20, NULL, '2021-10-31 20:06:04', '2021-10-31 20:22:39'),
(35, 333, 'TONTINE BENIAZONE', '15000', '30', 8, 'constitution', 4, NULL, '2021-11-01 14:17:14', '2021-11-01 14:17:14'),
(37, 1593, 'Tontine steve', '15150', '30', 9, 'constitution', 21, NULL, '2021-11-01 18:28:21', '2021-11-01 18:28:21'),
(39, 872, 'BIG ICE TONTINE', '7899', '3', 3, 'prete', 15, NULL, '2021-11-02 10:17:53', '2021-12-09 10:09:50'),
(40, 1932, 'vbj', '899', '8', 5, 'constitution', 7, NULL, '2021-11-03 17:57:36', '2021-11-03 17:57:36'),
(41, 1769, 'TONTINE 05 NOVEMBRE', '10100', '10', 5, 'constitution', 4, NULL, '2021-11-05 19:08:40', '2021-11-05 19:08:40'),
(42, 3948, 'test 01', '2000', '1', 10, 'constitution', 7, NULL, '2021-11-11 09:52:15', '2021-11-11 09:52:15'),
(43, 6521, 'test 01', '2000', '1', 10, 'constitution', 7, NULL, '2021-11-11 09:52:26', '2021-11-11 09:52:26'),
(44, 600, 'tontine 23 now', '1000', '7', 2, 'constitution', 4, NULL, '2021-11-24 11:01:30', '2021-11-24 11:01:30'),
(45, 664, 'TONTINE VACANCES', '100000', '30', 5, 'constitution', 4, NULL, '2022-01-13 18:37:26', '2022-01-13 18:37:26'),
(46, 3792, 'tontine eco', '20000', '30', 2, 'constitution', 4, NULL, '2022-01-14 10:21:18', '2022-01-14 10:24:57'),
(47, 2419, 'ivb', '2000', '5', 3, 'constitution', 15, NULL, '2022-01-20 11:11:53', '2022-01-20 11:11:53'),
(48, 1035, 'Tontine test', '50', '1', 2, 'ouverte', 4, NULL, '2022-01-26 12:26:03', '2022-01-26 12:42:07'),
(49, 1296, 'TONTINE HUBERSON', '25', '1', 2, 'terminer', 4, NULL, '2022-02-02 08:51:17', '2022-02-02 09:18:39'),
(50, 1715, 'HUBERSON 2', '25', '1', 2, 'ouverte', 8, NULL, '2022-02-02 09:26:14', '2022-02-02 10:38:45'),
(51, 1733, 'test 02 02 22', '25', '1', 2, 'terminer', 8, NULL, '2022-02-02 11:30:18', '2022-02-20 13:39:04'),
(52, 883, 'HG', '8', '8', 2, 'ouverte', 15, NULL, '2022-02-04 10:26:44', '2022-02-04 10:41:42'),
(53, 4179, 'tontine frais', '5', '8', 2, 'constitution', 15, NULL, '2022-02-07 13:11:27', '2022-02-07 13:11:27'),
(54, 1809, 'tontine frais', '5', '8', 2, 'ouverte', 15, NULL, '2022-02-07 13:11:27', '2022-02-09 13:36:43'),
(55, 907, 'ggg 444', '855', '88', 88, 'constitution', 15, NULL, '2022-02-08 22:58:27', '2022-02-08 22:58:27'),
(56, 815, 'hhhiii', '8', '888', 5, 'constitution', 15, NULL, '2022-02-08 23:23:21', '2022-02-08 23:23:21'),
(57, 1098, 'cvv', '88', '8', 888, 'constitution', 15, NULL, '2022-02-09 13:35:50', '2022-02-09 13:35:50'),
(58, 620, 'Tontine Hub', '1000', '2', 2, 'ouverte', 7, NULL, '2022-02-10 18:54:16', '2022-02-10 18:55:50'),
(59, 1376, 'TONTINE TEST FINAL', '1000', '1', 2, 'constitution', 4, NULL, '2022-02-22 13:40:45', '2022-02-22 13:40:45');

-- --------------------------------------------------------

--
-- Structure de la table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) NOT NULL,
  `id_tontine` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_menbre_qui_prend` bigint(20) UNSIGNED NOT NULL,
  `index_ouverture` int(11) NOT NULL DEFAULT 1,
  `trans_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(18, 22, 19, 32, 'ACCEPTED', 15, 1, NULL, NULL, '2021-10-27 10:04:11', '2021-10-27 10:04:11'),
(19, 22, 15, 32, 'ACCEPTED', 15, 1, NULL, NULL, '2021-10-27 10:08:45', '2021-10-27 10:08:45'),
(24, 22, 19, 32, 'ACCEPTED', 19, 1, NULL, NULL, '2021-10-27 10:22:49', '2021-10-27 10:22:49'),
(25, 22, 15, 32, 'ACCEPTED', 19, 1, NULL, NULL, '2021-10-27 10:23:17', '2021-10-27 10:23:17'),
(26, 28, 15, 100, 'ACCEPTED', 15, 2, NULL, NULL, '2021-11-18 12:43:21', '2021-11-18 12:43:21'),
(27, 48, 4, 50, 'ACCEPTED', 4, 1, NULL, NULL, '2022-01-26 12:42:18', '2022-01-26 12:42:18'),
(28, 49, 4, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-02 09:15:15', '2022-02-02 09:15:15'),
(29, 49, 8, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-02 09:16:34', '2022-02-02 09:16:34'),
(30, 49, 8, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 09:18:15', '2022-02-02 09:18:15'),
(31, 49, 4, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 09:18:34', '2022-02-02 09:18:34'),
(32, 50, 4, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 09:30:17', '2022-02-02 09:30:17'),
(33, 50, 8, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 09:30:26', '2022-02-02 09:30:26'),
(34, 50, 4, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-02 09:34:18', '2022-02-02 09:34:18'),
(35, 50, 8, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-02 09:34:48', '2022-02-02 09:34:48'),
(36, 2, 3, 100, 'ACCEPTED', 3, 1, NULL, NULL, '2022-02-02 09:42:23', '2022-02-02 09:42:23'),
(37, 51, 8, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 11:41:44', '2022-02-02 11:41:44'),
(38, 51, 4, 25, 'ACCEPTED', 8, 1, NULL, NULL, '2022-02-02 11:41:56', '2022-02-02 11:41:56'),
(40, 52, 15, 8, 'ACCEPTED', 15, 1, NULL, NULL, '2022-02-04 11:00:47', '2022-02-04 11:00:47'),
(41, 51, 8, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-06 18:21:01', '2022-02-06 18:21:01'),
(42, 58, 7, 1000, 'ACCEPTED', 7, 1, NULL, NULL, '2022-02-10 18:56:44', '2022-02-10 18:56:44'),
(43, 51, 4, 25, 'ACCEPTED', 4, 1, NULL, NULL, '2022-02-20 13:39:00', '2022-02-20 13:39:00');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_rechargement_waribanks`
--

CREATE TABLE `transaction_rechargement_waribanks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` int(11) NOT NULL,
  `solde_avant` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `solde_apres` int(11) NOT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `statut` enum('PENDING','ACCEPTED','REFUSED') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_rechargement_waribanks`
--

INSERT INTO `transaction_rechargement_waribanks` (`id`, `id_menbre`, `solde_avant`, `montant`, `solde_apres`, `trans_id`, `statut`, `created_at`, `updated_at`) VALUES
(1, 15, 2828, 800, 3628, 'waribana-rechargement-1635163994', 'REFUSED', '2021-10-25 12:13:15', '2021-10-25 12:14:00'),
(2, 15, 2828, 8, 2836, 'waribana-rechargement-1635164437', 'REFUSED', '2021-10-25 12:20:37', '2021-10-25 12:20:58'),
(3, 15, 2828, 900, 3728, 'waribana-rechargement-1635164673', 'REFUSED', '2021-10-25 12:24:34', '2021-10-25 12:24:52'),
(4, 15, 2828, 66, 2894, 'waribana-rechargement-1635165349', 'REFUSED', '2021-10-25 12:35:49', '2021-10-25 12:36:39'),
(5, 15, 2828, 56, 2884, 'waribana-rechargement-1635165775', 'REFUSED', '2021-10-25 12:42:55', '2021-10-25 12:43:23'),
(6, 15, 2828, 900, 3728, 'waribana-rechargement-1635166329', 'REFUSED', '2021-10-25 12:52:09', '2021-10-25 12:52:52'),
(7, 15, 2828, 900, 3728, 'waribana-rechargement-1635166453', 'REFUSED', '2021-10-25 12:54:13', '2021-10-25 12:55:19'),
(8, 15, 2828, 434, 3262, 'waribana-rechargement-1635166915', 'REFUSED', '2021-10-25 13:01:55', '2021-10-25 13:02:23'),
(9, 15, 2828, 445, 3273, 'waribana-rechargement-1635167328', 'REFUSED', '2021-10-25 13:08:48', '2021-10-25 13:09:18'),
(10, 15, 2828, 788, 3616, 'waribana-rechargement-1635167953', 'REFUSED', '2021-10-25 13:19:13', '2021-10-25 13:19:38'),
(11, 15, 2828, 1000, 3828, 'waribana-rechargement-1635168026', 'ACCEPTED', '2021-10-25 13:20:27', '2021-10-25 13:20:42'),
(12, 3, 0, 1000, 1000, 'waribana-rechargement-1635242541', 'PENDING', '2021-10-26 10:02:22', '2021-10-26 10:02:22'),
(13, 19, 0, 150, 150, 'waribana-rechargement-1635250675', 'PENDING', '2021-10-26 12:17:55', '2021-10-26 12:17:55'),
(14, 19, 0, 10000, 10000, 'waribana-rechargement-1635252744', 'REFUSED', '2021-10-26 12:52:24', '2021-10-26 12:53:05'),
(15, 19, 0, 655698, 655698, 'waribana-rechargement-1635252947', 'REFUSED', '2021-10-26 12:55:48', '2021-10-26 12:56:32'),
(16, 19, 0, 40000, 40000, 'waribana-rechargement-1635262103', 'ACCEPTED', '2021-10-26 15:28:23', '2021-10-26 15:29:15'),
(17, 19, 40000, 20000, 60000, 'waribana-rechargement-1635262231', 'ACCEPTED', '2021-10-26 15:30:32', '2021-10-26 15:31:25'),
(18, 4, 0, 50000, 50000, 'waribana-rechargement-1635271808', 'PENDING', '2021-10-26 18:10:08', '2021-10-26 18:10:08'),
(19, 4, 0, 50000, 50000, 'waribana-rechargement-1635276709', 'PENDING', '2021-10-26 19:31:49', '2021-10-26 19:31:49'),
(20, 4, 0, 10000, 10000, 'waribana-rechargement-1635294446', 'PENDING', '2021-10-27 00:27:26', '2021-10-27 00:27:26'),
(21, 7, 0, 100, 100, 'waribana-rechargement-1635516152', 'PENDING', '2021-10-29 14:02:32', '2021-10-29 14:02:32'),
(22, 19, 142470, 50000, 192470, 'waribana-rechargement-1635784478', 'REFUSED', '2021-11-01 16:34:38', '2021-11-01 16:35:26'),
(23, 19, 142470, 5000, 147470, 'waribana-rechargement-1635869977', 'REFUSED', '2021-11-02 16:19:38', '2021-11-02 16:20:11'),
(24, 19, 142470, 5000, 147470, 'waribana-rechargement-1635870155', 'REFUSED', '2021-11-02 16:22:35', '2021-11-02 16:23:17'),
(25, 15, 3369, 50, 3419, 'waribana-rechargement-1636023254', 'PENDING', '2021-11-04 10:54:14', '2021-11-04 10:54:14'),
(26, 15, 3369, 50, 3419, 'waribana-rechargement-1636023267', 'PENDING', '2021-11-04 10:54:27', '2021-11-04 10:54:27'),
(27, 15, 3369, 58, 3427, 'waribana-rechargement-1636023312', 'PENDING', '2021-11-04 10:55:13', '2021-11-04 10:55:13'),
(28, 15, 3369, 50, 3419, 'waribana-rechargement-1636023340', 'PENDING', '2021-11-04 10:55:41', '2021-11-04 10:55:41'),
(29, 15, 3369, 60, 3429, 'waribana-rechargement-1636023414', 'PENDING', '2021-11-04 10:56:54', '2021-11-04 10:56:54'),
(30, 15, 3369, 886, 4255, 'waribana-rechargement-1636023573', 'PENDING', '2021-11-04 10:59:33', '2021-11-04 10:59:33'),
(31, 15, 3369, 600, 3969, 'waribana-rechargement-1636023633', 'PENDING', '2021-11-04 11:00:33', '2021-11-04 11:00:33'),
(32, 15, 3319, 50, 3369, 'waribana-rechargement-1636023785', 'PENDING', '2021-11-04 11:03:06', '2021-11-04 11:03:06'),
(33, 15, 3159, 80, 3239, 'waribana-rechargement-1636024933', 'PENDING', '2021-11-04 11:22:13', '2021-11-04 11:22:13'),
(34, 15, 3159, 505, 3664, 'waribana-rechargement-1636024968', 'PENDING', '2021-11-04 11:22:48', '2021-11-04 11:22:48'),
(35, 15, 3159, 40, 3199, 'waribana-rechargement-1636025145', 'PENDING', '2021-11-04 11:25:45', '2021-11-04 11:25:45'),
(36, 15, 3159, 55, 3214, 'waribana-rechargement-1636028637', 'PENDING', '2021-11-04 12:23:58', '2021-11-04 12:23:58'),
(37, 15, 3159, 50, 3209, 'waribana-rechargement-1636029028', 'PENDING', '2021-11-04 12:30:29', '2021-11-04 12:30:29'),
(38, 7, 23560, 1000, 24560, 'waribana-rechargement-1636623938', 'PENDING', '2021-11-11 09:45:39', '2021-11-11 09:45:39'),
(39, 7, 22560, 5000, 27560, 'waribana-rechargement-1636634723', 'REFUSED', '2021-11-11 12:45:23', '2021-11-11 12:45:44'),
(40, 7, 22560, 5000, 27560, 'waribana-rechargement-1636634855', 'PENDING', '2021-11-11 12:47:35', '2021-11-11 12:47:35'),
(41, 7, 22560, 9000, 31560, 'waribana-rechargement-1636635033', 'REFUSED', '2021-11-11 12:50:33', '2021-11-11 12:51:01'),
(42, 7, 22560, 60000, 82560, 'waribana-rechargement-1636635505', 'REFUSED', '2021-11-11 12:58:25', '2021-11-11 12:58:59'),
(43, 7, 22560, 14664, 37224, 'waribana-rechargement-1636635621', 'PENDING', '2021-11-11 13:00:21', '2021-11-11 13:00:21'),
(44, 4, 0, 1000, 1000, 'waribana-rechargement-1637751417', 'PENDING', '2021-11-24 10:56:57', '2021-11-24 10:56:57'),
(45, 3, 0, 10000, 10000, 'waribana-rechargement-1638994535', 'PENDING', '2021-12-08 20:15:35', '2021-12-08 20:15:35'),
(46, 4, 0, 10000, 10000, 'waribana-rechargement-1642155193', 'PENDING', '2022-01-14 10:13:13', '2022-01-14 10:13:13'),
(47, 4, 0, 10000, 10000, 'waribana-rechargement-1642155316', 'PENDING', '2022-01-14 10:15:16', '2022-01-14 10:15:16'),
(48, 4, 0, 5000, 5000, 'waribana-rechargement-1642159403', 'PENDING', '2022-01-14 11:23:23', '2022-01-14 11:23:23'),
(49, 4, 0, 100, 100, 'waribana-rechargement-1643181691', 'PENDING', '2022-01-26 07:21:31', '2022-01-26 07:21:31'),
(50, 4, 0, 100, 100, 'waribana-rechargement-1643181817', 'PENDING', '2022-01-26 07:23:37', '2022-01-26 07:23:37'),
(51, 8, 0, 1000, 1000, 'waribana-rechargement-1643182994', 'PENDING', '2022-01-26 07:43:17', '2022-01-26 07:43:17'),
(52, 8, 0, 100, 100, 'waribana-rechargement-1643183056', 'PENDING', '2022-01-26 07:44:18', '2022-01-26 07:44:18'),
(53, 8, 0, 100, 100, 'waribana-rechargement-1643183379', 'PENDING', '2022-01-26 07:49:39', '2022-01-26 07:49:39'),
(54, 8, 0, 100, 100, 'waribana-rechargement-1643183433', 'PENDING', '2022-01-26 07:50:33', '2022-01-26 07:50:33'),
(55, 4, 0, 100, 100, 'waribana-rechargement-1643199124', 'ACCEPTED', '2022-01-26 12:12:04', '2022-01-26 12:23:27'),
(56, 3, 0, 100, 100, 'waribana-rechargement-1643754044', 'ACCEPTED', '2022-02-01 22:20:44', '2022-02-01 22:23:27'),
(57, 8, 0, 100, 100, 'waribana-rechargement-1643792235', 'ACCEPTED', '2022-02-02 08:57:15', '2022-02-02 09:01:15'),
(58, 8, 53, 100, 153, 'waribana-rechargement-1643802462', 'PENDING', '2022-02-02 11:47:43', '2022-02-02 11:47:43'),
(59, 3, 0, 1000, 1000, 'waribana-rechargement-1643818510', 'ACCEPTED', '2022-02-02 16:15:11', '2022-02-02 16:15:52'),
(60, 15, 1999, 46, 2045, 'waribana-rechargement-1643968228', 'REFUSED', '2022-02-04 09:50:28', '2022-02-04 09:56:47'),
(61, 15, 1999, 46, 2045, 'waribana-rechargement-1643968571', 'REFUSED', '2022-02-04 09:56:11', '2022-02-04 10:02:30'),
(62, 15, 1999, 5, 2004, 'waribana-rechargement-1643968636', 'PENDING', '2022-02-04 09:57:17', '2022-02-04 09:57:17'),
(63, 15, 1999, 5, 2004, 'waribana-rechargement-1643968637', 'REFUSED', '2022-02-04 09:57:18', '2022-02-04 10:03:41'),
(64, 15, 1999, 8, 2007, 'waribana-rechargement-1643968975', 'PENDING', '2022-02-04 10:02:55', '2022-02-04 10:02:55'),
(65, 15, 1999, 85, 2084, 'waribana-rechargement-1643969024', 'PENDING', '2022-02-04 10:03:44', '2022-02-04 10:03:44'),
(66, 15, 1999, 1, 2000, 'waribana-rechargement-1643969042', 'PENDING', '2022-02-04 10:04:03', '2022-02-04 10:04:03'),
(67, 15, 1999, 100, 2099, 'waribana-rechargement-1643969062', 'PENDING', '2022-02-04 10:04:22', '2022-02-04 10:04:22'),
(68, 15, 1999, 500, 2499, 'waribana-rechargement-1643969075', 'REFUSED', '2022-02-04 10:04:36', '2022-02-04 10:08:09'),
(69, 29, 0, 100, 100, 'waribana-rechargement-1644493699', 'PENDING', '2022-02-10 11:48:20', '2022-02-10 11:48:20');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_transfert_waribanks`
--

CREATE TABLE `transaction_transfert_waribanks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_menbre` int(11) NOT NULL,
  `id_destinataire` int(11) NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_monaie_expediteur` int(11) NOT NULL,
  `montant_equivalent_destinataire` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `transaction_transfert_waribanks`
--

INSERT INTO `transaction_transfert_waribanks` (`id`, `id_menbre`, `id_destinataire`, `telephone`, `montant_monaie_expediteur`, `montant_equivalent_destinataire`, `created_at`, `updated_at`) VALUES
(1, 15, 1, '2250778735784', 100, 117, '2021-10-25 13:23:28', '2021-10-25 13:23:28'),
(2, 15, 1, '2250778735784', 100, 117, '2021-10-25 13:36:18', '2021-10-25 13:36:18'),
(3, 15, 1, '2250778735784', 100, 117, '2021-10-25 13:38:26', '2021-10-25 13:38:26'),
(4, 15, 1, '2250778735784', 50, 58, '2021-10-25 13:48:26', '2021-10-25 13:48:26'),
(5, 15, 1, '2250778735784', 78, 91, '2021-10-25 13:57:59', '2021-10-25 13:57:59'),
(6, 19, 1, '2250778735784', 690, 1, '2021-10-26 15:41:43', '2021-10-26 15:41:43'),
(7, 19, 15, '2250555994041', 5000, 10, '2021-10-26 15:44:06', '2021-10-26 15:44:06'),
(8, 19, 15, '2250555994041', 5000, 10, '2021-10-26 15:46:27', '2021-10-26 15:46:27'),
(9, 19, 15, '2250555994041', 5000, 10, '2021-10-26 15:48:12', '2021-10-26 15:48:12'),
(10, 19, 15, '2250555994041', 5000, 10, '2021-10-26 15:49:34', '2021-10-26 15:49:34'),
(11, 19, 15, '2250555994041', 500, 1, '2021-10-26 15:51:01', '2021-10-26 15:51:01'),
(12, 19, 15, '2250555994041', 500, 1, '2021-10-26 15:52:46', '2021-10-26 15:52:46'),
(13, 19, 19, '2250565327653', 50, 50, '2021-10-26 15:59:13', '2021-10-26 15:59:13'),
(14, 19, 1, '2250778735784', 50, 0, '2021-10-26 16:00:16', '2021-10-26 16:00:16'),
(15, 19, 15, '2250555994041', 90, 0, '2021-10-26 16:00:42', '2021-10-26 16:00:42'),
(16, 7, 17, '2250170214740', 25000, 25000, '2021-10-29 14:06:54', '2021-10-29 14:06:54'),
(17, 15, 7, '2250758187266', 50, 32840, '2021-11-04 11:01:50', '2021-11-04 11:01:50'),
(18, 15, 7, '2250758187266', 50, 32840, '2021-11-04 11:06:49', '2021-11-04 11:06:49'),
(19, 15, 1, '2250778735784', 50, 58, '2021-11-04 11:08:02', '2021-11-04 11:08:02'),
(20, 15, 1, '2250778735784', 10, 12, '2021-11-04 11:10:47', '2021-11-04 11:10:47'),
(21, 15, 7, '2250758187266', 50, 32840, '2021-11-04 11:13:14', '2021-11-04 11:13:14'),
(22, 7, 17, '2250170214740', 1000, 1000, '2021-11-11 09:50:06', '2021-11-11 09:50:06'),
(23, 4, 8, '2250748216712', 50, 50, '2022-01-26 12:44:50', '2022-01-26 12:44:50'),
(24, 8, 4, '2250709779787', 50, 50, '2022-01-26 12:45:59', '2022-01-26 12:45:59'),
(25, 3, 8, '2250748216712', 50, 50, '2022-02-01 22:27:44', '2022-02-01 22:27:44'),
(26, 8, 4, '2250709779787', 50, 50, '2022-02-01 22:29:11', '2022-02-01 22:29:11'),
(27, 3, 4, '2250709779787', 50, 50, '2022-02-01 22:37:33', '2022-02-01 22:37:33'),
(28, 4, 3, '2250103570000', 100, 100, '2022-02-01 22:51:08', '2022-02-01 22:51:08'),
(29, 8, 4, '2250709779787', 50, 50, '2022-02-02 09:09:35', '2022-02-02 09:09:35'),
(30, 8, 4, '2250709779787', 10, 10, '2022-02-02 11:48:40', '2022-02-02 11:48:40'),
(31, 15, 1, '2250778735784', 78, 89, '2022-02-04 09:04:07', '2022-02-04 09:04:07'),
(32, 15, 1, '2250778735784', 5, 6, '2022-02-04 09:21:32', '2022-02-04 09:21:32'),
(33, 15, 1, '2250778735784', 1, 1, '2022-02-04 09:23:33', '2022-02-04 09:23:33'),
(34, 3, 8, '2250748216712', 300, 300, '2022-02-09 20:21:06', '2022-02-09 20:21:06'),
(35, 3, 29, '2250141863114', 200, 200, '2022-02-10 11:50:02', '2022-02-10 11:50:02'),
(36, 8, 4, '2250709779787', 50, 50, '2022-02-20 13:38:17', '2022-02-20 13:38:17'),
(37, 4, 8, '2250748216712', 50, 50, '2022-02-22 13:41:37', '2022-02-22 13:41:37'),
(38, 8, 4, '2250709779787', 50, 50, '2022-04-13 11:47:10', '2022-04-13 11:47:10'),
(39, 8, 4, '2250709779787', 25, 25, '2022-04-13 11:48:10', '2022-04-13 11:48:10');

-- --------------------------------------------------------

--
-- Structure de la table `transaction_waricrowds`
--

CREATE TABLE `transaction_waricrowds` (
  `id` bigint(20) NOT NULL,
  `id_menbre` bigint(20) UNSIGNED NOT NULL,
  `id_waricrowd` bigint(20) UNSIGNED NOT NULL,
  `montant` int(11) NOT NULL,
  `statut` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trans_id` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(20, 15, 1, 500, 'PENDING', 'waribana-waricrowd-1634919068', '2021-10-22 16:11:08', '2021-10-22 16:11:08'),
(21, 15, 6, 700, 'ACCEPTED', NULL, '2021-10-23 19:12:18', '2021-10-23 19:12:18'),
(22, 19, 2, 8000, 'ACCEPTED', NULL, '2021-10-27 09:18:58', '2021-10-27 09:18:58'),
(23, 19, 2, 13, 'ACCEPTED', NULL, '2021-10-27 09:21:20', '2021-10-27 09:21:20'),
(24, 19, 2, 500, 'ACCEPTED', NULL, '2021-10-27 09:23:23', '2021-10-27 09:23:23'),
(25, 19, 2, 300, 'ACCEPTED', NULL, '2021-10-27 09:25:26', '2021-10-27 09:25:26'),
(26, 19, 6, 5, 'ACCEPTED', NULL, '2021-10-27 10:25:16', '2021-10-27 10:25:16'),
(27, 7, 2, 1500, 'ACCEPTED', NULL, '2021-11-03 17:56:23', '2021-11-03 17:56:23'),
(28, 7, 6, 100, 'ACCEPTED', NULL, '2021-11-04 16:01:25', '2021-11-04 16:01:25'),
(29, 7, 6, 50, 'ACCEPTED', NULL, '2021-11-10 22:19:54', '2021-11-10 22:19:54'),
(30, 7, 2, 1000, 'ACCEPTED', NULL, '2021-11-29 09:44:21', '2021-11-29 09:44:21'),
(31, 15, 6, 888, 'ACCEPTED', NULL, '2021-11-30 11:49:30', '2021-11-30 11:49:30'),
(32, 15, 6, 88, 'ACCEPTED', NULL, '2021-12-01 10:48:17', '2021-12-01 10:48:17'),
(33, 7, 2, 50, 'ACCEPTED', NULL, '2021-12-09 10:08:45', '2021-12-09 10:08:45'),
(34, 4, 21, 50, 'ACCEPTED', NULL, '2022-01-26 12:47:40', '2022-01-26 12:47:40'),
(35, 8, 23, 10, 'ACCEPTED', NULL, '2022-02-02 09:50:32', '2022-02-02 09:50:32'),
(36, 4, 24, 10, 'ACCEPTED', NULL, '2022-02-02 09:57:40', '2022-02-02 09:57:40'),
(37, 8, 24, 10, 'ACCEPTED', NULL, '2022-02-02 11:45:22', '2022-02-02 11:45:22'),
(38, 15, 26, 45, 'ACCEPTED', NULL, '2022-02-04 12:12:10', '2022-02-04 12:12:10'),
(39, 3, 24, 80, 'ACCEPTED', NULL, '2022-02-07 16:29:30', '2022-02-07 16:29:30'),
(40, 28, 26, 1500, 'ACCEPTED', NULL, '2022-02-07 16:31:26', '2022-02-07 16:31:26'),
(41, 4, 24, 5, 'ACCEPTED', NULL, '2022-02-07 16:33:08', '2022-02-07 16:33:08'),
(42, 28, 26, 10, 'ACCEPTED', NULL, '2022-02-07 17:14:02', '2022-02-07 17:14:02'),
(43, 28, 26, 10, 'ACCEPTED', NULL, '2022-02-07 17:20:14', '2022-02-07 17:20:14'),
(44, 28, 26, 10, 'ACCEPTED', NULL, '2022-02-07 17:26:25', '2022-02-07 17:26:25');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('gestionnaire_de_tontine','gestionnaire_de_waricrowd','administrateur_general','super_admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` enum('actif','suspendu') COLLATE utf8mb4_unicode_ci NOT NULL,
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

INSERT INTO `users` (`id`, `role`, `etat`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'super_admin', 'actif', 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$eorYXnL56CcllRD47BziJOa9k/zGKYF6.yKkPVyyqP0Va.xm.2Xwa', NULL, NULL, NULL, NULL, NULL, '2021-10-05 11:05:22', '2022-02-08 18:47:54'),
(3, 'gestionnaire_de_waricrowd', 'actif', 'Gestionnaire de crowd', 'crowd@gmail.com', NULL, '$2y$10$.HwM82bSfQkca7n98uoAq.O31IWElIzzIcnevdauD4mLR46yN/VfW', NULL, NULL, NULL, NULL, NULL, '2022-02-08 18:58:16', '2022-02-08 18:58:16'),
(4, 'gestionnaire_de_tontine', 'actif', 'gestionnaire elegant', 'gestontine@gmail.com', NULL, '$2y$10$AOy..kI6fvN36RQ/MPUrx.5N2xAU5Yf/oVBF.68C3i5MZwHavXZ2i', NULL, NULL, NULL, NULL, NULL, '2022-02-08 19:01:00', '2022-02-08 19:01:00'),
(5, 'administrateur_general', 'actif', 'WHouedanou', 'whouedanou@recyplast.ci', NULL, '$2y$10$xdW4Wg7bsj3SDPtQQAk/F.I9QONd42tQoFkAybc5Baz7TSG1JHPVO', NULL, NULL, NULL, NULL, NULL, '2022-02-20 23:21:08', '2022-02-20 23:21:08'),
(6, 'gestionnaire_de_waricrowd', 'actif', 'yves santoz', 'yvesladde@gmail.com', NULL, '$2y$10$1JzCkmbk6aspn3ehR2i0N.6iLShf2BA1laEpb2g/H2Gw1RZfHGOrG', NULL, NULL, NULL, NULL, NULL, '2022-02-21 20:17:57', '2022-02-21 20:17:57');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowds`
--

CREATE TABLE `waricrowds` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowds`
--

INSERT INTO `waricrowds` (`id`, `id_categorie`, `id_menbre`, `titre`, `description_courte`, `description_complete`, `montant_objectif`, `lien_pitch_video`, `image_illustration`, `etat`, `motif_intervention_admin`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'jcvck', 'Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page', 'here are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.\r\n\r\nhere are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 2322, 'https://www.youtube.com/embed/DzH5aRoMYLw', 'images/waricrowd/111222.png', 'attente', NULL, '2021-10-07 15:07:12', '2021-12-14 22:59:44'),
(2, '1', 4, 'TEST ECONOMIE', 'Juste un test', 'ceci est un test, Juste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un testJuste un test', 50000000, 'https://www.youtube.com/embed/fyqQmh35vQc&list=RDfyqQmh35vQc&start_radio=1', 'images/waricrowd/111222.png', 'attente', NULL, '2021-10-13 11:13:01', '2021-12-14 23:00:06'),
(3, '2', 14, 'dfsd', '23', 'assa', 2332, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-18 03:25:35', '2021-10-18 03:25:35'),
(5, '1', 14, 'titr', 'gjjhlm courte', 'hvjjnbj complète', 5698, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-18 13:05:49', '2021-10-18 13:05:49'),
(6, '3', 14, 'agro', 'desc courte', 'desc long', 5000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-10-18 13:15:27', '2021-10-18 13:50:01'),
(7, '2', 15, 'WC informatique', 'hjk', 'hvvu uuNkkk kllkk nkl kl', 560000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', NULL, '2021-10-19 14:50:50', '2021-10-19 14:50:50'),
(15, '2', 7, 'Facebook cote d\'ivoire', 'test', 'test', 150000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-10-29 13:53:04', '2021-10-29 13:53:04'),
(17, '1', 7, 'test wari', 'test', 'test', 500000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-11-11 09:59:48', '2021-11-11 09:59:48'),
(18, '1', 4, 'Test du 23 novembre', 'test test', 'test test test', 1000000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-11-24 10:58:18', '2021-11-24 10:58:18'),
(19, '1', 7, 'test', 'test', 'test', 4000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2021-12-09 10:14:36', '2021-12-09 10:14:36'),
(20, '3', 4, 'MONCADDY', 'Faire ses courses en ligne', 'Faire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligneFaire ses courses en ligne', 50000000, NULL, 'images/waricrowd/16114510_1161076757342676_5433366904050244629_n.png', 'valider', NULL, '2021-12-14 22:49:02', '2021-12-14 22:49:31'),
(21, '4', 4, 'HENMA DREAM', 'Univers Bébé', 'Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé Univers Bébé', 10000000, NULL, 'images/waricrowd/Logo---Henma-Dream-bg-bleu.jpg', 'valider', NULL, '2021-12-14 22:54:30', '2021-12-14 23:09:13'),
(22, '1', 4, 'FINANCE REC', 'FOND DE GARANTIE', 'FOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIEFOND DE GARANTIE', 200000000, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2022-01-13 18:35:47', '2022-01-13 18:35:47'),
(23, '2', 4, 'HUBESRON KOFFI', 'TEST DE CREATION DE WARICROWD', 'TEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWDTEST DE CREATION DE WARICROWD', 10000000, NULL, 'images/waricrowd/Screen Shot 2022-02-02 at 09.09.46.png', 'annuler', 'Projet annulé', '2022-02-02 09:37:33', '2022-02-07 16:27:08'),
(24, '4', 8, 'TEST BEBE', 'TEST TEST', 'TESTTEST TESTSTESTS TEA TLKD LQ', 100, NULL, 'images/waricrowd/statiques/crowfunding.png', 'valider', 'OK', '2022-02-02 09:56:31', '2022-02-02 09:57:20'),
(25, '1', 8, 'waricrowd mobile', 'OK', 'OK OK', 100, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2022-02-02 11:51:15', '2022-02-02 11:51:15'),
(26, '5', 15, 'petrole', 'jhjh', 'jhjkhjk', 7899, NULL, 'images/waricrowd/612XOrMLP9L._AC_SX425_.jpg', 'terminer', NULL, '2022-02-04 12:00:38', '2022-02-09 21:43:53'),
(27, '3', 15, 'hgj', 'hgjg', 'hgj', 7565, 'https://www.youtube.com/embed/pam8E1BR-Vw', 'images/waricrowd/0000.PNG', 'attente', NULL, '2022-02-08 15:45:26', '2022-02-08 15:45:26'),
(28, '4', 15, 'Modif admin', 'hgjg', 'hgj', 7565, 'https://www.youtube.com/embed/1pBi56GJ-0w', 'images/waricrowd/0000.PNG', 'attente', NULL, '2022-02-08 15:45:26', '2022-02-08 16:17:55'),
(29, '4', 15, 'jfjhf', 'HIFK ccc', 'fff', 985, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2022-02-09 00:24:12', '2022-02-09 00:24:12'),
(30, '1', 15, 'gg', 'ggg', 'ccc', 55, NULL, 'images/waricrowd/statiques/crowfunding.png', 'attente', NULL, '2022-02-09 13:35:29', '2022-02-09 13:35:29');

-- --------------------------------------------------------

--
-- Structure de la table `waricrowd_menbres`
--

CREATE TABLE `waricrowd_menbres` (
  `id` bigint(11) NOT NULL,
  `menbre_id` bigint(20) UNSIGNED NOT NULL,
  `waricrowd_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `waricrowd_menbres`
--

INSERT INTO `waricrowd_menbres` (`id`, `menbre_id`, `waricrowd_id`, `created_at`, `updated_at`) VALUES
(1, 14, 2, '2021-10-18 17:35:50', '2021-10-18 17:35:50'),
(4, 15, 6, '2021-10-23 19:12:18', '2021-10-23 19:12:18'),
(5, 19, 2, '2021-10-27 09:21:20', '2021-10-27 09:21:20'),
(6, 19, 6, '2021-10-27 10:25:16', '2021-10-27 10:25:16'),
(7, 7, 2, '2021-11-03 17:56:23', '2021-11-03 17:56:23'),
(8, 7, 6, '2021-11-04 16:01:25', '2021-11-04 16:01:25'),
(9, 4, 21, '2022-01-26 12:47:40', '2022-01-26 12:47:40'),
(10, 8, 23, '2022-02-02 09:50:32', '2022-02-02 09:50:32'),
(11, 4, 24, '2022-02-02 09:57:40', '2022-02-02 09:57:40'),
(12, 8, 24, '2022-02-02 11:45:22', '2022-02-02 11:45:22'),
(13, 15, 26, '2022-02-04 12:12:10', '2022-02-04 12:12:10'),
(14, 3, 24, '2022-02-07 16:29:30', '2022-02-07 16:29:30'),
(15, 28, 26, '2022-02-07 16:31:26', '2022-02-07 16:31:26');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cahier_compte_tontines`
--
ALTER TABLE `cahier_compte_tontines`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `cahier_retrait_solde_menbres`
--
ALTER TABLE `cahier_retrait_solde_menbres`
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
-- Index pour la table `devises`
--
ALTER TABLE `devises`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `devises_code_unique` (`code`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `historique_modif_profil_membres`
--
ALTER TABLE `historique_modif_profil_membres`
  ADD PRIMARY KEY (`id`);

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
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
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
-- Index pour la table `transaction_rechargement_waribanks`
--
ALTER TABLE `transaction_rechargement_waribanks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transaction_transfert_waribanks`
--
ALTER TABLE `transaction_transfert_waribanks`
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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `cahier_retrait_solde_menbres`
--
ALTER TABLE `cahier_retrait_solde_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `caisse_tontines`
--
ALTER TABLE `caisse_tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `caisse_waricrowds`
--
ALTER TABLE `caisse_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `categorie_waricrowds`
--
ALTER TABLE `categorie_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `chat_tontine_messages`
--
ALTER TABLE `chat_tontine_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `compte_menbres`
--
ALTER TABLE `compte_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `devises`
--
ALTER TABLE `devises`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `historique_modif_profil_membres`
--
ALTER TABLE `historique_modif_profil_membres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT pour la table `menbres`
--
ALTER TABLE `menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `menbre_tontine`
--
ALTER TABLE `menbre_tontine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tontines`
--
ALTER TABLE `tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT pour la table `transaction_rechargement_waribanks`
--
ALTER TABLE `transaction_rechargement_waribanks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT pour la table `transaction_transfert_waribanks`
--
ALTER TABLE `transaction_transfert_waribanks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `transaction_waricrowds`
--
ALTER TABLE `transaction_waricrowds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `waricrowds`
--
ALTER TABLE `waricrowds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `waricrowd_menbres`
--
ALTER TABLE `waricrowd_menbres`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
