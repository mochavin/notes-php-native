-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for fp_pweb
CREATE DATABASE IF NOT EXISTS `fp_pweb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `fp_pweb`;

-- Dumping structure for table fp_pweb.note
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_note`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fp_pweb.note: ~10 rows (approximately)
INSERT INTO `note` (`id_note`, `title`, `content`, `created_at`, `updated_at`) VALUES
	(1, 'kesatu', 'wes keren', '2023-12-16 13:25:40', '2023-12-16 14:44:21'),
	(2, 'kedua', 'bukan punya user id 12', '2023-12-16 13:31:11', '2023-12-16 13:31:13'),
	(3, 'judul ke dua', 'wow ini kedua', '2023-12-16 13:36:28', '2023-12-16 13:36:28'),
	(4, 'judul ke dua', 'wow ini kedua', '2023-12-16 13:37:39', '2023-12-16 13:37:39'),
	(5, 'asd', 'sdf', '2023-12-16 13:37:46', '2023-12-16 13:37:46'),
	(6, 'asd', 'sdf', '2023-12-16 13:39:09', '2023-12-16 13:39:09'),
	(7, 'asd', 'sdf', '2023-12-16 13:39:27', '2023-12-16 13:39:27'),
	(10, '', '', '2023-12-16 13:40:58', '2023-12-16 13:40:58'),
	(11, 'content ke tiga ', 'wow ini kedua sudah update', '2023-12-16 13:42:06', '2023-12-16 14:40:19'),
	(12, 'ini note admin', 'admin admin admin admin', '2023-12-16 13:56:55', '2023-12-16 13:56:55'),
	(13, 'judul selanjutnya', 'ini kontennya judul selanjutnya\r\n', '2023-12-16 14:46:13', '2023-12-16 14:46:13');

-- Dumping structure for table fp_pweb.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fp_pweb.user: ~2 rows (approximately)
INSERT INTO `user` (`id_user`, `username`, `password`, `role`) VALUES
	(11, 'admin', 'admin', 'admin'),
	(12, 'user', 'user', 'user'),
	(14, 'admin2', 'admin', 'user');

-- Dumping structure for table fp_pweb.user_note
CREATE TABLE IF NOT EXISTS `user_note` (
  `id_user` int(11) NOT NULL,
  `id_note` int(11) NOT NULL,
  KEY `id_user` (`id_user`),
  KEY `id_note` (`id_note`),
  CONSTRAINT `user_note_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  CONSTRAINT `user_note_ibfk_2` FOREIGN KEY (`id_note`) REFERENCES `note` (`id_note`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table fp_pweb.user_note: ~1 rows (approximately)
INSERT INTO `user_note` (`id_user`, `id_note`) VALUES
	(12, 1),
	(12, 11),
	(11, 12),
	(12, 13);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
