-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 03:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kctms`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ct_id` int(11) NOT NULL,
  `ct_amount` int(11) NOT NULL,
  `ct_note` text NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ct_id`, `ct_amount`, `ct_note`, `s_id`, `f_id`, `c_id`) VALUES
(1, 1, '', 0, 0, 0),
(18, 1, '', 0, 0, 0),
(29, 3, '', 0, 0, 0),
(84, 1, '', 3, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `f_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `f_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `f_price` decimal(6,2) NOT NULL,
  `f_pic` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`f_id`, `s_id`, `f_name`, `f_price`, `f_pic`) VALUES
(66, 2, 'cricket', 200.00, '66_2.jpg'),
(67, 8, 'volleyball', 150.00, '67_8.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `mreg_detail`
--

CREATE TABLE `mreg_detail` (
  `ord_id` int(11) NOT NULL,
  `orh_id` int(11) NOT NULL,
  `f_id` int(11) NOT NULL,
  `ord_amount` int(11) NOT NULL,
  `ord_buyprice` decimal(6,2) NOT NULL,
  `ord_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mreg_detail`
--

INSERT INTO `mreg_detail` (`ord_id`, `orh_id`, `f_id`, `ord_amount`, `ord_buyprice`, `ord_note`) VALUES
(125, 90, 67, 1, 150.00, ''),
(126, 91, 66, 1, 200.00, ''),
(127, 92, 66, 1, 200.00, ''),
(128, 93, 67, 1, 150.00, ''),
(129, 94, 67, 1, 150.00, ''),
(130, 95, 67, 1, 150.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `mreg_status`
--

CREATE TABLE `mreg_status` (
  `orh_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `orh_ordertime` timestamp NOT NULL DEFAULT current_timestamp(),
  `orh_orderstatus` varchar(45) NOT NULL,
  `orh_finishedtime` datetime DEFAULT NULL,
  `t_id` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mreg_status`
--

INSERT INTO `mreg_status` (`orh_id`, `c_id`, `s_id`, `p_id`, `orh_ordertime`, `orh_orderstatus`, `orh_finishedtime`, `t_id`) VALUES
(90, 8, 8, 66, '2025-03-23 12:09:35', 'ACPT', '0000-00-00 00:00:00', '123456789012'),
(91, 7, 2, 67, '2025-03-23 12:44:08', 'ACPT', '0000-00-00 00:00:00', '123456789012'),
(92, 9, 2, 68, '2025-03-23 13:25:39', 'ACPT', '0000-00-00 00:00:00', '123456789012'),
(93, 10, 8, 69, '2025-03-23 15:33:09', 'ACPT', '0000-00-00 00:00:00', '123456789012'),
(94, 11, 8, 70, '2025-03-24 14:38:10', 'ACPT', '0000-00-00 00:00:00', '123456789012'),
(95, 12, 8, 71, '2025-03-24 14:41:43', 'ACPT', '0000-00-00 00:00:00', '123456789012');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `p_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `p_amount` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`p_id`, `c_id`, `p_amount`) VALUES
(66, 8, 150.00),
(67, 7, 200.00),
(68, 9, 200.00),
(69, 10, 150.00),
(70, 11, 150.00),
(71, 12, 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `c_username` varchar(45) NOT NULL,
  `c_pwd` varchar(45) NOT NULL,
  `c_firstname` varchar(45) NOT NULL,
  `c_lastname` varchar(45) NOT NULL,
  `c_email` varchar(100) NOT NULL,
  `c_gender` varchar(1) NOT NULL COMMENT 'M for Male, F for Female',
  `c_type` varchar(3) NOT NULL COMMENT 'ADM for admin,PLY for player',
  `c_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`c_username`, `c_pwd`, `c_firstname`, `c_lastname`, `c_email`, `c_gender`, `c_type`, `c_id`) VALUES
('akshaya', 'akshaya12', 'akshaya', 'p', 'akshaya12@gmail.com', 'F', 'ADM', 1),
('mithra', 'mithra13', 'mithra', 'r', 'mithra13@gmail.com', 'F', 'PLY', 7),
('eniyavan', 'eniyavan04', 'eniyavan', 'm', 'eni15@gmail.com', 'M', 'PLY', 8),
('dineshwar', 'dinesh15', 'dineshwar', 't', 'dinesh15@gmail.com', 'M', 'pla', 9),
('GANGARAJ', 'rajU1304', 'gangaraj', 'r', 'raj13@gmail.com', 'F', 'pla', 10),
('RAJU R', 'raju1304', 'raj', 'r', 'raj15@gmail.com', 'M', 'pla', 11),
('RAMU V', 'ramu2150', 'ramu', 'r', 'ramu215@gmail.com', 'M', 'pla', 12);

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_matches`
--

CREATE TABLE `scheduled_matches` (
  `schedule_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `team1_id` int(11) NOT NULL,
  `team2_id` int(11) NOT NULL,
  `match_date` date NOT NULL,
  `match_time` time NOT NULL,
  `venue` varchar(255) NOT NULL,
  `winner_team_id` int(11) DEFAULT NULL,
  `status` enum('Scheduled','Completed','Ongoing') DEFAULT 'Scheduled',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `team1_score` int(11) DEFAULT 0,
  `team2_score` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scheduled_matches`
--

INSERT INTO `scheduled_matches` (`schedule_id`, `s_id`, `team1_id`, `team2_id`, `match_date`, `match_time`, `venue`, `winner_team_id`, `status`, `created_at`, `updated_at`, `team1_score`, `team2_score`) VALUES
(1, 2, 6, 8, '2025-03-24', '08:30:00', 'kumaraguru college', 6, 'Completed', '2025-03-23 14:58:46', '2025-03-24 14:27:02', 150, 110),
(2, 8, 5, 9, '2025-03-24', '11:00:00', 'PSGITECH', 5, 'Scheduled', '2025-03-23 15:37:11', '2025-03-24 14:32:25', 15, 10),
(3, 8, 10, 11, '2025-03-25', '11:30:00', 'KCT', NULL, 'Scheduled', '2025-03-24 14:51:11', '2025-03-24 14:51:11', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `team_id` int(11) NOT NULL,
  `team_name` varchar(100) NOT NULL,
  `s_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teams`
--

INSERT INTO `teams` (`team_id`, `team_name`, `s_id`, `c_id`, `created_at`) VALUES
(5, 'myteam1', 8, 8, '2025-03-23 12:15:55'),
(6, 'kct cricketers', 2, 7, '2025-03-23 12:46:07'),
(8, 'cricket friends', 2, 9, '2025-03-23 13:31:31'),
(9, 'csk', 8, 10, '2025-03-23 15:36:20'),
(10, 'raju vb boys', 8, 11, '2025-03-24 14:39:40'),
(11, 'ramu vb boys', 8, 12, '2025-03-24 14:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `team_players`
--

CREATE TABLE `team_players` (
  `player_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `player_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `team_players`
--

INSERT INTO `team_players` (`player_id`, `team_id`, `player_name`, `created_at`) VALUES
(46, 5, 'raj', '2025-03-23 12:15:55'),
(47, 5, 'mithra', '2025-03-23 12:15:55'),
(48, 5, 'eni', '2025-03-23 12:15:55'),
(49, 5, 'laksmi', '2025-03-23 12:15:55'),
(50, 5, 'praveen k', '2025-03-23 12:15:55'),
(51, 5, 'priya', '2025-03-23 12:15:55'),
(52, 5, 'pranika', '2025-03-23 12:15:55'),
(53, 5, 'shree', '2025-03-23 12:15:55'),
(54, 5, 'akshu', '2025-03-23 12:15:55'),
(55, 5, 'dinesh', '2025-03-23 12:15:55'),
(56, 5, 'eniyavan', '2025-03-23 12:15:55'),
(57, 5, 'anu', '2025-03-23 12:15:55'),
(58, 6, 'gangaraj', '2025-03-23 12:46:07'),
(59, 6, 'mithra', '2025-03-23 12:46:07'),
(60, 6, 'ram', '2025-03-23 12:46:07'),
(61, 6, 'laksmi', '2025-03-23 12:46:07'),
(62, 6, 'praveen k', '2025-03-23 12:46:07'),
(63, 6, 'priya', '2025-03-23 12:46:07'),
(64, 6, 'pranika', '2025-03-23 12:46:07'),
(65, 6, 'gangamithra', '2025-03-23 12:46:07'),
(66, 6, 'akshu', '2025-03-23 12:46:07'),
(67, 6, 'dinesh', '2025-03-23 12:46:07'),
(68, 6, 'eniyavan', '2025-03-23 12:46:07'),
(69, 6, 'diva', '2025-03-23 12:46:07'),
(70, 6, 'sreya', '2025-03-23 12:46:07'),
(71, 6, 'shreekutty', '2025-03-23 12:46:07'),
(72, 6, 'pooj', '2025-03-23 12:46:07'),
(88, 8, 'abi', '2025-03-23 13:31:31'),
(89, 8, 'aakash', '2025-03-23 13:31:31'),
(90, 8, 'sandhiya', '2025-03-23 13:31:31'),
(91, 8, 'sanjee', '2025-03-23 13:31:31'),
(92, 8, 'dineshwar', '2025-03-23 13:31:31'),
(93, 8, 'shreedevi', '2025-03-23 13:31:31'),
(94, 8, 'ysr', '2025-03-23 13:31:31'),
(95, 8, 'karthick', '2025-03-23 13:31:31'),
(96, 8, 'raja', '2025-03-23 13:31:31'),
(97, 8, 'rani', '2025-03-23 13:31:31'),
(98, 8, 'king', '2025-03-23 13:31:31'),
(99, 8, 'queen', '2025-03-23 13:31:31'),
(100, 8, 'lachu', '2025-03-23 13:31:31'),
(101, 8, 'ramu', '2025-03-23 13:31:31'),
(102, 8, 'mani', '2025-03-23 13:31:31'),
(103, 9, 'raju', '2025-03-23 15:36:20'),
(104, 9, 'bhavya', '2025-03-23 15:36:20'),
(105, 9, 'GANGARAJ', '2025-03-23 15:36:20'),
(106, 9, 'PRAVEEN KUMAR', '2025-03-23 15:36:20'),
(107, 9, 'PRIYANKA', '2025-03-23 15:36:20'),
(108, 9, 'AISWARYA', '2025-03-23 15:36:20'),
(109, 9, 'SHREE', '2025-03-23 15:36:20'),
(110, 9, 'RAM', '2025-03-23 15:36:20'),
(111, 9, 'LAKSHMI', '2025-03-23 15:36:20'),
(112, 9, 'MITHRA R', '2025-03-23 15:36:20'),
(113, 9, 'GRAJ', '2025-03-23 15:36:20'),
(114, 9, 'MANI', '2025-03-23 15:36:20'),
(115, 10, 'mithu', '2025-03-24 14:39:40'),
(116, 10, 'mithra', '2025-03-24 14:39:40'),
(117, 10, 'ram', '2025-03-24 14:39:40'),
(118, 10, 'PRAVEEN KUMAR', '2025-03-24 14:39:40'),
(119, 10, 'praveen k', '2025-03-24 14:39:40'),
(120, 10, 'priya', '2025-03-24 14:39:40'),
(121, 10, 'pranika', '2025-03-24 14:39:40'),
(122, 10, 'RAM', '2025-03-24 14:39:40'),
(123, 10, 'akshu', '2025-03-24 14:39:40'),
(124, 10, 'dinesh', '2025-03-24 14:39:40'),
(125, 10, 'eniyavan', '2025-03-24 14:39:40'),
(126, 10, 'MANI', '2025-03-24 14:39:40'),
(127, 11, 'abi', '2025-03-24 14:50:19'),
(128, 11, 'aakash', '2025-03-24 14:50:19'),
(129, 11, 'GANGARAJ', '2025-03-24 14:50:19'),
(130, 11, 'PRAVEEN KUMAR', '2025-03-24 14:50:19'),
(131, 11, 'praveen k', '2025-03-24 14:50:19'),
(132, 11, 'AISWARYA', '2025-03-24 14:50:19'),
(133, 11, 'SHREE', '2025-03-24 14:50:19'),
(134, 11, 'gangamithra', '2025-03-24 14:50:19'),
(135, 11, 'anugraha', '2025-03-24 14:50:19'),
(136, 11, 'rani', '2025-03-24 14:50:19'),
(137, 11, 'GRAJ', '2025-03-24 14:50:19'),
(138, 11, 'RAMU V', '2025-03-24 14:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `s_username` varchar(45) NOT NULL,
  `s_pwd` varchar(45) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_location` varchar(100) NOT NULL,
  `s_email` varchar(100) NOT NULL,
  `s_phoneno` varchar(45) NOT NULL,
  `s_pic` text DEFAULT NULL,
  `s_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`s_username`, `s_pwd`, `s_name`, `s_location`, `s_email`, `s_phoneno`, `s_pic`, `s_id`) VALUES
('akshaya', 'akshaya12', 'yugam', 'KCT,coimbatore', 'akshaya12@gmail.com', '6380826186', 'tournament2.jpg', 2),
('akshaya', '', 'kalam', 'KCT,coimbatore', 'akshaya12@gmail.com', '6380826186', 'tournament8.jpg', 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ct_id`),
  ADD KEY `c_id` (`c_id`),
  ADD KEY `f_id` (`f_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`f_id`),
  ADD KEY `s_id` (`s_id`);

--
-- Indexes for table `mreg_detail`
--
ALTER TABLE `mreg_detail`
  ADD PRIMARY KEY (`ord_id`),
  ADD KEY `orh_id` (`orh_id`) USING BTREE,
  ADD KEY `f_id` (`f_id`) USING BTREE;

--
-- Indexes for table `mreg_status`
--
ALTER TABLE `mreg_status`
  ADD PRIMARY KEY (`orh_id`),
  ADD KEY `c_id` (`c_id`) USING BTREE,
  ADD KEY `s_id` (`s_id`) USING BTREE,
  ADD KEY `p_id` (`p_id`) USING BTREE;

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`c_id`),
  ADD UNIQUE KEY `c_username` (`c_username`),
  ADD UNIQUE KEY `c_email` (`c_email`);

--
-- Indexes for table `scheduled_matches`
--
ALTER TABLE `scheduled_matches`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `team1_id` (`team1_id`),
  ADD KEY `team2_id` (`team2_id`),
  ADD KEY `winner_team_id` (`winner_team_id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`team_id`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `c_id` (`c_id`);

--
-- Indexes for table `team_players`
--
ALTER TABLE `team_players`
  ADD PRIMARY KEY (`player_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`s_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ct_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `mreg_detail`
--
ALTER TABLE `mreg_detail`
  MODIFY `ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `mreg_status`
--
ALTER TABLE `mreg_status`
  MODIFY `orh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `scheduled_matches`
--
ALTER TABLE `scheduled_matches`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `team_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `team_players`
--
ALTER TABLE `team_players`
  MODIFY `player_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scheduled_matches`
--
ALTER TABLE `scheduled_matches`
  ADD CONSTRAINT `scheduled_matches_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `matches` (`s_id`),
  ADD CONSTRAINT `scheduled_matches_ibfk_2` FOREIGN KEY (`team1_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `scheduled_matches_ibfk_3` FOREIGN KEY (`team2_id`) REFERENCES `teams` (`team_id`),
  ADD CONSTRAINT `scheduled_matches_ibfk_4` FOREIGN KEY (`winner_team_id`) REFERENCES `teams` (`team_id`);

--
-- Constraints for table `teams`
--
ALTER TABLE `teams`
  ADD CONSTRAINT `teams_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `matches` (`s_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `teams_ibfk_2` FOREIGN KEY (`c_id`) REFERENCES `player` (`c_id`) ON DELETE CASCADE;

--
-- Constraints for table `team_players`
--
ALTER TABLE `team_players`
  ADD CONSTRAINT `team_players_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `teams` (`team_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
