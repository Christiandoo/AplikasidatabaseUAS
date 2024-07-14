-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for aplikasidatabase
DROP DATABASE IF EXISTS `aplikasidatabase2`;
CREATE DATABASE IF NOT EXISTS `aplikasidatabase2` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `aplikasidatabase2`;

-- Dumping structure for table aplikasidatabase.bukutamu
DROP TABLE IF EXISTS `bukutamu`;
CREATE TABLE IF NOT EXISTS `bukutamu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pesan` varchar(100) NOT NULL,
  `tgl_bukutamu` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.bukutamu: ~3 rows (approximately)
INSERT INTO `bukutamu` (`id`, `nama`, `email`, `pesan`, `tgl_bukutamu`) VALUES
	(3, 'Ardhi', 'ardhi@gmail.com', 'cobaa', '07-07-2018'),
	(4, 'kiw', 'kiwkiw@gmail.com', 'nyoba\r\n', '08-07-2018'),
	(5, 'bibir', 'bibir@gmail.com', 'percobaan', '08-07-2018');

-- Dumping structure for table aplikasidatabase.daftarkoleksi
DROP TABLE IF EXISTS `daftarkoleksi`;
CREATE TABLE IF NOT EXISTS `daftarkoleksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kodekatalog` varchar(20) NOT NULL,
  `judulkatalog` varchar(50) NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.daftarkoleksi: ~3 rows (approximately)
INSERT INTO `daftarkoleksi` (`id`, `kodekatalog`, `judulkatalog`, `jumlah`) VALUES
	(1, '32832435345', 'Tutorial Mysql', 12),
	(2, '43545454625', 'Performance Jquery Pada Aplikasi Web', 37),
	(3, '43436353435', 'Kontan: Koruptor Masa Kini', 45);

-- Dumping structure for table aplikasidatabase.gallery
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE IF NOT EXISTS `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_file` varchar(100) NOT NULL,
  `judul` varchar(100) NOT NULL,
  `tgl_gallery` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.gallery: ~1 rows (approximately)
INSERT INTO `gallery` (`id`, `nama_file`, `judul`, `tgl_gallery`) VALUES
	(24, 'hoodie.jpg', 'hoodie keren', '2024-05-19 20:36:58');

-- Dumping structure for table aplikasidatabase.kategori
DROP TABLE IF EXISTS `kategori`;
CREATE TABLE IF NOT EXISTS `kategori` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.kategori: ~5 rows (approximately)
INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
	(1, 'T-Shirt'),
	(2, 'Long T-Shirt'),
	(3, 'Hoodie'),
	(4, 'Kemeja'),
	(5, 'Celana Jeans');

-- Dumping structure for table aplikasidatabase.keranjang
DROP TABLE IF EXISTS `keranjang`;
CREATE TABLE IF NOT EXISTS `keranjang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_produk` int DEFAULT NULL,
  `jumlah` int DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table aplikasidatabase.keranjang: ~6 rows (approximately)
INSERT INTO `keranjang` (`id`, `id_produk`, `jumlah`, `session_id`) VALUES
	(3, 28, 2, 's9c2q0saot9smfir439r02veup'),
	(4, 32, 1, 's9c2q0saot9smfir439r02veup'),
	(5, 36, 1, '8dcgfhr1nonlmnjhv3cgg8ipf7'),
	(6, 34, 1, '8dcgfhr1nonlmnjhv3cgg8ipf7'),
	(7, 33, 1, '8dcgfhr1nonlmnjhv3cgg8ipf7'),
	(8, 32, 1, 'sjkfu8ctktu8plpj9n0hve14rr');

-- Dumping structure for table aplikasidatabase.komentar
DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `komentar` varchar(255) NOT NULL,
  `tgl_komentar` varchar(20) NOT NULL,
  `id_post` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.komentar: ~1 rows (approximately)
INSERT INTO `komentar` (`id`, `nama`, `email`, `komentar`, `tgl_komentar`, `id_post`) VALUES
	(6, 'mocahasda', 'mochluay00@gmail.com', 'apaan nih\r\n', '19-05-2024', '7');

-- Dumping structure for table aplikasidatabase.pembayaran
DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pesanan` int NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `nomor_kartu` varchar(20) DEFAULT NULL,
  `total_bayar` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT NULL,
  `bukti_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pesanan` (`id_pesanan`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table aplikasidatabase.pembayaran: ~0 rows (approximately)

-- Dumping structure for table aplikasidatabase.pesanan
DROP TABLE IF EXISTS `pesanan`;
CREATE TABLE IF NOT EXISTS `pesanan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `total_harga` decimal(10,2) NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `nama_penerima` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `nomor_pesanan` varchar(50) NOT NULL,
  `status_pesanan` enum('Menunggu Pembayaran','Dibayar','Diproses','Dikirim') DEFAULT 'Menunggu Pembayaran',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table aplikasidatabase.pesanan: ~0 rows (approximately)

-- Dumping structure for table aplikasidatabase.pesanan_items
DROP TABLE IF EXISTS `pesanan_items`;
CREATE TABLE IF NOT EXISTS `pesanan_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pesanan` int NOT NULL,
  `nama_product` varchar(255) NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_pesanan` (`id_pesanan`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ;

-- Dumping data for table aplikasidatabase.pesanan_items: ~0 rows (approximately)

-- Dumping structure for table aplikasidatabase.post_produk
DROP TABLE IF EXISTS `post_produk`;
CREATE TABLE IF NOT EXISTS `post_produk` (
  `id` int NOT NULL AUTO_INCREMENT,
  `produk` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` double NOT NULL,
  `tgl_post` varchar(255) NOT NULL,
  `kategori` varchar(255) NOT NULL,
  `stok` enum('habis','tersedia') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci  DEFAULT 'tersedia',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.post_produk: ~3 rows (approximately)
INSERT INTO `post_produk` (`id`, `produk`, `foto`, `deskripsi`, `harga`, `tgl_post`, `kategori`, `stok`) VALUES
	(34, 'kaos', 'kaoshitam.jpg', 'kaos keren', 50000, '2024-06-01', 'T-Shirt', 'habis'),
	(35, 'celana jeans pria', 'celana.jpg', 'jeans keren', 150000, '2024-06-01', 'Celana Jeans', ''),
	(37, 'hodie', 'hoodie.jpg', 'hodie berbahan corduroy', 100000, '2024-06-01', 'Hoodie', '');

-- Dumping structure for table aplikasidatabase.statistik
DROP TABLE IF EXISTS `statistik`;
CREATE TABLE IF NOT EXISTS `statistik` (
  `ip` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `hits` int NOT NULL,
  `online` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.statistik: ~0 rows (approximately)

-- Dumping structure for table aplikasidatabase.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
	(8, 'admin', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 1),
	(11, 'user', 'user@gmail.com', '6ad14ba9986e3615423dfca256d04e3f', 0);

-- Dumping structure for table aplikasidatabase.visitor
DROP TABLE IF EXISTS `visitor`;
CREATE TABLE IF NOT EXISTS `visitor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `os` varchar(100) NOT NULL,
  `browser` varchar(100) NOT NULL,
  `tgl_visitor` varchar(20) NOT NULL,
  `page` varchar(20) NOT NULL,
  `date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table aplikasidatabase.visitor: ~21 rows (approximately)
INSERT INTO `visitor` (`id`, `ip`, `os`, `browser`, `tgl_visitor`, `page`, `date_time`) VALUES
	(1, '::1', 'Windows 10', 'Google Chrome v.52.0.2743.116', '2018-07-07 20:46:33', 'final_project', NULL),
	(2, '::1', 'Windows 10', 'Google Chrome v.67.0.3396.99', '2018-07-08 00:07:09', 'where', NULL),
	(3, '::1', 'Windows 10', 'Google Chrome v.67.0.3396.99', '2018-07-08 01:58:21', 'index.php', NULL),
	(4, '::1', 'Windows 10', 'Google Chrome v.67.0.3396.99', '2018-07-08 02:07:11', 'index.php', NULL),
	(5, '::1', 'Windows 7', 'Google Chrome v.46.0.2490.80', '2018-07-08 17:47:14', 'where', NULL),
	(6, '::1', 'Windows 7', 'Google Chrome v.30.0.1551.0', '2018-07-11 13:10:39', 'where', NULL),
	(7, '::1', 'Windows 7', 'Internet Explorer v.8.0', '2018-07-11 13:15:58', 'where', NULL),
	(8, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-11 13:53:44', 'index.php', NULL),
	(9, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-11 14:33:21', 'index.php', NULL),
	(10, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-16 19:36:14', 'index.php', NULL),
	(11, '::1', 'Windows 7', 'Google Chrome v.30.0.1551.0', '2018-07-16 20:58:04', 'index.php', NULL),
	(12, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-16 21:02:30', 'index.php', NULL),
	(13, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-16 22:46:51', 'index.php', NULL),
	(14, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-18 16:38:47', 'index.php', NULL),
	(15, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-18 16:46:59', 'where', NULL),
	(16, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-18 21:28:40', 'index.php', NULL),
	(17, '::1', 'Windows 7', 'Google Chrome v.67.0.3396.99', '2018-07-19 09:01:21', 'where', NULL),
	(18, '::1', 'Windows 7', 'Google Chrome v.69.0.3497.100', '2018-10-02 15:14:56', 'index.php', NULL),
	(19, '::1', 'Windows 7', 'Google Chrome v.71.0.3578.98', '2019-06-19 20:19:45', 'where', NULL),
	(20, '::1', 'Windows 10', 'Google Chrome v.125.0.0.0', '2024-05-19 08:57:57', 'index.php', NULL),
	(21, '::1', 'Windows 10', 'Google Chrome v.125.0.0.0', '2024-05-31 15:02:07', 'index.php', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
