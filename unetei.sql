-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 28, 2023 at 07:52 AM
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
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `clicked` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `uid`, `title`, `icon`, `status`, `clicked`, `active`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Хувцас хэрэглэл', '20230326104411_clotheshanger2.png', 0, 0, 0),
(2, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Үл хөдлөх', '20230326112450_realestate.png', 0, 0, 0),
(3, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Авто машин', '20230326112637_Bevel-And-Emboss-Car-Car-orange.256.png', 0, 0, 0),
(4, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Ажлын зар', '20230326112817_Double-J-Design-Diagram-Free-Suitcase.128.png', 0, 0, 0),
(5, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Хүүхдийн бараа', '20230326112936_kidcloth.png', 0, 0, 0),
(6, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Компьютер сэлбэг хэрэгсэл', '20230326113055_Icons-Land-Vista-Hardware-Devices-Portable-Computer.256.png', 0, 0, 0),
(7, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Утас, дугаар', '20230326113237_Designcontest-Ecommerce-Business-Iphone.256.png', 0, 0, 0),
(9, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Цахилгаан бараа', '20230326113639_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png', 0, 0, 0),
(10, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Гэр ахуйн бараа', '20230326114022_red-sofa-furniture-icon-png-4.png', 0, 0, 0),
(11, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Төхөөрөмж, материал, түлш', '20230326114208_Treetog-Junior-Tool-box.256.png', 0, 0, 0),
(12, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Амралт, спорт, хобби', '20230326114317_Kevin-Andersson-Sportset-Basketball.128.png', 0, 0, 0),
(13, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Эрүүл мэнд, гоо сайхан, хүнс', '20230326114649_4773193.png', 0, 0, 0),
(14, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Мал амьтан, ургамал', '20230326115021_Google-Noto-Emoji-Animals-Nature-22215-dog.512.png', 0, 0, 0),
(15, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Үйлчилгээ', '20230326120006_6568544.png', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category2`
--

DROP TABLE IF EXISTS `category2`;
CREATE TABLE IF NOT EXISTS `category2` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `clicked` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category2`
--

INSERT INTO `category2` (`id`, `uid`, `title`, `icon`, `parent`, `status`, `clicked`, `active`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Эмэгтэй хувцас', NULL, 1, 0, 0, 0),
(2, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Эрэгтэй хувцас', NULL, 1, 0, 0, 0),
(3, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Гутал, пүүз', NULL, 1, 0, 0, 0),
(4, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Малгай, цүнх', NULL, 1, 0, 0, 0),
(5, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Гоёл чимэглэл, бугуйн цаг', NULL, 1, 0, 0, 0),
(6, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Ажлын хувцас', NULL, 1, 0, 0, 0),
(7, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Бусад', NULL, 1, 0, 0, 0),
(8, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Суурин компьютер', '20230326120144_Media-Design-Hydropro-V2-My-Computer.512.png', 6, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category3`
--

DROP TABLE IF EXISTS `category3`;
CREATE TABLE IF NOT EXISTS `category3` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `clicked` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category3`
--

INSERT INTO `category3` (`id`, `uid`, `title`, `icon`, `parent`, `status`, `clicked`, `active`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Гадуур хувцас', NULL, 2, 0, 0, 0),
(2, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Гэрийн өмсгөл', NULL, 2, 0, 0, 0),
(3, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Дотуур хувцас', NULL, 2, 0, 0, 0),
(4, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Дээл', NULL, 2, 0, 0, 0),
(5, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Костюм, зангиа', NULL, 2, 0, 0, 0),
(6, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Өмд', NULL, 2, 0, 0, 0),
(7, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Спорт өмсгөл', NULL, 2, 0, 0, 0),
(8, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Цамц', NULL, 2, 0, 0, 0),
(9, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Футболк', NULL, 2, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `category4`
--

DROP TABLE IF EXISTS `category4`;
CREATE TABLE IF NOT EXISTS `category4` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent` int(10) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `clicked` int(10) NOT NULL DEFAULT '0',
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
  `user` int(10) UNSIGNED NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `images` int(10) UNSIGNED NOT NULL,
  `youtube` varchar(2048) COLLATE utf8_unicode_ci NOT NULL,
  `video` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user` int(10) UNSIGNED NOT NULL,
  `isactive` tinyint(4) NOT NULL COMMENT '0-inactive,1-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', NULL, NULL, '+97699213557', NULL, NULL, 0, 1),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', NULL, NULL, '+97699114547', NULL, NULL, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
