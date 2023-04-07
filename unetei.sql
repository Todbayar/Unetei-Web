-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 07, 2023 at 02:06 PM
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
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `userID`, `title`, `words`, `icon`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Компьютер сэлбэг хэрэгсэл', '', '20230404012333_Media-Design-Hydropro-V2-My-Computer.512.png', 0, 0, 0),
(2, 1, 'Үл хөдлөх', '', '20230406120300_realestate.png', 0, 0, 0),
(3, 1, 'Автомашин', '', '20230406084155_car2.png', 0, 0, 0),
(4, 1, 'Хувцас хэрэглэл', '', '20230407023148_coathanger.png', 0, 0, 2),
(5, 1, 'Утас, дугаар', 'Утас шалгасан дүн,IMEI,Баталгаа,Product name', '20230407073329_Designcontest-Ecommerce-Business-Iphone.256.png', 0, 0, 1),
(7, 2, 'Цахилгаан бараа', '', '20230407094224_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png', 0, 0, 0);

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
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category2`
--

INSERT INTO `category2` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Notebook', '', NULL, 1, 0, 0, 0),
(2, 1, 'Үл хөдлөх зарна', '', NULL, 2, 0, 0, 0),
(3, 1, 'Автомашин зарна', '', NULL, 3, 0, 0, 0),
(4, 1, 'Эмэгтэй хувцас', '', NULL, 4, 0, 0, 0),
(5, 1, 'Эрэгтэй хувцас', 'Размер', NULL, 4, 0, 0, 0);

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
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category3`
--

INSERT INTO `category3` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(3, 1, 'HP', '', NULL, 1, 0, 0, 0),
(4, 1, 'АОС, хаус, зуслан зарна', '', NULL, 2, 0, 0, 0),
(5, 1, 'Mercedes-Benz', '', NULL, 3, 0, 0, 0),
(6, 1, 'Toyota', '', NULL, 3, 0, 0, 0),
(8, 1, 'Гадуур хувцас', 'Размер', NULL, 4, 0, 0, 0);

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
  `status` int(1) NOT NULL DEFAULT '0',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category4`
--

INSERT INTO `category4` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'S-Class', '', NULL, 5, 0, 0, 0),
(2, 2, 'Prius 30', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хаяг байршил,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 6, 0, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `userID`, `item`, `image`) VALUES
(12, 1, 1, '20230405105025_6.jpg'),
(11, 1, 1, '20230405105025_5.jpg'),
(17, 1, 6, '20230406120417_13.jpg'),
(14, 2, 2, '20230405014628_holy-spirit-fire-dove-wind.jpg'),
(15, 1, 3, '20230405032443_11.jpg'),
(16, 1, 3, '20230405032443_12.jpg'),
(18, 1, 6, '20230406120417_14.jpg'),
(19, 1, 6, '20230406120417_15.jpg'),
(20, 1, 7, '20230406121919_16.jpg'),
(21, 1, 7, '20230406121919_17.jpg'),
(22, 1, 7, '20230406121919_18.jpg'),
(23, 1, 8, '20230406122724_19.jpg'),
(30, 1, 12, '20230406084345_24.jpg'),
(25, 1, 9, '20230406123911_21.jpg'),
(29, 1, 12, '20230406084345_23.jpg'),
(27, 2, 10, '20230406124141_20230404_095433.jpg'),
(28, 2, 10, '20230406124141_20230404_095431.jpg'),
(31, 1, 12, '20230406084345_25.jpg'),
(32, 1, 13, '20230406085853_27.jpg'),
(33, 1, 13, '20230406085853_28.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `isactive`) VALUES
(1, 'Dell optiplex 3020 дан процессор', 0, 'Баянгол', '380000.00', 'https://www.youtube.com/embed/bRl5N_M9AvA', '20230405034449_20230329_104447.mp4', 'Dell Optiplex 3020 асуудалгүй шинэ процессор.\r\n4-р үеийн i3 @ 3.40GHz\r\nHDD: 500GB\r\nRam:8GB\r\nГар, mouse', 'Улаанбаатар', 'Todbayar', '+97695905811', 'atodko0513@gmail.com', 1, 'c3_3', 0, 0, '2023-04-06 09:09:25', 7, 2),
(2, 'Dell optiplex 3020 дан процессор', 1, 'Сонгино хайрхан', '1200000.00', '', '', 'Ok', 'Улаанбаатар', 'Tod', '+97699114547', '', 2, 'c3_3', 0, 0, '2023-04-05 04:01:18', 7, 1),
(3, 'Hp 1', 1, 'narnii horoolol', '1800000.00', '', '20230405034449_20230329_104447.mp4', 'i5-7r uy\r\n\r\n16gb ram\r\n\r\n256gb sdd hard + 500gb hard\r\n\r\ngtx1050', 'Улаанбаатар', 'vi', '+97689000025', '', 1, 'c3_3', 0, 0, '2023-04-06 01:14:31', 7, 1),
(6, 'Худ хотын төвтэй ойр хаус', 0, 'ХУД Чандманийн ам', '1500000000.00', '', '', 'ХУД Чандманийн аманд байрлах Хийморь хотхонд хамгийн гоё байршилд тансаг зэрэглэлийн засалтай хаус худалдана. Жилийн 4 улиралд цэвэр агаарт, хотын төвтэй ойр байршилд ая тухтай амьдрах бүх нөхцөл бүрэлдсэн, энерги сайтай сайхан газар байрлах хаусыг худалдана', 'Улаанбаатар', 'nice work', '+97699079840', '', 1, 'c3_4', 0, 0, '2023-04-06 01:05:51', 7, 1),
(7, 'Зочид буудал', 0, ' 3, 4 хороолол', '3500000000.00', '', '', '- Эх нялхасын эмнэлэгийн баруун хойно төв зам дагуу байрлалтай 5 давхар ЗОЧИД\r\n\r\n-Үнэ 3.5 тэрбум\r\n\r\n-Нийт 1212мкв 5 давхар\r\n\r\n-Зочид буудлын 15 өрөө (20саяаар түрээслүүлдэг)\r\n\r\n-Оффисын 4 өрөө\r\n\r\n-Караоке 2 өрөө\r\n\r\n-Ресторан\r\n\r\n-6 давхарт өргөтгөл хийх боломжтой', 'Улаанбаатар', 'vi', '+97691662277', '', 1, 'c3_4', 0, 0, '2023-04-06 01:06:07', 7, 2),
(8, 'Хотын төвд A бүсэд', 0, 'Сүхбаатар', '133000000000.00', '', '20230405034449_20230329_104447.mp4', 'Хотын төвд төсөл худалдана', 'Улаанбаатар', '', '+97695008655', '', 1, 'c3_4', 0, 0, '2023-04-06 01:16:41', 7, 1),
(9, 'Гоо сайханы салон', 0, 'Баянбүрд', '230000000.00', '', '', 'Гоо сайханы салоноор тохижуулсан хэвийн үйл ажиллагаа явуулж байгаа /гоо сайхан, вакс, сормуус, маникюр, педикюр/ бэлэн бизнес дагалдах бүх тохижилтын хамт худалдана.\r\n\r\n- Үйлчилгээний зориулалттай 51,1мкв\r\n\r\n- 2012 онд ашиглалтанд орсон\r\n\r\n- Гадагшаа болон орц руу орох хаалгатай\r\n\r\n- Гаднаа зогсоол сайтай', 'Улаанбаатар', 'dsa', '+97699077021', '', 1, 'c3_4', 0, 0, '2023-04-06 01:14:49', 7, 1),
(10, 'Хотын төвд A бүсэд', 0, 'ХУД Чандманийн ам', '120000.00', '', '20230406124308_20230406_124241.mp4', 'Havvs', 'Улаанбаатар', 'vi', '+97699114547', '', 2, 'c3_3', 0, 0, '2023-04-06 12:49:19', 7, 1),
(11, 'олрйы д дйы', 0, '', '54.00', 'https://www.youtube.com/embed/yJLZvQqcpME', '', 'https://www.youtube.com/embed/yJLZvQqcpME', 'Улаанбаатар', 'asd ok asd as лорйыбд үө үү', '+97699213557', 'asd@gmail.com', 1, 'c3_4', 0, 0, '2023-04-06 08:33:31', 7, 1),
(12, 'Mercedes-Benz S-Class, 2016/2023', 1, '', '185000000.00', '', '', 'S500 Mongold 2023.03.07orj irsen S bh buh yum bgaa goyo ter gee zarna. Uniin dungiin tald mashin <b>oroltsuulna</b>', 'Улаанбаатар', 'Era', '+97691112725', '', 1, 'c4_1', 0, 0, '2023-04-06 08:46:42', 7, 1),
(13, 'Toyota Tacoma, 2017/2019', 1, '', '110000000.00', '', '', 'Зэвгүй. Бага гүйлттэй\r\nМотор багтаамж: 3.5 л\r\nХурдны хайрцаг: Автомат\r\nХүрд: Зөв\r\nТөрөл: Жийп\r\nӨнгө: Улаан\r\nҮйлдвэрлэсэн он: 2017\r\nОрж ирсэн он: 2019\r\nХөдөлгүүр: Бензин', 'Улаанбаатар', 'радиатор ланд ххк', '+97699119133', '', 1, 'c3_6', 0, 0, '2023-04-06 08:58:55', 7, 0),
(14, 'asd', 0, '', '54.00', '', '', 'asd', 'Улаанбаатар', 'asd', '+97699213557', '', 1, 'c1_5', 0, 0, '2023-04-07 09:18:16', 14, 1);

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
