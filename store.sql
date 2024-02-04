-- MariaDB dump 10.19  Distrib 10.11.4-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: demo
-- ------------------------------------------------------
-- Server version	10.11.4-MariaDB-1

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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `token` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `mobile` varchar(191) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
(1,'Street Bolt','Street Bolt','street@gmail.com',NULL,'$2y$10$L.DSQ0kqtBINimOFSBhPC.GAf5XuxQQ00GZ9QxojHoQm3OPv8hYSC','8867675654','1933boy.png');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(22) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `banner_url` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES
(2,'TEST K','https://stackoverflow.com','1701693568banner1.jpg',1),
(5,'zara banner','https://www.zara.com/in/','1701679974zara2.jpg',1);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) NOT NULL,
  `banner` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES
(6,'Woman','1695817024Woman.jpg',NULL,NULL,1),
(7,'Man','1695817079Man.jpg',NULL,NULL,1),
(8,'Kids','1695817185Kids.jpg',NULL,'2023-09-27 12:19:45',1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `image` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `galleries_product_id_foreign` (`product_id`),
  CONSTRAINT `galleries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES
(3,8,'product/gallery/banner_whatseatingyou.png','2023-10-10 16:08:31','2023-10-10 16:08:31'),
(7,11,'product/gallery/product2.jpg','2023-11-01 10:27:56','2023-11-01 10:27:56'),
(8,12,'product/gallery/product6.jpg','2023-11-01 10:30:59','2023-11-01 10:30:59');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2023_03_31_111638_create_categories_table',1),
(2,'2023_09_26_104805_create_sub_categories_table',2),
(3,'2023_10_10_180411_create_products_table',3),
(4,'2023_10_10_202219_create_galleries_table',4),
(6,'2023_10_10_202242_create_stocks_table',5),
(7,'2023_10_10_213318_create_variations_table',6),
(8,'2024_01_14_123122_create_orders_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(191) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(191) NOT NULL,
  `address` varchar(191) NOT NULL,
  `state` varchar(191) NOT NULL,
  `city` varchar(191) NOT NULL,
  `pin_code` varchar(191) NOT NULL,
  `price` varchar(191) NOT NULL,
  `quantity` varchar(191) NOT NULL,
  `product_id` varchar(191) NOT NULL,
  `product_title` varchar(191) NOT NULL,
  `product_image` varchar(191) NOT NULL,
  `payment_mode` varchar(191) NOT NULL,
  `transaction_id` varchar(191) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(1,'tqSFUx',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','999','2','11','Jacket','product/image/1698834476product8.jpg','online',NULL,NULL,'2024-01-14 07:48:23','2024-01-14 07:48:23'),
(2,'tqSFUx',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','2800','1','12','Shirt','product/image/1698834659jeans.jpg','online',NULL,NULL,'2024-01-14 07:48:23','2024-01-14 07:48:23'),
(3,'EvP8u8',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','999','2','11','Jacket','product/image/1698834476product8.jpg','Cash On Delivery',NULL,NULL,'2024-01-14 08:03:05','2024-01-14 08:03:05'),
(4,'8dyyxg',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','3','2','8','u','product/image/1696973911Beauty.jpg','online',NULL,NULL,'2024-01-14 08:04:16','2024-01-14 08:04:16'),
(5,'5hXlY8',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','3','3','8','u','product/image/1696973911Beauty.jpg','online',NULL,NULL,'2024-01-14 08:06:48','2024-01-14 08:06:48'),
(6,'5hXlY8',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','2800','2','12','Shirt','product/image/1698834659jeans.jpg','online',NULL,NULL,'2024-01-14 08:06:48','2024-01-14 08:06:48'),
(7,'5hXlY8',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','999','1','11','Jacket','product/image/1698834476product8.jpg','online',NULL,NULL,'2024-01-14 08:06:48','2024-01-14 08:06:48'),
(8,'I2MJPb',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','2800','2','12','Shirt','product/image/1698834659jeans.jpg','online',NULL,NULL,'2024-01-14 08:09:00','2024-01-14 08:09:00'),
(9,'I2MJPb',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','999','1','11','Jacket','product/image/1698834476product8.jpg','online',NULL,NULL,'2024-01-14 08:09:00','2024-01-14 08:09:00'),
(10,'EFbiw5',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','3','3','8','u','product/image/1696973911Beauty.jpg','online',NULL,NULL,'2024-01-14 10:09:35','2024-01-14 10:09:35'),
(11,'EFbiw5',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','2800','2','12','Shirt','product/image/1698834659jeans.jpg','online',NULL,NULL,'2024-01-14 10:09:35','2024-01-14 10:09:35'),
(12,'EFbiw5',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','3','999','1','11','Jacket','product/image/1698834476product8.jpg','online',NULL,NULL,'2024-01-14 10:09:35','2024-01-14 10:09:35'),
(13,'6ysKzg',8,'Ratipriya Kundu','ratipriyakundu5@gmail.com','6466454544','A','West Bengal','C','5','999','1','11','Jacket','product/image/1698834476product8.jpg','Cash On Delivery',NULL,NULL,'2024-01-16 09:48:57','2024-01-16 09:48:57');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) NOT NULL,
  `description` varchar(191) NOT NULL,
  `category_id` bigint(20) unsigned NOT NULL,
  `subcategory_id` bigint(20) unsigned DEFAULT NULL,
  `image` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_subcategory_id_foreign` (`subcategory_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES
(8,'u','yyy',6,3,'product/image/1696973911Beauty.jpg',NULL,NULL,1),
(11,'Jacket','afaaafafa',7,5,'product/image/1698834476product8.jpg',NULL,NULL,1),
(12,'Shirt','fgfhfffhf',7,5,'product/image/1698834659jeans.jpg',NULL,'2023-12-04 16:55:48',1);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stocks`
--

DROP TABLE IF EXISTS `stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `variation_type` varchar(191) NOT NULL,
  `variation` varchar(191) DEFAULT NULL,
  `price` varchar(191) NOT NULL,
  `discount` varchar(191) NOT NULL,
  `stock` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stocks_product_id_foreign` (`product_id`),
  CONSTRAINT `stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stocks`
--

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;
INSERT INTO `stocks` VALUES
(8,8,'Variable','Red,S','3','3','3',NULL,NULL),
(9,8,'Variable','L,Red','3','3','3',NULL,NULL),
(10,8,'Variable','Green,S','3','3','3',NULL,NULL),
(11,8,'Variable','Green,L','3','3','3',NULL,NULL),
(22,11,'Variable','Red,S','1000','999','100',NULL,NULL),
(23,11,'Variable','M,Red','2099','2000','30',NULL,NULL),
(24,11,'Variable','L,Red','3999','3500','60',NULL,NULL),
(25,11,'Variable','Black,S','5000','3999','67',NULL,NULL),
(26,11,'Variable','Black,M','7000','6200','90',NULL,NULL),
(27,11,'Variable','Black,L','2500','2199','88',NULL,NULL),
(28,12,'Variable','Red,S','3999','2800','90',NULL,NULL);
/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `sub_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES
(3,6,'NEW',NULL,'2023-09-27 12:21:05',1),
(4,6,'THREAD OF LOVE',NULL,'2023-10-10 12:33:07',1),
(5,7,'Shirt',NULL,'2023-12-04 16:40:20',1);
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `testimonials` (
  `testimonial_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `designation` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `ratings` int(5) NOT NULL,
  `comments` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `dated` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`testimonial_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
INSERT INTO `testimonials` VALUES
(2,'dev','developer','1701684578aryabhatta.jpg',5,'fsdfs','2023-12-04 10:09:38',1);
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(255) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) NOT NULL,
  `user_mobile` varchar(15) NOT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(2,'Md Kalam','8787676565','kalam@gmail.com',NULL,'$2y$10$.DzdNwJYJPPLmMxlvrWma.tkbAr.hpZbE6n6oMj/lvziUvXdtGigW','123456',1),
(3,'Sanjay Kumar','9898987876','sanjay@gmail.com',NULL,'$2y$10$hI0OUZlWVgYHfHEPUFJmhOrugyUiPmHIfgsrGI66RrbUGR8ws.nmO','123456',1),
(4,'Amit Kumar','6666555545','amit@gmail.com','Male','$2y$10$ESwZo.bRK44.r4iwP5.fQ.ZKsv/yOyOg3y1tRhtCjyDgtsVbM1al2','123456',1),
(5,'dev kumar','8010382511','devtilante@gmail.com','Male','$2y$10$cxsYRk519ybkH8D2yIXMluUp.jPTJPGRYsd5Vi/l8Ub4CfGx8UNx2','123456',1),
(6,'dev kumar','8010382512','devtilante1@gmail.com','Male','$2y$10$ngOl2TGnYKELKxlSRy0r0umAfM.t6A8sPhf1L.34GGGM9.X32sF2.','123456',1),
(8,'Ratipriya Kundu','6466454544','ratipriyakundu5@gmail.com',NULL,'$2y$10$QMpfuTD2h0cXlDy7GTVx/ed25MTcqNGSiLRo9Gv3k1qyW1qOjnEU.','Rati#1234',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variations`
--

DROP TABLE IF EXISTS `variations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `variation_type` varchar(191) NOT NULL,
  `variation_list` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `variations_product_id_foreign` (`product_id`),
  CONSTRAINT `variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variations`
--

LOCK TABLES `variations` WRITE;
/*!40000 ALTER TABLE `variations` DISABLE KEYS */;
INSERT INTO `variations` VALUES
(1,8,'Color','Red,Green','2023-10-10 16:08:31','2023-10-10 16:08:31'),
(2,8,'Size','S,L','2023-10-10 16:08:31','2023-10-10 16:08:31'),
(5,11,'Color','Red,Black','2023-11-01 10:27:56','2023-11-01 10:27:56'),
(6,11,'Size','S,M,L','2023-11-01 10:27:56','2023-11-01 10:27:56'),
(7,12,'Color','Red','2023-11-01 10:30:59','2023-11-01 10:30:59'),
(8,12,'Size','S','2023-11-01 10:30:59','2023-11-01 10:30:59');
/*!40000 ALTER TABLE `variations` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-16 20:55:28
