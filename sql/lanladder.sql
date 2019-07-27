-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 12, 2018 at 03:06 AM
-- Server version: 5.7.21
-- PHP Version: 7.1.16

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

DROP TABLE IF EXISTS `ladder`;
CREATE TABLE IF NOT EXISTS `ladder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `players` tinyint(4) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

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

DROP TABLE IF EXISTS `played_match`;
CREATE TABLE IF NOT EXISTS `played_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_a_id` int(11) NOT NULL,
  `team_b_id` int(11) NOT NULL,
  `ladder_id` int(11) NOT NULL,
  `winning_team_id` int(11) NOT NULL,
  `losing_team_id` int(11) NOT NULL,
  `match_start` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `team_a_id` (`team_a_id`),
  KEY `team_b_id` (`team_b_id`),
  KEY `ladder_id` (`ladder_id`),
  KEY `losing_team_id` (`losing_team_id`),
  KEY `winning_team_id` (`winning_team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `played_match`
--

INSERT INTO `played_match` (`id`, `team_a_id`, `team_b_id`, `ladder_id`, `winning_team_id`, `losing_team_id`, `match_start`) VALUES
(1, 3, 2, 3, 3, 1, '0000-00-00 00:00:00'),
(2, 3, 4, 3, 3, 4, '0000-00-00 00:00:00'),
(3, 2, 4, 3, 4, 2, '0000-00-00 00:00:00'),
(4, 3, 4, 3, 3, 4, '0000-00-00 00:00:00'),
(5, 3, 2, 2, 1, 1, '0000-00-00 00:00:00'),
(6, 2, 4, 2, 1, 1, '0000-00-00 00:00:00'),
(7, 4, 3, 2, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `seated_loc` varchar(24) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_privileges` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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
(7, 'adamant', '$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu', 'isle', 5, '0'),
(8, 'houley', '$2y$10$gfKzfu7CDYFhFgyZCCM2F.xSsiVdJGv2MqlgOpyPd1mjOCdK2VJ1i', 'sky', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(24) NOT NULL,
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `team_name`, `color`, `image`) VALUES
(1, 'Unset', 'black', ''),
(2, 'Forefit', 'black', ''),
(3, 'readyriders', 'forestgreen', 'readycreek.jpeg'),
(4, 'bluebleechers', 'skyblue', 'bluebleechers.jpg'),
(5, 'sunset', 'yellow', 'sunset.jpeg'),
(6, 'tsunami', 'oceanblue', 'tsunami.jpeg');

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
