-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 06:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30
-- BY Usrname.nang


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_fpm`
--

-- --------------------------------------------------------
--
-- Table structure for table `tb_absen`
--

CREATE TABLE `tb_absen` (
  `id` varchar(50) NOT NULL,
  `masuk` varchar(15) NOT NULL,
  `keluar` varchar(15) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `Keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_absen`
--

INSERT INTO `tb_absen` (`id`, `masuk`, `keluar`, `date`, `status`, `Keterangan`) VALUES
('1', '', '16:34:24', '2025-12-26', 'B', ''),
('2', '', '16:34:40', '2025-12-26', 'B', ''),
('6', '', '16:38:14', '2025-12-26', 'B', ''),
('5', '', '16:20:43', '2025-12-26', 'B', ''),
('3', '', '16:35:17', '2025-12-26', 'B', ''),
('4', '', '16:27:43', '2025-12-26', 'B', ''),
('9', '', '16:27:57', '2025-12-26', 'B', ''),
('2', '10:56:54', '', '2026-01-05', 'T', ''),
('6', '11:00:35', '', '2026-01-05', 'T', ''),
('3', '06:11:05', '12:32:37', '2025-12-03', 'H', ''),
('9', '06:11:25', '12:32:48', '2025-12-03', 'H', ''),
('1', '06:12:08', '12:31:20', '2025-12-03', 'H', ''),
('6', '06:12:23', '12:31:43', '2025-12-03', 'H', ''),
('3', '06:33:35', '12:34:17', '2025-12-04', 'H', ''),
('9', '06:33:40', '12:41:30', '2025-12-04', 'H', ''),
('1', '06:34:04', '12:34:24', '2025-12-04', 'H', ''),
('6', '06:40:57', '12:41:48', '2025-12-04', 'H', ''),
('1', '06:56:49', '', '2025-12-05', 'H', ''),
('6', '06:44:03', '', '2025-12-05', 'H', ''),
('14', '06:34:51', '', '2025-12-05', 'H', ''),
('11', '06:35:18', '', '2025-12-05', 'H', ''),
('3', '06:35:25', '', '2025-12-05', 'H', ''),
('9', '06:35:35', '', '2025-12-05', 'H', ''),
('14', '06:38:25', '12:40:10', '2025-12-01', 'H', ''),
('12', '06:38:34', '12:40:15', '2025-12-01', 'H', ''),
('3', '06:40:45', '12:43:19', '2025-12-01', 'H', ''),
('9', '06:45:53', '12:43:36', '2025-12-01', 'H', ''),
('14', '06:44:03', '12:36:01', '2025-12-02', 'H', ''),
('12', '06:34:11', '12:36:07', '2025-12-02', 'H', ''),
('3', '06:29:19', '12:36:18', '2025-12-02', 'H', ''),
('9', '06:29:29', '12:37:26', '2025-12-02', 'H', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_id`
--

CREATE TABLE `tb_id` (
  `id` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nisn` int(50) NOT NULL,
  `telegram_id` varchar(50) NOT NULL,
  `jari` varchar(100) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `gender` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_id`
--

INSERT INTO `tb_id` (`id`, `nama`, `nisn`, `telegram_id`, `jari`, `kelas`, `gender`) VALUES
('1', 'Achmad Athaillah Yansi', 1831, '', '1', '6', 'laki-laki'),
('10', 'Naila Avika Mu\'azara', 1853, '', '2', '6', 'perempuan'),
('11', 'Aryanta Danadyaksa', 2039, '', '1', '5', 'laki-laki'),
('12', 'Aryanta Danadyaksa', 2039, '', '2', '5', 'laki-laki'),
('13', 'Aswi Dewi Khomariyah', 1868, '', '1', '5', 'perempuan'),
('14', 'Aswi Dewi Khomariyah', 1868, '', '2', '5', 'perempuan'),
('2', 'Achmad Athaillah Yansi', 1831, '', '2', '6', 'laki-laki'),
('3', 'Alifa Ramadani', 1838, '', '1', '6', 'perempuan'),
('4', 'Alifa Ramadani', 1838, '', '2', '6', 'perempuan'),
('5', 'Ardiansyah Rizky Perwira Ibrahim', 1840, '', '1', '6', 'laki-laki'),
('6', 'Ardiansyah Rizky Perwira Ibrahim', 1840, 'ya', '2', '6', 'laki-laki'),
('7', 'Aulia Widya Safira', 1841, '', '1', '6', 'perempuan'),
('8', 'Aulia Widya Safira', 1841, '', '2', '6', 'perempuan'),
('9', 'Naila Avika Mu\'azara', 1853, '', '1', '6', 'perempuan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `no` int(10) NOT NULL,
  `username` varchar(22) NOT NULL,
  `password` varchar(22) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`no`, `username`, `password`, `level`) VALUES
(2, 'Walas6', 'Walas6', 0),
(6, 'admin', 'admin', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `masuk_mulai` time NOT NULL,
  `masuk_akhir` time NOT NULL,
  `keluar_mulai` time NOT NULL,
  `keluar_akhir` time NOT NULL,
  `libur1` varchar(10) NOT NULL,
  `libur2` varchar(10) NOT NULL,
  `timezone` varchar(22) NOT NULL,
  `bot_token` varchar(50) NOT NULL,
  `ip` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`masuk_mulai`, `masuk_akhir`, `keluar_mulai`, `keluar_akhir`, `libur1`, `libur2`, `timezone`, `bot_token`, `ip`) VALUES
('05:00:00', '07:15:00', '12:30:00', '13:00:00', 'Minggu', '-', 'Asia/Jakarta', 'no', ' 192.168.1.73');

-- --------------------------------------------------------

--
-- Table structure for table `tb_state`
--

CREATE TABLE `tb_state` (
  `status` int(1) NOT NULL,
  `pesan_kontroler` varchar(50) NOT NULL,
  `id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_state`
--

INSERT INTO `tb_state` (`status`, `pesan_kontroler`, `id`) VALUES
(0, 'Sukses', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_id`
--
ALTER TABLE `tb_id`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `no` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
