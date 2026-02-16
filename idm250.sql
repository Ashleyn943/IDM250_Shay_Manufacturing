-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 16, 2026 at 07:46 PM
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
  `sku` varchar(100) DEFAULT NULL,
  `unit_numb` int(15) DEFAULT NULL,
  `ficha` int(11) DEFAULT NULL,
  `description1` text,
  `description2` text,
  `quantity` int(15) NOT NULL,
  `quantity_unit` varchar(10) NOT NULL,
  `footage_quantity` float NOT NULL,
  `location` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inventory_item_info`
--

INSERT INTO `inventory_item_info` (`inventory_id`, `sku`, `unit_numb`, `ficha`, `description1`, `description2`, `quantity`, `quantity_unit`, `footage_quantity`, `location`) VALUES
(1, '1720818-0167', 78114995, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(2, '1720818-0167', 78114996, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(3, '1720818-0167', 78114997, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(4, '1720818-0167', 78114998, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(5, '1720818-0167', 78114999, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(6, '1720818-0167', 78115000, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(7, '1720818-0167', 78115001, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(8, '1720818-0167', 78115002, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(9, '1720818-0167', 78115003, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(10, '1720818-0167', 78115004, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(11, '1720818-0167', 78115005, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(12, '1720818-0167', 78115006, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(13, '1720818-0167', 78115007, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(14, '1720818-0167', 78115008, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(15, '1720818-0167', 78115009, 223, 'MAPLE HARD FAS 5/4 RGH KD 10FT', 'Medex FSCMC 120', 120, 'PC', 1320.28, 'internal'),
(16, '1720823-0011', 78115010, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(17, '1720823-0011', 78115011, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(18, '1720823-0011', 78115012, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(19, '1720823-0011', 78115013, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(20, '1720823-0011', 78115014, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(21, '1720823-0011', 78115015, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(22, '1720823-0011', 78115016, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(23, '1720823-0011', 78115017, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(24, '1720823-0011', 78115018, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(25, '1720823-0011', 78115019, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(26, '1720823-0011', 78115020, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(27, '1720823-0011', 78115021, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(28, '1720823-0011', 78115022, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(29, '1720823-0011', 78115023, 547, 'PINE #2 2X4X10FT KD', 'Medex HB 220', 220, 'PC', 1420.34, 'internal'),
(30, '1720830-0108', 78115024, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(31, '1720830-0108', 78115025, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(32, '1720830-0108', 78115026, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(33, '1720830-0108', 78115027, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(34, '1720830-0108', 78115028, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(35, '1720830-0108', 78115029, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(36, '1720830-0108', 78115030, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(37, '1720830-0108', 78115031, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(38, '1720830-0108', 78115032, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(39, '1720830-0108', 78115033, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(40, '1720830-0108', 78115034, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(41, '1720830-0108', 78115035, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(42, '1720830-0108', 78115036, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(43, '1720830-0108', 78115037, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(44, '1720830-0108', 78115038, 886, 'CEDAR WRC 1X8X10FT CLR S4S', 'Medex PLY S4S', 280, 'PC', 2100, 'internal'),
(45, '1720822-0223', 78115039, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34, 'internal'),
(46, '1720822-0223', 78115040, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34, 'internal'),
(47, '1720822-0223', 78115041, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34, 'internal'),
(48, '1720822-0223', 78115042, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34, 'internal'),
(49, '1720822-0223', 78115043, 901, 'DOUGLAS FIR CVG 2X10X16FT #1', NULL, 100, 'PC', 3298.34, 'internal');

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
-- Table structure for table `mpl_shipping_list`
--

CREATE TABLE `mpl_shipping_list` (
  `id` int(100) NOT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `unit_numb` int(100) DEFAULT NULL,
  `ficha` int(10) DEFAULT NULL,
  `description1` text,
  `description2` text,
  `quantity` int(100) DEFAULT NULL,
  `quantity_unit` varchar(100) DEFAULT NULL,
  `footage_quantity` float DEFAULT NULL,
  `reference_numb` int(100) DEFAULT NULL,
  `ship_date` date DEFAULT NULL,
  `trailer_name` text,
  `status` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(11, 724, '1720813-0132', 'MDF ST LX C2-- 2465X1245X05.7MM P/EF/132', '15.16'),
(12, 987, '1720814-0248', 'PINE CLR VG 2X4X8FT KD SELECT', '16.18'),
(13, 337, '1720815-0156', 'OAK RED FAS 4/4 RGH KD 8-12FT', '15.16'),
(14, 778, '1720816-0089', 'SPRUCE DIMENSION 2X6X12FT #2BTR', '14.50'),
(15, 187, '1720817-0234', 'CEDAR WRC CVG 1X6X8FT CLR S4S', '20.06'),
(16, 223, '1720818-0167', 'MAPLE HARD FAS 5/4 RGH KD 10FT', '16.18'),
(17, 876, '1720819-0312', 'PLYWOOD BALTIC BIRCH 3/4X4X8', '17.02'),
(18, 233, '1720820-0098', 'POPLAR FAS 4/4 RGH KD 8-14FT', '16.14'),
(19, 991, '1720821-0445', 'WALNUT BLK FAS 4/4 RGH KD 8FT', '12.14'),
(20, 901, '1720822-0223', 'DOUGLAS FIR CVG 2X10X16FT #1', '16.18'),
(21, 547, '1720823-0011', 'PINE #2 2X4X10FT KD', '15.80'),
(22, 819, '1720824-0025', 'SPRUCE 2X6X10FT #2', '14.90'),
(23, 312, '1720825-0039', 'OAK RED 4/4 FAS KD 9FT', '16.50'),
(24, 694, '1720826-0052', 'MAPLE HARD 5/4 FAS KD 12FT', '17.20'),
(25, 128, '1720827-0067', 'POPLAR 4/4 FAS KD 10FT', '15.90'),
(26, 451, '1720828-0081', 'WALNUT 4/4 FAS KD 10FT', '13.40'),
(27, 273, '1720829-0094', 'DOUGLAS FIR 2X8X12FT #2', '16.00'),
(28, 886, '1720830-0108', 'CEDAR WRC 1X8X10FT CLR S4S', '19.50'),
(29, 409, '1720831-0122', 'PLYWOOD BIRCH 1/2X4X8', '16.80'),
(30, 762, '1720832-0136', 'MDF ST LX C3 2440X1220X18MM P/E', '15.40');

-- --------------------------------------------------------

--
-- Table structure for table `products_dimensions`
--

CREATE TABLE `products_dimensions` (
  `id` int(2) NOT NULL,
  `length_inches` float(10,2) DEFAULT NULL,
  `width_inches` float(10,2) DEFAULT NULL,
  `height_inches` float(10,2) DEFAULT NULL,
  `weight_lbs` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_dimensions`
--

INSERT INTO `products_dimensions` (`id`, `length_inches`, `width_inches`, `height_inches`, `weight_lbs`) VALUES
(1, 120.00, 44.00, 34.00, 3120.45),
(2, 168.00, 40.00, 28.50, 2975.30),
(3, 132.00, 46.00, 40.00, 3540.60),
(4, 96.00, 48.00, 52.00, 4250.75),
(5, 96.00, 42.00, 26.00, 1980.20),
(6, 120.00, 38.00, 32.00, 2430.85),
(7, 97.00, 49.00, 45.00, 3890.40),
(8, 120.00, 40.00, 30.00, 2180.55),
(9, 120.00, 48.00, 38.00, 2890.70),
(10, 144.00, 44.00, 48.00, 5120.35),
(11, 96.00, 39.00, 29.70, 3945.22),
(12, 96.00, 42.00, 36.00, 2850.50),
(13, 120.00, 48.00, 42.00, 4125.75),
(14, 144.00, 36.00, 30.00, 3280.00),
(15, 96.00, 36.00, 24.00, 1890.25),
(16, 120.00, 48.00, 38.00, 3750.80),
(17, 96.00, 48.00, 36.00, 2980.00),
(18, 144.00, 42.00, 32.00, 2650.40),
(19, 96.00, 48.00, 28.00, 2240.60),
(20, 192.00, 48.00, 40.00, 4580.90),
(21, 120.00, 42.00, 36.00, 3100.00),
(22, 120.00, 36.00, 30.00, 2950.00),
(23, 108.00, 48.00, 40.00, 4200.00),
(24, 144.00, 48.00, 38.00, 3950.00),
(25, 120.00, 42.00, 34.00, 2800.00),
(26, 120.00, 48.00, 30.00, 2550.00),
(27, 144.00, 48.00, 36.00, 3850.00),
(28, 120.00, 36.00, 28.00, 2100.00),
(29, 96.00, 48.00, 34.00, 2650.00),
(30, 96.00, 48.00, 36.00, 4200.00);

-- --------------------------------------------------------

--
-- Table structure for table `products_types`
--

CREATE TABLE `products_types` (
  `id` int(2) NOT NULL,
  `ficha` int(10) DEFAULT NULL,
  `uom_primary` text,
  `piece_count` int(3) DEFAULT NULL,
  `assembly` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products_types`
--

INSERT INTO `products_types` (`id`, `ficha`, `uom_primary`, `piece_count`, `assembly`) VALUES
(1, 452, 'PALLET', 95, 'FALSE'),
(2, 163, 'BUNDLE', 160, 'FALSE'),
(3, 589, 'PALLET', 110, 'FALSE'),
(4, 734, 'BUNDLE', 85, 'FALSE'),
(5, 298, 'PALLET', 70, 'FALSE'),
(6, 641, 'BUNDLE', 225, 'FALSE'),
(7, 812, 'PALLET', 60, 'FALSE'),
(8, 445, 'BUNDLE', 140, 'FALSE'),
(9, 127, 'PALLET', 65, 'FALSE'),
(10, 568, 'BUNDLE', 130, 'FALSE'),
(11, 724, 'BUNDLE', 250, 'FALSE'),
(12, 987, 'BUNDLE', 200, 'FALSE'),
(13, 337, 'PALLET', 150, 'FALSE'),
(14, 778, 'BUNDLE', 180, 'FALSE'),
(15, 187, 'BUNDLE', 300, 'FALSE'),
(16, 223, 'PALLET', 120, 'FALSE'),
(17, 876, 'PALLET', 45, 'FALSE'),
(18, 233, 'BUNDLE', 175, 'FALSE'),
(19, 991, 'PALLET', 20, 'FALSE'),
(20, 901, 'BUNDLE', 220, 'FALSE'),
(21, 547, 'BUNDLE', 190, 'FALSE'),
(22, 819, 'PALLET', 140, 'FALSE'),
(23, 312, 'PALLET', 110, 'FALSE'),
(24, 694, 'BUNDLE', 160, 'FALSE'),
(25, 128, 'PALLET', 90, 'FALSE'),
(26, 451, 'BUNDLE', 130, 'FALSE'),
(27, 273, 'BUNDLE', 280, 'FALSE'),
(28, 886, 'PALLET', 60, 'FALSE'),
(29, 409, 'BUNDLE', 180, 'FALSE'),
(30, 762, 'BUNDLE', 100, 'FALSE');

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
-- Indexes for table `mpl_shipping_list`
--
ALTER TABLE `mpl_shipping_list`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `mpl_shipping_list`
--
ALTER TABLE `mpl_shipping_list`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products_dimensions`
--
ALTER TABLE `products_dimensions`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products_types`
--
ALTER TABLE `products_types`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
