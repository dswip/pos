-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2018 at 06:35 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `untungdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `code` varchar(15) NOT NULL,
  `desc` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `code`, `desc`, `created`, `updated`, `deleted`) VALUES
(1, 'pieces', 'Pcs', '', NULL, NULL, NULL),
(2, 'Lusin', 'Lsn', '', NULL, NULL, NULL),
(3, 'Meter2', 'm2', '', NULL, NULL, NULL),
(4, 'Kaleng', 'klg', '', NULL, NULL, NULL),
(5, 'Liter', 'Ltr', '', NULL, NULL, NULL),
(6, 'Roll', 'Roll', '', NULL, NULL, NULL),
(7, 'Kg', 'Kg', '', NULL, NULL, NULL),
(8, 'Lbr', 'Lbr', '', NULL, NULL, NULL),
(9, 'Tabung', 'Tbg', '', NULL, NULL, NULL),
(10, 'Bh', 'Bh', '', NULL, NULL, NULL),
(11, 'Ktk', 'Ktk', '', NULL, NULL, NULL),
(12, 'batang', 'Btg', '', NULL, '2017-06-30 11:36:58', NULL),
(13, 'Meter 3', 'm3', '', NULL, NULL, NULL),
(14, 'Set', 'Set', '', NULL, NULL, NULL),
(15, 'Zak', 'Zak', '', NULL, NULL, NULL),
(16, 'Botol', 'Btl', '', NULL, NULL, NULL),
(17, 'Bungkus', 'Bks', '', NULL, NULL, NULL),
(18, 'Keping', 'Kpg', '', NULL, NULL, NULL),
(19, 'Blok', 'Blok', '', NULL, NULL, NULL),
(20, 'Meter', 'M', '', NULL, NULL, NULL),
(21, 'Unit', 'unit', '', NULL, NULL, NULL),
(22, 'Tin', 'Tin', '', NULL, NULL, NULL),
(27, 'pair', 'PAIR', 'desc', '2017-06-30 11:36:16', NULL, NULL),
(24, 'Pick Up', 'Pcu', 'Mobil Pickup', NULL, NULL, NULL),
(25, 'Truck', 'Tck', 'MObil Truck', NULL, NULL, NULL),
(26, 'Karung', 'Krg', 'Karung', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
