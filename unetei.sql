-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 29, 2023 at 03:16 AM
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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `userID`, `title`, `words`, `icon`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Хувцас хэрэглэл', '', NULL, 0, 0, 2),
(2, 1, 'Авто машин', '', NULL, 0, 0, 2),
(18, 2, 'hello', '', NULL, 0, 0, 2),
(27, 1, 'Үл хөдлөх', 'Тагт', '20230508105955_realestate.png', 0, 0, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category2`
--

INSERT INTO `category2` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 2, 'Эмэгтэй хувцас', '', NULL, 1, 0, 0, 2),
(2, 1, 'Амины орон сууц', 'Тагт', NULL, 27, 0, 0, 2);

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
(1, 2, 'Гадуур хувцас', '', NULL, 1, 0, 0, 2);

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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `fromID`, `toID`, `type`, `message`, `isRead`, `datetime`) VALUES
(1, 1, 2, 1, 'c1_1', 1, '2023-05-03 13:34:23'),
(2, 2, 1, 3, 'Tod (#2, +97699114547) хэрэглэгч Админ, 300,000 ₮ болох хүсэлт илгээлээ.', 1, '2023-05-03 13:35:57'),
(3, 1, 2, 2, '1', 0, '2023-05-03 13:40:24'),
(4, 1, 0, 2, '1', 1, '2023-05-03 13:43:24'),
(5, 2, 1, 3, 'Tod (#2, +97699114547) хэрэглэгч Менежер, 100,000 ₮ болох хүсэлт илгээлээ.', 1, '2023-05-03 14:05:53'),
(6, 1, 1, 1, 'c1_2', 0, '2023-05-05 09:46:10'),
(7, 1, 2, 2, '3', 0, '2023-05-05 10:04:25'),
(8, 1, 1, 2, '1', 0, '2023-05-16 20:17:49'),
(9, 1, 1, 2, '2', 0, '2023-05-16 22:34:02'),
(25, 2, 1, 1, 'c1_18', 0, '2023-05-05 13:29:15'),
(42, 2, 1, 3, 'Tod (#2, +97699114547) хэрэглэгч Сүпер админ, 1,000,000 ₮ болох хүсэлт илгээлээ.', 1, '2023-05-25 10:27:36'),
(41, 2, 1, 2, '6', 0, '2023-05-19 14:56:13'),
(40, 2, 1, 2, '5', 0, '2023-05-18 16:11:33'),
(39, 1, 1, 2, '3', 0, '2023-05-16 22:30:50'),
(38, 1, 1, 2, '4', 0, '2023-05-16 22:32:53'),
(37, 1, 1, 1, 'c2_2', 0, '2023-05-08 11:01:02'),
(36, 1, 1, 1, 'c1_27', 0, '2023-05-08 10:59:55'),
(34, 2, 1, 1, 'c2_1', 0, '2023-05-06 12:04:36'),
(35, 2, 1, 1, 'c3_1', 0, '2023-05-06 12:04:48'),
(43, 2, 1, 2, '7', 0, '2023-05-25 10:42:56'),
(44, 2, 1, 2, '8', 0, '2023-05-25 10:50:27'),
(45, 2, 1, 2, '9', 0, '2023-05-25 11:05:18'),
(46, 2, 1, 2, '10', 0, '2023-05-29 10:47:22'),
(47, 2, 1, 2, '11', 0, '2023-05-29 10:49:52'),
(48, 2, 1, 2, '12', 0, '2023-05-29 10:53:32'),
(49, 2, 1, 2, '13', 0, '2023-05-29 10:56:35'),
(50, 2, 1, 2, '14', 0, '2023-05-29 11:08:34');

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `userID`, `item`, `image`) VALUES
(1, 1, 1, '20230503014018_14.jpg'),
(2, 1, 1, '20230503014018_20.jpg'),
(3, 1, 1, '20230503014018_21.jpg'),
(4, 1, 4, '20230516085516_17.jpg'),
(5, 1, 4, '20230516085516_18.jpg'),
(6, 1, 4, '20230516085516_19.jpg'),
(7, 2, 5, '20230518041128_4.jpg'),
(8, 2, 5, '20230518041128_5.jpg'),
(9, 2, 5, '20230518041128_6.jpg'),
(10, 2, 10, '20230529104657_3.png'),
(11, 2, 10, '20230529104657_17.jpg'),
(12, 2, 10, '20230529104657_18.jpg'),
(13, 2, 11, '20230529104928_af9270a575c85e01c04e2c3ae2b0e253.jpg'),
(14, 2, 11, '20230529104928_b2b4578fc2111259ae2490cd92a17229.jpg'),
(15, 2, 11, '20230529104928_d7428f940430d77b81ad5d64d0ae603f.jpg'),
(16, 2, 12, '20230529105324_23.jpg'),
(17, 2, 12, '20230529105324_24.jpg'),
(18, 2, 13, '20230529105620_27.jpg'),
(19, 2, 13, '20230529105620_28.jpg'),
(20, 2, 14, '20230529110233_16.jpg'),
(21, 2, 14, '20230529110232_17.jpg');

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
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0-regular, 1-special, 2-vip',
  `isactive` tinyint(4) NOT NULL COMMENT '0-inactive, 1-review, 2-archive, 3-dismiss, 4-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `extras`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `status`, `isactive`) VALUES
(1, 'Dell optiplex', 0, 'Сансар', '12000000.00', 'https://www.youtube.com/embed/L9VyPaDvLPw', '20230516081724_Гарц хэлэлцүүлэг.mp4', '[]', 'asd', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c1_1', 1, 0, '2023-05-03 01:40:24', 14, 0, 4),
(2, 'asdasdasdasd', 0, 'asd', '125000000000000.00', '', '20230516090700_20230329_104447.mp4', '[]', 'asd', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c1_2', 0, 0, '2023-05-05 09:57:07', 14, 2, 4),
(3, 'rtty', 1, '', '4500.00', 'https://www.youtube.com/embed/7KDgxyWcd2s', '', '[]', 'asd', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c1_1', 0, 0, '2023-05-05 10:04:25', 14, 1, 4),
(4, 'erg', 0, 'sdf', '120000000000.00', '', '', '[{&quot;Тагт&quot;:&quot;sdf&quot;}]', 'sdf', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c2_2', 0, 0, '2023-05-08 11:02:29', 14, 2, 4),
(5, 'asdasdasdasdasd', 0, '', '987987.00', '', '', '[]', 'asdasd', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c3_1', 0, 0, '2023-05-18 04:11:33', 14, 0, 4),
(6, 'testdrive', 1, '', '123456.00', '', '', '[]', 'test test', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c3_1', 0, 0, '2023-05-19 02:56:13', 10, 2, 4),
(7, 'asd', 0, '', '987.00', '', '', '[]', 'asd', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c3_1', 0, 0, '2023-05-25 10:42:56', 10, 2, 4),
(8, '987sdf', 1, '', '2131564.00', '', '', '[]', 'oiu asdf', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c1_2', 0, 0, '2023-05-25 10:50:27', 10, 2, 4),
(9, 'asddasdasdasd', 0, '', '987.00', '', '', '[{&quot;Тагт&quot;:&quot;&quot;}]', 'asd', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c2_2', 0, 0, '2023-05-25 11:05:18', 10, 2, 4),
(10, 'Хан төгөл хотхонд 6 өрөө байр', 0, '', '120000000.00', '', '', '[{&quot;Тагт&quot;:&quot;1&quot;}]', 'goy', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c2_2', 0, 0, '2023-05-29 10:47:22', 10, 2, 4),
(11, 'Suzuki Бусад, 2016/2023', 1, '', '23000000.00', '', '', '[]', 'Suzuki - Ignis\r\n\r\n2016- онд үйлдвэрлэгдсэн.\r\n\r\n2023- онд импортлогдож дугаар авсан.\r\n\r\nӨнгө үзэмж, загвар сайтай. Жижиг харагддаг ч доторх зай нь боломжийн том. Nissan juke, Aqua зэргээс арай том зайтай бөгөөд, их тухтай, зөөлөн явдалтай.\r\n\r\nТүлшний зарцуулалт маш бага. Eco Hybrid мотортой.\r\n\r\nСмарт түлхүүртэй. Урд хоёр хаалга смарттай.\r\n\r\nУхрахын камер маш тод. Хөгжмийн дуугаралт маш гоё. Толин дээрх дохионы гэрэлтэй.\r\n\r\nСалоны материал болон хаалганы бариул дубэн оруулгатай, чамин загвартай.\r\n\r\nОбуд яг өөрийнх нь логотой оригинал сток.\r\n\r\nАвснаас хойш хүүхдийн зуу, нисэх хоёрын хооронд л унасан. Бага гүйлт гүйсэн.\r\n\r\nСэв зураас байхгүй, хийх юмгүй сайхан унаагаа арилжина.\r\n\r\nХэрэв та яг энэ машиныг орж ирснээр нь авбал Тос масло, суудлын бүрээс, шалавч, оношилгоо гэх мэт ойр зуурдаа 500 орчим мянган төгрөгийг дор хаяж зарлагадана. Мөн уг машинаас дор хаяж нэг саяар илүү үнэ төлнө. Харин уг машиныг авбал та дээр дурдсагдсан зарлагыг хэмнэх нь...\r\n\r\nЗургууд дээр тодорхой харагдах байх. Акуатай харьцуулсан зураг дээрээс уг машины багтаамж, зай, тэнхлэгийн өндөр зэрэг тодорхой харагдах байх аа.\r\n\r\nИрж үзэхээр бол хотын төвд байгаа шүү. Яг сонирхсон хүнд нь багахан зэрэг яриа хөөрөө хийж болно.', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c1_2', 0, 0, '2023-05-29 10:49:52', 10, 2, 4),
(12, 'Benz 123', 1, '', '9874654.00', '', '', '[]', 'asd sads', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c1_2', 0, 0, '2023-05-29 10:53:32', 20, 1, 4),
(13, 'Toyota Tacoma, 2017/2019', 1, '', '13000000.00', '', '', '[]', 'tocama', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c1_2', 0, 0, '2023-05-29 10:56:35', 10, 2, 4),
(14, 'Хотын төвд ааа бүсэд 1', 0, '', '45000000000.00', '', '', '[{&quot;Тагт&quot;:&quot;2&quot;}]', 'asd', 'Баян-Өлгий', 'Tod', '+97699114547', 'asd@asd.com', 2, 'c2_2', 0, 0, '2023-05-25 11:02:50', 20, 1, 4);

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
(1, 'P6jlLGWoZPanlSkWbxQL2FVY0PS2', 'Todbayar', '20230419060433_MyPic.jpg', 'atodko0513@gmail.com', '+97699213557', 'Улаанбаатар', '', 'ХААН банк', 'Тодбаяр', '5020922323', '20230425090025_Socialpay.jpg', NULL, 4, 1),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', 'Tod', '', 'asd@asd.com', '+97699114547', 'Баян-Өлгий', '+97699213557', '', '', '', '', NULL, 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
