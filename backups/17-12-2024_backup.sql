CREATE DATABASE  IF NOT EXISTS `sistema_universitario` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `sistema_universitario`;
-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: sistema_universitario
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `calificaciones`
--

DROP TABLE IF EXISTS `calificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `calificaciones` (
  `cedula` int NOT NULL,
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `primer_corte` float DEFAULT NULL,
  `segundo_corte` float DEFAULT NULL,
  `tercer_corte` float DEFAULT NULL,
  `cuarto_corte` float DEFAULT NULL,
  `nota_definitiva` float DEFAULT NULL,
  KEY `cedula_calificaciones_idx` (`cedula`),
  KEY `id_materia_idx` (`id_materia`),
  CONSTRAINT `cedula_calificaciones` FOREIGN KEY (`cedula`) REFERENCES `estudiantes` (`cedula`),
  CONSTRAINT `id_materia_calificaciones` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificaciones`
--

LOCK TABLES `calificaciones` WRITE;
/*!40000 ALTER TABLE `calificaciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `calificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiantes`
--

DROP TABLE IF EXISTS `estudiantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiantes` (
  `cedula` int NOT NULL,
  `primer_nombre_estudiante` varchar(45) NOT NULL,
  `segundo_nombre_estudiante` varchar(45) NOT NULL,
  `primer_apellido_estudiante` varchar(45) NOT NULL,
  `segundo_apellido_estudiante` varchar(45) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `correo_electronico` varchar(45) DEFAULT NULL,
  UNIQUE KEY `telefono_UNIQUE` (`telefono`),
  UNIQUE KEY `correo_electronico_UNIQUE` (`correo_electronico`),
  KEY `cedula_estudiante_idx` (`cedula`),
  CONSTRAINT `cedula_estudiante` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiantes`
--

LOCK TABLES `estudiantes` WRITE;
/*!40000 ALTER TABLE `estudiantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `estudiantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materias`
--

DROP TABLE IF EXISTS `materias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `materias` (
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `nombre_materia` varchar(45) NOT NULL,
  `nombre_profesor` varchar(45) NOT NULL,
  PRIMARY KEY (`id_materia`),
  UNIQUE KEY `nombre_materia_UNIQUE` (`nombre_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materias`
--

LOCK TABLES `materias` WRITE;
/*!40000 ALTER TABLE `materias` DISABLE KEYS */;
/*!40000 ALTER TABLE `materias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preguntas_seguridad`
--

DROP TABLE IF EXISTS `preguntas_seguridad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `preguntas_seguridad` (
  `cedula` int NOT NULL,
  `pregunta1` varchar(45) NOT NULL,
  `respuesta1` varchar(45) NOT NULL,
  `pregunta2` varchar(45) NOT NULL,
  `respuesta2` varchar(45) NOT NULL,
  `pregunta3` varchar(45) NOT NULL,
  `respuesta3` varchar(45) NOT NULL,
  KEY `cedula_preguntas_idx` (`cedula`),
  CONSTRAINT `cedula_preguntas` FOREIGN KEY (`cedula`) REFERENCES `estudiantes` (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preguntas_seguridad`
--

LOCK TABLES `preguntas_seguridad` WRITE;
/*!40000 ALTER TABLE `preguntas_seguridad` DISABLE KEYS */;
/*!40000 ALTER TABLE `preguntas_seguridad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores`
--

DROP TABLE IF EXISTS `profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `profesores` (
  `cedula` int NOT NULL,
  `id_materia` int NOT NULL AUTO_INCREMENT,
  `primer_nombre_profesor` varchar(45) NOT NULL,
  `segundo_nombre_profesor` varchar(45) NOT NULL,
  `segundo_apellido_profesor` varchar(45) NOT NULL,
  `primer_apellido_profesor` varchar(45) NOT NULL,
  KEY `cedula_profesor_idx` (`cedula`),
  KEY `id_materia_idx` (`id_materia`),
  CONSTRAINT `cedula_profesor` FOREIGN KEY (`cedula`) REFERENCES `usuarios` (`cedula`),
  CONSTRAINT `id_materia` FOREIGN KEY (`id_materia`) REFERENCES `materias` (`id_materia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores`
--

LOCK TABLES `profesores` WRITE;
/*!40000 ALTER TABLE `profesores` DISABLE KEYS */;
/*!40000 ALTER TABLE `profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `cedula` int NOT NULL,
  `clave` varchar(72) NOT NULL,
  `rol` varchar(15) NOT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-17 18:32:11
