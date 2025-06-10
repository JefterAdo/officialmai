-- MySQL dump 10.13  Distrib 8.0.42, for Linux (x86_64)
--
-- Host: localhost    Database: database
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `achievements`
--

DROP TABLE IF EXISTS `achievements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `achievements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `achievements`
--

LOCK TABLES `achievements` WRITE;
/*!40000 ALTER TABLE `achievements` DISABLE KEYS */;
INSERT INTO `achievements` VALUES (1,'Infrastructures','fas fa-road-bridge','Routes, ponts, et projets structurants.',NULL,1,1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(2,'Éducation','fas fa-school','Construction et réhabilitation d\'écoles.',NULL,2,1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(3,'Santé','fas fa-hospital','Accès aux soins et couverture maladie.',NULL,3,1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(4,'Économie','fas fa-chart-pie','Croissance soutenue et investissements.',NULL,4,1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(5,'Sécurité','fas fa-shield-halved','Paix retrouvée et sécurité renforcée.',NULL,5,1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(6,'Emploi','fas fa-briefcase','Programmes pour l\'emploi des jeunes.',NULL,6,1,'2025-05-24 00:39:26','2025-05-24 00:39:26');
/*!40000 ALTER TABLE `achievements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `articles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `articles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'Le RHDP salue la mémoire de Charles Diby Koffi','le-rhdp-salue-la-memoire-de-charles-diby-koffi','Le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) a appris avec une profonde tristesse le décès de M. Charles Koffi DIBY, ancien Ministre d\'État, ancien Ministre de l\'Économie et des Finances, ancien Président du Conseil Économique, Social, Environnemental et Culturel (CESEC).\n\nEn cette douloureuse circonstance, le Directoire du RHDP, au nom de tous les militants et sympathisants du Parti, présente ses condoléances les plus attristées à sa famille biologique, à ses proches et à tous les Ivoiriens.\n\nLe RHDP salue la mémoire d\'un grand serviteur de l\'État, d\'un homme de conviction et de devoir qui a marqué de son empreinte la vie politique et économique de notre pays.\n\nPuisse son âme reposer en paix.','images/actualites/charles-diby-koffi.jpg',NULL,'communique',1,0,'2023-12-08 10:00:00','2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(2,'Rencontre avec les structures spécialisées du RHDP','rencontre-avec-les-structures-specialisees-du-rhdp','Le Secrétaire Exécutif du RHDP, M. Cissé Bacongo, a présidé ce jeudi 07 décembre 2023, une importante rencontre avec les structures spécialisées du Parti.\n\nCette réunion qui s\'est tenue au siège du Parti à Cocody, a permis de faire le point des activités menées au cours de l\'année 2023 et de définir les orientations pour l\'année 2024.\n\nLe Secrétaire Exécutif a salué le dynamisme des structures spécialisées et les a exhortées à maintenir le cap pour l\'atteinte des objectifs du Parti.\n\nIl a notamment insisté sur la nécessité de renforcer la mobilisation des militants à la base et de poursuivre le travail de sensibilisation et d\'information auprès des populations.\n\nLes responsables des différentes structures ont, à leur tour, présenté leurs bilans respectifs et leurs projets pour l\'année à venir.\n\nCette rencontre s\'inscrit dans le cadre du suivi régulier des activités des organes du Parti et témoigne de la volonté du RHDP de maintenir une dynamique constante sur le terrain.','images/actualites/reunion-structures-specialisees.jpg',NULL,'vie-du-parti',1,0,'2023-12-07 15:30:00','2025-05-24 00:39:27','2025-05-24 00:39:27',NULL);
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audio`
--

DROP TABLE IF EXISTS `audio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audio` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `audio_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `speaker` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `recording_date` date NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `audio_slug_unique` (`slug`),
  KEY `audio_audio_category_id_foreign` (`audio_category_id`),
  CONSTRAINT `audio_audio_category_id_foreign` FOREIGN KEY (`audio_category_id`) REFERENCES `audio_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audio`
--

LOCK TABLES `audio` WRITE;
/*!40000 ALTER TABLE `audio` DISABLE KEYS */;
/*!40000 ALTER TABLE `audio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audio_categories`
--

DROP TABLE IF EXISTS `audio_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `audio_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `audio_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audio_categories`
--

LOCK TABLES `audio_categories` WRITE;
/*!40000 ALTER TABLE `audio_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `audio_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab','i:1;',1748388834),('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer','i:1748388834;',1748388834),('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba','i:3;',1748525526),('laravel_cache_5c785c036466adea360111aa28563bfd556b5fba:timer','i:1748525526;',1748525526),('laravel_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0','i:1;',1748528864),('laravel_cache_da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1748528864;',1748528864),('laravel_cache_spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:21:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:10:\"view pages\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"create pages\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"edit pages\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:12:\"delete pages\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:10:\"view media\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:12:\"upload media\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:12:\"delete media\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:9:\"view news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:11:\"create news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:9:\"edit news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:11:\"delete news\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:10:\"view users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:12:\"create users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:10:\"edit users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:12:\"delete users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:10:\"view roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"create roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:10:\"edit roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:12:\"delete roles\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:13:\"view settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:13:\"edit settings\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"super-admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:6:\"editor\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:6:\"author\";s:1:\"c\";s:3:\"web\";}}}',1748613786);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Actualités','actualites','Actualités générales du parti',1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(2,'Communiqués','communiques','Communiqués officiels du parti',1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(3,'Vie du parti','vie-du-parti','Activités et événements du parti',1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(4,'Discours','discours','Discours des membres du parti',1,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(5,'Documents','documents','Documents officiels du parti',1,'2025-05-24 00:39:26','2025-05-24 00:39:26');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communique_attachments`
--

DROP TABLE IF EXISTS `communique_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `communique_attachments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `communique_id` bigint unsigned NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `original_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` bigint unsigned NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `download_count` bigint unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `communique_attachments_communique_id_foreign` (`communique_id`),
  CONSTRAINT `communique_attachments_communique_id_foreign` FOREIGN KEY (`communique_id`) REFERENCES `communiques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communique_attachments`
--

LOCK TABLES `communique_attachments` WRITE;
/*!40000 ALTER TABLE `communique_attachments` DISABLE KEYS */;
INSERT INTO `communique_attachments` VALUES (2,10,'communiques/documents/communique-6835edbab24f8_68360df6bb5da.jpg','image/jpeg','communique-6835edbab24f8_68360df6bb5da.jpg',143340,'image/jpeg',0,'2025-05-27 19:09:42','2025-05-27 19:09:42'),(3,11,'communiques/documents/1_68360ec0d2a63.jpg','image/jpeg','1_68360ec0d2a63.jpg',142568,'image/jpeg',1,'2025-05-27 19:13:04','2025-05-27 19:13:33'),(4,11,'communiques/documents/2_68360ec0d3cf6.jpg','image/jpeg','2_68360ec0d3cf6.jpg',117443,'image/jpeg',1,'2025-05-27 19:13:04','2025-05-27 19:13:33'),(5,11,'communiques/documents/3_68360ec0d44c1.jpg','image/jpeg','3_68360ec0d44c1.jpg',95217,'image/jpeg',1,'2025-05-27 19:13:04','2025-05-27 19:13:33');
/*!40000 ALTER TABLE `communique_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communiques`
--

DROP TABLE IF EXISTS `communiques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `communiques` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_count` bigint unsigned NOT NULL DEFAULT '0',
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `has_attachments` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `communiques_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communiques`
--

LOCK TABLES `communiques` WRITE;
/*!40000 ALTER TABLE `communiques` DISABLE KEYS */;
INSERT INTO `communiques` VALUES (1,'COMMUNIQUÉ PORTANT INVITATION À LA RETRANSMISSION DES PRÉ-CONGRÈS RÉGIONAUX PAR VISIOCONFÉRENCE','communique-portant-invitation-a-la-retransmission-des-pre-congres-regionaux-par-visioconference','<p>Le Secrétaire exécutif du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP), le Ministre Gouverneur Cissé Ibrahima Bacongo, porte à la connaissance des cadres, des élus et des structures spécialisées du parti que les activités des pré-congrès régionaux feront l’objet d’une retransmission en direct par visioconférence au Siège du Parti, sis à Cocody, Rue Lepic.</p>','communiques/documents/01JW1XA84477MJACWMB0P28XBV.jpg',0,'jpg',NULL,1,0,'2025-05-22 19:43:54','2025-05-24 19:46:28','2025-05-27 12:11:26','2025-05-27 12:11:26'),(2,'ORGANISATIONS DES MEETINGS DU PRÉ-CONGRÈS','organisations-des-meetings-du-pre-congres','<p>Les délégations retenues pour l\'animation des meetings du Pré-Congrès dans les Régions et Communes d\'Abidjan sont composées comme suit :&nbsp;</p><p>Pour toutes informations&nbsp; complémentaires , veuillez contacter le Secrétariat permanent du Congrès .</p>',NULL,0,NULL,NULL,1,0,'2025-05-16 20:52:24','2025-05-24 20:54:49','2025-05-24 21:00:07','2025-05-24 21:00:07'),(3,'ORGANISATIONS DES MEETINGS DU PRÉ-CONGRÈS. ','organisations-des-meetings-du-pre-congres-1','<p>Les délégations retenues pour l\'animation des meetings du Pré-Congrès dans les Régions et Communes d\'Abidjan sont composées comme suit :&nbsp;</p><p>Pour toutes informations&nbsp; complémentaires , veuillez contacter le Secrétariat permanent du Congrès .</p>',NULL,0,NULL,NULL,1,0,'2025-05-16 22:03:55','2025-05-24 22:05:45','2025-05-24 22:06:17','2025-05-24 22:06:17'),(4,'COMMUNIQUÉ PORTANT INVITATION À LA RETRANSMISSION DES PRÉ-CONGRÈS RÉGIONAUX PAR VISIOCONFÉRENCE','communique-portant-invitation-a-la-retransmission-des-pre-congres-regionaux-par-visioconferences','<p>Le Secrétaire exécutif du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP), le Ministre Gouverneur Cissé Ibrahima Bacongo, porte à la connaissance des cadres, des élus et des structures spécialisées du parti que les activités des pré-congrès régionaux feront l’objet d’une retransmission en direct par visioconférence au Siège du Parti, sis à Cocody, Rue Lepic.</p>',NULL,0,NULL,NULL,1,0,'2025-05-23 12:12:26','2025-05-27 12:13:28','2025-05-27 12:38:09','2025-05-27 12:38:09'),(5,'COMMUNIQUÉ PORTANT INVITATION À LA RETRANSMISSION DES PRÉ-CONGRÈS RÉGIONAUX PAR VISIOCONFÉRENCE','communique-portant-invitation-a-la-retransmission-des-pre-congres-regionaux-visioconference','<p>Le Secrétaire exécutif du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP), le Ministre Gouverneur Cissé Ibrahima Bacongo, porte à la connaissance des cadres, des élus et des structures spécialisées du parti que les activités des pré-congrès régionaux feront l’objet d’une retransmission en direct par visioconférence au Siège du Parti, sis à Cocody, Rue Lepic.</p>',NULL,0,NULL,NULL,1,0,'2025-05-23 12:38:12','2025-05-27 12:39:30','2025-05-27 16:39:49','2025-05-27 16:39:49'),(6,'COMMUNIQUÉ PORTANT INVITATION À LA RETRANSMISSION DES PRÉ-CONGRÈS RÉGIONAUX PAR VISIOCONFÉRENCE','communique-portat-invitation-a-la-retransmission-des-pre-congres-regionaux-par-visioconference',NULL,NULL,0,NULL,NULL,1,0,'2025-05-23 12:39:30','2025-05-27 13:54:41','2025-05-27 16:39:49','2025-05-27 16:39:49'),(7,'tet','tet','<p>xxs</p>',NULL,0,NULL,NULL,1,0,'2025-05-27 14:17:26','2025-05-27 14:17:45','2025-05-27 16:39:49','2025-05-27 16:39:49'),(8,'ttttt','ttttt','<p>,hhhhhhhhhhh</p>',NULL,0,NULL,NULL,1,0,'2025-05-27 16:40:03','2025-05-27 16:40:24','2025-05-27 19:07:21','2025-05-27 19:07:21'),(9,' n','n','<p>,&nbsp; &nbsp;,&nbsp;</p>',NULL,0,NULL,NULL,1,0,'2025-05-27 16:51:47','2025-05-27 16:52:10','2025-05-27 19:07:21','2025-05-27 19:07:21'),(10,'COMMUNIQUÉ PORTANT INVITATION À LA RETRANSMISSION DES PRÉ-CONGRÈS RÉGIONAUX PAR VISIOCONFÉRENCE','communique-portant-invitation-a-retransmission-des-pre-congres-regionaux-par-visioconference','<p>Le Secrétaire exécutif du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP), le Ministre Gouverneur Cissé Ibrahima Bacongo, porte à la connaissance des cadres, des élus et des structures spécialisées du parti que les activités des pré-congrès régionaux feront l’objet d’une retransmission en direct par visioconférence au Siège du Parti, sis à Cocody, Rue Lepic.</p>',NULL,0,NULL,NULL,1,1,'2025-05-23 19:08:46','2025-05-27 19:09:42','2025-05-27 19:09:42',NULL),(11,'Communiqué du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (#RHDP) Organisation des Pré-Congrès régionaux. ','communique-du-rassemblement-des-houphouetistes-pour-la-democratie-et-la-paix-rhdp-organisation-des-pre-congres-regionaux','<p>En prélude à son deuxième Congrès ordinaire,&nbsp; prévu les 21 et 22 juin 2025 , le RHDP organise des Pré-Congrès dans ses 47 Régions Politiques .</p><p><br></p>',NULL,0,NULL,NULL,1,1,'2025-05-07 19:11:45','2025-05-27 19:13:04','2025-05-27 19:13:04',NULL);
/*!40000 ALTER TABLE `communiques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `documents_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (3,'Statuts et Règlement Intérieur du RHDP','statuts-et-reglement-interieur-rhdp','documents/statuts-du-rhdp.pdf','statut','Statuts et Règlement Intérieur du RHDP',1,'2025-05-27 19:17:23','2025-05-27 19:17:23');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `max_participants` int DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `events_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
INSERT INTO `events` VALUES (1,'Assemblée Générale du RHDP','assemblee-generale-rhdp','Assemblée générale annuelle du Rassemblement des Houphouëtistes pour la Démocratie et la Paix','2025-07-09 09:00:00','2025-07-09 17:00:00','Hôtel Ivoire, Abidjan','Boulevard de la République','Abidjan','Côte d\'Ivoire','contact@rhdp.ci','+225 20 30 40 50',500,1,1,'events/assemblee-generale.jpg','2025-05-24 00:39:27','2025-05-24 00:39:27'),(2,'Célébration du 10ème anniversaire du RHDP','10-ans-rhdp','Célébration du 10ème anniversaire de la création du Rassemblement des Houphouëtistes pour la Démocratie et la Paix','2025-07-24 08:00:00','2025-07-24 23:59:59','Stade Félix Houphouët-Boigny','Boulevard de la Paix','Abidjan','Côte d\'Ivoire','evenements@rhdp.ci','+225 20 30 40 60',5000,1,1,'events/anniversaire-rhdp.jpg','2025-05-24 00:39:27','2025-05-24 00:39:27');
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flash_infos`
--

DROP TABLE IF EXISTS `flash_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flash_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `display_order` int NOT NULL DEFAULT '0',
  `display_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'static',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flash_infos`
--

LOCK TABLES `flash_infos` WRITE;
/*!40000 ALTER TABLE `flash_infos` DISABLE KEYS */;
INSERT INTO `flash_infos` VALUES (1,'Pré-Congrès régionaux du RHDP : Du 25 mai au 15 juin 2025, les 47 coordinations régionales tiendront leurs pré-congrès en vue du 2ᵉ Congrès ordinaire des 21-22 juin 2025.',1,'2025-05-24 01:03:40','2025-06-15 01:03:49',0,'scroll','2025-05-24 01:04:09','2025-05-24 01:04:09'),(2,'Le ministre d’Etat Patrick Achi nommé président du 2e congrès ordinaire du RHDP prévu les 21 et 22 juin 2025 à Abidjan.',1,'2025-05-21 01:19:55','2025-06-21 01:20:06',0,'static','2025-05-24 01:21:15','2025-05-24 01:21:15');
/*!40000 ALTER TABLE `flash_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `footer_elements`
--

DROP TABLE IF EXISTS `footer_elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `footer_elements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `footer_elements`
--

LOCK TABLES `footer_elements` WRITE;
/*!40000 ALTER TABLE `footer_elements` DISABLE KEYS */;
/*!40000 ALTER TABLE `footer_elements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `event_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `galleries_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,'SÉMINAIRE DE FORMATION POLITIQUE RHDP - ANC ','Le Haut Représentant du Président de la République, Monsieur Gilbert Koné KAFANA, Président du Directoire du #RHDP, a procédé, ce lundi 26 mai 2025, à l\'ouverture du Séminaire de Formation Politique RHDP - ANC à Byblos Hôtel Zone 4 , Abidjan-Côte d\'Ivoire .\n','seminaire-de-formation-politique-rhdp-anc',1,'2025-05-26','2025-05-27 19:22:59','2025-05-27 19:22:59'),(2,'PRÉ-CONGRÈS DU RHDP DE LA RÉGION DE LA MÉ ','Le Pré-congrès régional du #RHDP de la Mé a démarré ce dimanche 25 mai 2025 , sous la présidence effective de Monsieur Patrick Achi  , president du 2eme Congrès, Coordonnateur Régional Principal du parti. \nÀ ses côtés, figuraient plusieurs hautes personnalités du RHDP, notamment, le Ministre Bouaké Fofana, Coordonnateur Principal du RHDP dans la région du Worodougou, le Ministre Seka Seka Joseph vice président du CESEC, le Ministre Assi Jean Luc premier vice-président du Conseil Régionalde la MÉ, Mme Florence Achi Maire de la commune d\'Adzopé, et de nombreux cadres du Parti présidentiel qui ont également pris part à cet important rendez-vous.','pre-congres-du-rhdp-de-la-region-de-la-me',1,'2025-05-26','2025-05-27 19:38:58','2025-05-27 19:38:58'),(3,'CLÔTURE DU PRÉ-CONGRÈS RÉGIONAL DU RHDP CAVALLY ','Dimanche 25 mai 2025, Madame Anne Désirée Ouloto , Coordonnatrice Principale #RHDP du Cavally, a présidé,  la cérémonie de clôture du Pré-congres régional du RHDP  Cavally , en présence d\'une forte délégation du Parti, composée de M. Emmanuel Ahoutou KOFFI,  Ministre Directeur de Cabinet du Vice-Président, chef de délégation,  du Docteur Adama Coulibaly, membre du Directoire du RHDP en charge de la stratégie,  de l\'organisation et de l\'implantation,  de M. Ibrahim Kouassi, Secrétaire Nationale adjoint en charge de la promotion et de l\'emploi des militants et du Docteur Kouassi Koffi , Directeur de Cabinet du Chef de délégation, et de la présence effective des élus et cadres,  des militants et  sympathisants du RHDP de la région du Cavally. ','cloture-du-pre-congres-regional-du-rhdp-cavally',1,'2025-05-25','2025-05-27 19:42:59','2025-05-27 19:42:59');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` bigint unsigned NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_images_gallery_id_foreign` (`gallery_id`),
  CONSTRAINT `gallery_images_gallery_id_foreign` FOREIGN KEY (`gallery_id`) REFERENCES `galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
INSERT INTO `gallery_images` VALUES (1,1,'galleries/01JW9K5D46FBFEAKAHE0TY19JY.jpg',NULL,0,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(2,1,'galleries/01JW9K5D49XKYE0C3J6CYSDQHH.jpg',NULL,1,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(3,1,'galleries/01JW9K5D4A8DSQM1W1WKSFVCJM.jpg',NULL,2,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(4,1,'galleries/01JW9K5D4CG29QRBXJBX3FZBWW.jpg',NULL,3,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(5,1,'galleries/01JW9K5D4EQPFGYZAB6BQVYMTZ.jpg',NULL,4,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(6,1,'galleries/01JW9K5D4FHRCFTTSG42ZTA1D0.jpg',NULL,5,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(7,1,'galleries/01JW9K5D4HAK92R3Q9KK4X60NS.jpg',NULL,6,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(8,1,'galleries/01JW9K5D4KJQW6YS46DJ7XGP86.jpg',NULL,7,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(9,1,'galleries/01JW9K5D4NK9MEF8AZM8K2PXJ9.jpg',NULL,8,'2025-05-27 19:22:59','2025-05-27 19:22:59'),(10,2,'galleries/01JW9M2NXWBTCZZFCX0JJEZ8Y1.jpg',NULL,0,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(11,2,'galleries/01JW9M2NY02014D2Q17MAVMPAJ.jpg',NULL,1,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(12,2,'galleries/01JW9M2NY2793CN94G90TED9TC.jpg',NULL,2,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(13,2,'galleries/01JW9M2NY5HVW5FW8GEWXSPMMP.jpg',NULL,3,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(14,2,'galleries/01JW9M2NY8G6Z391P6V99P4VFJ.jpg',NULL,4,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(15,2,'galleries/01JW9M2NYA49M7PAH8Z9TK0T5G.jpg',NULL,5,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(16,2,'galleries/01JW9M2NYDQGGCERVQN2TPG1G5.jpg',NULL,6,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(17,2,'galleries/01JW9M2NYHNYDNF7FF8B4ZHJFG.jpg',NULL,7,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(18,2,'galleries/01JW9M2NYMQFN2YM7ZTJVERGE7.jpg',NULL,8,'2025-05-27 19:38:58','2025-05-27 19:38:58'),(19,3,'galleries/01JW9MA0MA4SK6WVZ1YDA5SWH1.jpg',NULL,0,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(20,3,'galleries/01JW9MA0ME6CE0GD9F86WQHWRA.jpg',NULL,1,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(21,3,'galleries/01JW9MA0MHRC0WT6J4FQ78TJ4T.jpg',NULL,2,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(22,3,'galleries/01JW9MA0MNFX2KVTR04NCJDGG9.jpg',NULL,3,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(23,3,'galleries/01JW9MA0MRK0MZ29FW07K42P30.jpg',NULL,4,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(24,3,'galleries/01JW9MA0MT0MSN6DMXD15QF6Q1.jpg',NULL,5,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(25,3,'galleries/01JW9MA0MYTF1BHE6G918AB731.jpg',NULL,6,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(26,3,'galleries/01JW9MA0N1D9KR9X2NABMWZCD1.jpg',NULL,7,'2025-05-27 19:42:59','2025-05-27 19:42:59'),(27,3,'galleries/01JW9MA0N51949E7Y4E27MQH49.jpg',NULL,8,'2025-05-27 19:42:59','2025-05-27 19:42:59');
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `media` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mediable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mediable_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `media_mediable_type_mediable_id_index` (`mediable_type`,`mediable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `profession` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section_id` bigint unsigned DEFAULT NULL,
  `membership_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `membership_date` date NOT NULL,
  `membership_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_email_unique` (`email`),
  UNIQUE KEY `members_membership_number_unique` (`membership_number`),
  KEY `members_section_id_foreign` (`section_id`),
  CONSTRAINT `members_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_04_03_000001_create_communiques_table',1),(5,'2025_04_02_205715_create_permission_tables',1),(6,'2025_04_03_005457_create_categories_table',1),(7,'2025_04_03_005501_create_news_table',1),(8,'2025_04_03_005503_create_media_table',1),(9,'2025_04_03_010136_create_sections_table',1),(10,'2025_04_03_010138_create_members_table',1),(11,'2025_04_03_010140_create_events_table',1),(12,'2025_04_03_010143_create_official_documents_table',1),(13,'2025_04_03_100626_create_photo_galleries_table',1),(14,'2025_04_03_100639_create_videos_table',1),(15,'2025_04_03_100648_create_speeches_table',1),(16,'2025_04_03_100656_create_audio_table',1),(17,'2025_04_03_100700_create_site_settings_table',1),(18,'2025_04_03_110000_create_newsletters_table',1),(19,'2025_04_03_110100_create_notifications_table',1),(20,'2025_04_03_111823_create_pages_table',1),(21,'2025_04_04_140607_create_flash_infos_table',1),(22,'2025_04_04_143430_add_display_mode_to_flash_infos_table',1),(23,'2025_04_04_215638_create_president_pages_table',1),(24,'2025_04_04_225545_create_slides_table',1),(25,'2025_04_05_202954_create_galleries_table',1),(26,'2025_04_05_203001_create_gallery_images_table',1),(27,'2025_04_08_231446_create_achievements_table',1),(28,'2025_04_09_002009_create_organization_structure_table',1),(29,'2025_04_09_151739_add_missing_organization_members',1),(30,'2025_04_09_165426_create_articles_table',1),(31,'2025_04_09_200250_create_footer_elements_table',1),(32,'2025_04_09_205008_create_organization_members_table',1),(33,'2025_05_22_105400_create_documents_table',1),(34,'2025_05_24_022016_add_meta_description_to_news_table',2),(36,'2025_05_24_184252_add_download_count_to_communiques_table',3),(37,'2025_05_24_201824_create_communique_attachments_table',4),(38,'2025_05_24_221358_add_download_count_to_communique_attachments_table',5),(39,'2025_05_24_222636_add_has_attachments_to_communiques_table',6),(40,'2025_05_24_235400_update_organization_structure_members',7),(41,'2025_05_27_211146_add_excerpt_column_to_speeches_table',8),(42,'2025_05_28_194500_add_security_fields_to_users_table',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',2);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` bigint unsigned NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_category_id_foreign` (`category_id`),
  CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (4,'Le RHDP met les points sur les \"i\" : \"Tidjane Thiam est le seul responsable de sa radiation\"','le-rhdp-met-les-points-sur-les-i-tidjane-thiam-est-le-seul-responsable-de-sa-radiation','<p>Face aux accusations orchestrées par l\'opposition, notamment le PDCI-RDA, visant à imputer au Rassemblement des Houphouëtistes pour la Démocratie et la Paix (#RHDP) et à son Président, Alassane Ouattara, une prétendue manipulation de la justice dans l\'affaire de la radiation de Tidjane Thiam de la liste électorale, le parti au pouvoir a tenu une conférence de presse ce jeudi 24 avril 2025 pour rétablir la vérité.</p><p>Le Porte-parole Principal du #RHDP, Kobenan Kouassi Adjoumani, a d\'emblée квалифицировал la démarche de l\'opposition de \"volonté délibérée de séquestrer et d\'exécuter sur un poteau en public la vérité\" suite à une décision de justice. Il a souligné que le RHDP se devait de procéder à un \"recadrage\" et à une \"clarification\" urgents face à cette tentative de désinformation.</p><p>Selon M. Adjoumani, l\'opposition, et en particulier le PDCI-RDA, s\'est engagée dans une \"vaste campagne d\'intoxication, de menaces mêlées à la surenchère et à des accusations grotesques et insensées\" contre le RHDP et le Chef de l\'État, refusant d\'analyser les faits \"à l\'aune du droit, avec lucidité et sans passion\".</p><p>Le Porte-parole a rappelé l\'élément déclencheur de cette affaire : la déclaration publique de Tidjane Thiam le 7 février 2025 annonçant sa renonciation à la nationalité française. Avant cette date, a-t-il précisé, \"la plupart des Ivoiriens ignoraient que le président du PDCI-RDA avait une autre nationalité que celle de la Côte d’Ivoire.\"</p><p>\"C\'est cette déclaration qui a réveillé l\'article 48 qui dormait tranquillement dans le cadre de la nationalité, depuis 1961,\" a expliqué M. Adjoumani. \"Du coup, cela a ouvert les yeux aux Ivoiriens qui se sont dit : \'donc M. Thiam est devenu français depuis 1987\'. Partant de ce fait, le juge n’a fait que tirer les conséquences de cette déclaration.\"</p><p>Pour le RHDP, Tidjane Thiam est le seul responsable de sa situation. \"Après avoir commis tant d’impairs, rusé avec les textes de son parti, caché volontairement la vérité à ses militants, dans l’unique but de parvenir à ses fins, il devrait plutôt avoir la sagesse et l’humilité de demander publiquement pardon aux militants du PDCI-RDA et aux Ivoiriens, au lieu de choisir les courtes échelles, en cherchant à transférer la responsabilité de ce qui lui arrive sur la tête d’autres personnes,\" a déclaré M. Adjoumani avec fermeté. Il a conclu sur ce point en affirmant que \"le président du PDCI-RDA, M. Tidjane Thiam est lui-même auteur et victime de ses propres turpitudes.\"</p><p>Le Porte-parole Principal du #RHDP a également appelé l\'ensemble des acteurs politiques de l\'opposition à la \"retenue et à la responsabilité\", rappelant que \"le Président de la République est le garant de la Constitution\" qui consacre la séparation des pouvoirs. \"L’Etat de droit que nous voulons bâtir commence par le respect de la légalité,\" a insisté M. Adjoumani, ajoutant que \"le temps des compromis et des petits arrangements politiques est révolu, dès lors que toutes les Institutions de la République fonctionnent normalement.\"</p><p>Pour rappel, la justice ivoirienne a déclaré le mardi 22 avril 2025 que Tidjane Thiam n\'était pas фондирован à figurer sur la liste électorale ivoirienne, considérant qu\'au moment de son inscription, sa possession de la nationalité française, dont les effets se sont prolongés jusqu\'en mars 2025, entraînait la perte de ses droits civiques ivoiriens.</p><p>Ce point de presse a vu la participation notable du Secrétaire Exécutif du RHDP, le Ministre Gouverneur Cissé Ibrahima Bacongo, de la Ministre Myss Belmonde Dogo, membre du Directoire du RHDP, ainsi que de nombreux élus et cadres du parti présidentiel, témoignant de l\'importance que le RHDP accorde à cette affaire.</p>','Le RHDP rejette les accusations du PDCI-RDA : Tidjane Thiam est seul responsable de sa radiation. Conférence de presse du 24 avril 2025 pour rétablir les faits.',NULL,'news/featured/01JVZZXCAS5QB85M1TW4RS0K37.jpg',3,1,'2025-04-24 01:52:51','2025-05-24 01:53:23','2025-05-24 02:25:04'),(5,'INDÉNIÉ-DJUABLIN : Mobilisation réussie pour la rentrée politique de l\'UE-RHDP','indenie-djuablin-mobilisation-reussie-pour-la-rentree-politique-de-lue-rhdp','<p>Abengourou a vibré ce samedi 19 avril 2025 au rythme de la rentrée politique de la Coordination régionale UE-RHDP de l\'<strong>Indénié-Djuablin</strong>. L\'événement a connu un franc succès avec une forte mobilisation des militants, notamment des enseignants, venus écouter les directives du Bureau Exécutif National (BEN) de l\'Union des Enseignants du RHDP (UE-RHDP).</p><p>Le Président du BEN de l\'UE-RHDP, Dr OUATTARA DRISSA, en personne, a fait le déplacement à Abengourou, accompagné d\'une importante délégation. Cette présence témoigne de l\'engagement de la direction nationale à soutenir et dynamiser ses structures régionales.</p><p>Devant une salle comble, le Président Dr OUATTARA DRISSA a abordé des sujets cruciaux tels que la récente grève, le fonctionnement optimal de la coordination régionale et les stratégies à mettre en œuvre pour consolider les acquis du RHDP. Ses messages ont été accueillis avec enthousiasme par les militants, soucieux de contribuer activement à la vie du parti.</p><p>La mobilisation massive des enseignants de la région de l\'Indénié-Djuablin est un signal fort de leur adhésion aux idéaux du RHDP et de leur engagement à œuvrer pour son rayonnement. Le succès de cette rentrée politique est un indicateur positif pour les prochaines échéances.</p><p>Il convient de souligner le leadership et la proximité du Président OUATTARA DRISSA avec la base militante, qualités essentielles qui renforcent la cohésion et la motivation au sein de l\'UE-RHDP.</p><p><br></p>','Grande mobilisation à Abengourou pour la rentrée UE-RHDP. Dr Ouattara Drissa anime une rencontre décisive avec les enseignants militants.',NULL,'news/featured/01JW01ZH2YAMZ3Y9EQAKMCM4S4.jpg',1,1,'2025-04-19 02:28:59','2025-05-24 02:29:31','2025-05-24 02:30:42'),(6,'Daloa Ouest : Mobilisation et soutien massif à Alassane Ouattara lors de la rentrée politique du RHDP','daloa-ouest-mobilisation-et-soutien-massif-a-alassane-ouattara-lors-de-la-rentree-politique-du-rhdp','<p>Le samedi 19 avril 2025, le secrétariat départemental RHDP de Daloa Ouest, sous la houlette de l\'honorable Amaral Fofana, a marqué sa rentrée politique avec éclat, en inaugurant son siège fraîchement rénové. Cet événement d\'importance a été placé sous le parrainage du Ministre Mamadou Touré, Coordonnateur Principal du RHDP dans le Haut-Sassandra, et a rassemblé de nombreux cadres et élus de la région.</p><p>Au cœur de cette cérémonie, une motion de soutien retentissante a été adressée au Président de la République, SEM Alassane Ouattara, Président du RHDP. La Sénatrice Diaby Makani a donné lecture de cette motion, exprimant l\'adhésion et la reconnaissance des militants de Daloa Ouest envers le leadership et la vision du Chef de l\'État.</p><p>Les militants ont salué les progrès significatifs accomplis sous la direction du Président Ouattara, notamment en matière de développement économique, d\'infrastructures et de bien-être social. Ils ont également souligné son engagement pour la paix, la stabilité et le rayonnement international de la Côte d\'Ivoire.</p><p>La motion a réaffirmé l\'engagement des militants à soutenir activement les actions du gouvernement et à œuvrer pour la réalisation des objectifs de développement du pays. Point culminant, les militants ont demandé solennellement au Président Alassane Ouattara d\'être le candidat du RHDP pour l\'élection présidentielle du 25 octobre 2025.</p><p>Cet événement a démontré la forte mobilisation des militants du RHDP à Daloa Ouest et leur détermination à soutenir le Président Ouattara dans la poursuite de son œuvre pour la Côte d\'Ivoire.</p><p><br></p>',NULL,NULL,'news/featured/01JW0283GB010AKP7HQ9SYQF9A.jpg',1,1,'2025-04-19 02:31:54','2025-05-24 02:34:12','2025-05-24 02:34:12'),(7,'Le RHDP renforce l’UF-RHDP avec du matériel informatique et roulant pour une campagne dynamique','le-rhdp-renforce-luf-rhdp-avec-du-materiel-informatique-et-roulant-pour-une-campagne-dynamique','<p>Le Bureau Exécutif National de l’Union des Femmes du RHDP (UF-RHDP) a reçu, jeudi 22 mai 2025, un important lot de matériel informatique et roulant, offert par le parti présidentiel. La cérémonie de remise, présidée par M. Célestin Koalla, Directeur Général du Logement et du Cadre de Vie, Conseiller Technique du Secrétaire Exécutif du RHDP, s’est déroulée au siège du parti à Cocody.</p><p>Cette initiative, portée au nom du Ministre-Gouverneur Cissé Ibrahima Bacongo, vise à renforcer les capacités opérationnelles des femmes du RHDP, dont l’engagement sur le terrain a été salué. « Ce don traduit notre volonté de doter nos structures des moyens nécessaires pour une campagne efficace, en vue de la réélection du Président Alassane Ouattara dans moins de 20 semaines », a déclaré M. Koalla.</p><p>La Présidente de l’UF-RHDP, la Ministre Harlette Badou Kouamé Epse N\'guessan, a été particulièrement remerciée pour son leadership depuis 2023. Son travail, ainsi que celui de son équipe, a permis de diffuser largement la vision du chef de l’État à travers le pays.</p><p>Cette dotation s’inscrit dans la dynamique de modernisation et de mobilisation accrue du RHDP en prélude aux prochaines échéances électorales.</p>','Le RHDP dote l’Union des Femmes (UF-RHDP) de matériel informatique et roulant pour soutenir leur travail et préparer la réélection d’Alassane Ouattara.\n\n',NULL,'news/featured/01JW02PXJ0BY87R2VM9J2F0BJM.jpg',1,1,'2025-05-22 02:41:59','2025-05-24 02:42:17','2025-05-27 21:54:11'),(8,'Présidentielle 2025 : Le RHDP rassure sur des élections apaisées et dans les délais constitutionnels','presidentielle-2025-le-rhdp-rassure-sur-des-elections-apaisees-et-dans-les-delais-constitutionnels','<p>Le Porte-parole principal du RHDP, Kobenan Kouassi Adjoumani, a réaffirmé, ce mercredi 21 mai 2025,&nbsp; que les élections présidentielles d’octobre 2025 se dérouleront « de manière apaisée et dans les délais constitutionnels ». Cette déclaration a été faite lors des \"Rendez-vous du RHDP\", une conférence de presse tenue au siège du parti à Cocody, en présence de plusieurs cadres, dont le Secrétaire Exécutif Cissé Ibrahima Bacongo et les ministres Mamadou Touré, Amédé Koffi Kouakou et Mariatou Koné. &nbsp;<br><br>M. Adjoumani a souligné que « le RHDP reste focalisé sur ses priorités, contrairement à l’opposition, qui se perd en débats inutiles ». Il a rappelé l’engagement du Président Alassane Ouattara à garantir un scrutin pacifique et transparent. &nbsp;<br>&nbsp;<br>Sans faire de « tapage », le porte-parole a révélé « une ruée de militants du PDCI-RDA vers le RHDP », preuve de l’attractivité du parti présidentiel. « La Côte d’Ivoire est un pays qui se porte bien et qui compte », a-t-il martelé. &nbsp;<br><br></p><p>Le ministre Amédé Koffi Kouakou, président du comité d’organisation, a détaillé le programme du Congrès des 21 et 22 juin 2025 : &nbsp;<br>- 21 juin : 7 000 congressistes au Parc des Expositions pour la révision des textes. &nbsp;<br>- 22 juin : Grand meeting au stade Alassane Ouattara d’Ebimpé (70 000 personnes attendues). &nbsp;<br><br>« Nous désignerons notre candidat à la présidentielle : le Président Alassane Ouattara », a-t-il confirmé. Des pré-congrès régionaux débuteront dès le 24 mai. &nbsp;<br><br><br></p>','Le RHDP confirme que la présidentielle d’octobre 2025 se tiendra dans les délais légaux, annonce un congrès majeur et évoque une adhésion massive d’opposants.',NULL,'news/featured/01JW03QBMFECCBA9S55X87VS17.jpg',1,1,'2025-05-21 02:57:57','2025-05-24 03:00:00','2025-05-24 03:00:00'),(9,'Danané : Le RHDP forme une centaine de jeunes militants pour une campagne électorale dynamique','danane-le-rhdp-forme-une-centaine-de-jeunes-militants-pour-une-campagne-electorale-dynamique','<p>Dans le cadre de la préparation des élections de 2025, le Secrétariat Départemental du RHDP de Danané, dirigé par Dr Ouattara Lacina et son adjoint Feh Jean Marc, a organisé un séminaire de renforcement des capacités à l’intention d’une centaine de jeunes militants de l’Union des Jeunes du RHDP (UJ-RHDP) le 16 mai 2025. &nbsp;</p><p><br></p><p>Pendant 48 heures, les participants ont été outillés pour devenir des relais efficaces du parti sur le terrain. Cinq modules clés ont structuré les travaux : &nbsp;</p><p><br></p><p>1. Histoire et valeurs du RHDP : Retour sur les fondements du parti, son engagement pour la paix et le développement, ainsi que le leadership du président Alassane Ouattara. &nbsp;</p><p>2. Rôle du militant : Sensibilisation à l’engagement politique et aux responsabilités des cadres locaux. &nbsp;</p><p>3. Réalisations du RHDP à Danané : Focus sur les infrastructures routières, les projets agricoles et les programmes jeunesse. &nbsp;</p><p>4. Techniques de mobilisation : Formation en stratégies de porte-à-porte, causeries communautaires et communication digitale. &nbsp;</p><p>5. Processus électoral : Accent mis sur la transparence et l’efficacité lors des scrutins. &nbsp;</p><p><br></p><p>À l’issue de la formation, les participants se sont engagés à diffuser les connaissances acquises dans leurs comités de base. Une motion de soutien à la candidature du président Ouattara a été adoptée, confirmant leur mobilisation pour une victoire écrasante en 2025. &nbsp;</p><p><br></p><p>La cérémonie de clôture, marquée par la remise des certificats, a vu la présence de Koffi Benelux, représentant du ministre Mamadou Touré, qui a salué l’engagement des jeunes : « Vous incarnez l’avenir du RHDP. Votre dynamisme est essentiel pour notre succès. » &nbsp;</p><p><br></p><p>Cette initiative s’inscrit dans la stratégie du RHDP pour consolider sa base militante et assurer une campagne électorale bien structurée et victorieuse. &nbsp;</p><p><br><br><br></p>','Le RHDP forme 100 jeunes militants à Danané pour les élections 2025 : renforcement des capacités, mobilisation terrain et soutien au Pr Alassane Ouattara\n',NULL,'news/featured/01JW04Y7PK62V5194WXXA9PQKQ.jpg',1,1,'2025-05-21 03:20:16','2025-05-24 03:21:14','2025-05-24 03:21:14'),(10,'Adzopé en ébullition : le RHDP confirme sa force dans la Mé','adzope-en-ebullition-le-rhdp-confirme-sa-force-dans-la-me','<p>Ce <strong>samedi 25 mai 2025</strong>, la ville d\'<strong>Adzopé</strong>, cœur battant de la région de la Mé, a été le théâtre d\'une mobilisation populaire impressionnante. Les militants et sympathisants du Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) ont convergé en masse, démontrant avec éclat leur attachement indéfectible au Président Alassane Ouattara. Cette journée mémorable, qui a également vu la participation active des populations venues d\'Akoupé, Alépé, et Yakassé-Attobrou, a clairement positionné le <strong>RHDP Adzopé</strong> comme une force vive et incontournable, résolument tournée vers les échéances futures et le <strong>soutien Ouattara 2025</strong>.</p><p>Dans une ambiance électrique et un enthousiasme communicatif, Patrick Achi, l\'ancien Premier ministre et coordinateur principal du RHDP pour la Mé, a véritablement galvanisé la foule. Il a rendu un hommage appuyé et vibrant au Chef de l\'État, le qualifiant d\'« homme exceptionnel, un leader hors pair qui a transformé la Côte d\'Ivoire ». Ses mots, porteurs d\'un message d\'espoir et de reconnaissance, ont résonné fortement, rappelant les nombreuses réalisations du Président et la confiance éclairée qu\'il lui a constamment témoignée. L\'engagement populaire pour le <strong>soutien Ouattara 2025</strong> était palpable à chaque instant de cette grande communion.</p><p>Les interventions se sont succédé à la tribune, toutes empreintes de la même ferveur et d\'une détermination sans faille. Franck Abou, conseiller régional et figure de proue de la dynamique jeunesse RHDP de la Mé, a pris la parole avec une fougue contagieuse : « Nous, les jeunes, prenons l’engagement de nous battre pour une victoire éclatante dès le premier tour du Président Alassane Ouattara ». Un message clair et puissant qui témoigne de la vitalité du parti et de l\'adhésion massive des nouvelles générations au projet porté par le <strong>RHDP Adzopé</strong>. Dans la même veine, Sylvie Dadié, présidente des femmes RHDP d\'Adzopé, a souligné avec force la ferme volonté de toutes les femmes de porter le parti et son champion vers de nouveaux succès éclatants.</p><p>L\'ancrage local et la popularité du RHDP ont été brillamment illustrés par les propos de Florence Achi, la première magistrate de la commune d\'Adzopé. Elle a affirmé avec conviction que le choix du Président Ouattara transcende largement le simple cadre partisan, reflétant une adhésion populaire profonde, vaste et sincère, un véritable plébiscite pour le <strong>soutien Ouattara 2025</strong>. Son adjoint, Ali Traoré, a enchéri en lançant un appel vibrant à une mobilisation continue et sans relâche de tous les cadres et responsables locaux. Cette dynamique collective exceptionnelle, observée lors du grand meeting populaire qui a couronné un pré-congrès particulièrement animé en présence du ministre Bouaké Fofana, représentant la direction nationale, confirme que la région de la Mé est résolument et irréversiblement engagée. La formidable mobilisation du <strong>RHDP Adzopé</strong> ce week-end en est la preuve la plus éloquente, un signal fort pour l\'avenir et le renouvellement du <strong>soutien Ouattara 2025</strong>.</p>','Ce samedi 25 mai 2025, la ville d\'Adzopé, cœur battant de la région de la Mé, a été le théâtre d\'une mobilisation populaire impressionnante.',NULL,'news/featured/01JWA0S8PGKNH3EFPB4F6GG0RT.jpg',1,1,'2025-05-25 23:19:00','2025-05-27 23:21:01','2025-05-27 23:33:22');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_campaigns`
--

DROP TABLE IF EXISTS `newsletter_campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_campaigns` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` bigint unsigned DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `total_recipients` int NOT NULL DEFAULT '0',
  `successful_deliveries` int NOT NULL DEFAULT '0',
  `failed_deliveries` int NOT NULL DEFAULT '0',
  `opens` int NOT NULL DEFAULT '0',
  `clicks` int NOT NULL DEFAULT '0',
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `newsletter_campaigns_template_id_foreign` (`template_id`),
  CONSTRAINT `newsletter_campaigns_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `newsletter_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_campaigns`
--

LOCK TABLES `newsletter_campaigns` WRITE;
/*!40000 ALTER TABLE `newsletter_campaigns` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_subscribers`
--

DROP TABLE IF EXISTS `newsletter_subscribers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_subscribers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletter_subscribers_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_subscribers`
--

LOCK TABLES `newsletter_subscribers` WRITE;
/*!40000 ALTER TABLE `newsletter_subscribers` DISABLE KEYS */;
INSERT INTO `newsletter_subscribers` VALUES (1,'communicationaej@gmail.com',NULL,1,'2025-05-27 23:53:49','2025-05-27 23:53:49','2025-05-27 23:53:49');
/*!40000 ALTER TABLE `newsletter_subscribers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletter_templates`
--

DROP TABLE IF EXISTS `newsletter_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletter_templates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletter_templates`
--

LOCK TABLES `newsletter_templates` WRITE;
/*!40000 ALTER TABLE `newsletter_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletter_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `official_documents`
--

DROP TABLE IF EXISTS `official_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `official_documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `issue_date` date NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `official_documents_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `official_documents`
--

LOCK TABLES `official_documents` WRITE;
/*!40000 ALTER TABLE `official_documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `official_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_members`
--

DROP TABLE IF EXISTS `organization_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organization_members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_media` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `organization_structure_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organization_members_organization_structure_id_foreign` (`organization_structure_id`),
  CONSTRAINT `organization_members_organization_structure_id_foreign` FOREIGN KEY (`organization_structure_id`) REFERENCES `organization_structure` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_members`
--

LOCK TABLES `organization_members` WRITE;
/*!40000 ALTER TABLE `organization_members` DISABLE KEYS */;
INSERT INTO `organization_members` VALUES (1,'Claude Martins','Garçon de chenil',NULL,'Soluta ut porro magnam incidunt voluptas consequatur velit. Vel dolores aut doloremque. Voluptas eaque similique tenetur nam ex beatae nobis. Dolorem dolorum unde suscipit eaque.\n\nAut et ipsam et laboriosam quo voluptatum. Sunt et veniam quo non est tempore libero dolor. Minima facilis et et consequatur quis.\n\nEt et facere saepe quibusdam doloremque est fuga corrupti. Laborum ratione nulla voluptatem repudiandae rerum. Voluptatum architecto sint ipsum velit delectus.','frederic.pierre@example.com','09 27 17 36 43','{\"facebook\":\"https:\\/\\/facebook.com\\/agerard\",\"twitter\":\"https:\\/\\/twitter.com\\/lpelletier\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/alix.dupre\"}',1,1,1,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(2,'Marcel Roux','Porteur de hottes',NULL,'Assumenda cum in mollitia quibusdam et. Ab aspernatur sit magnam sapiente non quia velit. Error qui commodi atque facilis ut dolorum praesentium voluptatem. Culpa natus et qui incidunt. Fuga vel dolore ipsa sint sapiente et.\n\nEnim labore quibusdam sed iusto. Non omnis fuga cupiditate dicta est voluptatem. Non animi rerum laborum eum tempora ut quibusdam sit.\n\nMinus vel rerum nihil accusamus voluptatem quibusdam. Porro soluta quos minus veritatis distinctio autem vero. Alias distinctio quisquam qui odio nemo laborum iure.','seguin.philippe@example.org','0787128536','{\"facebook\":\"https:\\/\\/facebook.com\\/antoine19\",\"twitter\":\"https:\\/\\/twitter.com\\/jerome.begue\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/josette.loiseau\"}',1,1,2,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(3,'Rémy Riou','Chef de scierie',NULL,'Nulla velit minima velit perspiciatis quis veritatis. Est dolore ipsum ullam repellendus non ea aut. Excepturi consequuntur rem sit autem quae. Harum numquam expedita qui rerum mollitia fugiat consequatur.\n\nFugit perferendis est modi quibusdam. Rerum natus aut est ut ut aut. Eos deleniti corrupti fugiat deleniti eum. Accusantium optio amet in enim maxime.\n\nAccusantium doloremque qui rerum eos error dolores expedita. Quia molestiae ut illo dolores eos aliquid nihil. Occaecati soluta ullam vitae dolor dicta.','noemi50@example.org','+33 3 32 73 93 29','{\"facebook\":\"https:\\/\\/facebook.com\\/fbailly\",\"twitter\":\"https:\\/\\/twitter.com\\/thibault35\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/pauline.jacquet\"}',1,1,3,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(4,'Zoé Lopes','Potier',NULL,'Distinctio doloremque tempore ipsum. Quibusdam et et porro magni. Asperiores aut rerum quia voluptatem debitis.\n\nDolores nostrum quis laboriosam nihil eligendi autem. Eum vel sed quam quia repudiandae vel.\n\nOmnis sint a explicabo dolor quos aut. Beatae quo eos eius architecto voluptas aperiam. Amet mollitia molestiae neque vero voluptates. Inventore dolores perferendis voluptatem saepe in consectetur ea voluptas.','daniel.boulanger@example.com','0332409452','{\"facebook\":\"https:\\/\\/facebook.com\\/claudine.perrin\",\"twitter\":\"https:\\/\\/twitter.com\\/dorothee24\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/ileroux\"}',1,1,4,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(5,'Andrée du Coulon','Magicien',NULL,'Voluptatem iste autem explicabo accusantium veniam quod. Facere sint sunt natus quas. Cumque est placeat sed ipsa impedit.\n\nDolorem et consequatur dolores excepturi eius ullam. Ut eos minima totam impedit. Iusto iure vel itaque est dolor. Ipsum tempora et neque possimus est non facilis nihil.\n\nSed porro placeat aut facere sint. Explicabo id sunt quo voluptas quis animi ea. Magnam quae modi tempore provident expedita et repellat exercitationem. Nemo voluptatem recusandae adipisci sed facere. Qui fuga tempora consectetur aliquid veritatis ut minus.','emile38@example.net','0774860862','{\"facebook\":\"https:\\/\\/facebook.com\\/dupont.timothee\",\"twitter\":\"https:\\/\\/twitter.com\\/maggie52\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/chartier.laetitia\"}',1,1,5,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(6,'Claire de Hoareau','Fossoyeur',NULL,'Fugit numquam inventore necessitatibus ducimus aut mollitia praesentium aut. Dolores soluta recusandae quam error. Consequatur ut iste perferendis sed enim animi et consequatur. Ut assumenda nisi id quaerat.\n\nQuis esse sit eius atque. Aspernatur earum consequuntur hic vitae. Expedita voluptate fugiat voluptate non impedit quia quis. Consequuntur eos dolorem adipisci accusantium et. Et consequatur molestias adipisci qui libero.\n\nNihil aut sapiente eum ratione asperiores. Reprehenderit ab omnis sit omnis molestias. In qui est dignissimos. Id hic eligendi sunt et eum.','gerard20@example.net','05 23 95 36 73','{\"facebook\":\"https:\\/\\/facebook.com\\/poirier.marguerite\",\"twitter\":\"https:\\/\\/twitter.com\\/elise14\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/gerard.lamy\"}',1,1,6,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(7,'Caroline-Pénélope Toussaint','Preneur de son',NULL,'Veritatis et unde autem et voluptates ullam. Nam quis rerum molestiae tempore quos qui. Et consectetur id laudantium officiis rem. Explicabo corrupti sit atque aut quas iste.\n\nQui architecto cum perspiciatis ex quos hic in. Laborum vel inventore minus blanditiis excepturi voluptas quas. Ducimus tenetur doloremque odio ut. Ab a odio beatae mollitia. Necessitatibus ut culpa delectus recusandae quis.\n\nSuscipit possimus dolore ut quidem quod. Voluptas iure voluptas molestias distinctio. Ex velit corporis odio maxime necessitatibus alias. Iure ut dolor ipsam.','alix.laurent@example.org','+33 (0)1 17 01 11 97','{\"facebook\":\"https:\\/\\/facebook.com\\/vantoine\",\"twitter\":\"https:\\/\\/twitter.com\\/vmaury\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/gregoire91\"}',1,1,7,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(8,'Adélaïde Bertrand','Hydrothérapie',NULL,'Ut at reprehenderit quia vel cumque iste aliquid. Blanditiis laborum quia qui ut id. Ducimus rerum dolore autem in voluptas corporis repellendus. Et ut nobis ut.\n\nSit qui vel impedit earum sed. Ut architecto velit ut non reprehenderit non rem. Ratione nihil et id in ut error quis. Consectetur et quibusdam vel qui voluptates incidunt.\n\nOdio cumque eaque est incidunt asperiores. Consequatur eum dolorem maiores dolores. Quia ex rem voluptatem eius iusto aspernatur.','ejoly@example.org','+33 9 76 35 33 18','{\"facebook\":\"https:\\/\\/facebook.com\\/vincent14\",\"twitter\":\"https:\\/\\/twitter.com\\/ybreton\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/suzanne48\"}',1,1,8,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(9,'Nathalie Collet','Portier',NULL,'Quasi iste ab sit ipsa aut. Ea natus asperiores quo. Reprehenderit facere sit non. Omnis enim in aspernatur quia unde.\n\nA architecto ut molestiae quia iusto animi ipsam. Error at nemo harum quidem reprehenderit reprehenderit. In suscipit illo placeat.\n\nExcepturi pariatur ut velit sint pariatur. Beatae ut quibusdam et fuga nemo. Ut optio culpa rerum quisquam.','udenis@example.com','0353538934','{\"facebook\":\"https:\\/\\/facebook.com\\/marc.blanc\",\"twitter\":\"https:\\/\\/twitter.com\\/pauline99\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/frederic96\"}',1,1,9,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(10,'Suzanne Henry','Opérateur vidéo',NULL,'Cum quo qui accusamus in aut ut. Aut quasi ipsum laborum dolorem ut cum animi rerum. Quia ullam eligendi similique ipsum reprehenderit.\n\nCommodi aut est cum velit esse cumque esse. Perspiciatis minima ea explicabo minus rerum ipsa qui. Aliquid occaecati sunt quas cupiditate quae. Illo nisi dolor possimus dolorem rerum.\n\nPossimus praesentium et dicta libero ad. Qui laborum vel repudiandae ut veritatis blanditiis. Est minus quos temporibus error alias dolores.','becker.ines@example.net','0893882109','{\"facebook\":\"https:\\/\\/facebook.com\\/olivier.rousset\",\"twitter\":\"https:\\/\\/twitter.com\\/marques.alfred\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/rmarques\"}',1,1,10,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(11,'Eugène de la Gosselin','Rogneur',NULL,'Et hic qui inventore aspernatur non recusandae sit. Temporibus et quia doloribus velit deleniti minima quis. Minus et repudiandae quis iusto et voluptatum. Eos et voluptatem tempora quidem rerum.\n\nCum sed itaque earum deserunt. Cupiditate ad aut dolorem quo. At unde et ducimus est modi.\n\nVoluptate maiores debitis error. Laboriosam accusamus quis distinctio ducimus quisquam perferendis. Sint rerum veniam officiis. Suscipit modi non nihil consequatur. Nobis laboriosam natus consequuntur incidunt.','raymond82@example.com','07 54 20 50 92','{\"facebook\":\"https:\\/\\/facebook.com\\/zlevy\",\"twitter\":\"https:\\/\\/twitter.com\\/jpichon\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/gerard.adrien\"}',1,1,11,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(12,'Julien Legrand','Pareur en abattoir',NULL,'Sed quia tempora et sed ab distinctio. Omnis voluptatem qui ex accusamus itaque maxime distinctio nisi.\n\nEt perferendis voluptates qui consequuntur quia iure. Id et itaque sed. Sit aperiam nisi quaerat doloremque neque eos totam.\n\nVelit occaecati totam inventore corrupti omnis reprehenderit perferendis. Illo sequi quam dolore iusto assumenda vitae eum. Illum quisquam quia quisquam odit. Maiores asperiores ut rerum necessitatibus unde.','simone.carlier@example.net','+33 1 28 56 61 21','{\"facebook\":\"https:\\/\\/facebook.com\\/hernandez.laurent\",\"twitter\":\"https:\\/\\/twitter.com\\/gerard.maury\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/guy.klein\"}',1,1,12,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(13,'Virginie Gauthier','Copiste offset',NULL,'Hic architecto illum porro quia. Nobis dolore perferendis ex numquam rerum dolores vero. Dolor eveniet eum sed minus aliquid est.\n\nOfficia consectetur ut fuga in quasi. Placeat quasi ex consequatur ut vero. Enim doloremque temporibus eveniet quia enim rerum.\n\nAdipisci a saepe officia assumenda itaque molestias. Rem tempora quibusdam suscipit officiis vitae.','uhernandez@example.net','+33 5 22 11 59 59','{\"facebook\":\"https:\\/\\/facebook.com\\/jrousset\",\"twitter\":\"https:\\/\\/twitter.com\\/catherine.bouchet\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/adrien59\"}',1,1,13,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(14,'Margot Rodriguez','Céramiste concepteur',NULL,'Voluptatem enim et qui est earum necessitatibus. Voluptas animi harum tenetur non. Aliquam sed fugit voluptate eius modi autem.\n\nId atque officiis deserunt vitae nihil quos. Similique culpa commodi quidem et animi. Omnis nemo praesentium nihil dolorem ut neque natus nesciunt. Quis commodi et enim.\n\nInventore ex itaque harum laboriosam cupiditate totam. Id dicta repellendus tenetur nam blanditiis sint voluptas. Harum placeat amet quos qui numquam. Aspernatur cumque beatae tenetur deleniti.','gonzalez.thomas@example.org','+33 (0)2 71 31 39 76','{\"facebook\":\"https:\\/\\/facebook.com\\/frederic.courtois\",\"twitter\":\"https:\\/\\/twitter.com\\/dumont.renee\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/qbailly\"}',1,1,14,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(15,'Étienne de Lagarde','Conception et études',NULL,'Numquam exercitationem sit ratione. Est exercitationem aliquam tempore et. Voluptatem temporibus fugiat facere est ratione cupiditate.\n\nVel distinctio et quis sit sed qui optio. Magnam nisi rerum deserunt velit sed iste incidunt. Aut quia deleniti aut exercitationem quia similique eligendi. Omnis quia ex aut. Deleniti ut voluptates doloribus.\n\nQuos ut voluptatibus sunt laborum temporibus. Iure earum laboriosam illo debitis officiis earum. Qui qui perspiciatis id nihil molestias quam dolorem.','raymond92@example.net','0903908178','{\"facebook\":\"https:\\/\\/facebook.com\\/zmartinez\",\"twitter\":\"https:\\/\\/twitter.com\\/wperret\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/matthieu.fernandez\"}',1,1,15,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(16,'Jean Levy','Diététique',NULL,'Occaecati quod quaerat excepturi dolore earum consequatur. Rerum porro et ea et repudiandae et porro. Natus perferendis ipsam dolorem omnis cupiditate delectus. Provident et ut blanditiis fugit ea qui.\n\nEt ratione consequatur sed voluptas consequatur et modi sit. Et ratione officia autem illum rerum delectus quia. Quia et voluptatem laborum incidunt quis.\n\nSunt dolorem qui in occaecati in dicta. Ducimus molestiae voluptas qui corporis fugiat. Et sunt quia dolor eius.','ines61@example.org','01 98 91 51 92','{\"facebook\":\"https:\\/\\/facebook.com\\/crocher\",\"twitter\":\"https:\\/\\/twitter.com\\/laurent40\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/zgiraud\"}',1,1,16,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(17,'Alix Brunet','Facteur de clavecins',NULL,'Commodi itaque magnam quod autem et eaque. Porro quod deserunt alias unde quo. Architecto velit cupiditate et nihil perferendis.\n\nMagni cum dolorem ipsum. Quia consequatur blanditiis minima dolorum voluptatem non. Quas natus dolore ut sunt molestiae harum. Quas est veritatis perspiciatis aut.\n\nQuaerat accusantium est rerum. Consequatur nulla sed sit culpa. Porro nihil aut neque quaerat quas sint neque. Id voluptate beatae consequatur at.','sblin@example.org','+33 (0)4 88 33 01 04','{\"facebook\":\"https:\\/\\/facebook.com\\/thomas.besson\",\"twitter\":\"https:\\/\\/twitter.com\\/joseph96\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/roche.virginie\"}',1,1,17,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(18,'Valentine Noel','Consultant ergonome',NULL,'Tempore quos odit quia ea quam itaque laboriosam ipsum. Provident repellat ut aliquid non ut illum. Saepe nostrum dignissimos ullam sit quasi minus. Aspernatur totam ipsa sint libero omnis recusandae veritatis.\n\nId incidunt omnis voluptatibus omnis nobis molestiae. Unde recusandae hic minima animi. Minus laborum aut quod earum. Facere similique consequuntur omnis ut.\n\nOmnis totam dolore maiores facere. At similique ducimus ad cumque ut molestiae. Accusamus enim ex accusamus quasi totam vitae dolorum. Voluptatum hic velit exercitationem.','alejeune@example.net','+33 1 11 42 23 51','{\"facebook\":\"https:\\/\\/facebook.com\\/nlebrun\",\"twitter\":\"https:\\/\\/twitter.com\\/hortense.barre\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/ucharrier\"}',1,1,18,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(19,'Gilbert Gay','Présentateur radio',NULL,'Iure doloremque voluptatem labore excepturi. Ex est quibusdam velit qui quia. Consequatur rem omnis optio dicta sint. At et culpa alias culpa et.\n\nAb vel ex sit ut eligendi similique. Cum odit deleniti repudiandae rerum. Dicta omnis molestiae enim architecto eum fuga inventore. Rerum dolorum neque inventore.\n\nAccusantium at fuga dicta eum et aut. Maiores sed enim nulla quasi molestias sit. In maxime dolorum aut rem error repellat. Eum amet magnam quaerat illum ipsum eum quia.','emarie@example.org','04 79 33 99 70','{\"facebook\":\"https:\\/\\/facebook.com\\/ribeiro.virginie\",\"twitter\":\"https:\\/\\/twitter.com\\/monnier.etienne\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/caron.zacharie\"}',1,1,19,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(20,'Victor Labbe','Agent de curage',NULL,'Blanditiis iure et architecto expedita est quia quia. Vero aut eum in et quia qui ducimus.\n\nSed dolores velit autem voluptates deserunt autem atque eum. Ut nobis perspiciatis at tenetur aliquam asperiores aut qui. Et eum nulla ea error.\n\nAb architecto eos itaque voluptatem sed accusantium vel. Ratione est molestiae fugit. Saepe suscipit voluptas vero quis ut rerum reprehenderit. Sed laboriosam molestiae cum.','aubry.lucy@example.org','+33 5 55 93 84 60','{\"facebook\":\"https:\\/\\/facebook.com\\/gabrielle59\",\"twitter\":\"https:\\/\\/twitter.com\\/lverdier\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/kmendes\"}',1,1,20,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(21,'Aimée-Édith Dupuy','Piqueur en ganterie',NULL,'Saepe quia qui delectus omnis. Iusto enim itaque blanditiis facere nihil error cum. Accusamus debitis molestiae ut consequatur. Quia ad sed deserunt quis occaecati ex iure.\n\nDicta fugiat voluptatum autem sunt ab. A id dolore nisi qui. Labore iure dignissimos quam necessitatibus dolores. Molestiae labore dolores rerum dolor sit rerum.\n\nQuia atque et voluptatem explicabo ut commodi eos. Mollitia est quis fuga consectetur. In quisquam enim molestiae laborum est.','zjoubert@example.com','+33 7 54 20 62 76','{\"facebook\":\"https:\\/\\/facebook.com\\/gregoire35\",\"twitter\":\"https:\\/\\/twitter.com\\/eric.barbier\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/audrey.hernandez\"}',1,1,21,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(22,'Benjamin Rey','Exploitant de tennis',NULL,'Asperiores animi et veniam. Fugit temporibus quo est quaerat rerum. Ipsam perspiciatis culpa mollitia quia deserunt rerum dignissimos.\n\nTempora enim et odio ratione quia. Similique minus et vel sequi. Dolor cumque dolor ex reiciendis.\n\nTemporibus velit iusto excepturi quae animi. Incidunt et fugiat dolor error. Molestiae et est enim aut.','jeannine.delattre@example.com','0198000770','{\"facebook\":\"https:\\/\\/facebook.com\\/louise.herve\",\"twitter\":\"https:\\/\\/twitter.com\\/kvoisin\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/brigitte.regnier\"}',1,1,NULL,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(23,'Guillaume Gauthier','Juge des enfants',NULL,'Ipsam voluptatum dignissimos ducimus quam dolorem perspiciatis eos. Tenetur magnam dignissimos adipisci cumque vitae culpa quo. Ut ut quia reiciendis quaerat aliquam quasi a.\n\nEnim facilis in sunt dolores ea fuga praesentium. Magnam perferendis et optio voluptatibus. Incidunt sit eaque quae aut magnam.\n\nVoluptas pariatur fuga nisi atque. Reiciendis iure minima iure. Quia sit dolores qui est. Molestiae eaque sapiente soluta facilis et a aspernatur.','coste.marc@example.com','+33 2 30 56 26 08','{\"facebook\":\"https:\\/\\/facebook.com\\/jseguin\",\"twitter\":\"https:\\/\\/twitter.com\\/regnier.zacharie\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/lteixeira\"}',1,1,23,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(24,'Grégoire Couturier','Agent d\'enquêtes',NULL,'Eos nihil quam vitae deserunt corrupti officia ratione. Amet accusamus provident ipsum sit fuga. Quod suscipit non eius enim.\n\nUt enim quo et error maiores. Qui nam omnis non ex eum facilis laudantium.\n\nIpsa deleniti soluta debitis. Velit quasi dolores adipisci consequuntur debitis ut sit. Soluta quo quis placeat aut. Voluptatem pariatur facilis cupiditate id unde eum ipsa.','jacob.roger@example.net','+33 (0)2 97 57 07 35','{\"facebook\":\"https:\\/\\/facebook.com\\/turpin.elisabeth\",\"twitter\":\"https:\\/\\/twitter.com\\/tlaroche\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/agnes.benard\"}',1,1,24,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(25,'Thibault Navarro','Promotion des ventes',NULL,'Vel officia minima libero hic officia impedit. Est et veritatis ut dignissimos accusamus quam quas enim. Et quos dolorem deleniti aut et. Hic velit totam ut molestiae labore et explicabo.\n\nModi qui et eum molestiae. Illo eveniet et cum aperiam placeat saepe. Saepe natus corporis est reprehenderit pariatur.\n\nAut ipsam ratione rerum modi numquam. Ut doloribus placeat et deleniti sunt doloribus. Est ratione in nesciunt impedit ut quo qui. Consequatur aut voluptatem quisquam dolor ducimus vero repellendus.','cmendes@example.net','+33 2 54 63 94 56','{\"facebook\":\"https:\\/\\/facebook.com\\/guillaume88\",\"twitter\":\"https:\\/\\/twitter.com\\/ollivier.zoe\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/morvan.sophie\"}',1,1,25,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(26,'Henriette Maillot','Conception et études',NULL,'Et delectus iusto incidunt eveniet dolorem eos. Aut nulla facere atque et. Et quidem quo cum rerum pariatur.\n\nUt eos omnis consequuntur minima illum facilis. Vero blanditiis accusantium tenetur dolores necessitatibus in id fuga.\n\nFugit voluptas aut necessitatibus nulla dolor sequi libero. Aut deleniti consectetur sunt nulla eos omnis fuga. Numquam alias sint nulla ipsum rerum. Nihil ut ea officia quae sunt aliquid.','dominique28@example.net','0816457637','{\"facebook\":\"https:\\/\\/facebook.com\\/philippe40\",\"twitter\":\"https:\\/\\/twitter.com\\/rjourdan\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/nicolas.benoit\"}',1,1,26,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(27,'Denis Baron','Géodésien',NULL,'Assumenda possimus impedit dolorem sequi sit autem voluptas hic. Alias recusandae est possimus quisquam. Voluptatibus culpa qui est in.\n\nSit dolore fuga blanditiis dolore repellat iure. Ut vel velit voluptates et.\n\nSequi nulla repellendus omnis. Quia ea molestiae corporis id. Adipisci aperiam expedita ullam maiores fugit ab.','guerin.claire@example.net','+33 (0)1 07 20 27 80','{\"facebook\":\"https:\\/\\/facebook.com\\/nicolas.petit\",\"twitter\":\"https:\\/\\/twitter.com\\/petit.suzanne\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/cbouchet\"}',1,1,27,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(28,'Joséphine Brunel-Raynaud','Chansonnier',NULL,'Officia aut excepturi qui quo eveniet. Esse aut ea illum molestiae consequatur distinctio. Voluptatibus dolor est quas quos. Placeat ut non harum voluptatem nostrum ea doloribus.\n\nOdit officia soluta id exercitationem. Harum aut nemo quas similique esse molestiae tempora illo. Sunt quos animi tempore soluta iste. Et possimus enim qui et repellat sint assumenda.\n\nId ut asperiores labore asperiores quia. Neque natus placeat totam.','alphonse.mary@example.org','0440422352','{\"facebook\":\"https:\\/\\/facebook.com\\/margot.caron\",\"twitter\":\"https:\\/\\/twitter.com\\/amendes\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/vdelaunay\"}',1,1,28,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(29,'Nathalie de la Imbert','Etancheur',NULL,'Recusandae ea aspernatur alias sunt iusto ut repellendus. Aut provident aut aliquid doloribus. Natus soluta ut quis inventore totam. Exercitationem nobis ut omnis qui sint.\n\nEt corrupti alias incidunt tempora est. Molestias iste repellendus a et. Aliquid est quia dolor consequatur explicabo enim.\n\nUt voluptate impedit quas et veniam rerum aliquid. Ut dolor ipsum sit expedita deserunt aliquam dolor. Aut quia odio quia fugiat. In ut incidunt ea dicta. Cumque sapiente temporibus corporis nostrum.','benoit40@example.org','+33 5 89 48 82 16','{\"facebook\":\"https:\\/\\/facebook.com\\/rlopes\",\"twitter\":\"https:\\/\\/twitter.com\\/benjamin.pages\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/tessier.madeleine\"}',1,1,NULL,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(30,'Alexandria Dias','Pizzaïolo',NULL,'Iure deserunt assumenda atque est totam. Ut perferendis dicta commodi cupiditate quo harum.\n\nCorrupti pariatur id aut distinctio corrupti eos laudantium accusamus. Et illum explicabo fugit ut. Magnam temporibus ratione et veniam.\n\nFacere minima molestias illo eum ut illo enim. Dicta voluptate animi ad porro a est. Perspiciatis alias fuga enim esse ratione aut sit. Dolorem et ipsam exercitationem quod consequatur. Quod quia provident ut ut ut.','renee.chartier@example.com','+33 (0)7 82 07 32 76','{\"facebook\":\"https:\\/\\/facebook.com\\/susan.dumont\",\"twitter\":\"https:\\/\\/twitter.com\\/stephane.rocher\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/charles.claude\"}',1,1,30,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(31,'Nath Aubert','Ambassadeur',NULL,'Reiciendis nulla quod sit iusto iure incidunt. Nemo fugiat temporibus ipsa nostrum eligendi. Et quod quibusdam sit et sapiente veniam quisquam. Qui sed voluptatem aliquam est veritatis. Qui dolore consectetur et occaecati aliquam eum.\n\nCupiditate minima earum quia voluptatum ab voluptatem vitae aliquid. Culpa sit quaerat et fugit et aperiam eos. Vel qui corrupti dolorem quas illum ad. Veniam ut nam dignissimos eligendi asperiores.\n\nEligendi vel id aut non. Placeat eius eveniet veniam quibusdam. Id aut qui facilis impedit labore iste. Aut beatae sed iusto consequatur cum dolores sed dolores.','maggie.begue@example.org','01 89 53 10 32','{\"facebook\":\"https:\\/\\/facebook.com\\/hschmitt\",\"twitter\":\"https:\\/\\/twitter.com\\/ybegue\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/lbigot\"}',1,1,31,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(32,'Roger Lebreton','Stucateur',NULL,'Quasi distinctio quos labore. Rerum sed voluptate quis exercitationem nobis veritatis voluptatibus. Quos recusandae dolorem soluta impedit id. Et non sunt placeat.\n\nCumque deserunt consequatur quas nulla id repudiandae itaque. Culpa nulla modi quia distinctio velit ea velit. Reprehenderit doloribus necessitatibus necessitatibus.\n\nUt eos doloremque sed esse rerum repellat ut. Nulla non non quia aspernatur aperiam. Impedit id doloribus ipsam. Consequatur nostrum quis dolor voluptas et.','margot.pages@example.org','08 21 84 50 54','{\"facebook\":\"https:\\/\\/facebook.com\\/bernadette.ledoux\",\"twitter\":\"https:\\/\\/twitter.com\\/henry.isaac\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/qrichard\"}',1,1,NULL,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(33,'Richard Perrin','Verrier d\'art',NULL,'Eaque maxime eaque fugiat quod saepe et et. Atque consequatur ut eligendi mollitia. Sed ducimus ipsam ratione molestiae quo earum labore.\n\nDoloribus ex vero soluta optio aspernatur. Nihil fuga magnam est aut temporibus. Dicta sed consequatur omnis minus. Vero autem nesciunt sint ratione qui quia et assumenda.\n\nId quo natus ut sit. Atque fugit eum quia aut quo sit saepe. Voluptate dolor asperiores nesciunt debitis quidem tempore magnam autem. Sunt atque voluptas voluptas numquam.','zfischer@example.com','07 49 10 38 04','{\"facebook\":\"https:\\/\\/facebook.com\\/suzanne76\",\"twitter\":\"https:\\/\\/twitter.com\\/christelle75\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/georges.richard\"}',1,1,33,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(34,'Rémy Martel','Costumier-habilleur',NULL,'Voluptatibus aut et facilis totam natus. Quia harum quod vitae dicta est ex sed.\n\nFacere est ducimus aliquid et possimus officia. Nihil quo aut sunt. Qui natus labore sit aut aperiam.\n\nVeritatis consequatur autem repudiandae. Quis distinctio et dolor dolorum fugiat. Nihil illum rerum labore rerum aliquam. Dolores enim non maxime ipsum.','guy26@example.org','02 91 01 95 36','{\"facebook\":\"https:\\/\\/facebook.com\\/dupont.laetitia\",\"twitter\":\"https:\\/\\/twitter.com\\/martinez.marcel\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/isaac73\"}',1,1,34,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(35,'Paulette-Luce Perret','Chargé de recherche',NULL,'At debitis eos laborum excepturi. Maxime doloribus aperiam magnam eum ducimus dolorum et. Dolorum optio perferendis natus nostrum sed.\n\nIncidunt dolor minima consectetur cupiditate quis. Dolore est laborum asperiores assumenda minima debitis error. Sed laudantium doloribus praesentium corporis.\n\nLibero eum quia et. Aspernatur omnis fugit delectus doloremque. Nobis excepturi enim omnis impedit et. Ipsam culpa ipsam sint velit consequatur.','gledoux@example.net','+33 (0)9 11 18 37 49','{\"facebook\":\"https:\\/\\/facebook.com\\/dias.susan\",\"twitter\":\"https:\\/\\/twitter.com\\/mathilde40\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/caroline.robin\"}',1,1,35,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(36,'Marcel Levy','Sculpteur sur verre',NULL,'Animi voluptas quae distinctio ex ab. Amet quia unde nisi. Impedit et voluptas facere dolores earum est.\n\nEa ipsam ab aspernatur blanditiis libero animi. Esse consequatur vel voluptatem eius cumque. Ut et neque quia est amet nihil enim. Sunt quo consequatur est et et.\n\nEst sunt corporis vel qui cumque. Vel necessitatibus vero perferendis consequatur sapiente aliquam doloremque. Corporis similique quis sit eum.','anais56@example.org','+33 4 46 96 89 12','{\"facebook\":\"https:\\/\\/facebook.com\\/cecile07\",\"twitter\":\"https:\\/\\/twitter.com\\/lbertrand\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/alexandre51\"}',1,1,36,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(37,'Constance Coste-Regnier','Assistant logistique',NULL,'Et sed aperiam quos id vitae sed voluptatibus. Aut illo dolorum voluptatem sit dolores. Repudiandae sint modi aut quod et maxime.\n\nCulpa tempore et quis alias architecto. Corporis rerum aut consequatur unde similique. Beatae ullam ipsa deserunt iste.\n\nEt neque molestias veniam dolores et iste et. Et maiores facilis molestiae eaque fuga. Debitis qui incidunt qui omnis. Iure accusamus fuga ea quis.','sylvie.durand@example.org','01 67 05 91 10','{\"facebook\":\"https:\\/\\/facebook.com\\/ihamon\",\"twitter\":\"https:\\/\\/twitter.com\\/theophile.gosselin\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/icousin\"}',1,1,37,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(38,'Hélène Bailly','Fantaisiste',NULL,'Facere provident quas blanditiis beatae. Debitis optio repellendus et excepturi voluptas dignissimos. Earum facere voluptas minus magni. Quod quis mollitia fuga quia cumque qui.\n\nRerum labore aliquam possimus veniam sit iste libero. Itaque minus eum voluptas necessitatibus.\n\nVoluptas ratione velit quod dolorem. Quaerat quisquam aperiam voluptatem aliquam. Qui exercitationem explicabo delectus sint. Quae tempora ipsa voluptatem iure quod sit ipsum.','denis.clemence@example.org','08 97 12 06 26','{\"facebook\":\"https:\\/\\/facebook.com\\/rguibert\",\"twitter\":\"https:\\/\\/twitter.com\\/leroux.ines\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/meunier.caroline\"}',1,1,38,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(39,'Zacharie Garcia','Verrier à main levée',NULL,'Quod maxime impedit tenetur odio sapiente. Voluptatem animi et vero doloremque. Qui nulla fuga delectus fugiat recusandae aut ratione.\n\nLabore odit ut architecto maiores. Quis et eveniet reiciendis. Ipsa earum aspernatur eos similique maxime.\n\nQuia quos minima rerum molestias voluptatum. Sed et consectetur facilis eius. Assumenda nam dicta deserunt tempora nihil sint accusamus. Est velit rerum voluptas. Aut quam similique aut temporibus nisi quisquam.','michel03@example.org','0250115757','{\"facebook\":\"https:\\/\\/facebook.com\\/wruiz\",\"twitter\":\"https:\\/\\/twitter.com\\/noel.franck\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/dpereira\"}',1,1,39,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(40,'Benoît Lemonnier','Sapeur-pompier',NULL,'Quasi natus ab nihil omnis. Aut odit eaque in saepe mollitia est sit. Sunt et sint animi quo animi quia. Voluptas rerum iusto adipisci.\n\nQui maxime voluptatum eaque necessitatibus praesentium fuga. Odit quas voluptatibus voluptatem iste voluptatibus odit ullam. Voluptas nam porro nihil et nesciunt. Eos quia quia aut in voluptatem.\n\nQuibusdam amet ut velit in saepe dignissimos. Voluptatibus commodi aut excepturi doloremque quia nemo. Quaerat nostrum et quo ratione ut.','anais71@example.org','+33 (0)6 36 47 47 45','{\"facebook\":\"https:\\/\\/facebook.com\\/dbrun\",\"twitter\":\"https:\\/\\/twitter.com\\/weber.maggie\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/emile22\"}',1,1,40,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(41,'Lucas Samson','Céramiste concepteur',NULL,'Aliquam asperiores dolores vero facere dolorem possimus et. Maxime veniam et quod.\n\nDolores expedita qui quibusdam itaque non adipisci. Mollitia nihil dolores ex similique. Eaque inventore sit voluptatibus omnis officiis. Voluptas iste blanditiis omnis ea omnis mollitia harum placeat.\n\nNisi expedita corporis id quam eos quod dolores. Vel veritatis laudantium eos temporibus doloremque est. Ipsam dolore eum ipsum non.','ogilles@example.com','+33 (0)3 11 78 33 02','{\"facebook\":\"https:\\/\\/facebook.com\\/jandre\",\"twitter\":\"https:\\/\\/twitter.com\\/stephane.roy\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/rene46\"}',1,1,41,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(42,'Luce Le Roux','Gynécologue',NULL,'Vitae ab sint mollitia sint dolor. Porro dolorem et non expedita.\n\nTempore blanditiis suscipit quibusdam corrupti minus nihil id. Similique dolores sed labore harum nesciunt aliquid omnis itaque. Voluptates qui quam tenetur quos quis repudiandae magni.\n\nDeleniti ducimus beatae neque quisquam cupiditate et. Animi pariatur quam dolor.','lagarde.anouk@example.org','0548812638','{\"facebook\":\"https:\\/\\/facebook.com\\/bodin.margaret\",\"twitter\":\"https:\\/\\/twitter.com\\/auguste.dossantos\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/francois.boulay\"}',1,1,42,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(43,'Théophile Lejeune','Ingénieur bâtiment',NULL,'Ullam aperiam nemo ipsam accusantium ut. Totam eum sed labore ipsam optio nesciunt. Ut illo officiis ea laborum. Ea et quaerat est sint.\n\nPariatur aut ea voluptatibus optio et sit. Nihil incidunt officia corrupti voluptas reiciendis. Quibusdam quisquam voluptas excepturi itaque aliquid.\n\nVel fugiat est dolor esse consequuntur esse. Rerum omnis aut numquam autem dicta. Nesciunt voluptatem perspiciatis possimus consequatur. Saepe nobis quam dolores.','daniel.hardy@example.net','+33 (0)1 96 68 40 49','{\"facebook\":\"https:\\/\\/facebook.com\\/dorothee.gomes\",\"twitter\":\"https:\\/\\/twitter.com\\/frederic.normand\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/alex.lacombe\"}',1,1,43,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(44,'Dorothée Leroy','Auteur-adaptateur',NULL,'Rerum velit ea dicta non. Vel est et provident minima minima dolorem. Natus iste nemo dicta quas tempore alias.\n\nMinus cumque incidunt est sint suscipit. Dolores cupiditate dolorem omnis dignissimos culpa qui.\n\nMolestiae nam ut eos provident. In veritatis ipsam voluptas. Qui aut eos tempora at eos minima reiciendis. Optio rem commodi sequi atque autem. Sapiente quos vitae delectus omnis aperiam facilis.','chauveau.marie@example.net','07 32 61 14 92','{\"facebook\":\"https:\\/\\/facebook.com\\/kgerard\",\"twitter\":\"https:\\/\\/twitter.com\\/vbenard\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/dorothee10\"}',1,1,44,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(45,'Lucy Couturier','Pisteur secouriste',NULL,'Magni hic dolorem libero ipsam. Est corrupti provident quia. Incidunt quasi corporis consequatur.\n\nPariatur dolor aliquam autem ut veniam. Rem eos impedit dolores deleniti et sunt nesciunt illo. Laudantium qui totam ipsam.\n\nAut modi id eum. Quas dolor sint temporibus unde aut. Mollitia quis cumque sunt dolores dicta non. Quam aut natus deserunt eius veniam tempore. At itaque officia dolorem possimus inventore ex.','bernadette44@example.com','0408484439','{\"facebook\":\"https:\\/\\/facebook.com\\/qbegue\",\"twitter\":\"https:\\/\\/twitter.com\\/xgermain\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/tanguy.lucie\"}',1,1,45,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(46,'Thibault Blanchard-Rocher','Hôte de caisse',NULL,'Accusamus sit distinctio alias quos iste nulla. Vel enim non qui ut. Consequatur quaerat omnis excepturi tempora. Facere quo occaecati ipsam eaque rerum sint sunt. Maxime voluptas qui eligendi molestiae repellendus.\n\nSequi id nemo ratione dolore aut quod magnam accusamus. Fugiat cum aperiam quasi ut quae. Magnam rerum sed rerum nemo maiores sit. Expedita asperiores qui a.\n\nNisi magnam et neque non praesentium sit. Voluptatem nesciunt velit ad hic vero voluptatem vitae. Labore vel qui ea voluptatum quidem similique. Vero consequatur illo enim quia ipsa non ut sunt.','edouard.leclerc@example.org','+33 9 75 52 01 53','{\"facebook\":\"https:\\/\\/facebook.com\\/moreau.jacques\",\"twitter\":\"https:\\/\\/twitter.com\\/martin89\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/jdias\"}',1,1,46,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(47,'Geneviève Marion-Salmon','Pilote de soutireuse',NULL,'Dignissimos perspiciatis est magni vel ut repellendus ipsum veniam. Doloremque qui labore quia pariatur saepe et. Dolores officia omnis repellendus et. Placeat autem voluptatibus iure aliquam illo at aut.\n\nAccusamus sit eius at in. Porro qui sit nihil ea. Tempora accusantium nesciunt eveniet modi minima accusantium ipsa error. Culpa eius amet cum libero aut qui.\n\nEnim temporibus itaque error. Quia sunt est iusto molestias optio molestiae est nihil. Quia error a reprehenderit nihil. Distinctio accusantium adipisci facilis minima ipsa quas sequi cum.','bernard88@example.net','0162495445','{\"facebook\":\"https:\\/\\/facebook.com\\/jeanne.adam\",\"twitter\":\"https:\\/\\/twitter.com\\/durand.noemi\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/olivie.benoit\"}',1,1,47,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(48,'Bertrand-Claude Riou','Auteur-adaptateur',NULL,'Enim mollitia id quod quaerat. Ipsam et ut et possimus voluptatibus sed molestiae. Deleniti dolores eos molestias nostrum omnis esse dolor. Assumenda non atque sed magnam sunt praesentium.\n\nVoluptatem nisi facere quasi at. Quia nam repellendus tempore quidem eum quibusdam at quis. Cumque maxime ipsa magni voluptatibus culpa. Asperiores provident accusantium expedita doloribus.\n\nIpsum qui possimus dolore quia quod. Voluptatum consequatur quos laudantium corrupti et sit. Saepe voluptas est et odio. Voluptatem accusantium laudantium ad ut aut.','qduval@example.org','+33 1 67 63 52 57','{\"facebook\":\"https:\\/\\/facebook.com\\/tlemaire\",\"twitter\":\"https:\\/\\/twitter.com\\/turpin.francoise\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/valette.matthieu\"}',1,1,48,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(49,'Roger Humbert','Séismologue',NULL,'Repellendus non expedita totam eos. Ut debitis ad consectetur molestias occaecati sed nihil. Iure eligendi quos quos soluta et dignissimos.\n\nSint sunt quae autem molestias laborum. Et veniam nesciunt odit iste. Quis laudantium aut adipisci molestiae eaque facilis eos consequuntur.\n\nDoloremque hic porro repellat impedit similique harum deleniti. Quo hic harum expedita aut. Velit possimus molestias voluptatem.','adele.ollivier@example.net','+33 6 36 10 13 17','{\"facebook\":\"https:\\/\\/facebook.com\\/marie.sophie\",\"twitter\":\"https:\\/\\/twitter.com\\/gomes.christophe\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/charlotte48\"}',1,1,49,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL),(50,'Léon Bazin','Danse',NULL,'Velit architecto autem enim nesciunt iure. Sequi suscipit molestiae voluptatem voluptatem voluptates voluptas molestias et.\n\nAccusantium consequatur nisi voluptatibus optio. Non qui sed recusandae id. Tempore sed nisi provident rerum illum illum.\n\nExercitationem eligendi culpa repellendus voluptates. Dolores dicta aliquam veritatis. Qui labore consequatur ut sequi. Et eveniet praesentium nulla quidem nesciunt.','luc.lefebvre@example.org','+33 (0)6 07 87 53 19','{\"facebook\":\"https:\\/\\/facebook.com\\/gaudin.lucie\",\"twitter\":\"https:\\/\\/twitter.com\\/maury.gabrielle\",\"linkedin\":\"https:\\/\\/linkedin.com\\/in\\/roger36\"}',1,1,50,'2025-05-24 00:39:27','2025-05-24 00:39:27',NULL);
/*!40000 ALTER TABLE `organization_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization_structure`
--

DROP TABLE IF EXISTS `organization_structure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `organization_structure` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'directoire',
  `level` int NOT NULL DEFAULT '1',
  `parent_id` bigint unsigned DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `organization_structure_parent_id_foreign` (`parent_id`),
  CONSTRAINT `organization_structure_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `organization_structure` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization_structure`
--

LOCK TABLES `organization_structure` WRITE;
/*!40000 ALTER TABLE `organization_structure` DISABLE KEYS */;
INSERT INTO `organization_structure` VALUES (1,'SEM Alassane Ouattara','Président du RHDP',NULL,'images/membres/Alassane_Outtara.png','president','directoire',1,NULL,1,1,'2025-05-24 00:39:24','2025-05-24 00:39:24'),(2,'M. Robert Beugré Mambé','Vice-Président',NULL,'membres/directoire/beugre.webp','vice_president','directoire',1,NULL,3,1,'2025-05-24 00:39:24','2025-05-25 08:46:41'),(3,'Mme Kandia Camara','Vice-Présidente',NULL,'membres/kandia-camara.jpg','vice_president','directoire',1,NULL,4,1,'2025-05-24 00:39:26','2025-05-26 09:55:26'),(4,'M. Abdallah Toikeusse Mabri','Vice-Président',NULL,'membres/directoire/M. ABDALLAH TOIKEUSSE MABRI.jpg','vice_president','directoire',1,NULL,7,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(5,'M. Tene Birahima Ouattara','Trésorier Général',NULL,'images/membres/directoire/Tene-Brahima-Ouattara.jpeg','tresorier','directoire',1,NULL,5,1,'2025-05-24 00:39:26','2025-05-24 23:57:07'),(6,'M. Kouassi Kobenan Adjoumani','Porte-Parole Principal',NULL,'images/membres/directoire/Kobenan_Kouassi_Adjoumani.jpg','porte_parole','directoire',1,NULL,4,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(7,'M. Mamadou Touré','Porte-Parole Adjoint',NULL,'membres/mamadou-toure.jpg','membre','directoire',1,NULL,26,1,'2025-05-24 00:39:26','2025-05-26 15:24:07'),(8,'M. Bacongo Ibrahima Cisse','Secrétaire Exécutif',NULL,'images/membres/directoire/cisse-bacongo.webp','secretaire_executif','directoire',1,NULL,6,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(9,'M. Félix Anoblé','Membre',NULL,'membres/felix-anoble.jpg','membre','directoire',1,NULL,48,1,'2025-05-24 00:39:26','2025-05-26 16:41:32'),(10,'Présidence','Présidence','Direction et leadership du parti',NULL,'member','directoire',1,NULL,1,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(11,'Secrétariat Général','Secrétariat Général','Coordination et administration',NULL,'member','directoire',2,1,2,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(12,'Direction Exécutive','Direction Exécutive','Mise en œuvre des décisions',NULL,'member','directoire',2,1,3,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(13,'Conseil National','Conseil National','Organe délibératif',NULL,'member','directoire',2,1,4,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(14,'Commissions Permanentes','Commissions Permanentes','Groupes de travail thématiques',NULL,'member','directoire',3,2,5,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(15,'Sections Régionales','Sections Régionales','Représentation territoriale',NULL,'member','directoire',3,2,6,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(16,'M. Hien Sie Yacouba','Chargé de l\'organisation, de l\'implantation et du suivi de la vie du Parti',NULL,'membres/secretariat_executif/M. HIEN SIE Yacouba.jpeg','secretaire_executif_adjoint','secretariat_executif',1,NULL,1,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(17,'M. Emmanuel Ahoutou Koffi','Chargé de la promotion de l\'action gouvernementale',NULL,'membres/secretariat_executif/M. Emmanuel AHOUTOU KOFFI.jpg','secretaire_executif_adjoint','secretariat_executif',1,NULL,2,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(18,'M. Claude Sahi','Chargé des relations extérieures, de la Communication et de la Propagande',NULL,'membres/secretariat_executif/M. Claude SAHI.jpeg','secretaire_executif_adjoint','secretariat_executif',1,NULL,3,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(19,'M. Doumbia Brahima','Chargé du processus électoral',NULL,'membres/secretariat_executif/M. DOUMBIA Brahima.jpg','secretaire_executif_adjoint','secretariat_executif',1,NULL,4,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(20,'Mme Maférima Diarrassouba','Chargée de la Cohésion et de la Solidarité',NULL,'membres/secretariat_executif/Mme Maférima DIARRASSOUBA.jpg','secretaire_executif_adjoint','secretariat_executif',1,NULL,5,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(21,'Pr. Justin N\'Goran Koffi','Chargé de la formation et de l\'Institut Politique du Parti',NULL,'membres/secretariat_executif/Pr. Justin NGORAN KOFFI.jpg','secretaire_executif_adjoint','secretariat_executif',1,NULL,6,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(23,'M. Abdramane Tiemoko Berte','Chargé de l\'Administration du Patrimoine et des Finances',NULL,'membres/M.Abdrahamane Tiemoko BERTE.jpeg','membre','directoire',1,NULL,52,1,'2025-05-24 00:39:26','2025-05-26 16:50:40'),(24,'Mme Yao Patricia Sylvie','Chargée de la Promotion de l\'Autonomisation Financière du Militant',NULL,'membres/yao-patricia-sylvie.jpg','membre','directoire',1,NULL,44,1,'2025-05-24 00:39:26','2025-05-26 16:12:44'),(26,'M. Fidele Sarassoro','Membre',NULL,'images/membres/directoire/fidele-sirrasorro.jpeg','membre','directoire',1,NULL,9,1,'2025-05-24 00:39:26','2025-05-24 23:57:07'),(27,'M. Abdourahmane Cisse','Membre',NULL,'images/membres/directoire/aboudramane-cisse.jpg','membre','directoire',1,NULL,13,0,'2025-05-24 00:39:26','2025-05-24 00:39:26'),(28,'M. Ally Coulibaly','Membre',NULL,'membres/directoire/Ally coulibaly.jpg','membre','directoire',1,NULL,49,1,'2025-05-24 00:39:26','2025-05-26 14:24:14'),(30,'Mme Niale Kaba','Membre',NULL,'images/membres/directoire/kaba-niale.jpg','membre','directoire',1,NULL,12,1,'2025-05-24 00:39:26','2025-05-24 23:57:07'),(31,'M. Sangafowa Coulibaly','Membre',NULL,'membres/directoire/M. SANGAFOWA COULIBALY.jpg','membre','directoire',1,NULL,17,0,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(33,'M. Amadou Kone','Membre',NULL,'membres/directoire/M. AMADOU KONE.jpg','membre','directoire',1,NULL,15,1,'2025-05-24 00:39:26','2025-05-25 08:46:41'),(34,'M. Laurent Tchagba','Membre',NULL,'images/membres/directoire/laurent-tchagba.jpg','membre','directoire',1,NULL,19,1,'2025-05-24 00:39:27','2025-05-24 23:57:07'),(35,'M. Souleymane Diarrassouba','Membre',NULL,'images/membres/directoire/souleymane-diarrassouba.jpg','membre','directoire',1,NULL,22,1,'2025-05-24 00:39:27','2025-05-24 23:57:07'),(36,'M. Amadou Coulibaly','Membre',NULL,'images/membres/directoire/amadou-coulibaly.jpg','membre','directoire',1,NULL,25,1,'2025-05-24 00:39:27','2025-05-24 23:57:07'),(37,'M. Pierre Dimba','Membre',NULL,'images/membres/directoire/pierre-dimba.jpg','membre','directoire',1,NULL,29,1,'2025-05-24 00:39:27','2025-05-24 23:57:07'),(38,'M. Epiphane Zoro Bi Ballo','Membre',NULL,'membres/Epiphane_Zoro_Ballo.jpg','membre','directoire',1,NULL,31,1,'2025-05-24 00:39:27','2025-05-26 15:46:05'),(39,'Mme Myss Belmonde Dogo','Membre',NULL,'images/membres/directoire/myss-belmonde-dogo.jpg','membre','directoire',1,NULL,32,1,'2025-05-24 00:39:27','2025-05-24 23:57:07'),(40,'M. Adama Kamara','Membre',NULL,'membres/directoire/M. ADAMA KAMARA.jpg','membre','directoire',1,NULL,33,1,'2025-05-24 00:39:27','2025-05-26 15:48:46'),(41,'M. Koffi N\'Guessan','Membre',NULL,'membres/directoire/M. KOFFI N\'GUESSAN.webp','membre','directoire',1,NULL,35,1,'2025-05-24 00:39:27','2025-05-26 15:55:42'),(42,'Mme Nasseneba Toure','Membre',NULL,'membres/nasseneba-toure.jpg','membre','directoire',1,NULL,34,1,'2025-05-24 00:39:27','2025-05-26 15:50:10'),(43,'M. Léon Adom Kacou Houadja','Membre',NULL,'membres/Kacou_Houaja.jpg','membre','directoire',1,NULL,38,1,'2025-05-24 00:39:27','2025-05-26 16:02:08'),(44,'M. Alain Richard Donwahi','Membre',NULL,'membres/Alain_DONWAHI.jpeg','membre','directoire',1,NULL,46,1,'2025-05-24 00:39:27','2025-05-26 16:26:14'),(45,'Mme Jeanne Peuhmond','Chargée de la promotion du genre',NULL,'membres/directoire/Mme JEANNE PEUHMOND.jpg','membre','directoire',1,NULL,49,1,'2025-05-24 00:39:27','2025-05-26 16:42:55'),(46,'M. Jean-Luc Assi','Membre',NULL,'membres/directoire/M. JEAN-LUC ASSI.jpg','membre','directoire',1,NULL,37,1,'2025-05-24 00:39:27','2025-05-26 16:00:01'),(47,'M. Célestin Serey Doh','Membre',NULL,'membres/directoire/M. CELESTIN SEREY DOH.jpeg','membre','directoire',1,NULL,39,1,'2025-05-24 00:39:27','2025-05-26 16:02:55'),(48,'M. Gaoussou Touré','Membre',NULL,'membres/directoire/M. GAOUSSOU TOURE.jpeg','membre','directoire',1,NULL,40,1,'2025-05-24 00:39:27','2025-05-26 16:04:25'),(49,'Mme Raymonde Goudou','Membre',NULL,'membres/directoire/Mme RAYMONDE GOUDOU.jpg','membre','directoire',1,NULL,42,1,'2025-05-24 00:39:27','2025-05-25 08:46:41'),(50,'M. Souleymane Touré','Membre',NULL,'membres/directoire/M. SOULEYMANE TOURE.jpg','membre','directoire',1,NULL,43,1,'2025-05-24 00:39:27','2025-05-26 16:10:43'),(51,'M. Gilbert Koné KAFNA','Président du Directoire',NULL,'membres/Gilbert_Koné_Kafana.jpg','vice_president','directoire',1,NULL,2,1,'2025-05-24 23:21:02','2025-05-25 08:31:06'),(53,'M. Kobenan ADJOUMANI','Porte-Parole Principal',NULL,'membres/Kobenan_Kouassi_Adjoumani.jpg','porte_parole','directoire',1,NULL,6,1,'2025-05-24 23:57:07','2025-05-25 22:49:43'),(54,'M. Bacongo CISSE','Secrétaire Exécutif',NULL,'membres/cisse-bacongo.webp','secretaire_executif','directoire',1,NULL,8,1,'2025-05-24 23:57:07','2025-05-25 08:36:11'),(55,'M. Mamadou SANGAFOWA','Membre',NULL,'membres/M. SANGAFOWA COULIBALY.jpg','membre','directoire',1,NULL,11,1,'2025-05-24 23:57:07','2025-05-26 10:17:20'),(56,'Mme Anne Désirée OULOTO','Membre',NULL,'membres/anne-desire-ouloto.jpg','membre','directoire',1,NULL,14,1,'2025-05-24 23:57:07','2025-05-26 10:20:25'),(58,'M. Bruno Nabagné KONE','Membre',NULL,'membres/directoire/M. BRUNO NABAGNE KONE.jpg','membre','directoire',1,NULL,17,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(59,'M. Maurice BANDAMA','Membre',NULL,'membres/Maurice Bandama.jpg','membre','directoire',1,NULL,18,1,'2025-05-24 23:57:07','2025-05-26 10:33:22'),(60,'M. Siandou FOFANA','Membre',NULL,'membres/directoire/M. SIANDOU FOFANA.jpg','membre','directoire',1,NULL,20,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(61,'Mme Mariatou KONE','Membre',NULL,'membres/directoire/Mme MARIATOU KONE.jpg','membre','directoire',1,NULL,21,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(62,'M. Paulin DANHO','Membre',NULL,'membres/directoire/M. PAULIN DANHO.webp','membre','directoire',1,NULL,23,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(63,'M. Sidi Tiémoko TOURE','Membre',NULL,'membres/directoire/M. SIDI TIEMOKO TOURE.jpg','membre','directoire',1,NULL,24,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(64,'M. Adama BICTOGO','Membre',NULL,'membres/Adama-Bictogo.webp','membre','directoire',1,NULL,27,1,'2025-05-24 23:57:07','2025-05-26 10:38:51'),(65,'M. Adama DIAWARA','Membre',NULL,'membres/directoire/M. ADAMA DIAWARA.jpg','membre','directoire',1,NULL,28,1,'2025-05-24 23:57:07','2025-05-25 08:46:41'),(66,'M. Bouaké FOFANA','Membre',NULL,'membres/Bouaké FOFANA.jpg','membre','directoire',1,NULL,30,1,'2025-05-24 23:57:07','2025-05-26 14:16:25'),(68,'M. Amedé KOUAKOU','Membre',NULL,'membres/M. Amedé KOUAKOU.jpg','membre','directoire',1,NULL,20,1,'2025-05-24 23:57:07','2025-05-26 15:20:59'),(75,'ADJE SILAS METCH','Membre',NULL,'membres/ADJE SILAS METCH.jpg','membre','directoire',1,NULL,53,1,'2025-05-24 23:57:07','2025-05-26 16:52:51'),(77,'M. JOSEPH SEKA SEKA','Membre',NULL,'membres/JOSEPH SEKA SEKA.png','membre','directoire',1,NULL,56,1,'2025-05-24 23:57:07','2025-05-26 17:00:48'),(80,'M. Vagondo Diomande','Membre',NULL,'membres/vagondo-diomande.jpg','membre','directoire',1,NULL,11,1,'2025-05-26 14:36:04','2025-05-26 15:00:00'),(81,'M. Adama COULIBALY','Membre',NULL,'membres/Adama_coulibaly.jpg','membre','directoire',1,NULL,16,1,'2025-05-26 15:10:27','2025-05-26 15:10:27'),(82,'M. Moussa SANOGO','Membre',NULL,'membres/MOUSSA SANOGO.jpg','membre','directoire',1,NULL,18,1,'2025-05-26 15:15:12','2025-05-26 15:15:12'),(83,'Mme Françoise REMARCK','Membre',NULL,'membres/Mme Françoise REMARCK.jpg','membre','directoire',1,NULL,36,1,'2025-05-26 15:58:52','2025-05-26 15:58:52'),(84,'M. LEGRE Philippe','Membre',NULL,'membres/M. LEGRE Philippe.jpeg','membre','directoire',1,NULL,41,1,'2025-05-26 16:09:20','2025-05-26 16:09:20'),(85,'M. WOI Mela','Membre',NULL,'membres/persona-svgrepo-com.png','membre','directoire',1,NULL,45,1,'2025-05-26 16:24:02','2025-05-26 16:24:02'),(86,'M. Mamadou SANOGO','Chargé de la stratégie électorale',NULL,'membres/Mamadou_sanogo.jpg','membre','directoire',1,NULL,47,1,'2025-05-26 16:39:41','2025-05-26 16:39:41'),(87,'Dr Adama COULIBALY','Chargé de la stratégie d’organisation et d’implantation du parti',NULL,'membres/Dr Adama COULIBALY.jpeg','membre','directoire',1,NULL,50,1,'2025-05-26 16:45:50','2025-05-26 16:45:50'),(88,'M. Ali Kader COULIBALY','Chargé de l’Administration du patrimoine et des Finances',NULL,'membres/M. Ali Kader COULIBALY.jpg','membre','directoire',1,NULL,51,1,'2025-05-26 16:48:30','2025-05-26 16:48:30'),(89,'DJEDJE ILHAHIRI ALCIDE','Membre',NULL,'membres/L’Ambassadeur_Alcide_Djédjé.jpg','membre','directoire',1,NULL,54,1,'2025-05-26 16:55:51','2025-05-26 16:55:51'),(90,'ASSAHORE KONAN JACQUES','Membre',NULL,'membres/Konan_Jacques_Assahoré_-_2023_(cropped).jpg','membre','directoire',1,NULL,55,1,'2025-05-26 16:57:43','2025-05-26 16:57:43'),(91,'KONATE IBRAHIM KALIL','Membre',NULL,'membres/Kalil-Ibrahim-Konate.jpg','membre','directoire',1,NULL,57,1,'2025-05-26 17:03:30','2025-05-26 17:03:30'),(92,'WAUTABOUNA OUATTARA','Membre',NULL,'membres/WAUTABOUNA OUATTARA.jpg','membre','directoire',1,NULL,59,1,'2025-05-26 17:05:49','2025-05-26 17:05:49');
/*!40000 ALTER TABLE `organization_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `parent_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view pages','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(2,'create pages','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(3,'edit pages','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(4,'delete pages','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(5,'view media','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(6,'upload media','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(7,'delete media','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(8,'view news','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(9,'create news','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(10,'edit news','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(11,'delete news','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(12,'view users','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(13,'create users','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(14,'edit users','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(15,'delete users','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(16,'view roles','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(17,'create roles','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(18,'edit roles','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(19,'delete roles','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(20,'view settings','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(21,'edit settings','web','2025-05-24 00:39:25','2025-05-24 00:39:25');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photo_galleries`
--

DROP TABLE IF EXISTS `photo_galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photo_galleries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `photo_galleries_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photo_galleries`
--

LOCK TABLES `photo_galleries` WRITE;
/*!40000 ALTER TABLE `photo_galleries` DISABLE KEYS */;
/*!40000 ALTER TABLE `photo_galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `photos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `photo_gallery_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` int NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_photo_gallery_id_foreign` (`photo_gallery_id`),
  CONSTRAINT `photos_photo_gallery_id_foreign` FOREIGN KEY (`photo_gallery_id`) REFERENCES `photo_galleries` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `photos`
--

LOCK TABLES `photos` WRITE;
/*!40000 ALTER TABLE `photos` DISABLE KEYS */;
/*!40000 ALTER TABLE `photos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `president_pages`
--

DROP TABLE IF EXISTS `president_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `president_pages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `president_pages`
--

LOCK TABLES `president_pages` WRITE;
/*!40000 ALTER TABLE `president_pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `president_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(17,1),(18,1),(19,1),(20,1),(21,1),(1,2),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(9,2),(10,2),(11,2),(12,2),(13,2),(14,2),(16,2),(20,2),(21,2),(1,3),(2,3),(3,3),(5,3),(6,3),(8,3),(9,3),(10,3),(1,4),(5,4),(6,4),(8,4),(9,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'super-admin','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(2,'admin','web','2025-05-24 00:39:25','2025-05-24 00:39:25'),(3,'editor','web','2025-05-24 00:39:26','2025-05-24 00:39:26'),(4,'author','web','2025-05-24 00:39:26','2025-05-24 00:39:26');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sections_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('6tWCVxGCaXjLElLkUdouey5pgurwfb8TJ8pj814t',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUFRmRWo0YlZSdXpDM2Jma200RjRlUmRIOTlHQVFVS3RIZXRzb0h1TiI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRyZmVZcmN3RjNNQnRXVDdZNEs5aXlPZGN4MGJVRW1URk9vUS5FdjJSUVNGR2pyUDFEU25CaSI7fQ==',1748447906),('atNWLC5NDwLjGQZQGX0OxQ94FS9tLz0hKpOasVf2',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiTzVVSU1zdWxmZWJKUmdjVDlldWdVS3V4Z21JNnF1RGNNeTVrQzR3ZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkcmZlWXJjd0YzTUJ0V1Q3WTRLOWl5T2RjeDBiVUVtVEZPb1EuRXYyUlFTRkdqclAxRFNuQmkiO30=',1748527389),('fHEaZoRyE9EajqEJYsPr4KUdgtQy4ZEmXY3tagXy',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZm94NzJZVkp0UklTbDBrYkVEamk0WWpoZzhaVGlkMWRMdXRtZjZ5VyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2MDoiJDJ5JDEyJHJmZVlyY3dGM01CdFdUN1k0SzlpeU9kY3gwYlVFbVRGT29RLkV2MlJRU0ZHanJQMURTbkJpIjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo4OiJmaWxhbWVudCI7YTowOnt9fQ==',1748463819),('gaUugqkdmlKNH2zTZAoTDzsTG8953McslXhmZrvy',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVG5oV2hBOFhDSkJscGY4WDVuOTRXTW5kZDRxVFFWTEFtRXZIeUJLSyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748477607),('wtg4bnRioiUoLlP8F5VTEIPjFpB8y6Lpi08VvJg8',2,'127.0.0.1','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWVk4eDdIbVpzY0ZSUWlRVThZdklTN1IxRUl0RldVdkpxczlXbUxSNSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1748528804);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` json DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `site_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_settings`
--

LOCK TABLES `site_settings` WRITE;
/*!40000 ALTER TABLE `site_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `site_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `slides`
--

DROP TABLE IF EXISTS `slides`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `slides` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slides`
--

LOCK TABLES `slides` WRITE;
/*!40000 ALTER TABLE `slides` DISABLE KEYS */;
INSERT INTO `slides` VALUES (1,'Avec le RHDP, ensemble, bâtissons l\'avenir de la Côte d\'Ivoire','Grâce au leadership du Président Alassane Ouattara, le RHDP transforme la Côte d\'Ivoire.','slides/01JVZWCN9TVJAFQD7T3HGMGWXZ.jpg',NULL,NULL,1,1,'2025-05-24 00:39:26','2025-05-24 00:52:08'),(2,'Rejoignez le RHDP et devenez acteur du changement.','Ensemble, nous tracerons la voie vers un développement durable. Votre adhésion est notre force.','slides/01JVZWK2RVGXQMAFKR727ZR93P.png',NULL,NULL,4,1,'2025-05-24 00:39:26','2025-05-24 03:29:16'),(3,'La Force d\'une Côte d\'Ivoire Rassemblée','Le RHDP rassemble la Côte d\'Ivoire pour une nation unie et forte.','slides/01JVZWFR9SV2WXZ0M21N625CCD.png',NULL,NULL,3,1,'2025-05-24 00:39:26','2025-05-24 03:28:30'),(4,'RHDP : Tous unis pour 2025 !','Pré-Congrès régionaux du 25 mai au 15 juin : 47 coordinations mobilisées !','slides/01JW059AEJ1MKZHGBQB2ZWZWCT.jpg',NULL,NULL,2,1,'2025-05-24 03:27:17','2025-05-24 03:27:17');
/*!40000 ALTER TABLE `slides` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speech_categories`
--

DROP TABLE IF EXISTS `speech_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `speech_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `speech_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speech_categories`
--

LOCK TABLES `speech_categories` WRITE;
/*!40000 ALTER TABLE `speech_categories` DISABLE KEYS */;
INSERT INTO `speech_categories` VALUES (1,'Discours officiels','discours-officiels','Discours officiels des membres du parti',1,'2025-05-24 00:39:27','2025-05-24 00:39:27');
/*!40000 ALTER TABLE `speech_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `speeches`
--

DROP TABLE IF EXISTS `speeches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `speeches` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `speech_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci,
  `speaker` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `speech_date` date NOT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` int DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `audio_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `speeches_slug_unique` (`slug`),
  KEY `speeches_speech_category_id_foreign` (`speech_category_id`),
  CONSTRAINT `speeches_speech_category_id_foreign` FOREIGN KEY (`speech_category_id`) REFERENCES `speech_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `speeches`
--

LOCK TABLES `speeches` WRITE;
/*!40000 ALTER TABLE `speeches` DISABLE KEYS */;
INSERT INTO `speeches` VALUES (1,1,'Discours de lancement de la campagne électorale','discours-lancement-campagne','Discours prononcé par le Président du RHDP lors du lancement de la campagne électorale','<p>Discours complet du Président lors du lancement de la campagne électorale du RHDP.</p>','Alassane Ouattara','Lancement de la campagne électorale','Abidjan',NULL,'2025-02-24','speeches/discours-campagne.pdf','discours-campagne-2025.pdf','application/pdf',1024000,'https://youtube.com/embed/example1',NULL,1,1,'2025-02-24 00:39:27','2025-05-24 00:39:27','2025-05-27 20:40:05','2025-05-27 20:40:05'),(2,1,'Allocution à l\'occasion de la fête nationale','allocution-fete-nationale','Allocution du Secrétaire Général à l\'occasion de la fête nationale','<p>Allocution complète prononcée à l\'occasion de la fête nationale.</p>','Henriette Diabaté','Célébration de la fête nationale','Yamoussoukro',NULL,'2025-01-25','speeches/allocution-fete-nationale.pdf','allocution-fete-nationale-2025.pdf','application/pdf',890000,NULL,'https://example.com/audio/allocution-fete-nationale.mp3',0,1,'2025-01-25 00:39:27','2025-05-24 00:39:27','2025-05-27 20:40:05','2025-05-27 20:40:05'),(3,NULL,'CÉRÉMONIE D\'OUVERTURE DU SÉMINAIRE DE FORMATION POLITIQUE RHDP - ANC  ALLOCUTION DU PRESIDENT DU DIRECTOIRE ','ceremonie-douverture-du-seminaire-de-formation-politique-rhdp-anc-allocution-du-president-du-directoire',NULL,'<p>Monsieur le Secrétaire Exécutif du RHDP ;</p><p>Monsieur le Chef de la Délégation de l’ANC et l’ensemble de son équipe ;</p><p>Mesdames et Messieurs ;</p><p>C’est avec un immense honneur et un réel plaisir que je vous souhaite la bienvenue à Abidjan, à l’occasion de ce tout premier atelier conjoint d’éducation politique organisé par le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) et l’African National Congress (ANC).</p><p>Permettez-moi, au nom du Président du RHDP, SEM <a href=\"https://www.facebook.com/AlassaneOuattara.prci?__cft__[0]=AZX5VVQYNGG-pREjsloBQJQcEaBtKo_4iiwlC5imPru2rs4XAfVezypBg4sussVCIYT682TAa1AIzBkTcSC0LupBkSxpJe-rUgLrGtRv8FUcGRcjYDQgal0861psoxDcZeQNzrFLdLswVeJ1qQp1YcmRD8w9lvzecCPfiBHLDkMIqlkv5PsdXwjJUcQXtsAJpSg1glNX5id7kQOQqocmUUfG&amp;__tn__=-]K-R\"><strong>Alassane Ouattara</strong></a> de saluer chaleureusement nos hôtes sud-africains pour leur présence parmi nous.&nbsp;</p><p>Leur engagement à faire vivre cette coopération politique est un signal fort, non seulement pour nos partis, mais aussi pour l’avenir de notre continent.</p><p>Cet atelier, qui se tiendra jusqu’au 30 mai 2025, marque une étape importante dans le renforcement des liens historiques, politiques et idéologiques entre nos deux formations.</p><p>Il constitue un cadre privilégié pour la réflexion stratégique, le partage d’expériences, et la construction de passerelles solides entre nos réalités respectives, au service de nos peuples.</p><p>Notre ambition commune est claire : bâtir des partis plus forts, mieux organisés, mieux formés et plus proches des aspirations citoyennes, dans un contexte où les défis démocratiques, le développement durable et l’intégration africaine appellent à une réponse collective, lucide et concertée.</p><p>Au cours de cette semaine de travail, nous aborderons ensemble des thèmes majeurs et structurants, notamment :&nbsp;</p><p>● L’histoire de nos partis et de nos nations, riches en enseignements ;</p><p>● Les principes et pratiques d’une organisation politique moderne et efficace ;</p><p>Les enjeux de la gouvernance et de l’édification nationale ;</p><p>● Les mécanismes électoraux et les stratégies de campagne ;</p><p>● Et enfin, l’agenda africain et notre place dans les relations internationales.</p><p>Ces thématiques ne sont pas seulement académiques : elles traduisent les réalités concrètes auxquelles nos partis sont confrontés chaque jour dans l’exercice du pouvoir, dans la consolidation des institutions et dans la quête permanente de progrès pour nos concitoyens.</p><p>Chers participants,</p><p>Je nous invite à aborder ces échanges avec ouverture, sincérité et rigueur, dans un esprit d’apprentissage mutuel et d’amitié fraternelle. Car en apprenant les uns des autres, nous devenons collectivement meilleurs et plus aptes à servir notre continent.</p><p>En déclarant officiellement ouvert cet atelier, je formule le vœu qu’il débouche sur des recommandations utiles, des pistes d’action concrètes, et qu’il jette les bases d’une coopération politique durable entre le RHDP et l’ANC, au bénéfice de l’Afrique toute entière.</p><p>Je vous remercie.</p>','PRESIDENT DU DIRECTOIRE',NULL,'Byblos Hôtel Zone 4','C’est avec un immense honneur et un réel plaisir que je vous souhaite la bienvenue à Abidjan, à l’occasion de ce tout premier atelier conjoint d’éducation politique organisé par le Rassemblement des Houphouëtistes pour la Démocratie et la Paix (RHDP) et l’African National Congress (ANC).\n\n','2025-05-26','speeches/01JW9T7HNQ621HQE48N2S8D5ES.docx',NULL,NULL,NULL,NULL,NULL,0,1,'2025-05-26 21:26:17','2025-05-27 21:26:29','2025-05-27 21:26:29',NULL);
/*!40000 ALTER TABLE `speeches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `locked_until` timestamp NULL DEFAULT NULL,
  `lock_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_login_attempts` int NOT NULL DEFAULT '0',
  `password_changed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'RHDP','admin@rhdpofficiel.ci',NULL,'$2y$12$rfeYrcwF3MBtWT7Y4K9iyOdcx0bUEmTFOoQ.Ev2RQSFGjrP1DSnBi','qEsPBI6MmlCz7Ytw9IIFkqo7648v32Ct3mdKNOFUOYU0EPcc1jz7WITwFIQ7','2025-05-27 23:50:43','2025-05-29 14:03:06','2025-05-29 14:03:06','127.0.0.1',NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video_categories`
--

DROP TABLE IF EXISTS `video_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `video_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `video_categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video_categories`
--

LOCK TABLES `video_categories` WRITE;
/*!40000 ALTER TABLE `video_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `video_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `videos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `video_category_id` bigint unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `video_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'youtube',
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `videos_slug_unique` (`slug`),
  KEY `videos_video_category_id_foreign` (`video_category_id`),
  CONSTRAINT `videos_video_category_id_foreign` FOREIGN KEY (`video_category_id`) REFERENCES `video_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `videos`
--

LOCK TABLES `videos` WRITE;
/*!40000 ALTER TABLE `videos` DISABLE KEYS */;
/*!40000 ALTER TABLE `videos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-29 14:28:24
