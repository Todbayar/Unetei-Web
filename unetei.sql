-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2023 at 07:49 AM
-- Server version: 5.7.40
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `unetei`
--

-- --------------------------------------------------------

--
-- Table structure for table `category1`
--

DROP TABLE IF EXISTS `category1`;
CREATE TABLE IF NOT EXISTS `category1` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `userID`, `title`, `icon`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Компьютер сэлбэг хэрэгсэл', '20230404012333_Media-Design-Hydropro-V2-My-Computer.512.png', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category2`
--

DROP TABLE IF EXISTS `category2`;
CREATE TABLE IF NOT EXISTS `category2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category2`
--

INSERT INTO `category2` (`id`, `userID`, `title`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Notebook', NULL, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category3`
--

DROP TABLE IF EXISTS `category3`;
CREATE TABLE IF NOT EXISTS `category3` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category3`
--

INSERT INTO `category3` (`id`, `userID`, `title`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(3, 1, 'HP', NULL, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category4`
--

DROP TABLE IF EXISTS `category4`;
CREATE TABLE IF NOT EXISTS `category4` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL COMMENT 'user id',
  `item` int(10) NOT NULL COMMENT 'item id',
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `image` (`image`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `userID`, `item`, `image`) VALUES
(12, 1, 1, '20230405105025_6.jpg'),
(11, 1, 1, '20230405105025_5.jpg'),
(14, 2, 2, '20230405014628_holy-spirit-fire-dove-wind.jpg'),
(15, 1, 3, '20230405032443_11.jpg'),
(16, 1, 3, '20230405032443_12.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `quality` tinyint(4) NOT NULL COMMENT '0-шинэ, 1-хуучин',
  `address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) UNSIGNED NOT NULL,
  `youtube` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `userID` int(10) NOT NULL COMMENT 'user id',
  `category` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ex: c1_12 (category1, row id=12)',
  `item_viewer` int(10) UNSIGNED DEFAULT NULL,
  `phone_viewer` int(10) UNSIGNED DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `expire_days` int(10) NOT NULL,
  `isactive` tinyint(4) NOT NULL COMMENT '0-inactive, 1-review, 2-archive, 3-dismiss, 4-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `isactive`) VALUES
(1, 'Dell optiplex 3020 дан процессор', 0, 'Баянгол', '380000.00', 'https://www.youtube.com/embed/bRl5N_M9AvA', '20230405034449_20230329_104447.mp4', 'Dell Optiplex 3020 асуудалгүй шинэ процессор.\r\n4-р үеийн i3 @ 3.40GHz\r\nHDD: 500GB\r\nRam:8GB\r\nГар, mouse', 'Улаанбаатар', 'Todbayar', '+97695905811', 'atodko0513@gmail.com', 1, 'c3_3', 0, 0, '2023-04-05 03:44:54', 7, 1),
(2, 'Dell optiplex 3020 дан процессор', 1, 'Сонгино хайрхан', '1200000.00', '', '', 'Ok', 'Улаанбаатар', 'Tod', '+97699114547', '', 2, 'c3_3', 0, 0, '2023-04-05 03:43:14', 7, 1),
(3, 'Hp', 1, 'narnii horoolol', '1800000.00', '', '', 'i5-7r uy\r\n\r\n16gb ram\r\n\r\n256gb sdd hard + 500gb hard\r\n\r\ngtx1050', 'Улаанбаатар', '', '+97689000025', '', 1, 'c3_3', 0, 0, '2023-04-05 03:25:29', 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `topup` decimal(10,2) UNSIGNED DEFAULT NULL,
  `role` int(1) DEFAULT NULL COMMENT 'user role as admin=3, manager=2 and publisher=1 or user=0',
  `status` int(1) DEFAULT NULL COMMENT 'inactive=0, active=1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uid`, `name`, `email`, `phone`, `city`, `topup`, `role`, `status`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Todbayar', 'atodko0513@gmail.com', '+97699213557', 'Улаанбаатар', NULL, 3, 1),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', 'Tod', '', '+97699114547', 'Улаанбаатар', NULL, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
