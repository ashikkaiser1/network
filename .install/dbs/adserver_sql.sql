-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2020 at 10:59 AM
-- Server version: 5.7.28
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodmicr_food`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) UNSIGNED NOT NULL,
  `ref_id` varchar(30) NOT NULL,
  `ref_by` varchar(30) NOT NULL,
  `UTID` int(20) UNSIGNED NOT NULL,
  `manager` int(10) UNSIGNED NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `contact` varchar(14) NOT NULL,
  `contact_time` varchar(25) NOT NULL,
  `contact_timezone` int(11) NOT NULL,
  `contact_am` varchar(200) NOT NULL,
  `contact_notes` text NOT NULL,
  `skype_id` varchar(100) NOT NULL,
  `timeZone` varchar(3) DEFAULT NULL,
  `global` int(1) NOT NULL DEFAULT '0',
  `company` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `re_password` varchar(20) NOT NULL,
  `aff_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `country_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `offer_workwith` text NOT NULL,
  `offer_specific` text NOT NULL,
  `bank_name` varchar(250) DEFAULT NULL,
  `IFSC_code` varchar(11) DEFAULT NULL,
  `bank_account` varchar(20) DEFAULT NULL,
  `PAN` varchar(250) DEFAULT NULL,
  `swift_code` varchar(25) DEFAULT NULL,
  `paypal_email` varchar(60) DEFAULT NULL,
  `payoneer` varchar(50) DEFAULT NULL,
  `bank_verification_status` tinyint(1) DEFAULT '0' COMMENT '0:not verfied,1:verfied',
  `DOJ` varchar(20) NOT NULL,
  `in_code` varchar(50) NOT NULL,
  `verified` tinyint(4) NOT NULL DEFAULT '0',
  `AddUser` int(20) NOT NULL,
  `ModeUser` int(20) DEFAULT NULL,
  `ModeDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `ref_id`, `ref_by`, `UTID`, `manager`, `username`, `name`, `email`, `contact`, `contact_time`, `contact_timezone`, `contact_am`, `contact_notes`, `skype_id`, `timeZone`, `global`, `company`, `password`, `re_password`, `aff_id`, `country_id`, `address`, `offer_workwith`, `offer_specific`, `bank_name`, `IFSC_code`, `bank_account`, `PAN`, `swift_code`, `paypal_email`, `payoneer`, `bank_verification_status`, `DOJ`, `in_code`, `verified`, `AddUser`, `ModeUser`, `ModeDateTime`, `status`) VALUES
(1, '', '', 1, 0, 'khan', 'Khan', 'ashikkaiser@gmail.com', '', '', 0, '', '', '', '', 0, '', 'khan@2015', 'khan@2015', '', 0, '', '', '', '', '', '', '', '', '', '', 0, '', '', 1, 0, NULL, '2019-09-13 06:33:06', 1);

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `auto_approve_offer_for_new_user` AFTER INSERT ON `users` FOR EACH ROW INSERT INTO `usr_offerApproval`(`uid`, `campaign_id`, `status`)
SELECT NEW.uid , campaign_id , '1' from campaign
where req_approval=0
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `username` (`username`,`email`),
  ADD KEY `UTID` (`UTID`),
  ADD KEY `username_2` (`username`,`aff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
