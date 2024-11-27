-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 03:46 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tabungan_siswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(50) NOT NULL,
  `jurusan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan`) VALUES
(16, '10', 'PPLG1'),
(17, '10 ', 'PPLG2'),
(18, '10', 'DKV1'),
(20, '10', 'DKV2'),
(21, '11', 'PPLG1'),
(22, '11', 'PPLG2'),
(23, '11', 'DKV1'),
(24, '11', 'DKV2'),
(26, '12', 'RPL1'),
(27, '12', 'RPL2'),
(28, '12', 'MM1'),
(29, '12', 'MM2');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) DEFAULT NULL,
  `nisn` varchar(25) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `nama`, `kelas`, `nisn`, `jenis_kelamin`) VALUES
(1, 'Fivel Mar\'ah', '12', '66543216', 'P'),
(2, 'Almalia Safirah', '12', '6543215', 'P'),
(3, 'Muhammad Mirza', '10', '6543214', 'L'),
(4, 'Fani Agryand Veve', '10', '6543213', 'P'),
(5, 'Rahmat Nggaing', '10 ', '66543215', 'L');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `jenis_transaksi` enum('setor','tarik') DEFAULT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP,
  `no_referensi` varchar(50) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `jenis_transaksi`, `saldo`, `tanggal`, `no_referensi`, `id_siswa`) VALUES
(46, 'setor', '200000.00', '2024-10-25 07:15:48', 'FM-SET001', 1),
(47, 'tarik', '0.00', '2024-10-25 07:16:31', 'AS-TAR002', 2),
(48, 'setor', '150000.00', '2024-10-25 07:20:26', 'MM-SET003', 3),
(49, 'tarik', '20000.00', '2024-10-25 07:20:39', 'MM-TAR004', 3),
(50, 'tarik', '20000.00', '2024-10-25 14:58:28', 'FM-TAR005', 1),
(51, 'setor', '150000.00', '2024-10-25 14:58:57', 'AS-SET006', 2),
(52, 'setor', '20000.00', '2024-10-25 15:22:09', 'AS-SET007', 2),
(53, 'tarik', '20000.00', '2024-10-25 15:22:22', 'AS-TAR008', 2),
(54, 'setor', '120000.00', '2024-10-29 07:16:39', 'FA-SET001', 4),
(55, 'tarik', '10000.00', '2024-10-29 07:16:52', 'FA-TAR002', 4),
(56, 'setor', '800000.00', '2024-11-06 14:42:02', 'RN-SET001', 5),
(57, 'tarik', '100000.00', '2024-11-06 14:42:18', 'FM-TAR002', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','siswa') NOT NULL,
  `id_siswa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `id_siswa`) VALUES
(23, 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', NULL),
(32, 'fivel', 'c81e728d9d4c2f636f067f89cc14862c', 'siswa', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_transaksi_siswa` (`id_siswa`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_user_siswa` (`id_siswa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_transaksi_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
