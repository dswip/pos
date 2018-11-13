-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2018 at 06:36 AM
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
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(5) NOT NULL,
  `member_id` int(4) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `category` int(3) NOT NULL,
  `manufacture` int(4) NOT NULL,
  `name` varchar(100) NOT NULL,
  `model` text NOT NULL,
  `permalink` varchar(300) NOT NULL,
  `currency` varchar(25) NOT NULL,
  `description` text,
  `price` decimal(9,0) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `url_upload` int(1) NOT NULL,
  `url1` text,
  `url2` text,
  `url3` text,
  `url4` text,
  `url5` text,
  `publish` int(1) NOT NULL DEFAULT '0',
  `weight` varchar(10) NOT NULL,
  `related` text,
  `discount` decimal(6,0) NOT NULL,
  `min_order` int(3) NOT NULL,
  `color` varchar(50) NOT NULL,
  `size` varchar(50) NOT NULL,
  `unit` varchar(25) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `member_id`, `sku`, `category`, `manufacture`, `name`, `model`, `permalink`, `currency`, `description`, `price`, `image`, `url_upload`, `url1`, `url2`, `url3`, `url4`, `url5`, `publish`, `weight`, `related`, `discount`, `min_order`, `color`, `size`, `unit`, `created`, `deleted`, `updated`) VALUES
(9825, 0, '410302010316', 83, 2, 'fg22 gold wayang  jf', 'FG22 GOLD WAYANG  JF', 'fg22-gold-wayang-jf', 'idr', NULL, '0', NULL, 0, NULL, NULL, NULL, NULL, NULL, 1, '', NULL, '0', 0, '', '', '', '2018-06-21 15:43:15', NULL, '2018-06-21 15:43:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9826;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
