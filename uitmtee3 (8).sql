-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3345
-- Generation Time: Jul 05, 2024 at 07:17 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `uitmtee3`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `ADMIN_ID` int(11) NOT NULL,
  `ADMIN_NAME` varchar(100) NOT NULL,
  `ADMIN_EMAIL` varchar(100) NOT NULL,
  `ADMIN_PHONE` varchar(15) NOT NULL,
  `ADMIN_PASSWORD` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ADMIN_ID`, `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PHONE`, `ADMIN_PASSWORD`) VALUES
(2022454092, 'mirafizh', 'mirafizh@gmail.com', '0174020170', '757204mi');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
`CART_ID` int(11) NOT NULL,
  `CUS_ID` int(11) DEFAULT NULL,
  `CLO_NUM` int(11) DEFAULT NULL,
  `SIZE` varchar(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT '0',
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CART_ID`, `CUS_ID`, `CLO_NUM`, `SIZE`, `QUANTITY`, `added_at`) VALUES
(138, 2022454155, 1002, 'XS', 1, '2024-05-31 15:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `clothes`
--

CREATE TABLE IF NOT EXISTS `clothes` (
  `CLO_NUM` int(11) NOT NULL,
  `CLO_NAME` varchar(100) NOT NULL,
  `IMAGE` varchar(100) NOT NULL,
  `CLO_PRICE` decimal(10,2) NOT NULL,
  `CLO_TYPE` varchar(50) NOT NULL,
  `XS_QTY` int(11) NOT NULL,
  `S_QTY` int(11) NOT NULL,
  `M_QTY` int(11) NOT NULL,
  `L_QTY` int(11) NOT NULL,
  `XL_QTY` int(11) NOT NULL,
  `2XL_QTY` int(11) NOT NULL,
  `3XL_QTY` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clothes`
--

INSERT INTO `clothes` (`CLO_NUM`, `CLO_NAME`, `IMAGE`, `CLO_PRICE`, `CLO_TYPE`, `XS_QTY`, `S_QTY`, `M_QTY`, `L_QTY`, `XL_QTY`, `2XL_QTY`, `3XL_QTY`) VALUES
(1001, 'UiTM Lioness V3', 'j1.png', '65.00', 'Jersey', 82, 99, 100, 98, 100, 99, 100),
(1002, 'UiTM Lioness V1', 'j3.png', '56.00', 'Jersey', 85, 100, 100, 100, 99, 99, 100),
(1003, 'UiTM Lioness V2', 'j2.png', '60.00', 'Jersey', 83, 100, 100, 100, 100, 99, 100),
(1004, 'KPPIM Jersey', 'j10.png', '45.00', 'Jersey', 77, 84, 92, 94, 100, 99, 99),
(1005, 'UiTM Black', 'j99.png', '65.00', 'Jersey', 99, 100, 100, 99, 100, 99, 100),
(1006, 'Korporat FSG', 'j77.png', '80.00', 'Corporate', 75, 100, 100, 99, 100, 99, 99),
(1007, 'Korporat KPPIM', 'j23.png', '75.00', 'Corporate', 96, 100, 99, 100, 100, 100, 100),
(1008, 'Korporat FP', 'j01.png', '85.00', 'Corporate', 99, 100, 100, 100, 100, 100, 100),
(1009, 'Korporat BASCO', 'k1.png', '85.00', 'Corporate', 97, 100, 100, 99, 100, 100, 100),
(1010, 'Korporat DiSK', 'k1.png', '80.00', 'Corporate', 99, 100, 100, 100, 100, 100, 100),
(1011, 'Korporat MASSCOM', 'k2.png', '80.00', 'Corporate', 84, 100, 100, 100, 100, 100, 100),
(1012, 'Korporat EEC', 'k4.png', '83.00', 'Corporate', 88, 100, 100, 100, 79, 83, 100),
(1013, 'UiTM Muslimah Jersey', 'jj1.png', '55.00', 'Jersey', 99, 100, 100, 99, 100, 98, 100),
(1014, 'UiTM Long Sleeve', 'jj2.png', '55.00', 'Jersey', 100, 100, 0, 100, 100, 100, 100),
(1015, 'KPPIM Jersey V2', 'jj3.png', '60.00', 'Jersey', 94, 100, 100, 100, 100, 100, 100),
(1016, 'KPPIM Jersey V2', 'jj4.png', '75.00', 'Jersey', 99, 100, 100, 100, 100, 100, 100);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE IF NOT EXISTS `contact_messages` (
`MESSAGE_ID` int(11) NOT NULL,
  `MESSAGE` text NOT NULL,
  `RATING` varchar(1000) NOT NULL,
  `SUBMISSION_DATE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `CUS_ID` int(11) DEFAULT NULL,
  `ADMIN_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`MESSAGE_ID`, `MESSAGE`, `RATING`, `SUBMISSION_DATE`, `CUS_ID`, `ADMIN_ID`) VALUES
(20, 'baguss', '4', '2024-05-31 05:20:46', 2022454055, 2022454092),
(21, 'bad', '1', '2024-05-31 05:38:32', 2022454055, 2022454092),
(22, 'Saya amat menyukai apps ini, Thank you so much.', '5', '2024-05-31 07:07:03', 2022121212, 2022454092),
(23, 'Happy to using this apps.', '4', '2024-05-31 07:09:29', 2022121515, 2022454092),
(24, 'I like', '4', '2024-05-31 07:12:48', 2022123456, 2022454092),
(25, 'Thanks', '2', '2024-05-31 07:13:30', 2022454055, 2022454092),
(26, 'Very convenience', '4', '2024-05-31 07:15:43', 2022454065, 2022454092),
(27, 'bad sorry', '1', '2024-05-31 07:19:51', 2022454078, 2022454092),
(28, 'worstttttttt', '1', '2024-05-31 07:23:04', 2022454081, 2022454092),
(29, 'good but not good enough', '2', '2024-05-31 07:25:42', 2022454155, 2022454092),
(30, 'good ', '3', '2024-05-31 07:28:22', 2022457487, 2022454092),
(31, 'nyenyenye', '2', '2024-05-31 07:29:52', 2022787804, 2022454092),
(32, 'I hope you can improve apps more and including more clothes and more features', '3', '2024-05-31 07:35:07', 2022816422, 2022454092),
(33, 'Good just good', '2', '2024-05-31 07:39:14', 2022877957, 2022454092),
(34, 'good', '5', '2024-06-22 03:46:38', 2022757208, 2022454092),
(35, 'best', '5', '2024-07-05 10:44:36', 2022757208, 2022454092),
(36, 'good service', '5', '2024-07-05 10:50:39', 2022757208, 2022454092),
(37, 'good', '5', '2024-07-05 10:51:32', 2022757208, 2022454092),
(38, 'goof', '1', '2024-07-05 10:52:38', 2022757208, 2022454092),
(39, 'damnit it really good', '5', '2024-07-05 11:07:07', 2022757208, 2022454092);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `CUS_ID` int(11) NOT NULL,
  `CUS_NAME` varchar(100) NOT NULL,
  `CUS_PHONE` varchar(15) NOT NULL,
  `CUS_EMAIL` varchar(100) NOT NULL,
  `CUS_ADDRESS` text NOT NULL,
  `CUS_PASSWORD` varchar(255) NOT NULL,
  `PROFILE` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CUS_ID`, `CUS_NAME`, `CUS_PHONE`, `CUS_EMAIL`, `CUS_ADDRESS`, `CUS_PASSWORD`, `PROFILE`) VALUES
(2022121212, 'nema', '01985472888', 'mena@gmail.com', 'efsgdhjgfjf', '4747', 'ppic/iconprofile.png'),
(2022121515, 'mena', '01840215547', 'nini@gmail.com', 'dfgd', '4444', 'ppic/iconprofile.png'),
(2022123456, 'haikal', '012123456789', 'haikal@gmail.com', '111', 'baba14', 'ppic/iconprofile.png'),
(2022454055, 'Joyah Joshan', '01133438100', 'jojen@gmail.com', 'tiang lampu 19, Bukit Pasir', 'joyah055', 'ppic/iconprofile.png'),
(2022454065, 'WSFEF', '01548240174', 'xoxo@gmail.com', 'NSSD', 'xoxo4065', 'ppic/Screenshot (5).png'),
(2022454078, 'baekhyunwoo', '01136438100', 'haein@gmail.com', 'no 19, Permatang Tok Mahad', 'haein078', 'ppic/iconprofile.png'),
(2022454081, 'fakhrul', '01133138600', 'roll@gmail.com', 'no 21, jalan mont kiara', 'roll4081', 'ppic/iconprofile.png'),
(2022454091, 'lencai', '0154020170', 'lenlen@gmail.com', 'Parit 17 A Sungai Lampam', '$2y$10$ObnQtNvFHDJuuRQ.AURt4./SgypbS5zR.qqo78/grP61oWh53C11i', 'ppic/iconprofile.png'),
(2022454092, '', '', '', '', '757204mi12235', 'default.jpg'),
(2022454155, 'Nurliyana Hanisah', '0194041896', 'lyhanis@gmail.com', 'No,39 Jalan Murni1, Taman Murni', 'anieh115', 'ppic/iconprofile.png'),
(2022457487, 'mi', '01454255565', 'segrd@gmail.com', 'dfgg', '789', 'ppic/iconprofile.png'),
(2022757204, 'Razilah Rahman', '01133138600', '7572@gmail.com', 'Parit 17 A Sungai Lampam', '757204', 'ppic/iconprofile.png'),
(2022757208, 'myatt', '01840215547', 'mie@gmail.com', 'no 26', '757204', 'ppic/Screenshot (32).png'),
(2022787804, 'miraa', 'naem', 'nafiss@gmail.com', 'fsfgfdhgdhd', '545471', 'ppic/iconprofile.png'),
(2022816422, 'Amni', '01136346952', 'nurulamni23@gmail.com', 'Parit 17 A Sungai Lampam', '1234', 'ppic/iconprofile.png'),
(2022868686, 'Lencaima', '0194041899', 'lylema@gmail.com', 'no 19, Permatang Tok Mahad', '041016', 'ppic/iconprofile.png'),
(2022877957, 'Lin Yee', '01131392934', 'lin@gmail.com', 'no 12 jln ubi', '123456', 'ppic/iconprofile.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_customer`
--

CREATE TABLE IF NOT EXISTS `order_customer` (
`ORDER_ID` int(11) NOT NULL,
  `ORDER_DATE` datetime DEFAULT NULL,
  `ORDER_STATUS` varchar(11) DEFAULT NULL,
  `ADMIN_ID` int(11) DEFAULT NULL,
  `CUS_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_customer`
--

INSERT INTO `order_customer` (`ORDER_ID`, `ORDER_DATE`, `ORDER_STATUS`, `ADMIN_ID`, `CUS_ID`) VALUES
(2, '2024-05-31 10:00:48', 'Shipping', 2022454092, 2022454055),
(3, '2024-05-31 10:08:07', 'Shipping', 2022454092, 2022454055),
(5, '2024-05-31 10:14:49', 'Shipping', 2022454092, 2022454055),
(6, '2024-05-31 10:30:28', 'Shipping', 2022454092, 2022454055),
(7, '2024-05-31 11:04:19', 'Shipping', 2022454092, 2022454055),
(8, '2024-05-31 12:27:04', 'Shipping', 2022454092, 2022454055),
(9, '2024-05-31 12:35:13', 'Shipping', 2022454092, 2022454055),
(10, '2024-05-31 14:56:39', 'Shipping', 2022454092, 2022121212),
(11, '2024-05-31 15:05:33', 'Shipping', 2022454092, 2022121212),
(12, '2024-05-31 15:08:37', 'Shipping', 2022454092, 2022121515),
(13, '2024-05-31 15:10:52', 'Shipping', 2022454092, 2022123456),
(14, '2024-05-31 15:11:34', 'pending', 2022454092, 2022123456),
(16, '2024-05-31 15:14:45', 'Pending', 2022454092, 2022454065),
(17, '2024-05-31 15:18:47', 'Pending', 2022454092, 2022454078),
(18, '2024-05-31 15:21:54', 'Pending', 2022454092, 2022454081),
(19, '2024-05-31 15:22:37', 'Pending', 2022454092, 2022454081),
(20, '2024-05-31 15:27:40', 'Pending', 2022454092, 2022457487),
(21, '2024-05-31 15:29:26', 'Pending', 2022454092, 2022787804),
(22, '2024-05-31 15:31:14', 'Pending', 2022454092, 2022816422),
(23, '2024-05-31 15:37:20', 'Pending', 2022454092, 2022877957),
(24, '2024-05-31 15:39:51', 'Pending', 2022454092, 2022877957),
(25, '2024-05-31 17:10:42', 'Pending', 2022454092, 2022454155),
(26, '2024-05-31 17:52:36', 'Pending', 2022454092, 2022757204),
(27, '2024-06-23 14:45:05', 'Pending', 2022454092, 2022121212),
(28, '2024-06-23 15:03:04', 'Pending', 2022454092, 2022454065),
(29, '2024-07-05 18:34:15', 'Pending', 2022454092, 2022757208),
(30, '2024-07-05 18:37:25', 'Pending', 2022454092, 2022757208),
(31, '2024-07-05 18:43:54', 'Pending', 2022454092, 2022757208),
(33, '2024-07-05 19:06:22', 'Pending', 2022454092, 2022757208),
(34, '2024-07-05 19:07:22', 'Pending', 2022454092, 2022757208);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `ORDER_ID` int(11) DEFAULT NULL,
  `CLO_NUM` int(11) DEFAULT NULL,
  `SIZE` varchar(11) DEFAULT NULL,
  `QUANTITY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`ORDER_ID`, `CLO_NUM`, `SIZE`, `QUANTITY`) VALUES
(2, 1001, 'XS', 1),
(3, 1001, 'XS', 1),
(3, 1002, 'XS', 1),
(3, 1003, '2XL', 1),
(5, 1003, 'XS', 1),
(5, 1004, '2XL', 1),
(6, 1002, 'XS', 1),
(6, 1003, 'XS', 1),
(6, 1004, 'XS', 1),
(7, 1003, 'XS', 1),
(8, 1002, 'XS', 2),
(9, 1003, 'XS', 1),
(9, 1004, '3XL', 1),
(9, 1007, 'XS', 1),
(9, 1006, '2XL', 1),
(9, 1005, 'L', 1),
(9, 1011, 'XS', 1),
(10, 1001, 'XS', 1),
(10, 1005, '2XL', 1),
(10, 1009, 'XS', 1),
(10, 1010, 'XS', 1),
(10, 1011, 'XS', 1),
(10, 1015, 'XS', 1),
(11, 1007, 'XS', 1),
(11, 1008, 'XS', 1),
(12, 1001, 'XS', 1),
(12, 1006, 'XS', 4),
(12, 1011, 'XS', 1),
(13, 1009, 'XS', 1),
(13, 1015, 'XS', 1),
(13, 1017, '2XL', 1),
(13, 1017, '2XL', 1),
(13, 1017, '3XL', 1),
(13, 1017, 'XL', 1),
(14, 1004, 'XS', 1),
(14, 1001, 'XS', 1),
(14, 1003, 'XS', 1),
(14, 1002, 'XS', 1),
(16, 1001, 'XS', 8),
(16, 1011, 'XS', 10),
(16, 1012, 'XS', 12),
(16, 1012, 'XL', 21),
(17, 1001, 'XS', 1),
(17, 1006, 'XS', 19),
(17, 1015, 'XS', 1),
(18, 1005, 'XS', 1),
(18, 1013, 'XS', 1),
(18, 1013, '2XL', 1),
(18, 1013, '2XL', 1),
(18, 1013, 'L', 1),
(19, 1015, 'XS', 1),
(19, 1016, 'XS', 1),
(20, 1004, 'XS', 20),
(20, 1004, 'S', 16),
(20, 1004, 'M', 8),
(20, 1004, 'L', 6),
(21, 1002, 'XS', 1),
(21, 1003, 'XS', 1),
(22, 1006, 'XS', 1),
(22, 1007, 'XS', 1),
(22, 1011, 'XS', 1),
(23, 1007, 'XS', 1),
(23, 1006, 'XS', 1),
(23, 1011, 'XS', 1),
(24, 1011, 'XS', 1),
(24, 1012, '2XL', 17),
(25, 1001, 'XS', 1),
(26, 1002, 'XS', 1),
(26, 1003, 'XS', 1),
(27, 1015, 'XS', 1),
(27, 1003, 'XS', 1),
(27, 1001, 'L', 1),
(28, 1015, 'XS', 1),
(28, 1003, 'XS', 1),
(28, 1001, 'L', 1),
(29, 1003, 'XS', 1),
(30, 1002, 'XS', 1),
(31, 1003, 'XS', 1),
(33, 1004, 'XS', 1),
(34, 1003, 'XS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
`PAY_NUM` int(11) NOT NULL,
  `PAY_DATE` datetime DEFAULT NULL,
  `PAY_STATUS` varchar(11) DEFAULT NULL,
  `IMG` varchar(10000) DEFAULT NULL,
  `ORDER_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PAY_NUM`, `PAY_DATE`, `PAY_STATUS`, `IMG`, `ORDER_ID`) VALUES
(1, '2024-05-31 00:00:00', 'Pending', 'receipts/m.png', 2),
(2, '2024-05-31 00:00:00', 'Pending', 'receipts/uitm2.png', 3),
(3, '2024-05-31 00:00:00', 'Pending', 'receipts/fp.png', 5),
(4, '2024-05-31 00:00:00', 'Pending', 'receipts/uitm2.png', 6),
(5, '2024-05-31 00:00:00', 'Pending', 'receipts/uitm2.png', 7),
(6, '2024-05-31 00:00:00', 'Pending', 'receipts/call3.png', 8),
(7, '2024-05-31 00:00:00', 'Pending', 'receipts/OIP.jpg', 9),
(8, '2024-05-31 00:00:00', 'Successfull', 'receipts/bhnc.png', 10),
(9, '2024-05-31 00:00:00', 'Successfull', 'receipts/fuh.png', 11),
(10, '2024-05-31 00:00:00', 'Successfull', 'receipts/catalogue.png', 12),
(11, '2024-05-31 00:00:00', 'Successfull', 'receipts/iconperson.png', 13),
(12, '2024-05-31 00:00:00', 'Successfull', 'receipts/email_us.png', 14),
(13, '2024-05-31 00:00:00', 'Successfull', 'receipts/fuh.png', 16),
(14, '2024-05-31 00:00:00', 'Successfull', 'receipts/j2.png', 17),
(15, '2024-05-31 00:00:00', 'Successfull', 'receipts/email_us.png', 18),
(16, '2024-05-31 00:00:00', 'Successfull', 'receipts/catalogue.png', 19),
(17, '2024-05-31 00:00:00', 'Successfull', 'receipts/C1.png.png', 20),
(18, '2024-05-31 00:00:00', 'Successfull', 'receipts/j1.png', 21),
(19, '2024-05-31 00:00:00', 'Successfull', 'receipts/email_us.png', 22),
(20, '2024-05-31 00:00:00', 'Successfull', 'receipts/fuh.png', 23),
(21, '2024-05-31 00:00:00', 'Successfull', 'receipts/email_us.png', 24),
(22, '2024-05-31 00:00:00', 'Successfull', 'receipts/fp.png', 25),
(23, '2024-05-31 00:00:00', 'Successfull', 'receipts/j3.png', 26),
(24, '2024-06-23 00:00:00', 'Successfull', 'receipts/OIP.jpg', 27),
(25, '2024-06-23 00:00:00', 'Successfull', 'receipts/fp.png', 28),
(26, '2024-07-05 00:00:00', 'Successfull', 'receipts/Screenshot (11).png', 29),
(27, '2024-07-05 00:00:00', 'Successfull', 'receipts/Screenshot (23).png', 30),
(28, '2024-07-05 00:00:00', 'Successfull', 'receipts/Screenshot (13).png', 31),
(29, '2024-07-05 00:00:00', 'Successfull', 'receipts/Screenshot (15).png', 33),
(30, '2024-07-05 00:00:00', 'Successfull', 'receipts/Screenshot (13).png', 34);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`ADMIN_ID`), ADD UNIQUE KEY `ADMIN_EMAIL` (`ADMIN_EMAIL`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
 ADD PRIMARY KEY (`CART_ID`), ADD KEY `FK_CUS_ID` (`CUS_ID`), ADD KEY `FK_CLO_NUM` (`CLO_NUM`);

--
-- Indexes for table `clothes`
--
ALTER TABLE `clothes`
 ADD PRIMARY KEY (`CLO_NUM`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
 ADD PRIMARY KEY (`MESSAGE_ID`), ADD KEY `CUS_ID` (`CUS_ID`), ADD KEY `ADMIN_ID` (`ADMIN_ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`CUS_ID`), ADD UNIQUE KEY `CUS_EMAIL` (`CUS_EMAIL`);

--
-- Indexes for table `order_customer`
--
ALTER TABLE `order_customer`
 ADD PRIMARY KEY (`ORDER_ID`), ADD KEY `ADMIN_ID` (`ADMIN_ID`), ADD KEY `CUS_ID` (`CUS_ID`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
 ADD KEY `ORDER_ID` (`ORDER_ID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`PAY_NUM`), ADD KEY `ORDER_ID` (`ORDER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
MODIFY `CART_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=147;
--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
MODIFY `MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT for table `order_customer`
--
ALTER TABLE `order_customer`
MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `PAY_NUM` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
ADD CONSTRAINT `FK_CLO_NUM` FOREIGN KEY (`CLO_NUM`) REFERENCES `clothes` (`CLO_NUM`),
ADD CONSTRAINT `FK_CUS_ID` FOREIGN KEY (`CUS_ID`) REFERENCES `customer` (`CUS_ID`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`CUS_ID`) REFERENCES `customer` (`CUS_ID`),
ADD CONSTRAINT `contact_messages_ibfk_2` FOREIGN KEY (`ADMIN_ID`) REFERENCES `admin` (`ADMIN_ID`);

--
-- Constraints for table `order_customer`
--
ALTER TABLE `order_customer`
ADD CONSTRAINT `order_customer_ibfk_1` FOREIGN KEY (`ADMIN_ID`) REFERENCES `admin` (`ADMIN_ID`),
ADD CONSTRAINT `order_customer_ibfk_2` FOREIGN KEY (`CUS_ID`) REFERENCES `customer` (`CUS_ID`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `order_customer` (`ORDER_ID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `order_customer` (`ORDER_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
