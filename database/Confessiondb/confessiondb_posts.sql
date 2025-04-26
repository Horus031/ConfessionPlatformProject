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
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `post_content` text,
  `module_id` int DEFAULT NULL,
  `imageURL` text,
  `is_anonymous` tinyint(1) DEFAULT '0',
  `view_count` int DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  KEY `posts_ibfk_2` (`user_id`),
  KEY `posts_ibfk_3` (`module_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`module_id`) REFERENCES `modules` (`module_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (137,22,'Hello, this is my first post after edit','Welcome everyone',0,'https://res.cloudinary.com/dukqnp6n9/image/upload/v1745301586/posts/rjxbqjkyopru4k4my6oo.jpg',0,1,'2025-04-22 12:59:46'),(138,23,'How do you effectively manage study time during final exam season?','I\'ve tried making a schedule, but I always end up falling behind. Any tips on staying consistent and not burning out?',4,'https://res.cloudinary.com/dukqnp6n9/image/upload/v1745392510/posts/qphs7acrtw1lvpq9rxoy.jpg',0,4,'2025-04-23 14:15:13'),(139,24,'Why do we learn quadratic equations if we don\'t use them in real life?','I\'m struggling to understand the practical application of quadratic equations. My teacher says they\'re important, but I’m not convinced. Can someone explain?',2,'https://res.cloudinary.com/dukqnp6n9/image/upload/v1745393547/posts/zotu1ukq8lskure5vkwq.png',0,4,'2025-04-23 14:32:30'),(140,26,'Is it better to focus on one career path early or explore multiple interests in college?','I’m entering university soon and I’m torn. Should I pick one clear goal, or experiment a bit before deciding?',6,'https://res.cloudinary.com/dukqnp6n9/image/upload/v1745393716/posts/diggrmq4uqq7bxyswdow.jpg',0,5,'2025-04-23 14:35:19'),(141,28,'Any good techniques for memorizing history dates and events?','I always confuse dates, especially in modern history. Flashcards only work a little. Any alternative methods?',4,'https://res.cloudinary.com/dukqnp6n9/image/upload/v1745393823/posts/mtwsoccejm0wfw6nszyp.jpg',0,6,'2025-04-23 14:37:06');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
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
