-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2018 at 08:25 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lanladder`
--

-- --------------------------------------------------------

--
-- Table structure for table `ladder`
--

CREATE TABLE `ladder` (
  `id` int(11) NOT NULL,
  `game` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `players` tinyint(4) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ladder`
--

INSERT INTO `ladder` (`id`, `game`, `description`, `players`, `start_time`, `color`, `image`) VALUES
(1, 'TF2', '', 6, '2018-06-11 01:13:27', 'orange', 'tf2.png'),
(2, 'Rocket League', '', 3, '2018-06-11 01:13:30', 'navyblue', 'rocketleague.jpeg'),
(3, 'CS GO', '', 5, '2018-06-11 01:13:33', 'brown', 'csgo.jpg\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `played_match`
--

CREATE TABLE `played_match` (
  `id` int(11) NOT NULL,
  `team_a_id` int(11) NOT NULL,
  `team_b_id` int(11) NOT NULL,
  `ladder_id` int(11) NOT NULL,
  `winning_team_id` int(11) NOT NULL,
  `losing_team_id` int(11) NOT NULL,
  `match_start` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `played_match`
--

INSERT INTO `played_match` (`id`, `team_a_id`, `team_b_id`, `ladder_id`, `winning_team_id`, `losing_team_id`, `match_start`) VALUES
(1, 3, 2, 3, 3, 1, '0000-00-00 00:00:00'),
(2, 3, 4, 3, 3, 4, '0000-00-00 00:00:00'),
(3, 2, 4, 3, 4, 2, '0000-00-00 00:00:00'),
(4, 3, 4, 3, 3, 4, '0000-00-00 00:00:00'),
(5, 3, 2, 2, 1, 1, '0000-00-00 00:00:00'),
(6, 2, 4, 2, 1, 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `name` varchar(24) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `seated_loc` varchar(24) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_privileges` varchar(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`id`, `name`, `pass`, `seated_loc`, `team_id`, `user_privileges`) VALUES
(1, 'fragspawn', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'window', 2, '1'),
(2, 'kandigalaxy', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'centre', 3, '0'),
(3, 'beatlecrusher', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'front', 2, '0'),
(4, 'craigmod', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'back', 3, '0'),
(5, 'binglee', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'door', 4, '0'),
(6, 'vincesurf', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'centre', 4, '0'),
(7, 'adamant', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'isle', 5, '0');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `team_name` varchar(24) NOT NULL,
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `team_name`, `color`, `image`) VALUES
(1, 'Unset', 'black', ''),
(2, 'readyriders', 'forestgreen', 'readycreek.jpeg'),
(3, 'bluebleechers', 'skyblue', 'bluebleechers.jpg'),
(4, 'sunset', 'yellow', 'sunset.jpeg'),
(5, 'tsunami', 'oceanblue', 'tsunami.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ladder`
--
ALTER TABLE `ladder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `played_match`
--
ALTER TABLE `played_match`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_a_id` (`team_a_id`),
  ADD KEY `team_b_id` (`team_b_id`),
  ADD KEY `ladder_id` (`ladder_id`),
  ADD KEY `losing_team_id` (`losing_team_id`),
  ADD KEY `winning_team_id` (`winning_team_id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ladder`
--
ALTER TABLE `ladder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `played_match`
--
ALTER TABLE `played_match`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `played_match`
--
ALTER TABLE `played_match`
  ADD CONSTRAINT `played_match_ibfk_1` FOREIGN KEY (`ladder_id`) REFERENCES `ladder` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `played_match_ibfk_2` FOREIGN KEY (`winning_team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `played_match_ibfk_3` FOREIGN KEY (`team_a_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `played_match_ibfk_4` FOREIGN KEY (`team_b_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `played_match_ibfk_9` FOREIGN KEY (`losing_team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
