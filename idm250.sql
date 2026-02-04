-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2026 at 04:34 PM
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
-- Table structure for table `inventory_item_info`
--

CREATE TABLE `inventory_item_info` (
  `inventory_id` int(100) NOT NULL,
  `unit_numb` int(15) DEFAULT NULL,
  `ficha` int(11) DEFAULT NULL,
  `description_1` text,
  `description_2` text,
  `quantity` int(15) NOT NULL,
  `quantity_unit` varchar(10) NOT NULL,
  `footage_quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_item_info`
--

INSERT INTO `inventory_item_info` (`inventory_id`, `unit_numb`, `ficha`, `description_1`, `description_2`, `quantity`, `quantity_unit`, `footage_quantity`) VALUES
(1, 78114995, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(2, 78114996, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(3, 78114997, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(4, 78114998, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(5, 78114999, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(6, 78115000, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(7, 78115001, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(8, 78115002, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(9, 78115003, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(10, 78115004, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(11, 78115005, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(12, 78115006, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(13, 78115007, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(14, 78115008, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(15, 78115009, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28),
(16, 78115010, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(17, 78115011, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(18, 78115012, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(19, 78115013, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(20, 78115014, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(21, 78115015, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(22, 78115016, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(23, 78115017, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(24, 78115018, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(25, 78115019, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(26, 78115020, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(27, 78115021, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(28, 78115022, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(29, 78115023, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34),
(30, 78115024, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(31, 78115025, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(32, 78115026, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(33, 78115027, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(34, 78115028, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(35, 78115029, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(36, 78115030, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(37, 78115031, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(38, 78115032, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(39, 78115033, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(40, 78115034, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(41, 78115035, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(42, 78115036, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(43, 78115037, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(44, 78115038, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100),
(45, 78115039, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34),
(46, 78115040, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34),
(47, 78115041, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34),
(48, 78115042, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34),
(49, 78115043, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_ship_info`
--

CREATE TABLE `inventory_ship_info` (
  `shipment_id` int(100) NOT NULL,
  `unit_numb` int(15) NOT NULL,
  `request_date` date NOT NULL,
  `ship_date` date NOT NULL,
  `sold_numb` int(15) NOT NULL,
  `sold_name` varchar(20) NOT NULL,
  `ship_numb` int(15) NOT NULL,
  `ship_name` varchar(20) NOT NULL,
  `carrier_numb` varchar(10) NOT NULL,
  `carrier_name` varchar(15) NOT NULL,
  `car_initial` varchar(15) NOT NULL,
  `car_numb` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_ship_info`
--

INSERT INTO `inventory_ship_info` (`shipment_id`, `unit_numb`, `request_date`, `ship_date`, `sold_numb`, `sold_name`, `ship_numb`, `ship_name`, `carrier_numb`, `carrier_name`, `car_initial`, `car_numb`) VALUES
(1, 78114995, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(2, 78114996, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(3, 78114997, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(4, 78114998, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(5, 78114999, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(6, 78115000, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(7, 78115001, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(8, 78115002, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(9, 78115003, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(10, 78115004, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(11, 78115005, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(12, 78115006, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(13, 78115007, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(14, 78115008, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(15, 78115009, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(16, 78115010, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(17, 78115011, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(18, 78115012, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(19, 78115013, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(20, 78115014, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(21, 78115015, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(22, 78115016, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(23, 78115017, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(24, 78115018, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(25, 78115019, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(26, 78115020, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(27, 78115021, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(28, 78115022, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(29, 78115023, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(30, 78115024, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(31, 78115025, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(32, 78115026, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(33, 78115027, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(34, 78115028, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(35, 78115029, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(36, 78115030, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(37, 78115031, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(38, 78115032, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(39, 78115033, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(40, 78115034, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(41, 78115035, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(42, 78115036, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(43, 78115037, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(44, 78115038, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(45, 78115039, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(46, 78115040, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(47, 78115041, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(48, 78115042, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477),
(49, 78115043, '2025-11-24', '2026-01-27', 768448, 'Shay INC ', 768448, 'Shay INC ', 'B6H', '100045', 'TBOX', 634477);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(2) NOT NULL,
  `ficha` int(3) DEFAULT NULL,
  `sku` varchar(12) DEFAULT NULL,
  `description` text,
  `rate` decimal(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `ficha`, `sku`, `description`, `rate`) VALUES
(1, 452, '1720823-0567', 'BIRCH YEL FAS 6/4 RGH KD 10FT', '18.22'),
(2, 163, '1720824-0891', 'HEMLOCK DIM 2X8X14FT #2BTR STD', '14.85'),
(3, 589, '1720825-0234', 'ASH WHT FAS 4/4 RGH KD 9-11FT', '15.92'),
(4, 734, '1720826-0412', 'MDF ULTRALT C1-- 2440X1220X18MM', '13.44'),
(5, 298, '1720827-0178', 'CHERRY BLK SEL 5/4 RGH KD 8FT', '21.35'),
(6, 641, '1720828-0923', 'REDWOOD CLR VG 2X4X10FT KD HRT', '19.78'),
(7, 812, '1720829-0056', 'PARTICLEBOARD IND 3/4X49X97', '11.56'),
(8, 445, '1720830-0789', 'ALDER RED SEL 4/4 RGH KD 8-10FT', '17.64'),
(9, 127, '1720831-0345', 'WHITE OAK QS 4/4 RGH KD 10FT', '22.40'),
(10, 568, '1720832-0612', 'SOUTHERN PINE PT 4X4X12FT GC', '13.28'),
(11, 724, '1720813-0132', 'MDF ST LX C2-- 2465X1245X05.7MM P/EF/132', '15.16');

-- --------------------------------------------------------

--
-- Table structure for table `products_dimensions`
--

CREATE TABLE `products_dimensions` (
  `id` int(2) NOT NULL,
  `length_inches` int(3) DEFAULT NULL,
  `width_inches` int(2) DEFAULT NULL,
  `height_inches` decimal(3,1) DEFAULT NULL,
  `weight_lbs` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_dimensions`
--

INSERT INTO `products_dimensions` (`id`, `length_inches`, `width_inches`, `height_inches`, `weight_lbs`) VALUES
(1, 120, 44, '34.0', '3120.45'),
(2, 168, 40, '28.5', '2975.30'),
(3, 132, 46, '40.0', '3540.60'),
(4, 96, 48, '52.0', '4250.75'),
(5, 96, 42, '26.0', '1980.20'),
(6, 120, 38, '32.0', '2430.85'),
(7, 97, 49, '45.0', '3890.40'),
(8, 120, 40, '30.0', '2180.55'),
(9, 120, 48, '38.0', '2890.70'),
(10, 144, 44, '48.0', '5120.35');

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(2) NOT NULL,
  `uom_primary` varchar(6) DEFAULT NULL,
  `piece_count` int(3) DEFAULT NULL,
  `assembly` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `uom_primary`, `piece_count`, `assembly`) VALUES
(1, 'PALLET', 95, 'FALSE'),
(2, 'BUNDLE', 160, 'FALSE'),
(3, 'PALLET', 110, 'FALSE'),
(4, 'BUNDLE', 85, 'FALSE'),
(5, 'PALLET', 70, 'FALSE'),
(6, 'BUNDLE', 225, 'FALSE'),
(7, 'PALLET', 60, 'FALSE'),
(8, 'BUNDLE', 140, 'FALSE'),
(9, 'PALLET', 65, 'FALSE'),
(10, 'BUNDLE', 130, 'FALSE');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_item_info`
--
ALTER TABLE `inventory_item_info`
  ADD PRIMARY KEY (`inventory_id`);

--
-- Indexes for table `inventory_ship_info`
--
ALTER TABLE `inventory_ship_info`
  ADD PRIMARY KEY (`shipment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_dimensions`
--
ALTER TABLE `products_dimensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_types`
--
ALTER TABLE `products_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_item_info`
--
ALTER TABLE `inventory_item_info`
  MODIFY `inventory_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `inventory_ship_info`
--
ALTER TABLE `inventory_ship_info`
  MODIFY `shipment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products_dimensions`
--
ALTER TABLE `products_dimensions`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
