-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 08, 2022 at 08:45 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brziprsti`
--

-- --------------------------------------------------------

--
-- Table structure for table `dnevnaranglista`
--

DROP TABLE IF EXISTS `dnevnaranglista`;
CREATE TABLE IF NOT EXISTS `dnevnaranglista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_20` (`idKor`),
  KEY `R_21` (`idTekst`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dnevniizazov`
--

DROP TABLE IF EXISTS `dnevniizazov`;
CREATE TABLE IF NOT EXISTS `dnevniizazov` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sadrzaj` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `nazivKategorije` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_22` (`idTekst`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dnevniizazov`
--

INSERT INTO `dnevniizazov` (`id`, `sadrzaj`, `tezina`, `nazivKategorije`, `idTekst`) VALUES
(2, 'Галија је југословенска и српска рок група, основана у Нишу 1976. године.', 8, 'edukativni', 21);

-- --------------------------------------------------------

--
-- Table structure for table `jeprijatelj`
--

DROP TABLE IF EXISTS `jeprijatelj`;
CREATE TABLE IF NOT EXISTS `jeprijatelj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idKor1` int(11) NOT NULL,
  `idKor2` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_15` (`idKor1`),
  KEY `R_16` (`idKor2`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `jeprijatelj`
--

INSERT INTO `jeprijatelj` (`id`, `idKor1`, `idKor2`) VALUES
(4, 2, 4),
(5, 4, 2),
(6, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kategorija`
--

DROP TABLE IF EXISTS `kategorija`;
CREATE TABLE IF NOT EXISTS `kategorija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv`) VALUES
(2, 'engleski'),
(3, 'poezija'),
(4, 'edukativni'),
(5, 'roman'),
(6, 'citat');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zlato` int(11) DEFAULT NULL,
  `srebro` int(11) DEFAULT NULL,
  `bronza` int(11) DEFAULT NULL,
  `tip` int(11) DEFAULT NULL,
  `aktivan` int(11) DEFAULT NULL,
  `brojPrijatelja` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `username`, `password`, `zlato`, `srebro`, `bronza`, `tip`, `aktivan`, `brojPrijatelja`) VALUES
(1, 'admin', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 2, 1, 0),
(2, 'korisnik1', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 0, 1, 1),
(3, 'moderator', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 1, 1, 1),
(4, 'korisnik2', '$2y$10$7yggpSOOIbbtrdylcSvsg.pJtHXi6UeRoUZG6E7Xv4ZYwswa9ulh.', 0, 0, 0, 0, 1, 1),
(5, 'korisnik3', '$2y$10$csRKUPzbWLF/8EP7D9f0FeqO0bUtQQPkdEG2N.72ECOvh.OjpfBtC', 0, 0, 0, 0, 1, 0),
(6, 'korisnik4', '$2y$10$JD6pPceK/7TUJUpj2pl81OT6w2YEJYooHPsEiOmmtIRVYLP5zoW/6', 0, 0, 0, 0, 1, 0),
(7, 'korisnik5', '$2y$10$.bpHuJ74oWCQqoe.iJk.G.l1dcJZtreCLptpg9K49Vo7S/2uCiRr2', 0, 0, 0, 0, 1, 0),
(65, 'blokirani', '$2y$10$.bpHuJ74oWCQqoe.iJk.G.l1dcJZtreCLptpg9K49Vo7S/2uCiRr2', 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ranglista`
--

DROP TABLE IF EXISTS `ranglista`;
CREATE TABLE IF NOT EXISTS `ranglista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_17` (`idKor`),
  KEY `R_18` (`idTekst`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ranglista`
--

INSERT INTO `ranglista` (`id`, `vreme`, `idKor`, `idTekst`) VALUES
(7, 0.79, 2, 12),
(8, 1.68, 2, 12),
(9, 2.46, 2, 12),
(10, 1.74, 2, 12),
(11, 9.76, 2, 13),
(12, 2.76, 2, 13),
(14, 1.05, 4, 12),
(15, 2.45, 4, 13),
(17, 45.34, 5, 12),
(18, 44.08, 6, 13),
(20, 18.79, 3, 16),
(21, 20.85, 2, 16),
(22, 27.02, 3, 21);

-- --------------------------------------------------------

--
-- Table structure for table `tekst`
--

DROP TABLE IF EXISTS `tekst`;
CREATE TABLE IF NOT EXISTS `tekst` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sadrzaj` varchar(4000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `idKat` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `R_2` (`idKat`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tekst`
--

INSERT INTO `tekst` (`id`, `sadrzaj`, `tezina`, `idKat`) VALUES
(12, 'Al je lep ovaj svet, ovde potok, onde cvet', 6, 3),
(13, 'Početak je najvažniji deo svakog posla. - Platon', 1, 6),
(16, 'If you are committed enough, you can make any story work. I once convinced a woman that I was Kevin Costner, and it worked because I believed it.', 4, 2),
(18, 'The terrain along this stretch of the river was mostly flat, but in the immediate vicinity of the island, the land on the sunrise side was like a rumpled cloth, with hills and ridges and valleys. Among Laras people, there was a wooden babys crib, suitable for strapping to a cart, that had been passed down for generations. The island was shaped like that crib, longer than it was wide and pointed at the upriver end, where the flow had eroded both banks. The island was like a crib, and the group of hills on the sunrise side of the river were like old women mantled in heavy cloaks gathered to have a look at the baby in the crib that was how Laras father had once described the lay of the land.Larth spoke like that all the time, conjuring images of giants and monsters in the landscape. He could perceive the spirits, called numina, that dwelled in rocks and trees. Sometimes he could speak to them and hear what they had to say. The river was his oldest friend and told him where the fishing would be best. From whispers in the wind he could foretell the next days weather. Because of such skills, Larth was the leader of the group.', 10, 2),
(19, 'The two groups made separate camps at opposite ends of the island. As a gesture of friendship, speaking with his hands, Larth invited Tarketios and the others to share the venison that night. As the hosts and their guests feasted around the roasting fire, Tarketios tried to explain something of his craft. Firelight glittered in Larags eyes as she watched Tarketios point at the flames and mime the act of hammering. Firelight danced across the flexing muscles of his arms and shoulders. When he smiled at her, his grin was like a boast. She had never seen teeth so white and so perfect.Po saw the looks the two exchanged and frowned. Larags father saw the same looks and smiled.', 7, 2),
(20, 'U šumi je bilo još mlečne magle koja se, kao ostatak od neke čudne noćne igre, povlačila pred suncem. Belo i svetlo i tiho. Slaba vidljivost i potpuna tišina stvarale su zračan predeo u kome prostor i daljina nisu imali mere i u kome je vreme gubilo svoje značenje.', 5, 5),
(21, 'Галија је југословенска и српска рок група, основана у Нишу 1976. године.', 8, 4),
(22, 'Године 1978. са новим клавијатуристом Зораном Станковићем, група је постигла први значајан успех победом на Зајечарској гитаријади, наступајући у саставу: Ненад Милосављевић (вокал, акустична гитара, усна хармоника), Горан Љубисављевић (гитара), Предраг Бранковић (бас), Бобан Павловић Чалтон (бубњеви) и Зоран Станковић (клавијатуре), а на бини су се појавили у униформама из 18. века. Неколико месеци након гитаријаде наступили су на Омладинском фестивалу у Суботици, када је на клавијатурама свирао Љубодраг Вукадиновић, а Галија је проглашена за истинско откровење фестивала Омладина 78. Током 1978. године наступали су као предгрупа на турнеји групе Смак, након тога су имали концерт у Студију М са џез групом Мета џеза секција у Новом Саду, а крајем 1978. године у истом граду наступали на Бум фестивалу.', 10, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dnevnaranglista`
--
ALTER TABLE `dnevnaranglista`
  ADD CONSTRAINT `R_20` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `R_21` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `dnevniizazov`
--
ALTER TABLE `dnevniizazov`
  ADD CONSTRAINT `R_22` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jeprijatelj`
--
ALTER TABLE `jeprijatelj`
  ADD CONSTRAINT `R_15` FOREIGN KEY (`idKor1`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `R_16` FOREIGN KEY (`idKor2`) REFERENCES `korisnik` (`id`);

--
-- Constraints for table `ranglista`
--
ALTER TABLE `ranglista`
  ADD CONSTRAINT `R_17` FOREIGN KEY (`idKor`) REFERENCES `korisnik` (`id`),
  ADD CONSTRAINT `R_18` FOREIGN KEY (`idTekst`) REFERENCES `tekst` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tekst`
--
ALTER TABLE `tekst`
  ADD CONSTRAINT `R_2` FOREIGN KEY (`idKat`) REFERENCES `kategorija` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
