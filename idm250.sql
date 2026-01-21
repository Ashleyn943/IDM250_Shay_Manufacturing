-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 21, 2026 at 04:22 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `idm250`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `id` int(10) NOT NULL,
  `user` int(11) NOT NULL,
  `pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(2) NOT NULL,
  `ficha` int(3) DEFAULT NULL,
  `sku` varchar(12) DEFAULT NULL,
  `description` varchar(31) DEFAULT NULL,
  `rate` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `ficha`, `sku`, `description`, `rate`) VALUES
(1, 452, '1720823-0567', 'BIRCH YEL FAS 6/4 RGH KD 10FT', '18.22'),
(2, 163, '1720824-0891', 'HEMLOCK DIM 2X8X14FT #2BTR STD', '14.85'),
(3, 589, '1720825-0234', 'ASH WHT FAS 4/4 RGH KD 9-11FT', '15.92'),
(4, 734, '1720826-0412', 'MDF ULTRALT C1-- 2440X1220X18MM', '13.44'),
(5, 298, '1720827-0178', 'CHERRY BLK SEL 5/4 RGH KD 8FT', '21.35'),
(6, 641, '1720828-0923', 'REDWOOD CLR VG 2X4X10FT KD HRT', '19.78'),
(7, 812, '1720829-0056', 'PARTICLEBOARD IND 3/4X49X97', '11.56'),
(8, 445, '1720830-0789', 'ALDER RED SEL 4/4 RGH KD 8-10FT', '17.64'),
(9, 127, '1720831-0345', 'WHITE OAK QS 4/4 RGH KD 10FT', '22.40'),
(10, 568, '1720832-0612', 'SOUTHERN PINE PT 4X4X12FT GC', '13.28');

-- --------------------------------------------------------

--
-- Table structure for table `products_dimensions`
--

CREATE TABLE `products_dimensions` (
  `ID` int(2) NOT NULL,
  `ficha` int(3) DEFAULT NULL,
  `sku` varchar(12) DEFAULT NULL,
  `length_inches` int(3) DEFAULT NULL,
  `width_inches` int(2) DEFAULT NULL,
  `height_inches` decimal(3,1) DEFAULT NULL,
  `weight_lbs` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_dimensions`
--

INSERT INTO `products_dimensions` (`ID`, `ficha`, `sku`, `length_inches`, `width_inches`, `height_inches`, `weight_lbs`) VALUES
(1, 452, '1720823-0567', 120, 44, '34.0', '3120.45'),
(2, 163, '1720824-0891', 168, 40, '28.5', '2975.30'),
(3, 589, '1720825-0234', 132, 46, '40.0', '3540.60'),
(4, 734, '1720826-0412', 96, 48, '52.0', '4250.75'),
(5, 298, '1720827-0178', 96, 42, '26.0', '1980.20'),
(6, 641, '1720828-0923', 120, 38, '32.0', '2430.85'),
(7, 812, '1720829-0056', 97, 49, '45.0', '3890.40'),
(8, 445, '1720830-0789', 120, 40, '30.0', '2180.55'),
(9, 127, '1720831-0345', 120, 48, '38.0', '2890.70'),
(10, 568, '1720832-0612', 144, 44, '48.0', '5120.35');

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `ID` int(2) NOT NULL,
  `ficha` int(3) DEFAULT NULL,
  `sku` varchar(12) DEFAULT NULL,
  `uom_primary` varchar(6) DEFAULT NULL,
  `piece_count` int(3) DEFAULT NULL,
  `assembly` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`ID`, `ficha`, `sku`, `uom_primary`, `piece_count`, `assembly`) VALUES
(1, 452, '1720823-0567', 'PALLET', 95, 'FALSE'),
(2, 163, '1720824-0891', 'BUNDLE', 160, 'FALSE'),
(3, 589, '1720825-0234', 'PALLET', 110, 'FALSE'),
(4, 734, '1720826-0412', 'BUNDLE', 85, 'FALSE'),
(5, 298, '1720827-0178', 'PALLET', 70, 'FALSE'),
(6, 641, '1720828-0923', 'BUNDLE', 225, 'FALSE'),
(7, 812, '1720829-0056', 'PALLET', 60, 'FALSE'),
(8, 445, '1720830-0789', 'BUNDLE', 140, 'FALSE'),
(9, 127, '1720831-0345', 'PALLET', 65, 'FALSE'),
(10, 568, '1720832-0612', 'BUNDLE', 130, 'FALSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `products_dimensions`
--
ALTER TABLE `products_dimensions`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `products_types`
--
ALTER TABLE `products_types`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products_dimensions`
--
ALTER TABLE `products_dimensions`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `ID` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
