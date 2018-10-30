-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2018 at 10:35 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sale_manage`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyitems`
--

CREATE TABLE `buyitems` (
  `buy_id` int(11) NOT NULL,
  `buy_user` varchar(200) NOT NULL,
  `buy_stayprice` varchar(200) NOT NULL,
  `buy_price` varchar(200) NOT NULL,
  `buy_sub` varchar(200) NOT NULL,
  `buy_subphone` varchar(200) DEFAULT NULL,
  `buy_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buyitems`
--

INSERT INTO `buyitems` (`buy_id`, `buy_user`, `buy_stayprice`, `buy_price`, `buy_sub`, `buy_subphone`, `buy_date`) VALUES
(1, '1', '0', '11100', 'ahmed', '01011112222', '2018-10-29'),
(2, '1', '0', '22250', 'محمد', '01044446666', '2018-10-29'),
(3, '1', '3200', '500', 'sssssssss', '11111111111111', '2018-10-29'),
(4, '1', '0', '37000', 'faisal', '01012458798', '2018-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `buysitems`
--

CREATE TABLE `buysitems` (
  `buy_idid` int(11) NOT NULL,
  `item_ididbuy` int(11) NOT NULL,
  `item_mountbuy` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buysitems`
--

INSERT INTO `buysitems` (`buy_idid`, `item_ididbuy`, `item_mountbuy`) VALUES
(1, 3, 3),
(1, 8, 3),
(2, 1, 1),
(2, 4, 2),
(2, 5, 1),
(2, 6, 1),
(2, 7, 2),
(3, 3, 1),
(3, 8, 1),
(4, 3, 10),
(4, 8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(200) NOT NULL,
  `item_desc` text,
  `buyprice` varchar(200) NOT NULL,
  `sellprice` varchar(200) NOT NULL,
  `sell_mount` varchar(200) NOT NULL,
  `stay_mount` varchar(200) NOT NULL,
  `sectionid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `item_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_desc`, `buyprice`, `sellprice`, `sell_mount`, `stay_mount`, `sectionid`, `userid`, `item_date`) VALUES
(1, 'ايفون 6', 'ايفون 6+', '2000', '3000', '15', '30', 2, 1, '2018-10-18'),
(3, 's7+', 's7+', '3000', '3500', '20', '20', 2, 1, '2018-10-19'),
(4, 'بنطلون رجالي ', 'بنطلون رجالي ', '200', '250', '15', '25', 4, 1, '2018-10-19'),
(5, 'جيبه', 'جيبه', '300', '350', '15', '22', 4, 1, '2018-10-19'),
(6, 'موتسيكل', 'موتسيكل', '15000', '16000', '15', '17', 3, 1, '2018-10-19'),
(7, 'ساعة ديجتال', 'ساعة ديجتال', '1000', '1200', '15', '18', 5, 1, '2018-10-19'),
(8, 's6+', 's6+', '150', '200', '5', '20', 2, 1, '2018-10-23'),
(10, 'قميص', 'قميص رجالي', '70', '100', '15', '45', 4, 1, '2018-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sale_id` int(11) NOT NULL,
  `sale_user` int(11) NOT NULL,
  `sale_stayprice` varchar(200) NOT NULL,
  `sale_price` varchar(200) NOT NULL,
  `sale_cus` varchar(200) NOT NULL,
  `sale_cusphone` varchar(200) DEFAULT NULL,
  `sale_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sale_id`, `sale_user`, `sale_stayprice`, `sale_price`, `sale_cus`, `sale_cusphone`, `sale_date`) VALUES
(1, 1, '0', '3700', 'ahmed', '01015258850', '0000-00-00'),
(2, 1, '700', '3000', 'ssssssssssssssssss', 'ssssssssssssssss', '0000-00-00'),
(3, 1, '3700', '0', 'ssssssssssssssss', 'ssssssssssssssss', '0000-00-00'),
(4, 1, '3478', '222', 'ssssssssssssssssss', 'ssssssssssssssssssss', '0000-00-00'),
(5, 1, '3478', '222', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', '0000-00-00'),
(6, 1, '3200', '500', 'ahmed', '111111111111111111', '0000-00-00'),
(7, 1, '3200', '500', 'eeeeeeeeee', 'eeeeeeeeeeeee', '0000-00-00'),
(8, 1, '3692', '8', 'ssssssssssssssss', 'ssssssssssssss', '0000-00-00'),
(9, 1, '3256', '444', 'ssssssssssssss', 'ssssssssss', '0000-00-00'),
(10, 1, '3200', '500', 'mosa', '01015258850', '2018-10-28'),
(11, 1, '3666', '34', 'wwwwwwwwwwwwww', '44444444444', '2018-10-28'),
(12, 1, '3200', '500', 'mosa', '01015258850', '2018-10-28'),
(13, 1, '3300', '400', 'mosa', '01015258850', '2018-10-28'),
(14, 1, '3256', '444', 'mosa', '01015258850', '2018-10-28'),
(15, 1, '700', '3000', 'mosa', '01015258850', '2018-10-28'),
(16, 1, '3400', '300', 'said', '01015258850', '2018-10-28'),
(17, 1, '0', '3700', 'eeeeee', '01015258850', '2018-10-28'),
(18, 1, '700', '3000', 'said', '01015258850', '2018-10-28'),
(19, 1, '3879', '21', 'ssssssssssssssssss', '111111111111111111', '2018-10-28'),
(20, 1, '3400', '300', 'said', '01015258850', '2018-10-28'),
(21, 1, '700', '10000', 'said', '01015258850', '2018-10-28'),
(22, 1, '3700', '200', 'aaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaa', '2018-10-28'),
(23, 1, '700', '3000', 'ahmed', '44444444444', '2018-10-28'),
(24, 1, '2600', '5000', 'said', '01015258850', '2018-10-28'),
(25, 1, '100', '4000', 'mosa', '01015258850', '2018-10-28'),
(26, 1, '800', '35000', 'mosa', '01015258850', '2018-10-28'),
(27, 1, '800', '35000', 'mosa', '01015258850', '2018-10-28'),
(28, 1, '200', '7000', 'said', '01015258850', '2018-10-28'),
(29, 1, '0', '27650', 'mosa', '01015258850', '2018-10-28'),
(30, 1, '0', '18400', 'mosa', '01015258850', '2018-10-28'),
(31, 1, '3635', '65', 'mosa', '01015258850', '2018-10-28'),
(32, 1, '150', '21000', 'mosa', '01015258850', '2018-10-28'),
(33, 1, '0', '1000', 'sssssssssss', '11111111111', '2018-10-29'),
(34, 1, '0', '1000', 'ssssssssssssssssss', '111', '2018-10-29'),
(35, 1, '400', '200', 'mosa', '', '2018-10-29'),
(36, 1, '598', '2', 'mosa', '', '2018-10-29'),
(37, 1, '795', '5', 'mosa', '', '2018-10-29'),
(38, 1, '0', '200', 'said', '', '2018-10-29'),
(39, 1, '399', '1', 'mosa', '01015258850', '2018-10-29'),
(40, 1, '1000', '000', 'ssssssssssssssssss', '44444444444', '2018-10-29'),
(41, 1, '900', '100', 'mosa', '', '2018-10-29'),
(42, 1, '20000', '10000', 'mosa', '111111111111111111', '2018-10-29'),
(43, 1, '29000', '1000', 'ahmed', '111111111111111111', '2018-10-29'),
(44, 1, '9000', '200000', 'said', '01015258850', '2018-10-29');

-- --------------------------------------------------------

--
-- Table structure for table `salesitems`
--

CREATE TABLE `salesitems` (
  `sale_idid` int(11) NOT NULL,
  `item_idid` int(11) NOT NULL,
  `item_mount` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `salesitems`
--

INSERT INTO `salesitems` (`sale_idid`, `item_idid`, `item_mount`) VALUES
(9, 3, ''),
(9, 8, ''),
(18, 3, '2'),
(18, 8, '0'),
(19, 3, '4'),
(19, 8, '0'),
(22, 3, '400'),
(22, 8, '400'),
(23, 8, '3500'),
(23, 3, '3500'),
(24, 3, 'Array'),
(24, 8, 'Array'),
(25, 3, '1'),
(25, 3, '3'),
(25, 8, '1'),
(25, 8, '3'),
(26, 3, '10'),
(26, 3, '4'),
(26, 8, '10'),
(26, 8, '4'),
(27, 3, '10'),
(27, 3, '4'),
(27, 8, '10'),
(27, 8, '4'),
(30, 6, '1'),
(30, 7, '2'),
(31, 3, '1'),
(31, 8, '1'),
(32, 1, '1'),
(32, 4, '1'),
(32, 5, '2'),
(32, 6, '1'),
(32, 7, '1'),
(33, 8, '5'),
(34, 8, '5'),
(35, 8, '3'),
(36, 8, '3'),
(37, 8, '4'),
(38, 8, '1'),
(39, 8, '2'),
(40, 8, '5'),
(41, 8, '5'),
(42, 1, '10'),
(43, 1, '10'),
(44, 1, '10'),
(44, 4, '10'),
(44, 5, '10'),
(44, 6, '10'),
(44, 7, '10'),
(44, 10, '10');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `sec_id` int(11) NOT NULL,
  `sec_name` varchar(200) NOT NULL,
  `sec_desc` text,
  `sec_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`sec_id`, `sec_name`, `sec_desc`, `sec_date`) VALUES
(1, 'الالكترونيات', 'الالكترونيات', '2018-10-18'),
(2, 'الموبيلات1', 'الموبيلات', '2018-10-18'),
(3, 'السيارات', 'السيارات', '2018-10-19'),
(4, 'الملايس', 'الملايس', '2018-10-19'),
(5, 'الاكسسورات', 'الاكسسورات', '2018-10-19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `user_role` int(200) NOT NULL DEFAULT '0',
  `user_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `username`, `password`, `user_role`, `user_date`) VALUES
(1, 'ahmed', 'ahmed', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '2018-10-17'),
(3, 'احمد', 'احمد', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2018-10-17'),
(4, 'علي', 'علي', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, '2018-10-17'),
(6, 'محمد', 'محمد', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, '2018-10-17'),
(8, 'فرح', 'فرح', '7c4a8d09ca3762af61e59520943dc26494f8941b', 1, '2018-10-17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyitems`
--
ALTER TABLE `buyitems`
  ADD PRIMARY KEY (`buy_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `sectionidid` (`sectionid`),
  ADD KEY `usersidid` (`userid`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sale_id`),
  ADD KEY `usersididid` (`sale_user`);

--
-- Indexes for table `salesitems`
--
ALTER TABLE `salesitems`
  ADD KEY `salesidid` (`sale_idid`),
  ADD KEY `itemsidid` (`item_idid`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`sec_id`),
  ADD UNIQUE KEY `sec_name` (`sec_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyitems`
--
ALTER TABLE `buyitems`
  MODIFY `buy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `sec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `sectionidid` FOREIGN KEY (`sectionid`) REFERENCES `sections` (`sec_id`),
  ADD CONSTRAINT `usersidid` FOREIGN KEY (`userid`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `usersididid` FOREIGN KEY (`sale_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `salesitems`
--
ALTER TABLE `salesitems`
  ADD CONSTRAINT `itemsidid` FOREIGN KEY (`item_idid`) REFERENCES `items` (`item_id`),
  ADD CONSTRAINT `salesidid` FOREIGN KEY (`sale_idid`) REFERENCES `sales` (`sale_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
