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
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `tag_id` int NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(50) DEFAULT NULL,
  `tag_description` text,
  `tag_type` varchar(25) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Mathematics','Questions related to algebra, calculus, geometry, and more.','general'),(2,'Physics','Covers mechanics, thermodynamics, electromagnetism, and quantum physics.','general'),(3,'Chemistry','Discussions on organic, inorganic, and physical chemistry.','general'),(4,'Biology','Topics on genetics, microbiology, anatomy, and ecology.','general'),(5,'Computer Science','Covers programming, algorithms, data structures, and AI.','general'),(6,'History','Questions about world history, civilizations, and historical events.','general'),(7,'Geography','Covers maps, climate, and geographical phenomena.','general'),(8,'English Language','Grammar, vocabulary, and literature discussions.','general'),(9,'Economics','Questions about microeconomics, macroeconomics, and finance.','general'),(10,'HTML&CSS','Covers the foundation of web development, including structuring content with HTML and styling with CSS. Topics include layouts, responsive design, and best practices.','prog&tech'),(11,'JavaScript','The core programming language for web development. Used for creating interactive websites, handling DOM manipulation, and working with frameworks like React and Vue.','prog&tech'),(12,'Python','A versatile, beginner-friendly language used in web development, data science, AI, and automation. Topics include syntax, libraries, and coding best practices.','prog&tech'),(13,'Java','A widely-used, object-oriented programming language known for its use in Android app development, enterprise applications, and backend systems.','prog&tech'),(14,'C++','A powerful language used in competitive programming, game development, and system-level programming. Topics include memory management, OOP, and algorithms.','prog&tech'),(15,'C#','A language mainly used for game development with Unity, Windows applications, and enterprise software. Topics include OOP, .NET framework, and performance optimization.','prog&tech'),(16,'PHP','A server-side scripting language used for web development and backend applications. Topics include database interactions, authentication, and security.','prog&tech'),(17,'SQL&Database','Covers database management, SQL queries, normalization, indexing, and best practices for efficient data storage and retrieval.','prog&tech'),(18,'Swift','The primary language for iOS app development. Covers Swift syntax, UI design with SwiftUI, and Apple’s development ecosystem.','prog&tech'),(19,'Kotlin','A modern language for Android app development, offering concise syntax and interoperability with Java. Topics include Android Studio, UI components, and app architecture.','prog&tech'),(20,'Golang','A fast, efficient language used for cloud computing, microservices, and backend development. Covers concurrency, performance, and Go’s standard library.','prog&tech'),(21,'Rust','A systems programming language focused on memory safety and high performance. Used in embedded systems, game engines, and web assembly.','prog&tech'),(22,'Cybersecurity','Covers ethical hacking, encryption, penetration testing, and network security concepts to protect systems from cyber threats.','prog&tech'),(23,'AI','Discusses AI principles, machine learning, deep learning, and frameworks like TensorFlow and PyTorch for developing intelligent systems.','prog&tech'),(24,'StudyTips','Strategies for better learning and retention.','study'),(25,'ExamPreparation','Tips for acing exams and managing stress.','study'),(26,'TimeManagement','Advice on productivity and scheduling.','study'),(27,'CollegeAdmissions','Questions about applying to universities.','career'),(28,'Internships','Guidance on finding internships and career paths.','career'),(29,'Scholarships','Guidance on finding internships and career paths.','career');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
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
