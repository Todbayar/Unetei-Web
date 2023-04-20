-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2023 at 03:39 AM
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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-private',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category1`
--

INSERT INTO `category1` (`id`, `userID`, `title`, `words`, `icon`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'Компьютер сэлбэг хэрэгсэл', '', '20230404012333_Media-Design-Hydropro-V2-My-Computer.512.png', 0, 0, 0),
(2, 1, 'Үл хөдлөх', '', '20230406120300_realestate.png', 0, 0, 0),
(3, 1, 'Автомашин', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга', '20230406084155_car2.png', 0, 0, 0),
(4, 1, 'Хувцас хэрэглэл', '', '20230407023148_coathanger.png', 0, 0, 2),
(5, 1, 'Утас, дугаар', 'Утас шалгасан дүн,IMEI,Баталгаа,Product name', '20230407073329_Designcontest-Ecommerce-Business-Iphone.256.png', 0, 0, 1),
(7, 2, 'Цахилгаан бараа', '', '20230407094224_Julie-Henriksen-Kitchen-Rotating-Stand-Mixer.512.png', 0, 0, 0),
(10, 1, 'Ажлын зар', 'Зарлагч,Туршлага,Ажлын цаг,Мэргэжлийн түвшин', '20230420105027_Double-J-Design-Diagram-Free-Suitcase.128.png', 0, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-public,1-private',
  `category_viewer` int(10) NOT NULL DEFAULT '0',
  `active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-review, 1-dismiss, 2-active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category3`
--

INSERT INTO `category3` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(3, 1, 'HP', '', NULL, 1, 0, 0, 0),
(4, 1, 'АОС, хаус, зуслан зарна', '', NULL, 2, 0, 0, 0),
(5, 1, 'Mercedes-Benz', '', NULL, 3, 0, 0, 0),
(6, 1, 'Toyota', '', NULL, 3, 0, 0, 0),
(8, 1, 'Гадуур хувцас', 'Размер', NULL, 4, 0, 0, 0),
(9, 1, 'Nissan', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хаяг байршил,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 3, 0, 0, 0),
(10, 1, 'Lexus', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга,Хаяг байршил', NULL, 3, 0, 0, 0),
(11, 1, 'Ford', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга,Хаяг байршил', NULL, 3, 0, 0, 0);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category4`
--

INSERT INTO `category4` (`id`, `userID`, `title`, `words`, `icon`, `parent`, `status`, `category_viewer`, `active`) VALUES
(1, 1, 'S-Class', '', NULL, 5, 0, 0, 0),
(2, 2, 'Prius 30', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хаяг байршил,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 6, 0, 0, 0),
(3, 1, 'test', '', NULL, 3, 0, 0, 0),
(4, 1, 'X-Trail', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 9, 0, 0, 0),
(5, 1, 'C-Class', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 5, 0, 0, 0),
(6, 1, 'LX', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 10, 0, 0, 0),
(7, 1, 'Ranger', 'Мотор багтаамж,Хурдны хайрцаг,Хүрд,Төрөл,Өнгө,Үйлдвэрлэсэн он,Орж ирсэн он,Хөдөлгүүр,Дотор өнгө,Лизинг,Хөтлөгч,Явсан,Нөхцөл,Хаалга', NULL, 11, 0, 0, 0);

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
(1, 1, 0, 2, '33', 0, '2023-04-19 16:41:55'),
(2, 1, 0, 2, '34', 0, '2023-04-19 17:08:31'),
(3, 1, 0, 2, '34', 0, '2023-04-19 17:08:58'),
(4, 1, 0, 2, '34', 0, '2023-04-19 17:09:19'),
(5, 1, 0, 2, '35', 0, '2023-04-19 17:10:14'),
(6, 1, 0, 2, '36', 0, '2023-04-19 17:11:25'),
(7, 1, 0, 1, 'c1_10', 0, '2023-04-20 10:50:27');

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
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(33, 1, 13, '20230406085853_28.jpg'),
(49, 1, 16, '20230413101451_16.jpg'),
(50, 1, 32, '20230413101707_27.jpg'),
(47, 1, 16, '20230413101451_14.jpg'),
(46, 1, 16, '20230413101451_0f1955188b307a6ee14e8c5227a240cb.jpg'),
(48, 1, 16, '20230413101451_15.jpg'),
(42, 1, 27, '20230411054856_23.jpg'),
(43, 1, 27, '20230411054856_24.jpg'),
(44, 1, 28, '20230411071822_25.jpg'),
(45, 1, 28, '20230411071822_26.jpg'),
(51, 1, 32, '20230413101707_28.jpg'),
(52, 1, 32, '20230413101707_29.jpg'),
(53, 1, 34, '20230419050828_17.jpg'),
(54, 1, 34, '20230419050828_18.jpg'),
(55, 1, 34, '20230419050828_19.jpg'),
(56, 1, 35, '20230419051006_28.jpg'),
(57, 1, 35, '20230419051006_29.jpg'),
(58, 1, 36, '20230419051116_29477ecd52ceebb842e99a41d3692ee2.jpg'),
(59, 1, 36, '20230419051116_948303f4bd4656cfcdda628491c95dae.jpg');

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
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id`, `title`, `quality`, `address`, `price`, `youtube`, `video`, `extras`, `description`, `city`, `name`, `phone`, `email`, `userID`, `category`, `item_viewer`, `phone_viewer`, `datetime`, `expire_days`, `isactive`) VALUES
(1, 'Dell optiplex 3020 дан процессор', 0, 'Баянгол', '380000.00', 'https://www.youtube.com/embed/bRl5N_M9AvA', '20230405034449_20230329_104447.mp4', '', 'Dell Optiplex 3020 асуудалгүй шинэ процессор.\r\n4-р үеийн i3 @ 3.40GHz\r\nHDD: 500GB\r\nRam:8GB\r\nГар, mouse', 'Улаанбаатар', 'Todbayar', '+97695905811', 'atodko0513@gmail.com', 1, 'c3_3', 0, 0, '2023-04-06 09:09:25', 7, 2),
(2, 'Dell optiplex 3020 дан процессор', 1, 'Сонгино хайрхан', '1200000.00', '', '', '', 'Ok', 'Улаанбаатар', 'Tod', '+97699114547', '', 2, 'c3_3', 0, 0, '2023-04-05 04:01:18', 7, 1),
(3, 'Hp 1', 1, 'narnii horoolol', '1800000.00', '', '20230405034449_20230329_104447.mp4', '', 'i5-7r uy\r\n\r\n16gb ram\r\n\r\n256gb sdd hard + 500gb hard\r\n\r\ngtx1050', 'Улаанбаатар', 'vi', '+97689000025', '', 1, 'c3_3', 0, 0, '2023-04-06 01:14:31', 7, 1),
(6, 'Худ хотын төвтэй ойр хаус', 0, 'ХУД Чандманийн ам', '1500000000.00', '', '', '', 'ХУД Чандманийн аманд байрлах Хийморь хотхонд хамгийн гоё байршилд тансаг зэрэглэлийн засалтай хаус худалдана. Жилийн 4 улиралд цэвэр агаарт, хотын төвтэй ойр байршилд ая тухтай амьдрах бүх нөхцөл бүрэлдсэн, энерги сайтай сайхан газар байрлах хаусыг худалдана', 'Улаанбаатар', 'nice work', '+97699079840', '', 1, 'c3_4', 0, 0, '2023-04-06 01:05:51', 7, 1),
(7, 'Зочид буудал', 0, ' 3, 4 хороолол', '3500000000.00', '', '', '', '- Эх нялхасын эмнэлэгийн баруун хойно төв зам дагуу байрлалтай 5 давхар ЗОЧИД\r\n\r\n-Үнэ 3.5 тэрбум\r\n\r\n-Нийт 1212мкв 5 давхар\r\n\r\n-Зочид буудлын 15 өрөө (20саяаар түрээслүүлдэг)\r\n\r\n-Оффисын 4 өрөө\r\n\r\n-Караоке 2 өрөө\r\n\r\n-Ресторан\r\n\r\n-6 давхарт өргөтгөл хийх боломжтой', 'Улаанбаатар', 'vi', '+97691662277', '', 1, 'c3_4', 0, 0, '2023-04-06 01:06:07', 7, 2),
(8, 'Хотын төвд A бүсэд', 0, 'Сүхбаатар', '133000000000.00', '', '20230405034449_20230329_104447.mp4', '', 'Хотын төвд төсөл худалдана', 'Улаанбаатар', '', '+97695008655', '', 1, 'c3_4', 0, 0, '2023-04-06 01:16:41', 7, 1),
(9, 'Гоо сайханы салон', 0, 'Баянбүрд', '230000000.00', '', '', '', 'Гоо сайханы салоноор тохижуулсан хэвийн үйл ажиллагаа явуулж байгаа /гоо сайхан, вакс, сормуус, маникюр, педикюр/ бэлэн бизнес дагалдах бүх тохижилтын хамт худалдана.\r\n\r\n- Үйлчилгээний зориулалттай 51,1мкв\r\n\r\n- 2012 онд ашиглалтанд орсон\r\n\r\n- Гадагшаа болон орц руу орох хаалгатай\r\n\r\n- Гаднаа зогсоол сайтай', 'Улаанбаатар', 'dsa', '+97699077021', '', 1, 'c3_4', 0, 0, '2023-04-06 01:14:49', 7, 1),
(10, 'Хотын төвд A бүсэд', 0, 'ХУД Чандманийн ам', '120000.00', '', '20230406124308_20230406_124241.mp4', '', 'Havvs', 'Улаанбаатар', 'vi', '+97699114547', '', 2, 'c3_3', 0, 0, '2023-04-06 12:49:19', 7, 1),
(11, 'олрйы д дйы', 0, '', '54.00', 'https://www.youtube.com/embed/yJLZvQqcpME', '', '', 'https://www.youtube.com/embed/yJLZvQqcpME', 'Улаанбаатар', 'asd ok asd as лорйыбд үө үү', '+97699213557', 'asd@gmail.com', 1, 'c3_4', 0, 0, '2023-04-06 08:33:31', 7, 1),
(12, 'Mercedes-Benz S-Class, 2016/2023', 1, '', '185000000.00', '', '', '', 'S500 Mongold 2023.03.07orj irsen S bh buh yum bgaa goyo ter gee zarna. Uniin dungiin tald mashin <b>oroltsuulna</b>', 'Улаанбаатар', 'Era', '+97691112725', '', 1, 'c4_1', 0, 0, '2023-04-06 08:46:42', 7, 1),
(13, 'Toyota Tacoma, 2017/2019', 1, '', '110000000.00', '', '', '', 'Зэвгүй. Бага гүйлттэй\r\nМотор багтаамж: 3.5 л\r\nХурдны хайрцаг: Автомат\r\nХүрд: Зөв\r\nТөрөл: Жийп\r\nӨнгө: Улаан\r\nҮйлдвэрлэсэн он: 2017\r\nОрж ирсэн он: 2019\r\nХөдөлгүүр: Бензин', 'Улаанбаатар', 'радиатор ланд ххк', '+97699119133', '', 1, 'c3_6', 0, 0, '2023-04-06 08:58:55', 7, 0),
(14, 'asd', 0, '', '54.00', '', '', '', 'asd', 'Улаанбаатар', 'asd', '+97699213557', '', 1, 'c1_5', 0, 0, '2023-04-07 09:18:16', 14, 1),
(15, 'asd', 0, '', '54.00', '', '', '', 'asd', 'Дархан-Уул', 'asd', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 11:36:26', 14, 1),
(16, 'Nissan X-Trail, 2004/2014', 1, ' Улаанбаатар Нисэхийн спорт орны хажууд', '12000000.00', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;3.2 л&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;Механик&quot;},{&quot;Хүрд&quot;:&quot;&quot;},{&quot;Төрөл&quot;:&quot;&quot;},{&quot;Өнгө&quot;:&quot;&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;&quot;},{&quot;Орж ирсэн он&quot;:&quot;&quot;},{&quot;Хөдөлгүүр&quot;:&quot;&quot;},{&quot;Дотор өнгө&quot;:&quot;&quot;},{&quot;Лизинг&quot;:&quot;&quot;},{&quot;Хөтлөгч&quot;:&quot;&quot;},{&quot;Явсан&quot;:&quot;&quot;},{&quot;Нөхцөл&quot;:&quot;&quot;},{&quot;Хаалга&quot;:&quot;&quot;}]', 'Хийх юм байхгүй сайхан тэрэг байна. Хөдөө гадаа унаад явхад бэлэн.\r\n\r\n-Урд хоер суудал хална.-\r\n\r\n-Ухарахад толь бууна\r\n\r\n-Агаар цэвэршүүлэгчтэй-\r\n\r\n-Залгаж салгах мосттой-\r\n\r\n-Мотор хроп 3-н хэлхээ маш сайн\r\n\r\n-Бинзен зарцуулалт бага\r\n\r\nАвсан хүн алзахгүй сайхан тэрэг байна. Приус 20 оролцуулж зөрүүг тохирж болно', 'Улаанбаатар', 'Орших Сервис Төгс цэвэрлэнэ', '+97688109095', '', 1, 'c4_4', 0, 0, '2023-04-11 12:40:13', 14, 1),
(17, 'Nissan X-Trail, 2011/2021', 1, 'Сансар', '25000000.00', '', '', '', '', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 01:19:26', 14, 1),
(18, 'Nissan X-Trail, 2011/2021', 1, 'Сансар', '25000000.00', '', '', '', '', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 01:19:26', 14, 1),
(19, 'Nissan X-Trail, 2011/2022', 1, 'Сансар', '25000000.00', '', '', '', '[{\"Мотор багтаамж\":\"2.0 л\"},{\"Хурдны хайрцаг\":\" Автомат\"},{\"Хүрд\":\" Буруу\"},{\"Төрөл\":\"Жийп\"},{\"Өнгө\":\"Хар\"},{\"Үйлдвэрлэсэн он\":\"2004\"},{\"Орж ирсэн он\":\"2014\"},{\"Хөдөлгүүр\":\"Бензин\"},{\"Дотор өнгө\":\"Саарал\"},{\"Лизинг\":\"Лизинггүй\"},{\"Хөтлөгч\":\"Бүх дугуй 4WD\"},{\"Явсан\":\"189000 км.\"},{\"Нөхцөл\":\"Дугаар авсан\"},{\"Хаалга\":\"4\"},{\"description\":\"Nissan Xtrail T31 зарна 2500cc мотортой Салгаж, залгадаг мосттой 4x4 Бүх суудал хална Ухрах kамертай Ачаатай Автомат Савхин суудалтай Хийх зүйлгүй Туулах чадвар өндөртэй\"}]', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 01:29:41', 14, 1),
(20, 'Nissan X-Trail, 2012/2021', 1, 'Сансар', '25000000.00', '', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;2.0 л&quot;},{&quot;Хурдны хайрцаг&quot;:&quot; Автомат&quot;},{&quot;Хүрд&quot;:&quot; Буруу&quot;},{&quot;Төрөл&quot;:&quot;Жийп&quot;},{&quot;Өнгө&quot;:&quot;Хар&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;2004&quot;},{&quot;Орж ирсэн он&quot;:&quot;2014&quot;},{&quot;Хөдөлгүүр&quot;:&quot;Бензин&quot;},{&quot;Дотор өнгө&quot;:&quot;Саарал&quot;},{&quot;Лизинг&quot;:&quot;Лизинггүй&quot;},{&quot;Хөтлөгч&quot;:&quot;Бүх дугуй 4WD&quot;},{&quot;Явсан&quot;:&quot;189000 км.&quot;},{&quot;Нөхцөл&quot;:&quot;Дугаар авсан&quot;},{&quot;Хаалга&quot;:&quot;4&quot;},{&quot;description&quot;:&quot;Nissan Xtrail T31 зарна\\n\\n2500cc мотортой\\n\\nСалгаж, залгадаг мосттой 4x4\\n\\nБүх суудал хална\\n\\nУхрах kамертай\\n\\nАчаатай\\n\\nАвтомат\\n\\nСавхин суудалтай\\n\\nХийх зүйлгүй\\n\\nТуулах чадвар өндөртэй&quot;}]', 'Улаанбаатар', 'zizi', '+97680196888', '', 1, 'c4_4', 0, 0, '2023-04-11 01:37:00', 14, 1),
(21, 'Nissan X-Trail, 2010/2021', 1, '', '24999999.00', '', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;&quot;},{&quot;Хүрд&quot;:&quot;&quot;},{&quot;Төрөл&quot;:&quot;&quot;},{&quot;Өнгө&quot;:&quot;&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;&quot;},{&quot;Орж ирсэн он&quot;:&quot;&quot;},{&quot;Хөдөлгүүр&quot;:&quot;&quot;},{&quot;Дотор өнгө&quot;:&quot;&quot;},{&quot;Лизинг&quot;:&quot;&quot;},{&quot;Хөтлөгч&quot;:&quot;&quot;},{&quot;Явсан&quot;:&quot;&quot;},{&quot;Нөхцөл&quot;:&quot;&quot;},{&quot;Хаалга&quot;:&quot;&quot;},{&quot;description&quot;:&quot;Nissan Xtrail T31 зарна\\n\\n🔴2500cc мотортой\\n\\n🔴Салгаж, залгадаг мосттой 4x4\\n\\n🔴Бүх суудал хална\\n\\n🔴Ухрах kамертай\\n\\n🔴Ачаатай\\n\\n🔴Автомат\\n\\n🔴Савхин суудалтай\\n\\n🔴Хийх зүйлгүй\\n\\n🔴Туулах чадвар өндөртэй&quot;}]', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 01:42:17', 14, 1),
(22, 'Nissan X-Trail, 2008/2020', 1, 'Сансар', '21000000.00', '', '', '', '[{\"Мотор багтаамж\":\"2.0 л\"},{\"Хурдны хайрцаг\":\" Автомат\"},{\"Хүрд\":\" Буруу\"},{\"Төрөл\":\"Жийп\"},{\"Өнгө\":\"Хар\"},{\"Үйлдвэрлэсэн он\":\"2004\"},{\"Орж ирсэн он\":\"2014\"},{\"Хөдөлгүүр\":\"\"},{\"Дотор өнгө\":\"\"},{\"Лизинг\":\"\"},{\"Хөтлөгч\":\"\"},{\"Явсан\":\"\"},{\"Нөхцөл\":\"\"},{\"Хаалга\":\"\"},{\"description\":\"\"}]', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 02:04:05', 14, 1),
(23, 'Nissan X-Trail, 3-42', 1, '', '45.00', '', '', '', '[{\"Мотор багтаамж\":\"\"},{\"Хурдны хайрцаг\":\"\"},{\"Хүрд\":\"\"},{\"Төрөл\":\"\"},{\"Өнгө\":\"\"},{\"Үйлдвэрлэсэн он\":\"\"},{\"Орж ирсэн он\":\"\"},{\"Хөдөлгүүр\":\"\"},{\"Дотор өнгө\":\"\"},{\"Лизинг\":\"\"},{\"Хөтлөгч\":\"\"},{\"Явсан\":\"\"},{\"Нөхцөл\":\"\"},{\"Хаалга\":\"\"},{\"description\":\"Nissan Xtrail T31 зарна\n\n🔴2500cc мотортой\n\n🔴Салгаж, залгадаг мосттой 4x4\n\n🔴Бүх суудал хална\n\n🔴Ухрах kамертай\n\n🔴Ачаатай\n\n🔴Автомат\n\n🔴Савхин суудалтай\n\n🔴Хийх зүйлгүй\n\n🔴Туулах чадвар өндөртэй\"}]', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 03:41:51', 14, 1),
(24, 'Nissan X-Trail, 3-56', 1, '', '51.00', '', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;&quot;},{&quot;Хүрд&quot;:&quot;&quot;},{&quot;Төрөл&quot;:&quot;&quot;},{&quot;Өнгө&quot;:&quot;&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;&quot;},{&quot;Орж ирсэн он&quot;:&quot;&quot;},{&quot;Хөдөлгүүр&quot;:&quot;&quot;},{&quot;Дотор өнгө&quot;:&quot;&quot;},{&quot;Лизинг&quot;:&quot;&quot;},{&quot;Хөтлөгч&quot;:&quot;&quot;},{&quot;Явсан&quot;:&quot;&quot;},{&quot;Нөхцөл&quot;:&quot;&quot;},{&quot;Хаалга&quot;:&quot;&quot;},{&quot;description&quot;:&quot;Nissan Xtrail T31 зарна\n\n🔴2500cc мотортой\n\n🔴Салгаж, залгадаг мосттой 4x4\n\n🔴Бүх суудал хална\n\n🔴Ухрах kамертай\n\n🔴Ачаатай\n\n🔴Автомат\n\n🔴Савхин суудалтай\n\n🔴Хийх зүйлгүй\n\n🔴Туулах чадвар өндөртэй&quot;}]', 'Улаанбаатар', 'zizi', '+97699213557', '', 1, 'c4_4', 0, 0, '2023-04-11 03:56:53', 14, 1),
(25, 'Mercedes-Benz C-Class, 2015/2022', 1, 'БГД, 3-4р хороолол, Бичил МТ колонкоос хойш 500м', '79000000.00', '', '', '[{\"Мотор багтаамж\":\"2.0 л\"},{\"Хурдны хайрцаг\":\"Автомат\"},{\"Хүрд\":\"Зөв\"},{\"Төрөл\":\"Суудлын тэрэг\"},{\"Өнгө\":\"Хар\"},{\"Үйлдвэрлэсэн он\":\"2015\"},{\"Орж ирсэн он\":\"2022\"},{\"Хөдөлгүүр\":\"Бензин\"},{\"Дотор өнгө\":\"Хар\"},{\"Лизинг\":\" Банкны лизингтэй\"},{\"Хөтлөгч\":\"Хойноо RWD\"},{\"Явсан\":\"107310 км.\"},{\"Нөхцөл\":\"Дугаар аваагүй\"},{\"Хаалга\":\"4\"}]', '✅ 2015 MERCEDES BENZ C200 🇩🇪\r\n\r\n➖ Хөдөлгүүр: 2000сс турбо бензин\r\n\r\n➖ Японд явж байсан, зөв рүльтэй.\r\n\r\n➖ Гүйлт: 107,300 км\r\n\r\n➖ Хөтлөгч: RWD\r\n\r\n➖ Суудал халаагч, бүх талын мэдрэгчтэй\r\n\r\n➖ Дуудлага худалдааны 4B үнэлгээтэй.\r\n\r\n✅ Банк болон ББСБ-р зээлээр авч болно.', 'Улаанбаатар', 'Subaru house', '+97699646207', '', 1, 'c4_5', 0, 0, '2023-04-11 05:16:39', 14, 1),
(26, 'Toyota Prius 30, 2013/2023', 1, 'Да хүрээ 3-р хаалга Сайн ломбардны урд', '24800000.00', '', '', '[{\"Мотор багтаамж\":\"2.0 л\"},{\"Хурдны хайрцаг\":\" Автомат\"},{\"Хүрд\":\" Буруу\"},{\"Төрөл\":\"Суудлын тэрэг\"},{\"Өнгө\":\"Хар\"},{\"Үйлдвэрлэсэн он\":\"2004\"},{\"Орж ирсэн он\":\"2014\"},{\"Хөдөлгүүр\":\"Бензин\"},{\"Дотор өнгө\":\"Саарал\"},{\"Лизинг\":\"Лизинггүй\"},{\"Хаяг байршил\":\"Да хүрээ 3-р хаалга Сайн ломбардны урд\"},{\"Хөтлөгч\":\"Бүх дугуй 4WD\"},{\"Явсан\":\"189000 км.\"},{\"Нөхцөл\":\"Дугаар авсан\"},{\"Хаалга\":\"4\"}]', 'Сая орж ирсэн 2013оны 11сард үйлдвэрлэсэн\r\n\r\n👉S selection\r\n\r\n👉гялгар хар өнгөтэй\r\n\r\n👉хар салонтой\r\n\r\n👉148к гүйлттэй\r\n\r\n👉үнэ 24.8сая\r\n\r\n👉гүйлт болон эдэлгээ маш бага\r\n\r\n👉15тай обудтай\r\n\r\n👉жолооч хаалгандаа смарттай\r\n\r\n👉урд буферын нэмэлт гэрэлтэй\r\n\r\n👉ориг дэлгэцтэй хөгжим\r\n\r\n👉зураас дагаж эргэдэг ухрах камертай\r\n\r\n👉дотор болон гаднаа мааш цэвэрхэн машин\r\n\r\n👉үзлэг оношилгоонд орсон, дугаара авхад бэлэн\r\n\r\n🏦бүх банк болон ББСБ-н зээлээр авах боломжтой', 'Улаанбаатар', 'ТулгаТ', '+97699213557', '', 1, 'c4_2', 0, 0, '2023-04-11 05:22:13', 14, 1),
(27, 'Lexus LX, 2019/2019', 1, ' BZD', '370000000.00', '', '', '[{&quot;Мотор багтаамж&quot;:&quot; 3.2 л&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;Автомат&quot;},{&quot;Хүрд&quot;:&quot; Буруу&quot;},{&quot;Төрөл&quot;:&quot;Жийп&quot;},{&quot;Өнгө&quot;:&quot;Хар&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;2004&quot;},{&quot;Орж ирсэн он&quot;:&quot;2014&quot;},{&quot;Хөдөлгүүр&quot;:&quot;Бензин&quot;},{&quot;Дотор өнгө&quot;:&quot;Саарал&quot;},{&quot;Лизинг&quot;:&quot;Лизинггүй&quot;},{&quot;Хөтлөгч&quot;:&quot;Бүх дугуй 4WD&quot;},{&quot;Явсан&quot;:&quot;189000 км.&quot;},{&quot;Нөхцөл&quot;:&quot;Дугаар авсан&quot;},{&quot;Хаалга&quot;:&quot;4&quot;}]', 'Lexus LX570\r\n\r\n2019/2019 ontoi\r\n\r\nBaga yavsan 23.000km\r\n\r\nButen huulgatai mash tseverhen, barag unadaggui, 4 uliral grajd bsan', 'Улаанбаатар', 'Undral', '+97688109518', '', 1, 'c4_6', 0, 0, '2023-04-11 05:49:50', 14, 4),
(28, 'Ford Ranger, 2018/2022', 1, 'UB King Tower', '75000000.00', '', '', '[{\"Мотор багтаамж\":\" 3.2 л\"},{\"Хурдны хайрцаг\":\"Автомат\"},{\"Хүрд\":\" Буруу\"},{\"Төрөл\":\" Жийп\"},{\"Өнгө\":\"Цагаан\"},{\"Үйлдвэрлэсэн он\":\"2018\"},{\"Орж ирсэн он\":\"2022\"},{\"Хөдөлгүүр\":\"Дизель\"},{\"Дотор өнгө\":\"Хар\"},{\"Лизинг\":\"Лизинггүй\"},{\"Хөтлөгч\":\"Бүх дугуй 4WD\"},{\"Явсан\":\" 85000 км.\"},{\"Нөхцөл\":\"Дугаар авсан\"},{\"Хаалга\":\"5\"}]', '?2500cc ????????\r\n\r\n???????, ???????? ??????? 4x4\r\n\r\n???? ?????? ?????\r\n\r\n?????? k???????\r\n\r\n????????\r\n\r\n????????\r\n\r\n??????? ?????????\r\n\r\n????? ???????\r\n\r\n??????? ?????? ????????', 'Улаанбаатар', 'TBN', '+97699213557', '', 1, 'c4_7', 0, 0, '2023-04-11 07:19:59', 14, 1),
(29, 'Ford Ranger, 2010/2023', 1, '', '54.00', '', '', '[{\"Мотор багтаамж\":\"\"},{\"Хурдны хайрцаг\":\"\"},{\"Хүрд\":\"\"},{\"Төрөл\":\"\"},{\"Өнгө\":\"\"},{\"Үйлдвэрлэсэн он\":\"\"},{\"Орж ирсэн он\":\"\"},{\"Хөдөлгүүр\":\"\"},{\"Дотор өнгө\":\"\"},{\"Лизинг\":\"\"},{\"Хөтлөгч\":\"\"},{\"Явсан\":\"\"},{\"Нөхцөл\":\"\"},{\"Хаалга\":\"\"}]', 'ð´2500cc Ð¼Ð¾ÑÐ¾ÑÑÐ¾Ð¹\r\n\r\nð´Ð¡Ð°Ð»Ð³Ð°Ð¶, Ð·Ð°Ð»Ð³Ð°Ð´Ð°Ð³ Ð¼Ð¾ÑÑÑÐ¾Ð¹ 4x4\r\n\r\nð´ÐÒ¯Ñ ÑÑÑÐ´Ð°Ð» ÑÐ°Ð»Ð½Ð°\r\n\r\nð´Ð£ÑÑÐ°Ñ kÐ°Ð¼ÐµÑÑÐ°Ð¹\r\n\r\nð´ÐÑÐ°Ð°ÑÐ°Ð¹\r\n\r\nð´ÐÐ²ÑÐ¾Ð¼Ð°Ñ\r\n\r\nð´Ð¡Ð°Ð²ÑÐ¸Ð½ ÑÑÑÐ´Ð°Ð»ÑÐ°Ð¹\r\n\r\nð´Ð¥Ð¸Ð¹Ñ Ð·Ò¯Ð¹Ð»Ð³Ò¯Ð¹\r\n\r\nð´Ð¢ÑÑÐ»Ð°Ñ ÑÐ°Ð´Ð²Ð°Ñ Ó©Ð½Ð´Ó©ÑÑÑÐ¹', 'Улаанбаатар', 'vi', '+97699213557', '', 1, 'c4_7', 0, 0, '2023-04-11 07:22:01', 14, 1),
(30, 'Ford Ranger, 2007/2020', 0, '', '87.00', '', '', '[{\"Мотор багтаамж\":\"\"},{\"Хурдны хайрцаг\":\"\"},{\"Хүрд\":\"\"},{\"Төрөл\":\"\"},{\"Өнгө\":\"\"},{\"Үйлдвэрлэсэн он\":\"\"},{\"Орж ирсэн он\":\"\"},{\"Хөдөлгүүр\":\"\"},{\"Дотор өнгө\":\"\"},{\"Лизинг\":\"\"},{\"Хөтлөгч\":\"\"},{\"Явсан\":\"\"},{\"Нөхцөл\":\"\"},{\"Хаалга\":\"\"}]', '🔴2500cc мотортой\r\n\r\n🔴Салгаж, залгадаг мосттой 4x4\r\n\r\n🔴Бүх суудал хална\r\n\r\n🔴Ухрах kамертай\r\n\r\n🔴Ачаатай\r\n\r\n🔴Автомат\r\n\r\n🔴Савхин суудалтай\r\n\r\n🔴Хийх зүйлгүй\r\n\r\n🔴Туулах чадвар өндөртэй', 'Улаанбаатар', 'vi', '+97699213557', '', 1, 'c4_7', 0, 0, '2023-04-11 07:26:43', 14, 1),
(31, 'Ford Ranger\'s, 2007/2020', 1, 'asd\'asd', '54.00', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;&quot;},{&quot;Хүрд&quot;:&quot;&quot;},{&quot;Төрөл&quot;:&quot;&quot;},{&quot;Өнгө&quot;:&quot;&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;&quot;},{&quot;Орж ирсэн он&quot;:&quot;&quot;},{&quot;Хөдөлгүүр&quot;:&quot;&quot;},{&quot;Дотор өнгө&quot;:&quot;&quot;},{&quot;Лизинг&quot;:&quot;&quot;},{&quot;Хөтлөгч&quot;:&quot;&quot;},{&quot;Явсан&quot;:&quot;&quot;},{&quot;Нөхцөл&quot;:&quot;&quot;},{&quot;Хаалга&quot;:&quot;&quot;}]', '🔴2500cc мотортой\r\n\r\n🔴Салгаж, залгадаг мосттой 4x4\r\n\r\n🔴Бүх суудал хална\r\n\r\n🔴Ухрах kамертай\r\n\r\n🔴Ачаатай\r\n\r\n🔴Автомат\r\n\r\n🔴Савхин суудалтай\r\n\r\n🔴Хийх зүйлгүй\r\n\r\n🔴&lt;b&gt;Туулах чадвар өндөртэй\'s&lt;/b&gt;', 'Улаанбаатар', 'asd', '+97699213557', '', 1, 'c4_7', 0, 0, '2023-04-11 07:33:26', 14, 1),
(32, 'Ford Ranger, 2014/2015', 1, 'Улаанбаатар', '60000000.00', 'https://www.youtube.com/embed/bKSJZ8FEQdE', '20230413102001_20230329_104447.mp4', '[{&quot;Мотор багтаамж&quot;:&quot;3.2 л&quot;},{&quot;Хурдны хайрцаг&quot;:&quot;Механик&quot;},{&quot;Хүрд&quot;:&quot;Зөв&quot;},{&quot;Төрөл&quot;:&quot;Жийп&quot;},{&quot;Өнгө&quot;:&quot;Цагаан&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;2018&quot;},{&quot;Орж ирсэн он&quot;:&quot;2014&quot;},{&quot;Хөдөлгүүр&quot;:&quot;Бензин&quot;},{&quot;Дотор өнгө&quot;:&quot;Саарал&quot;},{&quot;Лизинг&quot;:&quot;Лизинггүй&quot;},{&quot;Хөтлөгч&quot;:&quot;Бүх дугуй 4WD&quot;},{&quot;Явсан&quot;:&quot;85000 км.&quot;},{&quot;Нөхцөл&quot;:&quot;Дугаар авсан&quot;},{&quot;Хаалга&quot;:&quot;5&quot;}]', '🔴2500cc мотортой\r\n\r\n🔴Салгаж, залгадаг мосттой 4x4\r\n\r\n🔴Бүх суудал хална\r\n\r\n🔴Ухрах kамертай\r\n\r\n🔴Ачаатай\r\n\r\n🔴Автомат\r\n\r\n🔴Савхин суудалтай\r\n\r\n🔴Хийх зүйлгүй\r\n\r\n🔴Туулах чадвар өндөртэй\r\n\r\nUSA стандарт\'s\r\n\r\n&lt;p&gt;Зөв механик&lt;/p&gt;\r\n\r\n3.2сс дизель\r\n\r\nARB бүтэн тоноглол\r\n\r\nСтандарт халуун тогоо\r\n\r\nСтандарт агаарын хоолой\r\n\r\nМанангийн болон нэмэлт гэрэл\r\n\r\nМоторын ган хаалт\r\n\r\nАвтомат удирдлагатай леботик\r\n\r\nСпорт 5н дугуй гэх мэт хийсэн юм ихтэй хэрэглээнд унасан машин зарна солино зөрүү тохирно', 'Улаанбаатар', 'Baagii', '+97699067283', '', 1, 'c4_7', 0, 0, '2023-04-13 10:19:31', 14, 1),
(33, 'hello world', 0, '', '53.00', '', '', '[]', 'asd', 'Улаанбаатар', 'Todbayar Altankhuyag', '+97699213557', 'todbayar@yahoo.com', 1, 'c4_3', 0, 0, '2023-04-19 04:41:23', 14, 1),
(34, 'nice work 1', 0, '', '998.00', '', '', '[{&quot;Мотор багтаамж&quot;:&quot;2.0 л&quot;},{&quot;Хурдны хайрцаг&quot;:&quot; Автомат&quot;},{&quot;Хүрд&quot;:&quot;&quot;},{&quot;Төрөл&quot;:&quot;Суудлын тэрэг&quot;},{&quot;Өнгө&quot;:&quot;Хар&quot;},{&quot;Үйлдвэрлэсэн он&quot;:&quot;2004&quot;},{&quot;Орж ирсэн он&quot;:&quot;&quot;},{&quot;Хөдөлгүүр&quot;:&quot;Дизель&quot;},{&quot;Дотор өнгө&quot;:&quot;Хар&quot;},{&quot;Лизинг&quot;:&quot;Лизинггүй&quot;},{&quot;Хөтлөгч&quot;:&quot;Бүх дугуй 4WD&quot;},{&quot;Явсан&quot;:&quot;189000 км.&quot;},{&quot;Нөхцөл&quot;:&quot;Дугаар авсан&quot;},{&quot;Хаалга&quot;:&quot;4&quot;}]', 'asd', 'Архангай', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c4_7', 0, 0, '2023-04-19 05:07:54', 14, 1),
(35, 'Dell optiplex 3020 процессор', 0, '', '54.00', '', '', '[]', '87878787', 'Архангай', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c4_1', 0, 0, '2023-04-19 05:10:14', 14, 1),
(36, 'Худ хотын төвтэй ойр хаус', 1, '', '9898.00', '', '', '[]', 'okokok', 'Улаанбаатар', 'Todbayar', '+97699213557', 'atodko0513@gmail.com', 1, 'c4_1', 0, 0, '2023-04-19 05:11:25', 14, 1);

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

INSERT INTO `user` (`id`, `uid`, `name`, `image`, `email`, `phone`, `city`, `topup`, `role`, `status`) VALUES
(1, 'lRm664LM9ggwA8iyExDDXVqDifN2', 'Todbayar', '20230419060433_MyPic.jpg', 'atodko0513@gmail.com', '+97699213557', 'Улаанбаатар', NULL, 3, 1),
(2, 'ui8fkPgY9gdcVTTCZe5F9DtLORy2', 'Tod', '', '', '+97699114547', 'Улаанбаатар', NULL, 0, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
