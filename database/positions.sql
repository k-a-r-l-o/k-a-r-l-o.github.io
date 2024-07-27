-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 06:43 AM
-- Server version: 10.11.8-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u753706103_Voting_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `council_id` int(11) DEFAULT NULL,
  `council_name` varchar(55) NOT NULL,
  `position_name` varchar(50) NOT NULL,
  `position_slot` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `council_id`, `council_name`, `position_name`, `position_slot`) VALUES
(1, 1, 'SABES', 'Governor', 1),
(2, 1, 'SABES', 'Vice Governor', 1),
(3, 1, 'SABES', 'Secretary', 1),
(4, 1, 'SABES', 'Treasurer', 1),
(5, 1, 'SABES', 'Auditor', 1),
(6, 1, 'SABES', 'Senator', 3),
(7, 2, 'OFEE', 'Governor', 1),
(8, 2, 'OFEE', 'Vice Governor', 1),
(9, 2, 'OFEE', 'Secretary', 1),
(10, 2, 'OFEE', 'Treasurer', 1),
(11, 2, 'OFEE', 'Auditor', 1),
(12, 2, 'OFEE', 'Senator', 3),
(13, 3, 'AECES', 'Governor', 1),
(14, 3, 'AECES', 'Vice Governor', 1),
(15, 3, 'AECES', 'Secretary', 1),
(16, 3, 'AECES', 'Treasurer', 1),
(17, 3, 'AECES', 'Auditor', 1),
(18, 3, 'AECES', 'Senator', 3),
(19, 4, 'OFSET', 'Governor', 1),
(20, 4, 'OFSET', 'Vice Governor', 1),
(21, 4, 'OFSET', 'Secretary', 1),
(22, 4, 'OFSET', 'Treasurer', 1),
(23, 4, 'OFSET', 'Auditor', 1),
(24, 4, 'OFSET', 'Senator', 3),
(25, 5, 'AFSET', 'Governor', 1),
(26, 5, 'AFSET', 'Vice Governor', 1),
(27, 5, 'AFSET', 'Secretary', 1),
(28, 5, 'AFSET', 'Treasurer', 1),
(29, 5, 'AFSET', 'Auditor', 1),
(30, 5, 'AFSET', 'MATH Senator', 3),
(31, 5, 'AFSET', 'ENGLISH Senator', 3),
(32, 5, 'AFSET', 'FILIPINO Senator', 3),
(33, 6, 'SITS', 'Governor', 1),
(34, 6, 'SITS', 'Vice Governor', 1),
(35, 6, 'SITS', 'Secretary', 1),
(36, 6, 'SITS', 'Treasurer', 1),
(37, 6, 'SITS', 'Auditor', 1),
(38, 6, 'SITS', 'Senator', 3),
(39, 7, 'FTVETTS', 'Governor', 1),
(40, 7, 'FTVETTS', 'Vice Governor', 1),
(41, 7, 'FTVETTS', 'Secretary', 1),
(42, 7, 'FTVETTS', 'Treasurer', 1),
(43, 7, 'FTVETTS', 'Auditor', 1),
(44, 7, 'FTVETTS', 'Senator', 3),
(45, 8, 'TSC', 'President', 1),
(46, 8, 'TSC', 'Vice President for Internal Affairs', 1),
(47, 8, 'TSC', 'Vice President for External Affairs', 1),
(48, 8, 'TSC', 'General Secretary', 1),
(49, 8, 'TSC', 'General Treasurer', 1),
(50, 8, 'TSC', 'General Auditor', 1),
(51, 8, 'TSC', 'Public Information Officer', 1);


--
-- Indexes for dumped tables
--

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `council_id` (`council_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
