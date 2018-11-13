-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 24, 2018 at 02:06 AM
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
-- Table structure for table `manufacture`
--

CREATE TABLE `manufacture` (
  `id` int(5) NOT NULL,
  `member_id` int(5) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `orders` int(2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `deleted` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacture`
--

INSERT INTO `manufacture` (`id`, `member_id`, `name`, `image`, `orders`, `created`, `deleted`, `updated`) VALUES
(1, 0, 'molten', NULL, 1, '2017-08-12 09:41:54', NULL, NULL),
(2, 0, 'abc', NULL, 1, '2017-09-07 10:49:52', NULL, NULL),
(3, 0, 'acme', NULL, 1, '2017-09-07 10:50:01', NULL, NULL),
(4, 0, 'add', NULL, 1, '2017-09-07 10:50:08', NULL, NULL),
(5, 0, 'addoy\\tamasu', NULL, 1, '2017-09-07 10:50:21', NULL, NULL),
(6, 0, 'adtess\\uk', NULL, 1, '2017-09-07 10:50:58', NULL, NULL),
(7, 0, 'agasi', NULL, 1, '2017-09-07 10:51:06', NULL, NULL),
(8, 0, 'amiya', NULL, 1, '2017-09-07 10:51:13', NULL, NULL),
(9, 0, 'apachem', NULL, 1, '2017-09-07 10:51:20', NULL, NULL),
(10, 0, 'aria', NULL, 1, '2017-09-07 10:51:27', NULL, NULL),
(11, 0, 'ascot', NULL, 1, '2017-09-07 10:51:37', NULL, NULL),
(12, 0, 'atlete', NULL, 1, '2017-09-07 10:51:44', NULL, NULL),
(13, 0, 'atp tour', NULL, 1, '2017-09-07 10:51:52', NULL, NULL),
(14, 0, 'b.becker', NULL, 1, '2017-09-07 10:51:58', NULL, NULL),
(15, 0, 'babolat', NULL, 1, '2017-09-07 10:52:20', NULL, NULL),
(16, 0, 'benyamin', NULL, 1, '2017-09-07 10:52:26', NULL, NULL),
(17, 0, 'bike 9', NULL, 1, '2017-09-07 10:52:34', NULL, NULL),
(18, 0, 'bike 9b', NULL, 1, '2017-09-07 10:52:39', NULL, NULL),
(19, 0, 'bola mas', NULL, 1, '2017-09-07 10:52:45', NULL, NULL),
(20, 0, 'boron', NULL, 1, '2017-09-07 10:52:52', NULL, NULL),
(21, 0, 'butterfly', NULL, 1, '2017-09-07 10:52:59', NULL, NULL),
(22, 0, 'calci', NULL, 1, '2017-09-07 10:53:06', NULL, NULL),
(23, 0, 'canon', NULL, 1, '2017-09-07 10:53:12', NULL, NULL),
(24, 0, 'carlos', NULL, 1, '2017-09-07 10:53:22', NULL, NULL),
(25, 0, 'champion', NULL, 1, '2017-09-07 10:53:29', NULL, NULL),
(26, 0, 'comp', NULL, 1, '2017-09-07 10:53:35', NULL, NULL),
(27, 0, 'd.fish', NULL, 1, '2017-09-07 10:53:40', NULL, NULL),
(28, 0, 'd.happiness', NULL, 1, '2017-09-07 10:53:47', NULL, NULL),
(29, 0, 'diabolo', NULL, 1, '2017-09-07 10:53:53', NULL, NULL),
(30, 0, 'diadora', NULL, 1, '2017-09-07 10:53:59', NULL, NULL),
(31, 0, 'diamond', NULL, 1, '2017-09-07 10:54:06', NULL, NULL),
(32, 0, 'diana', NULL, 1, '2017-09-07 10:54:12', NULL, NULL),
(33, 0, 'digital', NULL, 1, '2017-09-07 10:54:18', NULL, NULL),
(34, 0, 'dunlop', NULL, 1, '2017-09-07 10:54:24', NULL, NULL),
(35, 0, 'eagle', NULL, 1, '2017-09-07 10:54:31', NULL, NULL),
(36, 0, 'euro', NULL, 1, '2017-09-07 10:54:37', NULL, NULL),
(37, 0, 'fans', NULL, 1, '2017-09-07 10:55:02', NULL, NULL),
(38, 0, 'fbt', NULL, 1, '2017-09-07 10:55:09', NULL, NULL),
(39, 0, 'fender', NULL, 1, '2017-09-07 10:55:15', NULL, NULL),
(40, 0, 'force speed', NULL, 1, '2017-09-07 10:55:21', NULL, NULL),
(41, 0, 'forki', NULL, 1, '2017-09-07 10:55:27', NULL, NULL),
(42, 0, 'fox', NULL, 1, '2017-09-07 10:55:33', NULL, NULL),
(43, 0, 'g.cup', NULL, 1, '2017-09-07 10:55:39', NULL, NULL),
(44, 0, 'g.t.o', NULL, 1, '2017-09-07 10:55:46', NULL, NULL),
(45, 0, 'g.win', NULL, 1, '2017-09-07 10:56:07', NULL, NULL),
(46, 0, 'gajah mada', NULL, 1, '2017-09-07 10:56:14', NULL, NULL),
(47, 0, 'gambar', NULL, 1, '2017-09-07 10:56:26', NULL, NULL),
(48, 0, 'garpo', NULL, 1, '2017-09-07 10:56:32', NULL, NULL),
(49, 0, 'garuda', NULL, 1, '2017-09-07 10:56:37', NULL, NULL),
(50, 0, 'gay', NULL, 1, '2017-09-07 10:56:42', NULL, NULL),
(51, 0, 'golf calaway', NULL, 1, '2017-09-07 10:56:48', NULL, NULL),
(52, 0, 'gosen', NULL, 1, '2017-09-07 10:56:52', NULL, NULL),
(53, 0, 'hamster', NULL, 1, '2017-09-07 10:56:58', NULL, NULL),
(54, 0, 'hb', NULL, 1, '2017-09-07 10:57:03', NULL, NULL),
(55, 0, 'hb\\fitness', NULL, 1, '2017-09-07 10:57:09', NULL, NULL),
(56, 0, 'head', NULL, 1, '2017-09-07 10:57:15', NULL, NULL),
(57, 0, 'hit', NULL, 1, '2017-09-07 10:57:20', NULL, NULL),
(58, 0, 'hit 88', NULL, 1, '2017-09-07 10:57:27', NULL, NULL),
(59, 0, 'hq', NULL, 1, '2017-09-07 10:57:34', NULL, NULL),
(60, 0, 'hunter', NULL, 1, '2017-09-07 10:57:43', NULL, NULL),
(61, 0, 'ipsi', NULL, 1, '2017-09-07 10:57:49', NULL, NULL),
(62, 0, 'isuzu', NULL, 1, '2017-09-07 10:57:55', NULL, NULL),
(63, 0, 'j-rope', NULL, 1, '2017-09-07 10:58:01', NULL, NULL),
(64, 0, 'kapok', NULL, 1, '2017-09-07 10:58:38', NULL, NULL),
(65, 0, 'kei shin kan', NULL, 1, '2017-09-07 10:58:43', NULL, NULL),
(66, 0, 'kki', NULL, 1, '2017-09-07 10:58:48', NULL, NULL),
(67, 0, 'kota medan', NULL, 1, '2017-09-07 10:58:53', NULL, NULL),
(68, 0, 'lemkari', NULL, 1, '2017-09-07 10:59:02', NULL, NULL),
(69, 0, 'lion', NULL, 1, '2017-09-07 10:59:10', NULL, NULL),
(70, 0, 'logo', NULL, 1, '2017-09-07 10:59:15', NULL, NULL),
(71, 0, 'lorenza', NULL, 1, '2017-09-07 10:59:22', NULL, NULL),
(72, 0, 'maestro', NULL, 1, '2017-09-07 10:59:27', NULL, NULL),
(73, 0, 'maestro\\kappa', NULL, 1, '2017-09-07 10:59:34', NULL, NULL),
(74, 0, 'maraton', NULL, 1, '2017-09-07 10:59:40', NULL, NULL),
(75, 0, 'master', NULL, 1, '2017-09-07 10:59:46', NULL, NULL),
(76, 0, 'md', NULL, 1, '2017-09-07 10:59:55', NULL, NULL),
(77, 0, 'melody', NULL, 1, '2017-09-07 11:00:00', NULL, NULL),
(78, 0, 'mikasa', NULL, 1, '2017-09-07 11:00:08', NULL, NULL),
(79, 0, 'millenium', NULL, 1, '2017-09-07 11:00:19', NULL, NULL),
(80, 0, 'moris', NULL, 1, '2017-09-07 11:00:35', NULL, NULL),
(81, 0, 'mtc', NULL, 1, '2017-09-07 11:00:45', NULL, NULL),
(82, 0, 'muscle hyper', NULL, 1, '2017-09-07 11:00:52', NULL, NULL),
(83, 0, 'mz', NULL, 1, '2017-09-07 11:00:59', NULL, NULL),
(84, 0, 'nassau', NULL, 1, '2017-09-07 11:01:04', NULL, NULL),
(85, 0, 'newstyle', NULL, 1, '2017-09-07 11:01:10', NULL, NULL),
(86, 0, 'nike', NULL, 1, '2017-09-07 11:01:17', NULL, NULL),
(87, 0, 'nikita', NULL, 1, '2017-09-07 11:01:30', NULL, NULL),
(88, 0, 'nine stars', NULL, 1, '2017-09-07 11:01:40', NULL, NULL),
(89, 0, 'nitaku', NULL, 1, '2017-09-07 11:01:47', NULL, NULL),
(90, 0, 'olympic', NULL, 1, '2017-09-07 11:01:53', NULL, NULL),
(91, 0, 'panda', NULL, 1, '2017-09-07 11:02:04', NULL, NULL),
(92, 0, 'panitia', NULL, 1, '2017-09-07 11:02:09', NULL, NULL),
(93, 0, 'panther', NULL, 1, '2017-09-07 11:02:15', NULL, NULL),
(94, 0, 'paramount', NULL, 1, '2017-09-07 11:02:22', NULL, NULL),
(95, 0, 'perguruan', NULL, 1, '2017-09-07 11:02:28', NULL, NULL),
(96, 0, 'petrillo\\proteam', NULL, 1, '2017-09-07 11:02:37', NULL, NULL),
(97, 0, 'pinbo', NULL, 1, '2017-09-07 11:02:44', NULL, NULL),
(98, 0, 'prasida', NULL, 1, '2017-09-07 11:02:50', NULL, NULL),
(99, 0, 'prince', NULL, 1, '2017-09-07 11:02:57', NULL, NULL),
(100, 0, 'pro ace', NULL, 1, '2017-09-07 11:03:03', NULL, NULL),
(101, 0, 'proffessional', NULL, 1, '2017-09-07 11:03:10', NULL, NULL),
(102, 0, 'prokennex', NULL, 1, '2017-09-07 11:03:16', NULL, NULL),
(103, 0, 'pyramid', NULL, 1, '2017-09-07 11:03:22', NULL, NULL),
(104, 0, 'rbk', NULL, 1, '2017-09-07 11:03:31', NULL, NULL),
(105, 0, 'reductor', NULL, 1, '2017-09-07 11:03:39', NULL, NULL),
(106, 0, 'remora', NULL, 1, '2017-09-07 11:03:45', NULL, NULL),
(107, 0, 'ronvil', NULL, 1, '2017-09-07 11:03:50', NULL, NULL),
(108, 0, 'rox', NULL, 1, '2017-09-07 11:03:56', NULL, NULL),
(109, 0, 'rrc', NULL, 1, '2017-09-07 11:04:02', NULL, NULL),
(110, 0, 'sakura', NULL, 1, '2017-09-07 11:04:17', NULL, NULL),
(111, 0, 'samba', NULL, 1, '2017-09-07 11:04:47', NULL, NULL),
(112, 0, 'seiko', NULL, 1, '2017-09-07 11:04:54', NULL, NULL),
(113, 0, 'seton', NULL, 1, '2017-09-07 11:05:07', NULL, NULL),
(114, 0, 'sharp', NULL, 1, '2017-09-07 11:05:13', NULL, NULL),
(115, 0, 'shield', NULL, 1, '2017-09-07 11:05:20', NULL, NULL),
(116, 0, 'shiroite', NULL, 1, '2017-09-07 11:05:27', NULL, NULL),
(117, 0, 'spec', NULL, 1, '2017-09-07 11:05:36', NULL, NULL),
(118, 0, 'speed', NULL, 1, '2017-09-07 11:05:45', NULL, NULL),
(119, 0, 'speedman', NULL, 1, '2017-09-07 11:05:52', NULL, NULL),
(120, 0, 'speedo', NULL, 1, '2017-09-07 11:05:57', NULL, NULL),
(121, 0, 'sport 8301', NULL, 1, '2017-09-07 11:06:03', NULL, NULL),
(122, 0, 'spotec', NULL, 1, '2017-09-07 11:06:09', NULL, NULL),
(123, 0, 'spotty', NULL, 1, '2017-09-07 11:06:15', NULL, NULL),
(124, 0, 'stedman', NULL, 1, '2017-09-07 11:06:34', NULL, NULL),
(125, 0, 'superpoint', NULL, 1, '2017-09-07 11:06:40', NULL, NULL),
(126, 0, 'supra', NULL, 1, '2017-09-07 11:06:46', NULL, NULL),
(127, 0, 'suzuki', NULL, 1, '2017-09-07 11:06:52', NULL, NULL),
(128, 0, 'swimmer 105', NULL, 1, '2017-09-07 11:06:58', NULL, NULL),
(129, 0, 'tako', NULL, 1, '2017-09-07 11:07:04', NULL, NULL),
(130, 0, 'target', NULL, 1, '2017-09-07 11:07:11', NULL, NULL),
(131, 0, 'tora2', NULL, 1, '2017-09-07 11:07:16', NULL, NULL),
(132, 0, 'ultrateck', NULL, 1, '2017-09-07 11:07:23', NULL, NULL),
(133, 0, 'umbro', NULL, 1, '2017-09-07 11:07:29', NULL, NULL),
(134, 0, 'usa', NULL, 1, '2017-09-07 11:07:35', NULL, NULL),
(135, 0, 'victory', NULL, 1, '2017-09-07 11:07:42', NULL, NULL),
(136, 0, 'vidiska', NULL, 1, '2017-09-07 11:07:48', NULL, NULL),
(137, 0, 'w.line', NULL, 1, '2017-09-07 11:07:54', NULL, NULL),
(138, 0, 'willson', NULL, 1, '2017-09-07 11:08:02', NULL, NULL),
(139, 0, 'win', NULL, 1, '2017-09-07 11:08:08', NULL, NULL),
(140, 0, 'winstar', NULL, 1, '2017-09-07 11:08:14', NULL, NULL),
(141, 0, 'yamaha', NULL, 1, '2017-09-07 11:08:20', NULL, NULL),
(142, 0, 'yonex', NULL, 1, '2017-09-07 11:08:26', NULL, NULL),
(143, 0, 'ziljiang', NULL, 1, '2017-09-07 11:08:33', NULL, NULL),
(144, 0, 'baru', NULL, 1, '2017-10-13 15:16:06', '2017-10-13 15:21:19', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manufacture`
--
ALTER TABLE `manufacture`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manufacture`
--
ALTER TABLE `manufacture`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
