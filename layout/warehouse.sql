-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2021 at 12:46 PM
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
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id_branchs` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id_branchs`, `branch_name`) VALUES
(1, 'อโศก'),
(2, 'แจ้งวัฒนะ'),
(3, 'อารีย์'),
(4, 'อ่อนนุช'),
(5, 'สาทร'),
(6, 'งามวงค์วาน'),
(7, 'ลาดกระบัง'),
(8, 'อุดมสุข');

-- --------------------------------------------------------

--
-- Table structure for table `branch_stock`
--

CREATE TABLE `branch_stock` (
  `id_branch` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `code_item` int(11) NOT NULL,
  `inventories` int(11) NOT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `center_stock`
--

CREATE TABLE `center_stock` (
  `id_center` int(11) NOT NULL,
  `code_item` int(11) NOT NULL,
  `inventories` int(11) NOT NULL,
  `unit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `id_item` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`id_item`, `item_name`, `unit`) VALUES
(55, 'รีทินเนอร์', 36),
(56, 'กาแฟ', 33),
(57, 'แก้วกระดาษ', 33);

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL,
  `order_f` varchar(100) NOT NULL,
  `prict_stock` decimal(10,2) NOT NULL,
  `unit` int(10) NOT NULL,
  `code_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `unit_name`) VALUES
(33, 'กล่อง'),
(34, 'อัน'),
(35, 'ชิ้น'),
(36, 'แท่ง');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id_branchs`);

--
-- Indexes for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD PRIMARY KEY (`id_branch`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `code_item` (`code_item`),
  ADD KEY `unit` (`unit`);

--
-- Indexes for table `center_stock`
--
ALTER TABLE `center_stock`
  ADD PRIMARY KEY (`id_center`),
  ADD KEY `code_item` (`code_item`),
  ADD KEY `unit` (`unit`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `unit` (`unit`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id_stock`),
  ADD UNIQUE KEY `unit` (`unit`),
  ADD KEY `code_item` (`code_item`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id_branchs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `branch_stock`
--
ALTER TABLE `branch_stock`
  MODIFY `id_branch` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `center_stock`
--
ALTER TABLE `center_stock`
  MODIFY `id_center` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD CONSTRAINT `branch_stock_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id_branchs`),
  ADD CONSTRAINT `branch_stock_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `stock` (`id_stock`),
  ADD CONSTRAINT `branch_stock_ibfk_3` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`);

--
-- Constraints for table `center_stock`
--
ALTER TABLE `center_stock`
  ADD CONSTRAINT `center_stock_ibfk_1` FOREIGN KEY (`code_item`) REFERENCES `stock` (`id_stock`),
  ADD CONSTRAINT `center_stock_ibfk_2` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `unit` (`id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `item` (`id_item`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
