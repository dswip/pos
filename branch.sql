-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2018 at 07:38 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

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
-- Table structure for table `branch`
--

CREATE TABLE `branch` (
  `id` int(3) NOT NULL,
  `member_id` int(5) NOT NULL,
  `code` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(50) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `city` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `publish` smallint(1) NOT NULL,
  `defaults` smallint(1) NOT NULL,
  `sales_account` int(3) NOT NULL,
  `stock_account` int(3) NOT NULL,
  `unit_cost_account` int(3) NOT NULL,
  `ar_account` int(3) NOT NULL,
  `bank_account` int(3) NOT NULL,
  `cash_account` int(3) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `member_id`, `code`, `name`, `address`, `phone`, `mobile`, `email`, `city`, `zip`, `image`, `publish`, `defaults`, `sales_account`, `stock_account`, `unit_cost_account`, `ar_account`, `bank_account`, `cash_account`, `updated`, `deleted`, `created`) VALUES
(1, 0, 'SJS53', 'sejahtera sports', 'Jalan Palangkaraya No. 53', '061-4159053', '082160716888', 'sejahterasports@gmail.com', 'Medan', '20212', NULL, 1, 1, 8, 8, 8, 8, 8, 8, '2017-10-13 08:51:38', NULL, '2017-08-12 09:40:09'),
(2, 0, 'MS', 'makmur', 'JL. Palangkaraya No.125', '061 4535220', '061 4535220', 'none@none.com', 'Medan', '20212', NULL, 1, 0, 300, 28, 32, 191, 53, 24, '2017-09-30 10:24:30', NULL, '2017-09-30 10:24:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branch`
--
ALTER TABLE `branch`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branch`
--
ALTER TABLE `branch`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
