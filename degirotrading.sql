-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2022 at 02:16 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `degirotrading`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  `BTC_wallet` varchar(500) NOT NULL,
  `ETH_wallet` varchar(500) NOT NULL,
  `USDT_wallet` varchar(500) NOT NULL,
  `LTC_wallet` varchar(500) NOT NULL,
  `DOGE_wallet` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `phone`, `BTC_wallet`, `ETH_wallet`, `USDT_wallet`, `LTC_wallet`, `DOGE_wallet`) VALUES
(1, 'Admin', '1234', 'support@degirotrading', '+1827162722736273', 'fjwlkwebwebwqke', 'hdnsldsdbsndsdsd', 'sasagshnf,,fffff', 'JLFHKJDKFF', 'WEREKLREWRER');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` int(11) NOT NULL,
  `deposit_id` varchar(500) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `deposit_type` varchar(500) NOT NULL,
  `coin_type` varchar(500) NOT NULL,
  `wallet_address` varchar(500) NOT NULL,
  `usd_amount` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `deposit_id`, `user_id`, `deposit_type`, `coin_type`, `wallet_address`, `usd_amount`, `status`, `time`, `time_created`) VALUES
(16, '62c3d8397b96a', '62c3bfdf011a5', 'Deposit', 'USDT', 'sasagshnf,,f', '120', 'Approved', '1657002041', 'Jul,05,2022 08:20 AM'),
(18, '62cd40a00d940', '62c3bfdf011a5', 'Topup', 'ETH', 'hdnsldsdbsndsdsd', '3000', 'Pending', '1657618592', 'Jul,12,2022 11:36 AM'),
(19, '62cff16d408be', '62cd92a40b7a2', 'Deposit', 'USDT', 'sasagshnf,,fffff', '15000', 'Pending', '1657794925', 'Jul,14,2022 12:35 PM'),
(20, '62cff26ac862b', '62cd92a40b7a2', 'Topup', 'BTC', 'fjwlkwebwebwqke', '2000', 'Pending', '1657795178', 'Jul,14,2022 12:39 PM');

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` int(11) NOT NULL,
  `investment_id` varchar(500) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `plan` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `investment_id`, `user_id`, `plan`, `status`, `amount`, `time_created`) VALUES
(18, 'FIL_0F5DV6', '62c3bfdf011a5', 'Gold', 'Active', '1500', 'Jul,05,2022 11:49 AM'),
(19, 'FIL_7N3Z2L', '62c3bfdf011a5', 'Platinum', 'Active', '5000', 'Jul,05,2022 12:02 PM'),
(21, 'FIL_702NSG', '62c3bfdf011a5', 'Promo', 'Active', '2000', 'Jul,12,2022 11:58 AM'),
(22, 'FIL_73XVE0', '62cd92a40b7a2', 'Gold', 'Active', '1000', 'Jul,14,2022 12:38 PM');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `status`, `time_created`) VALUES
(1, '62c3bfdf011a5', 'Please topup', 'hskjahsasas\r\n', 'Seen', 'Jul,11,2022 07:28 PM'),
(2, '62cd92a40b7a2', 'Welcome to Fidelityinvestments LLC', 'Hello there Mary! We specially welcome you to fidelityinvesments.. Feel free to Invest and make massive returns', 'Seen', 'Jul,12,2022 05:31 PM'),
(3, '62cd92a40b7a2', 'Please Topup', 'Kindly Topup to withdraw $2000', 'Seen', 'Jul,12,2022 05:35 PM'),
(4, '62cd92a40b7a2', 'Happy EID Mubarak', 'We are giving a special bonus offer', 'Seen', 'Jul,12,2022 05:37 PM');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_keys`
--

CREATE TABLE `password_reset_keys` (
  `id` int(11) NOT NULL,
  `key_id` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `password_reset_keys`
--

INSERT INTO `password_reset_keys` (`id`, `key_id`, `email`, `status`) VALUES
(4, '62cdc10c6f87d', 'john@gmail.com', 'used');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `referrer_id` varchar(500) NOT NULL,
  `referred_id` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referrer_id`, `referred_id`) VALUES
(2, '62c3bfdf011a5', '62cd92a40b7a2'),
(3, '62c3bfdf011a5', '630f494f87740');

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `reference_id` varchar(500) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `support_tickets`
--

INSERT INTO `support_tickets` (`id`, `user_id`, `reference_id`, `subject`, `message`, `time`, `time_created`) VALUES
(2, '62c3bfdf011a5', 'K50V4D', 'How to fund my account', 'jksd.jsdlsdd', '1657207643', 'Jul,07,2022 05:27 PM');

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE `trades` (
  `id` int(11) NOT NULL,
  `trade_id` varchar(500) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `asset` varchar(500) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `profit` varchar(500) NOT NULL,
  `trade_type` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trades`
--

INSERT INTO `trades` (`id`, `trade_id`, `user_id`, `asset`, `amount`, `profit`, `trade_type`, `time_created`) VALUES
(2, '62cfc7769d1f2', '62c3bfdf011a5', 'EUR/USD', '10', '100', 'BUY', 'Jul,14,2022 09:36 AM'),
(3, '62cfc7e1c38b9', '62c3bfdf011a5', 'EUR/USD', '5000', '20', 'BUY', 'Jul,14,2022 09:38 AM'),
(4, '62cfc7fc6bcb5', '62c3bfdf011a5', 'USD/JPY', '1000', '50', 'SELL', 'Jul,14,2022 09:38 AM');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `firstname` varchar(500) NOT NULL,
  `lastname` varchar(500) NOT NULL,
  `phone` varchar(500) NOT NULL,
  `email` varchar(500) NOT NULL,
  `country` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `image` varchar(500) NOT NULL,
  `wallet_address` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `available_balance` varchar(500) NOT NULL,
  `total_deposit` varchar(500) NOT NULL,
  `total_bonus` varchar(500) NOT NULL,
  `total_withdrawal` varchar(500) NOT NULL,
  `total_referral_bonus` varchar(500) NOT NULL,
  `pending_deposit` varchar(500) NOT NULL,
  `pending_withdrawal` varchar(500) NOT NULL,
  `referral_code` varchar(500) NOT NULL,
  `withdrawal_code` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL,
  `verification_status` varchar(500) NOT NULL,
  `last_login` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `username`, `firstname`, `lastname`, `phone`, `email`, `country`, `password`, `image`, `wallet_address`, `status`, `available_balance`, `total_deposit`, `total_bonus`, `total_withdrawal`, `total_referral_bonus`, `pending_deposit`, `pending_withdrawal`, `referral_code`, `withdrawal_code`, `time`, `date`, `time_created`, `verification_status`, `last_login`) VALUES
(9, '62c3bfdf011a5', 'john123', 'John', 'Doe', '+649023827383', 'john@gmail.com', 'empty', '1234', '62c6dec1242f5undraw_profile_1.svg', 'salkdsandsnad,nsa ds9', 'Active', '2200', '120', '0', '5300', '0', '50', '0', 'KJ1Q73', '1234', '1656995807', '05-07-22', 'Jul,05,2022 06:36 AM', 'Verified', 'Aug,31,2022 01:22 PM'),
(11, '62cd92a40b7a2', 'mary123', 'Mary', 'Lanes', '09012781782', 'mary@gmail.com', 'empty', '1234', 'default.svg', 'empty', 'Active', '1800', '0', '0', '0', '0', '17000', '1200', '28YAS1', '1234', '1657639588', '12-07-22', 'Jul,12,2022 05:26 PM', 'Not Verified', 'Jul,12,2022 05:26 PM'),
(12, '630f494f87740', 'paul123', 'Paul', 'John', '0902812872', 'paul@gmail.com', 'empty', '1234', 'default.svg', 'empty', 'Active', '0', '0', '0', '0', '0', '0', '0', 'DC74G9', 'withdrawal_code', '1661946191', '31-08-22', 'Aug,31,2022 01:43 PM', 'Not Verified', 'Aug,31,2022 01:43 PM');

-- --------------------------------------------------------

--
-- Table structure for table `verification_requests`
--

CREATE TABLE `verification_requests` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `image1` varchar(500) NOT NULL,
  `image2` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification_requests`
--

INSERT INTO `verification_requests` (`id`, `user_id`, `image1`, `image2`, `status`, `time`, `time_created`) VALUES
(7, '62c3bfdf011a5', '62d66376038c8correctleg3.PNG', '62d6637604226correctleg2.PNG', 'Verified', '1658217334', '19-07-22');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` int(11) NOT NULL,
  `user_id` varchar(500) NOT NULL,
  `amount` varchar(500) NOT NULL,
  `payment_method` varchar(500) NOT NULL,
  `payment_details` varchar(500) NOT NULL,
  `status` varchar(500) NOT NULL,
  `time` varchar(500) NOT NULL,
  `date` varchar(500) NOT NULL,
  `time_created` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `withdrawals`
--

INSERT INTO `withdrawals` (`id`, `user_id`, `amount`, `payment_method`, `payment_details`, `status`, `time`, `date`, `time_created`) VALUES
(5, '62c3bfdf011a5', '5000', 'BTC', 'djdsjdsmahdjsabd', 'Approved', '1657210114', '07-07-22', 'Jul,07,2022 06:08 PM'),
(6, '62c3bfdf011a5', '300', 'USDT', 'jsklqnbenqrfq', 'Pending', '1657786818', '14-07-22', 'Jul,14,2022 10:20 AM'),
(7, '62cd92a40b7a2', '1200', 'BTC', 'q,sdsjbbdsdbvsd', 'Pending', '1657796034', '14-07-22', 'Jul,14,2022 12:53 PM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_keys`
--
ALTER TABLE `password_reset_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trades`
--
ALTER TABLE `trades`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verification_requests`
--
ALTER TABLE `verification_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `password_reset_keys`
--
ALTER TABLE `password_reset_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trades`
--
ALTER TABLE `trades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `verification_requests`
--
ALTER TABLE `verification_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
