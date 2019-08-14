-- MySQL dump 10.17  Distrib 10.3.12-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: LANLadder
-- ------------------------------------------------------
-- Server version	10.3.12-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ladder`
--

DROP TABLE IF EXISTS `ladder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ladder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `players` tinyint(4) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ladder`
--

LOCK TABLES `ladder` WRITE;
/*!40000 ALTER TABLE `ladder` DISABLE KEYS */;
INSERT INTO `ladder` VALUES (1,'TF2','',6,'2019-08-14 00:08:48','000000','tf2.png'),(2,'Rocket League','',3,'2019-08-14 00:08:53','000000','rocketleague.jpeg'),(3,'CS GO','',5,'2019-08-14 00:08:58','000000','csgo.jpg\r\n');
/*!40000 ALTER TABLE `ladder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `played_match`
--

DROP TABLE IF EXISTS `played_match`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `played_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_a_id` int(11) NOT NULL,
  `team_b_id` int(11) NOT NULL,
  `ladder_id` int(11) NOT NULL,
  `winning_team_id` int(11) NOT NULL,
  `losing_team_id` int(11) NOT NULL,
  `match_start` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `team_a_id` (`team_a_id`),
  KEY `team_b_id` (`team_b_id`),
  KEY `ladder_id` (`ladder_id`),
  KEY `losing_team_id` (`losing_team_id`),
  KEY `winning_team_id` (`winning_team_id`),
  CONSTRAINT `played_match_ibfk_1` FOREIGN KEY (`ladder_id`) REFERENCES `ladder` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `played_match_ibfk_2` FOREIGN KEY (`winning_team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `played_match_ibfk_3` FOREIGN KEY (`team_a_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `played_match_ibfk_4` FOREIGN KEY (`team_b_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `played_match_ibfk_9` FOREIGN KEY (`losing_team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `played_match`
--

LOCK TABLES `played_match` WRITE;
/*!40000 ALTER TABLE `played_match` DISABLE KEYS */;
INSERT INTO `played_match` VALUES (1,3,6,3,3,6,'2019-08-09 11:30:13'),(2,3,4,3,3,4,'0000-00-00 00:00:00'),(3,6,4,3,4,3,'2019-08-10 02:04:49'),(4,3,4,3,3,4,'0000-00-00 00:00:00'),(5,3,6,2,1,1,'2019-08-09 12:11:17'),(6,5,4,2,1,1,'2019-08-09 12:11:30'),(7,4,3,2,3,1,'2019-08-09 11:29:19');
/*!40000 ALTER TABLE `played_match` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(24) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `seated_loc` varchar(24) NOT NULL,
  `image` varchar(24) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_privileges` varchar(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `team_id` (`team_id`),
  CONSTRAINT `player_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `player`
--

LOCK TABLES `player` WRITE;
/*!40000 ALTER TABLE `player` DISABLE KEYS */;
INSERT INTO `player` VALUES (1,'fragspawn','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','window','ra-wooden-sign',2,'1'),(2,'kandigalaxy','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','centre','ra-speech-bubble',3,'0'),(3,'beatlecrusher','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','front','ra-rifle',2,'0'),(4,'craigmod','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','back','ra-muscle-fat',3,'0'),(5,'binglee','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','door','ra-kettlebell',4,'0'),(6,'vincesurf','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','centre','ra-frostfire',4,'0'),(7,'adamant','$2y$10$8RXCXyEy5ahpruAKMBigDu101SM0da4eiEAeGEZAdi2ixmOo75pCu','isle','ra-droplet-splash',5,'0'),(8,'houley','$2y$10$gfKzfu7CDYFhFgyZCCM2F.xSsiVdJGv2MqlgOpyPd1mjOCdK2VJ1i','sky','ra-cracked-shield',1,'1');
/*!40000 ALTER TABLE `player` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_name` varchar(24) NOT NULL,
  `color` varchar(16) NOT NULL,
  `image` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team`
--

LOCK TABLES `team` WRITE;
/*!40000 ALTER TABLE `team` DISABLE KEYS */;
INSERT INTO `team` VALUES (1,'Unset','000000',''),(2,'Forefit','000000',''),(3,'readyriders','999900','ra-lightning-bolt'),(4,'bluebleechers','990000','ra-flat-hammer'),(5,'sunset','990099','ra-dragon-breath'),(6,'tsunami','009900','ra-cluster-bomb'),(7,'hawks','b73d00','ra-wyvern');
/*!40000 ALTER TABLE `team` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-14 20:30:57
