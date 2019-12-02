-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2019 at 11:19 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `framework`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `fname` varchar(155) NOT NULL,
  `lname` varchar(155) NOT NULL,
  `email` varchar(155) NOT NULL,
  `address` varchar(155) NOT NULL,
  `city` varchar(120) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `user_id`, `fname`, `lname`, `email`, `address`, `city`, `zip`, `phone`, `deleted`) VALUES
(1, 2, 'Djoka', 'Djokic', 'djokica@gmail.com', 'Djokina 85', 'Djokingrad', '11453', '+3812523456', 0),
(2, 1, 'Mika', 'Mikic', 'mikica@gmail.com', 'Mikicina 35', 'Novi Sad', '21000', '+3812523477', 0),
(3, 1, 'Sanja', 'Antonijevic', 'sanjaantonijevic1@gmail.com', 'Brace Badzak 93', 'Mladenovac', '11400', '+38164281458', 0),
(7, 2, 'Zika', 'Zikic', 'zika@gmail.com', 'Zikina 46', 'Palanka', '11420', '06458255', 0),
(8, 1, 'Pera', 'Peric', 'pera@gmail.com', 'Perina 12', 'Pozarevac', '13000', '0645824685', 0),
(12, 1, 'hgjghj', 'ghjghjghj', 'ghj@fg.com', 'gdfgdfg 64', 'dfgdfgdfg', '34534534', '4353535345', 1),
(13, 1, 'Maja', 'Majic', 'maja@gmail.com', 'Djokina 23', 'Palanka', '11420', '+38164222333', 0),
(14, 1, 'Mile', 'Miletic', 'mile@gmail.com', 'Miletova 44', 'Milici', '11200', '0645858978', 0),
(15, 2, 'Jova ', 'Jovovic', 'jova@gmail.com', 'Jovicina 12', 'Jovingrad', '11345', '0625487369', 0),
(16, 1, 'Djole', 'Djokic', 'djole@gmail.com', 'Petrova 46', 'Kupusina', '11456', '+38163201366', 0),
(17, 1, 'dfgdfg', 'dgdfg', 'a@g.com', 'sdfsdf 54', 'dfgdfgdfg', '324234', '435435345', 1),
(18, 1, 'Tole', 'Lopove', 'tolelopove@gmail.com', 'Toletova 13', 'Tolovgrad', '11255', '+381655487896', 0),
(19, 1, 'Zile', 'dfgdfgdf', 'aaa@g.com', 'sfsdf 35', 'sgsfgsgf', '21478', '+4235243123424', 1),
(20, 1, 'Tole', 'Lopov', 'tolelopove@gmail.com', 'Toletova 13', 'Tolovgrad', '11255', '+381655487896', 0),
(21, 1, 'Uros', 'Peric', 'up@gmail.com', 'Peroviceva 25', 'Petlovo', '12345', '066543387', 0),
(22, 1, 'Lola', 'Lolic', 'lola@gmail.com', 'Lolina 12', 'Lolovo', '13452', '0677234521', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(150) DEFAULT NULL,
  `fname` varchar(150) DEFAULT NULL,
  `lname` varchar(150) DEFAULT NULL,
  `acl` text,
  `deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `fname`, `lname`, `acl`, `deleted`) VALUES
(1, 'duki87', 'duki@gmail.com', '$2y$10$TX8TlB3hBdmgoHO3M/gUeu59DsRzQ/V1fkAHI3/12v8kGRyLLzC2K', 'Dusan', 'Marinkovic', NULL, 0),
(2, 'gigica', 'gigi@gmail.com', '$2y$10$2Cr2ZMNF1FHb0eQ3G/xukOXrmsYXVNmx/In8ywV2RRfbIotWcucdq', 'Gigi', 'Gigic', NULL, 0),
(3, 'MikiDjoki', 'mikidjoki@gmail.com', '$2y$10$kXuXNDSq.V6UZwEfRVm3G.BGB.IgTeE6VEXeeMkavAZWZmT3HtPsW', 'Mikica', 'Djokic', NULL, 0),
(7, 'Djokica76', 'djokica@gmail.com', '$2y$10$c4Bl7zw6tOXqgi65eG3mj.aOLfjpv6M9z7kvnp7lH6efx6r5JdlDm', 'Djoka', 'Djokic', NULL, 0),
(8, 'perica', 'perica@gmail.com', '$2y$10$Xy68BUaskQkjBBICYascNOAYvsPOuSJi3MN3nWBNgbTO3xvh9OL2W', 'Perica', 'Peric', NULL, 0),
(9, 'radojica', 'rade@gmail.com', '$2y$10$kbvk8r2EbKNPhkOScDBfeuaRPmkEKdChmuegfn8aPxdfqrY298KHq', 'Rade', 'Radic', NULL, 0),
(19, 'duki_87', 'dusan@yandex.com', '$2y$10$wDKNHMNQAMXKDtLZ4y2tSuTC1afSSf9FLNQmzceX0nu4GtYzOFKt2', 'Dusan', 'Marinkovic', NULL, 0),
(26, 'gigica16', 'gigi@yandex.com', '$2y$10$gVcIIjMb4Kp7uoKDVY.5WOixmfgN3eqTegmQ.5pecNIEFYPVyQa1y', 'Gigi', 'Gigica', NULL, 0),
(27, 'Djokica88', 'djokson@gmail.com', '$2y$10$lwAAHqZRChCDbU06AtpKreZ9l5r0cU7B2LDRFE4PLCPYiwzl0pbk.', 'Djokica', 'Djokic', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `session`, `user_agent`) VALUES
(1, 1, 'f457c545a9ded88f18ecee47145a72c0', 'Mozilla (Windows NT 6.1; rv:61.0) Gecko Firefox');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `deleted` (`deleted`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
