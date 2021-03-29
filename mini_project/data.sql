-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2021 at 04:16 AM
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
-- Database: `mini_orgsup`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_items`
--

CREATE TABLE `product_items` (
  `student_id int NOT NULL AUTO_INCREMENT,
  `pi_code` varchar(10) NOT NULL,
  `pi_name` varchar(50) NOT NULL,
  `pi_stock` int(11) NOT NULL,
  `pi_price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_items`
--

INSERT INTO `product_items` (`pi_code`, `pi_name`, `pi_stock`, `pi_price`) VALUES
('', '', 0, '0'),
('B1', 'Foxter', 5, '2999'),
('B2', 'Trinx', 5, '2999'),
('G1', 'Fender', 5, '1999'),
('G2', 'Gibson', 5, '1999'),
('G3', 'Lumanog', 5, '1999'),
('S1', 'Vans', 5, '499'),
('S2', 'Nike', 5, '499'),
('S3', 'New Balance', 5, '499'),
('T1', 'Nick Automatic', 5, '199'),
('T2', 'Worship Generation', 5, '199'),
('T3', 'Macbeth', 5, '199');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_items`
--
ALTER TABLE `product_items`
  ADD PRIMARY KEY (`pi_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
