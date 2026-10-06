-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20260928.09b821d72b
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 06, 2026 at 02:56 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--
CREATE TABLE `anggota` (
  `no_ktp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_anggota` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` enum('L','P') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` char(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'MD5',
  `hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tautan_foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`no_ktp`, `nama_anggota`, `jenis_kelamin`, `email`, `password`, `hp`, `tautan_foto`) VALUES
('3201010101010001', 'Budi Santoso', 'L', 'budi@sekolah.test', '482c811da5d5b4bc6d497ffa98491e38', '081200000001', NULL),
('3201010101010002', 'Siti Aminah', 'P', 'siti@sekolah.test', '482c811da5d5b4bc6d497ffa98491e38', '081200000002', 'profil_picture/3201010101010002.png'),
('3201010101010003', 'Andi Pratama', 'L', 'andi@sekolah.test', '482c811da5d5b4bc6d497ffa98491e38', '081200000003', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--
CREATE TABLE `guru` (
  `no_ktp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spesialisasi` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`no_ktp`, `nik`, `spesialisasi`) VALUES
('3201010101010002', '198501012010011001', 'Matematika');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--
CREATE TABLE `siswa` (
  `no_ktp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nim` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('A','TA') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`no_ktp`, `nim`, `kelas`, `status`) VALUES
('3201010101010001', '2024001', 'XII-IPA-1', 'A'),
('3201010101010003', '2024002', 'XI-IPS-2', 'A');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`no_ktp`),
  ADD UNIQUE KEY `uq_anggota_email` (`email`),
  ADD UNIQUE KEY `uq_anggota_hp` (`hp`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`no_ktp`),
  ADD UNIQUE KEY `uq_guru_nik` (`nik`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`no_ktp`),
  ADD UNIQUE KEY `uq_siswa_nim` (`nim`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `fk_guru_anggota` FOREIGN KEY (`no_ktp`) REFERENCES `anggota` (`no_ktp`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `fk_siswa_anggota` FOREIGN KEY (`no_ktp`) REFERENCES `anggota` (`no_ktp`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
