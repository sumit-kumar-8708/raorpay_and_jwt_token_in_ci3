-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2024 at 12:49 PM
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
-- Database: `razorpay`
--

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `signature` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_id`, `signature`, `amount`, `status`, `created_at`) VALUES
(2, 'order_Oc2tFg8Bz9slES', 'pay_Oc2tgInoYZEtip', 'aa59dd5c3bc71851cad31e22148374e38020865528dd360db68e4a9cb5d5f9cc', 300.00, 'captured', '2024-07-23 10:47:03'),
(3, 'order_Oc3KdB9dAJLKor', 'pay_Oc3M8tjox1El69', '91c5eb8fc248af46223bd3af95cd0917ccb74878c7c0a4b96b2132e2f1b5a4a7', 400.00, 'captured', '2024-07-23 11:14:01'),
(4, 'order_Oc4hf5QFPxacyC', 'pay_Oc4jSDtR3ZWtCF', 'e0ad2ae593bd06eb0dbb377d782b84ca340a644175fbf99e2df9b5b89f707b15', 15000.00, 'captured', '2024-07-23 12:34:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(400) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img`) VALUES
(1, 'Shirt', 150.00, 'https://rukminim2.flixcart.com/image/850/1000/xif0q/shirt/x/l/d/s-st28-vebnor-original-imagq6aqgh2hzv22.jpeg?q=90&crop=false'),
(2, 'T-shirt', 180.00, 'https://www.jiomart.com/images/product/original/rv28zflunt/inchh-men-s-cotton-round-neck-colour-block-half-sleeve-t-shirt-product-images-rv28zflunt-0-202207250225.jpg?im=Resize=(500,630)'),
(3, 'DVD', 450.00, 'https://images-cdn.ubuy.co.in/65b7b15aa445ac5f4d55604a-dvd-players-for-tv-with-hdmi-dvd.jpg'),
(4, 'Bottle', 200.00, 'https://giftvaala.in/wp-content/uploads/2021/04/bottle.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `product_id`, `payment_id`, `signature`, `amount`, `status`, `created_at`) VALUES
(3, 'order_Ocr18lq7r8szAC', 1, 'pay_Ocr31fgJLsYY41', '7019e138bf5adfe28f3633e76a032bdb65fbe6d718d2e1170bb9032024b9b831', 6.00, '1', '2024-07-25 11:48:32'),
(4, 'order_OcrHDibFtKDu0F', 1, 'pay_OcrHXkCwd62RLt', '3261a4c11f6c1f1e40f0ac1ad9ca818213775302c468922f6cfdab5ef3adb76e', 10.00, '1', '2024-07-25 12:03:45'),
(5, 'order_OcrJNPkvF3H1z0', 1, 'pay_OcrJwbBHWaumqy', 'e072858103fe2f1c389d23930bfbbfd156f95fa9ed73ea6ef6a9c386dce9ccf1', 11.00, '1', '2024-07-25 12:05:48'),
(6, 'order_OcrLyqaZh4B5zr', 1, 'pay_OcrMvn8PY5X4Qp', '3bef52dbb89104056ecd9628c4b9e94bfab4e0719417048d3815bffb3e3e4f1c', 12.00, '1', '2024-07-25 12:08:16'),
(7, 'order_OcrO6EInMxP19g', 1, 'pay_OcrOa6yMmt4ly3', '4792631950bf22e93aef77054b01dbde86b0ef12370c4ab29151d79df0ff23cd', 14.00, '1', '2024-07-25 12:10:16'),
(8, 'order_Odd25MBcBLnMSM', 1, 'pay_Odd2V38On7H7YD', '6bbfe65d61fb08fb730a7ea090efaf3071945283b345c4ce70a94cdf1757b482', 20.00, '1', '2024-07-27 10:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `status`) VALUES
(1, 'sumit@basix.in', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
