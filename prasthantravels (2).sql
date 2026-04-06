-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Apr 04, 2026 at 01:34 PM
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
-- Database: `prasthantravels`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `source` varchar(191) DEFAULT NULL,
  `destination` text DEFAULT NULL,
  `travel_date` date NOT NULL,
  `travel_time` time NOT NULL,
  `mobile` varchar(191) NOT NULL,
  `booking_type` varchar(191) NOT NULL DEFAULT 'outstation',
  `sub_type` varchar(191) DEFAULT NULL,
  `package_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `name`, `email`, `source`, `destination`, `travel_date`, `travel_time`, `mobile`, `booking_type`, `sub_type`, `package_id`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'sultanpur', 'lucknow', '2026-02-12', '14:49:00', '8568569855', 'outstation', NULL, NULL, 'pending', '2026-02-06 01:49:54', '2026-02-06 01:49:54'),
(2, NULL, NULL, 'wfw', 'f3', '2026-02-18', '14:54:00', '5456456461', 'outstation', NULL, NULL, 'pending', '2026-02-06 01:55:02', '2026-02-06 01:55:02'),
(4, NULL, NULL, 'ghjk', 'gh', '2026-02-26', '11:38:00', '4444444445', 'outstation', NULL, NULL, 'pending', '2026-02-09 00:38:19', '2026-02-09 00:38:19'),
(5, NULL, NULL, 'sultanpur', 'varanasi', '2026-02-26', '01:44:00', '7410852965', 'outstation', NULL, NULL, 'pending', '2026-02-09 00:43:35', '2026-02-09 00:43:35'),
(6, NULL, NULL, 'jaunpur', 'chanda', '2026-02-05', '11:51:00', '7410852095', 'outstation', NULL, NULL, 'pending', '2026-02-09 00:50:20', '2026-02-09 00:50:20'),
(7, NULL, NULL, 'hinn', 'kk', '2026-02-04', '20:36:00', '4564656565', 'outstation', NULL, NULL, 'pending', '2026-02-11 07:36:00', '2026-02-11 07:36:00'),
(8, NULL, NULL, 'Sultanpur', 'Rampur', '2026-02-11', '23:54:00', '5646546546', 'outstation', NULL, NULL, 'pending', '2026-02-12 12:52:19', '2026-02-12 12:52:19'),
(9, 'Saurabh Kumar', 'saurabhkumarsfd@gmail.com', 'Sultanpur', 'Sultanpur', '2026-02-25', '17:57:00', '7705839870', 'outstation', 'one_way', NULL, 'pending', '2026-02-14 06:54:41', '2026-02-14 06:54:41'),
(10, 'Saurabh Kumar', 'saurabhkumarsfd@gmail.com', 'Sultanpur', 'Sultanpur', '2026-02-25', '17:57:00', '7705839870', 'outstation', 'one_way', NULL, 'pending', '2026-02-14 06:54:44', '2026-02-14 06:54:44'),
(11, 'Saurabh Kumar', 'saurabhkumarsfd@gmail.com', 'Sultanpur', 'Sultanpur -> Pratapgarh -> Jaunpur', '2026-02-25', '08:58:00', '7705839870', 'outstation', 'round_trip', NULL, 'pending', '2026-02-14 06:58:03', '2026-02-14 06:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(191) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-admin@pr|127.0.0.1', 'i:1;', 1774949802),
('laravel-cache-admin@pr|127.0.0.1:timer', 'i:1774949802;', 1774949802);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(191) NOT NULL,
  `owner` varchar(191) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `slug`, `status`, `created_at`, `updated_at`, `description`) VALUES
(1, 'Lucknow', 'taxi-services-in-lucknow', 1, '2026-03-13 04:49:00', '2026-03-13 04:49:00', '<h3>Lucknow City Description for Prasthan Travels</h3>\r\n\r\n<p>Lucknow is the capital city of Uttar Pradesh and one of the most historic and culturally rich cities in India. The city is famous for its Nawabi culture, beautiful architecture, delicious cuisine, and popular tourist attractions.</p>\r\n\r\n<p>Lucknow is an important travel hub in North India because many travelers start their journeys from here to major religious and tourist destinations such as Ayodhya, Varanasi, Prayagraj, Gorakhpur, Gaya and Nepal.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to many cities across North India. We offer a wide range of vehicles including sedans, SUVs, tempo travellers, luxury cars, and mini buses to meet the needs of families, groups, and business travelers.</p>\r\n\r\n<p>Our goal at <strong>Prasthan Travels</strong> is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(2, 'Varanasi', 'taxi-services-in-varanasi', 1, '2026-03-13 05:12:09', '2026-03-13 05:12:09', '<h3>Varanasi City Description for Prasthan Travels</h3>\r\n\r\n<p>Varanasi is one of the oldest living cities in the world and a major spiritual center of India. Located on the banks of the sacred Ganges River, Varanasi is considered one of the holiest cities for Hindus. Every year millions of pilgrims and tourists visit the city to experience its spiritual atmosphere, historic temples, and famous river ghats.</p>\r\n\r\n<p>The city is well known for important religious sites such as Kashi Vishwanath Temple, which is one of the most sacred temples dedicated to Lord Shiva. Visitors also come to witness the beautiful Ganga Aarti performed every evening on the ghats, which creates a unique and unforgettable spiritual experience.</p>\r\n\r\n<p>Varanasi is also famous for its traditional culture, silk sarees, classical music, and rich heritage. Because of its religious importance, the city attracts travelers from all parts of India and around the world.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides comfortable and reliable taxi services from Lucknow to Varanasi. Travelers can easily book sedans, SUVs, tempo travellers, and luxury vehicles for family trips, pilgrimages, and group tours. Our goal is to provide a safe, comfortable, and memorable journey for every traveler visiting Varanasi.</p>'),
(3, 'Ayodhya', 'taxi-services-in-ayodhya', 1, '2026-03-13 05:49:12', '2026-03-13 05:49:12', '<h1>Ayodhya City Description for Prasthan Travels</h1>\r\n\r\n<p>Ayodhya is one of the most sacred cities in India and is believed to be the birthplace of Lord Rama. The city holds great religious importance and attracts millions of pilgrims every year.</p>\r\n\r\n<p>Ayodhya is famous for important religious sites such as the Ram Mandir and the peaceful banks of the Sarayu River.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Ayodhya for pilgrims and tourists.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(4, 'Prayagraj', 'taxi-services-in-prayagraj', 1, '2026-03-13 05:54:07', '2026-03-13 05:54:07', '<h1>Prayagraj City Description for Prasthan Travels</h1>\r\n\r\n<p>Prayagraj is a historic city known for its religious and cultural significance. The city is famous for the sacred confluence known as the Triveni Sangam where the Ganges River and Yamuna River meet.</p>\r\n\r\n<p>Prayagraj is also known for hosting the world-famous Kumbh Mela, which attracts millions of visitors from around the world.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Prayagraj.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(5, 'Gorakhpur', 'taxi-services-in-gorakhpur', 1, '2026-03-13 05:56:29', '2026-03-13 05:56:29', '<h1>Gorakhpur City Description for Prasthan Travels</h1>\r\n\r\n<p>Gorakhpur is an important city in eastern Uttar Pradesh known for its religious and cultural heritage. The city is famous for the historic Gorakhnath Temple which attracts thousands of devotees every year.</p>\r\n\r\n<p>Gorakhpur also serves as an important gateway for travelers visiting nearby regions and international destinations like Nepal.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Gorakhpur.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(6, 'Gaya', 'taxi-services-in-gaya', 1, '2026-03-13 05:58:54', '2026-03-13 05:58:54', '<h1>Gaya City Description for Prasthan Travels</h1>\r\n\r\n<p>Gaya is one of the most important religious destinations in India. The city is well known for its spiritual importance for both Hindus and Buddhists.</p>\r\n\r\n<p>The nearby town of Bodh Gaya is famous as the place where Lord Buddha attained enlightenment under the sacred Bodhi Tree.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Gaya.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(7, 'Manali', 'taxi-services-in-manali', 1, '2026-03-13 06:02:43', '2026-03-13 06:02:43', '<h1>Manali City Description for Prasthan Travels</h1>\r\n\r\n<p>Manali is one of the most popular tourist destinations in North India. The city is surrounded by snow-covered mountains, beautiful valleys, and adventure activities.</p>\r\n\r\n<p>Tourists visit famous places such as Rohtang Pass and Solang Valley for sightseeing and adventure sports.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Manali.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(8, 'Nainital', 'taxi-services-in-nainital', 1, '2026-03-13 06:06:57', '2026-03-13 06:06:57', '<h1>Nainital City Description for Prasthan Travels</h1>\r\n\r\n<p>Nainital is a famous hill station known for its natural beauty, pleasant weather, and scenic landscapes. The city is built around the beautiful Naini Lake which is a major tourist attraction.</p>\r\n\r\n<p>Tourists visit Nainital to enjoy boating, sightseeing, and relaxing holidays in the mountains.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Nainital.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(9, 'Nepal', 'taxi-services-in-nepal', 1, '2026-03-13 06:10:03', '2026-03-13 06:10:03', '<h1>Nepal Description for Prasthan Travels</h1>\r\n\r\n<p>Nepal is a beautiful country known for its Himalayan mountains, natural beauty, and rich cultural heritage. It is home to the world&rsquo;s highest mountain, Mount Everest.</p>\r\n\r\n<p>Nepal attracts tourists from around the world for adventure tourism, pilgrimage, and sightseeing.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Nepal for cross-border travel.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(10, 'Delhi', 'taxi-services-in-delhi', 1, '2026-03-13 06:14:13', '2026-03-13 06:14:13', '<h1>Delhi City Description for Prasthan Travels</h1>\r\n\r\n<p>Delhi is the capital city of India and one of the most important political, cultural, and economic centers of the country. The city is known for its historical monuments, modern infrastructure, and vibrant lifestyle.</p>\r\n\r\n<p>Delhi is home to many famous tourist attractions such as India Gate, Red Fort, and Qutub Minar which attract millions of visitors every year.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Delhi. We offer a wide range of vehicles including sedans, SUVs, tempo travellers, luxury cars, and mini buses for family trips, business travel, and group tours.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>'),
(11, 'Patna', 'taxi-services-in-patna', 1, '2026-03-13 06:16:57', '2026-03-13 06:16:57', '<h1>Patna City Description for Prasthan Travels</h1>\r\n\r\n<p>Patna is the capital city of Bihar and one of the oldest continuously inhabited cities in the world. The city has a rich historical and cultural heritage and is an important center for education, business, and tourism in eastern India.</p>\r\n\r\n<p>Patna is located on the banks of the sacred Ganges River and is known for its historical landmarks and religious sites such as Takht Sri Patna Sahib.</p>\r\n\r\n<p><strong>Prasthan Travels</strong> provides reliable, safe, and comfortable taxi and tour services from Lucknow to Patna for travelers, pilgrims, and business visitors.</p>\r\n\r\n<p>Our goal at Prasthan Travels is to provide customers with a safe, comfortable, and affordable travel experience.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `city_images`
--

CREATE TABLE `city_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(191) NOT NULL,
  `place_name` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `city_images`
--

INSERT INTO `city_images` (`id`, `city_id`, `image_path`, `place_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'city_images/BxhiYylKHlkd9deyslX2DftbwfD5LjaYp9tdG8KB.jpg', '.', '2026-03-13 04:49:00', '2026-03-13 05:14:24'),
(2, 1, 'city_images/iEkRfKB8ngHpA1UB1dTUpyVsr1oIn7aWdxDNh2hj.webp', 'Ambedkar Park', '2026-03-13 04:54:58', '2026-03-13 04:54:58'),
(3, 2, 'city_images/ulBiahPwD8hp5lHicuBrZz2DEtRK3HhD1AWM7cyZ.jpg', NULL, '2026-03-13 05:12:09', '2026-03-13 05:12:09'),
(4, 2, 'city_images/KYz4qUlrSzukNFFWtfmLSLuhYswyDwxGyfiQ2hzk.webp', NULL, '2026-03-13 05:12:09', '2026-03-13 05:12:09'),
(5, 2, 'city_images/cYyOASy2vfONPYhigSic4pr9v9NE6FQXU6oyb9WF.jpg', NULL, '2026-03-13 05:12:09', '2026-03-13 05:12:09'),
(6, 2, 'city_images/tHddRf3aEdHmKSDWj4ShBpipa9PvcGNZ6JIXHuMi.jpg', NULL, '2026-03-13 05:12:09', '2026-03-13 05:12:09'),
(7, 1, 'city_images/sYG4mC2ZmY8vJBqQPP6GvQaKpdRrrazfuq9R4Ral.jpg', NULL, '2026-03-13 05:13:11', '2026-03-13 05:13:11'),
(8, 3, 'city_images/3wkGrhXpOIo5EzGxz9FETJOp7fIdvKs4T4sgoqgC.jpg', NULL, '2026-03-13 05:49:13', '2026-03-13 05:49:13'),
(9, 3, 'city_images/Wg4HkDgPTnypCp8YIpPR0bHEdbSkNfFXIKwiIiDR.png', NULL, '2026-03-13 05:49:13', '2026-03-13 05:49:13'),
(10, 3, 'city_images/SzClj8NgsBdE7ZkHqsoOsC2nh4ih6fGk9BRm34iI.jpg', NULL, '2026-03-13 05:49:13', '2026-03-13 05:49:13'),
(11, 4, 'city_images/9xPfJZzpvrPOXexFAiJx4P6VOGmgWw5nG5ARZD5k.jpg', NULL, '2026-03-13 05:54:07', '2026-03-13 05:54:07'),
(12, 4, 'city_images/SRNHHkqTbFFQRmRDC9tRbaIcH96iU55nbVZVjXdr.jpg', NULL, '2026-03-13 05:54:07', '2026-03-13 05:54:07'),
(13, 4, 'city_images/ClFfkPvfRTZsMYFzDadRAdsYMqM9XyW1Kukg6lxl.jpg', NULL, '2026-03-13 05:54:07', '2026-03-13 05:54:07'),
(14, 5, 'city_images/oKGwaWbwn0pwRmEFrU0vOwSx5fi92rpTf8S0v3zw.jpg', NULL, '2026-03-13 05:56:29', '2026-03-13 05:56:29'),
(15, 5, 'city_images/S6t46wRgPcW4A7W6hqdU1NRx3bZYs3VAWSj3n4E4.jpg', NULL, '2026-03-13 05:56:29', '2026-03-13 05:56:29'),
(16, 5, 'city_images/lJ6R4LJAeyOfLdKhExDeCnPsSxaH3TExD9UmU75l.jpg', NULL, '2026-03-13 05:56:29', '2026-03-13 05:56:29'),
(17, 6, 'city_images/oQpslmy96udhFJnmQ7RwdcBRzXf1vJFeJqKSN5Ib.jpg', NULL, '2026-03-13 05:58:54', '2026-03-13 05:58:54'),
(18, 6, 'city_images/EAOnWSMkAqhp9H22QrwAW11nh0YqinW00sCVOhzw.jpg', NULL, '2026-03-13 05:58:54', '2026-03-13 05:58:54'),
(19, 6, 'city_images/UGspAvDJUTMO0O84KU7G4RE1dWYfJPmoaORE02ew.jpg', NULL, '2026-03-13 05:58:54', '2026-03-13 05:58:54'),
(20, 7, 'city_images/bz2rin4BmTpymhxg0P173gEc9U5cWUBW318pl1WJ.jpg', NULL, '2026-03-13 06:02:43', '2026-03-13 06:02:43'),
(21, 7, 'city_images/3Sm9hJTWSQ5sPTFACflQFR99schS0saxf43UjGPC.jpg', NULL, '2026-03-13 06:02:43', '2026-03-13 06:02:43'),
(22, 7, 'city_images/UR3O2dOdRrPeoO5OhJT80Rut4vXrWuhZs6MNSgNV.jpg', NULL, '2026-03-13 06:02:43', '2026-03-13 06:02:43'),
(23, 8, 'city_images/yaGOFQ555hTqDgF7XSoLxOMF2htUYwOj5n8r7qMM.jpg', NULL, '2026-03-13 06:06:57', '2026-03-13 06:06:57'),
(24, 8, 'city_images/aAcPSEsHqUPYoatxTnADjqlma4Mssu9UENNvkjxQ.jpg', NULL, '2026-03-13 06:06:57', '2026-03-13 06:06:57'),
(25, 8, 'city_images/FRjVPvcnHwQ0lMk5wKO8OWMTAHGiN3OkpuvVsdlo.jpg', NULL, '2026-03-13 06:06:57', '2026-03-13 06:06:57'),
(26, 9, 'city_images/gHY2nrg54khNgzC4ZJEOY3MxNmD3SIN0QPmscG7h.jpg', NULL, '2026-03-13 06:10:04', '2026-03-13 06:10:04'),
(27, 9, 'city_images/VJd3QkkMLNgkVenNUVHWIy2dNTd5JZ9Inf1zEAe4.jpg', NULL, '2026-03-13 06:10:04', '2026-03-13 06:10:04'),
(28, 9, 'city_images/5jMOaKz5yDr4wvnr1UEasgHS7zW3jrOgOueOOksW.jpg', NULL, '2026-03-13 06:10:04', '2026-03-13 06:10:04'),
(29, 10, 'city_images/v1P1CGd8Rlpw6ok6rjNUM7pmhNn2KuQT1Y6M5P3d.jpg', NULL, '2026-03-13 06:14:13', '2026-03-13 06:14:13'),
(30, 10, 'city_images/fLkh5rQnAIdXXGpekiiXKE71gX9MOXbAoByKXNNu.webp', NULL, '2026-03-13 06:14:13', '2026-03-13 06:14:13'),
(31, 10, 'city_images/wzwoBa9d6Xav8JtGo0j5C9WPkCFV1KUY4vutKlTq.jpg', NULL, '2026-03-13 06:14:13', '2026-03-13 06:14:13'),
(32, 10, 'city_images/j3nZNwHKAoaLD5nDffSJUU26JmfcNAVFQNCm5Gmt.webp', NULL, '2026-03-13 06:14:13', '2026-03-13 06:14:13'),
(33, 10, 'city_images/bmxGCNxqqlAoKdV8CQSDnLYT2MgrjxQ6h7UpR3tn.jpg', NULL, '2026-03-13 06:14:13', '2026-03-13 06:14:13'),
(34, 11, 'city_images/Kurk3c9n6Ij46OjGRTtTifBvzHz7VaNeRbF7qUwk.jpg', NULL, '2026-03-13 06:16:57', '2026-03-13 06:16:57'),
(35, 11, 'city_images/TIx7ZjzhfrN9ahrcfZMCKUSf4VfHb8bxz9LpknE9.jpg', NULL, '2026-03-13 06:16:57', '2026-03-13 06:16:57'),
(36, 11, 'city_images/nLxMKph4aBz8FTn0XQVcNYUcpGBTWg71cnORXKew.jpg', NULL, '2026-03-13 06:16:57', '2026-03-13 06:16:57');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Saurabh Kumar', 'saurabhkumarssp@gmail.com', '7705839870', NULL, 'hii', '2026-02-13 07:07:35', '2026-02-13 07:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `alternate_phone` varchar(191) DEFAULT NULL,
  `license` varchar(191) DEFAULT NULL,
  `vehicle_type` varchar(191) DEFAULT NULL,
  `city` varchar(191) NOT NULL,
  `state` varchar(191) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `rc_image` varchar(191) DEFAULT NULL,
  `dl_image` varchar(191) DEFAULT NULL,
  `ic_image` varchar(191) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `email`, `phone`, `alternate_phone`, `license`, `vehicle_type`, `city`, `state`, `address`, `status`, `created_at`, `updated_at`, `rc_image`, `dl_image`, `ic_image`) VALUES
(1, 'Saurabh Kumar', 'saurabhkumarsfd@gmail.com', '7705839870', '7705839870', NULL, NULL, 'Sultanpur', 'Up', 'Lambhhua', 'approved', '2026-02-17 05:16:53', '2026-02-17 07:00:00', 'uploads/drivers/1771325213_rc.png', 'uploads/drivers/1771325213_dl.png', 'uploads/drivers/1771325213_ic.png');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fleets`
--

CREATE TABLE `fleets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `type` varchar(191) NOT NULL,
  `rate_per_km` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleets`
--

INSERT INTO `fleets` (`id`, `name`, `type`, `rate_per_km`, `image`, `features`, `created_at`, `updated_at`) VALUES
(1, 'Honda Amaze', 'Sedan', '11', 'fleets/az85HZDu7EHQ0GmRA300T6q06-1773394252.png', '[]', '2026-02-05 05:06:32', '2026-03-13 04:01:27'),
(2, 'Maruti Ciaz', 'Sedan', '12', 'fleets/eAOKwlbuxkD0dHZiB47Hzf8R0-1773394366.png', '[]', '2026-02-05 05:06:32', '2026-03-13 04:02:46'),
(3, 'Swift Dzire', 'Sedan', '10', 'fleets/QnRyE7jPMalaCFdAXylocepnu-1773394417.png', '[]', '2026-02-05 05:06:32', '2026-03-13 04:03:37'),
(5, 'Toyota Innova Crysta', 'MPV', '16', 'fleets/ldZIoK71toTAuHlLEo6dj3YAs-1773734435.png', '[]', '2026-02-07 06:32:11', '2026-03-17 02:30:35'),
(7, 'Tata Winger (9+1)', 'VAN', '24', 'fleets/HGxU2lkRt0jh6tXKUXQmplIAI-1773394525.png', '[]', '2026-03-13 04:05:25', '2026-03-13 04:05:25'),
(8, 'Tata Winger (12+1)', 'VAN', '25', 'fleets/XyrpjFZ7bJK8eIelyuYMhWQ8i-1773394584.png', '[]', '2026-03-13 04:06:24', '2026-03-13 04:06:24'),
(9, 'Tata Winger (15+1)', 'VAN', '25', 'fleets/wBf3rvR4eHK65tSKcWlyMXBW7-1773394645.png', '[]', '2026-03-13 04:07:25', '2026-03-13 04:07:25'),
(10, 'Tempo Traveller (17+1)', 'MINI BUS', '26', 'fleets/chaWJEhgQB3X4XvD7P4XxHtfT-1773394705.png', '[]', '2026-03-13 04:08:25', '2026-03-13 04:08:25'),
(11, 'Tempo Traveller (26+1)', 'MINI BUS', '30', 'fleets/h30M7VLK76jBnWVFnOt1ALBtT-1773395420.png', '[]', '2026-03-13 04:09:30', '2026-03-13 04:20:20'),
(12, 'Kia Carens', 'MPV', '14', 'fleets/jgN7zf9sNgIe5wl9e9CU5JwJW-1773394963.png', '[]', '2026-03-13 04:12:43', '2026-03-13 04:12:43'),
(13, 'Ertiga', 'MPV', '13', 'fleets/8PiA7gfGj2jp8TCWjRaT2kVHU-1773395000.png', '[]', '2026-03-13 04:13:20', '2026-03-13 04:13:20'),
(14, 'Luxury car (BMW, Audi, Mercedes)', 'Luxury car', '20000', 'fleets/tWbWYzUEhQWSWdE7vMgS4Apit-1773395366.png', '[]', '2026-03-13 04:19:26', '2026-03-13 04:19:26'),
(15, 'Force Urbania', 'Premium', '80', 'fleets/IJQ4kAX9LeYbxX8yRJ4zuhrp8-1773395684.png', '[]', '2026-03-13 04:22:51', '2026-03-13 04:24:44'),
(16, 'Tata Marcopolo Mini Bus', 'MINI BUS', '35', 'fleets/s9oxktmcpMzV986XUTWx9UZOn-1773395623.png', '[]', '2026-03-13 04:23:43', '2026-03-13 04:23:43'),
(17, 'Toyota Fortuner', 'SUV', '40', 'fleets/a3gvLDpayBTv3fTcQTDkWxnLi-1773395668.png', '[]', '2026-03-13 04:24:28', '2026-03-13 04:24:28');

-- --------------------------------------------------------

--
-- Table structure for table `fleet_popular_route`
--

CREATE TABLE `fleet_popular_route` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `popular_route_id` bigint(20) UNSIGNED NOT NULL,
  `fleet_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fleet_popular_route`
--

INSERT INTO `fleet_popular_route` (`id`, `popular_route_id`, `fleet_id`, `price`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 6050.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(8, 1, 2, 6600.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(9, 1, 3, 5500.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(10, 1, 5, 8800.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(11, 1, 7, 13200.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(12, 1, 8, 13750.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(13, 1, 9, 13750.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(14, 1, 10, 14300.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(15, 1, 11, 16500.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(16, 1, 12, 7700.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(17, 1, 13, 7150.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(18, 1, 15, 44000.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(19, 1, 16, 19250.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(20, 1, 17, 22000.00, '2026-03-13 06:51:39', '2026-03-13 06:51:39'),
(21, 2, 1, 3520.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(22, 2, 2, 3840.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(23, 2, 3, 3200.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(24, 2, 5, 5120.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(25, 2, 7, 7680.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(26, 2, 8, 8000.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(27, 2, 9, 8000.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(28, 2, 10, 8320.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(29, 2, 11, 9600.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(30, 2, 12, 4480.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(31, 2, 13, 4160.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(32, 2, 15, 25600.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(33, 2, 16, 11200.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(34, 2, 17, 12800.00, '2026-03-13 07:15:49', '2026-03-13 07:15:49'),
(35, 3, 1, 1320.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(36, 3, 2, 1440.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(37, 3, 3, 1200.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(38, 3, 5, 1920.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(39, 3, 7, 2880.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(40, 3, 8, 3000.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(41, 3, 9, 3000.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(42, 3, 10, 3120.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(43, 3, 11, 3600.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(44, 3, 12, 1680.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(45, 3, 13, 1560.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(46, 3, 15, 9600.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(47, 3, 16, 4200.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(48, 3, 17, 4800.00, '2026-03-13 07:25:01', '2026-03-13 07:25:01'),
(49, 4, 1, 2200.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(50, 4, 2, 2400.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(51, 4, 3, 2000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(52, 4, 5, 3200.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(53, 4, 7, 4800.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(54, 4, 8, 5000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(55, 4, 9, 5000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(56, 4, 10, 5200.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(57, 4, 11, 6000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(58, 4, 12, 2800.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(59, 4, 13, 2600.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(60, 4, 15, 16000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(61, 4, 16, 7000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(62, 4, 17, 8000.00, '2026-03-13 07:29:18', '2026-03-13 07:29:18'),
(63, 5, 1, 2970.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(64, 5, 2, 3240.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(65, 5, 3, 2700.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(66, 5, 5, 4320.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(67, 5, 7, 6480.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(68, 5, 8, 6750.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(69, 5, 9, 6750.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(70, 5, 10, 7020.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(71, 5, 11, 8100.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(72, 5, 12, 3780.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(73, 5, 13, 3510.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(74, 5, 15, 21600.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(75, 5, 16, 9450.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(76, 5, 17, 10800.00, '2026-03-13 07:33:59', '2026-03-13 07:33:59'),
(77, 6, 1, 5830.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(78, 6, 2, 6360.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(79, 6, 3, 5300.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(80, 6, 5, 8480.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(81, 6, 7, 12720.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(82, 6, 8, 13250.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(83, 6, 9, 13250.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(84, 6, 10, 13780.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(85, 6, 11, 15900.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(86, 6, 12, 7420.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(87, 6, 13, 6890.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(88, 6, 15, 42400.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(89, 6, 16, 18550.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(90, 6, 17, 21200.00, '2026-03-13 07:39:35', '2026-03-13 07:39:35'),
(91, 7, 1, 5170.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(92, 7, 2, 5640.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(93, 7, 3, 4700.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(94, 7, 5, 7520.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(95, 7, 7, 11280.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(96, 7, 8, 11750.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(97, 7, 9, 11750.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(98, 7, 10, 12220.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(99, 7, 11, 14100.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(100, 7, 12, 6580.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(101, 7, 13, 6110.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(102, 7, 15, 37600.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(103, 7, 16, 16450.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(104, 7, 17, 18800.00, '2026-03-13 07:44:22', '2026-03-13 07:44:22'),
(105, 8, 1, 4400.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(106, 8, 2, 4800.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(107, 8, 3, 4000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(108, 8, 5, 6400.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(109, 8, 7, 9600.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(110, 8, 8, 10000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(111, 8, 9, 10000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(112, 8, 10, 10400.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(113, 8, 11, 12000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(114, 8, 12, 5600.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(115, 8, 13, 5200.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(116, 8, 15, 32000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(117, 8, 16, 14000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(118, 8, 17, 16000.00, '2026-03-13 07:49:02', '2026-03-13 07:49:02'),
(119, 9, 1, 9900.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(120, 9, 2, 10800.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(121, 9, 3, 9000.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(122, 9, 5, 14400.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(123, 9, 7, 21600.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(124, 9, 8, 22500.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(125, 9, 9, 22500.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(126, 9, 10, 23400.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(127, 9, 11, 27000.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(128, 9, 12, 12600.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(129, 9, 13, 11700.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(130, 9, 15, 72000.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(131, 9, 16, 31500.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(132, 9, 17, 36000.00, '2026-03-13 07:54:03', '2026-03-13 07:54:03'),
(147, 11, 1, 2200.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(148, 11, 2, 2400.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(149, 11, 3, 2000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(150, 11, 5, 3200.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(151, 11, 7, 4800.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(152, 11, 8, 5000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(153, 11, 9, 5000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(154, 11, 10, 5200.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(155, 11, 11, 6000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(156, 11, 12, 2800.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(157, 11, 13, 2600.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(158, 11, 15, 16000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(159, 11, 16, 7000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34'),
(160, 11, 17, 8000.00, '2026-03-13 07:58:34', '2026-03-13 07:58:34');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) DEFAULT NULL,
  `image_path` varchar(191) NOT NULL,
  `category` varchar(191) NOT NULL DEFAULT 'General',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `image_path`, `category`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Luxury Car', 'gallery/bvrx1cdE2zj6SOlTzK4oOgor3-1773473799.jpg', 'Fleets', 1, '2026-03-14 02:06:41', '2026-03-14 02:06:41'),
(2, 'van', 'gallery/GDot2ATXz84AwrmgM5QWckMqd-1773473899.jpg', 'General', 1, '2026-03-14 02:08:19', '2026-03-14 02:08:19'),
(3, 'Car', 'gallery/yiHYA4JUvQ5GLBtTtLbx95TgD-1773474120.jpg', 'Fleets', 1, '2026-03-14 02:12:00', '2026-03-14 02:12:00'),
(4, 'Ertiga', 'gallery/Swf4K9VcZkj8VpvTlXfXXOlMG-1773474149.jpg', 'Fleets', 1, '2026-03-14 02:12:29', '2026-03-14 02:12:29'),
(5, 'BUS', 'gallery/ULMp0iuuxDGTVRRYV3pms1AGs-1773730206.jpg', 'Fleets', 1, '2026-03-17 01:20:08', '2026-03-17 01:20:08'),
(6, 'Ertiga', 'gallery/b2CaVcCAmMsNUmJqph9okzSfu-1773730244.jpg', 'Fleets', 1, '2026-03-17 01:20:44', '2026-03-17 01:20:44'),
(7, 'Car', 'gallery/GmpD8lDoK6GcTO405OZYA4MIs-1773730288.jpg', 'Fleets', 1, '2026-03-17 01:21:28', '2026-03-17 01:21:28'),
(8, 'Bus', 'gallery/V4Lyy0tkvLqxUkaknlAxzWfqM-1773730344.jpg', 'Fleets', 1, '2026-03-17 01:22:24', '2026-03-17 01:22:24'),
(9, 'Car', 'gallery/Fciy6l0WLfDLOlI5ZPCSNsyKa-1773730379.jpg', 'Fleets', 1, '2026-03-17 01:22:59', '2026-03-17 01:22:59'),
(10, 'Van', 'gallery/8MWgRwAesgT0kqYcBMjwDp4ou-1773730422.jpg', 'Fleets', 1, '2026-03-17 01:23:42', '2026-03-17 01:23:42'),
(11, 'Luxury Car', 'gallery/TYjRWUN1so69SWz6CidpvIoID-1773730501.jpg', 'Fleets', 1, '2026-03-17 01:25:01', '2026-03-17 01:25:01'),
(12, 'Bus', 'gallery/bqosEWaJlNJMPcxdGVfZmYJtn-1773730539.jpg', 'Fleets', 1, '2026-03-17 01:25:39', '2026-03-17 01:25:39'),
(13, 'Luxury Car', 'gallery/8vG1PYjtvBbtzhDcwpHzUof3x-1773730591.jpg', 'Fleets', 1, '2026-03-17 01:26:31', '2026-03-17 01:26:31'),
(14, 'Luxury Car', 'gallery/6a4pCGc2LfOZzLKndu6zVTynF-1773730636.jpg', 'Fleets', 1, '2026-03-17 01:27:16', '2026-03-17 01:27:16'),
(15, 'Luxury Car', 'gallery/BUm30H0Od00Ygy9kH5qyL0MYa-1773730664.jpg', 'Fleets', 1, '2026-03-17 01:27:44', '2026-03-17 01:27:44'),
(16, 'Luxury Car', 'gallery/GKtZIKPl0l16nTPr8Soa6FvDs-1773730719.jpg', 'Fleets', 1, '2026-03-17 01:28:39', '2026-03-17 01:28:39'),
(17, 'Luxury Car', 'gallery/PPNoLQgUYRsnf1ddVBNCqQpPq-1773730768.jpg', 'Fleets', 1, '2026-03-17 01:29:28', '2026-03-17 01:29:28'),
(18, 'Car', 'gallery/yWextrGmJmgemzMzGahbkHHCC-1773730810.jpg', 'Events', 1, '2026-03-17 01:30:10', '2026-03-17 01:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(191) NOT NULL,
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
  `id` varchar(191) NOT NULL,
  `name` varchar(191) NOT NULL,
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
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_05_062139_create_bookings_table', 1),
(5, '2026_02_05_091831_create_packages_table', 2),
(6, '2026_02_05_092319_create_fleets_table', 2),
(7, '2026_02_05_092352_create_testimonials_table', 2),
(9, '2026_02_05_092359_create_popular_cities_table', 2),
(10, '2026_02_05_092403_add_is_admin_to_users_table', 2),
(11, '2026_02_06_062503_create_cities_table', 3),
(12, '2026_02_06_062715_create_services_table', 3),
(13, '2026_02_06_062719_create_seo_pages_table', 3),
(15, '2026_02_05_092355_create_popular_routes_table', 4),
(16, '2026_02_07_091552_rename_avatar_to_image_in_testimonials_table', 5),
(17, '2026_02_09_060210_remove_car_type_from_bookings_table', 6),
(18, '2026_02_10_134903_add_details_to_popular_routes_table', 7),
(19, '2026_02_11_060622_add_dynamic_fields_to_popular_routes', 8),
(20, '2026_02_11_080347_add_details_to_cities_table', 9),
(21, '2026_02_11_080626_add_details_to_cities_table', 9),
(22, '2026_02_11_105748_create_fleet_popular_route_table', 10),
(23, '2026_02_11_114418_add_details_to_packages_table', 11),
(24, '2026_02_13_122216_create_contacts_table', 12),
(25, '2026_02_13_130754_add_subject_to_contacts_table', 13),
(26, '2026_02_14_102335_add_details_to_bookings_table', 14),
(27, '2026_02_14_124728_create_drivers_table', 15),
(28, '2026_02_14_134426_add_extra_fields_to_drivers_table', 16),
(29, '2026_03_14_071430_create_galleries_table', 17),
(30, '2026_03_17_081454_create_subscribers_table', 18);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `price` varchar(191) NOT NULL,
  `discount_price` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `destination` varchar(191) DEFAULT NULL,
  `image` varchar(191) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `title`, `slug`, `price`, `discount_price`, `duration`, `destination`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Manali Escape', 'manali-escape', '13999', '12999', '5 days', 'Manali', 'packages/xKETu7Gjo9dHndtGkJ4LI4WWN-1770889339.jpg', 'Snow-capped peaks and cozy stays.', '2026-02-05 05:06:31', '2026-02-12 04:12:19'),
(4, 'Goa Getaway', 'goa-getaway', '17499', '16499', '4 Nights', 'Goa', 'packages/KuNAbZnaopBroTu9uK0aGFHDR-1770889143.jpg', 'Sun, sand & sea – premium cab included.', '2026-02-07 02:28:21', '2026-02-12 04:09:03'),
(5, 'Rishikesh Retreat', 'rishikesh-retreat', '9999', '8999', '3 days', 'Rishikesh', 'packages/GeM6zzzpSXabn5gdrD8W1zTCy-1770888816.jpg', 'Yoga, Ganga aarti & luxury transfer.', '2026-02-11 06:24:01', '2026-02-12 04:03:51'),
(6, 'Agra Day Tour', 'agra-day-tour', '6299', '5999', '1 day', 'Agra', 'packages/nkaHrV5nZqKYRBoOLmU0agGDF-1770889002.jpg', 'Sunrise Taj, private cab & guide.', '2026-02-12 04:06:42', '2026-02-12 04:06:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popular_cities`
--

CREATE TABLE `popular_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `image` varchar(191) DEFAULT NULL,
  `slug` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popular_routes`
--

CREATE TABLE `popular_routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `from_city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `to_city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `route_title` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `page_type` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `distance` varchar(191) DEFAULT NULL,
  `duration` varchar(191) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `price_etios` decimal(10,2) DEFAULT NULL,
  `price_suv` decimal(10,2) DEFAULT NULL,
  `price_innova` decimal(10,2) DEFAULT NULL,
  `featured_image` varchar(191) DEFAULT NULL,
  `faq_data` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `popular_routes`
--

INSERT INTO `popular_routes` (`id`, `from_city_id`, `to_city_id`, `route_title`, `slug`, `page_type`, `status`, `created_at`, `updated_at`, `distance`, `duration`, `price`, `price_etios`, `price_suv`, `price_innova`, `featured_image`, `faq_data`) VALUES
(1, 1, 10, 'Lucknow to Delhi Taxi', 'lucknow-to-delhi-taxi', 'one_way', 1, '2026-03-13 06:51:39', '2026-03-13 06:51:39', '550 km', '8 hours', 10000.00, NULL, NULL, NULL, 'popular_routes/pQlXn1aoBqpaUxYvHnyoG3CxnKyE74VuNHUJsl9s.jpg', '[{\"question\":\"What is the distance from Lucknow to Delhi?\",\"answer\":\"The distance is approximately 550 km by road.\"},{\"question\":\"How much time does it take to reach Delhi?\",\"answer\":\"It usually takes around 8\\u201310 hours depending on traffic and road conditions.\"},{\"question\":\"Which vehicles are available for this route?\",\"answer\":\"Sedans, SUVs, tempo travellers, and luxury cars are available.\"},{\"question\":\"Is this route suitable for family travel?\",\"answer\":\"Is this route suitable for family travel?\"},{\"question\":\"Are drivers experienced for long-distance travel?\",\"answer\":\"Yes, Prasthan Travels provides professional and experienced drivers.\"},{\"question\":\"Can I book a one-way taxi?\",\"answer\":\"Yes, both one-way and round-trip bookings are available.\"},{\"question\":\"Are toll charges included in the fare?\",\"answer\":\"Toll charges are usually paid by the customer unless included in a package.\"},{\"question\":\"Is night travel available?\",\"answer\":\"Yes, taxis are available 24\\/7.\"},{\"question\":\"Can groups travel together?\",\"answer\":\"Yes, tempo travellers and mini buses are available for groups.\"},{\"question\":\"How can I book the taxi?\",\"answer\":\"You can book through phone, WhatsApp, or online booking.\"}]'),
(2, 1, 2, 'Lucknow to Varanasi Taxi', 'lucknow-to-varanasi-taxi', 'one_way', 1, '2026-03-13 07:15:49', '2026-03-13 07:15:49', '320 km', '5-6 hours', 9000.00, NULL, NULL, NULL, 'popular_routes/2BwP4JV1cBkUfppB7XKGXjAhZ61cEVRNx6kx7yYr.jpg', '[{\"question\":\"What is the distance from Lucknow to Varanasi?\",\"answer\":\"Approximately 320 km.\"},{\"question\":\"How long does the journey take?\",\"answer\":\"Around 5\\u20136 hours.\"},{\"question\":\"Why do people travel to Varanasi?\",\"answer\":\"For pilgrimage, tourism, and religious visits.\"},{\"question\":\"Which vehicles are available?\",\"answer\":\"Sedans, SUVs, and tempo travellers.\"},{\"question\":\"Is this route safe for night travel?\",\"answer\":\"Yes, it is safe and commonly used.\"},{\"question\":\"Can tourists visit temples easily?\",\"answer\":\"Yes, drivers can guide you to major temples.\"},{\"question\":\"Are group vehicles available?\",\"answer\":\"Yes, tempo travellers are available.\"},{\"question\":\"Can we book a round trip?\",\"answer\":\"Yes, round trips are available.\"},{\"question\":\"Are sightseeing services available?\",\"answer\":\"Yes, local sightseeing can be arranged.\"},{\"question\":\"Is advance booking required?\",\"answer\":\"Advance booking is recommended.\"}]'),
(3, 1, 3, 'Lucknow To Ayodhya Taxi', 'lucknow-to-ayodhya-taxi', 'one_way', 1, '2026-03-13 07:25:01', '2026-03-13 07:25:01', '120', '2.5–3 hours', 8000.00, NULL, NULL, NULL, 'popular_routes/K943HVPqEVDsmIIrFKvYehAzPGalanlC62o2nNKB.jpg', '[{\"question\":\"What is the distance from Lucknow to Ayodhya?\",\"answer\":\"About 135 km.\"},{\"question\":\"How much travel time is required?\",\"answer\":\"Around 2.5\\u20133 hours.\"},{\"question\":\"Why is Ayodhya famous?\",\"answer\":\"It is known as the birthplace of Lord Rama.\"},{\"question\":\"Is this route popular for pilgrimage?\",\"answer\":\"Yes, many devotees travel daily.\"},{\"question\":\"Which vehicles are best for this trip?\",\"answer\":\"Sedans and SUVs are commonly used.\"},{\"question\":\"Is same-day return possible?\",\"answer\":\"Yes, it is possible.\"},{\"question\":\"Are group vehicles available?\",\"answer\":\"Yes, tempo travellers are available.\"},{\"question\":\"Is parking available near temples?\",\"answer\":\"Yes, parking facilities are available.\"},{\"question\":\"Can we visit multiple temples?\",\"answer\":\"Yes, drivers can help with temple visits.\"},{\"question\":\"Is weekend travel crowded?\",\"answer\":\"Yes, weekends are usually busy.\"}]'),
(4, 1, 4, 'Lucknow To Prayagraj', 'lucknow-to-prayagraj', 'one_way', 1, '2026-03-13 07:29:18', '2026-03-13 07:29:18', '200 km', '4-5 hours', 9000.00, NULL, NULL, NULL, 'popular_routes/99tLnHiocYefG3iW2VvNovWrXvgEd96G8UBOomgy.jpg', '[{\"question\":\"What is the distance from Lucknow to Prayagraj?\",\"answer\":\"About 200 km.\"},{\"question\":\"How long does the journey take?\",\"answer\":\"Around 4\\u20135 hours.\"},{\"question\":\"Why is Prayagraj famous?\",\"answer\":\"For the Triveni Sangam and Kumbh Mela.\"},{\"question\":\"Which vehicles are available?\",\"answer\":\"Sedans, SUVs, and travellers.\"},{\"question\":\"Is this route popular for pilgrimage?\",\"answer\":\"Yes, many pilgrims travel here.\"},{\"question\":\"Can we visit Sangam easily?\",\"answer\":\"Yes, taxis can drop near Sangam.\"},{\"question\":\"Are group vehicles available?\",\"answer\":\"Yes.\"},{\"question\":\"Is night travel possible?\",\"answer\":\"Yes.\"},{\"question\":\"Can tourists visit temples?\",\"answer\":\"Yes.\"},{\"question\":\"Is same-day return possible?\",\"answer\":\"Yes.\"}]'),
(5, 1, 5, 'Luckonw To Gorakhpur Taxi', 'luckonw-to-gorakhpur-taxi', 'one_way', 1, '2026-03-13 07:33:59', '2026-03-13 07:33:59', '270 km', '6 hours', 9000.00, NULL, NULL, NULL, 'popular_routes/kMUgCuzOIxB7SRt1H3H65PNlTnxld8qEmYohohCn.jpg', '[{\"question\":\"Distance from Lucknow to Gorakhpur?\",\"answer\":\"About 270 km.\"},{\"question\":\"Travel time?\",\"answer\":\"Around 5\\u20136 hours.\"},{\"question\":\"Why visit Gorakhpur?\",\"answer\":\"For religious visits and tourism.\"},{\"question\":\"Which vehicles are available?\",\"answer\":\"Sedans, SUVs, travellers.\"},{\"question\":\"Is night travel available?\",\"answer\":\"Yes.\"},{\"question\":\"Is the route safe?\",\"answer\":\"Yes.\"},{\"question\":\"Can groups travel together?\",\"answer\":\"Yes.\"},{\"question\":\"Is advance booking required?\",\"answer\":\"Recommended.\"},{\"question\":\"Are experienced drivers provided?\",\"answer\":\"Yes.\"},{\"question\":\"Is round trip available?\",\"answer\":\"Yes.\"}]'),
(6, 1, 11, 'Lucknow To Patna Taxi', 'lucknow-to-patna-taxi', 'one_way', 1, '2026-03-13 07:39:35', '2026-03-13 07:39:35', '530 km', '8-9 hours', 10000.00, NULL, NULL, NULL, NULL, '[{\"question\":\"What is the distance from Lucknow to Patna?\",\"answer\":\"The distance from Lucknow to Patna is approximately 530 kilometers by road, depending on the route taken by the driver.\"},{\"question\":\"How long does it take to travel from Lucknow to Patna by taxi?\",\"answer\":\"The journey from Lucknow to Patna usually takes around 8 to 9 hours depending on traffic conditions, road quality, and rest stops during the trip.\"},{\"question\":\"Why do people usually travel from Lucknow to Patna?\",\"answer\":\"People travel from Lucknow to Patna for various purposes such as business meetings, tourism, educational activities, and religious visits.\"},{\"question\":\"Which types of vehicles are available for this route?\",\"answer\":\"Prasthan Travels provides a variety of vehicles for this route including sedans, SUVs, tempo travellers, and mini buses for both individual and group travel.\"},{\"question\":\"Is night travel available from Lucknow to Patna?\",\"answer\":\"Yes, Prasthan Travels offers 24-hour taxi services, so passengers can travel comfortably during the night as well.\"},{\"question\":\"Is highway travel comfortable for this route?\",\"answer\":\"Yes, the route between Lucknow and Patna mainly consists of highways and well-connected roads, making the journey comfortable for passengers.\"},{\"question\":\"Can groups travel together on this route?\",\"answer\":\"Yes, groups can easily travel together by booking tempo travellers, Urbania, or mini buses depending on the group size.\"},{\"question\":\"Is round trip booking available for this route?\",\"answer\":\"Yes, Prasthan Travels provides both one-way and round-trip taxi services between Lucknow and Patna.\"},{\"question\":\"Is advance booking recommended for this trip?\",\"answer\":\"9. Is advance booking recommended for this trip?\\r\\nYes, it is always better to book your taxi in advance to ensure vehicle availability and smooth travel planning.\"},{\"question\":\"Are experienced drivers provided for this journey?\",\"answer\":\"Yes, Prasthan Travels provides professional and experienced drivers who are familiar with long-distance travel routes.\"}]'),
(7, 1, 6, 'Lucknow To Gaya Taxi', 'lucknow-to-gaya-taxi', 'one_way', 1, '2026-03-13 07:44:22', '2026-03-13 07:44:22', '470 km', '7-8 hours', 8000.00, NULL, NULL, NULL, 'popular_routes/skyK01cwTCwiYsQZVWr6fwCBmtEjZYi0zhhROiQf.jpg', '[{\"question\":\"What is the distance from Lucknow to Gaya?\",\"answer\":\"The distance between Lucknow and Gaya is approximately 470 kilometers by road.\"},{\"question\":\"How long does the journey from Lucknow to Gaya take?\",\"answer\":\"The travel time from Lucknow to Gaya usually takes around 7 to 8 hours depending on road and traffic conditions.\"},{\"question\":\"Why do people travel to Gaya?\",\"answer\":\"Many people travel to Gaya for religious rituals, pilgrimage purposes, and to visit important spiritual places.\"},{\"question\":\"Are taxis available daily for this route?\",\"answer\":\"Yes, Prasthan Travels provides taxi services every day for passengers traveling from Lucknow to Gaya.\"},{\"question\":\"Are taxis available daily for this route?\",\"answer\":\"Passengers can choose from sedans, SUVs, tempo travellers, and luxury vehicles according to their travel needs.\"},{\"question\":\"Is night travel possible on this route?\",\"answer\":\"Yes, passengers can travel at night because Prasthan Travels provides 24-hour taxi services.\"},{\"question\":\"Are drivers experienced for long-distance travel?\",\"answer\":\"Yes, all drivers provided by Prasthan Travels are experienced and trained for long-distance routes.\"},{\"question\":\"Is group travel possible from Lucknow to Gaya?\",\"answer\":\"Yes, groups can travel together by booking tempo travellers or mini buses.\"},{\"question\":\"Is round trip booking available?\",\"answer\":\"Yes, customers can book both one-way and round-trip taxi services for this route.\"},{\"question\":\"Is advance booking recommended for this route?\",\"answer\":\"Yes, advance booking is recommended to avoid last-minute vehicle availability issues.\"}]'),
(8, 1, 8, 'Lucknow To Nainital Taxi', 'lucknow-to-nainital-taxi', 'one_way', 1, '2026-03-13 07:49:02', '2026-03-13 07:49:02', '400 km', '7-8 hours', 10000.00, NULL, NULL, NULL, 'popular_routes/QnD9bCMcHh2a5P0YzSiD0ibsdHXQyejG15PHorZy.jpg', '[{\"question\":\"What is the distance from Lucknow to Nainital?\",\"answer\":\"The distance between Lucknow and Nainital is approximately 400 kilometers by road.\"},{\"question\":\"How long does it take to travel from Lucknow to Nainital?\",\"answer\":\"The journey usually takes around 7 to 8 hours depending on traffic conditions and weather.\"},{\"question\":\"Why do tourists visit Nainital?\",\"answer\":\"Tourists visit Nainital to enjoy its natural beauty, pleasant climate, lakes, and mountain views.\"},{\"question\":\"Which vehicles are best for traveling to hill stations like Nainital?\",\"answer\":\"SUVs and tempo travellers are generally recommended because they are comfortable and suitable for mountain roads.\"},{\"question\":\"Is winter travel safe on this route?\",\"answer\":\"Yes, winter travel is safe when experienced drivers and suitable vehicles are used.\"},{\"question\":\"Are sightseeing trips available in Nainital?\",\"answer\":\"Yes, Prasthan Travels can arrange sightseeing trips to popular tourist spots in Nainital.\"},{\"question\":\"Is group travel possible to Nainital?\",\"answer\":\"Yes, families and groups can travel together by booking tempo travellers or mini buses.\"},{\"question\":\"Is advance booking required for this trip?\",\"answer\":\"Advance booking is recommended especially during peak tourist seasons.\"},{\"question\":\"Can travelers stay overnight in Nainital?\",\"answer\":\"Yes, many travelers prefer to stay overnight or for a few days to enjoy the hill station experience.\"},{\"question\":\"Is round trip taxi service available?\",\"answer\":\"Yes, Prasthan Travels provides both one-way and round-trip taxi services.\"}]'),
(9, 1, 7, 'Lucknow To Manali Taxi', 'lucknow-to-manali-taxi', 'one_way', 1, '2026-03-13 07:54:03', '2026-03-13 07:54:03', '900 km', '15-18 hours', 15000.00, NULL, NULL, NULL, 'popular_routes/YFIGgkJBAQ5dvu6wbjxum7lWBk1iFrM1736QHw0L.jpg', '[{\"question\":\"What is the distance from Lucknow to Manali?\",\"answer\":\"The distance between Lucknow and Manali is approximately 900 kilometers by road.\"},{\"question\":\"How long does the journey from Lucknow to Manali take?\",\"answer\":\"The journey usually takes around 15 to 18 hours depending on road conditions and weather.\"},{\"question\":\"Why do tourists travel to Manali?\",\"answer\":\"Tourists visit Manali to enjoy snow-covered mountains, beautiful valleys, adventure sports, and sightseeing.\"},{\"question\":\"Which vehicles are best for long-distance trips like this?\",\"answer\":\"SUVs, tempo travellers, and luxury vehicles are the most comfortable options for long-distance journeys.\"},{\"question\":\"Is overnight travel possible for this route?\",\"answer\":\"Yes, passengers can travel overnight depending on their travel plan.\"},{\"question\":\"Are drivers experienced for hill roads?\",\"answer\":\"Yes, Prasthan Travels provides experienced drivers who are familiar with mountain roads.\"},{\"question\":\"Are group tours available to Manali?\",\"answer\":\"Yes, groups can travel comfortably using tempo travellers or mini buses.\"},{\"question\":\"Is sightseeing available in Manali?\",\"answer\":\"Yes, tourists can visit many popular places in Manali during their trip.\"},{\"question\":\"Is winter travel popular for this destination?\",\"answer\":\"Yes, many tourists visit Manali during winter to enjoy snowfall and snow activities.\"},{\"question\":\"Is advance booking required for this route?\",\"answer\":\"Yes, advance booking is highly recommended because it is a long-distance trip.\"}]'),
(11, 1, 9, 'Lucknow to Nepal Taxi', 'lucknow-to-nepal-taxi', 'one_way', 1, '2026-03-13 07:58:34', '2026-03-13 07:58:34', '200 km', '4-5 hours', 12000.00, NULL, NULL, NULL, 'popular_routes/98EgM0Ai8tqGTnCSRKj0kaLuK4oJGkyYhiTioPGO.jpg', '[{\"question\":\"What is the distance from Lucknow to the Nepal border?\",\"answer\":\"The distance from Lucknow to the Nepal border is approximately 180 to 200 kilometers depending on the border crossing point.\"},{\"question\":\"How long does it take to reach Nepal from Lucknow?\",\"answer\":\"The journey usually takes around 4 to 5 hours by road.\"},{\"question\":\"Do Indian citizens need a visa to travel to Nepal?\",\"answer\":\"No, Indian citizens do not need a visa to travel to Nepal, but they should carry valid identification documents.\"},{\"question\":\"Which vehicles are available for traveling to Nepal?\",\"answer\":\"Prasthan Travels offers sedans, SUVs, tempo travellers, and luxury vehicles for this route.\"},{\"question\":\"Is cross-border travel allowed by taxi?\",\"answer\":\"Yes, cross-border travel is allowed with proper vehicle permissions and necessary documents.\"},{\"question\":\"Are drivers experienced for international travel routes?\",\"answer\":\"Yes, drivers are experienced and familiar with routes leading to the Nepal border.\"},{\"question\":\"Can groups travel together to Nepal?\",\"answer\":\"Yes, group travel is possible with tempo travellers and larger vehicles.\"},{\"question\":\"Can tourists visit temples and cities in Nepal?\",\"answer\":\"Yes, tourists can visit many famous temples, cultural sites, and cities in Nepal.\"},{\"question\":\"Is advance booking recommended for this trip?\",\"answer\":\"Yes, advance booking is recommended to arrange proper vehicle documents for cross-border travel.\"},{\"question\":\"Is round trip taxi service available for Nepal travel?\",\"answer\":\"Yes, Prasthan Travels provides both one-way and round-trip taxi services for travelers going to Nepal.\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `seo_pages`
--

CREATE TABLE `seo_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `city_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(191) NOT NULL,
  `title` varchar(191) NOT NULL,
  `h1_heading` varchar(191) NOT NULL,
  `content` longtext NOT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `canonical_url` varchar(191) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `service_name`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(1, 'two way cab', 'two-way-cab', 1, '2026-02-07 02:00:46', '2026-02-07 02:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(191) NOT NULL,
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
('9GhK6OCcNxs5oleRDsfphcGtPjPlt1gi5bsa5lRj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiWFNlb0swYTBFYjlNMUxSckdKVzRYMWZobHhHaVpZU0FMaUNvbWNrYyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjgwMDEvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YToxOntpOjA7czo3OiJzdWNjZXNzIjt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6Nzoic3VjY2VzcyI7czoyMDoiV2VsY29tZSB0byBEYXNoYm9hcmQiO30=', 1774949747),
('DlqTM8thlXHuOHL70pF6X7bNIU8TTwdC2rfSkuru', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWjZiNVJGNFdCdWRza2loQ05JUkxDd05iQkRRNHJBVWdQaU5WRTZKNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774099347),
('Gcv81MFDuqdeclvshugVDySYRh64lvjBzHXw0LdW', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTEtnc1REWDNuNmxNVXJMTHowU0hIUlIxVE40R1ZERTlXbmhweWF0VSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774949753),
('JPZek1iTdMmlxj66nDkNK1Ir8BAia1TbLMZpz46u', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlJGcEFRZDdsSWlwUkdNczdVWmZCOUZUa21ZYms4ZHcxMEVzeE1rQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774099781),
('kMY5RVzLHLQUgFnxggy7H16RLLOko0LucrrG0274', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicEsyUzVyNnEzRkxpTnhUUG5MYmM5Tnp2aFkzaTd6ZXBMUWFQU0hkRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMS9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774949693),
('TczTlUNSJDrqO8X4eERhYAw9LJqg9TMTieOseDGb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNm1ydzd1a05VblQxcDZpZzA0ZThnVnl0S0pzUVlkMG41TW8xZ0VMNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9zdWJzY3JpYmVycyI7czo1OiJyb3V0ZSI7czoyMzoiYWRtaW4uc3Vic2NyaWJlcnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1773745512),
('TvBghnGYfoiQxVBOtcXi6Tx2Bdw9lT4LiXidK0Ix', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNTBjZXZZazV4bzJ2OFZibGdWSVROSFpzSFZ4QmVRdHk2MzdtbHlENSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMS9hZG1pbi9wYWNrYWdlcy9jcmVhdGUiO3M6NToicm91dGUiO3M6MjE6ImFkbWluLnBhY2thZ2VzLmNyZWF0ZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1774950123);

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(191) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `status`, `created_at`, `updated_at`) VALUES
(1, 'saurabh@gmail.com', 1, '2026-03-17 03:38:42', '2026-03-17 03:38:42');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `role` varchar(191) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `image` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `message`, `rating`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Rahul Sharma', 'Business Traveler', 'Excellent service! The cab was clean and the driver was very professional.', 5, 'testimonials/QfDQZ1y027MYE6Sc1hV6aPGwt-1770966750.jpg', '2026-02-05 05:06:32', '2026-02-13 01:42:30'),
(2, 'Priya Singh', 'Tourist', 'We booked the Golden Triangle tour and it was perfectly managed.', 5, 'testimonials/t37uDY4pxGmzNxdWHwwGqtwgD-1770966765.jpg', '2026-02-05 05:06:32', '2026-02-13 01:42:45'),
(4, 'Raghav Khanna', 'Business', 'Chauffeurs are professional, cars smell great. Premium indeed.', 5, 'testimonials/iSENoJuAD1TfjXfHr8DRfuzkN-1770966730.jpg', '2026-02-07 03:49:02', '2026-02-13 01:42:10'),
(5, 'Sunita Rawa', 'family tour', 'Used for Char Dham yatra – safe driving, great planning.', 3, 'testimonials/jh0QePYUgSlZgKJdoL61lzA4g-1770966659.jpg', '2026-02-13 01:41:01', '2026-02-13 01:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@prasthantravels.com', 1, NULL, '$2y$12$P6VXvTY.v5MtK8JMQ64Tg.QXgU4i7zl1EuJtSGHXMspWTGCWLYgY2', 'g48a0RYMUvxehg1jeCSSWFfFN2FcmS1kvroN8YSCBTsgpKb1k77Nw3aIopKk', '2026-02-05 05:06:31', '2026-02-06 03:41:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_package_id_foreign` (`package_id`);

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
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_slug_unique` (`slug`);

--
-- Indexes for table `city_images`
--
ALTER TABLE `city_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_images_city_id_foreign` (`city_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `fleets`
--
ALTER TABLE `fleets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fleet_popular_route`
--
ALTER TABLE `fleet_popular_route`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fleet_popular_route_popular_route_id_foreign` (`popular_route_id`),
  ADD KEY `fleet_popular_route_fleet_id_foreign` (`fleet_id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `popular_cities`
--
ALTER TABLE `popular_cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `popular_cities_slug_unique` (`slug`);

--
-- Indexes for table `popular_routes`
--
ALTER TABLE `popular_routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `popular_routes_slug_unique` (`slug`),
  ADD KEY `popular_routes_slug_index` (`slug`),
  ADD KEY `popular_routes_from_city_id_index` (`from_city_id`),
  ADD KEY `popular_routes_to_city_id_index` (`to_city_id`);

--
-- Indexes for table `seo_pages`
--
ALTER TABLE `seo_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seo_pages_slug_unique` (`slug`),
  ADD KEY `seo_pages_city_id_foreign` (`city_id`),
  ADD KEY `seo_pages_service_id_foreign` (`service_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `services_slug_unique` (`slug`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `city_images`
--
ALTER TABLE `city_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fleets`
--
ALTER TABLE `fleets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `fleet_popular_route`
--
ALTER TABLE `fleet_popular_route`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `popular_cities`
--
ALTER TABLE `popular_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `popular_routes`
--
ALTER TABLE `popular_routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `seo_pages`
--
ALTER TABLE `seo_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `city_images`
--
ALTER TABLE `city_images`
  ADD CONSTRAINT `city_images_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fleet_popular_route`
--
ALTER TABLE `fleet_popular_route`
  ADD CONSTRAINT `fleet_popular_route_fleet_id_foreign` FOREIGN KEY (`fleet_id`) REFERENCES `fleets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fleet_popular_route_popular_route_id_foreign` FOREIGN KEY (`popular_route_id`) REFERENCES `popular_routes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `popular_routes`
--
ALTER TABLE `popular_routes`
  ADD CONSTRAINT `popular_routes_from_city_id_foreign` FOREIGN KEY (`from_city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `popular_routes_to_city_id_foreign` FOREIGN KEY (`to_city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `seo_pages`
--
ALTER TABLE `seo_pages`
  ADD CONSTRAINT `seo_pages_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `seo_pages_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
