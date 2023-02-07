-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 25, 2022 at 07:15 AM
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
-- Indexes for table `raj_user_details`
--
ALTER TABLE `raj_user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `raj_user_details`
--
ALTER TABLE `raj_user_details`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
