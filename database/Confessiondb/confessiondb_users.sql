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
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` text,
  `bio` text,
  `role_id` int NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `remember_token` varchar(64) DEFAULT NULL,
  `dark_mode` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (17,'Thang','Nguyen','thang123','toanthangnee123','toanthang@gmail.com','$2y$10$Jsky8BTGjlVbdo5m7aOKVeftO838mhbvoZJI96k/NWO4rj.hSuZJG','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745433294/avatars/gwqiji6ymovo6sxkti3j.jpg','',1,'2025-04-05',NULL,NULL,1),(20,'Horus','Weaver','horus0312','horuss.if','vominhnghia1878@gmail.com','$2y$10$T3WwXHmrbQBY2J.bY9rUc.yCEQJphTLmAKpPGgOckzf9KsT/g.s8u','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745509854/avatars/lkfwe0eszvqcv6j9uy6a.jpg','Hello, this is my bio after editing',2,'2025-04-16',NULL,NULL,0),(22,'Mary','Weaver','maryw201','maryw201','maryw@gmail.com','$2y$10$gfm.xTRmwdMyiwllVbLNCecDLNSl8ubv83J1UA8GlQ5u2QFz8AEI.','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745400402/avatars/e0wkhx0dnnvwuznwfthf.jpg','',1,'2025-04-20',NULL,NULL,0),(23,'Emma','Carter','emma_dev','studyWithEmma','emma.carter@example.com','$2y$10$vl4j3PYxvrwIP/ntBhhaOe0QFdZcrJnVDPZi7c4QqpxGzatnjYnN2','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745394716/avatars/zmtnw512csmenooqe3zk.jpg','',1,'2025-04-23',NULL,NULL,1),(24,'Jack','Thompson','jack_thompson88','thisisjack','jack.thompson88@example.com','$2y$10$y3/9xdyqXnVByxgiHTZ58.zq/..jPh8hnp8fQQ4FwMOfYx/HPpyH.','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745395904/avatars/hwhdfpghpugc7dytiwtj.jpg','',1,'2025-04-23',NULL,NULL,0),(25,'Olivia','Reed','olivia.tech','olir264','olivia.reed@example.com','$2y$10$B8YakE88Cp2nBLuCoDJvpOnLgWhxzhHathUl7TAk2LGzva7LDXLPG','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745397795/avatars/dpxop6pxe22u2lfxhza5.jpg','',1,'2025-04-23',NULL,NULL,0),(26,'Ethan','Brooks','ethanbrooks_dev','iambrooks578','ethan.brooks@example.com','$2y$10$X6G9HsjRx/K6./IqON2rkuLJByqWBwQwTIOcxmtrybUYcDuQoCZYu','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745395988/avatars/innfqhkhicc71rhq9jyt.jpg','',1,'2025-04-23',NULL,NULL,1),(27,'Mason','Matthews','mama18','masma18','mason.matthews@example.com','$2y$10$h7/JhJzEr3B6FeqmyyJtHuDvnAUeF2crc1AWN5A0nQfKoV0UUO7.G','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745400280/avatars/jrn3qscwlkofglttobpr.jpg','',1,'2025-04-23',NULL,NULL,0),(28,'Sophia','Mitchell','sophia.codes','sophia49','sophia.mitchell@example.com','$2y$10$obuqlan6DtBf.rUYohstsezi2YxzpR3agAhk7Zu.clbAtVpZf9i4u','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745396243/avatars/uchywvvm89njaimmnkla.jpg','',1,'2025-04-23',NULL,NULL,0),(29,'Lucas','Bennett','lucas.backend','lucaslearning24','lucas.bennett@example.com','$2y$10$I6h0V04gnS4jBn7e/ItjHebQ24XUF.BV5yb0uRym3ECmanV3olidu','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745397166/avatars/olf5thrlx7xctkidr1km.jpg','',1,'2025-04-23',NULL,NULL,0),(30,'Ava','Sanders','ava_uiux','askAva','ava.sanders@example.com','$2y$10$jHrZuhVu9FkvYyAMbeyXiOhn0cDYmax0hSh0iVUcBwKSaJ5UdvrRy','https://res.cloudinary.com/dukqnp6n9/image/upload/v1745396582/avatars/evknkxgrzuydtffxjkzr.jpg','',1,'2025-04-23',NULL,NULL,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
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
