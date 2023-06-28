-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 28, 2023 at 08:14 AM
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
(1, 1, 'Хувцас хэрэглэл', 'Размер', '20230628014017_clotheshanger2.png', 0, 0, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category2`
--

INSERT INTO `category2` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Эмэгтэй хувцас', 'Размер', NULL, 1, 0, 0, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category3`
--

INSERT INTO `category3` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Өмд', 'Размер', NULL, 1, 0, 0, 2);

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
  `type` tinyint(4) UNSIGNED NOT NULL COMMENT '0-text, 1-category, 2-item, 3-role',
  `message` text NOT NULL,
  `isRead` tinyint(1) NOT NULL COMMENT '0-unread, 1-read',
  `datetime` datetime NOT NULL,
  `note` text COMMENT 'isPaid',
  `action` tinyint(4) DEFAULT NULL COMMENT 'add-0, edit-1, update-2',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `fromID`, `toID`, `type`, `message`, `isRead`, `datetime`, `note`, `action`) VALUES
(1, 1, 2, 0, 'Сайн байна уу?', 1, '2023-06-28 13:57:22', NULL, NULL),
(2, 2, 1, 0, 'hello', 1, '2023-06-28 11:23:23', NULL, NULL),
(3, 1, 1, 1, 'c1_1', 1, '2023-06-28 13:40:17', NULL, NULL),
(4, 1, 1, 1, 'c2_1', 1, '2023-06-28 13:41:56', NULL, NULL),
(5, 1, 1, 1, 'c3_1', 1, '2023-06-28 13:42:30', NULL, NULL),
(6, 1, 1, 2, '1', 1, '2023-06-28 13:46:10', '{\"payment\":[{\"datetime\":\"2023-06-28 01:46:55\",\"isPaid\":true}]}', NULL),
(7, 3, 1, 2, '2', 1, '2023-06-28 14:58:38', '{\"payment\":[{\"datetime\":\"2023-06-28 03:10:54\",\"isPaid\":true}]}', NULL),
(8, 1, 3, 0, 'Сайн байна уу?', 1, '2023-06-28 15:11:03', NULL, NULL),
(9, 0, 3, 0, '&lt;b&gt;Jeans&lt;/b&gt;&lt;br/&gt;20,000 ₮&lt;br/&gt;#3&lt;br/&gt;Хувцас хэрэглэл &gt; Эмэгтэй хувцас &gt; Өмд', 0, '2023-06-28 15:54:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

DROP TABLE IF EXISTS `favorite`;
CREATE TABLE IF NOT EXISTS `favorite` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `itemID` int(10) UNSIGNED NOT NULL,
  `userID` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `userID`, `item`, `image`) VALUES
(1, 1, 1, '20230628014437_817b26b597e1ebde40c2fe52e58872da.jpg'),
(2, 1, 1, '20230628014437_3218f8da256d1e3a3d0400025f5f98d8.jpg'),
(3, 1, 1, '20230628014437_dec951ed22602c04461ddbc3925cfd0f.jpg'),
(4, 3, 2, '20230628025741_ddaabdc0570543e89719d9327a0d9467.jpg'),
(5, 3, 2, '20230628025741_f8629ecdb308f2038e4d2a07061703d5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
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
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-regular, 1-special, 2-vip',
  `isactive` tinyint(4) NOT NULL COMMENT '0-inactive, 1-review, 2-archive, 3-dismiss, 4-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `extras`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `status`, `isactive`) VALUES
(1, 'Өмд', 1, 'Халдвартын эцэс', '45000.00', '', '', '[{&quot;Размер&quot;:&quot;M&quot;}]', 'Японоос авч байсан цэвэрхэн өмссөн элэгдэл байхгүй даавуун брэндийн өмд зарна.', 'Улаанбаатар', 'Zulaa', '+97688083555', '', 1, 'c3_1', 20, 1, '2023-06-28 01:46:10', 30, 0, 4),
(2, 'Jeans', 1, 'sansar', '20000.00', '', '', '[{&quot;Размер&quot;:&quot;XS&quot;}]', 'sec', 'Улаанбаатар', 'Muugii', '+97699031094', '', 3, 'c3_1', 37, 2, '2023-06-28 02:58:38', 30, 0, 4);

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
  `token` varchar(200) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Firebase Cloud Messaging Token (fcm)',
  `datetime` datetime DEFAULT NULL,
  `lastlogged` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uid`, `name`, `image`, `email`, `phone`, `city`, `affiliate`, `bank_name`, `bank_owner`, `bank_account`, `socialpay`, `topup`, `role`, `status`, `token`, `datetime`, `lastlogged`) VALUES
(1, 'P6jlLGWoZPanlSkWbxQL2FVY0PS2', 'Zulaa', '20230419060433_MyPic.jpg', '', '+97699213557', 'Улаанбаатар', '', 'ХААН банк', 'Тодбаяр', '5020922323', '20230628111628_Todbayar SocialPay QR 1.jpg', NULL, 3, 1, '', NULL, NULL),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', 'Ууганбат', '20230529112346_11.jpg', 'asd@asdgmail.com', '+97699114547', 'Улаанбаатар', '+97699213557', '', '', '', '', NULL, 2, 1, 'f1pHQHFmw-AWscDUcoaZ1C:APA91bH5I5t6iXli1o5XAdAIfH27ZP61h7x7G3Bm1fMlwJx9t_b5e9wq9M0wY6LXEGt0Z6H8xvI6qGirJ9u34OKzUhjjaQtzBDHg7hb2uN0RLcHmVJqzDqOW5Kw3FXVFPUIDvKqakCtN', NULL, NULL),
(3, 'gsW7jtHFaGOAAFYBIxpmIrEvDdl1', 'Muugii', '', '', '+97699031094', 'Улаанбаатар', '+97699213557', '', '', '', '', NULL, 0, 1, '', '2023-06-28 00:00:00', '2023-06-28 01:46:10');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
