-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 24, 2023 at 04:10 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rumah_sakit`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pasien`
--

DROP TABLE IF EXISTS `tbl_pasien`;
CREATE TABLE IF NOT EXISTS `tbl_pasien` (
  `no_dokter` smallint(6) NOT NULL AUTO_INCREMENT,
  `nama_pasien` varchar(40) NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `norm` char(6) NOT NULL,
  PRIMARY KEY (`no_dokter`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_pasien`
--

INSERT INTO `tbl_pasien` (`no_dokter`, `nama_pasien`, `tgl_periksa`, `norm`) VALUES
(1, 'Aa', '2023-01-19 07:45:30', '000001'),
(2, 'Bb', '2023-01-19 07:45:30', '000002'),
(3, 'Cc', '2023-01-19 07:46:27', '000003'),
(4, 'Dd', '2023-01-19 07:46:27', '000004');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
