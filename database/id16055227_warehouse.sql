-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: 02 ส.ค. 2021 เมื่อ 02:26 AM
-- เวอร์ชันของเซิร์ฟเวอร์: 10.3.16-MariaDB
-- PHP Version: 7.3.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id16055227_warehouse`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `branch`
--

CREATE TABLE `branch` (
  `id_bn` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `branch`
--

INSERT INTO `branch` (`id_bn`, `branch_name`) VALUES
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
-- โครงสร้างตาราง `branch_stock`
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
-- โครงสร้างตาราง `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL,
  `price_stock` decimal(10,2) NOT NULL,
  `code_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `unit`, `price_stock`, `code_item`) VALUES
(55, 'รีทินเนอร์', 36, 0.00, 0),
(56, 'กาแฟ', 33, 0.00, 0),
(57, 'แก้วกระดาษ', 33, 0.00, 0),
(58, 'รีทินเนอร์', 34, 99.99, 12345678);

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `stock`
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
-- โครงสร้างตาราง `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES
(33, 'กล่อง'),
(34, 'อัน'),
(35, 'ชิ้น');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id_bn`);

--
-- Indexes for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD PRIMARY KEY (`id_branch`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `code_item` (`code_item`),
  ADD KEY `unit` (`unit`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
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
  ADD PRIMARY KEY (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id_bn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `branch_stock`
--
ALTER TABLE `branch_stock`
  MODIFY `id_branch` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD CONSTRAINT `branch_stock_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id_bn`),
  ADD CONSTRAINT `branch_stock_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `stock` (`id_stock`),
  ADD CONSTRAINT `branch_stock_ibfk_3` FOREIGN KEY (`unit`) REFERENCES `unit` (`unit_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`unit`) REFERENCES `unit` (`unit_id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`code_item`) REFERENCES `item` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
