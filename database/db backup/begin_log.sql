-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2021 at 03:29 AM
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
-- Table structure for table `begin_log`
--

CREATE TABLE `begin_log` (
  `begin_id` int(11) NOT NULL,
  `date_begin` date NOT NULL,
  `stock_begin` varchar(100) NOT NULL,
  `cn` int(11) NOT NULL,
  `ra` int(11) NOT NULL,
  `ar` int(11) NOT NULL,
  `sa` int(11) NOT NULL,
  `as` int(11) NOT NULL,
  `on` int(11) NOT NULL,
  `ud` int(11) NOT NULL,
  `nw` int(11) NOT NULL,
  `cw` int(11) NOT NULL,
  `r2` int(11) NOT NULL,
  `lb` int(11) NOT NULL,
  `bk` int(11) NOT NULL,
  `hq` int(11) NOT NULL,
  `sum_begin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `begin_log`
--
ALTER TABLE `begin_log`
  ADD PRIMARY KEY (`begin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `begin_log`
--
ALTER TABLE `begin_log`
  MODIFY `begin_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
