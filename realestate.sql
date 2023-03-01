-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 01, 2023 at 11:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate`
--

-- --------------------------------------------------------

--
-- Table structure for table `annonce`
--

CREATE TABLE `annonce` (
  `annonceID` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `publicationDate` datetime NOT NULL DEFAULT current_timestamp(),
  `lastModificationDate` datetime DEFAULT NULL,
  `type` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL,
  `superficie` int(50) NOT NULL,
  `postalCode` int(11) NOT NULL,
  `city` varchar(50) NOT NULL,
  `avenue` varchar(100) NOT NULL,
  `clientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `annonce`
--

INSERT INTO `annonce` (`annonceID`, `title`, `price`, `publicationDate`, `lastModificationDate`, `type`, `category`, `superficie`, `postalCode`, `city`, `avenue`, `clientID`) VALUES
(9, 'Nemo deserunt qui do', 120000, '2023-02-25 00:18:16', NULL, 'villa', 'vente', 65, 13, 'Casablanca', 'Et autem pariatur O', 17),
(10, 'best maison     ', 310000, '2023-02-25 00:18:55', NULL, 'maison', 'loca', 90000, 22, 'Tanger', 'villa vista', 17),
(11, 'Et numquam dolores e', 15000, '2023-02-25 00:19:28', NULL, 'villa', 'loca', 72, 64, 'Casablanca', 'Est adipisicing ven', 17),
(12, 'Enim porro pariatur', 70000, '2023-02-25 01:52:18', NULL, 'maison', 'loca', 80, 20000, 'Safi', 'Officia est reprehe', 18),
(13, 'Modi et recusandae ', 500000, '2023-02-25 01:53:28', NULL, 'appartement', 'vente', 240, 10000, 'Taza', 'Voluptatem eu minus', 18),
(14, 'Ut at consequatur ex', 200000, '2023-02-25 01:54:25', NULL, 'bureau', 'vente', 150, 90000, 'tanger', 'Sit qui ullamco eaqu', 18),
(15, 'Repudiandae nihil si', 80000, '2023-02-25 02:04:23', NULL, 'maison', 'loca', 75, 40000, 'Khémisset', 'Omnis culpa aliquam ', 19),
(16, 'Amet est lorem off', 782000, '2023-02-25 02:05:05', NULL, 'appartement', 'vente', 130, 90000, 'Tanger', 'Et aut aliquid est v', 19),
(17, 'Fugiat et et lorem e', 969, '2023-02-27 12:25:06', NULL, 'maison', 'vente', 65, 7, 'Mohammédia', 'Aliquam suscipit con', 17),
(18, 'Fugiat et et lorem e', 969, '2023-02-27 12:25:06', NULL, 'maison', 'vente', 65, 7, 'Mohammédia', 'Aliquam suscipit con', 17),
(19, 'Fugiat et et lorem e', 969, '2023-02-27 12:25:44', NULL, 'maison', 'vente', 65, 7, 'Mohammédia', 'Aliquam suscipit con', 17);

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `clientID` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `profielPic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`clientID`, `firstName`, `lastName`, `email`, `password`, `phone`, `profielPic`) VALUES
(17, 'amine', 'lamchatab', 'amine@gmail.com', '$2y$10$PnjZrzeaoXf/4cyDdOz7UeF1wfw6GsW559ahF1ri9Of', '645789851', 'profiel.jpeg'),
(18, 'yassin', 'lamchatab', 'yassin@gmail.com', '$2y$10$7eX70Ukv6.hbnNiXiouBOemrwHAqF7g0UeIR.MRZZUV', '675487115', NULL),
(19, 'imran', 'lamchatab', 'imran@gmail.com', '$2y$10$ccWDABROQHXvc6BxubEpTOy6N2rwvfqac3E6UuW.C4V', '612538947', NULL),
(20, 'hamza', 'ben', 'benamm@gmailcom', '$2y$10$ooqYNH3sY3.s4PHkc.J9feUgbCkpk.KW06zcLBX6uLm', '606060607', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `imageID` int(11) NOT NULL,
  `imagePath` varchar(200) NOT NULL,
  `imageType` varchar(20) NOT NULL,
  `annonceID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`imageID`, `imagePath`, `imageType`, `annonceID`) VALUES
(13, './imagesFiles/realestate3.jpg', '1', 9),
(14, './imagesFiles/realestate4.jpg', '0', 9),
(15, './imagesFiles/realestate5.jpg', '0', 9),
(16, './imagesFiles/realestate6.jpg', '1', 10),
(17, './imagesFiles/realestate5.jpg', '0', 10),
(18, './imagesFiles/realestate4.jpg', '0', 10),
(19, './imagesFiles/realestate9.jpg', '1', 11),
(20, './imagesFiles/realestate8.jpg', '0', 11),
(21, './imagesFiles/realestate7.jpg', '0', 11),
(22, './imagesFiles/realestate12.jpg', '1', 12),
(23, './imagesFiles/realestate11.jpg', '0', 12),
(24, './imagesFiles/realestate10.jpg', '0', 12),
(25, './imagesFiles/realestate15.jpg', '1', 13),
(26, './imagesFiles/realestate14.jpg', '0', 13),
(27, './imagesFiles/realestate13.jpg', '0', 13),
(28, './imagesFiles/realestate17.jpg', '1', 14),
(29, './imagesFiles/realestate18.jpg', '0', 14),
(30, './imagesFiles/realestate16.jpg', '0', 14),
(31, './imagesFiles/realestate21.jpg', '1', 15),
(32, './imagesFiles/realestate20.jpg', '0', 15),
(33, './imagesFiles/realestate19.jpg', '0', 15),
(34, './imagesFiles/realestate24.jpg', '1', 16),
(35, './imagesFiles/realestate23.jpg', '0', 16),
(36, './imagesFiles/realestate22.jpg', '0', 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`annonceID`),
  ADD KEY `annonce_ibfk_1` (`clientID`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`clientID`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`imageID`),
  ADD KEY `image_ibfk_1` (`annonceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `annonceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `clientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `imageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`clientID`) REFERENCES `client` (`clientID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `image_ibfk_1` FOREIGN KEY (`annonceID`) REFERENCES `annonce` (`annonceID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
