-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2024 at 06:32 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u753706103_voting_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `list_councils`
--

DROP TABLE IF EXISTS `list_councils`;
CREATE TABLE IF NOT EXISTS `list_councils` (
  `council_ID` int DEFAULT NULL,
  `council_name` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `Cnl_level` int DEFAULT NULL,
  `cFullName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  UNIQUE KEY `council_ID` (`council_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_councils`
--

INSERT INTO `list_councils` (`council_ID`, `council_name`, `program`, `Cnl_level`, `cFullName`) VALUES
(1, 'SABES', 'BSABE', 2, 'Society of Agricultural and Biosystems Engineering Students'),
(2, 'OFEE', 'BEEd', 2, 'Organization of Future Elementary Educators'),
(3, 'AECES', 'BECEd', 2, 'Association of Early Childhood Education'),
(4, 'OFSET', 'BSNEd', 2, 'Organization of Future Special Education Teachers'),
(5, 'AFSET', 'BSEd', 2, 'Association of Future Secondary Teacher'),
(6, 'SITS', 'BSIT', 2, 'Society of Information Technology Students'),
(7, 'FTVETS', 'BTVTEd', 2, 'Future Technical Vocational Educators and Trainers Society'),
(8, 'TSC', 'ALL PROGRAMS', 1, 'Tagum Student Council');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
