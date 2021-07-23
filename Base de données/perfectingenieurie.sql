-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 23 juil. 2021 à 17:32
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `perfectingenieurie`
--
CREATE DATABASE `perfectingenieurie`;
-- --------------------------------------------------------

--
-- Structure de la table `avoir_cours_mots_cles`
--

CREATE TABLE `avoir_cours_mots_cles` (
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `id_mot_cle` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_formations_mots_cles`
--

CREATE TABLE `avoir_formations_mots_cles` (
  `id_formation` bigint(20) UNSIGNED NOT NULL,
  `id_mot_cle` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_preferences`
--

CREATE TABLE `avoir_preferences` (
  `id_stagiaire` bigint(20) UNSIGNED NOT NULL,
  `id_mot_cle` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'Informatique', '2021-07-20 06:50:36', '2021-07-20 06:50:36'),
(2, 'Management', '2021-07-20 07:11:06', '2021-07-20 07:11:06');

-- --------------------------------------------------------

--
-- Structure de la table `chapitres`
--

CREATE TABLE `chapitres` (
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `numero_chapitre` int(10) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chapitres`
--

INSERT INTO `chapitres` (`id_chapitre`, `numero_chapitre`, `designation`, `image`, `video`, `etat`, `id_cours`, `created_at`, `updated_at`) VALUES
(12345678, 1, 'mamp', 'mamp.png', '607d86ffe4ac3.mp4', 0, 95027475, '2021-07-23 06:00:57', '2021-07-23 06:00:57');

-- --------------------------------------------------------

--
-- Structure de la table `contenir_documents_chapitres`
--

CREATE TABLE `contenir_documents_chapitres` (
  `id_proj` bigint(20) UNSIGNED NOT NULL,
  `id_doc` bigint(20) UNSIGNED NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `contenir_documents_projets`
--

CREATE TABLE `contenir_documents_projets` (
  `id_projet` bigint(20) UNSIGNED NOT NULL,
  `id_document` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cours`
--

CREATE TABLE `cours` (
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_chapitres` int(11) NOT NULL,
  `prix` double(8,2) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `formateur` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cours`
--

INSERT INTO `cours` (`id_cours`, `designation`, `image`, `nombre_chapitres`, `prix`, `etat`, `formateur`, `created_at`, `updated_at`) VALUES
(43855550, 'phpC2N2', NULL, 0, 2.00, 0, 1, '2021-07-23 12:31:04', '2021-07-23 12:31:04'),
(78750127, 'phpC2N1', NULL, 0, 1.00, 0, 1, '2021-07-23 12:30:53', '2021-07-23 12:30:53'),
(95027475, 'Les sessions', '1626963126session.png', 0, 100.00, 1, 1, '2021-07-22 10:12:06', '2021-07-23 08:06:36'),
(95597804, 'phpC3N4', NULL, 0, 1.00, 0, 1, '2021-07-23 13:03:12', '2021-07-23 13:03:12');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lien` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `exercices`
--

CREATE TABLE `exercices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `enonce` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `faire_projets`
--

CREATE TABLE `faire_projets` (
  `id_projet` bigint(20) UNSIGNED NOT NULL,
  `id_stagiaire` bigint(20) UNSIGNED NOT NULL,
  `statut_reussite` tinyint(1) DEFAULT NULL,
  `resultat_description` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formateurs`
--

CREATE TABLE `formateurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parcours` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cv` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formateurs`
--

INSERT INTO `formateurs` (`id`, `nom`, `prenom`, `parcours`, `cv`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'doe', 'john', '', '', 4, '2021-07-22 10:59:56', '2021-07-22 10:59:56');

-- --------------------------------------------------------

--
-- Structure de la table `formations`
--

CREATE TABLE `formations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `libelle` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `volume_horaire` int(11) NOT NULL,
  `nombre_cours_total` int(11) NOT NULL,
  `nombre_chapitre_total` int(11) NOT NULL,
  `reference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prix` int(11) NOT NULL,
  `userRef` int(11) DEFAULT NULL,
  `_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `_method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations`
--

INSERT INTO `formations` (`id`, `libelle`, `description`, `image`, `volume_horaire`, `nombre_cours_total`, `nombre_chapitre_total`, `reference`, `prix`, `userRef`, `_token`, `_method`, `etat`, `categorie_id`, `created_at`, `updated_at`) VALUES
(31088407, 'PHP', 'php', NULL, 20, 3, 0, '1', 1000, 5, 'xDMk57fgbIuBl9EEsnlRKinbyOLQrpMeuTaldPaB', 'PUT', 0, 1, '2021-07-22 03:15:40', '2021-07-23 13:03:31'),
(55387986, 'java', 'java', NULL, 20, 0, 0, '1', 1, 4, NULL, NULL, 0, 1, '2021-07-23 11:05:16', '2021-07-23 13:03:32');

-- --------------------------------------------------------

--
-- Structure de la table `formations_contenir_cours`
--

CREATE TABLE `formations_contenir_cours` (
  `id_formation` bigint(20) UNSIGNED NOT NULL,
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `numero_cours` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `formations_contenir_cours`
--

INSERT INTO `formations_contenir_cours` (`id_formation`, `id_cours`, `numero_cours`, `created_at`, `updated_at`) VALUES
(31088407, 43855550, 2, '2021-07-23 12:31:04', '2021-07-23 12:31:04'),
(31088407, 78750127, 1, '2021-07-23 12:30:53', '2021-07-23 12:30:53'),
(31088407, 95597804, 3, '2021-07-23 13:03:12', '2021-07-23 13:03:32');

-- --------------------------------------------------------

--
-- Structure de la table `lier_sessions_stagiaires`
--

CREATE TABLE `lier_sessions_stagiaires` (
  `id_session` bigint(20) UNSIGNED NOT NULL,
  `id_stagiaire` bigint(20) UNSIGNED NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `validation` tinyint(1) DEFAULT NULL,
  `resultat_description` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `meeting_en_lignes`
--

CREATE TABLE `meeting_en_lignes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_meeting` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `statut_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `id_cours` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2021_07_15_000001_create_role_table', 1),
(4, '2021_07_15_000002_create_users_table', 1),
(5, '2021_07_15_000003_create_formateur_table', 1),
(6, '2021_07_15_000004_create_categorie_table', 1),
(7, '2021_07_15_000005_create_formation_table', 1),
(8, '2021_07_15_000006_create_type_inscription_table', 1),
(9, '2021_07_15_000007_create_organisation_table', 1),
(10, '2021_07_15_000008_create_stagiaire_table', 1),
(11, '2021_07_15_000009_create_cours_table', 1),
(12, '2021_07_15_000010_create_chapitre_table', 1),
(13, '2021_07_15_000011_create_section_table', 1),
(14, '2021_07_15_000012_create_exercice_table', 1),
(15, '2021_07_15_000013_create_question_exercice_table', 1),
(16, '2021_07_15_000014_create_question_correction_table', 1),
(17, '2021_07_15_000015_create_qcm_table', 1),
(18, '2021_07_15_000016_create_question_qcm_table', 1),
(19, '2021_07_15_000017_create_reponse_question_qcm_table', 1),
(20, '2021_07_15_000018_create_score_qcm_table', 1),
(21, '2021_07_15_000019_create_statut_table', 1),
(22, '2021_07_15_000020_create_projet_table', 1),
(23, '2021_07_15_000021_create_faire_projet_table', 1),
(24, '2021_07_15_000022_create_document_table', 1),
(25, '2021_07_15_000023_create_contenir_document_projet_table', 1),
(26, '2021_07_15_000024_create_contenir_document_chapitre_table', 1),
(27, '2021_07_15_000025_create_meeting_en_ligne_table', 1),
(28, '2021_07_15_000026_create_participer_meeting_table', 1),
(29, '2021_07_15_000027_create_mot_cle_table', 1),
(30, '2021_07_15_000028_create_avoir_formations_mot_cle_table', 1),
(31, '2021_07_15_000029_create_avoir_cours_mot_cle_table', 1),
(32, '2021_07_15_000030_create_avoir_preference_table', 1),
(33, '2021_07_15_000031_create_suivre_formations_table', 1),
(34, '2021_07_15_000032_create_suivre_cours_table', 1),
(35, '2021_07_15_000033_create_session_table', 1),
(36, '2021_07_15_000034_create_lier_session_stagiaire_table', 1),
(37, '2021_07_15_000035_create_titre_table', 1),
(38, '2021_07_15_000036_create_formations_contenir_cours_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mots_cles`
--

CREATE TABLE `mots_cles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `organisations`
--

CREATE TABLE `organisations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participer_meetings`
--

CREATE TABLE `participer_meetings` (
  `id_utilisateur` bigint(20) UNSIGNED NOT NULL,
  `id_meeting` bigint(20) UNSIGNED NOT NULL,
  `valiadtion` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `formateur_id` bigint(20) UNSIGNED NOT NULL,
  `id_cours` bigint(20) UNSIGNED DEFAULT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

CREATE TABLE `qcm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions_corrections`
--

CREATE TABLE `questions_corrections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reponse` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `question_exercice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions_exercices`
--

CREATE TABLE `questions_exercices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `exercice_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_qcm`
--

CREATE TABLE `question_qcm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `explication` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `qcm_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reponse_question_qcm`
--

CREATE TABLE `reponse_question_qcm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reponse` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `validation` tinyint(1) NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `question_qcm_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Centre', NULL, NULL),
(3, 'Stagiaire', NULL, NULL),
(4, 'Formateur', NULL, NULL),
(5, 'Organisme', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `score_qcm`
--

CREATE TABLE `score_qcm` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resultat` int(11) NOT NULL,
  `stagiaire_id` bigint(20) UNSIGNED NOT NULL,
  `qcm_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenu` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `etat` tinyint(1) NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `etat` tinyint(1) NOT NULL,
  `formateur_id` bigint(20) UNSIGNED NOT NULL,
  `formations_id` bigint(20) UNSIGNED NOT NULL,
  `statut_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `stagiaires`
--

CREATE TABLE `stagiaires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `formateur_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_inscription_id` bigint(20) UNSIGNED DEFAULT NULL,
  `organisation_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `statut`
--

CREATE TABLE `statut` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `statut` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `statut`
--

INSERT INTO `statut` (`id`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'Non débuté', NULL, NULL),
(2, 'Non débutée', NULL, NULL),
(3, 'En cours', NULL, NULL),
(4, 'Terminé', NULL, NULL),
(5, 'Terminée', NULL, NULL),
(6, 'Annulé', NULL, NULL),
(7, 'Annulée', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `suivre_cours`
--

CREATE TABLE `suivre_cours` (
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `id_stagiaire` bigint(20) UNSIGNED NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `nombre_chapitre_lu` int(11) NOT NULL,
  `progression` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivre_formations`
--

CREATE TABLE `suivre_formations` (
  `id_stagiaire` bigint(20) UNSIGNED NOT NULL,
  `id_formations` bigint(20) UNSIGNED NOT NULL,
  `id_cours` bigint(20) UNSIGNED NOT NULL,
  `id_chapitre` bigint(20) UNSIGNED NOT NULL,
  `nombre_chapitre_lu` int(11) NOT NULL,
  `progression` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `titres`
--

CREATE TABLE `titres` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intitule` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_obtention` date NOT NULL,
  `stagiaire_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types_inscriptions`
--

CREATE TABLE `types_inscriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status_id` int(11) DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `preference` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `image`, `name`, `status_id`, `email`, `email_verified_at`, `password`, `role_id`, `preference`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'malek', NULL, 'mt@gmail.com', NULL, '$2y$10$vS3kiCg0ALi9kVXRhAoAkOG42AguL2W1If6Z7V2BihowhQjwFPSVS', 3, NULL, NULL, '2021-07-22 03:13:56', '2021-07-22 03:13:56'),
(2, NULL, 'formation', NULL, 'formation@gmail.com', NULL, '$2y$10$pHNxyHEB7bdIdYVX0lIKJeSWlqTUAsELsnrOxrnnSmSk8oY8KADWK', 2, NULL, NULL, '2021-07-22 03:14:58', '2021-07-22 03:14:58'),
(3, NULL, 'admin', NULL, 'admin@gmail.com', NULL, '$2y$10$pHNxyHEB7bdIdYVX0lIKJeSWlqTUAsELsnrOxrnnSmSk8oY8KADWK', 1, NULL, NULL, '2021-07-22 05:16:30', '2021-07-22 05:16:30'),
(4, NULL, 'doe', NULL, 'doe@gmail.com', NULL, '$2y$10$pHNxyHEB7bdIdYVX0lIKJeSWlqTUAsELsnrOxrnnSmSk8oY8KADWK', 4, NULL, NULL, '2021-07-22 10:58:40', '2021-07-22 10:58:40');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `avoir_cours_mots_cles`
--
ALTER TABLE `avoir_cours_mots_cles`
  ADD PRIMARY KEY (`id_cours`,`id_mot_cle`),
  ADD KEY `avoir_cours_mots_cles_id_mot_cle_foreign` (`id_mot_cle`);

--
-- Index pour la table `avoir_formations_mots_cles`
--
ALTER TABLE `avoir_formations_mots_cles`
  ADD PRIMARY KEY (`id_formation`,`id_mot_cle`),
  ADD KEY `avoir_formations_mots_cles_id_mot_cle_foreign` (`id_mot_cle`);

--
-- Index pour la table `avoir_preferences`
--
ALTER TABLE `avoir_preferences`
  ADD PRIMARY KEY (`id_stagiaire`,`id_mot_cle`),
  ADD KEY `avoir_preferences_id_mot_cle_foreign` (`id_mot_cle`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chapitres`
--
ALTER TABLE `chapitres`
  ADD PRIMARY KEY (`id_chapitre`,`numero_chapitre`),
  ADD KEY `chapitres_id_cours_foreign` (`id_cours`);

--
-- Index pour la table `contenir_documents_chapitres`
--
ALTER TABLE `contenir_documents_chapitres`
  ADD PRIMARY KEY (`id_proj`,`id_doc`,`id_chapitre`),
  ADD KEY `contenir_documents_chapitres_id_doc_foreign` (`id_doc`),
  ADD KEY `contenir_documents_chapitres_id_chapitre_foreign` (`id_chapitre`);

--
-- Index pour la table `contenir_documents_projets`
--
ALTER TABLE `contenir_documents_projets`
  ADD PRIMARY KEY (`id_projet`,`id_document`),
  ADD KEY `contenir_documents_projets_id_document_foreign` (`id_document`);

--
-- Index pour la table `cours`
--
ALTER TABLE `cours`
  ADD PRIMARY KEY (`id_cours`),
  ADD KEY `cours_formateur_index` (`formateur`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exercices_id_chapitre_index` (`id_chapitre`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `faire_projets`
--
ALTER TABLE `faire_projets`
  ADD PRIMARY KEY (`id_projet`,`id_stagiaire`),
  ADD KEY `faire_projets_id_stagiaire_foreign` (`id_stagiaire`);

--
-- Index pour la table `formateurs`
--
ALTER TABLE `formateurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formateurs_user_id_index` (`user_id`);

--
-- Index pour la table `formations`
--
ALTER TABLE `formations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `formations_categorie_id_index` (`categorie_id`);

--
-- Index pour la table `formations_contenir_cours`
--
ALTER TABLE `formations_contenir_cours`
  ADD PRIMARY KEY (`id_formation`,`id_cours`),
  ADD KEY `formations_contenir_cours_id_cours_foreign` (`id_cours`);

--
-- Index pour la table `lier_sessions_stagiaires`
--
ALTER TABLE `lier_sessions_stagiaires`
  ADD PRIMARY KEY (`id_session`,`id_stagiaire`),
  ADD KEY `lier_sessions_stagiaires_id_stagiaire_foreign` (`id_stagiaire`);

--
-- Index pour la table `meeting_en_lignes`
--
ALTER TABLE `meeting_en_lignes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meeting_en_lignes_statut_id_index` (`statut_id`),
  ADD KEY `meeting_en_lignes_user_id_index` (`user_id`),
  ADD KEY `meeting_en_lignes_id_cours_index` (`id_cours`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mots_cles`
--
ALTER TABLE `mots_cles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `organisations`
--
ALTER TABLE `organisations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participer_meetings`
--
ALTER TABLE `participer_meetings`
  ADD PRIMARY KEY (`id_utilisateur`,`id_meeting`),
  ADD KEY `participer_meetings_id_meeting_foreign` (`id_meeting`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projets_formateur_id_index` (`formateur_id`),
  ADD KEY `projets_id_cours_index` (`id_cours`),
  ADD KEY `projets_statut_id_index` (`statut_id`);

--
-- Index pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qcm_id_chapitre_index` (`id_chapitre`);

--
-- Index pour la table `questions_corrections`
--
ALTER TABLE `questions_corrections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_corrections_question_exercice_id_index` (`question_exercice_id`);

--
-- Index pour la table `questions_exercices`
--
ALTER TABLE `questions_exercices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_exercices_exercice_id_index` (`exercice_id`);

--
-- Index pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_qcm_qcm_id_index` (`qcm_id`);

--
-- Index pour la table `reponse_question_qcm`
--
ALTER TABLE `reponse_question_qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reponse_question_qcm_question_qcm_id_index` (`question_qcm_id`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `score_qcm`
--
ALTER TABLE `score_qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score_qcm_stagiaire_id_index` (`stagiaire_id`),
  ADD KEY `score_qcm_qcm_id_index` (`qcm_id`);

--
-- Index pour la table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_id_chapitre_index` (`id_chapitre`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_formateur_id_index` (`formateur_id`),
  ADD KEY `sessions_formations_id_index` (`formations_id`),
  ADD KEY `sessions_statut_id_index` (`statut_id`);

--
-- Index pour la table `stagiaires`
--
ALTER TABLE `stagiaires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stagiaires_user_id_index` (`user_id`),
  ADD KEY `stagiaires_formateur_id_index` (`formateur_id`),
  ADD KEY `stagiaires_type_inscription_id_index` (`type_inscription_id`),
  ADD KEY `stagiaires_organisation_id_index` (`organisation_id`);

--
-- Index pour la table `statut`
--
ALTER TABLE `statut`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suivre_cours`
--
ALTER TABLE `suivre_cours`
  ADD PRIMARY KEY (`id_cours`,`id_stagiaire`),
  ADD KEY `suivre_cours_id_stagiaire_foreign` (`id_stagiaire`),
  ADD KEY `suivre_cours_id_chapitre_index` (`id_chapitre`);

--
-- Index pour la table `suivre_formations`
--
ALTER TABLE `suivre_formations`
  ADD PRIMARY KEY (`id_stagiaire`,`id_formations`),
  ADD KEY `suivre_formations_id_formations_foreign` (`id_formations`),
  ADD KEY `suivre_formations_id_cours_index` (`id_cours`),
  ADD KEY `suivre_formations_id_chapitre_index` (`id_chapitre`);

--
-- Index pour la table `titres`
--
ALTER TABLE `titres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `titres_stagiaire_id_index` (`stagiaire_id`);

--
-- Index pour la table `types_inscriptions`
--
ALTER TABLE `types_inscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_index` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `cours`
--
ALTER TABLE `cours`
  MODIFY `id_cours` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99563544;

--
-- AUTO_INCREMENT pour la table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `exercices`
--
ALTER TABLE `exercices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `formateurs`
--
ALTER TABLE `formateurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `formations`
--
ALTER TABLE `formations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55387988;

--
-- AUTO_INCREMENT pour la table `meeting_en_lignes`
--
ALTER TABLE `meeting_en_lignes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `mots_cles`
--
ALTER TABLE `mots_cles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `organisations`
--
ALTER TABLE `organisations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questions_corrections`
--
ALTER TABLE `questions_corrections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `questions_exercices`
--
ALTER TABLE `questions_exercices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reponse_question_qcm`
--
ALTER TABLE `reponse_question_qcm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `score_qcm`
--
ALTER TABLE `score_qcm`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `stagiaires`
--
ALTER TABLE `stagiaires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `statut`
--
ALTER TABLE `statut`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `titres`
--
ALTER TABLE `titres`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `types_inscriptions`
--
ALTER TABLE `types_inscriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avoir_cours_mots_cles`
--
ALTER TABLE `avoir_cours_mots_cles`
  ADD CONSTRAINT `avoir_cours_mots_cles_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`),
  ADD CONSTRAINT `avoir_cours_mots_cles_id_mot_cle_foreign` FOREIGN KEY (`id_mot_cle`) REFERENCES `mots_cles` (`id`);

--
-- Contraintes pour la table `avoir_formations_mots_cles`
--
ALTER TABLE `avoir_formations_mots_cles`
  ADD CONSTRAINT `avoir_formations_mots_cles_id_formation_foreign` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id`),
  ADD CONSTRAINT `avoir_formations_mots_cles_id_mot_cle_foreign` FOREIGN KEY (`id_mot_cle`) REFERENCES `mots_cles` (`id`);

--
-- Contraintes pour la table `avoir_preferences`
--
ALTER TABLE `avoir_preferences`
  ADD CONSTRAINT `avoir_preferences_id_mot_cle_foreign` FOREIGN KEY (`id_mot_cle`) REFERENCES `mots_cles` (`id`),
  ADD CONSTRAINT `avoir_preferences_id_stagiaire_foreign` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`);

--
-- Contraintes pour la table `chapitres`
--
ALTER TABLE `chapitres`
  ADD CONSTRAINT `chapitres_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE;

--
-- Contraintes pour la table `contenir_documents_chapitres`
--
ALTER TABLE `contenir_documents_chapitres`
  ADD CONSTRAINT `contenir_documents_chapitres_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`),
  ADD CONSTRAINT `contenir_documents_chapitres_id_doc_foreign` FOREIGN KEY (`id_doc`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `contenir_documents_chapitres_id_proj_foreign` FOREIGN KEY (`id_proj`) REFERENCES `projets` (`id`);

--
-- Contraintes pour la table `contenir_documents_projets`
--
ALTER TABLE `contenir_documents_projets`
  ADD CONSTRAINT `contenir_documents_projets_id_document_foreign` FOREIGN KEY (`id_document`) REFERENCES `documents` (`id`),
  ADD CONSTRAINT `contenir_documents_projets_id_projet_foreign` FOREIGN KEY (`id_projet`) REFERENCES `projets` (`id`);

--
-- Contraintes pour la table `cours`
--
ALTER TABLE `cours`
  ADD CONSTRAINT `cours_formateur_foreign` FOREIGN KEY (`formateur`) REFERENCES `formateurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `exercices`
--
ALTER TABLE `exercices`
  ADD CONSTRAINT `exercices_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`) ON DELETE CASCADE;

--
-- Contraintes pour la table `faire_projets`
--
ALTER TABLE `faire_projets`
  ADD CONSTRAINT `faire_projets_id_projet_foreign` FOREIGN KEY (`id_projet`) REFERENCES `projets` (`id`),
  ADD CONSTRAINT `faire_projets_id_stagiaire_foreign` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`);

--
-- Contraintes pour la table `formateurs`
--
ALTER TABLE `formateurs`
  ADD CONSTRAINT `formateurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `formations`
--
ALTER TABLE `formations`
  ADD CONSTRAINT `formations_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `formations_contenir_cours`
--
ALTER TABLE `formations_contenir_cours`
  ADD CONSTRAINT `formations_contenir_cours_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`),
  ADD CONSTRAINT `formations_contenir_cours_id_formation_foreign` FOREIGN KEY (`id_formation`) REFERENCES `formations` (`id`);

--
-- Contraintes pour la table `lier_sessions_stagiaires`
--
ALTER TABLE `lier_sessions_stagiaires`
  ADD CONSTRAINT `lier_sessions_stagiaires_id_session_foreign` FOREIGN KEY (`id_session`) REFERENCES `sessions` (`id`),
  ADD CONSTRAINT `lier_sessions_stagiaires_id_stagiaire_foreign` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`);

--
-- Contraintes pour la table `meeting_en_lignes`
--
ALTER TABLE `meeting_en_lignes`
  ADD CONSTRAINT `meeting_en_lignes_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_en_lignes_statut_id_foreign` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `meeting_en_lignes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `participer_meetings`
--
ALTER TABLE `participer_meetings`
  ADD CONSTRAINT `participer_meetings_id_meeting_foreign` FOREIGN KEY (`id_meeting`) REFERENCES `meeting_en_lignes` (`id`),
  ADD CONSTRAINT `participer_meetings_id_utilisateur_foreign` FOREIGN KEY (`id_utilisateur`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_formateur_id_foreign` FOREIGN KEY (`formateur_id`) REFERENCES `formateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projets_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE,
  ADD CONSTRAINT `projets_statut_id_foreign` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `qcm_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`) ON DELETE CASCADE;

--
-- Contraintes pour la table `questions_corrections`
--
ALTER TABLE `questions_corrections`
  ADD CONSTRAINT `questions_corrections_question_exercice_id_foreign` FOREIGN KEY (`question_exercice_id`) REFERENCES `questions_exercices` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `questions_exercices`
--
ALTER TABLE `questions_exercices`
  ADD CONSTRAINT `questions_exercices_exercice_id_foreign` FOREIGN KEY (`exercice_id`) REFERENCES `exercices` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `question_qcm`
--
ALTER TABLE `question_qcm`
  ADD CONSTRAINT `question_qcm_qcm_id_foreign` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reponse_question_qcm`
--
ALTER TABLE `reponse_question_qcm`
  ADD CONSTRAINT `reponse_question_qcm_question_qcm_id_foreign` FOREIGN KEY (`question_qcm_id`) REFERENCES `question_qcm` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `score_qcm`
--
ALTER TABLE `score_qcm`
  ADD CONSTRAINT `score_qcm_qcm_id_foreign` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `score_qcm_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `sessions_formateur_id_foreign` FOREIGN KEY (`formateur_id`) REFERENCES `formateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_formations_id_foreign` FOREIGN KEY (`formations_id`) REFERENCES `formations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sessions_statut_id_foreign` FOREIGN KEY (`statut_id`) REFERENCES `statut` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `stagiaires`
--
ALTER TABLE `stagiaires`
  ADD CONSTRAINT `stagiaires_formateur_id_foreign` FOREIGN KEY (`formateur_id`) REFERENCES `formateurs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stagiaires_organisation_id_foreign` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stagiaires_type_inscription_id_foreign` FOREIGN KEY (`type_inscription_id`) REFERENCES `types_inscriptions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `stagiaires_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `suivre_cours`
--
ALTER TABLE `suivre_cours`
  ADD CONSTRAINT `suivre_cours_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`) ON DELETE CASCADE,
  ADD CONSTRAINT `suivre_cours_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`),
  ADD CONSTRAINT `suivre_cours_id_stagiaire_foreign` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`);

--
-- Contraintes pour la table `suivre_formations`
--
ALTER TABLE `suivre_formations`
  ADD CONSTRAINT `suivre_formations_id_chapitre_foreign` FOREIGN KEY (`id_chapitre`) REFERENCES `chapitres` (`id_chapitre`) ON DELETE CASCADE,
  ADD CONSTRAINT `suivre_formations_id_cours_foreign` FOREIGN KEY (`id_cours`) REFERENCES `cours` (`id_cours`) ON DELETE CASCADE,
  ADD CONSTRAINT `suivre_formations_id_formations_foreign` FOREIGN KEY (`id_formations`) REFERENCES `formations` (`id`),
  ADD CONSTRAINT `suivre_formations_id_stagiaire_foreign` FOREIGN KEY (`id_stagiaire`) REFERENCES `stagiaires` (`id`);

--
-- Contraintes pour la table `titres`
--
ALTER TABLE `titres`
  ADD CONSTRAINT `titres_stagiaire_id_foreign` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaires` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
