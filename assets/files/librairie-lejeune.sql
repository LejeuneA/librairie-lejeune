-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: librarie-lejeune
-- ------------------------------------------------------
-- Server version	8.0.36

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
-- Table structure for table `cadeaux`
--

DROP TABLE IF EXISTS `cadeaux`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cadeaux` (
  `idCadeau` int NOT NULL AUTO_INCREMENT,
  `titleCadeau` varchar(100) NOT NULL,
  `featureCadeau` varchar(100) DEFAULT NULL,
  `descriptionCadeau` mediumtext,
  `priceCadeau` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idCadeau`),
  UNIQUE KEY `idCadeau_UNIQUE` (`idCadeau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cadeaux`
--

LOCK TABLES `cadeaux` WRITE;
/*!40000 ALTER TABLE `cadeaux` DISABLE KEYS */;
/*!40000 ALTER TABLE `cadeaux` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `livres`
--

DROP TABLE IF EXISTS `livres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `livres` (
  `idLivre` int NOT NULL AUTO_INCREMENT,
  `titleLivre` varchar(100) NOT NULL,
  `writerLivre` varchar(45) DEFAULT NULL,
  `featureLivre` varchar(100) DEFAULT NULL,
  `descriptionLivre` mediumtext,
  `priceLivre` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idLivre`),
  UNIQUE KEY `idLivres_UNIQUE` (`idLivre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `livres`
--

LOCK TABLES `livres` WRITE;
/*!40000 ALTER TABLE `livres` DISABLE KEYS */;
INSERT INTO `livres` VALUES (1,'Les yeux de Mona','Thomas Schlesser','Livre broché | Français','Cinquante-deux semaines : c\'est le temps qu\'il reste à Mona pour découvrir toute la beauté du monde. C\'est le temps que s\'est donné son grand-père, un... ',23.00),(2,'Lakestone. Vol. 1','Sarah Rivens','Livre broché | Français','Dans la tranquillité trompeuse de la ville d\'Ewing aux États-Unis, Iris, confinée à la bibliothèque, est plongée dans ses révisions. À des kilomètres ...',20.10),(3,'La rose de minuit','Lusinda Riley','Livre broché | Français','La rencontre d\'Ari Malik, petit-fils d\'une suivante de la princesse Indira, et de Rebecca Bradley, jeune actrice américaine, dans les ruines d\'un mano...',14.99);
/*!40000 ALTER TABLE `livres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `papeteries`
--

DROP TABLE IF EXISTS `papeteries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `papeteries` (
  `idPapeterie` int NOT NULL AUTO_INCREMENT,
  `titlePapeterie` varchar(100) NOT NULL,
  `featurePapeterie` varchar(100) DEFAULT NULL,
  `descriptionPapeterie` mediumtext,
  `pricePapeterie` decimal(5,2) NOT NULL,
  PRIMARY KEY (`idPapeterie`),
  UNIQUE KEY `idPapeteries_UNIQUE` (`idPapeterie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `papeteries`
--

LOCK TABLES `papeteries` WRITE;
/*!40000 ALTER TABLE `papeteries` DISABLE KEYS */;
/*!40000 ALTER TABLE `papeteries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `idUser` int NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `passwd` varchar(250) NOT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `idUser_UNIQUE` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'lejeune@mail.com','130580'),(2,'pierre@mail.com','100578');
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

-- Dump completed on 2024-04-18 13:50:27
