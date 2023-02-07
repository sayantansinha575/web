-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2022 at 07:16 AM
-- Server version: 5.7.23-23
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phpblkr8_rajedu`
--

-- --------------------------------------------------------

--
-- Table structure for table `raj_groups`
--

CREATE TABLE `raj_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Inactive',
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `raj_groups`
--

INSERT INTO `raj_groups` (`id`, `name`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Active', 1, NULL, 1666596415),
(2, 'Associates', 'Active', 1, 1666596392, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `raj_master_data`
--

CREATE TABLE `raj_master_data` (
  `id` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` enum('Type of Degree','University Programs','Program Search Tags','Intake','Status','Type of Exam','Test Type','Document Type') COLLATE utf8_unicode_ci DEFAULT NULL,
  `intake_prefix` varchar(155) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intake_year` int(11) DEFAULT NULL,
  `search_tags` text COLLATE utf8_unicode_ci,
  `status` enum('Active','Inactive') COLLATE utf8_unicode_ci DEFAULT 'Inactive',
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `raj_master_data`
--

INSERT INTO `raj_master_data` (`id`, `title`, `type`, `intake_prefix`, `intake_year`, `search_tags`, `status`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 'Strategic Intelligence', 'Type of Degree', NULL, NULL, NULL, 'Active', 1666188875, NULL, 1),
(2, 'Professional MBA', 'Type of Degree', NULL, NULL, NULL, 'Active', 1666189806, 1666327796, 1),
(4, 'Accountancy', 'University Programs', NULL, NULL, NULL, 'Active', 1666191429, 1666262859, 1),
(5, 'Accounting', 'University Programs', NULL, NULL, NULL, 'Active', 1666192192, NULL, 1),
(6, 'Accounting & Taxation', 'University Programs', NULL, NULL, NULL, 'Active', 1666192211, NULL, 1),
(7, 'Accounting (MSA)', 'University Programs', NULL, NULL, NULL, 'Active', 1666192376, NULL, 1),
(8, 'Accounting and Finance', 'University Programs', NULL, NULL, NULL, 'Active', 1666192385, NULL, 1),
(9, 'Acting', 'University Programs', NULL, NULL, NULL, 'Active', 1666192396, NULL, 1),
(10, 'Actuarial & Mathematical Sciences', 'University Programs', NULL, NULL, NULL, 'Active', 1666192404, NULL, 1),
(11, 'Actuarial science', 'University Programs', NULL, NULL, NULL, 'Active', 1666192420, NULL, 1),
(12, 'Addiction Counseling', 'University Programs', NULL, NULL, NULL, 'Active', 1666192430, NULL, 1),
(13, 'Administration', 'University Programs', NULL, NULL, NULL, 'Active', 1666192448, NULL, 1),
(14, 'Administration and Policy - Emphasis', 'University Programs', NULL, NULL, NULL, 'Active', 1666192462, NULL, 1),
(15, 'Administration of Justice', 'University Programs', NULL, NULL, NULL, 'Active', 1666192485, NULL, 1),
(16, 'Accountancy', 'University Programs', NULL, NULL, NULL, 'Active', 1666250079, 1666416654, 1),
(17, 'Accountancya', 'University Programs', NULL, NULL, NULL, 'Active', 1666254167, NULL, 1),
(21, NULL, 'Intake', 'SP', 2040, NULL, 'Active', 1666260392, 1666268114, 1),
(22, NULL, 'Intake', 'FA', 2034, NULL, 'Active', 1666261729, 1666268127, 1),
(23, NULL, 'Intake', 'SU', 2033, NULL, 'Active', 1666266213, 1666267538, 1),
(25, NULL, 'Intake', 'SU', 2037, NULL, 'Active', 1666268146, NULL, 1),
(26, 'sayantan', 'Status', NULL, NULL, NULL, 'Inactive', 1666332374, 1666359612, 1),
(27, 'test1', 'Status', NULL, NULL, NULL, 'Active', 1666332520, 1666337192, 1),
(28, 'test2', 'Status', NULL, NULL, NULL, 'Inactive', 1666333213, 1666337207, 1),
(34, '7', 'Program Search Tags', NULL, NULL, 'test', 'Inactive', 1666352168, 1666365276, 1),
(35, '4', 'Program Search Tags', NULL, NULL, 'test', 'Active', 1666352291, NULL, 1),
(36, '9', 'Program Search Tags', NULL, NULL, 'test', 'Inactive', 1666352672, 1666359700, 1),
(39, '6', 'Program Search Tags', NULL, NULL, 'test', 'Active', 1666357802, NULL, 1),
(41, 'test', 'Status', NULL, NULL, NULL, 'Active', 1666358483, NULL, 1),
(44, 'test15', 'Type of Exam', NULL, NULL, NULL, 'Active', 1666440377, 1666444070, 1),
(45, 'test', 'Type of Exam', NULL, NULL, NULL, 'Inactive', 1666441061, 1666442581, 1),
(46, 'test', 'Type of Exam', NULL, NULL, NULL, 'Inactive', 1666441522, NULL, 1),
(48, 'test', 'Type of Exam', NULL, NULL, NULL, 'Active', 1666442443, NULL, 1),
(49, 'test', 'Type of Exam', NULL, NULL, NULL, 'Active', 1666453376, NULL, 1),
(50, 'test', 'Test Type', NULL, NULL, NULL, 'Inactive', 1666454684, NULL, 1),
(51, 'test544', 'Test Type', NULL, NULL, NULL, 'Active', 1666454702, 1666456391, 1),
(56, 'test', 'Type of Exam', NULL, NULL, NULL, 'Active', 1666589310, NULL, 1),
(57, 'test', 'Type of Exam', NULL, NULL, NULL, 'Active', 1666589339, NULL, 1),
(58, 'test2', 'Document Type', NULL, NULL, NULL, 'Active', 1666591633, 1666592512, 1),
(60, 'test2', 'Document Type', NULL, NULL, NULL, 'Active', 1666592706, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `raj_migrations`
--

CREATE TABLE `raj_migrations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raj_migrations`
--

INSERT INTO `raj_migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(1, '2021-07-04-041948', 'CodeIgniter\\Settings\\Database\\Migrations\\CreateSettingsTable', 'default', 'CodeIgniter\\Settings', 1663303623, 1),
(2, '2021-11-14-143905', 'CodeIgniter\\Settings\\Database\\Migrations\\AddContextColumn', 'default', 'CodeIgniter\\Settings', 1663303623, 1);

-- --------------------------------------------------------

--
-- Table structure for table `raj_settings`
--

CREATE TABLE `raj_settings` (
  `id` int(9) NOT NULL,
  `class` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text,
  `type` varchar(31) NOT NULL DEFAULT 'string',
  `context` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raj_settings`
--

INSERT INTO `raj_settings` (`id`, `class`, `key`, `value`, `type`, `context`, `created_at`, `updated_at`) VALUES
(1, 'Config\\App', 'siteName', 'Raj Edu', 'string', NULL, '2022-09-15 23:55:42', '2022-09-15 23:55:42');

-- --------------------------------------------------------

--
-- Table structure for table `raj_users`
--

CREATE TABLE `raj_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_id` int(11) NOT NULL,
  `email` varchar(191) DEFAULT NULL,
  `new_email` varchar(191) DEFAULT NULL,
  `password_hash` varchar(191) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `activate_hash` varchar(191) DEFAULT NULL,
  `reset_hash` varchar(191) DEFAULT NULL,
  `reset_expires` bigint(20) DEFAULT NULL,
  `created_at` bigint(20) DEFAULT NULL,
  `updated_at` bigint(20) DEFAULT NULL,
  `deleted` enum('Y','N') DEFAULT 'N',
  `active` enum('Y','N') NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `raj_users`
--

INSERT INTO `raj_users` (`id`, `group_id`, `email`, `new_email`, `password_hash`, `user_name`, `mobile`, `activate_hash`, `reset_hash`, `reset_expires`, `created_at`, `updated_at`, `deleted`, `active`) VALUES
(1, 1, 'admin@rajedu.com', NULL, '$2y$10$mUhMntqX7x6iZMeINHhHieaJp39CqzohLW.1x5FObDwL30E2YYsl.', NULL, NULL, NULL, NULL, NULL, NULL, 1658487354, 'N', 'Y'),
(2, 2, 'test@gmail.com', NULL, '$2y$10$SsQDiiHRgGyaetpKeU7bf.Z7sAAF/mmJmbWAqcJaxrcRsdKpxW4jW', 'test', NULL, NULL, NULL, NULL, NULL, NULL, 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `raj_user_details`
--

CREATE TABLE `raj_user_details` (
  `id` bigint(20) NOT NULL,
  `parent_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `first_name` varchar(155) DEFAULT NULL,
  `last_name` varchar(155) DEFAULT NULL,
  `phone` varchar(155) DEFAULT NULL,
  `alternative_phone` varchar(155) DEFAULT NULL,
  `establishment_date` varchar(50) DEFAULT NULL,
  `address` text,
  `display_picture` text,
  `toc` enum('Y','N') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `raj_user_details`
--

INSERT INTO `raj_user_details` (`id`, `parent_id`, `name`, `first_name`, `last_name`, `phone`, `alternative_phone`, `establishment_date`, `address`, `display_picture`, `toc`) VALUES
(1, 0, NULL, 'Subrata', 'Jana', NULL, NULL, NULL, NULL, NULL, 'Y'),
(2, 2, 'Test User', NULL, NULL, '55555', '11111111', NULL, 'Kolkata', '1666681384_a16396fb7f3f46919c00.jpg', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `raj_groups`
--
ALTER TABLE `raj_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raj_master_data`
--
ALTER TABLE `raj_master_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raj_migrations`
--
ALTER TABLE `raj_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raj_settings`
--
ALTER TABLE `raj_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `raj_users`
--
ALTER TABLE `raj_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`) USING BTREE;

--
-- Indexes for table `raj_user_details`
--
ALTER TABLE `raj_user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `raj_groups`
--
ALTER TABLE `raj_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `raj_master_data`
--
ALTER TABLE `raj_master_data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `raj_migrations`
--
ALTER TABLE `raj_migrations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `raj_settings`
--
ALTER TABLE `raj_settings`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `raj_users`
--
ALTER TABLE `raj_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `raj_user_details`
--
ALTER TABLE `raj_user_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
