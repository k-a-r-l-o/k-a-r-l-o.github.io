-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2024 at 06:56 AM
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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `usep_ID` int NOT NULL,
  `logs_date` date NOT NULL,
  `logs_time` time NOT NULL,
  `logs_action` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  KEY `usep_ID` (`usep_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aeces_votes`
--

DROP TABLE IF EXISTS `aeces_votes`;
CREATE TABLE IF NOT EXISTS `aeces_votes` (
  `usep_ID` int NOT NULL,
  `AECES_Governor` int NOT NULL,
  `AECES_Vice_Governor` int NOT NULL,
  `AECES_Secretary` int NOT NULL,
  `AECES_Auditor` int NOT NULL,
  `AECES_Treasurer` int NOT NULL,
  `AECES_Senator1` int NOT NULL,
  `AECES_Senator2` int NOT NULL,
  `AECES_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`AECES_Governor`),
  KEY `Vice_Governor` (`AECES_Vice_Governor`),
  KEY `Secretary` (`AECES_Secretary`),
  KEY `Treasurer` (`AECES_Treasurer`),
  KEY `Senator1` (`AECES_Senator1`),
  KEY `Senator2` (`AECES_Senator2`),
  KEY `Senator3` (`AECES_Senator3`),
  KEY `Auditor` (`AECES_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `afset_votes`
--

DROP TABLE IF EXISTS `afset_votes`;
CREATE TABLE IF NOT EXISTS `afset_votes` (
  `usep_ID` int NOT NULL,
  `AFSET_Governor` int NOT NULL,
  `AFSET_Vice_Governor` int NOT NULL,
  `AFSET_Secretary` int NOT NULL,
  `AFSET_Treasurer` int NOT NULL,
  `AFSET_Auditor` int NOT NULL,
  `AFSET_MATH_Senator1` int DEFAULT NULL,
  `AFSET_MATH_Senator2` int DEFAULT NULL,
  `AFSET_MATH_Senator3` int DEFAULT NULL,
  `AFSET_ENGLISH_Senator1` int DEFAULT NULL,
  `AFSET_ENGLISH_Senator2` int DEFAULT NULL,
  `AFSET_ENGLISH_Senator3` int DEFAULT NULL,
  `AFSET_FILIPINO_Senator1` int DEFAULT NULL,
  `AFSET_FILIPINO_Senator2` int DEFAULT NULL,
  `AFSET_FILIPINO_Senator3` int DEFAULT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`AFSET_Governor`),
  KEY `Vice_Governor` (`AFSET_Vice_Governor`),
  KEY `Secretary` (`AFSET_Secretary`),
  KEY `Treasurer` (`AFSET_Treasurer`),
  KEY `MATH_Senator1` (`AFSET_MATH_Senator1`),
  KEY `MATH_Senator2` (`AFSET_MATH_Senator2`),
  KEY `MATH_Senator3` (`AFSET_MATH_Senator3`),
  KEY `ENGLISH_Senator1` (`AFSET_ENGLISH_Senator1`),
  KEY `ENGLISH_Senator2` (`AFSET_ENGLISH_Senator2`),
  KEY `ENGLISH_Senator3` (`AFSET_ENGLISH_Senator3`),
  KEY `FILIPINO_Senator1` (`AFSET_FILIPINO_Senator1`),
  KEY `FILIPINO_Senator2` (`AFSET_FILIPINO_Senator2`),
  KEY `FILIPINO_Senator3` (`AFSET_FILIPINO_Senator3`),
  KEY `Auditor` (`AFSET_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
CREATE TABLE IF NOT EXISTS `candidates` (
  `usep_ID` int NOT NULL,
  `candPic` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `LName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `FName` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `gender` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `yearLvl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `program` varchar(55) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `council` varchar(55) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(55) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prty_ID` int DEFAULT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `prty_ID` (`prty_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ftvets_votes`
--

DROP TABLE IF EXISTS `ftvets_votes`;
CREATE TABLE IF NOT EXISTS `ftvets_votes` (
  `usep_ID` int NOT NULL,
  `FTVETS_Governor` int NOT NULL,
  `FTVETS_Vice_Governor` int NOT NULL,
  `FTVETS_Secretary` int NOT NULL,
  `FTVETS_Treasurer` int NOT NULL,
  `FTVETS_Auditor` int NOT NULL,
  `FTVETS_Senator1` int NOT NULL,
  `FTVETS_Senator2` int NOT NULL,
  `FTVETS_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`FTVETS_Governor`),
  KEY `Vice_Governor` (`FTVETS_Vice_Governor`),
  KEY `Secretary` (`FTVETS_Secretary`),
  KEY `Treasurer` (`FTVETS_Treasurer`),
  KEY `Senator1` (`FTVETS_Senator1`),
  KEY `Senator2` (`FTVETS_Senator2`),
  KEY `Senator3` (`FTVETS_Senator3`),
  KEY `Auditor` (`FTVETS_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_councils`
--

DROP TABLE IF EXISTS `list_councils`;
CREATE TABLE IF NOT EXISTS `list_councils` (
  `council_ID` int DEFAULT NULL,
  `council_name` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(55) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Cnl_level` int DEFAULT NULL,
  `cFullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `list_partylist`
--

DROP TABLE IF EXISTS `list_partylist`;
CREATE TABLE IF NOT EXISTS `list_partylist` (
  `prty_ID` int NOT NULL AUTO_INCREMENT,
  `name_partylist` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`prty_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_partylist`
--

INSERT INTO `list_partylist` (`prty_ID`, `name_partylist`) VALUES
(1, 'Independent');

-- --------------------------------------------------------

--
-- Table structure for table `ofee_votes`
--

DROP TABLE IF EXISTS `ofee_votes`;
CREATE TABLE IF NOT EXISTS `ofee_votes` (
  `usep_ID` int NOT NULL,
  `OFEE_Governor` int NOT NULL,
  `OFEE_Vice_Governor` int NOT NULL,
  `OFEE_Secretary` int NOT NULL,
  `OFEE_Treasurer` int NOT NULL,
  `OFEE_Auditor` int NOT NULL,
  `OFEE_Senator1` int NOT NULL,
  `OFEE_Senator2` int NOT NULL,
  `OFEE_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`OFEE_Governor`),
  KEY `Vice_Governor` (`OFEE_Vice_Governor`),
  KEY `Secretary` (`OFEE_Secretary`),
  KEY `Treasurer` (`OFEE_Treasurer`),
  KEY `Senator1` (`OFEE_Senator1`),
  KEY `Senator2` (`OFEE_Senator2`),
  KEY `Senator3` (`OFEE_Senator3`),
  KEY `Auditor` (`OFEE_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ofset_votes`
--

DROP TABLE IF EXISTS `ofset_votes`;
CREATE TABLE IF NOT EXISTS `ofset_votes` (
  `usep_ID` int NOT NULL,
  `OFSET_Governor` int NOT NULL,
  `OFSET_Vice_Governor` int NOT NULL,
  `OFSET_Secretary` int NOT NULL,
  `OFSET_Treasurer` int NOT NULL,
  `OFSET_Auditor` int NOT NULL,
  `OFSET_Senator1` int NOT NULL,
  `OFSET_Senator2` int NOT NULL,
  `OFSET_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`OFSET_Governor`),
  KEY `Vice_Governor` (`OFSET_Vice_Governor`),
  KEY `Secretary` (`OFSET_Secretary`),
  KEY `Treasurer` (`OFSET_Treasurer`),
  KEY `Senator1` (`OFSET_Senator1`),
  KEY `Senator2` (`OFSET_Senator2`),
  KEY `Senator3` (`OFSET_Senator3`),
  KEY `Auditor` (`OFSET_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

DROP TABLE IF EXISTS `positions`;
CREATE TABLE IF NOT EXISTS `positions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `council_id` int DEFAULT NULL,
  `council_name` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `position_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `position_slot` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `council_id` (`council_id`)
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `prgramID` int NOT NULL,
  `Program` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`prgramID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`prgramID`, `Program`) VALUES
(1, 'BSABE'),
(2, 'BEEd'),
(3, 'BECEd'),
(4, 'BSNEd'),
(5, 'BSEd'),
(6, 'BSIT'),
(7, 'BTVTEd');

-- --------------------------------------------------------

--
-- Table structure for table `sabes_votes`
--

DROP TABLE IF EXISTS `sabes_votes`;
CREATE TABLE IF NOT EXISTS `sabes_votes` (
  `usep_ID` int NOT NULL,
  `SABES_Governor` int NOT NULL,
  `SABES_Vice_Governor` int NOT NULL,
  `SABES_Secretary` int NOT NULL,
  `SABES_Treasurer` int NOT NULL,
  `SABES_Auditor` int NOT NULL,
  `SABES_Senator1` int NOT NULL,
  `SABES_Senator2` int NOT NULL,
  `SABES_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`SABES_Governor`),
  KEY `Vice_Governor` (`SABES_Vice_Governor`),
  KEY `Secretary` (`SABES_Secretary`),
  KEY `Treasurer` (`SABES_Treasurer`),
  KEY `Senator1` (`SABES_Senator1`),
  KEY `Senator2` (`SABES_Senator2`),
  KEY `Senator3` (`SABES_Senator3`),
  KEY `Auditor` (`SABES_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sits_votes`
--

DROP TABLE IF EXISTS `sits_votes`;
CREATE TABLE IF NOT EXISTS `sits_votes` (
  `usep_ID` int NOT NULL,
  `SITS_Governor` int NOT NULL,
  `SITS_Vice_Governor` int NOT NULL,
  `SITS_Secretary` int NOT NULL,
  `SITS_Treasurer` int NOT NULL,
  `SITS_Auditor` int NOT NULL,
  `SITS_Senator1` int NOT NULL,
  `SITS_Senator2` int NOT NULL,
  `SITS_Senator3` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `LC_Governor` (`SITS_Governor`),
  KEY `Vice_Governor` (`SITS_Vice_Governor`),
  KEY `Secretary` (`SITS_Secretary`),
  KEY `Treasurer` (`SITS_Treasurer`),
  KEY `Senator1` (`SITS_Senator1`),
  KEY `Senator2` (`SITS_Senator2`),
  KEY `Senator3` (`SITS_Senator3`),
  KEY `Auditor` (`SITS_Auditor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tsc_votes`
--

DROP TABLE IF EXISTS `tsc_votes`;
CREATE TABLE IF NOT EXISTS `tsc_votes` (
  `usep_ID` int NOT NULL,
  `TSC_President` int NOT NULL,
  `TSC_Vice_President_for_Internal_Affairs` int NOT NULL,
  `TSC_Vice_President_for_External_Affairs` int NOT NULL,
  `TSC_General_Secretary` int NOT NULL,
  `TSC_General_Treasurer` int NOT NULL,
  `TSC_General_Auditor` int NOT NULL,
  `TSC_Public_Information_Officer` int NOT NULL,
  PRIMARY KEY (`usep_ID`),
  KEY `President` (`TSC_President`),
  KEY `Vice_President_Internal_Affairs` (`TSC_Vice_President_for_Internal_Affairs`),
  KEY `Vice_President_External_Affairs` (`TSC_Vice_President_for_External_Affairs`),
  KEY `General_Secretary` (`TSC_General_Secretary`),
  KEY `General_Treasurer` (`TSC_General_Treasurer`),
  KEY `General_Auditor` (`TSC_General_Auditor`),
  KEY `Public_Information_Officer` (`TSC_Public_Information_Officer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usep_ID` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `userpass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `usertype` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `User_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_heartbeat` timestamp NULL DEFAULT NULL,
  `logged_out` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`usep_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usep_ID`, `username`, `userpass`, `LName`, `FName`, `usertype`, `User_status`, `last_heartbeat`, `logged_out`) VALUES
(1, 'Central', '$2y$10$gjoPHd7q1v9/e98MTPsU.uj8dewn/TyzJt1SpUAV14m5.hywYfYvK', 'Cornejo', 'Karl', 'Chairperson', 'Active', '2024-07-27 06:53:30', 0),
(2, 'Alexis', '$2y$10$mmCslwt6Rm/VdCfq7zTbD.EAuxnsTTpJ4IKi1Svv5xSO2Mo8oQrC.', 'Bughao', 'Alexis Nicole ', 'Chairperson', 'Offline', NULL, 0),
(100010000, 'SABES', '$2y$10$SpJGT1TMGuq0NMRjwHSwIu.bf6ugoyn8lLSn7yumZWiDgWqMlHgaa', 'Watcher', 'SABES', 'Watcher', 'Offline', NULL, 0),
(200020000, 'OFEE', '$2y$10$9Ma0SFpXkb3jRSRmJskxE.0qQpFTFPqs4Mn6V0lAxrzXdkzuVXur2', 'Watcher', 'OFEE', 'Watcher', 'Offline', '2024-06-02 06:07:53', 1),
(202000123, 'kaidrmil ', '$2y$10$AF80CjSEVUMuiRa8afypteT21xHwJRLHU2OI0DVSsVebI2frRUhny', 'Millana', 'Kaizer Dredd ', 'Admin-Front', 'Offline', '2024-07-12 07:15:31', 0),
(202300118, 'BrixB', '$2y$10$4rrZm58A.x2p26L72xNa5uIphJ4JjmYQzupyn8VF0k7cHXm/w9R9C', 'Beron', 'Brix', 'Admin-Front', 'Offline', '2024-07-12 07:13:11', 0),
(202300237, 'Marr', '$2y$10$0vzclOfMChw5WyhIE0iEgeXQMM6zhH1wYrlLgQbw5BooRKGctIE8.', 'Aniñon', 'Mariel ', 'Admin-Front', 'Offline', '2024-07-12 06:29:16', 0),
(300030000, 'AECES', '$2y$10$yMcfgVNeiAaNTSQ.aTvq9OeuSWow74l9bRJY2hxxzKll02Cp1U01y', 'Watcher', 'AECES', 'Watcher', 'Offline', NULL, 0),
(400040000, 'OFSET', '$2y$10$.bumwsOORX5PC31tlW2ZuOJZXifuAjsWYo3hIf5c5PKaT9WdOr0iW', 'Watcher', 'OFSET', 'Watcher', 'Offline', '2024-07-15 00:03:06', 1),
(500050000, 'AFSET', '$2y$10$vihruj.K7fHf.0XuAWRPmeME/zAzSLlHokC5CV7MHltA2F7Yy4pRG', 'Watcher', 'AFSET', 'Watcher', 'Offline', '2024-07-12 00:16:35', 0),
(600060000, 'SITS', '$2y$10$mNRcBRojAMruzfwm9ntt..e9hgcuwZ3P5sTS2V5TZ/W1gh5e1i6jK', 'Watcher', 'SITS', 'Watcher', 'Offline', '2024-07-12 06:50:09', 1),
(700070000, 'FTVETS', '$2y$10$P6WNyAPRrTp.V05R8xh4xeQ83mQyEbWw2HEmXQfaieyw5zAGNHDQy', 'Watcher', 'FTVETS', 'Watcher', 'Offline', NULL, 0),
(800080000, 'TSC', '$2y$10$rRAFPGcmOCrs8uad/upFBeUVdlR1MaffFoZ1/O95nraTrxyKVCNc2', 'Watcher', 'TSC', 'Watcher', 'Offline', '2024-07-19 02:55:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `voters`
--

DROP TABLE IF EXISTS `voters`;
CREATE TABLE IF NOT EXISTS `voters` (
  `usep_ID` int NOT NULL,
  `Email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `yearLvl` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `program` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `voted` varchar(55) COLLATE utf8mb4_general_ci NOT NULL,
  `VotedDT` datetime DEFAULT NULL,
  PRIMARY KEY (`usep_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voting_schedule`
--

DROP TABLE IF EXISTS `voting_schedule`;
CREATE TABLE IF NOT EXISTS `voting_schedule` (
  `startDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `endTime` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aeces_votes`
--
ALTER TABLE `aeces_votes`
  ADD CONSTRAINT `aeces_votes_ibfk_1` FOREIGN KEY (`AECES_Governor`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_2` FOREIGN KEY (`AECES_Vice_Governor`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_3` FOREIGN KEY (`AECES_Secretary`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_4` FOREIGN KEY (`AECES_Treasurer`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_5` FOREIGN KEY (`AECES_Senator1`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_6` FOREIGN KEY (`AECES_Senator2`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_7` FOREIGN KEY (`AECES_Senator3`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_8` FOREIGN KEY (`AECES_Auditor`) REFERENCES `candidates` (`usep_ID`),
  ADD CONSTRAINT `aeces_votes_ibfk_9` FOREIGN KEY (`usep_ID`) REFERENCES `voters` (`usep_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
