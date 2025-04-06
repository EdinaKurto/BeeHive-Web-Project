-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: beehive_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_comments`
--

DROP TABLE IF EXISTS `blog_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_comments` (
  `blog_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`blog_comment_id`),
  KEY `blog_comments_blogs_FK` (`blog_id`),
  KEY `blog_comments_users_FK` (`user_id`),
  CONSTRAINT `blog_comments_blogs_FK` FOREIGN KEY (`blog_id`) REFERENCES `blogs` (`blog_id`),
  CONSTRAINT `blog_comments_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_comments`
--

LOCK TABLES `blog_comments` WRITE;
/*!40000 ALTER TABLE `blog_comments` DISABLE KEYS */;
INSERT INTO `blog_comments` VALUES (1,4,NULL,'Great info, thanks!','2025-04-06 17:34:49'),(2,5,NULL,'Great info, thanks!','2025-04-06 17:35:30'),(3,6,28,'Great info, thanks!','2025-04-06 17:37:53'),(4,7,30,'Great info, thanks!','2025-04-06 17:38:24'),(5,8,31,'Great info, thanks!','2025-04-06 17:40:23'),(6,9,32,'Great info, thanks!','2025-04-06 18:08:33');
/*!40000 ALTER TABLE `blog_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(100) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `published_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`blog_id`),
  KEY `blogs_users_FK` (`author_id`),
  CONSTRAINT `blogs_users_FK` FOREIGN KEY (`author_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,'Bee Benefits','Honey has natural healing properties...',NULL,NULL,'2025-04-06 17:29:07'),(2,'Bee Benefits','Honey has natural healing properties...',NULL,NULL,'2025-04-06 17:29:34'),(3,'Bee Benefits','Honey has natural healing properties...',NULL,NULL,'2025-04-06 17:31:43'),(4,'Bee Benefits','Honey has natural healing properties...',NULL,NULL,'2025-04-06 17:34:49'),(5,'Bee Benefits','Honey has natural healing properties...',NULL,NULL,'2025-04-06 17:35:30'),(6,'Bee Benefits','Honey has natural healing properties...',NULL,28,'2025-04-06 17:37:53'),(7,'Bee Benefits','Honey has natural healing properties...',NULL,30,'2025-04-06 17:38:24'),(8,'Bee Benefits','Honey has natural healing properties...',NULL,31,'2025-04-06 17:40:23'),(9,'Bee Benefits','Honey has natural healing properties...',NULL,32,'2025-04-06 18:08:33');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`cart_id`),
  KEY `cart_items_users_FK` (`user_id`),
  KEY `cart_items_products_FK` (`product_id`),
  CONSTRAINT `cart_items_products_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `cart_items_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (1,30,17,3),(2,31,18,3),(3,32,19,3);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(100) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Electronics'),(2,'Electronics'),(3,'Electronics'),(4,'Electronics'),(5,'Electronics'),(6,'HoneyComb'),(7,'HoneyComb'),(8,'HoneyComb'),(9,'HoneyComb'),(10,'HoneyComb'),(11,'HoneyComb'),(12,'HoneyComb'),(13,'HoneyComb'),(14,'HoneyComb'),(15,'HoneyComb'),(16,'HoneyComb'),(17,'HoneyComb'),(18,'HoneyComb'),(19,'HoneyComb'),(20,'HoneyComb'),(21,'HoneyComb'),(22,'HoneyComb'),(23,'HoneyComb'),(24,'HoneyComb'),(25,'HoneyComb'),(26,'HoneyComb');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_messages` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 17:34:49'),(2,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 17:35:30'),(3,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 17:37:53'),(4,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 17:38:24'),(5,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 17:40:23'),(6,'Jane Doe','jd@example.com','123456789','Order help','Where is my honey?','2025-04-06 18:08:33');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`notification_id`),
  KEY `notifications_users_FK` (`user_id`),
  CONSTRAINT `notifications_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,30,'Your order has been shipped!',0,'2025-04-06 19:38:24'),(2,31,'Your order has been shipped!',0,'2025-04-06 19:40:23'),(3,32,'Your order has been shipped!',0,'2025-04-06 20:08:33');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  KEY `order_items_orders_FK` (`order_id`),
  KEY `order_items_products_FK` (`product_id`),
  CONSTRAINT `order_items_orders_FK` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_items_products_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,NULL,2),(NULL,17,2),(NULL,18,2),(NULL,19,2);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_statuses`
--

DROP TABLE IF EXISTS `order_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_statuses`
--

LOCK TABLES `order_statuses` WRITE;
/*!40000 ALTER TABLE `order_statuses` DISABLE KEYS */;
INSERT INTO `order_statuses` VALUES (1,'Pending'),(2,'Pending'),(3,'Pending'),(4,'Pending'),(5,'Pending'),(6,'Pending'),(7,'Pending'),(8,'Pending'),(9,'Pending'),(10,'Pending'),(11,'Pending'),(12,'Pending'),(13,'Pending'),(14,'Pending'),(15,'Pending'),(16,'Pending'),(17,'Pending'),(18,'Pending'),(19,'Pending'),(20,'Pending'),(21,'Pending'),(22,'Pending'),(23,'Pending'),(24,'Pending'),(25,'Pending'),(26,'Pending');
/*!40000 ALTER TABLE `order_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `phone_number` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `additional_notes` text DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `orders_order_statuses_FK` (`status_id`),
  CONSTRAINT `orders_order_statuses_FK` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,NULL,NULL,'123 Test St','2025-04-06 15:40:06','123456789','Sarajevo','Bosnia','Order description'),(2,NULL,NULL,'123 Test St','2025-04-06 17:38:06','123456789','Sarajevo','Bosnia','Order description'),(3,NULL,NULL,'123 Test St','2025-04-06 18:06:06','123456789','Sarajevo','Bosnia','Order description'),(4,NULL,NULL,'123 Test St','2025-04-06 19:17:12','123456789','Sarajevo','Bosnia','Order description'),(5,NULL,NULL,'123 Test St','2025-04-06 19:17:57','123456789','Sarajevo','Bosnia','Order description'),(6,NULL,NULL,'123 Test St','2025-04-06 19:19:51','123456789','Sarajevo','Bosnia','Order description'),(7,NULL,NULL,'123 Test St','2025-04-06 19:20:18','123456789','Sarajevo','Bosnia','Order description'),(8,NULL,NULL,'123 Test St','2025-04-06 19:26:11','123456789','Sarajevo','Bosnia','Order description'),(9,NULL,NULL,'123 Test St','2025-04-06 19:29:07','123456789','Sarajevo','Bosnia','Order description'),(10,NULL,NULL,'123 Test St','2025-04-06 19:29:34','123456789','Sarajevo','Bosnia','Order description'),(11,NULL,NULL,'123 Test St','2025-04-06 19:31:43','123456789','Sarajevo','Bosnia','Order description'),(12,NULL,NULL,'123 Test St','2025-04-06 19:34:49','123456789','Sarajevo','Bosnia','Order description'),(13,NULL,NULL,'123 Test St','2025-04-06 19:35:30','123456789','Sarajevo','Bosnia','Order description'),(14,28,NULL,'123 Test St','2025-04-06 19:37:53','123456789','Sarajevo','Bosnia','Order description'),(15,30,NULL,'123 Test St','2025-04-06 19:38:24','123456789','Sarajevo','Bosnia','Order description'),(16,31,NULL,'123 Test St','2025-04-06 19:40:23','123456789','Sarajevo','Bosnia','Order description'),(17,32,NULL,'123 Test St','2025-04-06 20:08:33','123456789','Sarajevo','Bosnia','Order description');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(10,0) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`payment_id`),
  KEY `payments_users_FK` (`user_id`),
  CONSTRAINT `payments_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,NULL,600,'2025-04-06 15:40:06'),(2,NULL,600,'2025-04-06 17:38:06'),(3,NULL,600,'2025-04-06 18:06:06'),(4,NULL,600,'2025-04-06 19:17:12'),(5,NULL,600,'2025-04-06 19:17:57'),(6,NULL,600,'2025-04-06 19:19:51'),(7,NULL,600,'2025-04-06 19:20:18'),(8,NULL,600,'2025-04-06 19:26:11'),(9,NULL,600,'2025-04-06 19:29:07'),(10,NULL,600,'2025-04-06 19:29:34'),(11,NULL,600,'2025-04-06 19:31:43'),(12,NULL,600,'2025-04-06 19:34:49'),(13,NULL,600,'2025-04-06 19:35:30'),(14,28,600,'2025-04-06 19:37:53'),(15,30,600,'2025-04-06 19:38:24'),(16,31,600,'2025-04-06 19:40:23'),(17,32,600,'2025-04-06 20:08:33');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `products_categories_FK` (`category_id`),
  CONSTRAINT `products_categories_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Smartphone',300,10,'Brand new smartphone','smartphone.jpg',NULL),(2,'Smartphone',300,10,'Brand new smartphone','smartphone.jpg',NULL),(3,'Smartphone',300,10,'Brand new smartphone','smartphone.jpg',NULL),(4,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(5,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(6,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(7,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(8,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(9,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(10,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(11,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(12,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(13,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(14,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(15,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(16,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(17,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(18,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL),(19,'Honey',300,10,'Brand organic Honey','Honey.jpg',NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Customer'),(2,'Customer'),(3,'Customer'),(4,'Customer'),(5,'Admin'),(6,'Admin'),(7,'Admin'),(8,'Customer'),(9,'Customer'),(10,'Customer'),(11,'Customer'),(12,'Customer'),(13,'Customer'),(14,'Customer'),(15,'Customer'),(16,'Customer'),(17,'Customer'),(18,'Customer'),(19,'Customer'),(20,'Customer'),(21,'Admin');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `users_unique` (`email`),
  KEY `users_roles_FK` (`role_id`),
  CONSTRAINT `users_roles_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Doe','john@example.com','$2y$10$DMjmhNoEf3608rZzO16bEuFOZeL1imqEy9ld69JsLz1FXnTsh2Xr.','000000','John Doe',NULL),(7,'John Doe','john1@example.com','$2y$10$RwMOI0pLSK7MKhSh.GpSseqbqZS1VYyiUcESvWzuIUPrIdOIedVn2','000000','John Doe',NULL),(8,'Jane Doe','jane@example.com','$2y$10$.QKRhNnXZDMnGQez1zyDnepVkhYClXouueuOkLSxXqaT9UxSrrte.','123456789','123 Test St',NULL),(10,'Jane Doe','janesed@example.com','$2y$10$I6/P04ksWcAUfZi9X8JEie1Qh2Ufmb6M/NYY9biv/0Ibi7U4f6Vtm','123456789','123 Test St',NULL),(12,'Jane Doe','janesdded@example.com','$2y$10$EuhM.NUqHeNGHVYKw6kH.OPTIYyXiKHhm.03jp1fy5lCH8vj5SzMe','123456789','123 Test St',NULL),(14,'Jane Doe','janessdadsdded@example.com','$2y$10$I7tBNIx6ZG4yjDSIeCU1cON2Vvyh4FRH9WF0s9TIzJMXiMZAUDAhS','123456789','123 Test St',NULL),(15,'Jane Doe','jd@example.com','$2y$10$BfkF0c5kd9RJwJIyT9h7D.shqL0x9hmPcjFblfiDqSMQp6h2P51NW','123456789','123 Test St',NULL),(16,'Edina Kurt','ek@example.com','$2y$10$Gl11pAZQxr0GoYLmRZmztOXLDjdWMlltNg9ZfGMwGmLgszyngmwj.','123456789','123 Test St',NULL),(17,'Edina Kurt','ekkk@example.com','$2y$10$eAPg1m4SwCRfSeElLHx.zOEKkPjRjPhwc8Exy7IEazKmk4UV8aXUG','123456789','123 Test St',NULL),(19,'Edina Kurt','ekkkkk@example.com','$2y$10$LfzSRUuobsdrTBEUQN9s6u3WHWEiZx4Fpl2YcX9FHtkSLcsHUVpRS','123456789','123 Test St',NULL),(20,'Edina Kurt','ekddkkkk@example.com','$2y$10$TbzEvsThV.DWiZtFOs/ksOoQ5Ugwnum/Ivvs9kUjmDW12.E5BtkSG','123456789','123 Test St',NULL),(21,'Edina Kurt','ekddkdsdskkk@example.com','$2y$10$GjtULTlVVr8JTC.jb8365u.c4L5ct6WmAJ3jY2eosIVfM/C8JXjrK','123456789','123 Test St',NULL),(22,'Edina Kurt','ekddkdsdsdsddskkk@example.com','$2y$10$1E9Qj2b73MQbBl4l3zG14O12ZELbeBCThmSFp1qL7sOLHE8DaXkuW','123456789','123 Test St',NULL),(23,'Edina Kurt','ekddkdsdsdsdddsdsadskkk@example.com','$2y$10$ft7eaMYYHiMJiK2h2qhYLOeggihH78/ApcBA9fX1YEypbqBnjiXY6','123456789','123 Test St',NULL),(24,'Edina Kurt','ekddkdsdsdsdsdddsdsadskkk@example.com','$2y$10$JDlb51nVkuf9heuhojgKDe/JilTgfnnneVKsKYJkox3nmIURta6Re','123456789','123 Test St',NULL),(25,'Edina Kurt','ekddkdsdsdsddfsfsdsdddsdsadskkk@example.com','$2y$10$xqetC1rltfi2EOIBjlem0OkuhuftaWAgRKaGtFNNH3DVtBfiwaw7i','123456789','123 Test St',NULL),(27,'Edina Kurt','ekddkdsdsdsddfsfsdsdddsdsadsddskkk@example.com','$2y$10$UMC890UceYETYmcpLpLeRu13RJedXdqr7FLTkwXCzFcEuf2HyurAi','123456789','123 Test St',NULL),(28,'Edina Kurt','ekddkdsdsdsddfsfsdsdddsdsadsddsdskkk@example.com','$2y$10$azqjd98ghEcM.Pi6P7HkTuzQgyUmb.cXkSd9dy2bIkQmpd.iyrbR6','123456789','123 Test St',NULL),(30,'Edina Kurt','ekddkdsdsdsddfsfsdsdddsdsadsddsaddsdskkk@example.com','$2y$10$5bIApOZOd3Cy7PJ.YS7nIOY/8yeHM4FmCSx4l6tto39B.4L6kqfeO','123456789','123 Test St',NULL),(31,'Edina Kurt','ekddkdsdsdsddfsfsdsdddsdsadsddsaddsfdfdskkk@example.com','$2y$10$Jeqlp0fazC8cWfHUUx6AIu1GWLMAC9dcZeg8qCVoYWvP2nw4cB8tG','123456789','123 Test St',NULL),(32,'Edina Eddie','edd.k@example.com','$2y$10$vRUFi2EFWI0Hf/JOXsP3De2u5e/uwdp7PVr.GZHEn4g4UCxk8hJgm','123456789','123 Test St',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'beehive_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-06 20:31:28
