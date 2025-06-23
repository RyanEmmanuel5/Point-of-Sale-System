-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 01:40 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_dcit26`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_tbl`
--

CREATE TABLE `cart_tbl` (
  `CART_ID` int(11) NOT NULL,
  `PRODUCT_ID` int(11) NOT NULL,
  `QUANTITY` int(11) NOT NULL,
  `ADDED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `PRODUCT_ID` int(11) NOT NULL,
  `PRODUCT_NAME` varchar(255) NOT NULL,
  `PRICE` decimal(10,2) NOT NULL,
  `CATEGORY` varchar(100) NOT NULL,
  `IMAGE` varchar(255) DEFAULT NULL,
  `CREATED_AT` datetime DEFAULT current_timestamp(),
  `UPDATED_AT` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`PRODUCT_ID`, `PRODUCT_NAME`, `PRICE`, `CATEGORY`, `IMAGE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 'Red Velvet Cookies', '40.00', 'Cookies', 'uploads/67681fbce14e95.68396199.jpg', '2024-12-22 22:18:36', '2025-01-18 20:47:51'),
(2, 'Choco Chip', '40.00', 'Cookies', 'uploads/67681fd896b8c5.91427195.jpg', '2024-12-22 22:19:04', '2025-01-14 22:36:28'),
(3, 'Matcha', '40.00', 'Cookies', 'uploads/67681fe9398e96.63468330.jpg', '2024-12-22 22:19:21', '2025-01-14 23:56:54'),
(4, 'Cheese', '40.00', 'Cookies', 'uploads/67681ffa4d9f42.62551360.jpg', '2024-12-22 22:19:38', '2024-12-22 22:19:38'),
(5, 'Double Choco', '40.00', 'Cookies', 'uploads/67682010b1e294.16321142.jpg', '2024-12-22 22:20:00', '2024-12-22 22:20:00'),
(6, 'Banana Loaf', '150.00', 'Loaf', 'uploads/67682020a65733.98541916.jpg', '2024-12-22 22:20:16', '2024-12-22 22:20:26'),
(7, 'Box of 6  Brownies', '180.00', 'Brownies', 'uploads/6769923a417869.49442379.jpg', '2024-12-24 00:39:22', '2025-06-13 16:11:12'),
(12, ' 8 Red Velvet Crinkles', '180.00', 'Crinkles', 'uploads/678676a53ab403.29568393.jpg', '2025-01-14 22:37:25', '2025-01-14 22:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `sales_tbl`
--

CREATE TABLE `sales_tbl` (
  `SALE_ID` int(11) NOT NULL,
  `USERNAME` varchar(255) NOT NULL,
  `TOTAL_PAYABLE` decimal(10,2) NOT NULL,
  `ITEM_DETAILS` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`ITEM_DETAILS`)),
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `PAID_AMOUNT` decimal(10,2) DEFAULT 0.00,
  `CHANGED` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_tbl`
--

CREATE TABLE `users_tbl` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(150) NOT NULL,
  `USERNAME` varchar(150) NOT NULL,
  `EMAIL` varchar(150) NOT NULL,
  `PASSWORD` varchar(150) NOT NULL,
  `ROLE` enum('employee','admin') NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tbl`
--

INSERT INTO `users_tbl` (`ID`, `NAME`, `USERNAME`, `EMAIL`, `PASSWORD`, `ROLE`) VALUES
(1, 'Mikha Lim', 'Admin1', 'admin1@gmail.com', '$2y$10$oZuaYh6qKTGbC9f0LW5XCeQ2SkWOsNVcBxTjumMP9xBVYMf98stCi', 'admin'),
(2, 'Maloi Ricalde', 'employee1', 'employee1@gmail.com', '$2y$10$yYyqbNnB/k7nIqS8bWtByOBg3Hdf5eJB4EnI/7MBRTNN8keqfPldS', 'employee');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD PRIMARY KEY (`CART_ID`),
  ADD KEY `PRODUCT_ID` (`PRODUCT_ID`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`PRODUCT_ID`);

--
-- Indexes for table `sales_tbl`
--
ALTER TABLE `sales_tbl`
  ADD PRIMARY KEY (`SALE_ID`);

--
-- Indexes for table `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  MODIFY `CART_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `PRODUCT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sales_tbl`
--
ALTER TABLE `sales_tbl`
  MODIFY `SALE_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD CONSTRAINT `cart_tbl_ibfk_1` FOREIGN KEY (`PRODUCT_ID`) REFERENCES `product_tbl` (`PRODUCT_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
