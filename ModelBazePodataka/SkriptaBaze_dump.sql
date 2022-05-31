-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: brziprsti
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `dnevnaranglista`
--

DROP TABLE IF EXISTS `dnevnaranglista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dnevnaranglista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_20` (`idKor`),
  KEY `R_21` (`idTekst`),
  CONSTRAINT `R_20` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`id`),
  CONSTRAINT `R_21` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dnevnaranglista`
--

LOCK TABLES `dnevnaranglista` WRITE;
/*!40000 ALTER TABLE `dnevnaranglista` DISABLE KEYS */;
/*!40000 ALTER TABLE `dnevnaranglista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dnevniizazov`
--

DROP TABLE IF EXISTS `dnevniizazov`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dnevniizazov` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sadrzaj` varchar(4000) DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `nazivKategorije` varchar(20) DEFAULT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_22` (`idTekst`),
  CONSTRAINT `R_22` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dnevniizazov`
--

LOCK TABLES `dnevniizazov` WRITE;
/*!40000 ALTER TABLE `dnevniizazov` DISABLE KEYS */;
/*!40000 ALTER TABLE `dnevniizazov` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jeprijatelj`
--

DROP TABLE IF EXISTS `jeprijatelj`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jeprijatelj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKor1` int(11) NOT NULL,
  `idKor2` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_15` (`idKor1`),
  KEY `R_16` (`idKor2`),
  CONSTRAINT `R_15` FOREIGN KEY (`idKor1`) REFERENCES `korisnik` (`id`),
  CONSTRAINT `R_16` FOREIGN KEY (`idKor2`) REFERENCES `korisnik` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jeprijatelj`
--

LOCK TABLES `jeprijatelj` WRITE;
/*!40000 ALTER TABLE `jeprijatelj` DISABLE KEYS */;
INSERT INTO `jeprijatelj` VALUES (4,2,4),(5,4,2),(6,3,2);
/*!40000 ALTER TABLE `jeprijatelj` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategorija`
--

DROP TABLE IF EXISTS `kategorija`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kategorija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategorija`
--

LOCK TABLES `kategorija` WRITE;
/*!40000 ALTER TABLE `kategorija` DISABLE KEYS */;
INSERT INTO `kategorija` VALUES (1,'srpski'),(2,'engleski');
/*!40000 ALTER TABLE `kategorija` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `zlato` int(11) DEFAULT NULL,
  `srebro` int(11) DEFAULT NULL,
  `bronza` int(11) DEFAULT NULL,
  `tip` int(11) DEFAULT NULL,
  `aktivan` int(11) DEFAULT NULL,
  `brojPrijatelja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `korisnik`
--

LOCK TABLES `korisnik` WRITE;
/*!40000 ALTER TABLE `korisnik` DISABLE KEYS */;
INSERT INTO `korisnik` VALUES (1,'admin','$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e',0,0,0,2,1,1),(2,'korisnik1','$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e',0,0,0,0,1,2),(3,'moderator','$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e',0,0,0,1,1,1),(4,'korisnik2','$2y$10$7yggpSOOIbbtrdylcSvsg.pJtHXi6UeRoUZG6E7Xv4ZYwswa9ulh.',0,0,0,0,1,1),(5,'korisnik3','$2y$10$csRKUPzbWLF/8EP7D9f0FeqO0bUtQQPkdEG2N.72ECOvh.OjpfBtC',0,0,0,0,1,0),(6,'korisnik4','$2y$10$JD6pPceK/7TUJUpj2pl81OT6w2YEJYooHPsEiOmmtIRVYLP5zoW/6',0,0,0,0,1,0),(7,'korisnik5','$2y$10$.bpHuJ74oWCQqoe.iJk.G.l1dcJZtreCLptpg9K49Vo7S/2uCiRr2',0,0,0,0,1,0);
/*!40000 ALTER TABLE `korisnik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ranglista`
--

DROP TABLE IF EXISTS `ranglista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ranglista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_17` (`idKor`),
  KEY `R_18` (`idTekst`),
  CONSTRAINT `R_17` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`id`),
  CONSTRAINT `R_18` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ranglista`
--

LOCK TABLES `ranglista` WRITE;
/*!40000 ALTER TABLE `ranglista` DISABLE KEYS */;
INSERT INTO `ranglista` VALUES (6,2.97,2,14),(7,0.79,2,12),(8,1.68,2,12),(9,2.46,2,12),(10,1.74,2,12),(11,9.76,2,13),(12,2.76,2,13),(13,1.98,2,14),(14,1.05,4,12),(15,2.45,4,13),(16,2.23,4,14),(17,45.34,5,12),(18,44.08,6,13),(19,2.18,7,14),(20,18.79,3,16),(21,20.85,2,16);
/*!40000 ALTER TABLE `ranglista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tekst`
--

DROP TABLE IF EXISTS `tekst`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tekst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sadrzaj` varchar(4000) DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `idKat` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_2` (`idKat`),
  CONSTRAINT `R_2` FOREIGN KEY (`idKat`) REFERENCES `kategorija` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tekst`
--

LOCK TABLES `tekst` WRITE;
/*!40000 ALTER TABLE `tekst` DISABLE KEYS */;
INSERT INTO `tekst` VALUES (12,'Prvi tekst',6,1),(13,'Drugi tekst!!!!',1,1),(14,'Ovo je treci tekst',6,1),(16,'If you are committed enough, you can make any story work. I once convinced a woman that I was Kevin Costner, and it worked because I believed it.',4,2),(18,'The terrain along this stretch of the river was mostly flat, but in the immediate vicinity of the island, the land on the sunrise side was like a rumpled cloth, with hills and ridges and valleys. Among LaraΓÇÖs people, there was a wooden babyΓÇÖs crib, suitable for strapping to a cart, that had been passed down for generations. The island was shaped like that crib, longer than it was wide and pointed at the upriver end, where the flow had eroded both banks. The island was like a crib, and the group of hills on the sunrise side of the river were like old women mantled in heavy cloaks gathered to have a look at the baby in the cribΓÇöthat was how LaraΓÇÖs father had once described the lay of the land.\r\nLarth spoke like that all the time, conjuring images of giants and monsters in the landscape. He could perceive the spirits, called numina, that dwelled in rocks and trees. Sometimes he could speak to them and hear what they had to say. The river was his oldest friend and told him where the fishing would be best. From whispers in the wind he could foretell the next dayΓÇÖs weather. Because of such skills, Larth was the leader of the group.',10,2),(19,'The two groups made separate camps at opposite ends of the island. As a gesture of friendship, speaking with his hands, Larth invited Tarketios and the others to share the venison that night. As the hosts and their guests feasted around the roasting fire, Tarketios tried to explain something of his craft. Firelight glittered in LaraΓÇÖs eyes as she watched Tarketios point at the flames and mime the act of hammering. Firelight danced across the flexing muscles of his arms and shoulders. When he smiled at her, his grin was like a boast. She had never seen teeth so white and so perfect.\r\nPo saw the looks the two exchanged and frowned. LaraΓÇÖs father saw the same looks and smiled.',7,2),(20,'U ┼íumi je bilo jo┼í mle─ìne magle koja se, kao ostatak od neke ─ìudne no─çne igre, povla─ìila pred suncem. Belo i svetlo i tiho. Slaba vidljivost i potpuna ti┼íina stvarale su zra─ìan predeo u kome prostor i daljina nisu imali mere i u kome je vreme gubilo svoje zna─ìenje.',5,1);
/*!40000 ALTER TABLE `tekst` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2022-05-29 17:25:17
