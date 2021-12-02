-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2021 at 01:33 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_c1`
--

-- --------------------------------------------------------

--
-- Table structure for table `faskes`
--

CREATE TABLE `faskes` (
  `idFaskes` int(11) NOT NULL,
  `namaFaskes` varchar(25) NOT NULL,
  `alamatFaskes` varchar(50) NOT NULL,
  `kabupaten` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faskes`
--

INSERT INTO `faskes` (`idFaskes`, `namaFaskes`, `alamatFaskes`, `kabupaten`) VALUES
(2, 'Puskesmas Taman Sari', 'Jl.A.Yani', 'Kota Pangkalpinang'),
(12, 'RS Panti Rapih', 'Jalan Cik Di TIro, Terban', 'Kota Yogyakarta');

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `idKabupaten` int(11) NOT NULL,
  `namaKabupaten` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`idKabupaten`, `namaKabupaten`) VALUES
(1, 'Kota Yogyakarta'),
(5, 'Kab Sleman');

-- --------------------------------------------------------

--
-- Table structure for table `nakes`
--

CREATE TABLE `nakes` (
  `idNakes` varchar(10) NOT NULL,
  `namaNakes` varchar(25) NOT NULL,
  `jabatan` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nakes`
--

INSERT INTO `nakes` (`idNakes`, `namaNakes`, `jabatan`) VALUES
('AA0001XY', 'Sinta', 'Perawat'),
('AA0002XY', 'Kris', 'Perawat'),
('AA1112ZZ', 'Untung', 'Dokter');

-- --------------------------------------------------------

--
-- Table structure for table `resipien`
--

CREATE TABLE `resipien` (
  `nik` varchar(16) NOT NULL,
  `namaResipien` varchar(25) NOT NULL,
  `nomerHPResipien` varchar(15) NOT NULL,
  `tglLahir` date NOT NULL,
  `alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `resipien`
--

INSERT INTO `resipien` (`nik`, `namaResipien`, `nomerHPResipien`, `tglLahir`, `alamat`) VALUES
('197101040102', 'William Suryadinata', '081369632888', '2001-05-07', 'Solihin GP Jakarta'),
('333441234', 'Uncle Mutu', '08123456111', '2002-12-31', 'Jalan Salmon No 46'),
('340407110502', 'Untung Mangkunegara', '085741130644', '2002-05-11', 'Laksda Adisucipto 55282');

-- --------------------------------------------------------

--
-- Table structure for table `stokvaksin`
--

CREATE TABLE `stokvaksin` (
  `idStok` int(11) NOT NULL,
  `idKabupaten` int(11) NOT NULL,
  `idGTIN` int(20) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stokvaksin`
--

INSERT INTO `stokvaksin` (`idStok`, `idKabupaten`, `idGTIN`, `stok`) VALUES
(5, 1, 2, 98),
(6, 5, 3, 98);

-- --------------------------------------------------------

--
-- Table structure for table `vaksin`
--

CREATE TABLE `vaksin` (
  `idGTIN` int(20) NOT NULL,
  `namaVaksin` varchar(20) NOT NULL,
  `nomorBatch` varchar(15) NOT NULL,
  `tglExpire` date NOT NULL,
  `serialNo` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaksin`
--

INSERT INTO `vaksin` (`idGTIN`, `namaVaksin`, `nomorBatch`, `tglExpire`, `serialNo`) VALUES
(1, 'AstraZeneca', 'CTMAV548', '2022-06-22', '1101'),
(2, 'Sinovac', '24004021', '2022-06-12', '2278'),
(3, 'Moderna', 'FSFF343', '2022-06-07', '0001');

-- --------------------------------------------------------

--
-- Table structure for table `vaksinasi`
--

CREATE TABLE `vaksinasi` (
  `noTiket` varchar(20) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `idGTIN` int(20) NOT NULL,
  `dosis` enum('1','2','3') NOT NULL,
  `tglPemberian` date NOT NULL,
  `tglDosisLanjutan` date NOT NULL,
  `idFaskes` int(11) NOT NULL,
  `idNakes` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vaksinasi`
--

INSERT INTO `vaksinasi` (`noTiket`, `nik`, `idGTIN`, `dosis`, `tglPemberian`, `tglDosisLanjutan`, `idFaskes`, `idNakes`) VALUES
('2', '197101040102', 2, '2', '2014-12-28', '2021-11-30', 2, 'AA0002XY'),
('T-123', '333441234', 3, '1', '2021-12-01', '2022-01-31', 12, 'AA1112ZZ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `faskes`
--
ALTER TABLE `faskes`
  ADD PRIMARY KEY (`idFaskes`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`idKabupaten`);

--
-- Indexes for table `nakes`
--
ALTER TABLE `nakes`
  ADD PRIMARY KEY (`idNakes`);

--
-- Indexes for table `resipien`
--
ALTER TABLE `resipien`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `stokvaksin`
--
ALTER TABLE `stokvaksin`
  ADD PRIMARY KEY (`idStok`),
  ADD KEY `fkidKabupaten` (`idKabupaten`),
  ADD KEY `fkidGTIN2` (`idGTIN`);

--
-- Indexes for table `vaksin`
--
ALTER TABLE `vaksin`
  ADD PRIMARY KEY (`idGTIN`);

--
-- Indexes for table `vaksinasi`
--
ALTER TABLE `vaksinasi`
  ADD PRIMARY KEY (`noTiket`,`nik`,`idGTIN`),
  ADD KEY `fkidGTIN` (`idGTIN`),
  ADD KEY `fkidFaskes` (`idFaskes`),
  ADD KEY `fkidNakes` (`idNakes`),
  ADD KEY `fknik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faskes`
--
ALTER TABLE `faskes`
  MODIFY `idFaskes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kabupaten`
--
ALTER TABLE `kabupaten`
  MODIFY `idKabupaten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stokvaksin`
--
ALTER TABLE `stokvaksin`
  MODIFY `idStok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stokvaksin`
--
ALTER TABLE `stokvaksin`
  ADD CONSTRAINT `fkidGTIN2` FOREIGN KEY (`idGTIN`) REFERENCES `vaksin` (`idGTIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkidKabupaten` FOREIGN KEY (`idKabupaten`) REFERENCES `kabupaten` (`idKabupaten`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaksinasi`
--
ALTER TABLE `vaksinasi`
  ADD CONSTRAINT `fkidFaskes` FOREIGN KEY (`idFaskes`) REFERENCES `faskes` (`idFaskes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkidGTIN` FOREIGN KEY (`idGTIN`) REFERENCES `vaksin` (`idGTIN`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fkidNakes` FOREIGN KEY (`idNakes`) REFERENCES `nakes` (`idNakes`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fknik` FOREIGN KEY (`nik`) REFERENCES `resipien` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
