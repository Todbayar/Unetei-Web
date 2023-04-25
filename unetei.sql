-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2023 at 01:20 PM
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
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `words` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-brand',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `userID`, `title`, `words`, `icon`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Хувцас хэрэглэл', 'Размер', '20230421033657_coathanger.png', 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category2`
--

DROP TABLE IF EXISTS `category2`;
CREATE TABLE IF NOT EXISTS `category2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `words` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-private',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category3`
--

DROP TABLE IF EXISTS `category3`;
CREATE TABLE IF NOT EXISTS `category3` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `words` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-private',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category4`
--

DROP TABLE IF EXISTS `category4`;
CREATE TABLE IF NOT EXISTS `category4` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `words` text COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-private',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fromID` int(10) UNSIGNED NOT NULL COMMENT 'from user id',
  `toID` int(10) UNSIGNED NOT NULL COMMENT 'to user id',
  `type` tinyint(4) UNSIGNED NOT NULL COMMENT '0-text, 1-category, 2-item',
  `message` text NOT NULL,
  `isRead` tinyint(1) NOT NULL COMMENT '0-unread, 1-read',
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `fromID`, `toID`, `type`, `message`, `isRead`, `datetime`) VALUES
(1, 1, 0, 0, 'hello world', 0, '2023-04-24 13:44:52'),
(2, 1, 0, 0, 'asd&lt;a href=&quot;google.com&quot;&gt;google&lt;/a&gt;', 0, '2023-04-21 15:33:07'),
(3, 1, 0, 1, 'c1_1', 0, '2023-04-21 15:36:57'),
(4, 1, 0, 2, '1', 0, '2023-04-21 15:48:22'),
(6, 1, 0, 0, 'ok', 0, '2023-04-24 13:44:55'),
(7, 1, 0, 0, 'done', 0, '2023-04-24 13:44:57');

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `userID`, `item`, `image`) VALUES
(1, 1, 1, '20230421033800_20.jpg'),
(2, 1, 1, '20230421033800_21.jpg'),
(3, 1, 1, '20230421033800_22.jpg'),
(4, 1, 2, '20230421033942_3.png'),
(5, 1, 2, '20230421033942_13.jpg'),
(6, 1, 2, '20230421033942_15.jpg'),
(7, 1, 2, '20230421033942_17.jpg');

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
  `price` decimal(22,2) UNSIGNED NOT NULL,
  `youtube` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `extras` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `extras`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `isactive`) VALUES
(1, 'Dell optiplex 3020 процессор', 0, '', '87.00', '', '', '[{&quot;Размер&quot;:&quot;37.5&quot;}]', 'asd', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c1_1', 0, 0, '2023-04-21 03:38:18', 14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `affiliate` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `bank_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bank_owner` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `bank_account` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `socialpay` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `topup` decimal(10,2) UNSIGNED DEFAULT NULL,
  `role` int(1) DEFAULT NULL COMMENT 'user role as superadmin=4, admin=3, manager=2 and publisher=1 or user=0',
  `status` int(1) DEFAULT NULL COMMENT 'inactive=0, active=1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uid`, `name`, `image`, `email`, `phone`, `city`, `affiliate`, `bank_name`, `bank_owner`, `bank_account`, `socialpay`, `topup`, `role`, `status`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Todbayar', '20230419060433_MyPic.jpg', 'atodko0513@gmail.com', '+97699213557', 'Улаанбаатар', '+97699114547', 'ХААН банк', 'Тодбаяр', '5020922323', '20230425090025_Socialpay.jpg', NULL, 4, 1),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', 'Tod', '', '', '+97699114547', 'Улаанбаатар', '0', '', '', '0', '', NULL, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
