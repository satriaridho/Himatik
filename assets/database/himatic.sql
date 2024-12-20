-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2024 at 06:31 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `himatic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `email`, `password`) VALUES
(1, 'AdminTest', 'admintest@gmail.com', '$2a$12$/rwsxksQpQmCR7i5VI75feu0roEz2PcI8l4vo6NYmUTf2b3xtZkZa');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `created_at`) VALUES
(4, 'Product Update by AdminTest: Ayam Goreng has been updated.', '2024-12-17 14:56:17'),
(5, 'Product Update by AdminTest: Ayam Goreng has been updated.', '2024-12-03 14:56:56'),
(6, 'Product Update by AdminTest: Ayam Goreng has been updated.', '2024-12-17 14:58:53'),
(7, 'AdminTest updated product Ayam Goreng: stock from \'19\' to \'20\'.', '2024-12-17 16:56:26'),
(8, 'AdminTest updated product Es Gondang Winangun: name from \'Es Gondang Winangun\' to \'Es Gondang Geming\', stock from \'14\' to \'15\'.', '2024-12-17 16:56:40'),
(9, 'AdminTest updated user addtestEdit: email from \'addtest@test.com\' to \'addtest1@test.com\'.', '2024-12-17 16:56:58'),
(10, 'AdminTest added a sale for Ayam Goreng (ID: 1) on 2024-12-21 with quantity 78545245.', '2024-12-17 17:27:58'),
(11, 'AdminTest deleted 1 from sales_data.', '2024-12-17 17:28:56');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category` enum('Makanan','Minuman','Alat Tulis','Lain Lain') NOT NULL,
  `stock` int(11) NOT NULL,
  `harga_barang` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category`, `stock`, `harga_barang`) VALUES
(1, 'Ayam Goreng', 'Makanan', 20, 15000),
(2, 'Es Gondang Geming', 'Minuman', 15, 10000),
(4, 'Pensil', 'Alat Tulis', 15, 3000),
(5, 'parfum', 'Lain Lain', 15, 75000),
(9, 'Bebek Goreng', 'Makanan', 59, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `sales_data`
--

CREATE TABLE `sales_data` (
  `sales_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `sale_date` date NOT NULL,
  `sales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_data`
--

INSERT INTO `sales_data` (`sales_id`, `product_id`, `sale_date`, `sales`) VALUES
(4, 1, '2024-12-01', 20),
(5, 2, '2024-12-13', 20),
(6, 1, '2024-12-16', 15),
(7, 4, '2024-12-17', 20),
(8, 5, '2024-12-15', 10),
(9, 1, '2024-12-11', 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `join_date`, `address`) VALUES
(1, 'userTest', 'usertest@gmail.com', '$2a$12$6ko/u/bXLlpPa/jlpt4g5utLwo4zvlOTTum5wP0gsOyxjLjfcAguy', '2024-12-17', 'Yogyakarta, DIY'),
(2, 'addtestEdit', 'addtest1@test.com', '$2y$10$qbl9Ig8v7BfFReEg2AjmzeilAllzRMoItzaeHQ67r2Sti5ivGcYYK', '2024-12-17', 'Yogyakarta, DIY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD PRIMARY KEY (`sales_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sales_data`
--
ALTER TABLE `sales_data`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales_data`
--
ALTER TABLE `sales_data`
  ADD CONSTRAINT `sales_data_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
