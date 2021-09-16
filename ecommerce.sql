-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2021 at 08:47 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(7) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default_category.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Mobile&Tablets', 'default_category.png', '2021-09-07 22:05:33', '2021-09-07 22:05:33'),
(2, 'TVs', 'default_category.png', '2021-09-07 22:05:33', '2021-09-07 22:05:33'),
(3, 'Electronics', 'default_category.png', '2021-09-07 22:05:33', '2021-09-12 08:46:35'),
(4, 'Sports', 'default_category.png', '2021-09-07 22:06:03', '2021-09-07 22:06:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(7) UNSIGNED NOT NULL,
  `code` varchar(5) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `delivery_date` datetime NOT NULL,
  `user_id` int(7) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `product_id` int(7) UNSIGNED NOT NULL,
  `order_id` int(7) UNSIGNED NOT NULL,
  `price_after_order` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Stand-in structure for view `pagination`
-- (See below for the actual view)
--
CREATE TABLE `pagination` (
`id` int(7) unsigned
,`name` varchar(200)
,`description` text
,`price` decimal(8,2)
,`image` varchar(100)
,`Category` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(7) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT 'default_product.png',
  `description` text NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `category_id` int(7) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `price`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Football', 'uploads/1631678975.jpg', ' It has survived not only five centuries, but also the leap.', '753.00', 4, '2021-09-11 10:13:31', '2021-09-15 04:09:35'),
(2, 'Samsung Galaxy A70', 'uploads/1631534507.jpg', 'Dimensions: 163.7 x 75.3 x 8.9 mm (6.44 x 2.96 x 0.35 in)\r\nWeight: 192 g (6.77 oz)\r\nSIM: Dual SIM (Nano-SIM, dual stand-by)', '2900.00', 1, '2021-09-11 10:20:22', '2021-09-13 12:01:47'),
(3, 'Huawei mate 11 ', 'uploads/1631604773.jpg', 'With the new era of the fast-moving automotive industry, LG Mobility is poised to be a market leader in the development of advanced parts for electric vehicles and services leveraging LG\'s rich user experiences and technologies acquired from its diverse consumer electronics experience over many decades.', '5800.00', 1, '2021-09-14 07:32:53', '2021-09-14 07:38:30'),
(62, 'Cooling Only Split Air Conditioner', 'uploads/1631772703.png', 'Key Features\r\nDual Inverter Compressor\r\nEnergy Saving\r\nFast Cooling\r\nSimple and Slim Design with Hidden Display\r\nLow Noise\r\nQuick and Easy Installation\r\n', '14390.00', 3, '2021-09-16 06:04:42', '2021-09-16 06:11:43'),
(63, 'LG 50 Inch 4K UHD Smart LED TV with Built-in Receiver', 'uploads/1631772631.png', 'Display: Display Type: 4K UHD Screen Size: 50 Inch Resolution: 3840 x 2160 BLU Type: Direct TruMotion / Refresh Rate: - / 50 Hz Video (Picture Quality) Processor: Quad Core Processor 4K Image Enhancing: Image Enhancing HDR', '8525.00', 2, '2021-09-16 06:10:31', '2021-09-16 06:10:31'),
(64, 'Panasonic Microwave Oven Silver', 'uploads/1631772812.jpg', 'Capacity:40L\r\nDisplay Type:LED \r\nMax Cooking time:99 Minutes 99 Seconds\r\nCooking stages\r\nOne Minute/30 sec plus\r\nPreheat\r\nAuto cook\r\nHeat Source:Grill, Microwave\r\nPower: 1300W', '4199.00', 3, '2021-09-16 06:13:32', '2021-09-16 06:13:32'),
(65, 'Reebok Kung Fu Panda Vector Runner Pull', 'uploads/1631773170.jpg', 'Product Dimensions ‏ : ‎ 33.5 x 25.5 x 9 cm; 900 Grams\r\nDate First Available ‏ : ‎ 16 March 2021\r\nManufacturer ‏ : ‎ Reebok\r\nASIN ‏ : ‎ B08TMR8TRD\r\nItem model number ‏ : ‎ H02990\r\nDepartment ‏ : ‎ Unisex', '1220.00', 4, '2021-09-16 06:17:30', '2021-09-16 06:19:30'),
(66, 'Hand Gripper Wrist Forearm', 'uploads/1631773612.jpg', 'Adopting the stainless steel spring and strengthened ABS material makes it durable.', '74.99', 4, '2021-09-16 06:23:47', '2021-09-16 06:26:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(7) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `photo` varchar(100) NOT NULL DEFAULT 'default.png',
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `photo`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Saad Elkammah', 'saad1998elkammah@gmail.com', '45e6f56595886196868336bfba1f5c0c', 'default.png', 'Admin', '2021-09-08 06:32:44', '2021-09-11 01:19:20'),
(2, 'Tamer Ahmed', 'tamer12345sdf@gmail.com', '8bac60c454f33b240a5150b883ee88c6', 'default.png', 'user', '2021-09-08 08:01:17', '2021-09-08 08:01:31'),
(14, 'Galal Elhussieny', 'galal@gmail.com', '60d23871f252b56c16a74fd7a7cc587b', 'default.png', 'Admin', '2021-09-11 01:29:05', '2021-09-16 06:37:28'),
(16, 'Ali Amin', 'saadmohammed@gmail.com', '1596fc95ba108a5181ecc862b4fc878f', 'default.png', 'user', '2021-09-16 06:34:03', '2021-09-16 06:34:03');

-- --------------------------------------------------------

--
-- Structure for view `pagination`
--
DROP TABLE IF EXISTS `pagination`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pagination`  AS   (select `products`.`id` AS `id`,`products`.`name` AS `name`,`products`.`description` AS `description`,`products`.`price` AS `price`,`products`.`image` AS `image`,`categories`.`name` AS `Category` from (`products` join `categories` on(`products`.`category_id` = `categories`.`id`)) order by `products`.`id`)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_FK` (`user_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD KEY `products_FK` (`product_id`),
  ADD KEY `orders_FK` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_FK` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD CONSTRAINT `orders_FK` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `products_FK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categories_FK` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
