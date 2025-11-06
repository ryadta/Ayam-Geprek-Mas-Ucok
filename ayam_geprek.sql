-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 06, 2025 at 11:40 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ayam_geprek`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `harga`) VALUES
(1, 'Ayam geprek', 8000),
(2, 'Ayam crispy + nasi', 13000),
(3, 'Ori', 13000),
(4, 'Ori + nasi', 15000),
(5, 'Matah', 13000),
(6, 'Matah + nasi', 15000),
(7, 'Korek', 13000),
(8, 'Korek + nasi', 15000),
(9, 'Terasi', 13000),
(10, 'Terasi + nasi', 15000),
(11, 'Nasi goreng', 13000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

DROP TABLE IF EXISTS `penjualan`;
CREATE TABLE IF NOT EXISTS `penjualan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menu` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `jumlah` int NOT NULL,
  `total` int NOT NULL,
  `tanggal` date NOT NULL DEFAULT (curdate()),
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id`, `menu`, `harga`, `jumlah`, `total`, `tanggal`, `created_at`) VALUES
(1, 'Ayam geprek', 8000, 2, 16000, '2025-11-06', '2025-11-06 10:37:26'),
(2, 'Korek + nasi', 15000, 2, 30000, '2025-11-06', '2025-11-06 10:37:26'),
(3, 'Nasi goreng', 13000, 2, 26000, '2025-11-06', '2025-11-06 10:37:26'),
(4, 'Ayam geprek', 8000, 1, 8000, '2025-11-06', '2025-11-06 10:37:51'),
(5, 'Ori + nasi', 15000, 1, 15000, '2025-11-06', '2025-11-06 10:37:51'),
(6, 'Ayam geprek', 8000, 1, 8000, '2025-11-06', '2025-11-06 10:37:59'),
(7, 'Ori + nasi', 15000, 1, 15000, '2025-11-06', '2025-11-06 10:37:59'),
(8, 'Ayam geprek', 8000, 3, 24000, '2025-11-06', '2025-11-06 10:38:48'),
(9, 'Ayam crispy + nasi', 13000, 3, 39000, '2025-11-06', '2025-11-06 10:38:48'),
(10, 'Nasi goreng', 13000, 2, 26000, '2025-11-06', '2025-11-06 10:39:01'),
(11, 'Terasi + nasi', 15000, 2, 30000, '2025-11-06', '2025-11-06 10:44:23'),
(12, 'Korek + nasi', 15000, 4, 60000, '2025-11-06', '2025-11-06 10:44:36'),
(13, 'Ayam geprek', 8000, 3, 24000, '2025-11-06', '2025-11-06 10:46:14'),
(14, 'Korek + nasi', 15000, 1, 15000, '2025-11-06', '2025-11-06 10:50:53'),
(15, 'Nasi goreng', 13000, 3, 39000, '2025-11-06', '2025-11-06 10:53:48'),
(16, 'Nasi goreng', 13000, 1, 13000, '2025-11-06', '2025-11-06 10:55:01'),
(17, 'Nasi goreng', 13000, 1, 13000, '2025-11-06', '2025-11-06 10:55:10'),
(18, 'Terasi', 13000, 2, 26000, '2025-11-06', '2025-11-06 10:55:43'),
(19, 'Nasi goreng', 13000, 2, 26000, '2025-11-06', '2025-11-06 10:55:43'),
(20, 'Nasi goreng', 13000, 6, 78000, '2025-11-06', '2025-11-06 10:59:23'),
(21, 'Nasi goreng', 13000, 2, 26000, '2025-11-06', '2025-11-06 11:00:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', '2025-11-06 10:36:48');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
