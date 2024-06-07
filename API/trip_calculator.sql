-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 07, 2024 at 08:30 PM
-- Server version: 5.7.39
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trip_calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `age_load`
--

CREATE TABLE `age_load` (
  `id` int(11) NOT NULL,
  `lower_age` int(11) NOT NULL,
  `upper_age` int(11) NOT NULL,
  `load_value` double NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `valid_from` datetime DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `age_load`
--

INSERT INTO `age_load` (`id`, `lower_age`, `upper_age`, `load_value`, `created_on`, `valid_from`, `valid_to`, `is_deleted`) VALUES
(1, 18, 30, 0.6, '2024-06-07 20:28:36', '2024-01-01 00:00:00', NULL, b'0'),
(2, 31, 40, 0.7, '2024-06-07 20:28:36', '2024-01-01 00:00:00', NULL, b'0'),
(3, 41, 50, 0.8, '2024-06-07 20:28:36', '2024-01-01 00:00:00', NULL, b'0'),
(4, 51, 60, 0.9, '2024-06-07 20:28:36', '2024-01-01 00:00:00', NULL, b'0'),
(5, 61, 70, 1, '2024-06-07 20:28:36', '2024-01-01 00:00:00', NULL, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE `quotation` (
  `id` int(11) NOT NULL,
  `total` double NOT NULL,
  `currency` varchar(50) NOT NULL,
  `age` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `total`, `currency`, `age`, `start_date`, `end_date`, `created_on`, `is_deleted`) VALUES
(1, 117, 'EUR', '25,35', '2020-10-01', '2020-10-30', '2024-06-07 20:29:11', b'0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `age_load`
--
ALTER TABLE `age_load`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotation`
--
ALTER TABLE `quotation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `age_load`
--
ALTER TABLE `age_load`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quotation`
--
ALTER TABLE `quotation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
