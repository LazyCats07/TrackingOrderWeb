-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql_db
-- Generation Time: Aug 08, 2024 at 07:10 AM
-- Server version: 9.0.1
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cust`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_order`
--

CREATE TABLE `data_order` (
  `no` int NOT NULL,
  `id_cust` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_cust` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `ktp` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `kartu_keluarga` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `jenis_pinjaman` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `status_order` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `data_order`
--

INSERT INTO `data_order` (`no`, `id_cust`, `nama_cust`, `gender`, `alamat`, `ktp`, `kartu_keluarga`, `jenis_pinjaman`, `status_order`, `created`) VALUES
(1, '0001-1250', 'Ahmad Fauzan', 'Laki-Laki', 'Jl. Kenanga No. 5, Kel. Kebayoran Lama, Kec. Kebayoran Lama, Jakarta Selatan, 12240	(Pilih ', '0001-1250.jpeg', '0001-1250.jpeg', 'NMC', 'New Order', '2024-07-15 08:15:19'),
(2, '0001-1251', 'Fitri Handayani	', 'Perempuan', 'Jl. Melati No. 7, Kel. Palmerah, Kec. Palmerah, Jakarta Barat, 11480', '0001-1251.jpeg', '0001-1251.jpeg', 'Motor Bekas', 'Kontrak', '2024-07-18 08:28:43'),
(3, '0001-1252', 'Dedi Setiawan', 'Laki-Laki', 'Jl. Anggrek No. 3, Kel. Setiabudi, Kec. Setiabudi, Jakarta Selatan, 12910', '0001-1252.jpg', '0001-1252.jpg', 'Multiproduk', 'PO Pending', '2024-07-15 08:16:40'),
(4, '0001-1253', 'Lestari Putri', 'Perempuan', 'Jl. Mawar No. 12, Kel. Tebet, Kec. Tebet, Jakarta Selatan, 12820', '0001-1253.jpeg', '0001-1253.jpeg', 'Microfinance', 'Kontrak', '2024-07-15 08:17:10'),
(5, '0001-1254', 'Budi Raharjo', 'Laki-Laki', 'Jl. Dahlia No. 15, Kel. Cipete, Kec. Cipete, Jakarta Selatan, 12410', '0001-1254.jpg', '0001-1254.jpg', 'Ibadah Haji', 'Dishbursement', '2024-07-15 08:17:43'),
(6, '0001-1256', 'Rian Pratama', 'Laki-Laki', 'Jl. Tulip No. 2, Kel. Pulo Gadung, Kec. Pulo Gadung, Jakarta Timur, 13260', '0001-1256.jpeg', '0001-1256.jpeg', 'Ibadah Umroh', 'Accepted', '2024-07-18 08:29:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_order`
--
ALTER TABLE `data_order`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_order`
--
ALTER TABLE `data_order`
  MODIFY `no` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
