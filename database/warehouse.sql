-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2021 at 05:49 PM
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
  `bn_id` int(11) NOT NULL,
  `bn_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`bn_id`, `bn_name`) VALUES
(1, 'ส่วนกลาง'),
(2, 'อารีย์'),
(3, 'อุดมสุข'),
(4, 'อโศก'),
(5, 'สาทร'),
(6, 'อ่อนนุช'),
(7, 'ลาดกระบัง'),
(8, 'งามวงค์วาน'),
(9, 'แจ้งวัฒนะ'),
(10, 'บางแค'),
(11, 'พระราม2'),
(12, 'รามคําแหง');

-- --------------------------------------------------------

--
-- Table structure for table `branch_stock`
--

CREATE TABLE `branch_stock` (
  `full_stock_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `exd_date` date NOT NULL,
  `bn_stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `catagories`
--

CREATE TABLE `catagories` (
  `catagories_id` int(11) NOT NULL,
  `catagories_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catagories`
--

INSERT INTO `catagories` (`catagories_id`, `catagories_name`) VALUES
(1, 'Supplies \r\n'),
(2, 'Genaral\r\n'),
(3, 'Ortho\r\n'),
(4, 'Surgical\r\n'),
(5, 'Endo\r\n'),
(6, 'Prosth\r\n'),
(7, 'Medical/Goods\r\n'),
(8, 'หัวเบอร์\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `unit` int(11) NOT NULL,
  `price_stock` decimal(10,2) NOT NULL,
  `code_item` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `unit`, `price_stock`, `code_item`) VALUES
(3, 'แก้วกระดาษ', 2, '50.00', 111111),
(4, 'ถังน้ำ', 1, '60.00', 123457),
(5, 'กาแฟ-ดำ', 2, '20.55', 131313),
(8, 'ซอส-ภูเขา', 1, '50.00', 456789),
(9, 'แก้วกระดาษ(จับโบ้)', 2, '50.00', 456719),
(10, 'รีทินเนอร์(แดง)', 1, '50.00', 110101),
(11, 'ถังน้ำ(แดง)', 2, '50.00', 123123),
(12, 'กาแฟ(ไทย-ลาว)', 1, '50.00', 554466),
(13, 'กาแฟ++', 1, '50.00', 123445),
(14, 'เมจิก(น้ำเงิน)', 1, '125.75', 852147);

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`level_id`, `level_name`) VALUES
(1, 'พนักงาน(Plus Dental Clinic)'),
(2, 'ผู้จัดการสาขา'),
(3, 'ผู้จัดการเขต'),
(4, 'แอดมิน');

-- --------------------------------------------------------

--
-- Table structure for table `line`
--

CREATE TABLE `line` (
  `line_id` int(11) NOT NULL,
  `line_group` varchar(100) NOT NULL,
  `line_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prefix`
--

CREATE TABLE `prefix` (
  `prefix_id` int(11) NOT NULL,
  `prefix_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `prefix`
--

INSERT INTO `prefix` (`prefix_id`, `prefix_name`) VALUES
(1, 'นาย'),
(2, 'นาง'),
(3, 'นางสาว');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `stock_id` int(11) NOT NULL,
  `vendor` int(11) NOT NULL,
  `unit` int(10) NOT NULL,
  `item_id` int(11) NOT NULL,
  `type_item` int(11) NOT NULL,
  `type_catagories` int(11) NOT NULL,
  `img_stock` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`stock_id`, `vendor`, `unit`, `item_id`, `type_item`, `type_catagories`, `img_stock`) VALUES
(31, 1, 2, 3, 1, 1, ''),
(32, 2, 1, 4, 2, 2, ''),
(33, 4, 2, 5, 3, 3, ''),
(34, 3, 1, 8, 4, 5, ''),
(35, 4, 2, 9, 3, 4, ''),
(36, 1, 1, 10, 4, 5, ''),
(37, 3, 2, 11, 3, 4, ''),
(40, 2, 1, 14, 4, 6, '123.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `type_name`
--

CREATE TABLE `type_name` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type_name`
--

INSERT INTO `type_name` (`type_id`, `type_name`) VALUES
(1, 'Large equipment (อุปกรณ์ใหญ่)'),
(2, 'Material (ของใช้) \r\n'),
(3, 'Equipment (เครื่องมือ) \r\n'),
(4, 'Medical (ยาเวชภัณฑ์)\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `unit_id` int(11) NOT NULL,
  `unit_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`unit_id`, `unit_name`) VALUES
(1, 'กล่อง'),
(2, 'อัน'),
(3, 'แท่ง');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `user_bn` int(11) NOT NULL,
  `user_lv` int(11) NOT NULL,
  `user_tel` varchar(20) NOT NULL,
  `user_prefix` int(11) NOT NULL,
  `user_fname` varchar(100) NOT NULL,
  `user_lname` varchar(100) NOT NULL,
  `user_line` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_bn`, `user_lv`, `user_tel`, `user_prefix`, `user_fname`, `user_lname`, `user_line`) VALUES
(16, 'test1@gmail.com', '$2y$10$mMVgQ8eGPHSVDJsYskZIAuUwY914k0L8iGqjDrnRQ0toOQVIM2k7a', 1, 1, '08xxxxxxx', 1, 'นายอรรถพล', 'สีชา', '@line'),
(17, 'test2@gmail.com', '$2y$10$ZTVlOj1moWpvfbPklprTeuRfef45Z8GIAHOSz2dx7UQ5SAQE9OcgW', 1, 2, '08xxxxxxx', 1, 'xxx', 'xxx', '@line'),
(18, 'test3@gmail.com', '$2y$10$4cARNEyLhJ/gZRwmP0IFZOWDZXpJCsslF5SJyTxGujBLPE4ovqhsq', 4, 3, '08xxxxxxx', 1, 'xxx', 'xxx', '@line'),
(26, 'test4@gmail.com', '$2y$10$s.jKx.NLyF.Y38HSqeHxQur8ougH39UlAm86crCkL.DT6g6/.XIoK', 11, 4, '08xxxxxxx', 1, 'test', '4', '@line'),
(27, 'test_A.1@gmail.com', '$2y$10$1si5eHc/xTEErV0ZhzRQi.qSR6re.CibMGRrlZeHiscCAgUCOkjzy', 10, 1, '08xxxxxxx', 2, 'test', 'test', '@line'),
(28, 'test_A.2@gmail.com', '$2y$10$NaH9MNQHnkDh.duR.bcfOelbXpfUtg6MfhXUgLyXKPJrJZvtNJTle', 10, 2, '08xxxxxxx', 3, 'test', 'test', '@line'),
(29, 'test_A.3@gmail.com', '$2y$10$86ArcBx1ml3QI96qa7Vya.h.rAcXiQvv8QQaCrY4XEuq9b09k.mTe', 10, 1, '08xxxxxxx', 3, 'test', 'test', '@line');

-- --------------------------------------------------------

--
-- Table structure for table `user_stock`
--

CREATE TABLE `user_stock` (
  `user_stock_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code_item` int(11) NOT NULL,
  `full_stock_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(1, 'นรงค์ศักดิ์'),
(2, 'อนงค์'),
(3, 'ชาติชาย'),
(4, 'สมหมาย');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`bn_id`);

--
-- Indexes for table `branch_stock`
--
ALTER TABLE `branch_stock`
  ADD PRIMARY KEY (`full_stock_id`);

--
-- Indexes for table `catagories`
--
ALTER TABLE `catagories`
  ADD PRIMARY KEY (`catagories_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `code_item` (`code_item`);

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `line`
--
ALTER TABLE `line`
  ADD PRIMARY KEY (`line_id`);

--
-- Indexes for table `prefix`
--
ALTER TABLE `prefix`
  ADD PRIMARY KEY (`prefix_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `type_name`
--
ALTER TABLE `type_name`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_stock`
--
ALTER TABLE `user_stock`
  ADD PRIMARY KEY (`user_stock_id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`vendor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `bn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `branch_stock`
--
ALTER TABLE `branch_stock`
  MODIFY `full_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catagories`
--
ALTER TABLE `catagories`
  MODIFY `catagories_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `line`
--
ALTER TABLE `line`
  MODIFY `line_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prefix`
--
ALTER TABLE `prefix`
  MODIFY `prefix_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `type_name`
--
ALTER TABLE `type_name`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `user_stock`
--
ALTER TABLE `user_stock`
  MODIFY `user_stock_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
