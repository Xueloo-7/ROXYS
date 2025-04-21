-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 20, 2025 at 05:18 PM
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
-- Database: `web_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `code` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL,
  `price` double(10,2) NOT NULL,
  `original_price` double NOT NULL,
  `description` varchar(500) NOT NULL,
  `stock` int(11) NOT NULL,
  `discount` int(11) DEFAULT NULL,
  `sold` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `reviews` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `details` varchar(500) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `original_price`, `description`, `stock`, `discount`, `sold`, `rating`, `reviews`, `details`, `image_url`, `category`) VALUES
(1, 'Brixton Brown Flatcap', 49.99, 69.99, 'A classic brown flat cap from Brixton.', 100, 30, 20, 4.80, 125, 'Function: Wear resistant\r\nClosing method: Lace up\r\nStyle: Fashion\r\nSeason: Spot And Dring\r\nflat cap style: Round cicle flat\r\nOccasion: Fashion and design', 'image\\product\\Caps\\Flat Caps\\Brixton Brown Flatcap Cap.webp', 'cap'),
(2, 'Adidas Classics Women T-Shirt', 39.99, 59.99, 'Comfortable Adidas t-shirt for women.', 150, 33, 2325, 4.60, 98, 'Function: Built with ultra wear-resistant materials, this item offers extended durability for long-term use.\r\nClosing method: Traditional lace-up style ensures a custom fit and all-day comfort.\r\nStyle: Sleek and sporty, perfect for pairing with both streetwear and casual outfits.\r\nSeason: Ideal for spring, summer, and early autumn wear.\r\nFlat cap style: The rounded flat cap design brings a touch of vintage flair to a modern look.\r\nOccasion: Great for daily use, city walking, or creative photosho', 'image\\product\\Clothes\\Adidas Classics 4 woman T-Shirt.webp', 'clothes'),
(3, 'Gucci Belted Pleated Dress', 799.99, 999.99, 'Elegant Gucci dress with pleated design.', 50, 20, 5650, 4.90, 200, 'Function: Reinforced with abrasion-resistant fibers to withstand rugged conditions.\r\nClosing method: Lace-up closure adds security and a sporty look.\r\nStyle: Minimalist aesthetic for a timeless fashion vibe.\r\nSeason: Suitable for cool and mild seasons.\r\nFlat cap style: Circular flat brim gives a bold statement.\r\nOccasion: Designed for art fairs, weekend walks, or streetwear looks.\",\"https://picsum.photos/seed/3/300/300,https://picsum.photos/seed/4/300/300', 'image/product/Dresses/Gucci Belted pleated cotton dresses.webp', 'dress'),
(4, 'Men\'s Fashionable Long Pants', 59.99, 79.99, 'Stylish long pants for men.', 120, 25, 87, 4.70, 110, 'Function: Crafted for flexibility and resistance to wear, ensuring comfort and longevity.\r\nClosing method: Classic lace-up system for snug fit.\r\nStyle: Urban-inspired, tailored for trend-conscious individuals.\r\nSeason: Designed for transitional weather.\r\nFlat cap style: Smooth round shape complements most face shapes.\r\nOccasion: Ideal for fashion shoots, events, or casual hangouts.\",\"https://picsum.photos/seed/5/300/300,https://picsum.photos/seed/6/300/300', 'image/product/LongShortPants/Long Pants/Men\'s Fashionable pants.webp', 'pants'),
(5, 'Rollerblade Grey Men\'s Shorts', 34.99, 49.99, 'Casual grey shorts with pockets.', 90, 30, 22, 4.50, 85, 'Function: Durable design suitable for outdoor activity and all-day wear.\r\nClosing method: Adjustable lace system for a personalized fit.\r\nStyle: Modern cut with a vintage twist.\r\nSeason: Versatile for spring and fall.\r\nFlat cap style: Round flat cap with reinforced seams.\r\nOccasion: Wear it to markets, campus, or creative events.\",\"https://picsum.photos/seed/7/3000/300,https://picsum.photos/seed/8/200/320', 'image/product/LongShortPants/Short pants/Rollerblade Grey Men\'s Shorts with Pocket Grey.webp', 'pants'),
(6, 'Adidas Boxer Underwear for Men', 89.99, 129.99, 'High-quality shoes with detailed finishing.', 70, 20, 18, 4.60, 77, 'Function: Combines comfort with long-term endurance in daily use.\r\nClosing method: Secure lace-up entry.\r\nStyle: Contemporary cap with subtle urban cues.\r\nSeason: Meant for sunny or breezy weather.\r\nFlat cap style: Clean round silhouette.\r\nOccasion: Pair it with smart-casual outfits or outdoor wear.\",\"https://picsum.photos/seed/9/300/300,https://picsum.photos/seed/10/300/300', 'image\\product\\Underclothes\\Men\'s\\Adidas Boxer Underwear for Men.jpeg', 'underclothes'),
(7, 'Christian Louboutin High Heels', 999.99, 1299.99, 'Luxury high heels by Christian Louboutin.', 40, 23, 10, 4.90, 140, 'Function: Engineered to resist friction and surface damage.\r\nClosing method: Easy-to-adjust laces ensure a perfect fit.\r\nStyle: Refined streetwear influence.\r\nSeason: Best for spring-to-summer transition.\r\nFlat cap style: Balanced circle shape for comfort and style.\r\nOccasion: Street fashion, music festivals, or quick errands.\",\"https://picsum.photos/seed/11/300/300,https://picsum.photos/seed/12/300/300', 'image/product/Shoes/HighHeels/Christian Louboutin Sourse high heels.webp', 'shoe'),
(8, 'Dior Running Shoes', 299.99, 399.99, 'Premium running shoes by Dior.', 80, 25, 523, 4.80, 150, 'Function: Wear resistant\r\nClosing method: Lace up\r\nStyle: Sports\r\nSeason: Spring and Autumn\r\nShoe toe style: Round toe\r\nOccasion: Sports and Leisure', 'image/product/Shoes/RunningShoes/dior shoes.jpeg', 'shoe'),
(9, 'Adidas Women\'s Ankle Socks', 19.99, 29.99, 'Comfortable ankle socks from Adidas.', 200, 33, 50, 4.40, 90, 'Function: Made with materials that withstand intensive daily use.\r\nClosing method: Customizable lacing structure.\r\nStyle: Urban cool with minimalist touches.\r\nSeason: Great for variable temperatures.\r\nFlat cap style: Neutral round frame.\r\nOccasion: Use it at cafes, trips, or city walks.\",\"https://picsum.photos/seed/13/300/300,https://picsum.photos/seed/14/300/300', 'image/product/Socks/Women\'s/Adidas Women\'s Anikle Socks.jpeg', 'socks'),
(10, 'Bellroy Laneway Everyday Bumbag', 79.99, 99.99, 'A stylish everyday bag for men.', 60, 20, 124, 4.70, 130, 'Function: Scratch-resistant and breathable design.\r\nClosing method: Traditional lace with secure eyelets.\r\nStyle: Balanced between comfort and modern appeal.\r\nSeason: Best worn in transitional climates.\r\nFlat cap style: Defined circle base for style balance.\r\nOccasion: Excellent for chill hangouts and shopping runs.\",\"https://picsum.photos/seed/19/300/300,https://picsum.photos/seed/20/300/30', 'image/product/WomenManBags/Men\'s Bags/Bellroy Laneway- Everyday Bumbag.webp', 'bag');

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_code` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_color`
--

INSERT INTO `product_color` (`id`, `product_id`, `color_code`) VALUES
(3, 3, '#FFD700'),
(4, 4, '#000000'),
(5, 5, '#808080'),
(6, 6, '#B22222'),
(7, 7, '#FF1493'),
(8, 8, '#1E90FF'),
(9, 9, '#000000'),
(11, 5, '#8B4513'),
(39, 2, '#8B4513'),
(44, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `product_review`
--

CREATE TABLE `product_review` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`id`, `product_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(2, 2, 102, 4.5, 'Very comfortable and stylish.', '2025-03-17 12:00:12'),
(3, 3, 103, 4.8, 'Gucci never disappoints, stunning dress.', '2025-03-17 12:00:12'),
(4, 4, 104, 4.6, 'Good fit, material feels premium.', '2025-03-17 12:00:12'),
(5, 5, 105, 4.2, 'Nice shorts, but a bit loose.', '2025-03-17 12:00:12'),
(6, 6, 106, 4.5, 'Excellent finishing on these shoes.', '2025-03-17 12:00:12'),
(7, 7, 107, 5.0, 'Best heels ever, worth every penny!', '2025-03-17 12:00:12'),
(8, 8, 108, 4.9, 'Super comfortable for running.', '2025-03-17 12:00:12'),
(9, 9, 109, 4.3, 'Decent quality socks, very soft.', '2025-03-17 12:00:12'),
(10, 10, 110, 4.7, 'Perfect size bag, great for daily use.', '2025-03-17 12:00:12'),
(12, 1, 1, 4.5, 'test 1', '2025-04-20 05:09:49'),
(14, 1, 1, 4.8, 'test 3', '2025-04-20 05:10:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`id`, `product_id`, `size`) VALUES
(52, 3, 6),
(53, 3, 8),
(54, 3, 10),
(55, 4, 30),
(56, 4, 32),
(57, 4, 34),
(58, 5, 28),
(59, 5, 30),
(60, 5, 32),
(61, 6, 40),
(62, 6, 42),
(63, 7, 38),
(64, 7, 40),
(65, 8, 39),
(66, 8, 41),
(67, 8, 43),
(68, 9, 1),
(77, 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_history`
--

CREATE TABLE `purchase_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `order_status` varchar(10) NOT NULL,
  `delivery_detail` varchar(500) NOT NULL,
  `place_date` datetime NOT NULL,
  `paid_date` datetime DEFAULT NULL,
  `shipped_date` datetime DEFAULT NULL,
  `delivered_date` datetime DEFAULT NULL,
  `completed_date` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchase_history`
--

INSERT INTO `purchase_history` (`id`, `user_id`, `product_id`, `quantity`, `payment_method`, `order_status`, `delivery_detail`, `place_date`, `paid_date`, `shipped_date`, `delivered_date`, `completed_date`, `updated_at`) VALUES
(13, 1, 1, 5, 'Touch n Go', 'to_pay', '', '2024-08-16 10:00:00', '2024-08-16 10:00:00', '2024-08-16 10:00:00', '2024-08-16 10:00:00', '2024-08-16 10:00:00', '2025-04-19 23:11:47'),
(14, 1, 2, 2, 'Touch n Go', 'to_receive', '', '2024-09-10 12:30:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(15, 1, 3, 4, 'Touch n Go', 'to_ship', '', '2024-10-05 14:45:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(16, 1, 4, 1, 'Touch n Go', 'to_review', '', '2024-11-20 16:10:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(17, 1, 5, 4, 'Touch n Go', 'to_pay', '', '2024-12-15 18:25:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(18, 1, 6, 2, 'Touch n Go', 'to_receive', '', '2025-01-08 20:40:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(19, 1, 7, 1, 'Touch n Go', 'to_ship', '', '2025-02-12 08:55:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(20, 1, 8, 1, 'Touch n Go', 'to_review', '', '2025-03-05 11:15:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(21, 1, 9, 2, 'Touch n Go', 'to_pay', 'WOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWOWO', '2025-03-25 13:30:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(22, 1, 10, 5, 'Touch n Go', 'to_receive', 'Your package was received on September 16, 2018\n', '2025-04-01 15:45:00', NULL, NULL, NULL, NULL, '2025-04-19 23:11:47'),
(28, 1, 8, 2, 'Online Banking', 'to_ship', 'Your package has been delivered![Kuala Lumpur]', '2025-04-19 12:53:00', '2025-04-20 22:52:00', '2025-04-21 22:52:00', '2025-04-24 01:55:00', '2025-04-24 07:53:00', '2025-04-20 12:35:15');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `color_code` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `gender` varchar(100) DEFAULT NULL,
  `avatar_url` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `address_line` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postcode` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `gender`, `avatar_url`, `active`, `address_line`, `city`, `postcode`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$T5cAq0nJxO7ylo560DjG9OwuVDX5AQ703A82ExGnUKKQUL72vILSG', 'ef9c38d88296dfe8e6cddc74f83c1a35', '2025-03-31 05:32:33', '2025-04-20 16:57:47', 'Male', '/image/avatar/admin.jpg', 1, '', '', ''),
(2, '芙宁娜', 'furina@gmail.com', '$2y$10$BOzoIzLfJcssk2i76oMhrOCRDKAMLRKXdfaBqhKb9yi5dxDdPlY46', '60b39ebea2f547f96c528c33f9391049', '2025-04-09 17:05:24', '2025-04-20 16:53:57', 'Female', '/image/avatar/芙宁娜.jpg', 1, '', '', ''),
(15, 'Pandora', 'jackyloh5775@gmail.com', '$2y$10$7i9p./ydlVcz3NWr0Lc/Re0.66g4YEQvpuhWMXO4tlqDPkLeLTGRS', '4b5348117224bc92bffbc68d171cbcb3', '2025-04-19 15:05:20', '2025-04-20 19:45:31', 'other', '/image/avatar/Pandora.jpg', 1, '6, lorong ria 2, Taman Bunga Raya', 'Setapak', '53000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_color`
--
ALTER TABLE `product_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_review`
--
ALTER TABLE `product_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_cart_item` (`user_id`,`product_id`,`color_code`,`size`),
  ADD KEY `product_id` (`product_id`);

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
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `purchase_history`
--
ALTER TABLE `purchase_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_color`
--
ALTER TABLE `product_color`
  ADD CONSTRAINT `product_color_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_review`
--
ALTER TABLE `product_review`
  ADD CONSTRAINT `product_review_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchase_history`
--
ALTER TABLE `purchase_history`
  ADD CONSTRAINT `purchase_history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchase_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `shopping_cart_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
