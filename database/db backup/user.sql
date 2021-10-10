-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 10, 2021 at 12:26 AM
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
  `user_line` varchar(100) NOT NULL,
  `user_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`, `user_bn`, `user_lv`, `user_tel`, `user_prefix`, `user_fname`, `user_lname`, `user_line`, `user_img`) VALUES
(1, 'test1@gmail.com', '$2y$10$mMVgQ8eGPHSVDJsYskZIAuUwY914k0L8iGqjDrnRQ0toOQVIM2k7a', 3, 1, '082602362', 1, 'นายอรรถพล', 'สีชา', 'atthapol@line', ''),
(2, 'pinkza88@gmail.com', '$2y$10$ZTVlOj1moWpvfbPklprTeuRfef45Z8GIAHOSz2dx7UQ5SAQE9OcgW', 1, 4, '0828602362', 1, 'เจ้าหน้าที่', 'ไอที(เจ๋ง)', '0828602362', '12331.jpg'),
(3, 'plusdental.os@gmail.com', '$2y$10$07tizjbqFQ1E41KDsK6SWOtCwLf.YsMjRWwRZHD4QzRfsywVcFJqS', 10, 3, '', 1, 'วิรชัย', 'อั้นจุ้ย', '', ''),
(4, 'it@plusdentalclinic.com', '$2y$10$o8s2w5OkcAc0n1ZTQiwep.NtWso3808/7F/kxukj4BiLR44p2WwX2', 1, 4, '', 0, 'IT', 'plus', '', ''),
(5, 'wichit.t@plusdentalclinic.com', '$2y$10$LLZOEBUWFPUEOqIgEPcYJ.8E1r6svVbpV9vuBV4DvMeeqd7G1xjy.', 1, 3, '', 0, 'wichit', 'AM', '', ''),
(6, 'kamolwan.v@plusdentalclinic.com', '$2y$10$NdxqtIYmZ6Fl.trKKEb/t.HnWGgSwqIQWSEsyciKwg7RxQOEPm44i', 1, 3, '', 0, 'kamolwan', 'AM', '', ''),
(7, 'yothaka.c@plusdentalclinic.com', '$2y$10$BIvbNrk.ZHwR5V1enp0ChOOtEN9AdsAZg9wQ8kmk4R5/cgk6HoHr.', 1, 3, '', 0, 'yothaka', 'AM', '', ''),
(8, 'plusdental.ar@gmail.com', '$2y$10$eCJVx0TVJliojmgy804vrOxipNBl/w2b7Xp3rh6DSywgQ5Pdx1HE2', 3, 1, '', 0, 'อารีย์', 'AR', '', ''),
(9, 'plusdental.as@gmail.com', '$2y$10$9JjALPiFOAuDTwyRaEMT9O9xuSRGc06F6cQXwRuexqXpZ9ui1jnca', 5, 1, '', 0, 'อโศก', 'AS', '', ''),
(10, 'plusdental.lb@gmail.com', '$2y$10$fbSFsfK6YhfTOmZQR3mMteJ6ok94HiIbLLvxZg6jY4yCt5ScvtPtO', 11, 1, '', 0, 'ลาดกระบัง', 'LB ', '', ''),
(11, 'plusdental.nw@gmail.com', '$2y$10$40aKtqG6JpxE1/Yr1mW1Je5fN5KtVbg22/muzeIKSLDoiZiQtMSw2', 8, 1, '', 0, 'งามวงค์วาน', 'NW', '', ''),
(12, 'plusdental.on@gmail.com', '$2y$10$huoMYFOZaPy7vPeLg1G56uv4XwGzhNJHXmh36XNlje/YViJ0A334O', 6, 1, '', 0, 'อ่อนนุช', 'ON', '', ''),
(13, 'plusdental.ra@gmail.com', '$2y$10$zPt9cV/mDEmL7Ysc2mqtN.yQMO4bPOdzhn7Qq9d4IFOwRDrv1yZie', 2, 1, '', 0, 'รามคำแหง', 'RA', '', ''),
(14, 'plusdental.ra2@gmail.com', '$2y$10$LFF2FiMWhtByDajFZyXBnOvVlhf08SzayOpzRe/c3oOP7DoBhwSH6', 10, 1, '', 0, 'พระราม2', 'RA2', '', ''),
(15, 'plusdental.sn@gmail.com', '$2y$10$2i8qUSncntyPlKVS/znmO.P.xDOD0jD.KQ1I6DBmRHXnUGpgwt8xm', 4, 1, '', 0, 'สาทร', 'SN', '', ''),
(16, 'plusdental.ud@gmail.com', '$2y$10$UNQF0JS8.SkV/AwEJFpwUeev3udc11Tztw9Wt4uXlN6/bQYoYYSmC', 7, 1, '', 0, 'อุดมสุข', 'UD', '', ''),
(17, 'plusdental.cw@gmail.com', '$2y$10$zeHSOqb94BRfApKp4irKaeZqmVSI595SNsdOU8ybvTsr8M7t9SKBW', 9, 1, '', 0, 'แจ้งวัฒนะ', 'CW', '', ''),
(18, 'plusdental.bk@gmail.com', '$2y$10$pDxgaM4Pl6KpzVK8c6M0fOcusko/fVqjKtr/AKWtzd8Cf6ZMYltWC', 12, 1, '', 0, 'บางแค', 'BK', '', ''),
(19, 'ar.plusdental@gmail.com', '$2y$10$uJPHosHC3PzpMCt/dHemduV7QmNqUJyI/otsP2TzHYuALYxJdoEPS', 3, 2, '0632584678', 0, 'อารีย์', 'AR', '', ''),
(20, 'as.plusdental@gmail.com', '$2y$10$..zsaZdbId1U5ytf0GoMiugneMdPXdhS819frT11h50NkA9Z99ZnW', 5, 2, '0632584087', 0, 'อโศก', 'AS', '', ''),
(21, 'lb.plusdental@gmail.com', '$2y$10$w9vu6.vt20nKuNlBBlWgOOVYxXwkLQclPlT/bzYBMs10wSmXGlQJa', 11, 2, '0632582017', 0, 'ลาดกระบัง', 'LB', '', ''),
(22, 'nw.plusdental@gmail.com', '$2y$10$oxdzlIkK.pt6fXV8n5acfekDAO3NNl4EiJOxSpew8FtageuSrymLq', 8, 2, '0632610621 ', 0, 'งามวงศ์วาน', 'NW', '', ''),
(23, 'on.plusdental@gmail.com', '$2y$10$qpN.idc.MrIXyl92BV2YUeOxIuVWi/2z/nuKKk/.LRmzyC8ERuUQC', 6, 2, '0632582661', 0, 'อ่อนนุช', 'ON', '', ''),
(24, 'rm.plusdental@gmail.com', '$2y$10$uPhaxi3EOhb8kHEkYCBub.1BzHOFztb.cBZgmHvkdM.E63OFfNtLS', 2, 2, '0632580063', 0, 'รามคำแหง', 'RA', '', ''),
(25, 'sa.plusdental@gmail.com', '$2y$10$j0/ni2Vim6vTVd6NqziyxeNczA1WFz4FUUVRcXh29ELC.jyy2/q6.', 4, 2, '0632581251', 0, 'สาทร', 'SA', '', ''),
(26, 'ud.plusdental@gmail.com', '$2y$10$GDUrdCQeq6qFLdpJ6UWj1OfhU5TwsZyw.Hcn9K3oGXEaF1Qk.JAze', 7, 2, '0632582203', 0, 'อุดมสุข', 'UD', '', ''),
(27, 'cw.plusdental@gmail.com', '$2y$10$No93.U8zEt25/5g3bS72TuFAK2DPldk67agXAPzm1lOXucb4TIsWS', 9, 2, '0923107129', 0, 'แจ้งวัฒนะ', 'CW', '', ''),
(28, 'r2.plusdental@gmail.com', '$2y$10$aG72usVye57XkMPVAbxOve3UWckk667qwcDEgH0n71lpoadKY/k9C', 10, 2, '0923109212', 0, 'พระราม2', 'RA2', '', ''),
(29, 'bk.plusdental@gmail.com', '$2y$10$L5bsXg2yBp4t4hPZ/fLmAeJe7absJGe9/C/UxJuKxAzjKXnK6rs/2', 12, 2, '0923108164', 0, 'บางแค', 'BK', '', '');

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
