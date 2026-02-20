-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2026 at 09:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practicee`
--

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `contact`, `subject`, `message`, `created_at`) VALUES
(1, 'Jeorgina Sapon', 'jeorginacathryncruzsapon@gmail.com', '09152053289', 'Concern', 'kehoahjhfkfkjakjfa', '2026-02-20 06:42:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `quantity` int(50) NOT NULL,
  `image` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `name` varchar(50) NOT NULL,
  `contact_num` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `product_name`, `quantity`, `image`, `total`, `name`, `contact_num`) VALUES
(1, 'M&Ms', 5, 'product.jpg', 5000.00, 'jaja', 926546352),
(2, 'M&Ms', 5, 'product.jpg', 5000.00, 'Leiona', 2147483647),
(3, 'M&Ms', 5, 'product.jpg', 5000.00, 'Leiona', 2147483647),
(4, 'M&Ms', 1, 'product.jpg', 1000.00, 'jaja', 926546352),
(15, 'M&Ms', 5, 'product.jpg', 5000.00, 'Leiona', 9063537806),
(16, 'M&Ms', 10, 'product.jpg', 10000.00, 'Leiona', 926546352),
(17, 'M&M\'s', 3, 'product.jpg', 1500.00, 'leiona', 9152032890);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stocks` int(50) NOT NULL,
  `image` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `stocks`, `image`) VALUES
(1, 'M&Ms', 1000.00, 100, 'product.jpg'),
(2, 'Kinder Bueno', 250.00, 50, 'product2.jpg'),
(3, 'Choco Chip Muffin', 350.00, 60, 'product3.jpg'),
(4, 'Dark Chocolate Toblerone', 200.00, 100, 'product4.png'),
(5, 'M&M\'s', 500.00, 0, 'product.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
