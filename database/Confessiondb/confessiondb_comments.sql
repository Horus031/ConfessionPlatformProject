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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comments` (
  `comment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `content` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `comments_ibfk_1` (`user_id`),
  KEY `comments_ibfk_2` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (147,20,137,'Hello, nice to meet you, good post!','2025-04-22 23:18:05'),(148,26,138,'Try the Pomodoro technique — 25 minutes of study, 5 minutes break. It helped me survive exam weeks.','2025-04-23 15:19:37'),(149,28,138,'Don\'t forget to schedule rest. Studying 12 hours a day without breaks is a trap!','2025-04-23 15:21:30'),(150,30,138,'I use Notion to plan out each week and track what I’ve done — helps me stay motivated.','2025-04-23 15:29:28'),(151,29,139,'Great question! Quadratics are used in physics (e.g., projectile motion), economics (max profit problems), and even in computer graphics.','2025-04-23 15:33:09'),(152,23,139,'I felt the same until I started programming — suddenly it all made sense.','2025-04-23 15:35:49'),(153,25,139,'They help you build logical thinking skills, which matter in any career.','2025-04-23 15:43:53'),(154,23,140,'Everyone need the time to know themselves. Exploring helped me realize I loved data science more than web dev. So don’t rush!','2025-04-23 15:45:23'),(155,30,140,'I think it\'s wise to try different classes early on. You’ll be surprised what clicks.','2025-04-23 15:46:13'),(156,29,140,'Having a rough direction so you don’t feel too lost — I wasted two semesters switching majors. Keep it up!','2025-04-23 15:47:25'),(171,27,141,'I use timeline apps where I visually arrange events. Helps a lot!','2025-04-23 16:25:15'),(172,22,141,'Try creating a story or comic strip to connect events — the sillier, the more memorable.','2025-04-23 16:27:09'),(173,25,141,'Group events by theme or cause-effect patterns. That gives context and helps retention.','2025-04-23 16:27:59'),(174,20,138,'Make a planner and put it somewhere you see it often, and your goals, this will help a lot.','2025-04-24 14:24:05');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-27  2:43:32
