-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 10:10 PM
-- Server version: 10.1.38-MariaDB
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
-- Database: `datamining`
--

-- --------------------------------------------------------

--
-- Table structure for table `upload_data`
--

CREATE TABLE `upload_data` (
  `bahan_baku` varchar(50) NOT NULL,
  `jan` int(20) NOT NULL,
  `feb` int(20) NOT NULL,
  `mart` int(20) NOT NULL,
  `apr` int(20) NOT NULL,
  `mei` int(20) NOT NULL,
  `jun` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `upload_data`
--

INSERT INTO `upload_data` (`bahan_baku`, `jan`, `feb`, `mart`, `apr`, `mei`, `jun`) VALUES
('Ayam', 15587, 14251, 13782, 14136, 14832, 14626),
('Fillet dada ayam', 369, 304, 339, 348, 339, 375),
('Gepuk', 4655, 4178, 4111, 4282, 4193, 4157),
('Ikan gurame', 793, 623, 810, 785, 659, 687),
('Ikan mas', 1458, 1372, 1396, 1319, 1437, 1452),
('Ikan nila', 1059, 918, 940, 938, 910, 951),
('Kerupuk', 583, 610, 805, 575, 673, 699),
('Oncom', 5697, 5358, 5222, 5064, 5669, 5550),
('Sayur asem', 412, 373, 393, 364, 409, 431),
('Tahu', 180, 213, 194, 181, 224, 219),
('Telor', 528, 521, 648, 557, 571, 571),
('Tempe', 162, 157, 165, 155, 164, 167),
('Wingko', 1397, 1175, 1173, 1197, 1240, 1228);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','management') NOT NULL DEFAULT 'management'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(2, 'kepin', '4799f23aeada2befa8cbc7f296c89d36', 'management');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `upload_data`
--
ALTER TABLE `upload_data`
  ADD PRIMARY KEY (`bahan_baku`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
