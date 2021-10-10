-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2021 at 12:33 AM
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
-- Table structure for table `marque`
--

CREATE TABLE `marque` (
  `marque_id` int(11) NOT NULL,
  `marque_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `marque`
--

INSERT INTO `marque` (`marque_id`, `marque_name`) VALUES
(1, 'ThaiBulk SMS'),
(2, ' BLACKBERRY'),
(3, 'CAMEL(คาเมล)'),
(4, 'Lenovo'),
(5, 'Huawei'),
(6, 'Acer'),
(7, 'XIAOMI'),
(8, 'Mitsubishi​ Econo '),
(9, 'Durr'),
(10, 'CTM'),
(11, 'NSK Prophy'),
(12, '3M / DKSH'),
(13, 'Orthobrite'),
(14, 'Ortholine'),
(15, 'NSK Panaair FX'),
(16, 'W&H'),
(17, 'NSK FX65'),
(18, 'W&H HE-43 '),
(19, 'NSK FX57'),
(20, 'NSK (คาดน้ำเงิน)'),
(21, 'NSK FX23'),
(22, 'WE-56 W&H'),
(23, 'AM-25 RM W&H'),
(24, 'NSK'),
(25, 'MONITEX'),
(26, 'SPEC 3'),
(27, 'Other'),
(28, 'Woodpacker'),
(29, 'B-Cure'),
(30, 'NSK VOLVERE i7'),
(31, 'Jeradent'),
(32, 'Watashi'),
(33, 'Strong'),
(34, 'ID Fast'),
(35, 'MATALL'),
(36, 'Vivadent'),
(37, 'portable X-ray system'),
(38, 'ยูไนเต็ด '),
(39, 'INTENSIV'),
(40, 'Worrex'),
(41, 'Fast ID'),
(42, 'koncept furniture');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`marque_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marque`
--
ALTER TABLE `marque`
  MODIFY `marque_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
