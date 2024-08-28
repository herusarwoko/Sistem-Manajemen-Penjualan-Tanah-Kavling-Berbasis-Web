-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2023 at 02:29 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kav_mentaya`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `bank_id` int(11) NOT NULL,
  `bank_nama` varchar(255) NOT NULL,
  `bank_nomor` varchar(255) NOT NULL,
  `bank_pemilik` varchar(255) NOT NULL,
  `bank_saldo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`bank_id`, `bank_nama`, `bank_nomor`, `bank_pemilik`, `bank_saldo`) VALUES
(1, 'Bank Syariah Indonesia', '', '', 0),
(5, 'Cash', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `barang_id` int(11) NOT NULL,
  `barang` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('jdb91scn2k87ivfb6c6ieg25chtme4uj', '127.0.0.1', 1676873485, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637363837333438353b),
('n665g8qfmegtuo2po2r5446nduec0nl1', '127.0.0.1', 1676873485, 0x5f5f63695f6c6173745f726567656e65726174657c693a313637363837333438353b);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(5) NOT NULL,
  `nama_lengkap` varchar(150) NOT NULL,
  `no_ktp` varchar(25) NOT NULL,
  `no_kk` varchar(35) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `pekerjaan` varchar(100) NOT NULL,
  `no_telp` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `surat_akad` varchar(100) NOT NULL,
  `ktp` varchar(100) NOT NULL,
  `kk` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `nama_divisi` varchar(35) NOT NULL,
  `keterangan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses`
--

CREATE TABLE `hak_akses` (
  `id_hak_akses` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `status_hak` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hak_akses`
--

INSERT INTO `hak_akses` (`id_hak_akses`, `id_user`, `id_menu`, `status_hak`) VALUES
(1, 1, 1, 1),
(2, 1, 3, 1),
(3, 1, 4, 1),
(4, 1, 5, 1),
(5, 1, 6, 1),
(6, 1, 7, 1),
(7, 1, 8, 1),
(8, 1, 9, 1),
(9, 1, 10, 1),
(10, 1, 11, 1),
(21, 1, 12, 1),
(44, 1, 13, 1),
(93, 1, 14, 1),
(108, 1, 2, 1),
(109, 1, 15, 1),
(110, 1, 16, 1),
(111, 1, 17, 0),
(112, 1, 18, 1),
(113, 1, 19, 1),
(114, 1, 20, 1),
(115, 1, 21, 1),
(116, 1, 22, 1),
(138, 1, 23, 1),
(139, 1, 24, 1),
(232, 1, 25, 0),
(233, 1, 26, 1),
(234, 1, 27, 1),
(235, 1, 28, 1),
(236, 1, 29, 1),
(237, 1, 30, 1),
(238, 1, 31, 1),
(253, 1, 32, 1),
(254, 1, 33, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `id_customer`, `kategori`) VALUES
(1, 11, 'jani sudjaja'),
(2, 12, 'JANI SUDJAJA'),
(3, 13, 'Ade Aji');

-- --------------------------------------------------------

--
-- Table structure for table `kavling_peta`
--

CREATE TABLE `kavling_peta` (
  `id_kavling` int(11) NOT NULL,
  `kode_kavling` varchar(15) NOT NULL,
  `panjang_kanan` double(11,1) NOT NULL,
  `panjang_kiri` double(11,1) NOT NULL,
  `lebar_depan` double(11,1) NOT NULL,
  `lebar_belakang` double(11,1) NOT NULL,
  `luas_tanah` int(11) NOT NULL,
  `hrg_meter` int(11) NOT NULL,
  `hrg_jual` int(11) NOT NULL,
  `jenis_map` varchar(15) NOT NULL,
  `map` text NOT NULL,
  `matrik` varchar(250) NOT NULL,
  `status` int(2) NOT NULL,
  `id_customer` int(3) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `tgl_jatuh_tempo` int(2) NOT NULL,
  `stt_cicilan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kavling_peta`
--

INSERT INTO `kavling_peta` (`id_kavling`, `kode_kavling`, `panjang_kanan`, `panjang_kiri`, `lebar_depan`, `lebar_belakang`, `luas_tanah`, `hrg_meter`, `hrg_jual`, `jenis_map`, `map`, `matrik`, `status`, `id_customer`, `id_marketing`, `keterangan`, `tgl_jatuh_tempo`, `stt_cicilan`) VALUES
(1, 'D-1', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,5722 7117,5722 7117,7119 7891,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10495.1 9712.37)', 0, 0, 0, '', 0, 0),
(2, 'D-2', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,5722 7926,5722 7926,7119 8700,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9709.51 9726.15)', 0, 0, 0, '', 0, 0),
(3, 'D-3', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,5722 8735,5722 8735,7119 9509,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8890.86 9725.2)', 0, 0, 0, '', 0, 0),
(4, 'D-4', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,5722 9544,5722 9544,7119 10318,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8092.27 9729.71)', 0, 0, 0, '', 0, 0),
(5, 'D-5', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,5722 10353,5722 10353,7119 11126,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7273.97 9734.39)', 0, 0, 0, '', 0, 0),
(6, 'D-6', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,5722 11162,5722 11162,7119 11935,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6463.55 9726.3)', 0, 0, 0, '', 0, 0),
(7, 'D-7', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,5722 11971,5722 11971,7119 12744,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5641.28 9729.91)', 0, 0, 0, '', 0, 0),
(8, 'D-8', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,5722 12779,5722 12779,7119 13553,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4849.74 9727.92)', 0, 0, 0, '', 0, 0),
(9, 'D-9', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,5722 13949,5722 13949,7119 14722,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3666.23 9724.99)', 0, 0, 0, '', 0, 0),
(10, 'D-10', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,5722 14758,5722 14758,7119 15531,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2902.02 9759.5)', 0, 0, 0, '', 0, 0),
(11, 'D-11', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,5722 15566,5722 15566,7119 16340,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2079.37 9745.55)', 0, 0, 0, '', 0, 0),
(12, 'D-12', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,5722 16375,5722 16375,7119 17149,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1292.3 9757.87)', 0, 0, 0, '', 0, 0),
(13, 'D-13', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,5722 17184,5722 17184,7119 17958,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -473.641 9756.92)', 0, 0, 0, '', 0, 0),
(14, 'D-14', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,5722 17993,5722 17993,7119 18766,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 324.939 9761.43)', 0, 0, 0, '', 0, 0),
(15, 'D-15', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,5722 18802,5722 18802,7119 19575,7119 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1143.24 9766.11)', 0, 0, 0, '', 0, 0),
(16, 'D-16', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,5686 7891,4289 7117,4289 7117,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10539.5 8325.15)', 0, 0, 0, '', 0, 0),
(17, 'D-17', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,5686 8700,4289 7926,4289 7926,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9720.63 8332.17)', 0, 0, 0, '', 0, 0),
(18, 'D-18', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,4289 8735,4289 8735,5686 9509,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8925.67 8326.76)', 0, 0, 0, '', 0, 0),
(19, 'D-19', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,5686 10318,4289 9544,4289 9544,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8102.65 8323.84)', 0, 0, 0, '', 0, 0),
(20, 'D-20', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,5686 11126,4289 10353,4289 10353,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7326.57 8346.46)', 0, 0, 0, '', 0, 0),
(21, 'D-21', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,5686 11935,4289 11162,4289 11162,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6503.93 8332.51)', 0, 0, 0, '', 0, 0),
(22, 'D-22', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,4289 11971,4289 11971,5686 12744,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5716.84 8344.83)', 0, 0, 0, '', 0, 0),
(23, 'D-23', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,5686 13553,4289 12779,4289 12779,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4898.19 8343.89)', 0, 0, 0, '', 0, 0),
(24, 'D-24', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,5686 14722,4289 13949,4289 13949,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3736.19 8345.47)', 0, 0, 0, '', 0, 0),
(25, 'D-25', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,5686 15531,4289 14758,4289 14758,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2920.81 8353.07)', 0, 0, 0, '', 0, 0),
(26, 'D-26', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,4289 15566,4289 15566,5686 16340,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2107.46 8342.06)', 0, 0, 0, '', 0, 0),
(27, 'D-27', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,5686 17149,4289 16375,4289 16375,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1291.53 8352)', 0, 0, 0, '', 0, 0),
(28, 'D-28', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,5686 17958,4289 17184,4289 17184,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -496.571 8346.6)', 0, 0, 0, '', 0, 0),
(29, 'D-29', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,5686 18766,4289 17993,4289 17993,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 326.439 8343.67)', 0, 0, 0, '', 0, 0),
(30, 'D-30', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,5686 19575,4289 18802,4289 18802,5686 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1121.14 8347.68)', 0, 0, 0, '', 0, 0),
(31, 'A-1', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,15347 7117,15347 7117,16744 7891,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10512.1 19328.3)', 0, 0, 0, '', 0, 0),
(32, 'A-2', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7926,15347 7926,16744 8700,16744 8700,15347 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9726.48 19342.1)', 0, 0, 0, '', 0, 0),
(33, 'A-3', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8735,15347 8735,16744 9509,16744 9509,15347 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8907.83 19341.1)', 0, 0, 0, '', 0, 0),
(34, 'A-4', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,15347 9544,15347 9544,16744 10318,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8109.24 19345.6)', 0, 0, 0, '', 0, 0),
(35, 'A-5', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10353,15347 10353,16744 11126,16744 11126,15347 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7290.93 19350.3)', 0, 0, 0, '', 0, 0),
(36, 'A-6', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11162,15347 11162,16744 11935,16744 11935,15347 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6480.51 19342.2)', 0, 0, 0, '', 0, 0),
(37, 'A-7', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11971,15347 11971,16744 12744,16744 12744,15347 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5658.24 19345.8)', 0, 0, 0, '', 0, 0),
(38, 'A-8', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,15347 12779,15347 12779,16744 13553,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4866.7 19343.8)', 0, 0, 0, '', 0, 0),
(39, 'A-9', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,15347 13949,15347 13949,16744 14722,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3683.19 19340.9)', 0, 0, 0, '', 0, 0),
(40, 'A-10', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,15347 14758,15347 14758,16744 15531,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2918.99 19375.4)', 0, 0, 0, '', 0, 0),
(41, 'A-11', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,15347 15566,15347 15566,16744 16340,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2096.34 19361.5)', 0, 0, 0, '', 0, 0),
(42, 'A-12', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,15347 16375,15347 16375,16744 17149,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1309.26 19373.8)', 0, 0, 0, '', 0, 0),
(43, 'A-13', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,15347 17184,15347 17184,16744 17958,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -490.597 19372.8)', 0, 0, 0, '', 0, 0),
(44, 'A-14', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,15347 17993,15347 17993,16744 18766,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 307.983 19377.3)', 0, 0, 0, '', 0, 0),
(45, 'A-15', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,15347 18802,15347 18802,16744 19575,16744 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1126.28 19382)', 0, 0, 0, '', 0, 0),
(46, 'A-16', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7117,15312 7891,15312 7891,13914 7117,13914 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10556.4 17941.1)', 0, 0, 0, '', 0, 0),
(47, 'A-17', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,15312 8700,13914 7926,13914 7926,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9737.59 17948.1)', 0, 0, 0, '', 0, 0),
(48, 'A-18', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,13914 8735,13914 8735,15312 9509,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8942.64 17942.7)', 0, 0, 0, '', 0, 0),
(49, 'A-19', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,15312 10318,13914 9544,13914 9544,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8119.62 17939.7)', 0, 0, 0, '', 0, 0),
(50, 'A-20', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,15312 11126,13914 10353,13914 10353,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7343.53 17962.4)', 0, 0, 0, '', 0, 0),
(51, 'A-21', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,15312 11935,13914 11162,13914 11162,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6520.89 17948.4)', 0, 0, 0, '', 0, 0),
(52, 'A-22', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,13914 11971,13914 11971,15312 12744,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5733.81 17960.7)', 0, 0, 0, '', 0, 0),
(53, 'A-23', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,15312 13553,13914 12779,13914 12779,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4915.16 17959.8)', 0, 0, 0, '', 0, 0),
(54, 'A-24', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,15312 14722,13914 13949,13914 13949,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3753.15 17961.4)', 0, 0, 0, '', 0, 0),
(55, 'A-25', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,15312 15531,13914 14758,13914 14758,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2937.78 17969)', 0, 0, 0, '', 0, 0),
(56, 'A-26', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,13914 15566,13914 15566,15312 16340,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2124.42 17958)', 0, 0, 0, '', 0, 0),
(57, 'A-27', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,15312 17149,13914 16375,13914 16375,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1308.49 17967.9)', 0, 0, 0, '', 0, 0),
(58, 'A-28', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,15312 17958,13914 17184,13914 17184,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -513.527 17962.5)', 0, 0, 0, '', 0, 0),
(59, 'A-29', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,15312 18766,13914 17993,13914 17993,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 309.483 17959.6)', 0, 0, 0, '', 0, 0),
(60, 'A-30', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,15312 19575,13914 18802,13914 18802,15312 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1104.18 17963.6)', 0, 0, 0, '', 0, 0),
(61, 'B-1', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7117,13556 7891,13556 7891,12158 7117,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10494 16147.9)', 0, 0, 0, '', 0, 0),
(62, 'B-2', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7926,13556 8700,13556 8700,12158 7926,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9708.43 16161.7)', 0, 0, 0, '', 0, 0),
(63, 'B-3', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8735,13556 9509,13556 9509,12158 8735,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8889.78 16160.8)', 0, 0, 0, '', 0, 0),
(64, 'B-4', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9544,13556 10318,13556 10318,12158 9544,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8091.19 16165.3)', 0, 0, 0, '', 0, 0),
(65, 'B-5', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10353,13556 11126,13556 11126,12158 10353,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7272.89 16169.9)', 0, 0, 0, '', 0, 0),
(66, 'B-6', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11162,13556 11935,13556 11935,12158 11162,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6462.47 16161.9)', 0, 0, 0, '', 0, 0),
(67, 'B-7', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11971,13556 12744,13556 12744,12158 11971,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5640.2 16165.5)', 0, 0, 0, '', 0, 0),
(68, 'B-8', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12779,13556 13553,13556 13553,12158 12779,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4848.65 16163.5)', 0, 0, 0, '', 0, 0),
(69, 'B-9', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13949,13556 14722,13556 14722,12158 13949,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3665.14 16160.5)', 0, 0, 0, '', 0, 0),
(70, 'B-10', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14758,13556 15531,13556 15531,12158 14758,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2900.94 16195)', 0, 0, 0, '', 0, 0),
(71, 'B-11', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15566,13556 16340,13556 16340,12158 15566,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2078.29 16181.1)', 0, 0, 0, '', 0, 0),
(72, 'B-12', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16375,13556 17149,13556 17149,12158 16375,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1291.22 16193.4)', 0, 0, 0, '', 0, 0),
(73, 'B-13', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17184,13556 17958,13556 17958,12158 17184,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -472.559 16192.5)', 0, 0, 0, '', 0, 0),
(74, 'B-14', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17993,13556 18766,13556 18766,12158 17993,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 326.021 16197)', 0, 0, 0, '', 0, 0),
(75, 'B-15', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18802,13556 19575,13556 19575,12158 18802,12158 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1144.32 16201.7)', 0, 0, 0, '', 0, 0),
(76, 'B-16', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,10726 7117,10726 7117,12123 7891,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10538.4 14760.7)', 0, 0, 0, '', 0, 0),
(77, 'B-17', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,10726 7926,10726 7926,12123 8700,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9719.54 14767.7)', 0, 0, 0, '', 0, 0),
(78, 'B-18', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,10726 8735,10726 8735,12123 9509,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8924.59 14762.3)', 0, 0, 0, '', 0, 0),
(79, 'B-19', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,10726 9544,10726 9544,12123 10318,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8101.57 14759.4)', 0, 0, 0, '', 0, 0),
(80, 'B-20', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,10726 10353,10726 10353,12123 11126,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7325.49 14782)', 0, 0, 0, '', 0, 0),
(81, 'B-21', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,10726 11162,10726 11162,12123 11935,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6502.85 14768.1)', 0, 0, 0, '', 0, 0),
(82, 'B-22', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,10726 11971,10726 11971,12123 12744,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5715.76 14780.4)', 0, 0, 0, '', 0, 0),
(83, 'B-23', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,10726 12779,10726 12779,12123 13553,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4897.11 14779.4)', 0, 0, 0, '', 0, 0),
(84, 'B-24', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,10726 13949,10726 13949,12123 14722,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3735.11 14781)', 0, 0, 0, '', 0, 0),
(85, 'B-25', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,10726 14758,10726 14758,12123 15531,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2919.73 14788.6)', 0, 0, 0, '', 0, 0),
(86, 'B-26', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,10726 15566,10726 15566,12123 16340,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2106.38 14777.6)', 0, 0, 0, '', 0, 0),
(87, 'B-27', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,10726 16375,10726 16375,12123 17149,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1290.45 14787.6)', 0, 0, 0, '', 0, 0),
(88, 'B-28', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,10726 17184,10726 17184,12123 17958,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -495.489 14782.1)', 0, 0, 0, '', 0, 0),
(89, 'B-29', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,10726 17993,10726 17993,12123 18766,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 327.521 14779.2)', 0, 0, 0, '', 0, 0),
(90, 'B-30', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,10726 18802,10726 18802,12123 19575,12123 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1122.23 14783.2)', 0, 0, 0, '', 0, 0),
(91, 'C-1', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,8946 7117,8946 7117,10343 7891,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10502.7 12943.8)', 0, 0, 0, '', 0, 0),
(92, 'C-2', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,8946 7926,8946 7926,10343 8700,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9717.04 12957.6)', 0, 0, 0, '', 0, 0),
(93, 'C-3', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,8946 8735,8946 8735,10343 9509,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8898.39 12956.6)', 0, 0, 0, '', 0, 0),
(94, 'C-4', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,8946 9544,8946 9544,10343 10318,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8099.8 12961.1)', 0, 0, 0, '', 0, 0),
(95, 'C-5', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,8946 10353,8946 10353,10343 11126,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7281.5 12965.8)', 0, 0, 0, '', 0, 0),
(96, 'C-6', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,8946 11162,8946 11162,10343 11935,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6471.08 12957.7)', 0, 0, 0, '', 0, 0),
(97, 'C-7', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,8946 11971,8946 11971,10343 12744,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5648.81 12961.3)', 0, 0, 0, '', 0, 0),
(98, 'C-8', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,8946 12779,8946 12779,10343 13553,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4857.27 12959.4)', 0, 0, 0, '', 0, 0),
(99, 'C-9', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,8946 13949,8946 13949,10343 14722,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3673.76 12956.4)', 0, 0, 0, '', 0, 0),
(100, 'C-10', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,8946 14758,8946 14758,10343 15531,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2909.56 12990.9)', 0, 0, 0, '', 0, 0),
(101, 'C-11', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,8946 15566,8946 15566,10343 16340,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2086.9 12977)', 0, 0, 0, '', 0, 0),
(102, 'C-12', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,8946 16375,8946 16375,10343 17149,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1299.83 12989.3)', 0, 0, 0, '', 0, 0),
(103, 'C-13', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,8946 17184,8946 17184,10343 17958,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -481.171 12988.4)', 0, 0, 0, '', 0, 0),
(104, 'C-14', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,8946 17993,8946 17993,10343 18766,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 317.409 12992.9)', 0, 0, 0, '', 0, 0),
(105, 'C-15', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,8946 18802,8946 18802,10343 19575,10343 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1135.71 12997.5)', 0, 0, 0, '', 0, 0),
(106, 'C-16', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '7891,8910 7891,7513 7117,7513 7117,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -10547 11556.6)', 0, 0, 0, '', 0, 0),
(107, 'C-17', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '8700,8910 8700,7513 7926,7513 7926,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -9728.16 11563.6)', 0, 0, 0, '', 0, 0),
(108, 'C-18', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '9509,7513 8735,7513 8735,8910 9509,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8933.2 11558.2)', 0, 0, 0, '', 0, 0),
(109, 'C-19', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '10318,8910 10318,7513 9544,7513 9544,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -8110.18 11555.3)', 0, 0, 0, '', 0, 0),
(110, 'C-20', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11126,8910 11126,7513 10353,7513 10353,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -7334.1 11577.9)', 0, 0, 0, '', 0, 0),
(111, 'C-21', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '11935,8910 11935,7513 11162,7513 11162,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -6511.46 11563.9)', 0, 0, 0, '', 0, 0),
(112, 'C-22', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '12744,7513 11971,7513 11971,8910 12744,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -5724.38 11576.3)', 0, 0, 0, '', 0, 0),
(113, 'C-23', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '13553,8910 13553,7513 12779,7513 12779,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -4905.73 11575.3)', 0, 0, 0, '', 0, 0),
(114, 'C-24', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '14722,8910 14722,7513 13949,7513 13949,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -3743.72 11576.9)', 0, 0, 0, '', 0, 0),
(115, 'C-25', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '15531,8910 15531,7513 14758,7513 14758,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2928.34 11584.5)', 0, 0, 0, '', 0, 0),
(116, 'C-26', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '16340,7513 15566,7513 15566,8910 16340,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -2114.99 11573.5)', 0, 0, 0, '', 0, 0),
(117, 'C-27', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17149,8910 17149,7513 16375,7513 16375,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -1299.06 11583.4)', 0, 0, 0, '', 0, 0),
(118, 'C-28', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '17958,8910 17958,7513 17184,7513 17184,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 -504.101 11578)', 0, 0, 0, '', 0, 0),
(119, 'C-29', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '18766,8910 18766,7513 17993,7513 17993,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 318.909 11575.1)', 0, 0, 0, '', 0, 0),
(120, 'C-30', 0.0, 0.0, 0.0, 0.0, 0, 0, 0, 'polygon', '19575,8910 19575,7513 18802,7513 18802,8910 ', 'matrix(0.707107 -0.707107 0.707107 0.707107 1113.61 11579.1)', 0, 0, 0, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `kirim`
--

CREATE TABLE `kirim` (
  `id_kirim` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam` time NOT NULL,
  `jenis` varchar(15) NOT NULL,
  `nama_pasien` varchar(50) NOT NULL,
  `no_tujuan` varchar(35) NOT NULL,
  `isi_pesan` text NOT NULL,
  `stt_kirim` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id` int(5) NOT NULL,
  `nama_kavling` varchar(250) NOT NULL,
  `nama_perusahaan` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `telp` varchar(50) NOT NULL,
  `hape` varchar(15) NOT NULL,
  `fax` varchar(50) NOT NULL,
  `nama_bank` varchar(35) NOT NULL,
  `no_rekening` varchar(25) NOT NULL,
  `nama_pemilik_rek` varchar(40) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `kota_penandatanganan` varchar(75) NOT NULL,
  `file_ttd` varchar(50) NOT NULL,
  `nama_penandatangan` varchar(50) NOT NULL,
  `nama_mengetahui` varchar(200) NOT NULL,
  `akad_cash` varchar(35) NOT NULL,
  `akad_kredit` varchar(35) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id`, `nama_kavling`, `nama_perusahaan`, `alamat`, `email`, `telp`, `hape`, `fax`, `nama_bank`, `no_rekening`, `nama_pemilik_rek`, `logo`, `kota_penandatanganan`, `file_ttd`, `nama_penandatangan`, `nama_mengetahui`, `akad_cash`, `akad_kredit`) VALUES
(1, 'Demo Kavling Berkah', 'CV. Demo Kavling Berkah', ' JL. SARADAN GANG HATI Mu dan Dia', 'arkhakavling@gmail.com', '081809179979', '081809179979', '0542 - 8800930', 'BCA', '3030300261', 'ACA YANCA', '1676870537867.png', 'Sampit 123', '1676261373861.png', 'ACA YANCA', 'Syaiful Hidayat', 'akad_cash.docx', 'akad_kredit.docx');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi_wa`
--

CREATE TABLE `konfigurasi_wa` (
  `id` int(11) NOT NULL,
  `id_device` varchar(50) NOT NULL,
  `no_telp` varchar(35) NOT NULL,
  `jam_ultah` time NOT NULL,
  `acak` int(11) NOT NULL,
  `stt_keteangan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `konfigurasi_wa`
--

INSERT INTO `konfigurasi_wa` (`id`, `id_device`, `no_telp`, `jam_ultah`, `acak`, `stt_keteangan`) VALUES
(1, '11f1837caa12e6217341301e98edc027', '081250274777', '01:33:00', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `marketing`
--

CREATE TABLE `marketing` (
  `id_marketing` int(11) NOT NULL,
  `nama_marketing` varchar(50) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `jenis_kelamin` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `id_parent` int(11) NOT NULL,
  `title_menu` varchar(30) NOT NULL,
  `url` varchar(40) NOT NULL,
  `link_aktif` varchar(25) NOT NULL,
  `icon` varchar(25) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `urutan` int(11) NOT NULL,
  `status_menu` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `id_parent`, `title_menu`, `url`, `link_aktif`, `icon`, `keterangan`, `urutan`, `status_menu`) VALUES
(1, 0, 'Dashboard', 'dashboard', 'dashboard', 'fa-tachometer-alt', '', 1, 0),
(2, 26, 'Transaksi', 'denahtrx', '0', 'fa-cogs', '', 1, 0),
(3, 0, 'Statistik Penjualan', 'dashboard_keuangan', 'dashboard_keuangan', 'fa-chart-pie', '', 2, 0),
(4, 26, 'Rekap Pembelian', 'transaksi', '0', 'fa-user', '', 2, 0),
(5, 0, 'History Pembayaran', 'statistik', '0', 'fa-file-medical-alt', '', 4, 0),
(6, 26, 'Status Kavling', 'pembayaran', '0', 'fa-chair', '', 5, 0),
(7, 0, 'Keuangan', 'transaksi_keuangan', '0', 'fa-calculator', '', 5, 0),
(8, 0, 'Master Data', '#', '0', 'fa-database', '', 6, 0),
(9, 70, 'Keuangan', 'transaksi_keuangan', '0', 'fa-users', '', 8, 0),
(10, 70, 'Catatan Hutang', 'hutang', '0', 'fa-credit-card', '', 9, 0),
(11, 70, 'Catatan Piutang', 'piutang', '0', 'fa-ship', 'kapal', 10, 0),
(12, 70, 'Rekening', 'bank', '0', 'fa-share', 'catatan pengeluaran', 11, 0),
(13, 0, 'Laporan', '#', '0', 'fa-file', '', 8, 0),
(14, 70, 'Dashboard Keuangan', 'dashboard_keuangan', '0', 'fa-arrow-left', '', 13, 0),
(15, 8, 'kavling', 'kavling', '0', 'fa-arrow-left', '', 14, 0),
(16, 8, 'Customer', 'customer', '0', 'fa-arrow-left', '', 15, 0),
(17, 8, 'Kategori', 'kategori', '0', 'fa-arrow-left', '', 16, 0),
(18, 32, 'Pengaturan Aplikasi', 'konfigurasi', '0', 'fa-arrow-left', '', 17, 0),
(19, 32, 'Pengaturan Pengguna', 'pengguna', '0', 'fa-arrow-left', '', 18, 0),
(20, 13, 'Lap. Transaksi', 'laporan', '0', 'fa-arrow-left', '', 19, 0),
(21, 13, 'Lap. Customer', 'laporan/customer', '0', 'fa-arrow-left', '', 20, 0),
(22, 32, 'Hak Akses', 'hakakses', '0', 'fa-arrow-left', '', 19, 0),
(23, 26, 'Booking Kavling', 'transaksi/booking', '0', 'fa-user', '', 4, 0),
(24, 13, 'Lap. Penjualan', 'laporan/kategori', '0', 'fa-arrow-left', '', 21, 0),
(25, 0, 'Data Pembayaran', 'statistik', '0', 'fa-cogs', '', 7, 0),
(26, 0, 'Transaksi Penjualan', '#', '0', 'fa-laptop-code', '', 3, 0),
(27, 26, 'Rekap Kredit', 'transaksi_kredit', '0', 'fa-file', '', 3, 0),
(28, 0, 'Pengaturan WA', '#', '0', 'fa-cogs', '', 10, 0),
(29, 28, 'Template Pesan', 'template', '0', 'fa-print', '', 1, 0),
(30, 28, 'Status Pesan', 'statuskirim', '0', 'fa-print', '', 2, 0),
(31, 28, 'Pengaturan Koneksi', 'konfigwa', '0', 'fa-print', '', 3, 0),
(32, 0, 'Pengaturan', '#', '0', 'fa-cogs', '', 9, 0),
(33, 8, 'Marketing', 'marketing', '0', 'fa-arrow-left', '', 14, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `no_pembayaran` varchar(40) NOT NULL,
  `deskripsi` varchar(200) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_kavling` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `pembayaran_ke` int(5) NOT NULL,
  `jumlah_bayar` int(11) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `jenis_pembelian` int(1) NOT NULL,
  `id_bank` int(1) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(75) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `pcs` int(11) NOT NULL,
  `harga_satuan` double(16,2) NOT NULL,
  `sub_total` double(16,2) NOT NULL,
  `file_lampiran` varchar(75) NOT NULL,
  `id_user` int(11) NOT NULL,
  `surname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `template`
--

CREATE TABLE `template` (
  `id_template` int(11) NOT NULL,
  `nama_template` varchar(50) NOT NULL,
  `isi_template` text NOT NULL,
  `jenis_pesan` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `template`
--

INSERT INTO `template` (`id_template`, `nama_template`, `isi_template`, `jenis_pesan`) VALUES
(3, 'Untuk Ultah', 'Hai.. *{nama}*, selamat ya hari ini adalah\r\n\r\nKami segenap _warga Balikpapan_ mengucapkan\r\n\r\n*TTD ADMIN*', 'ultah'),
(4, 'Untuk pesan pengantar kwitansi', '_Assalamualaikum_\r\n\r\nKepada Bapak / Ibu *{nama}*, terima kasih telah melakukan pembayaran kavling *{kode_kavling}*.  \r\n\r\nBerikut kami sertakan bukti pembayaran anda.\r\n\r\n*ttd Admin*', 'kwitansi'),
(5, 'Notif Customer', 'Assalamualaikum\r\n\r\nKepada Bapak/Ibu *{nama}*, kami mengingatkan untuk pembayaran cicilan kavling *{kode_kavling}* telah jatuh tempo. Untuk kebaikan bersama mohon agar segera melunasi tagihan sebesar *{cicilan_per_bulan}*   \r\n\r\nAbaikan pesan ini jika anda telah melakukan pelunasan tagihan.\r\n\r\n*Admin Kavling*', 'notif'),
(6, 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `throttle`
--

CREATE TABLE `throttle` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `transaksi_tanggal` date NOT NULL,
  `transaksi_jenis` enum('Pengeluaran','Pemasukan') NOT NULL,
  `transaksi_kategori` int(11) NOT NULL,
  `transaksi_barang` int(11) NOT NULL,
  `transaksi_nominal` int(11) NOT NULL,
  `transaksi_keterangan` text NOT NULL,
  `transaksi_bank` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_booking`
--

CREATE TABLE `transaksi_booking` (
  `id_pembelian` int(11) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `tgl_expired` date NOT NULL,
  `jenis_pembelian` varchar(25) NOT NULL,
  `id_kavling` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `nominal_booking` int(11) NOT NULL,
  `keterangan_booking` varchar(200) NOT NULL,
  `stt_booking` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_kavling`
--

CREATE TABLE `transaksi_kavling` (
  `id_pembelian` int(11) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `tgl_akad` date NOT NULL,
  `tgl_mulai_cicilan` date NOT NULL,
  `no_transaksi` varchar(35) NOT NULL,
  `jenis_pembelian` varchar(25) NOT NULL,
  `id_kavling` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_marketing` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `jumlah_dp` int(11) NOT NULL,
  `cicilan_per_bulan` int(11) NOT NULL,
  `lama_cicilan` int(11) NOT NULL,
  `booking_rp` int(11) NOT NULL,
  `bayar_cash` int(11) NOT NULL,
  `fee_marketing` int(11) NOT NULL,
  `fee_notaris` int(11) NOT NULL,
  `stt_transaksi` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `status` enum('AKTIF','BLOKIR') NOT NULL DEFAULT 'AKTIF',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `id_join` int(11) DEFAULT NULL,
  `is_trash` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `surname`, `username`, `password`, `email`, `status`, `is_admin`, `id_join`, `is_trash`) VALUES
(1, 'Heru Hidayat', 'master', '$2y$10$LpLDl4dZjUyQKgXSqywF.OX3p0OYQL1IT1wMhIM66EPJGA854pmN.', 'tes@gmail.com', 'AKTIF', 1, 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`barang_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `hak_akses`
--
ALTER TABLE `hak_akses`
  ADD PRIMARY KEY (`id_hak_akses`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `kavling_peta`
--
ALTER TABLE `kavling_peta`
  ADD PRIMARY KEY (`id_kavling`);

--
-- Indexes for table `kirim`
--
ALTER TABLE `kirim`
  ADD PRIMARY KEY (`id_kirim`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `konfigurasi_wa`
--
ALTER TABLE `konfigurasi_wa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketing`
--
ALTER TABLE `marketing`
  ADD PRIMARY KEY (`id_marketing`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `template`
--
ALTER TABLE `template`
  ADD PRIMARY KEY (`id_template`);

--
-- Indexes for table `throttle`
--
ALTER TABLE `throttle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`);

--
-- Indexes for table `transaksi_booking`
--
ALTER TABLE `transaksi_booking`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `transaksi_kavling`
--
ALTER TABLE `transaksi_kavling`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `barang_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hak_akses`
--
ALTER TABLE `hak_akses`
  MODIFY `id_hak_akses` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=255;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kavling_peta`
--
ALTER TABLE `kavling_peta`
  MODIFY `id_kavling` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `kirim`
--
ALTER TABLE `kirim`
  MODIFY `id_kirim` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `konfigurasi_wa`
--
ALTER TABLE `konfigurasi_wa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `marketing`
--
ALTER TABLE `marketing`
  MODIFY `id_marketing` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `template`
--
ALTER TABLE `template`
  MODIFY `id_template` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `throttle`
--
ALTER TABLE `throttle`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_booking`
--
ALTER TABLE `transaksi_booking`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_kavling`
--
ALTER TABLE `transaksi_kavling`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=283;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
