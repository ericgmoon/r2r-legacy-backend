-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 03, 2019 at 04:14 AM
-- Server version: 5.6.43-cll-lve
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hair_link`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(13, '2014_10_12_000000_create_users_table', 1),
(14, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(15, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(16, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(17, '2016_06_01_000004_create_oauth_clients_table', 1),
(18, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(19, '2019_01_10_070920_create_user_devices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('26df59d60ac4edbca75f0844620064a56d4a05ba009827f0537f3dab06a21e4744b891c5900d4818', 4, 1, 'MyApp', '[]', 0, '2019-07-03 17:06:23', '2019-07-03 17:06:23', '2020-07-03 10:06:23'),
('5517901d8d4d853bc7ddda8e215843bdc7e6e0704457629feb186fc5779ec6ef1b838d58fd781a89', 4, 1, 'MyApp', '[]', 0, '2019-07-03 17:48:00', '2019-07-03 17:48:00', '2020-07-03 10:48:00'),
('766795c40d11b01573b195e9410cba92da15b40054e6674c6029e639bc576cb1105f61ca7d13643f', 1, 1, 'MyApp', '[]', 0, '2019-01-17 00:35:58', '2019-01-17 00:35:58', '2020-01-17 06:05:58'),
('8be4688ac4f466cb8564a872e764a4da94bb30d3cc4104009ed2cf88c8d06be489cf8a81ccdd5feb', 1, 1, 'MyApp', '[]', 0, '2019-01-17 01:17:30', '2019-01-17 01:17:30', '2020-01-17 06:47:30'),
('9241767524b6571e85117243da99c26d36e421c11a55febd624bf7201ed7d7cb0d85eb0c1bf169c7', 4, 1, 'MyApp', '[]', 0, '2019-07-03 17:07:53', '2019-07-03 17:07:53', '2020-07-03 10:07:53'),
('dfb0029147cd2f79db439d6d987c5f5b4ed91a296b651c6c8a19383fd38d9818aa4788a5eb02596b', 4, 1, 'MyApp', '[]', 0, '2019-07-03 17:21:24', '2019-07-03 17:21:24', '2020-07-03 10:21:24');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'TellMe Personal Access Client', 'zOLYBAX58eHCKqlYkwiXdvshfxcOnX5FH51Tsjw8', 'http://localhost', 1, 0, 0, '2019-01-17 00:35:43', '2019-01-17 00:35:43'),
(2, NULL, 'TellMe Password Grant Client', 'aVXWqAVPVXRPOjv9i3AgzdUpFHurM57ZM0pbfzcb', 'http://localhost', 0, 1, 0, '2019-01-17 00:35:43', '2019-01-17 00:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-01-17 00:35:43', '2019-01-17 00:35:43');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `salon_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(119) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_code` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abn_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1 for salon,2 for customer, 3 for hair stylist',
  `active` mediumint(9) NOT NULL DEFAULT '1',
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `salon_name`, `full_name`, `email`, `phone_number`, `password`, `post_code`, `city`, `abn_number`, `address`, `profile_image`, `user_type`, `active`, `otp`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Atul Constructions', 'atul.ozit@gmail.com', 'GT485525GT6520', '$2y$10$iTPmDhbhehvmk6Ooq5Y1T.VvxHv8IJZwhBtgyqPMBkbyje5DKtZUq', NULL, NULL, NULL, 'A94, Mubarakpur kotla', NULL, '1', 1, '0101', NULL, '2019-01-17 00:35:53', '2019-01-17 01:16:58'),
(2, 'test salon', NULL, 'arshad11.ozit@gmail.com', '8882019689', '$2y$10$pvkWu9HEIO5Mph7dlMxHpuZCZ3XeZCZIb0dpLVxOpQedPcc.5aOE2', '110096', NULL, NULL, 'new delhi', NULL, '1', 1, '0000', NULL, '2019-07-03 16:43:08', '2019-07-03 16:43:08'),
(3, 'test salon', NULL, 'arshad22.ozit@gmail.com', '8882019689', '$2y$10$jdAWWa8e/kSU.FkDxjrHW.Y37xMeOZIwXRgkcmNkCmoSV7YpJ97UG', '110096', 'delhi', NULL, 'new delhi', NULL, '1', 1, '0000', NULL, '2019-07-03 16:48:05', '2019-07-03 16:48:05'),
(4, 'test salon', NULL, 'arshad.ozit@gmail.com', '8882019689', '$2y$10$YVFhNe6oIDIJaWP/6YJnwe8hz24A3fAShcd/Mj8lr27i/QPuMTo8u', '110096', 'delhi', '1100ABC-XY-990', 'new delhi', NULL, '1', 1, '0101', NULL, '2019-07-03 16:52:02', '2019-07-03 17:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `device_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `device_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_type`, `device_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'ANDROID', 'DERFR1585858955585', '2019-01-17 00:35:58', '2019-01-17 00:35:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
