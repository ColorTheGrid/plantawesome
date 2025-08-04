-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 04 aug 2025 om 08:55
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
-- Database: `plantstore`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `stock` tinyint NOT NULL,
  `itemName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `itemDescription` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `itemPrice` double NOT NULL,
  `itemImg` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `item`
--

INSERT INTO `item` (`Id`, `stock`, `itemName`, `itemDescription`, `itemPrice`, `itemImg`) VALUES
(43, 1, 'JungleJuice', 'Fusce imperdiet tortor enim, id laoreet mauris fringilla eu. Ut vitae suscipit libero. Aenean laoreet ante at ante luctus bibendum. Donec eget nibh et odio tristique euismod.', 25, 'img/pexels-kseniachernaya-7318145.jpg'),
(44, 0, 'Wacky ', 'Fusce imperdiet tortor enim, id laoreet mauris fringilla eu. Ut vitae suscipit libero. Aenean laoreet ante at ante luctus bibendum. Donec eget nibh et odio tristique euismod.', 12, 'img/pexels-kseniachernaya-7318096.jpg'),
(45, 1, 'LocalPlant', 'Fusce imperdiet tortor enim, id laoreet mauris fringilla eu. Ut vitae suscipit libero. Aenean laoreet ante at ante luctus bibendum. Donec eget nibh et odio tristique euismod.', 55, 'img/pexels-anna-nekrashevich-8988961.jpg'),
(46, 1, 'SeriouslyAwesome', 'Fusce imperdiet tortor enim, id laoreet mauris fringilla eu. Ut vitae suscipit libero. Aenean laoreet ante at ante luctus bibendum. Donec eget nibh et odio tristique euismod.', 65, 'img/pexels-anna-nekrashevich-8988963.jpg'),
(47, 1, 'JangoBel', 'Fusce imperdiet tortor enim, id laoreet mauris fringilla eu. Ut vitae suscipit libero. Aenean laoreet ante at ante luctus bibendum. Donec eget nibh et odio tristique euismod.', 25, 'img/pexels-juanpphotoandvideo-1084188.jpg');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int NOT NULL AUTO_INCREMENT,
  `orderUserId` int NOT NULL,
  `orderItemId` int NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `orderItemId_itemId` (`orderItemId`),
  KEY `orderUserId_userId` (`orderUserId`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`orderId`, `orderUserId`, `orderItemId`) VALUES
(107, 47, 45),
(109, 50, 46),
(111, 50, 43),
(112, 50, 44),
(113, 50, 45),
(114, 50, 44),
(115, 50, 46),
(116, 50, 44),
(117, 50, 43),
(118, 50, 46),
(119, 50, 44),
(120, 38, 44),
(121, 38, 44),
(122, 38, 44),
(123, 38, 45),
(124, 38, 46),
(125, 38, 45),
(126, 38, 44),
(127, 38, 47),
(128, 38, 45),
(129, 38, 44),
(130, 38, 44),
(131, 38, 44),
(132, 38, 44),
(133, 38, 45),
(134, 38, 44),
(135, 38, 43),
(136, 38, 44),
(137, 38, 44),
(138, 55, 47),
(139, 38, 47),
(140, 38, 44),
(141, 38, 43),
(142, 38, 44),
(143, 38, 47),
(144, 38, 44),
(145, 38, 45),
(146, 38, 43),
(147, 38, 45),
(148, 38, 46),
(149, 38, 47),
(150, 38, 47),
(151, 38, 47),
(152, 38, 46),
(153, 38, 43),
(154, 38, 47),
(155, 38, 47),
(156, 38, 44),
(157, 38, 46),
(158, 38, 44),
(159, 38, 47),
(160, 38, 44),
(161, 38, 44),
(162, 38, 44),
(163, 38, 44),
(164, 38, 44);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `isAdmin` tinyint(1) NOT NULL,
  `userEmail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userPassword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`Id`, `isAdmin`, `userEmail`, `userName`, `userPassword`) VALUES
(38, 1, 'willemvinke8@gmail.com', 'WillemVinke', '$2y$10$GKanTsTkXi8VC5xRepEasOXId43nkZ1nt6TY3D575FjOnkBGL1bPu'),
(43, 0, 'foo@bar.com', 'foo', '$2y$10$rv4nGTbxqRvroN3qasuyFO/pjsTEBvdVtuayENtDKOTmYxmiHhQ3a'),
(44, 0, 'foo@foo.foo', 'foo', '$2y$10$FK8oh0plFyT3fdmPoUGqJu1pCajWCbvYN19X53ONlshsKd8pL9yZS'),
(47, 0, 'willemvinke5@gmail.com', 'WillemVinke', '$2y$10$7XERQ4hNIBAb9tu3wH/C.uZnVEtaGDwh5O1yYV1jGG4p6TGTO4hiq'),
(48, 0, 'willemvinke10@gmail.com', 'WillemVinke', '$2y$10$GVzjysr0afC4BLZpRtG21eM97JXYghiLFcL.LWTRMVICII9.N4dWG'),
(49, 1, 'willemvinke15@gmail.com', 'WillemVinke', '$2y$10$HwMM5YQqHvRRdZuxkxEbYuGBdb7NGgqeCT.Taedga98KY0axWs6fy'),
(50, 1, 'willemvinke20@gmail.com', 'WillemVinke', '$2y$10$j6eYkz1ZD9nS0rlV4waDBuU4JDsLzBOE879X3jXxYFl/vpgGtkpP.'),
(51, 0, 'willemvinke2@gmail.com', 'WillemVinke', '$2y$10$ktZ92fXKQZZneju942q7vO/2Z/FeZzjBg1V.K5A0mMjqw03xvQasq'),
(52, 1, 'willemvinke1@gmail.com', 'WillemVinke', '$2y$10$1feabn2ytU.XnYeD2eYpEeuBlv.CoylkJxt7t5FnX463nq2/bUe2O'),
(53, 1, 'willemvinke22@gmail.com', 'WillemVinke', '$2y$10$1AscgSXbnvVm8dk0QOGA7ueOZoPAUS4wJqKXw7fWsQKG.VADSA4l2'),
(54, 0, 'willemvinke3@gmail.com', 'WillemVinke', '$2y$10$H5HRbXGHqMoXQFug/BYWuuAKHpWRZSjdhErD21/gaFrLskJYwWQO2'),
(55, 0, 'double@damage.records', 'double', '$2y$10$oQaRfn5BHxd6WjqD.n1R9.nP0TRIviO.0e0VVw5DyR6ZukaQI23U.'),
(56, 0, 'hello@me.me', 'hello', '$2y$10$eGV0VLkIllj5G5vkFTwPV.x4qUOvmQoGvQg7AuPSfcFF9GJE.EQ4C'),
(57, 1, 'wu@wu.wu', 'wu', '$2y$10$kqI9Ib9EAwlRCr1bqNcy7./Tg.JBsvpfdXCuhlZ0kbQ34krWRaJli');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `useraddress`
--

DROP TABLE IF EXISTS `useraddress`;
CREATE TABLE IF NOT EXISTS `useraddress` (
  `userId` int NOT NULL,
  `streetName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `streetNumber` int NOT NULL,
  `streetPostalCode` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `useraddress`
--

INSERT INTO `useraddress` (`userId`, `streetName`, `streetNumber`, `streetPostalCode`, `country`) VALUES
(38, 'Malangstraat', 20, '7541 AD', 'Netherlands'),
(43, 'Malangstraat', 20, '7541 AD', 'Netherlands'),
(47, 'Malangstraat', 20, '7541AD', 'Netherlands'),
(48, 'Malangstraat', 20, '7541 AD', 'Netherlands'),
(50, 'Malangstraat ', 20, '7541 AD', 'Netherlands'),
(55, '20', 0, '7541AD', 'Netherlands'),
(56, '20', 0, '7541AD', 'Netherlands');

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orderItemId_itemId` FOREIGN KEY (`orderItemId`) REFERENCES `item` (`Id`),
  ADD CONSTRAINT `orderUserId_userId` FOREIGN KEY (`orderUserId`) REFERENCES `user` (`Id`);

--
-- Beperkingen voor tabel `useraddress`
--
ALTER TABLE `useraddress`
  ADD CONSTRAINT `UserAddressId_UserId` FOREIGN KEY (`userId`) REFERENCES `user` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
