-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 13, 2022 at 10:01 PM
-- Server version: 5.6.41-84.1
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
-- Database: `thomaspo_pagefarms`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(4) NOT NULL,
  `sent_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `school_name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `school_addr` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `school_city` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `school_zip` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `num_children` int(3) NOT NULL,
  `num_teachers` int(3) NOT NULL,
  `num_adults` int(3) NOT NULL,
  `contact_person` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `contact_first` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `contact_last` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `contact_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `contact_ext` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `alt_phone` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `alt_ext` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `contact_email` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `res_year` int(4) NOT NULL DEFAULT '2019',
  `requested_date` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `requested_month` int(2) NOT NULL,
  `requested_day` int(2) NOT NULL,
  `arrival_time` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `arrival_hour` int(2) NOT NULL,
  `hr24` int(2) NOT NULL,
  `arrival_min` int(2) NOT NULL,
  `arrival_ampm` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `special_needs` text COLLATE utf8_unicode_ci NOT NULL,
  `comments` text COLLATE utf8_unicode_ci NOT NULL,
  `TYPE` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
