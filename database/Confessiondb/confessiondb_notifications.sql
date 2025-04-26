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
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `notification_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `sender_id` int NOT NULL,
  `type` enum('like','comment','follow','new_post') DEFAULT NULL,
  `message` text,
  `message_content` text,
  `url` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`notification_id`),
  KEY `notifications_ibfk_1` (`user_id`),
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (225,17,5,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=120',0,'2025-04-05 17:06:21'),(228,17,5,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=120',0,'2025-04-11 14:50:25'),(229,17,5,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=120',0,'2025-04-11 14:54:08'),(239,22,20,'new_post','has shared a new post','Hello my followers','../views/main.html.php?page=postdetails&id=132',0,'2025-04-20 23:35:24'),(240,22,20,'new_post','has shared a new post','Test','../views/main.html.php?page=postdetails&id=136',0,'2025-04-21 14:01:39'),(241,22,20,'comment','has commented on your post!','Hello, nice to meet you, good post!','../views/main.html.php?page=postdetails&id=137',0,'2025-04-22 23:18:05'),(242,23,26,'comment','has commented on your post!','Try the Pomodoro technique — 25 minutes of study, 5 minutes break. It helped me survive exam weeks.','../views/main.html.php?page=postdetails&id=138',0,'2025-04-23 15:19:37'),(243,23,28,'comment','has commented on your post!','Don\'t forget to schedule rest. Studying 12 hours a day without breaks is a trap!','../views/main.html.php?page=postdetails&id=138',0,'2025-04-23 15:21:30'),(244,23,30,'comment','has commented on your post!','I use Notion to plan out each week and track what I’ve done — helps me stay motivated.','../views/main.html.php?page=postdetails&id=138',0,'2025-04-23 15:29:28'),(245,24,29,'comment','has commented on your post!','Great question! Quadratics are used in physics (e.g., projectile motion), economics (max profit problems), and even in computer graphics.','../views/main.html.php?page=postdetails&id=139',0,'2025-04-23 15:33:09'),(246,24,23,'comment','has commented on your post!','I felt the same until I started programming — suddenly it all made sense.','../views/main.html.php?page=postdetails&id=139',0,'2025-04-23 15:35:49'),(247,24,25,'comment','has commented on your post!','They help you build logical thinking skills, which matter in any career.','../views/main.html.php?page=postdetails&id=139',0,'2025-04-23 15:43:53'),(248,26,23,'comment','has commented on your post!','Everyone need the time to know themselves. Exploring helped me realize I loved data science more than web dev. So don’t rush!','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 15:45:24'),(249,26,30,'comment','has commented on your post!','I think it\'s wise to try different classes early on. You’ll be surprised what clicks.','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 15:46:13'),(250,26,29,'comment','has commented on your post!','But have a rough direction so you don’t feel too lost — I wasted two semesters switching majors.','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 15:47:25'),(251,26,29,'comment','has commented on your post!','Test comment','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 15:59:30'),(252,26,29,'comment','has commented on your post!','Test comments','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:01:29'),(253,26,29,'comment','has commented on your post!','Test commenttttt','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:02:06'),(254,26,29,'comment','has commented on your post!','Test comments','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:02:47'),(255,26,29,'comment','has commented on your post!','Testttttttttt','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:03:43'),(256,26,29,'comment','has commented on your post!','Test commentsssssss','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:09:33'),(257,26,29,'comment','has commented on your post!','Testttttttt','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:10:02'),(258,26,29,'comment','has commented on your post!','Test test','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:12:48'),(259,26,29,'comment','has commented on your post!','Test comment id','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:13:25'),(260,26,29,'comment','has commented on your post!','Test again','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:15:20'),(261,26,29,'comment','has commented on your post!','Test edit button','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:16:32'),(262,26,29,'comment','has commented on your post!','Test actionnnnnnnn','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:19:09'),(263,26,29,'comment','has commented on your post!','Test delete button','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:19:24'),(264,26,29,'comment','has commented on your post!','Test test','../views/main.html.php?page=postdetails&id=140',0,'2025-04-23 16:19:56'),(265,28,27,'comment','has commented on your post!','I use timeline apps where I visually arrange events. Helps a lot!','../views/main.html.php?page=postdetails&id=141',0,'2025-04-23 16:25:15'),(266,28,22,'comment','has commented on your post!','Try creating a story or comic strip to connect events — the sillier, the more memorable.','../views/main.html.php?page=postdetails&id=141',0,'2025-04-23 16:27:09'),(267,28,25,'comment','has commented on your post!','Group events by theme or cause-effect patterns. That gives context and helps retention.','../views/main.html.php?page=postdetails&id=141',0,'2025-04-23 16:27:59'),(268,23,20,'comment','has commented on your post!','Make a planner and put it somewhere you see it often, and your goals, this will help a lot.','../views/main.html.php?page=postdetails&id=138',0,'2025-04-24 14:24:05'),(269,26,20,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=140',0,'2025-04-24 14:36:22'),(270,28,20,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=141',0,'2025-04-24 14:37:16'),(271,23,20,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=138',0,'2025-04-24 15:06:55'),(272,22,20,'like','has liked your post!',NULL,'../views/main.html.php?page=postdetails&id=137',0,'2025-04-24 15:33:15'),(273,22,20,'new_post','has shared a new post','Hello everyone, this is my first post','../views/main.html.php?page=postdetails&id=142',0,'2025-04-24 16:00:06'),(274,22,20,'follow','has started following you!',NULL,'../views/main.html.php?page=profile&tag_name=horuss.if',0,'2025-04-24 17:41:53'),(275,22,20,'follow','has started following you!',NULL,'../views/main.html.php?page=profile&tag_name=horuss.if',0,'2025-04-24 17:42:10'),(281,22,20,'new_post','has shared a new post','Test','../views/main.html.php?page=postdetails&id=144',0,'2025-04-27 00:09:12');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
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
