-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 05, 2020 at 01:51 PM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `createevent`
--

DROP TABLE IF EXISTS `createevent`;
CREATE TABLE IF NOT EXISTS `createevent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `eventday` int(11) NOT NULL,
  `subject` text CHARACTER SET utf8 NOT NULL,
  `eventinformation` text CHARACTER SET utf8 NOT NULL,
  `createdby` int(11) NOT NULL,
  `createddate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
CREATE TABLE IF NOT EXISTS `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'om@12345', 0, 0, 0, NULL, '2020-08-01 14:02:24');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `company` text NOT NULL,
  `email` varchar(80) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `adminstatus` varchar(11) NOT NULL DEFAULT 'disable',
  `createddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleteddate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `company`, `email`, `mobile`, `password`, `adminstatus`, `createddate`, `deleteddate`) VALUES
(1, 'Om', 'EMS', 'ochaudhary88@gmail.com', '7710828332', '$2y$10$ZKTBAamCk9iSLuggPv6AN.vZ9otFsuo4Myj5cVsePmjX1je8k6BQ6', 'enable', '2020-08-01 06:44:11', NULL),
(47, 'sunil', 'Swagstik Styles Private Limited', 'sunil@gmail.com', '07710828332', '$2y$10$geLaNAXXvA1cp3wjICshI.jB/i4rerAajHAL5JZK4Y.NuTONcsJK6', 'disable', '2020-08-05 13:50:43', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usernotify`
--

DROP TABLE IF EXISTS `usernotify`;
CREATE TABLE IF NOT EXISTS `usernotify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `eventid` int(11) NOT NULL,
  `eventstatus` int(11) NOT NULL DEFAULT 0,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
