-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 04:09 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_lsp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kontak` varchar(225) DEFAULT NULL,
  `email` varchar(225) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `kontak`, `email`, `password`) VALUES
(2, 'Bagus Setyo Hadi', '085255804015', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jenis_barang` varchar(255) NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `lokasi_gudang` varchar(255) NOT NULL,
  `barcode` int(20) NOT NULL,
  `harga` bigint(20) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `storage_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `nama_barang`, `jenis_barang`, `kuantitas`, `lokasi_gudang`, `barcode`, `harga`, `vendor_id`, `storage_id`) VALUES
(1, 'Koenigsegg Regera', 'Kendaraan', 0, 'PT. PACE SUKOLILO', 394810213, 6506000, 3, 1),
(3, 'Rokok Surya', 'Rokok', 12, 'PT. MANDALIKA RACING', 8489213, 50000, 3, 3),
(6, 'Meja bundar', 'Furnitur', 5, 'PT. PACE SUKOLILO', 465912341, 30000, 4, 1),
(8, 'PC Gaming Full RGB', 'Electronic', 10, 'PT. MANDALIKA RACING', 783910234, 10000000, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `storage`
--

CREATE TABLE `storage` (
  `id` int(11) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `storage`
--

INSERT INTO `storage` (`id`, `nama_gudang`, `lokasi`) VALUES
(1, 'PT. PACE SUKOLILO', 'SUKOLILO'),
(3, 'PT. MANDALIKA RACING', 'mandalika');

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `kontak` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `invoice` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `nama`, `kontak`, `nama_barang`, `invoice`) VALUES
(3, 'Bagus Setyo Hadi', '085255804015', 'Rokok Surya', 'LV9273X'),
(4, 'Bilal Sanayu Majid', '082610384168', 'Meja bundar', 'R782XA1'),
(5, 'Bagus Setyo Hadi', '085255804015', 'Koenigsegg Regera', 'QZ9234M12'),
(6, 'Bilal Sanayu Majid', '08673628103', 'PC Gaming Full RGB', 'T94221XMQ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `fk_vendor` (`vendor_id`),
  ADD KEY `fk_storage` (`storage_id`);

--
-- Indexes for table `storage`
--
ALTER TABLE `storage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `storage`
--
ALTER TABLE `storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `fk_storage` FOREIGN KEY (`storage_id`) REFERENCES `storage` (`id`),
  ADD CONSTRAINT `fk_vendor` FOREIGN KEY (`vendor_id`) REFERENCES `vendor` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
