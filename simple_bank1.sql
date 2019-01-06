-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2019 at 02:08 AM
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
-- Database: `simple_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` int(11) NOT NULL,
  `name` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `name`) VALUES
(1, 'USD'),
(2, 'EUR'),
(3, 'GBP');

-- --------------------------------------------------------

--
-- Table structure for table `direct`
--

CREATE TABLE `direct` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `direct`
--

INSERT INTO `direct` (`id`, `name`, `country`) VALUES
(4, 'Abdul Manan', 'Pakistan'),
(5, 'Abdul Manan', 'Pakistan'),
(6, 'Abdul Manan', 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `receiver_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direct_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `sender_id`, `receiver_id`, `currency_id`, `date`, `amount`, `description`, `type`, `direct_id`) VALUES
(35, NULL, 18, 1, '2018/12/26 18:06:19', '11', '11', '0', 4),
(36, NULL, 18, 1, '2018/12/26 18:07:32', '11', '11', '0', 5),
(37, NULL, 19, 1, '2018/12/26 18:09:23', '11.19', '11', '0', 6),
(38, 19, 18, 1, '2018/12/26 18:09:44', '10', 'Hello', '1', NULL),
(39, 18, 19, 1, '2018/12/26 18:10:26', '510.19', 'Accept this', '4', NULL),
(40, 19, 18, 1, '2018/12/26 18:19:53', '11', '11', '3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `phoneNumber` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `api_expire` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL,
  `reset_request` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `phoneNumber`, `firstName`, `lastName`, `gender`, `type`, `code`, `client_token`, `api_key`, `api_expire`, `status`, `reset_request`) VALUES
(18, 'mirza.amanan@gmail.com2', 'mirza.amanan@gmail.com2', 'mirza.amanan@gmail.com2', 'mirza.amanan@gmail.com2', 1, NULL, '$2y$13$KrRCYDMYBSvlDuKw8/qxZOVjPca0ps1BPn7UuLKo/ILSFgSq2boVm', '2019-01-05 14:49:13', '769915', '2019-01-03 16:37:41', 'a:0:{}', '30004210772', 'Abdul', 'Manan', 'm', 'p', '609245', 'nl3IFxgS8Z', '0gWxRRr0C5', NULL, 1, NULL),
(19, 'mirza.amanan1@gmail.com', 'mirza.amanan1@gmail.com', 'mirza.amanan1@gmail.com', 'mirza.amanan1@gmail.com', 1, NULL, '$2y$13$32lwOhfAqTCmmjG2wCEUZe1XsgGBizspIXdhUoiEaThaQ2gc.8Mna', '2019-01-05 23:41:06', NULL, NULL, 'a:0:{}', '923000421077', 'Abdul', 'Manan', 'm', 'p', '852529', 'h7HspCk0Sp', 'zWMx3aKzjU', NULL, 1, NULL),
(20, 'mirza.amanan@gmail.com1', 'mirza.amanan@gmail.com1', 'mirza.amanan@gmail.com1', 'mirza.amanan@gmail.com1', 1, NULL, '$2y$13$iBvLmK6aDTQrUwG9kvbttuajHBHXTFgvBpBIVTZV3oNNOC3BRRV7u', '2019-01-05 22:23:32', NULL, NULL, 'a:0:{}', '3000421077', 'Abdul', 'Manan', 'f', 'c', '552553', 'Yreq5ZwIhc', 'Pinn4c3OgC', NULL, 2, NULL),
(21, 'mirza.amanan@gmail.com', 'mirza.amanan@gmail.com', 'mirza.amanan@gmail.com', 'mirza.amanan@gmail.com', 1, NULL, '$2y$13$WApF0x84k3vwqrWO4rKCl.6.avAK2gz1cJ8slViwUCCFe24XycOlS', '2019-01-04 00:54:03', '628740', '2019-01-05 12:50:38', 'a:0:{}', '9230004210771', 'Abdul', 'Manan', 'm', 'p', '189930', 'diTPrSj6oj', 'J6Ploeu04X', NULL, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `direct`
--
ALTER TABLE `direct`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_723705D1F624B39D` (`sender_id`),
  ADD KEY `IDX_723705D1CD53EDB6` (`receiver_id`),
  ADD KEY `IDX_723705D138248176` (`currency_id`),
  ADD KEY `IDX_723705D1A8230609` (`direct_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D64992FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649A0D96FBF` (`email_canonical`),
  ADD UNIQUE KEY `UNIQ_8D93D649E85E83E4` (`phoneNumber`),
  ADD UNIQUE KEY `UNIQ_8D93D649C05FB297` (`confirmation_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `direct`
--
ALTER TABLE `direct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `FK_723705D138248176` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `FK_723705D1A8230609` FOREIGN KEY (`direct_id`) REFERENCES `direct` (`id`),
  ADD CONSTRAINT `FK_723705D1CD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_723705D1F624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
