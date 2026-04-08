-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 08, 2026 at 12:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce_shipperrj`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `plain_password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `plain_password`, `remember_token`, `created_at`, `updated_at`) VALUES
('ADMNTTGG4N', 'Admin', 'admin@gmail.com', '$2y$12$v/hHY8.0jqCSSkbJmRALhOtuggwLAi9SQA9OdlU5Wacw11H9x9UHe', NULL, NULL, '2026-03-20 04:38:55', '2026-03-23 04:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-global_settings', 'a:8:{s:26:\"global_cod_advance_percent\";s:1:\"4\";s:19:\"global_cod_shipping\";s:1:\"5\";s:22:\"global_online_shipping\";s:1:\"2\";s:15:\"min_order_price\";s:1:\"1\";s:24:\"min_free_delivery_amount\";s:3:\"500\";s:13:\"support_email\";s:29:\"support@shoppingclubindia.com\";s:13:\"support_phone\";s:16:\"+91 999 999 9999\";s:19:\"cashback_percentage\";s:1:\"0\";}', 1775644624),
('laravel-cache-header_categories', 'O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:8:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CAT54DJHU\";s:4:\"name\";s:16:\"Sports & Fitness\";s:4:\"slug\";s:14:\"sports-fitness\";s:5:\"image\";s:33:\"uploads/categories/1774354161.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:09:21\";s:10:\"updated_at\";s:19:\"2026-03-24 12:09:21\";s:11:\"description\";s:52:\"Gym equipment, sports gear, and fitness accessories.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CAT54DJHU\";s:4:\"name\";s:16:\"Sports & Fitness\";s:4:\"slug\";s:14:\"sports-fitness\";s:5:\"image\";s:33:\"uploads/categories/1774354161.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:09:21\";s:10:\"updated_at\";s:19:\"2026-03-24 12:09:21\";s:11:\"description\";s:52:\"Gym equipment, sports gear, and fitness accessories.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBOFXV61\";s:11:\"category_id\";s:9:\"CAT54DJHU\";s:4:\"name\";s:13:\"Gim Equipment\";s:4:\"slug\";s:13:\"gim-equipment\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:19:54\";s:10:\"updated_at\";s:19:\"2026-03-24 12:19:54\";s:11:\"description\";s:44:\"Dumbbells, treadmills, and workout machines.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBOFXV61\";s:11:\"category_id\";s:9:\"CAT54DJHU\";s:4:\"name\";s:13:\"Gim Equipment\";s:4:\"slug\";s:13:\"gim-equipment\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:19:54\";s:10:\"updated_at\";s:19:\"2026-03-24 12:19:54\";s:11:\"description\";s:44:\"Dumbbells, treadmills, and workout machines.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:7:\"Fashion\";s:4:\"slug\";s:7:\"fashion\";s:5:\"image\";s:33:\"uploads/categories/1774352333.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:13:48\";s:10:\"updated_at\";s:19:\"2026-03-24 11:38:53\";s:11:\"description\";s:67:\"Trending clothes, shoes, and fashion accessories for men and women.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:7:\"Fashion\";s:4:\"slug\";s:7:\"fashion\";s:5:\"image\";s:33:\"uploads/categories/1774352333.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:13:48\";s:10:\"updated_at\";s:19:\"2026-03-24 11:38:53\";s:11:\"description\";s:67:\"Trending clothes, shoes, and fashion accessories for men and women.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBEINCJH\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:9:\"Clothings\";s:4:\"slug\";s:9:\"clothings\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:15:49\";s:10:\"updated_at\";s:19:\"2026-03-24 12:15:49\";s:11:\"description\";s:52:\"Stylish shirts, jeans, and traditional wear for men.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBEINCJH\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:9:\"Clothings\";s:4:\"slug\";s:9:\"clothings\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:15:49\";s:10:\"updated_at\";s:19:\"2026-03-24 12:15:49\";s:11:\"description\";s:52:\"Stylish shirts, jeans, and traditional wear for men.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBJRFFNE\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:15:\"Women Clothings\";s:4:\"slug\";s:15:\"women-clothings\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:16:21\";s:10:\"updated_at\";s:19:\"2026-03-24 12:16:21\";s:11:\"description\";s:44:\"Dresses, sarees, and western wear for women.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBJRFFNE\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:15:\"Women Clothings\";s:4:\"slug\";s:15:\"women-clothings\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:16:21\";s:10:\"updated_at\";s:19:\"2026-03-24 12:16:21\";s:11:\"description\";s:44:\"Dresses, sarees, and western wear for women.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBSDY1NN\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:4:\"test\";s:4:\"slug\";s:4:\"test\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-26 06:17:47\";s:10:\"updated_at\";s:19:\"2026-03-26 06:17:47\";s:11:\"description\";s:4:\"test\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBSDY1NN\";s:11:\"category_id\";s:9:\"CAT5JEH0F\";s:4:\"name\";s:4:\"test\";s:4:\"slug\";s:4:\"test\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-26 06:17:47\";s:10:\"updated_at\";s:19:\"2026-03-26 06:17:47\";s:11:\"description\";s:4:\"test\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATJZIIWT\";s:4:\"name\";s:5:\"Books\";s:4:\"slug\";s:5:\"books\";s:5:\"image\";s:33:\"uploads/categories/1774352931.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:48:52\";s:10:\"updated_at\";s:19:\"2026-03-24 11:48:52\";s:11:\"description\";s:54:\"Educational, story, and motivational books collection.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATJZIIWT\";s:4:\"name\";s:5:\"Books\";s:4:\"slug\";s:5:\"books\";s:5:\"image\";s:33:\"uploads/categories/1774352931.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:48:52\";s:10:\"updated_at\";s:19:\"2026-03-24 11:48:52\";s:11:\"description\";s:54:\"Educational, story, and motivational books collection.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBJSFT4Z\";s:11:\"category_id\";s:9:\"CATJZIIWT\";s:4:\"name\";s:17:\"Educational Books\";s:4:\"slug\";s:17:\"educational-books\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:17:29\";s:10:\"updated_at\";s:19:\"2026-03-24 12:17:29\";s:11:\"description\";s:44:\"School, college, and competitive exam books.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBJSFT4Z\";s:11:\"category_id\";s:9:\"CATJZIIWT\";s:4:\"name\";s:17:\"Educational Books\";s:4:\"slug\";s:17:\"educational-books\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:17:29\";s:10:\"updated_at\";s:19:\"2026-03-24 12:17:29\";s:11:\"description\";s:44:\"School, college, and competitive exam books.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATK4CPFG\";s:4:\"name\";s:9:\"Groceries\";s:4:\"slug\";s:9:\"groceries\";s:5:\"image\";s:33:\"uploads/categories/1774354412.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:13:32\";s:10:\"updated_at\";s:19:\"2026-03-24 12:13:32\";s:11:\"description\";s:49:\"Daily grocery items including food and beverages.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATK4CPFG\";s:4:\"name\";s:9:\"Groceries\";s:4:\"slug\";s:9:\"groceries\";s:5:\"image\";s:33:\"uploads/categories/1774354412.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:13:32\";s:10:\"updated_at\";s:19:\"2026-03-24 12:13:32\";s:11:\"description\";s:49:\"Daily grocery items including food and beverages.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBNEPBGJ\";s:11:\"category_id\";s:9:\"CATK4CPFG\";s:4:\"name\";s:3:\"4rg\";s:4:\"slug\";s:3:\"4rg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-04-04 15:34:10\";s:10:\"updated_at\";s:19:\"2026-04-04 15:34:10\";s:11:\"description\";s:3:\"g4e\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBNEPBGJ\";s:11:\"category_id\";s:9:\"CATK4CPFG\";s:4:\"name\";s:3:\"4rg\";s:4:\"slug\";s:3:\"4rg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-04-04 15:34:10\";s:10:\"updated_at\";s:19:\"2026-04-04 15:34:10\";s:11:\"description\";s:3:\"g4e\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:4;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATLVMVW9\";s:4:\"name\";s:12:\"Toys & Games\";s:4:\"slug\";s:10:\"toys-games\";s:5:\"image\";s:33:\"uploads/categories/1774353862.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:59:20\";s:10:\"updated_at\";s:19:\"2026-03-24 12:04:22\";s:11:\"description\";s:43:\"Fun toys and indoor/outdoor games for kids.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATLVMVW9\";s:4:\"name\";s:12:\"Toys & Games\";s:4:\"slug\";s:10:\"toys-games\";s:5:\"image\";s:33:\"uploads/categories/1774353862.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:59:20\";s:10:\"updated_at\";s:19:\"2026-03-24 12:04:22\";s:11:\"description\";s:43:\"Fun toys and indoor/outdoor games for kids.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBT28UHJ\";s:11:\"category_id\";s:9:\"CATLVMVW9\";s:4:\"name\";s:12:\"Indoor Games\";s:4:\"slug\";s:12:\"indoor-games\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:18:38\";s:10:\"updated_at\";s:19:\"2026-03-24 12:18:38\";s:11:\"description\";s:47:\"Board games and indoor fun activities for kids.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBT28UHJ\";s:11:\"category_id\";s:9:\"CATLVMVW9\";s:4:\"name\";s:12:\"Indoor Games\";s:4:\"slug\";s:12:\"indoor-games\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:18:38\";s:10:\"updated_at\";s:19:\"2026-03-24 12:18:38\";s:11:\"description\";s:47:\"Board games and indoor fun activities for kids.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:5;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:11:\"Electronics\";s:4:\"slug\";s:11:\"electronics\";s:5:\"image\";s:33:\"uploads/categories/1774350715.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:11:55\";s:10:\"updated_at\";s:19:\"2026-03-24 11:11:55\";s:11:\"description\";s:65:\"Latest electronic gadgets like mobiles, laptops, and accessories.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:11:\"Electronics\";s:4:\"slug\";s:11:\"electronics\";s:5:\"image\";s:33:\"uploads/categories/1774350715.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:11:55\";s:10:\"updated_at\";s:19:\"2026-03-24 11:11:55\";s:11:\"description\";s:65:\"Latest electronic gadgets like mobiles, laptops, and accessories.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUB3JZQE8\";s:11:\"category_id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:11:\"Smartphones\";s:4:\"slug\";s:11:\"smartphones\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:14:54\";s:10:\"updated_at\";s:19:\"2026-03-24 12:14:54\";s:11:\"description\";s:58:\"Latest Android and iOS smartphones with advanced features.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUB3JZQE8\";s:11:\"category_id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:11:\"Smartphones\";s:4:\"slug\";s:11:\"smartphones\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:14:54\";s:10:\"updated_at\";s:19:\"2026-03-24 12:14:54\";s:11:\"description\";s:58:\"Latest Android and iOS smartphones with advanced features.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBIUJMAT\";s:11:\"category_id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:7:\"Laptops\";s:4:\"slug\";s:7:\"laptops\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:15:24\";s:10:\"updated_at\";s:19:\"2026-03-24 12:15:24\";s:11:\"description\";s:53:\"High performance laptops for work, gaming, and study.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBIUJMAT\";s:11:\"category_id\";s:9:\"CATSH6BLX\";s:4:\"name\";s:7:\"Laptops\";s:4:\"slug\";s:7:\"laptops\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:15:24\";s:10:\"updated_at\";s:19:\"2026-03-24 12:15:24\";s:11:\"description\";s:53:\"High performance laptops for work, gaming, and study.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:6;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATWNDJ1A\";s:4:\"name\";s:14:\"Home & Kitchen\";s:4:\"slug\";s:12:\"home-kitchen\";s:5:\"image\";s:33:\"uploads/categories/1774352843.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:47:24\";s:10:\"updated_at\";s:19:\"2026-03-24 11:47:24\";s:11:\"description\";s:48:\"Daily use home application & kitchen essentials.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATWNDJ1A\";s:4:\"name\";s:14:\"Home & Kitchen\";s:4:\"slug\";s:12:\"home-kitchen\";s:5:\"image\";s:33:\"uploads/categories/1774352843.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 11:47:24\";s:10:\"updated_at\";s:19:\"2026-03-24 11:47:24\";s:11:\"description\";s:48:\"Daily use home application & kitchen essentials.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUB7CTEYJ\";s:11:\"category_id\";s:9:\"CATWNDJ1A\";s:4:\"name\";s:20:\"Kitchen Applications\";s:4:\"slug\";s:20:\"kitchen-applications\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:17:01\";s:10:\"updated_at\";s:19:\"2026-03-24 12:17:01\";s:11:\"description\";s:50:\"Mixer, grinder, microwave, and cooking essentials.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUB7CTEYJ\";s:11:\"category_id\";s:9:\"CATWNDJ1A\";s:4:\"name\";s:20:\"Kitchen Applications\";s:4:\"slug\";s:20:\"kitchen-applications\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:17:01\";s:10:\"updated_at\";s:19:\"2026-03-24 12:17:01\";s:11:\"description\";s:50:\"Mixer, grinder, microwave, and cooking essentials.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:7;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"CATZP7PRJ\";s:4:\"name\";s:13:\"Beauty & Care\";s:4:\"slug\";s:11:\"beauty-care\";s:5:\"image\";s:33:\"uploads/categories/1774354071.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:07:51\";s:10:\"updated_at\";s:19:\"2026-03-24 12:07:51\";s:11:\"description\";s:51:\"Skincare, haircare, and personal grooming products.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"CATZP7PRJ\";s:4:\"name\";s:13:\"Beauty & Care\";s:4:\"slug\";s:11:\"beauty-care\";s:5:\"image\";s:33:\"uploads/categories/1774354071.jpg\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:07:51\";s:10:\"updated_at\";s:19:\"2026-03-24 12:07:51\";s:11:\"description\";s:51:\"Skincare, haircare, and personal grooming products.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:13:\"subCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:22:\"App\\Models\\SubCategory\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"sub_categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";s:9:\"SUBDHQYHQ\";s:11:\"category_id\";s:9:\"CATZP7PRJ\";s:4:\"name\";s:8:\"Skincare\";s:4:\"slug\";s:8:\"skincare\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:19:05\";s:10:\"updated_at\";s:19:\"2026-03-24 12:19:05\";s:11:\"description\";s:39:\"Face wash, creams, and beauty products.\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";s:9:\"SUBDHQYHQ\";s:11:\"category_id\";s:9:\"CATZP7PRJ\";s:4:\"name\";s:8:\"Skincare\";s:4:\"slug\";s:8:\"skincare\";s:6:\"status\";i:1;s:10:\"created_at\";s:19:\"2026-03-24 12:19:05\";s:10:\"updated_at\";s:19:\"2026-03-24 12:19:05\";s:11:\"description\";s:39:\"Face wash, creams, and beauty products.\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:11:\"category_id\";i:1;s:4:\"name\";i:2;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}', 1775643123);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active, 0:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `status`, `created_at`, `updated_at`, `description`) VALUES
('CAT54DJHU', 'Sports & Fitness', 'sports-fitness', 'uploads/categories/1774354161.jpg', 1, '2026-03-24 06:39:21', '2026-03-24 06:39:21', 'Gym equipment, sports gear, and fitness accessories.'),
('CAT5JEH0F', 'Fashion', 'fashion', 'uploads/categories/1774352333.jpg', 1, '2026-03-24 05:43:48', '2026-03-24 06:08:53', 'Trending clothes, shoes, and fashion accessories for men and women.'),
('CATJZIIWT', 'Books', 'books', 'uploads/categories/1774352931.jpg', 1, '2026-03-24 06:18:52', '2026-03-24 06:18:52', 'Educational, story, and motivational books collection.'),
('CATK4CPFG', 'Groceries', 'groceries', 'uploads/categories/1774354412.jpg', 1, '2026-03-24 06:43:32', '2026-03-24 06:43:32', 'Daily grocery items including food and beverages.'),
('CATLVMVW9', 'Toys & Games', 'toys-games', 'uploads/categories/1774353862.jpg', 1, '2026-03-24 06:29:20', '2026-03-24 06:34:22', 'Fun toys and indoor/outdoor games for kids.'),
('CATSH6BLX', 'Electronics', 'electronics', 'uploads/categories/1774350715.jpg', 1, '2026-03-24 05:41:55', '2026-03-24 05:41:55', 'Latest electronic gadgets like mobiles, laptops, and accessories.'),
('CATWNDJ1A', 'Home & Kitchen', 'home-kitchen', 'uploads/categories/1774352843.jpg', 1, '2026-03-24 06:17:24', '2026-03-24 06:17:24', 'Daily use home application & kitchen essentials.'),
('CATZP7PRJ', 'Beauty & Care', 'beauty-care', 'uploads/categories/1774354071.jpg', 1, '2026-03-24 06:37:51', '2026-03-24 06:37:51', 'Skincare, haircare, and personal grooming products.');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_comment` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`id`, `user_id`, `product_id`, `subject`, `message`, `admin_comment`, `status`, `created_at`, `updated_at`) VALUES
('COMPKCM8XQ', 'USRJ5PI64', NULL, 'Order Tracking & Logistics', 'jhbkl', 'dfghjkl;\'', 'resolved', '2026-03-28 04:12:26', '2026-03-28 04:31:30'),
('COMPKSWWHA', 'USRJ5PI64', 'PRDRVRZL2', 'Issue with Delivered Product', 'damaged', NULL, 'pending', '2026-03-28 04:08:03', '2026-03-28 04:08:03');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(2, 'Saurabh Kumar', 'saurabhkumarssp@gmail.com', '6556151455', 'saurabh@gmail.com', 'done', '2026-03-25 03:08:40', '2026-03-25 03:08:40'),
(3, 'ytt', 'r@gmais.com', '9623556464', 'bt', 'r', '2026-03-25 03:11:42', '2026-03-25 03:11:42');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `min_spend` decimal(10,2) NOT NULL DEFAULT 0.00,
  `expiry_date` date DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active, 0:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_amount`, `min_spend`, `expiry_date`, `status`, `created_at`, `updated_at`) VALUES
(1, 'SAVE200', 200.00, 5000.00, '2026-04-02', 1, '2026-03-26 07:55:19', '2026-03-30 07:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_20_051617_create_categories_table', 1),
(5, '2026_03_20_051618_create_sub_categories_table', 1),
(6, '2026_03_20_051619_create_products_table', 1),
(8, '2026_03_20_051621_create_offers_table', 1),
(9, '2026_03_20_051622_create_orders_table', 1),
(10, '2026_03_20_051623_create_order_trackings_table', 1),
(11, '2026_03_20_051624_create_wallet_transactions_table', 1),
(12, '2026_03_20_051625_create_wishlists_table', 1),
(13, '2026_03_20_051626_create_complaints_table', 1),
(14, '2026_03_20_051627_create_refunds_table', 1),
(15, '2026_03_20_051744_create_settings_table', 1),
(16, '2026_03_20_054803_add_admin_fields_to_users_table', 1),
(17, '2026_03_20_060557_create_admins_table', 1),
(18, '2026_03_20_075832_add_description_to_various_tables', 1),
(19, '2026_03_20_103916_add_extra_fields_to_products_table', 2),
(20, '2026_03_20_104337_add_variants_to_product_prices_table', 3),
(21, '2026_03_20_104903_add_status_to_sub_categories_table', 4),
(22, '2026_03_20_051620_create_product_prices_table', 5),
(23, '2026_03_20_113642_add_extra_fields_to_products_table', 6),
(24, '2026_03_20_113643_add_extra_fields_to_product_prices_table', 6),
(25, '2026_03_20_122915_create_product_images_table', 7),
(26, '2026_03_23_113702_create_carts_table', 8),
(27, '2026_03_23_122551_add_google_id_to_users_table', 9),
(28, '2026_03_23_132735_add_profile_fields_to_users_table', 10),
(29, '2026_03_25_074109_create_contacts_table', 11),
(30, '2026_03_25_075506_add_phone_to_contacts_table', 12),
(31, '2026_03_25_093843_create_user_addresses_table', 13),
(32, '2026_03_25_093844_create_order_items_table', 13),
(33, '2026_03_25_093845_update_orders_table_for_payments', 13),
(34, '2026_03_25_100210_add_cod_advance_to_products_table', 13),
(35, '2026_03_25_103948_rename_address_to_address_line_in_user_addresses_table', 14),
(37, '2026_03_26_085311_create_wallet_offers_table', 15),
(38, '2026_03_26_095936_add_is_blocked_to_users_table', 16),
(39, '2026_03_26_124355_add_shipping_charges_and_moq_to_products_table', 17),
(40, '2026_03_26_124401_create_coupons_table', 17),
(41, '2026_03_26_125302_add_extra_finance_to_orders_table', 18),
(43, '2026_03_26_130713_make_shipping_fields_nullable_on_products_table', 19),
(44, '2026_03_27_101936_create_support_tickets_table', 20),
(45, '2026_03_27_114149_remove_status_from_support_tickets_table', 21),
(46, '2026_03_27_170700_remove_status_from_support_tickets_table', 21),
(48, '2026_03_28_073709_create_product_reviews_table', 22),
(49, '2026_03_28_091351_add_product_and_reply_to_complaints_table', 23),
(50, '2026_03_28_093321_change_status_to_string_in_complaints_table', 24),
(51, '2026_03_29_100105_create_sub_admins_table', 25),
(52, '2026_03_29_175000_update_orders_and_products_for_returns', 26),
(53, '2026_03_29_140454_change_status_to_string_in_refunds_table', 27),
(54, '2026_03_29_143326_change_type_to_string_in_wallet_transactions_table', 28),
(55, '2026_04_01_101151_add_plain_password_to_admins_and_sub_admins_table', 29),
(56, '2026_04_01_102053_add_plain_password_to_users_table', 30),
(57, '2026_04_02_173000_add_performance_indexes', 31),
(58, '2026_04_04_055235_add_tracking_link_to_orders_table', 32),
(59, '2026_04_06_131656_create_seller_inquiries_table', 33),
(60, '2026_04_08_131043_add_plain_password_to_admins_and_sub_admins_v2', 34);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`id`, `product_id`, `discount_percentage`, `start_date`, `end_date`, `status`, `created_at`, `updated_at`, `description`) VALUES
('OFFREGDL1U', 'PRDRVRZL2', 10.00, '2026-03-05 00:00:00', '2026-04-03 00:00:00', 1, '2026-03-25 23:52:14', '2026-03-25 23:52:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `address_id` varchar(20) DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `advance_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `refund_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `refund_status` varchar(255) DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `return_status` varchar(255) DEFAULT NULL,
  `return_reason` text DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `prepaid_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `cod_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `order_status` varchar(255) NOT NULL DEFAULT 'placed',
  `tracking_link` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_number`, `total_amount`, `advance_paid`, `refund_amount`, `refund_status`, `cancel_reason`, `return_status`, `return_reason`, `delivered_at`, `shipping_amount`, `coupon_discount`, `coupon_code`, `prepaid_amount`, `cod_amount`, `payment_status`, `admin_note`, `order_status`, `tracking_link`, `payment_method`, `razorpay_order_id`, `razorpay_payment_id`, `created_at`, `updated_at`) VALUES
('ORD1BLZWF', 'USRJ5PI64', 'ADRXNULTK', 'ORD69C3E3F50E0C0', 259996.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 259996.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-25 08:02:37', '2026-03-25 08:02:37'),
('ORD2MPAGT', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0C222A437C', 2197.80, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 199.80, 0.00, NULL, 199.80, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZL3LnjZIivAKd', NULL, '2026-04-04 07:47:46', '2026-04-04 07:47:50'),
('ORD3JCC8D', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4FEB8D46BF', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 64999.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-26 04:09:04', '2026-03-26 04:09:04'),
('ORD3SCVHH', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4FECB4AFB3', 64999.00, 0.00, 64999.00, 'pending', NULL, 'pending', 'fghjk', '2026-03-29 08:47:35', 0.00, 0.00, NULL, 64999.00, 0.00, 'paid', NULL, 'return_requested', NULL, 'online', 'order_SVoFSIi2qwzgmB', NULL, '2026-03-26 04:09:23', '2026-03-29 08:48:10'),
('ORD4JOXTJ', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E802DF3C7', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 64999.00, 0.00, 'paid', NULL, 'placed', NULL, 'online', 'order_SVTsgBOINqvEHD', 'pay_SVTtAofNnDNZR9', '2026-03-25 08:19:54', '2026-03-25 08:20:46'),
('ORD8KOU9X', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C6308F2EDB2', 5844.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 50.00, 200.00, 'SAVE200', 169.88, 5674.12, 'pending', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-27 01:53:59', '2026-03-27 01:53:59'),
('ORD9V33W0', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C62FA8BF60C', 6044.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 50.00, 0.00, NULL, 169.88, 5874.12, 'unpaid', NULL, 'dispatched', 'http://localhost:8000/', 'cod', 'order_SWAJENtqoCpD1V', NULL, '2026-03-27 01:50:08', '2026-04-04 06:56:18'),
('ORDBBSDHK', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C539757FC8D', 64799.00, 0.00, 0.00, 'processed', 'ghjk', NULL, NULL, NULL, 0.00, 200.00, 'SAVE200', 0.00, 64799.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-26 08:19:41', '2026-04-04 00:59:17'),
('ORDBVZC24', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E05D48BE9', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 64999.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVTKEvz2c5uCjI', NULL, '2026-03-25 07:47:17', '2026-03-25 07:47:23'),
('ORDC4NGO3', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3EB00159DA', 194997.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 194997.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-25 08:32:40', '2026-03-25 08:32:40'),
('ORDCBKZLH', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C6301063EC5', 5824.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 30.00, 200.00, 'SAVE200', 5824.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SWAL4FYnNLOVpo', NULL, '2026-03-27 01:51:52', '2026-03-27 01:51:58'),
('ORDDOHQAS', 'USRJ5PI64', 'ADRXNULTK', 'ORD69D0C3A1F19C3', 2197.80, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 199.80, 0.00, NULL, 199.80, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLCgEszcX3jHg', NULL, '2026-04-04 07:54:10', '2026-04-04 07:56:40'),
('ORDDWSOSO', 'USRWIPWSQ', 'ADRHFXFSM', 'ORD69D5F4E079E9B', 2097.90, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 99.90, 0.00, NULL, 179.82, 1918.08, 'paid', NULL, 'confirmed', 'https://shiprocket.co/tracking/368394193143', 'cod', 'order_SatwNGBm8x9Egj', NULL, '2026-04-08 06:25:36', '2026-04-08 07:54:53'),
('ORDFQFYIA', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0C16ABB529', 2197.80, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 199.80, 0.00, NULL, 199.80, 1998.00, 'paid', NULL, 'placed', NULL, 'cod', 'order_SZL0Btv7nZa7Ik', NULL, '2026-04-04 07:44:42', '2026-04-04 07:46:25'),
('ORDFXDWO0', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4CE8418F2E', 389994.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 389994.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-26 00:43:24', '2026-03-26 00:43:24'),
('ORDFZ3VFO', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E1A5E0337', 259996.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 259996.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-25 07:52:45', '2026-03-25 07:52:45'),
('ORDGTAUGI', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0CAAA4C39F', 2037.96, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 39.96, 0.00, NULL, 39.96, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLnjLxq4VkypR', NULL, '2026-04-04 08:24:10', '2026-04-04 08:31:44'),
('ORDHLAHOQ', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0CA749183C', 2097.90, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 99.90, 0.00, NULL, 2097.90, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SZLeq8P8X0Cvoe', NULL, '2026-04-04 08:23:16', '2026-04-04 08:23:19'),
('ORDI7Y9BT', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C68DCE0E323', 2028.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 30.00, 0.00, NULL, 2028.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SWH9aeLwUUf7bY', NULL, '2026-03-27 08:31:50', '2026-03-27 08:31:57'),
('ORDI86WBA', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E866C9F1A', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 64999.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVTw5pkZbt3U0g', NULL, '2026-03-25 08:21:34', '2026-03-25 08:23:12'),
('ORDIHDJFV', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E1B0CFE30', 259996.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 259996.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVTQAPllE7R5h6', NULL, '2026-03-25 07:52:56', '2026-03-25 07:52:59'),
('ORDILULWF', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E53D5E55F', 259996.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 259996.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', NULL, NULL, '2026-03-25 08:08:05', '2026-03-25 08:08:05'),
('ORDKC4ZMV', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69CE34EC1DDF4', 1998.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, 'SAVE200', 1998.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', NULL, NULL, '2026-04-02 03:50:44', '2026-04-02 03:50:44'),
('ORDKCOOGG', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4CD4F56DC2', 389994.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 389994.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVkYGmlpnhdZrA', NULL, '2026-03-26 00:38:15', '2026-03-26 00:38:28'),
('ORDKOSL95', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E65278217', 259996.00, 0.00, 259996.00, 'pending', NULL, 'pending', 'gvhjk', NULL, 0.00, 0.00, NULL, 259996.00, 0.00, 'paid', NULL, 'return_requested', NULL, 'online', 'order_SVTl3PC1TUgdoo', 'pay_SVTmjNGTbSBjHE', '2026-03-25 08:12:42', '2026-03-31 02:33:05'),
('ORDKYLXTQ', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C534EC97A07', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 64999.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-26 08:00:20', '2026-03-26 08:00:20'),
('ORDMHU8XA', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4FEC3E26EE', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 64999.00, 'paid', NULL, 'out_for_delivery', NULL, 'cod', NULL, NULL, '2026-03-26 04:09:15', '2026-03-28 07:43:42'),
('ORDMQYKDB', 'USRJ5PI64', 'ADRXNULTK', 'ORD69CE35E13C9A8', 1998.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 1998.00, 0.00, 'paid', NULL, 'confirmed', NULL, 'online', 'order_SYZf3BIz1aIq32', 'pay_SYZfqmaYvf50wB', '2026-04-02 03:54:49', '2026-04-02 04:20:38'),
('ORDN4FGK3', 'USRJ5PI64', 'ADRXNULTK', 'ORD69D0CE55A296D', 2037.96, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 39.96, 0.00, NULL, 119.88, 1918.08, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLwMkaQ5NiRrW', NULL, '2026-04-04 08:39:49', '2026-04-04 08:39:55'),
('ORDNJUBJ4', 'USRJ5PI64', 'ADRXNULTK', 'ORD69D0C9B75A10A', 2197.80, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 199.80, 0.00, NULL, 199.80, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLbXjUeq1gq9a', NULL, '2026-04-04 08:20:07', '2026-04-04 08:20:12'),
('ORDPWFHKD', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C4CE9C4199B', 389994.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 389994.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVkdz97EfHf6lg', NULL, '2026-03-26 00:43:48', '2026-03-26 00:43:51'),
('ORDQ3COSP', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0CA1B92C34', 2037.96, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 39.96, 0.00, NULL, 39.96, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLdI6a5UNNLWG', NULL, '2026-04-04 08:21:47', '2026-04-04 08:21:51'),
('ORDRHOKYA', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C68C24EB6DF', 3027.00, 0.00, 3027.00, 'processed', 'done', NULL, NULL, NULL, 30.00, 0.00, 'SAVE200', 3027.00, 0.00, 'paid', NULL, 'cancelled', NULL, 'online', 'order_SWH29r4vY8BeFS', 'pay_SWH2RPe07HnzYP', '2026-03-27 08:24:44', '2026-03-29 06:59:25'),
('ORDRK7FDT', 'USRJ5PI64', 'ADRXNULTK', 'ORD69C3E402623D2', 259996.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 259996.00, 0.00, 'pending', NULL, 'placed', NULL, 'online', 'order_SVTadp2LfBn4GC', NULL, '2026-03-25 08:02:50', '2026-03-25 08:02:54'),
('ORDRX0MY6', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C5360E4440E', 64799.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 200.00, 'SAVE200', 0.00, 64799.00, 'paid', NULL, 'confirmed', 'http://localhost:8000/', 'cod', NULL, NULL, '2026-03-26 08:05:10', '2026-04-04 00:42:06'),
('ORDSE0ME4', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C68EC608B0D', 2048.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 50.00, 0.00, 'SAVE200', 89.96, 1958.04, 'pending', NULL, 'placed', NULL, 'cod', 'order_SWHDwJXqUZXHZB', NULL, '2026-03-27 08:35:58', '2026-03-27 08:36:04'),
('ORDSLOXRW', 'USRJ5PI64', 'ADRXNULTK', 'ORD69CF6EAE3B525', 1998.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 1998.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-04-03 02:09:26', '2026-04-03 02:09:26'),
('ORDT2GOKW', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C589F98D59C', 129998.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 129998.00, 'paid', NULL, 'confirmed', 'https://ht.com', 'cod', NULL, NULL, '2026-03-26 14:03:13', '2026-04-04 00:37:37'),
('ORDVIBOR5', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C626D747D10', 3047.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 50.00, 0.00, NULL, 109.94, 2937.06, 'pending', NULL, 'placed', NULL, 'cod', 'order_SW9fZ2ZqqwwBpj', NULL, '2026-03-27 01:12:31', '2026-03-27 01:12:42'),
('ORDVMDSMW', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C630CFAD8F3', 5844.00, 0.00, 5844.00, 'pending', NULL, 'Refunded', 'ertyui', '2026-03-29 08:46:14', 50.00, 200.00, 'SAVE200', 169.88, 5674.12, 'paid', NULL, 'delivered', NULL, 'cod', 'order_SWAOgxrvjpxsoP', NULL, '2026-03-27 01:55:03', '2026-03-29 08:46:14'),
('ORDVTXY2K', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C3E0726300E', 64999.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 64999.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-03-25 07:47:38', '2026-03-25 07:47:38'),
('ORDWHK6MJ', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69D0CC9414CFC', 1998.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 0.00, 0.00, NULL, 0.00, 1998.00, 'paid', NULL, 'placed', NULL, 'cod', NULL, NULL, '2026-04-04 08:32:20', '2026-04-04 08:32:20'),
('ORDWUBCJ6', 'USRJ5PI64', 'ADRXNULTK', 'ORD69D0C8C3C3749', 2197.80, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 199.80, 0.00, NULL, 199.80, 1998.00, 'pending', NULL, 'placed', NULL, 'cod', 'order_SZLaY2nXiMZUmH', NULL, '2026-04-04 08:16:03', '2026-04-04 08:19:15'),
('ORDZLUOAP', 'USRJ5PI64', 'ADRTYYW7V', 'ORD69C68EE91E892', 2048.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 50.00, 0.00, NULL, 89.96, 1958.04, 'unpaid', NULL, 'processing', NULL, 'cod', 'order_SWHEZZJfjOnetd', NULL, '2026-03-27 08:36:33', '2026-03-27 12:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` varchar(20) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
('OIT1BK6U6', 'ORDRHOKYA', 'PRDRVRZL2', 3, 999.00, '2026-03-27 08:24:45', '2026-03-27 08:24:45'),
('OIT1V0GNF', 'ORDN4FGK3', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:39:49', '2026-04-04 08:39:49'),
('OIT2UN1G2', 'ORDVMDSMW', 'PRDRVRZL2', 6, 999.00, '2026-03-27 01:55:03', '2026-03-27 01:55:03'),
('OIT2YGQGR', 'ORDMQYKDB', 'PRDRVRZL2', 2, 999.00, '2026-04-02 03:54:49', '2026-04-02 03:54:49'),
('OIT32UT3N', 'ORDI86WBA', 'PRDRVRZL2', 1, 64999.00, '2026-03-25 08:21:34', '2026-03-25 08:21:34'),
('OIT4SIADT', 'ORDKOSL95', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 08:12:42', '2026-03-25 08:12:42'),
('OIT5DWLSW', 'ORD3SCVHH', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 04:09:23', '2026-03-26 04:09:23'),
('OIT7QLHR0', 'ORDRK7FDT', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 08:02:50', '2026-03-25 08:02:50'),
('OIT9F3WDM', 'ORDWUBCJ6', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:16:04', '2026-04-04 08:16:04'),
('OITAJHKZY', 'ORDDWSOSO', 'PRDRVRZL2', 2, 999.00, '2026-04-08 06:25:40', '2026-04-08 06:25:40'),
('OITARLHC7', 'ORDNJUBJ4', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:20:07', '2026-04-04 08:20:07'),
('OITATKHUI', 'ORDT2GOKW', 'PRDRVRZL2', 2, 64999.00, '2026-03-26 14:03:13', '2026-03-26 14:03:13'),
('OITB77VY0', 'ORDVIBOR5', 'PRDRVRZL2', 3, 999.00, '2026-03-27 01:12:31', '2026-03-27 01:12:31'),
('OITBMKSM7', 'ORDQ3COSP', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:21:47', '2026-04-04 08:21:47'),
('OITCWIT5Q', 'ORDC4NGO3', 'PRDRVRZL2', 3, 64999.00, '2026-03-25 08:32:40', '2026-03-25 08:32:40'),
('OITDSJXM2', 'ORDSLOXRW', 'PRDRVRZL2', 2, 999.00, '2026-04-03 02:09:26', '2026-04-03 02:09:26'),
('OITFIPFPE', 'ORD4JOXTJ', 'PRDRVRZL2', 1, 64999.00, '2026-03-25 08:19:54', '2026-03-25 08:19:54'),
('OITFVKKDC', 'ORD9V33W0', 'PRDRVRZL2', 6, 999.00, '2026-03-27 01:50:08', '2026-03-27 01:50:08'),
('OITFYR874', 'ORDBBSDHK', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 08:19:41', '2026-03-26 08:19:41'),
('OITGKU2K8', 'ORDILULWF', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 08:08:05', '2026-03-25 08:08:05'),
('OITH16BPS', 'ORD1BLZWF', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 08:02:37', '2026-03-25 08:02:37'),
('OITH5CKUP', 'ORDKC4ZMV', 'PRDRVRZL2', 2, 999.00, '2026-04-02 03:50:44', '2026-04-02 03:50:44'),
('OITHTRXRG', 'ORDBVZC24', 'PRDRVRZL2', 1, 64999.00, '2026-03-25 07:47:17', '2026-03-25 07:47:17'),
('OITIX2TBH', 'ORDPWFHKD', 'PRDRVRZL2', 6, 64999.00, '2026-03-26 00:43:48', '2026-03-26 00:43:48'),
('OITJDAKKI', 'ORD8KOU9X', 'PRDRVRZL2', 6, 999.00, '2026-03-27 01:53:59', '2026-03-27 01:53:59'),
('OITJHRI3V', 'ORD3JCC8D', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 04:09:04', '2026-03-26 04:09:04'),
('OITJL80Z1', 'ORDCBKZLH', 'PRDRVRZL2', 6, 999.00, '2026-03-27 01:51:52', '2026-03-27 01:51:52'),
('OITKWZOYV', 'ORDI7Y9BT', 'PRDRVRZL2', 2, 999.00, '2026-03-27 08:31:50', '2026-03-27 08:31:50'),
('OITKYF0JD', 'ORDGTAUGI', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:24:10', '2026-04-04 08:24:10'),
('OITKZS5XO', 'ORDRX0MY6', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 08:05:10', '2026-03-26 08:05:10'),
('OITLC720S', 'ORD2MPAGT', 'PRDRVRZL2', 2, 999.00, '2026-04-04 07:47:46', '2026-04-04 07:47:46'),
('OITLQ3HIB', 'ORDSE0ME4', 'PRDRVRZL2', 2, 999.00, '2026-03-27 08:35:58', '2026-03-27 08:35:58'),
('OITMX1CJK', 'ORDDOHQAS', 'PRDRVRZL2', 2, 999.00, '2026-04-04 07:54:10', '2026-04-04 07:54:10'),
('OITNXYXZ1', 'ORDMHU8XA', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 04:09:15', '2026-03-26 04:09:15'),
('OITOPQL3Z', 'ORDFQFYIA', 'PRDRVRZL2', 2, 999.00, '2026-04-04 07:44:42', '2026-04-04 07:44:42'),
('OITOYBTBZ', 'ORDZLUOAP', 'PRDRVRZL2', 2, 999.00, '2026-03-27 08:36:33', '2026-03-27 08:36:33'),
('OITPXGM6I', 'ORDHLAHOQ', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:23:16', '2026-04-04 08:23:16'),
('OITQI1JWK', 'ORDVTXY2K', 'PRDRVRZL2', 1, 64999.00, '2026-03-25 07:47:38', '2026-03-25 07:47:38'),
('OITR1TECR', 'ORDKYLXTQ', 'PRDRVRZL2', 1, 64999.00, '2026-03-26 08:00:20', '2026-03-26 08:00:20'),
('OITROSKJG', 'ORDFXDWO0', 'PRDRVRZL2', 6, 64999.00, '2026-03-26 00:43:24', '2026-03-26 00:43:24'),
('OITUBXM6U', 'ORDFZ3VFO', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 07:52:45', '2026-03-25 07:52:45'),
('OITWY7HQA', 'ORDIHDJFV', 'PRDRVRZL2', 4, 64999.00, '2026-03-25 07:52:56', '2026-03-25 07:52:56'),
('OITYIOF51', 'ORDWHK6MJ', 'PRDRVRZL2', 2, 999.00, '2026-04-04 08:32:20', '2026-04-04 08:32:20'),
('OITYKTNIQ', 'ORDKCOOGG', 'PRDRVRZL2', 6, 64999.00, '2026-03-26 00:38:15', '2026-03-26 00:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_trackings`
--

CREATE TABLE `order_trackings` (
  `id` varchar(20) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `status` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_trackings`
--

INSERT INTO `order_trackings` (`id`, `order_id`, `status`, `message`, `created_at`, `updated_at`) VALUES
('TRK16BABO', 'ORD3SCVHH', 'delivered', 'fghj', '2026-03-29 08:47:35', '2026-03-29 08:47:35'),
('TRK28QHO2', 'ORDZLUOAP', 'processing', 'rdfgyhuj', '2026-03-27 12:08:38', '2026-03-27 12:08:38'),
('TRK6PUJQP', 'ORD3SCVHH', 'pending', 'fghjkloiuytretyhujkl', '2026-03-28 07:30:05', '2026-03-28 07:30:05'),
('TRK7VMN45', 'ORDI86WBA', 'update', 'adsfghj', '2026-03-27 12:05:40', '2026-03-27 12:05:40'),
('TRKAZWOSF', 'ORD3SCVHH', 'shipped', 'cvbnm,', '2026-03-28 07:22:27', '2026-03-28 07:22:27'),
('TRKBVH1XD', 'ORDVMDSMW', 'delivered', 'dfghj', '2026-03-29 08:22:01', '2026-03-29 08:22:01'),
('TRKCHZVG4', 'ORDVMDSMW', 'returned', 'fghjk', '2026-03-29 08:44:12', '2026-03-29 08:44:12'),
('TRKDLPWB4', 'ORDBBSDHK', 'placed', 'ghj', '2026-04-04 00:59:18', '2026-04-04 00:59:18'),
('TRKFDP7EC', 'ORD1BLZWF', 'update', 'dispatch', '2026-03-25 08:34:47', '2026-03-25 08:34:47'),
('TRKFSYJY9', 'ORDKOSL95', 'shipped', 'hjbhjrgt', '2026-03-26 06:57:23', '2026-03-26 06:57:23'),
('TRKG0UCQW', 'ORDVMDSMW', 'placed', 'fghj', '2026-03-29 08:42:22', '2026-03-29 08:42:22'),
('TRKH9ZP8R', 'ORD3SCVHH', 'return_requested', 'Return request submitted by User. Reason: fghjk', '2026-03-29 08:48:10', '2026-03-29 08:48:10'),
('TRKJ3Q7DP', 'ORDRX0MY6', 'confirmed', 'afsdfg', '2026-04-04 00:42:07', '2026-04-04 00:42:07'),
('TRKJ74XSA', 'ORDMHU8XA', 'out_for_delivery', 'jai ho', '2026-03-28 07:43:43', '2026-03-28 07:43:43'),
('TRKJGFI1Y', 'ORDVMDSMW', 'delivered', 'dftyuio', '2026-03-29 08:07:38', '2026-03-29 08:07:38'),
('TRKJKMXJ1', 'ORD9V33W0', 'dispatched', 'rg', '2026-04-04 06:56:18', '2026-04-04 06:56:18'),
('TRKJOOBVZ', 'ORDZLUOAP', 'confirmed', 'fghj', '2026-03-27 12:08:23', '2026-03-27 12:08:23'),
('TRKK7HPEP', 'ORDMQYKDB', 'confirmed', 'confirmed', '2026-04-02 04:20:38', '2026-04-02 04:20:38'),
('TRKMIJMQB', 'ORD9V33W0', 'processing', 'sfdghj', '2026-04-04 01:22:30', '2026-04-04 01:22:30'),
('TRKMJQ5AH', 'ORDVMDSMW', 'delivered', 'Order status updated to delivered', '2026-03-29 08:46:14', '2026-03-29 08:46:14'),
('TRKNDJML5', 'ORDRHOKYA', 'cancelled', 'Order cancelled by User. Reason: done', '2026-03-29 06:59:25', '2026-03-29 06:59:25'),
('TRKNWIVZE', 'ORDT2GOKW', 'confirmed', 't4hy', '2026-04-04 00:37:38', '2026-04-04 00:37:38'),
('TRKNXJLKJ', 'ORDKOSL95', 'return_requested', 'Return request submitted by User. Reason: gvhjk', '2026-03-31 02:33:05', '2026-03-31 02:33:05'),
('TRKP7GUA8', 'ORDBBSDHK', 'cancelled', 'Order cancellation request submitted by User. Reason: ghjk', '2026-03-29 09:02:18', '2026-03-29 09:02:18'),
('TRKWJHGFD', 'ORDDWSOSO', 'confirmed', 'confirmed', '2026-04-08 07:53:06', '2026-04-08 07:53:06'),
('TRKX92I09', 'ORD9V33W0', 'confirmed', 'rt', '2026-04-04 01:20:40', '2026-04-04 01:20:40'),
('TRKXEDFWE', 'ORDKOSL95', 'delivered', 'jhghj', '2026-03-26 06:57:59', '2026-03-26 06:57:59'),
('TRKY7M3YI', 'ORDDWSOSO', 'confirmed', 'confirmed', '2026-04-08 07:54:53', '2026-04-08 07:54:53'),
('TRKYQ21DK', 'ORDRX0MY6', 'confirmed', 'hj', '2026-04-04 00:34:42', '2026-04-04 00:34:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(20) NOT NULL,
  `subcategory_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `manufacturer` varchar(255) DEFAULT NULL,
  `seller_name` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `gst_tax` decimal(8,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `tags` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `shipping_charges` decimal(10,2) NOT NULL DEFAULT 0.00,
  `online_shipping_charges` decimal(10,2) DEFAULT NULL,
  `cod_shipping_charges` decimal(10,2) DEFAULT NULL,
  `cod_advance_percent` decimal(10,2) DEFAULT NULL,
  `is_free_shipping` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active, 0:inactive',
  `return_days` int(11) NOT NULL DEFAULT 7,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `return_policy` text DEFAULT NULL,
  `warranty_info` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stock_status` varchar(255) NOT NULL DEFAULT 'In Stock',
  `featured` tinyint(1) NOT NULL DEFAULT 0,
  `trending` tinyint(1) NOT NULL DEFAULT 0,
  `warranty` text DEFAULT NULL,
  `mrp` decimal(10,2) DEFAULT NULL,
  `selling_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `minimum_order_quantity` int(11) NOT NULL DEFAULT 1,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `subcategory_id`, `name`, `brand`, `manufacturer`, `seller_name`, `sku`, `slug`, `description`, `short_description`, `gst_tax`, `image`, `gallery_images`, `tags`, `weight`, `dimensions`, `shipping_charges`, `online_shipping_charges`, `cod_shipping_charges`, `cod_advance_percent`, `is_free_shipping`, `status`, `return_days`, `is_featured`, `is_trending`, `return_policy`, `warranty_info`, `meta_title`, `meta_description`, `meta_keywords`, `created_at`, `updated_at`, `stock_status`, `featured`, `trending`, `warranty`, `mrp`, `selling_price`, `stock`, `minimum_order_quantity`, `size`, `color`) VALUES
('PRDRVRZL2', 'SUB3JZQE8', 'iPhone 13', 'Apple', 'Apple Inc', 'Appario Retail', 'PRD-002', 'iphone-13-1774355506', 'Latest Apple smartphone with A15 chip.', NULL, 0.00, 'uploads/products/1774355506.jpg', NULL, 'mobile, ios', '173g', '14x7x0.7 cm', 0.00, 0.00, 0.00, 0.00, 0, 1, 7, 0, 0, '7 days', NULL, NULL, NULL, NULL, '2026-03-24 07:01:46', '2026-03-27 01:10:50', 'In Stock', 1, 1, '1 years', 69999.00, 999.00, 30, 2, '', ',Blue,Black');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `created_at`, `updated_at`) VALUES
(5, 'PRDRVRZL2', 'uploads/products/gallery/XSFWpkbRNu_1774355506.jpg', '2026-03-24 07:01:46', '2026-03-24 07:01:46'),
(6, 'PRDRVRZL2', 'uploads/products/gallery/rulRYutmtH_1774355507.jpg', '2026-03-24 07:01:47', '2026-03-24 07:01:47'),
(8, 'PRDRVRZL2', 'uploads/products/gallery/sQzOVtQeHa_1774420410.jpg', '2026-03-25 01:03:30', '2026-03-25 01:03:30');

-- --------------------------------------------------------

--
-- Table structure for table `product_prices`
--

CREATE TABLE `product_prices` (
  `id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `selling_price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `comment` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `admin_reply` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `status`, `admin_reply`, `created_at`, `updated_at`) VALUES
(1, 'USRJ5PI64', 'PRDRVRZL2', 3, 'jai ho', 1, 'thanks', '2026-03-28 02:42:53', '2026-03-28 02:43:37');

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` varchar(20) NOT NULL,
  `order_id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `refunds`
--

INSERT INTO `refunds` (`id`, `order_id`, `user_id`, `amount`, `status`, `reason`, `created_at`, `updated_at`) VALUES
('RFNDB1ZNOG', 'ORD3SCVHH', 'USRJ5PI64', 64999.00, 'approved', 'Return: fghjk', '2026-03-29 08:48:10', '2026-03-29 08:59:52'),
('RFNDJZWCEU', 'ORDKOSL95', 'USRJ5PI64', 259996.00, 'pending', 'Return: gvhjk', '2026-03-31 02:33:05', '2026-03-31 02:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `seller_inquiries`
--

CREATE TABLE `seller_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_inquiries`
--

INSERT INTO `seller_inquiries` (`id`, `name`, `email`, `phone`, `business_name`, `business_type`, `message`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Saurabh Kumar', 'saurabhkumarssp@gmail.com', '7705397065', 'htr', 'Retailer', 'htr', 'approved', '2026-04-06 08:40:48', '2026-04-06 09:04:11'),
(2, 'Saurabh', 'saurabhkumarssp@gmail.com', '9311534354', 'digicoders technology', 'Retailer', 'done', 'pending', '2026-04-08 06:11:34', '2026-04-08 06:11:34');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('BKDVEEAgnxVPs9NAuLaVO6uawhvVrznpfoPOVgTV', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM1NnTWJCRVFBU3hsbGtoajExVE80dU81TWY1MTlndUFlNkhNTFVmRiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyOToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL3Byb2ZpbGUiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czoyNjoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2F1dGgiO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774334832),
('jH61gyLFTVWGHYICaDYUvJwT3IELgYuE4V08PDSy', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSWh1eHJKRXBoRUhaZ1VtZ3A2UWVlOUwwbUVEeWpsVjBYeEE5TjJjTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hdXRoIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774332173);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'global_cod_advance_percent', '4', '2026-03-26 13:49:30', '2026-04-04 08:21:08'),
(2, 'global_cod_shipping', '5', '2026-03-26 13:49:30', '2026-04-04 12:44:57'),
(3, 'global_online_shipping', '2', '2026-03-26 13:49:30', '2026-04-04 12:44:57'),
(4, 'min_order_price', '1', '2026-03-26 13:49:30', '2026-04-03 02:05:31'),
(5, 'min_free_delivery_amount', '500', '2026-03-26 13:49:30', '2026-03-26 13:49:30'),
(6, 'support_email', 'support@shoppingclubindia.com', '2026-03-26 13:49:30', '2026-03-26 13:49:30'),
(7, 'support_phone', '+91 999 999 9999', '2026-03-26 13:49:30', '2026-03-26 13:49:30'),
(8, 'cashback_percentage', '0', '2026-03-26 13:49:30', '2026-03-26 13:49:30');

-- --------------------------------------------------------

--
-- Table structure for table `sub_admins`
--

CREATE TABLE `sub_admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `plain_password` varchar(255) DEFAULT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_admins`
--

INSERT INTO `sub_admins` (`id`, `name`, `username`, `email`, `mobile`, `password`, `plain_password`, `permissions`, `status`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'vipin', 'vipin55', 'vipinpal@gmail.com', '7705839870', '$2y$12$lPHc6wBAwOlzkpGL4YtcNuNZTiOECadkhscLYK.Vt3hF.8ngApCDS', 'vipin123', '[\"dashboard_view\",\"categories_view\",\"categories_add\",\"categories_edit\",\"categories_delete\"]', 1, '2026-04-08 07:42:58', NULL, '2026-03-29 05:01:39', '2026-04-08 09:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` varchar(20) NOT NULL,
  `category_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:active, 0:inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `name`, `slug`, `status`, `created_at`, `updated_at`, `description`) VALUES
('SUB3JZQE8', 'CATSH6BLX', 'Smartphones', 'smartphones', 1, '2026-03-24 06:44:54', '2026-03-24 06:44:54', 'Latest Android and iOS smartphones with advanced features.'),
('SUB7CTEYJ', 'CATWNDJ1A', 'Kitchen Applications', 'kitchen-applications', 1, '2026-03-24 06:47:01', '2026-03-24 06:47:01', 'Mixer, grinder, microwave, and cooking essentials.'),
('SUBDHQYHQ', 'CATZP7PRJ', 'Skincare', 'skincare', 1, '2026-03-24 06:49:05', '2026-03-24 06:49:05', 'Face wash, creams, and beauty products.'),
('SUBEINCJH', 'CAT5JEH0F', 'Clothings', 'clothings', 1, '2026-03-24 06:45:49', '2026-03-24 06:45:49', 'Stylish shirts, jeans, and traditional wear for men.'),
('SUBIUJMAT', 'CATSH6BLX', 'Laptops', 'laptops', 1, '2026-03-24 06:45:24', '2026-03-24 06:45:24', 'High performance laptops for work, gaming, and study.'),
('SUBJRFFNE', 'CAT5JEH0F', 'Women Clothings', 'women-clothings', 1, '2026-03-24 06:46:21', '2026-03-24 06:46:21', 'Dresses, sarees, and western wear for women.'),
('SUBJSFT4Z', 'CATJZIIWT', 'Educational Books', 'educational-books', 1, '2026-03-24 06:47:29', '2026-03-24 06:47:29', 'School, college, and competitive exam books.'),
('SUBNEPBGJ', 'CATK4CPFG', '4rg', '4rg', 1, '2026-04-04 10:04:10', '2026-04-04 10:04:10', 'g4e'),
('SUBOFXV61', 'CAT54DJHU', 'Gim Equipment', 'gim-equipment', 1, '2026-03-24 06:49:54', '2026-03-24 06:49:54', 'Dumbbells, treadmills, and workout machines.'),
('SUBSDY1NN', 'CAT5JEH0F', 'test', 'test', 1, '2026-03-26 00:47:47', '2026-03-26 00:47:47', 'test'),
('SUBT28UHJ', 'CATLVMVW9', 'Indoor Games', 'indoor-games', 1, '2026-03-24 06:48:38', '2026-03-24 06:48:38', 'Board games and indoor fun activities for kids.');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `suggestion` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `name`, `email`, `phone`, `message`, `suggestion`, `created_at`, `updated_at`) VALUES
(1, 'Saurabh kumar', 'saurabh@gmail.com', '7705839870', 'test', 'test', '2026-03-27 05:38:57', '2026-03-27 06:10:55'),
(2, 'Saurabh kumar', 'saurabh@gmail.com', '7705839870', 'test', 'test', '2026-03-27 05:39:26', '2026-03-27 05:39:26'),
(3, 'Saurabh kumar', 'saurabh@gmail.com', '7705839870', 'test', 'ett', '2026-03-27 05:41:38', '2026-03-27 05:41:38'),
(4, 'Saurabh kumar', 'saurabh@gmail.com', '7705839870', 'jai ho', 'jai bharat', '2026-03-27 05:47:41', '2026-03-27 05:47:41'),
(5, 'Saurabh kumar', 'saurabh@gmail.com', '7705839870', 'test', 'test', '2026-03-27 05:54:55', '2026-03-27 05:54:55'),
(6, 'Saurabh Kumar', 'saurabhkumarssp@gmail.com', '7707897898', 'test', 'test', '2026-04-02 03:43:12', '2026-04-02 03:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_blocked` tinyint(1) NOT NULL DEFAULT 0,
  `mobile` varchar(255) DEFAULT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `alt_mobile` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `plain_password` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `wallet_balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_blocked`, `mobile`, `profile_photo`, `address`, `city`, `state`, `pincode`, `alt_mobile`, `email_verified_at`, `password`, `plain_password`, `google_id`, `is_admin`, `wallet_balance`, `remember_token`, `created_at`, `updated_at`) VALUES
('USR20QWIV', 'Test User', 'test@example.com', 0, '9999999999', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$BucgbkD41N71WOrTvZlIrebTcW84dNYcMH2N1vQPaLSamod2R39hK', NULL, NULL, 0, 0.00, NULL, '2026-03-27 14:31:42', '2026-03-27 14:31:42'),
('USR458BSB', 'Test User', 'testuser123@example.com', 0, '9876543210', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$m3/zCH5umL8qaC.iOyrAee8/qaBx/LC1wJ88KT3KrsdfJd43280NC', NULL, NULL, 0, 0.00, NULL, '2026-03-24 00:51:57', '2026-03-26 05:29:57'),
('USRJ5PI64', 'Saurabh kumar', 'saurabh@gmail.com', 0, '7705839870', 'profile_photos/YcH0FVfwSTBUi96XImgovsi1aBJDA4Il7ZZi8uNn.jpg', 'Pooranpur Lambhua sultanpur', 'Sultanpur', 'Uttar Pradesh', '222302', NULL, NULL, '$2y$12$dT3OQLDTPC42wDqCTEVSzuRg.wDUFU/IHmGZ.0F87JGFxtAEz7WUK', NULL, NULL, 0, 66179.32, 'HieUafBTN1b5PJgYXnTePMlqR2mRsxSCUchYPWRoBlxfGkH0AqAJ3JRgSYOE', '2026-03-23 07:22:44', '2026-04-04 07:46:25'),
('USRRNFIWV', 'Test User', 'test661@example.com', 0, '0000000145', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$Tyq9jE0Z5YfsAL9EavMTm.GS.shv/Rz9PMaOhMtTB9gRwjJ9XwlWW', NULL, NULL, 0, 0.00, NULL, '2026-03-23 07:13:48', '2026-03-26 05:29:25'),
('USRVJARK4', 'Test User', 'test113237@example.com', 0, '9288238931', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$u1Bm9neqVG9zAlCK/bzNZ.1Gygc0Bs5nPTAcWN.6OQQ.WZVMGJNgi', NULL, NULL, 0, 0.00, NULL, '2026-03-28 15:00:24', '2026-03-28 15:00:24'),
('USRWIPWSQ', 'Gaurav', 'gaurav@gmail.com', 0, '7705939970', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$12$VJzPIK9GRbNFWyteFyTJwu3LqpLxIPxTBI7B1xxf2S8WR/CBjp9e6', 'Gaurav123', NULL, 0, 5050.00, NULL, '2026-04-08 06:14:11', '2026-04-08 07:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `alt_mobile` varchar(255) DEFAULT NULL,
  `address_line` text NOT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'Home',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `name`, `mobile`, `alt_mobile`, `address_line`, `landmark`, `city`, `state`, `pincode`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
('ADRHFXFSM', 'USRWIPWSQ', 'Priyanshu', '6378918051', NULL, 'POORANPUR', 'Adhiyapur', 'Etawah', 'Uttar Pradesh', '206002', 'Home', 1, '2026-04-08 06:21:29', '2026-04-08 06:21:29'),
('ADRTYYW7V', 'USRJ5PI64', 'Saurabh Kumar', '351351513', NULL, 'Jagdishpur\r\nPooranpur', NULL, 'Sultanpur', 'Uttar Pradesh', '222302', 'Home', 0, '2026-03-25 07:46:35', '2026-03-27 12:47:27'),
('ADRXNULTK', 'USRJ5PI64', 'gaurav', '745646654', NULL, 'Pooranpur Lambhua sultanpur', NULL, 'Sultanpur', 'Uttar Pradesh', '222302', 'Work', 1, '2026-03-25 07:56:55', '2026-03-27 12:48:05');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_offers`
--

CREATE TABLE `wallet_offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `min_amount` decimal(10,2) NOT NULL,
  `bonus_amount` decimal(10,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_offers`
--

INSERT INTO `wallet_offers` (`id`, `min_amount`, `bonus_amount`, `status`, `created_at`, `updated_at`) VALUES
(1, 500.00, 25.00, 1, '2026-03-26 03:45:54', '2026-03-26 03:45:54'),
(2, 1500.00, 50.00, 1, '2026-03-26 03:57:34', '2026-03-26 03:57:34'),
(3, 5000.00, 50.00, 1, '2026-04-08 07:16:36', '2026-04-08 07:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_transactions`
--

INSERT INTO `wallet_transactions` (`id`, `user_id`, `amount`, `type`, `description`, `created_at`, `updated_at`) VALUES
('WAL6RW79J', 'USRWIPWSQ', 5000.00, '1', 'Wallet Recharge via Razorpay', '2026-04-08 07:20:50', '2026-04-08 07:20:50'),
('WAL9ZWM7M', 'USRJ5PI64', 25.00, '1', 'Wallet Bonus (Offer)', '2026-03-26 04:00:17', '2026-03-26 04:00:17'),
('WALDPXB11', 'USRWIPWSQ', 50.00, '1', 'Wallet Bonus (Offer)', '2026-04-08 07:20:50', '2026-04-08 07:20:50'),
('WALMQCB4Z', 'USRJ5PI64', 1000.00, '1', 'Wallet Recharge via Razorpay', '2026-03-26 04:00:17', '2026-03-26 04:00:17'),
('WALPP4YNI', 'USRJ5PI64', 25.00, '1', 'Wallet Bonus (Offer)', '2026-03-26 03:56:15', '2026-03-26 03:56:15'),
('WALSWFGUF', 'USRJ5PI64', 169.88, '2', 'Payment for Order #ORD69C630CFAD8F3', '2026-03-27 01:55:50', '2026-03-27 01:55:50'),
('WALXKSF9G', 'USRJ5PI64', 500.00, '1', 'Wallet Recharge via Razorpay', '2026-03-26 03:56:15', '2026-03-26 03:56:15'),
('WALYAJIUH', 'USRJ5PI64', 199.80, '2', 'Payment for Order #ORD69D0C16ABB529', '2026-04-04 07:46:25', '2026-04-04 07:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` varchar(20) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `product_id` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
('WSHGKPOQS', 'USRJ5PI64', 'PRDRVRZL2', '2026-04-02 04:03:18', '2026-04-02 04:03:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_foreign` (`user_id`),
  ADD KEY `carts_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `complaints_user_id_foreign` (`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_product_id_foreign` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_order_status_index` (`order_status`),
  ADD KEY `orders_payment_status_index` (`payment_status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_trackings`
--
ALTER TABLE `order_trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_trackings_order_id_foreign` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`),
  ADD KEY `products_status_index` (`status`),
  ADD KEY `products_featured_index` (`featured`),
  ADD KEY `products_trending_index` (`trending`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `refunds_order_id_foreign` (`order_id`),
  ADD KEY `refunds_user_id_foreign` (`user_id`);

--
-- Indexes for table `seller_inquiries`
--
ALTER TABLE `seller_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sub_admins`
--
ALTER TABLE `sub_admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_admins_username_unique` (`username`),
  ADD UNIQUE KEY `sub_admins_email_unique` (`email`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  ADD KEY `sub_categories_category_id_foreign` (`category_id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_is_blocked_index` (`is_blocked`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `wallet_offers`
--
ALTER TABLE `wallet_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_transactions_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlists_user_id_foreign` (`user_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `seller_inquiries`
--
ALTER TABLE `seller_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sub_admins`
--
ALTER TABLE `sub_admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wallet_offers`
--
ALTER TABLE `wallet_offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_trackings`
--
ALTER TABLE `order_trackings`
  ADD CONSTRAINT `order_trackings_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_prices`
--
ALTER TABLE `product_prices`
  ADD CONSTRAINT `product_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `refunds`
--
ALTER TABLE `refunds`
  ADD CONSTRAINT `refunds_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `refunds_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
