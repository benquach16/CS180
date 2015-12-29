-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_list`
--

DROP TABLE IF EXISTS `auth_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_list` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(32) NOT NULL,
  `pass` varchar(512) DEFAULT NULL,
  `currency` int(8) NOT NULL,
  `friends_list` varchar(512) NOT NULL,
  `premium_currency` int(8) NOT NULL,
  `select_pet` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_list`
--

LOCK TABLES `auth_list` WRITE;
/*!40000 ALTER TABLE `auth_list` DISABLE KEYS */;
INSERT INTO `auth_list` VALUES (1,'test','0925467e1cc53074a440dae7ae67e3e9',1282,'',0,1),(2,'admin','21232f297a57a5a743894a0e4a801fc3',0,'',0,0),(3,'user','ee11cbb19052e40b07aac0ca060c23ee',0,'',0,0),(4,'testuser','5d9c68c6c50ed3d02a2fcf54f63993b6',0,'',0,1),(5,'ben','7fe4771c008a22eb763df47d19e2c6aa',0,'',0,0);
/*!40000 ALTER TABLE `auth_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends_list`
--

DROP TABLE IF EXISTS `friends_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends_list` (
  `id_A` int(6) NOT NULL,
  `id_B` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends_list`
--

LOCK TABLES `friends_list` WRITE;
/*!40000 ALTER TABLE `friends_list` DISABLE KEYS */;
INSERT INTO `friends_list` VALUES (1,2),(2,1),(1,5),(5,1);
/*!40000 ALTER TABLE `friends_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gun_list`
--

DROP TABLE IF EXISTS `gun_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gun_list` (
  `item_name` varchar(16) NOT NULL,
  `item_speed` tinyint(3) NOT NULL,
  `item_range` tinyint(3) NOT NULL,
  `item_clip` mediumint(4) NOT NULL,
  `item_damage` tinyint(3) NOT NULL,
  `item_weight` tinyint(3) NOT NULL,
  PRIMARY KEY (`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gun_list`
--

LOCK TABLES `gun_list` WRITE;
/*!40000 ALTER TABLE `gun_list` DISABLE KEYS */;
INSERT INTO `gun_list` VALUES ('Glock Pistol',2,4,16,5,5);
/*!40000 ALTER TABLE `gun_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_list`
--

DROP TABLE IF EXISTS `inv_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_list` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `slot1` smallint(6) NOT NULL,
  `slot2` smallint(6) NOT NULL,
  `slot3` smallint(6) NOT NULL,
  `slot4` smallint(6) NOT NULL,
  `slot5` smallint(6) NOT NULL,
  `slot6` smallint(6) NOT NULL,
  `slot7` smallint(6) NOT NULL,
  `slot8` smallint(6) NOT NULL,
  `slot9` smallint(6) NOT NULL,
  `slot10` smallint(6) NOT NULL,
  `slot11` smallint(6) NOT NULL,
  `slot12` smallint(6) NOT NULL,
  `slot13` smallint(6) NOT NULL,
  `slot14` smallint(6) NOT NULL,
  `slot15` smallint(6) NOT NULL,
  `slot16` smallint(6) NOT NULL,
  `slot17` smallint(6) NOT NULL,
  `slot18` smallint(6) NOT NULL,
  `slot19` smallint(6) NOT NULL,
  `slot20` smallint(6) NOT NULL,
  `slot21` smallint(6) NOT NULL,
  `slot22` smallint(6) NOT NULL,
  `slot23` smallint(6) NOT NULL,
  `slot24` smallint(6) NOT NULL,
  `slot25` smallint(6) NOT NULL,
  `slot26` smallint(6) NOT NULL,
  `slot27` smallint(6) NOT NULL,
  `slot28` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_list`
--

LOCK TABLES `inv_list` WRITE;
/*!40000 ALTER TABLE `inv_list` DISABLE KEYS */;
INSERT INTO `inv_list` VALUES (1,4,3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(3,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(4,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),(5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `inv_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `matchmaking`
--

DROP TABLE IF EXISTS `matchmaking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `matchmaking` (
  `id` int(11) NOT NULL DEFAULT '0',
  `playerID` int(11) NOT NULL,
  `petID` int(11) NOT NULL,
  `peerID` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matchmaking`
--

LOCK TABLES `matchmaking` WRITE;
/*!40000 ALTER TABLE `matchmaking` DISABLE KEYS */;
/*!40000 ALTER TABLE `matchmaking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications_list`
--

DROP TABLE IF EXISTS `notifications_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications_list` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `receiver_id` int(6) NOT NULL,
  `sender_id` int(6) NOT NULL,
  `notification_type` int(6) NOT NULL,
  `sender` varchar(32) NOT NULL,
  `message` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications_list`
--

LOCK TABLES `notifications_list` WRITE;
/*!40000 ALTER TABLE `notifications_list` DISABLE KEYS */;
INSERT INTO `notifications_list` VALUES (2,2,1,1,'test','hi admin!'),(3,2,1,1,'test','testsdfsddsfsdf'),(4,1,2,1,'admin','message'),(6,5,1,1,'test','Hi Ben, Im test');
/*!40000 ALTER TABLE `notifications_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pet_list`
--

DROP TABLE IF EXISTS `pet_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pet_list` (
  `id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `name` varchar(16) NOT NULL,
  `hat` mediumint(6) NOT NULL,
  `top` mediumint(6) NOT NULL,
  `bottom` mediumint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pet_list`
--

LOCK TABLES `pet_list` WRITE;
/*!40000 ALTER TABLE `pet_list` DISABLE KEYS */;
INSERT INTO `pet_list` VALUES (1,'lion','mista whiskas',0,0,0),(2,'gator','lizardbro',0,0,0),(3,'gator','captain cupcakes',0,0,0),(4,'gator','meow meows',0,0,0),(5,'gator','supaleetkilla',0,0,0),(6,'bunny','mr sprinkles',0,0,0),(7,'bunny','Mr. Sprinnkles',0,0,0),(8,'bunny','Mr. Rabbits',1,2,0);
/*!40000 ALTER TABLE `pet_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `team_list`
--

DROP TABLE IF EXISTS `team_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team_list` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `pet1` int(6) NOT NULL,
  `pet2` int(6) NOT NULL,
  `pet3` int(6) NOT NULL,
  `pet4` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `team_list`
--

LOCK TABLES `team_list` WRITE;
/*!40000 ALTER TABLE `team_list` DISABLE KEYS */;
INSERT INTO `team_list` VALUES (1,1,3,8,0),(2,2,0,0,0),(3,4,0,0,0),(4,5,6,0,0),(5,7,0,0,0);
/*!40000 ALTER TABLE `team_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_posts`
--

DROP TABLE IF EXISTS `user_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_posts` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userid` int(6) NOT NULL,
  `user` varchar(32) NOT NULL,
  `post` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_posts`
--

LOCK TABLES `user_posts` WRITE;
/*!40000 ALTER TABLE `user_posts` DISABLE KEYS */;
INSERT INTO `user_posts` VALUES (1,1,'test','this is a post'),(2,1,'test','hi'),(3,3,'user','meow'),(4,4,'testuser','hello my name is '),(5,5,'ben','Hi my name is mr sprinkles'),(6,1,'test','i eatcats'),(7,1,'test','fuck me with a spear'),(8,1,'test','fuck me with a halberd'),(9,1,'test','fuck me with a halberd'),(10,1,'test','captain cupcakes is my friend');
/*!40000 ALTER TABLE `user_posts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-12-29  1:00:11
