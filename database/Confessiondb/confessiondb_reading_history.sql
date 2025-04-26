-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: confessiondb
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `reading_history`
--

DROP TABLE IF EXISTS `reading_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reading_history` (
  `history_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `read_date` date NOT NULL,
  PRIMARY KEY (`history_id`),
  UNIQUE KEY `unique_user_post_date` (`user_id`,`post_id`,`read_date`),
  KEY `reading_history_ibfk_2` (`post_id`),
  CONSTRAINT `reading_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `reading_history_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=342 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reading_history`
--

LOCK TABLES `reading_history` WRITE;
/*!40000 ALTER TABLE `reading_history` DISABLE KEYS */;
INSERT INTO `reading_history` VALUES (287,20,137,'2025-04-22'),(328,20,138,'2025-04-24'),(327,20,139,'2025-04-24'),(338,20,139,'2025-04-26'),(320,20,140,'2025-04-23'),(329,20,140,'2025-04-24'),(323,20,141,'2025-04-23'),(337,20,141,'2025-04-26'),(307,22,141,'2025-04-23'),(290,23,139,'2025-04-23'),(297,23,140,'2025-04-23'),(289,23,141,'2025-04-23'),(302,25,139,'2025-04-23'),(311,25,140,'2025-04-23'),(308,25,141,'2025-04-23'),(293,26,138,'2025-04-23'),(291,26,141,'2025-04-23'),(306,27,141,'2025-04-23'),(292,28,138,'2025-04-23'),(296,29,139,'2025-04-23'),(305,29,140,'2025-04-23'),(295,30,138,'2025-04-23'),(304,30,140,'2025-04-23');
/*!40000 ALTER TABLE `reading_history` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-27  2:43:31
