-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2021 at 12:34 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `vendor_id` int(11) NOT NULL,
  `vendor_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`vendor_id`, `vendor_name`) VALUES
(1, 'CTM'),
(2, 'QC PLUS'),
(3, 'Makro'),
(4, 'Big-C'),
(5, 'Lyreco'),
(6, '3M'),
(7, 'OWIRE'),
(8, 'ThaiBulk SMS'),
(9, 'เดอะ เด็นทอล ลีดเดอร์'),
(10, 'กระต่าย'),
(11, 'advice'),
(12, 'cameloutdoor.th'),
(13, 'LINK'),
(14, 'Dahua'),
(15, 'Western Digital'),
(16, 'LOGITECH'),
(17, 'Vention'),
(18, 'TP-LINK'),
(19, 'Xiaomi'),
(20, 'Xprinter'),
(21, 'Apple'),
(22, 'Intel'),
(23, 'AMD'),
(24, 'ACER'),
(25, 'Zircon'),
(26, 'BROTHER'),
(27, 'shopee'),
(28, 'lazada'),
(29, 'เศรษฐวุฒิ '),
(30, 'สมโชค Maerketing'),
(31, 'นูเด้น'),
(32, 'ACCORD'),
(33, 'SD ทันตเวช'),
(34, 'Kerr'),
(35, 'Eminance/NSK'),
(36, 'DKSH'),
(37, 'บริษัท เสนา'),
(38, 'Dent Mate'),
(39, '3M / DKSH'),
(40, 'DKSH/dentspy'),
(41, 'Unity'),
(42, 'ปาลิน'),
(43, 'เซี่ยงไฮ้'),
(44, 'คณะทันตแพทย์ จุฬา'),
(45, 'VRP Dent'),
(46, 'ทันตสยาม'),
(47, 'Lion Care'),
(48, 'alexpress'),
(49, 'DENTAL VISION'),
(50, 'DDI'),
(51, 'Bangkok Dental Supply'),
(52, 'Dentmate'),
(53, 'DDS'),
(54, 'Ortholine'),
(55, 'W&H'),
(56, 'Orthobrite'),
(57, 'Pacific'),
(58, 'ACCORD/ORTHO'),
(59, 'AOSC'),
(60, 'I Dew plus'),
(61, 'Dental Innovision'),
(62, 'OSSTEM'),
(63, 'NANA Ortho'),
(64, 'UDOM MEDICAL'),
(65, 'DKSH ปลา'),
(66, 'ชูมิต'),
(67, 'ดาร์ฟี่'),
(68, 'HOMEDENT'),
(69, 'Teego dental caer'),
(70, 'Deva'),
(71, 'SMS'),
(72, 'DKSH colgate'),
(73, 'โอสถอินเตอร์'),
(74, 'บ. ละมุนภัณฑ์'),
(75, 'aliexpress'),
(76, 'homepro'),
(77, 'dentalvision'),
(78, 'pipat'),
(79, 'koncept furniture');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
