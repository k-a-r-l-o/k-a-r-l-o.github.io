-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 27, 2024 at 06:22 AM
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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `usep_ID` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userpass` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `LName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `FName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `usertype` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `User_status` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_heartbeat` timestamp NULL DEFAULT NULL,
  `logged_out` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`usep_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`usep_ID`, `username`, `userpass`, `LName`, `FName`, `usertype`, `User_status`, `last_heartbeat`, `logged_out`) VALUES
(1, 'Central', '$2y$10$gjoPHd7q1v9/e98MTPsU.uj8dewn/TyzJt1SpUAV14m5.hywYfYvK', 'Cornejo', 'Karl', 'Chairperson', 'Active', '2024-07-27 06:21:38', 0),
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
