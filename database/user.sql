-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 08 ก.ย. 2021 เมื่อ 09:33 AM
-- เวอร์ชันของเซิร์ฟเวอร์: 10.2.25-MariaDB-log
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plusdental_warehouse`
--

-- --------------------------------------------------------

--
-- โครงสร้างตาราง `user`
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
  `user_line` varchar(100) NOT NULL,
  `user_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- dump ตาราง `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_bn`, `user_lv`, `user_tel`, `user_prefix`, `user_fname`, `user_lname`, `user_line`, `user_img`) VALUES
(16, 'test1@gmail.com', '$2y$10$mMVgQ8eGPHSVDJsYskZIAuUwY914k0L8iGqjDrnRQ0toOQVIM2k7a', 1, 1, '082602362', 1, 'นายอรรถพล', 'สีชา', 'atthapol@line', ''),
(26, 'pinkza88@gmail.com', '$2y$10$ZTVlOj1moWpvfbPklprTeuRfef45Z8GIAHOSz2dx7UQ5SAQE9OcgW', 6, 4, '0828602362', 1, 'เจ้าหน้าที่', 'ไอที(เจ๋ง)', '0828602362', ''),
(31, 'plusdental.os@gmail.com', '$2y$10$wNFv/Zooqolca1P.Tr0WfOFxJe2ovx6pslkeiFg6YGQLfntKEJbsC', 7, 3, '', 1, 'วิรชัย', 'อั้นจุ้ย', '', ''),
(32, 'plusdental.on@gmail.com', '$2y$10$hxEKIn1Iib2yiBE7f7I5xe3Uf3fwq2LfLxpvW0zoJUYR4kHFRVOYW', 6, 1, '', 2, 'อาภาพร', 'สุดดาจันทร์', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
