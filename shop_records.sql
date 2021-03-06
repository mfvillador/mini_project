-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2021 at 04:14 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_records`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cus_uname` varchar(50) NOT NULL,
  `cus_password` varchar(50) DEFAULT NULL,
  `cus_fname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cus_uname`, `cus_password`, `cus_fname`) VALUES
('boyet', 'zxc', 'Boyet Null'),
('jerald', 'asd', 'Jerald Feranil'),
('marvin', 'qwe', 'Marvin Villador');

-- --------------------------------------------------------

--
-- Table structure for table `customer_cart`
--

CREATE TABLE `customer_cart` (
  `cc_id` int(11) NOT NULL,
  `cus_uname` varchar(50) DEFAULT NULL,
  `pi_code` varchar(10) DEFAULT NULL,
  `order_name` varchar(50) DEFAULT NULL,
  `order_price` decimal(10,0) DEFAULT NULL,
  `order_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer_checkout`
--

CREATE TABLE `customer_checkout` (
  `cch_id` int(11) NOT NULL,
  `cus_uname` varchar(50) DEFAULT NULL,
  `pi_code` varchar(10) DEFAULT NULL,
  `order_name` varchar(50) DEFAULT NULL,
  `order_price` decimal(10,0) DEFAULT NULL,
  `order_count` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `own_uname` varchar(50) NOT NULL,
  `own_password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `owner`
--

INSERT INTO `owner` (`own_uname`, `own_password`) VALUES
('admin', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

CREATE TABLE `product_items` (
  `pi_code` varchar(10) NOT NULL,
  `pi_name` varchar(50) NOT NULL,
  `pi_stock` int(11) NOT NULL,
  `pi_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_items`
--

INSERT INTO `product_items` (`pi_code`, `pi_name`, `pi_stock`, `pi_price`) VALUES
('B1', 'FOXTER', 2, '2999'),
('B2', 'TRINX', 9, '2999'),
('B3', 'MERIDA', 9, '2999'),
('B4', 'CANNONDALE', 9, '2999');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cus_uname`);

--
-- Indexes for table `customer_cart`
--
ALTER TABLE `customer_cart`
  ADD PRIMARY KEY (`cc_id`),
  ADD KEY `cus_uname` (`cus_uname`),
  ADD KEY `pi_code` (`pi_code`);

--
-- Indexes for table `customer_checkout`
--
ALTER TABLE `customer_checkout`
  ADD PRIMARY KEY (`cch_id`),
  ADD KEY `cus_uname` (`cus_uname`),
  ADD KEY `pi_code` (`pi_code`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`own_uname`);

--
-- Indexes for table `product_items`
--
ALTER TABLE `product_items`
  ADD PRIMARY KEY (`pi_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_cart`
--
ALTER TABLE `customer_cart`
  MODIFY `cc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `customer_checkout`
--
ALTER TABLE `customer_checkout`
  MODIFY `cch_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `customer_cart`
--
ALTER TABLE `customer_cart`
  ADD CONSTRAINT `customer_cart_ibfk_1` FOREIGN KEY (`cus_uname`) REFERENCES `customer` (`cus_uname`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_cart_ibfk_2` FOREIGN KEY (`pi_code`) REFERENCES `product_items` (`pi_code`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer_checkout`
--
ALTER TABLE `customer_checkout`
  ADD CONSTRAINT `customer_checkout_ibfk_1` FOREIGN KEY (`cus_uname`) REFERENCES `customer` (`cus_uname`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `customer_checkout_ibfk_2` FOREIGN KEY (`pi_code`) REFERENCES `product_items` (`pi_code`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
