-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 21 mai 2025 à 22:09
-- Version du serveur : 8.0.36-28
-- Version de PHP : 8.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `database`
--
CREATE DATABASE IF NOT EXISTS `database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `database`;

--
-- Structure de la table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

-- First create categories
INSERT INTO categories (id, name, slug, is_active, created_at, updated_at) VALUES
(2, 'Les Rendez-vous du RHDP', 'les-rendez-vous-du-rhdp', 1, '2025-04-24 20:55:41', '2025-04-24 20:55:41'),
(3, 'Activités du Parti', 'Activités du Parti', 1, '2025-04-24 21:52:09', '2025-04-24 21:52:09');
INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `image`, `author`, `category`, `is_featured`, `is_published`, `published_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Le RHDP salue la mémoire de Charles Diby Koffi', 'le-rhdp-salue-la-memoire-de-charles-diby-koffi', 'Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) a appris avec une profonde tristesse le décès de M. Charles Koffi DIBY, ancien Ministre d\'État, ancien Ministre de l\'Économie et des Finances, ancien Président du Conseil Économique, Social, Environnemental et Culturel (CESEC).

En cette douloureuse circonstance, le Directoire du RHDP, au nom de tous les militants et sympathisants du Parti, présente ses condoléances les plus attristées à sa famille biologique, à ses proches et à tous les Ivoiriens.

Le RHDP salue la mémoire d\'un grand serviteur de l\'État, d\'un homme de conviction et de devoir qui a marqué de son empreinte la vie politique et économique de notre pays.

Puisse son âme reposer en paix.', 'images/actualites/charles-diby-koffi.jpg', 'Secrétariat Exécutif du RHDP', 'communique', 1, 1, '2023-12-08 10:00:00', '2023-12-08 10:00:00', '2023-12-08 10:00:00', NULL),
(2, 'Rencontre avec les structures spécialisées du RHDP', 'rencontre-avec-les-structures-specialisees-du-rhdp', 'Le Secrétaire Exécutif du RHDP, M. Cissé Bacongo, a présidé ce jeudi 07 décembre 2023, une importante rencontre avec les structures spécialisées du Parti.

Cette réunion qui s\'est tenue au siège du Parti à Cocody, a permis de faire le point des activités menées au cours de l\'année 2023 et de définir les orientations pour l\'année 2024.

Le Secrétaire Exécutif a salué le dynamisme des structures spécialisées et les a exhortées à maintenir le cap pour l\'atteinte des objectifs du Parti.

Il a notamment insisté sur la nécessité de renforcer la mobilisation des militants à la base et de poursuivre le travail de sensibilisation et d\'information auprès des populations.

Les responsables des différentes structures ont, à leur tour, présenté leurs bilans respectifs et leurs projets pour l\'année à venir.

Cette rencontre s\'inscrit dans le cadre du suivi régulier des activités des organes du Parti et témoigne de la volonté du RHDP de maintenir une dynamique constante sur le terrain.', 'images/actualites/reunion-structures-specialisees.jpg', 'Service Communication RHDP', 'vie-du-parti', 1, 1, '2023-12-07 15:30:00', '2023-12-07 15:30:00', '2023-12-07 15:30:00', NULL);

--
-- Structure de la table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `content`, `excerpt`, `featured_image`, `category_id`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(3, 'Le RHDP met les points sur les "i" : "Tidjane Thiam est le seul responsable de sa radiation"', 'le-rhdp-met-les-points-sur-les-i-tidjane-thiam-est-le-seul-responsable-de-sa-radiation', '<p>Face aux accusations orchestrées par l\'opposition, notamment le PDCI-RDA, visant à imputer au Rassemblement des Houphouëtistes pour la Démocratie et la Paix (#RHDP) et à son Président, Alassane Ouattara, une prétendue manipulation de la justice dans l\'affaire de la radiation de Tidjane Thiam de la liste électorale, le parti au pouvoir a tenu une conférence de presse ce jeudi 24 avril 2025 pour rétablir la vérité.</p><p>Le Porte-parole Principal du #RHDP, Kobenan Kouassi Adjoumani, a d\'emblée qualifié la démarche de l\'opposition de "volonté délibérée de séquestrer et d\'exécuter sur un poteau en public la vérité" suite à une décision de justice. Il a souligné que le RHDP se devait de procéder à un "recadrage" et à une "clarification" urgents face à cette tentative de désinformation.</p>', NULL, 'news/featured/01JSPAYEDMDSKG3F697942537H.jpg', 2, 1, '2025-04-24 20:58:03', '2025-04-24 20:58:25', '2025-04-25 11:22:25'),
(4, 'INDÉNIÉ-DJUABLIN : Mobilisation réussie pour la rentrée politique de l\'UE-RHDP', 'indenie-djuablin-mobilisation-reussie-pour-la-rentree-politique-de-lue-rhdp', '<p>Abengourou a vibré ce samedi 19 avril 2025 au rythme de la rentrée politique de la Coordination régionale UE-RHDP de l\'<strong>Indénié-Djuablin</strong>. L\'événement a connu un franc succès avec une forte mobilisation des militants, notamment des enseignants, venus écouter les directives du Bureau Exécutif National (BEN) de l\'Union des Enseignants du RHDP (UE-RHDP).</p>', NULL, 'news/featured/01JSPKJ9V9AS3VQD1T84HVPDT9.jpg', 3, 1, '2025-04-19 23:54:53', '2025-04-24 21:54:32', '2025-04-25 13:53:04'),
(5, 'Daloa Ouest : Mobilisation et soutien massif à Alassane Ouattara lors de la rentrée politique du RHDP', 'daloa-ouest-mobilisation-et-soutien-massif-a-alassane-ouattara-lors-de-la-rentree-politique-du-rhdp', '<p>Le samedi 19 avril 2025, le secrétariat départemental RHDP de Daloa Ouest, sous la houlette de l\'honorable Amaral Fofana, a marqué sa rentrée politique avec éclat, en inaugurant son siège fraîchement rénové. Cet événement d\'importance a été placé sous le parrainage du Ministre Mamadou Touré, Coordonnateur Principal du RHDP dans le Haut-Sassandra, et a rassemblé de nombreux cadres et élus de la région.</p>', NULL, 'news/featured/01JSPKKJRJZXA8DZAQPTDX87YN.jpg', 3, 1, '2025-04-19 21:58:39', '2025-04-24 21:59:09', '2025-04-25 13:53:46');

--
-- Structure de la table `categories`
--

-- CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

-- INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Les Rendez-vous du RHDP', 'les-rendez-vous-du-rhdp', NULL, 1, '2025-04-24 20:55:41', '2025-04-24 20:55:41'),
(3, 'Activités du Parti', 'Activités du Parti', NULL, 1, '2025-04-24 21:52:09', '2025-04-24 21:52:09');

--
-- Contraintes pour la table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
