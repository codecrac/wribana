-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : jeu. 07 oct. 2021 à 13:23
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
  `montant` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `index_ouverture` int(11) NOT NULL DEFAULT 1,
  `prochaine_date_encaissement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(2, 'Informatique', '2021-10-07 12:44:59', '2021-10-07 12:44:59');

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
(1, 1, 0, '2021-10-07 13:01:48', '2021-10-07 13:01:48');

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
  `code_postal` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `menbres`
--

INSERT INTO `menbres` (`id`, `nom_complet`, `telephone`, `email`, `mot_de_passe`, `etat`, `motif_intervention_admin`, `date_derniere_visite`, `devise`, `code_de_confirmation`, `created_at`, `updated_at`, `pays`, `ville`, `adresse`, `etat_us`, `code_postal`) VALUES
(1, 'yves santoz', '2250778735784', NULL, 'e09cfacc420a00e8a136a4773c457090', 'actif', NULL, NULL, '2', 1387, '2021-10-07 13:01:48', '2021-10-07 13:10:49', 'ci', 'abidjan', 'cocody palmeraie', NULL, NULL);

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
(25, '2021_10_06_123738_create_cahier_retrait_solde_menbres_table', 2);

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
('3EMHue7GBxV1IEvhTerp0ULR58NGNu1d0VuQ0QDe', NULL, '160.155.231.108', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejd2MzFNQTU5cFRRcWRVSXNmRm1iV3FEakNYcmVTNjYyaEN1NW9DeSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2luc2NyaXB0aW9uLW1lbmJyZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1633611119),
('7OzWEU3Di3ttOqUUkywKgzzR1j24VenanynL4rhl', NULL, '38.108.182.5', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.72 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidDVoSnl5d2JXZFRNeERscEczZzVCMFdOUm44STJpWkNqMEdRWUREaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly93YXJpYmFuYS5uZXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1633611540),
('aORe9IqN1mDcpYGuAioZCcsW8HtWgZH85JQfWIcs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEd4WjdwNmFDaVBnMUtYNXF5NTJCTjhCbEhmekFwZHpTeFBZVmJ6OCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1633602418),
('dA7Iv4F8dJHg8RTDCeWntsXWRLqfSEQu9zCNtbn3', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibE5XeThDSXc4TjRFM0xVRHlkakQyNXpHVHRCZ1d1VXdVR0N1MklrMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wcm9qZXRzLXdhcmljcm93ZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1633608346),
('dXF4Uc4IezcYr4ZkQOifQQHkDW05Z2wnvPO3DKMf', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiS25OYnRVN0dQSkhVTHFKalVSdjkwMkhrVEhkakJxbnBoZ0thT1EwNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9lc3BhY2UtbWVuYnJlL2RldGFpbHMtdG9udGluZXMvNiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjU6Im1lbmJyZV93YXJpYmFuYV9jb25uZWN0ZXIiO2E6NDp7czoyOiJpZCI7aTozO3M6MTE6Im5vbV9jb21wbGV0IjtzOjE1OiJtb3ppbGxhIGZpcmVmb3giO3M6NjoiZGV2aXNlIjtzOjg6ImRvbGxhcmRzIjtzOjExOiJjb2RlX2RldmlzZSI7czozOiJVU0QiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTAkLzJBNlliNzlGdmkwMnlpazk1T2pxLlp2OFl1WVpyZi4xMTlVM2pxRVAvbGpJMmdQV1A3QzIiO3M6MjE6InBhc3N3b3JkX2hhc2hfc2FuY3R1bSI7czo2MDoiJDJ5JDEwJC8yQTZZYjc5RnZpMDJ5aWs5NU9qcS5adjhZdVlacmYuMTE5VTNqcUVQL2xqSTJnUFdQN0MyIjt9', 1633608094),
('FBBLiwmYVfl4Fipzb7ruQIgehn8qXpUcZgYHPgHi', NULL, '160.155.231.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:92.0) Gecko/20100101 Firefox/92.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRHRZUGFWelNlWGNmZHRsZEpBaFdDallCbDVyVnVESFYzMlhCVzJYcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly93YXJpYmFuYS5uZXQvZXNwYWNlLW1lbmJyZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MjU6Im1lbmJyZV93YXJpYmFuYV9jb25uZWN0ZXIiO2E6NDp7czoyOiJpZCI7aToxO3M6MTE6Im5vbV9jb21wbGV0IjtzOjExOiJ5dmVzIHNhbnRveiI7czo2OiJkZXZpc2UiO3M6ODoiZG9sbGFyZHMiO3M6MTE6ImNvZGVfZGV2aXNlIjtzOjM6IlVTRCI7fX0=', 1633612250),
('i2w2Gnlq38kZ5OTGuuD4DEYAFicYLH2Z88zmz2qV', NULL, '160.155.231.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.71 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU3prQWZ3MTg1a2FDVHFlaVBhallSY2UxS2hmMXBvWDB2MlltclBCVSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2luc2NyaXB0aW9uLW1lbmJyZSI7fX0=', 1633612894),
('SpBNbaq2v9ZuYdxom5V005DOSs34oWx5wRAn2bpa', NULL, '154.0.29.4', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMENTSVJGa1prQzNmTlU4bFZnWTk1dWJqQkZlR1ZhVU5YQ1lPTmlQMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHBzOi8vd2FyaWJhbmEubmV0L2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1633610130),
('SST2yRAAUUj8F1sxDArpkywmvM09XZ0KGiQqDvfK', NULL, '69.25.58.56', 'Mozilla/5.0 (Windows N\\T 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.16', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnRseDM5Z2M2cDAyaEtSZGlDMU1EUHloYzZ5ZExjcDRlOGVjcWJuTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTk6Imh0dHA6Ly93YXJpYmFuYS5uZXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1633610224);

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
(1, 'Bienvenu(e) sur waribana, votre code de confirmation est le suivant $code$', 'Bonjour votre waricrowd intitule <<$titre$>> a été : $etat$ $motif$', 'Bonjour, le menbre $nom_complet$ de waribana vous invite a rejoindre la tontine << $titre_tontine$ >>, Connectez vous inscrivez-vous pour repondre a son invitation', 'Bonjour votre tontine intitule <<$titre$>> est : $etat$ $motif$ ', 'Bonjour, montant de cotisation atteinds sur tontine << $titre_tontine$ >>, virement effectue au menbre : $nom_menbre_qui_prend$ ', 'Bonjour, des cotisations en retard sur la tontine << $titre$ >>; retardataires : $liste_retardataires$ ', '2021-10-07 12:44:03', '2021-10-07 12:44:03');

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
(1, '10/2021', '10/2021', 6, '2021-10-07 12:35:00', '2021-10-07 12:59:00');

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
(1, 'Super Admin', 'admin@gmail.com', NULL, '$2y$10$/2A6Yb79Fvi02yik95Ojq.Zv8YuYZrf.119U3jqEP/ljI2gPWP7C2', NULL, NULL, NULL, NULL, NULL, '2021-10-05 11:05:22', '2021-10-05 11:05:22');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `cahier_retrait_solde_menbres`
--
ALTER TABLE `cahier_retrait_solde_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `caisse_tontines`
--
ALTER TABLE `caisse_tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `caisse_waricrowds`
--
ALTER TABLE `caisse_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `categorie_waricrowds`
--
ALTER TABLE `categorie_waricrowds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `chat_tontine_messages`
--
ALTER TABLE `chat_tontine_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `compte_menbres`
--
ALTER TABLE `compte_menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT pour la table `invitations`
--
ALTER TABLE `invitations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `menbres`
--
ALTER TABLE `menbres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `menbre_tontine`
--
ALTER TABLE `menbre_tontine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `tontines`
--
ALTER TABLE `tontines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `transaction_waricrowds`
--
ALTER TABLE `transaction_waricrowds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waricrowds`
--
ALTER TABLE `waricrowds`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `waricrowd_menbres`
--
ALTER TABLE `waricrowd_menbres`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
