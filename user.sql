-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 23 jun 2026 om 09:54
-- Serverversie: 9.1.0
-- PHP-versie: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plantdatabase`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `UserId` int NOT NULL AUTO_INCREMENT,
  `UserAdmin` tinyint(1) DEFAULT '0',
  `UserEmail` varchar(100) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `UserPassword` varchar(255) NOT NULL,
  `StreetNumber` varchar(20) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`UserId`),
  UNIQUE KEY `UserEmail` (`UserEmail`),
  KEY `PostalCode` (`PostalCode`,`StreetNumber`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`UserId`, `UserAdmin`, `UserEmail`, `UserName`, `UserPassword`, `StreetNumber`, `PostalCode`) VALUES
(3, 0, 'admin@shop.com', 'admin', '$2y$10$5xuX4H5sGG0EVcljneA/H.A/ogjbQCqt9bG6YC4m65XEPdPkt6NQ.', NULL, NULL),
(2, 1, 'admin@gmail.com', 'admin', '$2y$10$VrAxKSNqPhqs3qqw0du9mOUGyVt2WWF5WX4UwofKBjqSf0wC0oJW2', '42', '1011DJ'),
(17, 1, 'wvinke550@gmail.com', 'Willem', '$2y$10$5iWUcNY2Q.rRnUGDtB9Mx.CXmS5uCFh5mASVXdOOA1axE6B876dLO', '341-2', '7533 AS'),
(18, 1, 'new@admin.com', 'new', '$2y$10$k7EF7ZUGtjoHfajFU2qrWeJp4l1qytmoE2HMMkt/T29XbGDhtQRnO', NULL, NULL),
(19, 0, 'wvinke@gmail.com', 'WillemVinke', '$2y$10$A9Y.vW2c7KC7u9Fjn8QEQ.Oj29CmMbQ164m5Gjxd7b3ICuwYmLUgG', '341-2', '7533 AS');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
