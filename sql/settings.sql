-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 18, 2022 at 01:36 PM
-- Server version: 8.0.30-0ubuntu0.22.04.1
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `holderHill`
--

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `index` int NOT NULL,
  `farm_name` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `max_kids` int NOT NULL,
  `day_max_kids` int NOT NULL,
  `orange_margin` int NOT NULL,
  `site_url` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_email` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_email_cc` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_email_bcc` varchar(80) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `confirmation_body` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `master_password` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `spring_opening_month` int NOT NULL,
  `spring_opening_day` int NOT NULL,
  `spring_closing_month` int NOT NULL,
  `spring_closing_day` int NOT NULL,
  `spring_open_hour` int NOT NULL,
  `spring_open_min` int NOT NULL,
  `spring_close_hour` int NOT NULL,
  `spring_close_min` int NOT NULL,
  `fall_opening_month` int NOT NULL,
  `fall_opening_day` int NOT NULL,
  `fall_closing_month` int NOT NULL,
  `fall_closing_day` int NOT NULL,
  `fall_open_hour` int NOT NULL,
  `fall_open_min` int NOT NULL,
  `fall_close_hour` int NOT NULL,
  `fall_close_min` int NOT NULL,
  `dr_start_month` int NOT NULL DEFAULT '1',
  `dr_end_month` int NOT NULL DEFAULT '12',
  `dr_start_day` int NOT NULL DEFAULT '2',
  `dr_end_day` int NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`index`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `index` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
