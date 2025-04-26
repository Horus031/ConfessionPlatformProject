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
-- Table structure for table `user_tags_history`
--

DROP TABLE IF EXISTS `user_tags_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tags_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `tag_name` varchar(255) NOT NULL,
  `read_count` int DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`tag_name`),
  CONSTRAINT `user_tags_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=278 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tags_history`
--

LOCK TABLES `user_tags_history` WRITE;
/*!40000 ALTER TABLE `user_tags_history` DISABLE KEYS */;
INSERT INTO `user_tags_history` VALUES (141,17,'ExamPreparation',2),(145,17,'Mathematics',6),(146,17,'Geography',3),(157,17,'HTML&CSS',1),(173,20,'Mathematics',5),(174,22,'Mathematics',4),(178,20,'HTML&CSS',17),(184,22,'HTML&CSS',4),(189,22,'StudyTips',3),(196,23,'StudyTips',1),(197,23,'Mathematics',4),(198,26,'StudyTips',1),(199,28,'TimeManagement',2),(200,26,'TimeManagement',1),(202,30,'TimeManagement',1),(203,29,'Mathematics',1),(204,23,'CollegeAdmissions',2),(205,23,'Internships',2),(208,23,'HTML&CSS',1),(209,23,'JavaScript',1),(211,25,'Mathematics',1),(214,30,'CollegeAdmissions',1),(215,30,'Internships',1),(216,29,'CollegeAdmissions',1),(217,29,'Internships',1),(218,27,'StudyTips',1),(220,25,'StudyTips',4),(223,25,'CollegeAdmissions',7),(224,25,'Internships',7),(238,20,'CollegeAdmissions',7),(239,20,'Internships',7),(244,20,'StudyTips',3),(251,20,'TimeManagement',1),(256,20,'JavaScript',3),(258,20,'SQL&Database',2),(259,20,'PHP',2),(266,22,'Computer Science',2),(267,22,'Physics',2),(275,20,'Biology',1),(277,20,'Geography',1);
/*!40000 ALTER TABLE `user_tags_history` ENABLE KEYS */;
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
