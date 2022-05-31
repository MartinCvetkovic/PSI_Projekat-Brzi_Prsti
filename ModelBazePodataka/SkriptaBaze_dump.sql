-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2022 at 08:29 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `brziprsti`
--
CREATE DATABASE IF NOT EXISTS `brziprsti` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `brziprsti`;

-- --------------------------------------------------------

--
-- Table structure for table `dnevnaranglista`
--

DROP TABLE IF EXISTS `dnevnaranglista`;
CREATE TABLE `dnevnaranglista` (
  `id` int(11) NOT NULL,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dnevniizazov`
--

DROP TABLE IF EXISTS `dnevniizazov`;
CREATE TABLE `dnevniizazov` (
  `id` int(11) NOT NULL,
  `sadrzaj` varchar(4000) DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `nazivKategorije` varchar(20) DEFAULT NULL,
  `idTekst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dnevniizazov`
--

INSERT INTO `dnevniizazov` (`id`, `sadrzaj`, `tezina`, `nazivKategorije`, `idTekst`) VALUES
(6, 'Drugi tekst!!!!', 1, 'srpski', 13);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jeprijatelj`
--

DROP TABLE IF EXISTS `jeprijatelj`;
CREATE TABLE `jeprijatelj` (
  `id` int(11) NOT NULL,
  `idKor1` int(11) NOT NULL,
  `idKor2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
CREATE TABLE `kategorija` (
  `id` int(11) NOT NULL,
  `naziv` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategorija`
--

INSERT INTO `kategorija` (`id`, `naziv`) VALUES
(1, 'srpski'),
(2, 'engleski');

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE `korisnik` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `zlato` int(11) DEFAULT NULL,
  `srebro` int(11) DEFAULT NULL,
  `bronza` int(11) DEFAULT NULL,
  `tip` int(11) DEFAULT NULL,
  `aktivan` int(11) DEFAULT NULL,
  `brojPrijatelja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`id`, `username`, `password`, `zlato`, `srebro`, `bronza`, `tip`, `aktivan`, `brojPrijatelja`) VALUES
(1, 'admin', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 2, 1, 0),
(2, 'korisnik1', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 2, 1, 1),
(3, 'moderator', '$2y$10$QS31ukwN4E3ViIk2Iz5/j.2.Q.iHDuYQ7YOKPo/iSwLLT2Yzlp4/e', 0, 0, 0, 1, 1, 1),
(4, 'korisnik2', '$2y$10$7yggpSOOIbbtrdylcSvsg.pJtHXi6UeRoUZG6E7Xv4ZYwswa9ulh.', 0, 0, 0, 0, 1, 1),
(5, 'korisnik3', '$2y$10$csRKUPzbWLF/8EP7D9f0FeqO0bUtQQPkdEG2N.72ECOvh.OjpfBtC', 0, 0, 0, 0, 1, 0),
(6, 'korisnik4', '$2y$10$JD6pPceK/7TUJUpj2pl81OT6w2YEJYooHPsEiOmmtIRVYLP5zoW/6', 0, 0, 0, 0, 1, 0),
(7, 'korisnik5', '$2y$10$.bpHuJ74oWCQqoe.iJk.G.l1dcJZtreCLptpg9K49Vo7S/2uCiRr2', 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ranglista`
--

DROP TABLE IF EXISTS `ranglista`;
CREATE TABLE `ranglista` (
  `id` int(11) NOT NULL,
  `vreme` float DEFAULT NULL,
  `idKor` int(11) NOT NULL,
  `idTekst` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ranglista`
--

INSERT INTO `ranglista` (`id`, `vreme`, `idKor`, `idTekst`) VALUES
(6, 2.97, 2, 14),
(7, 0.79, 2, 12),
(8, 1.68, 2, 12),
(9, 2.46, 2, 12),
(10, 1.74, 2, 12),
(11, 9.76, 2, 13),
(12, 2.76, 2, 13),
(13, 1.98, 2, 14),
(14, 1.05, 4, 12),
(15, 2.45, 4, 13),
(16, 2.23, 4, 14),
(17, 45.34, 5, 12),
(18, 44.08, 6, 13),
(19, 2.18, 7, 14),
(20, 18.79, 3, 16),
(21, 20.85, 2, 16);

-- --------------------------------------------------------

--
-- Table structure for table `tekst`
--

DROP TABLE IF EXISTS `tekst`;
CREATE TABLE `tekst` (
  `id` int(11) NOT NULL,
  `sadrzaj` varchar(4000) DEFAULT NULL,
  `tezina` float DEFAULT NULL,
  `idKat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tekst`
--

INSERT INTO `tekst` (`id`, `sadrzaj`, `tezina`, `idKat`) VALUES
(12, 'Prvi tekst', NULL, 1),
(13, 'Drugi tekst!!!!', 1, 1),
(14, 'Ovo je treci tekst', 6, 1),
(16, 'Maecenas condimentum elementum lacus. Sed dapibus velit vel ante tincidunt posuere. Cras sed accumsan dui. Aenean rhoncus pretium ante, in commodo felis scelerisque vitae. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed libero massa, ultrices quis volutpat non, egestas quis erat. Nulla facilisi. Suspendisse accumsan pretium ornare. Sed posuere nisi sit amet rutrum ultricies. Cras consequat mi ex, a lobortis quam sagittis sit amet. Nam ultrices velit id risus lobortis lobortis.', 4, 2),
(18, 'Phasellus vulputate augue in dui maximus commodo. Nullam id gravida enim, in euismod nisl. In posuere dui non ornare lobortis. Maecenas suscipit ligula nec lorem ultrices elementum. Praesent id dolor rhoncus nulla varius iaculis. Nunc euismod bibendum est non rhoncus. Nam imperdiet tortor vulputate augue luctus, eget blandit mauris congue. Suspendisse at dolor quis lorem maximus imperdiet. Cras nunc nibh, mattis et ex vitae, elementum faucibus urna. Praesent eu mattis libero. Ut efficitur elit sit amet mi scelerisque, vitae feugiat eros sollicitudin. Nunc hendrerit dignissim risus nec euismod. Suspendisse dictum tincidunt nisi eu laoreet. Nam dapibus enim eu efficitur accumsan. Phasellus at lorem nec mi rutrum interdum. Phasellus vel est ligula.', 10, 2),
(19, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eget pulvinar tortor, vel consequat sapien. Nam erat ligula, placerat imperdiet libero bibendum, vehicula pellentesque nibh. Praesent vulputate nisl et sapien interdum, eu egestas lacus bibendum. Curabitur ante leo, lobortis et erat quis, hendrerit sodales ante. Morbi a odio et odio feugiat egestas non vel nisl. Mauris commodo volutpat tristique. Mauris volutpat, odio nec interdum tincidunt, urna dui elementum tortor, vel interdum lacus nisl nec magna. Nullam facilisis arcu eget tortor rutrum, nec vulputate nisi semper. Aliquam vestibulum scelerisque ligula, ut faucibus tellus. Morbi sed tincidunt ex. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.', 7, 2),
(20, 'U šumi je bilo još mlečne magle koja se, kao ostatak od neke čudne noćne igre, povlačila pred suncem. Belo i svetlo i tiho. Slaba vidljivost i potpuna tišina stvarale su zračan predeo u kome prostor i daljina nisu imali mere i u kome je vreme gubilo svoje značenje.', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dnevnaranglista`
--
ALTER TABLE `dnevnaranglista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `R_20` (`idKor`),
  ADD KEY `R_21` (`idTekst`);

--
-- Indexes for table `dnevniizazov`
--
ALTER TABLE `dnevniizazov`
  ADD PRIMARY KEY (`id`),
  ADD KEY `R_22` (`idTekst`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jeprijatelj`
--
ALTER TABLE `jeprijatelj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `R_15` (`idKor1`),
  ADD KEY `R_16` (`idKor2`);

--
-- Indexes for table `kategorija`
--
ALTER TABLE `kategorija`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `ranglista`
--
ALTER TABLE `ranglista`
  ADD PRIMARY KEY (`id`),
  ADD KEY `R_17` (`idKor`),
  ADD KEY `R_18` (`idTekst`);

--
-- Indexes for table `tekst`
--
ALTER TABLE `tekst`
  ADD PRIMARY KEY (`id`),
  ADD KEY `R_2` (`idKat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dnevnaranglista`
--
ALTER TABLE `dnevnaranglista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dnevniizazov`
--
ALTER TABLE `dnevniizazov`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jeprijatelj`
--
ALTER TABLE `jeprijatelj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategorija`
--
ALTER TABLE `kategorija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ranglista`
--
ALTER TABLE `ranglista`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tekst`
--
ALTER TABLE `tekst`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
