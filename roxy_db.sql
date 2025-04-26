-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 05:52 AM
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
-- Database: `roxy_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `payment_method`, `order_status`, `delivery_detail`, `place_date`, `paid_date`, `shipped_date`, `delivered_date`, `completed_date`, `updated_at`) VALUES
(1, 2, 1, 1, 'Touch n Go', 'pending', 'Your package has been delivered![Kuala Lumpur]', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43'),
(2, 2, 6, 1, 'Touch n Go', 'pending', 'Your package has been delivered![Kuala Lumpur]', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43'),
(3, 2, 26, 1, 'Touch n Go', 'pending', 'Your package has been delivered![Kuala Lumpur]', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43', '2025-04-25 21:15:43'),
(4, 2, 3, 1, 'Touch n Go', 'pending', 'Your package has been delivered![Kuala Lumpur]', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30'),
(5, 2, 10, 1, 'Touch n Go', 'pending', 'Your package has been delivered![Kuala Lumpur]', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30', '2025-04-25 21:20:30');

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

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `code`, `expires_at`, `created_at`, `updated_at`) VALUES
(11, 'qisheng7615@gmail.com', '557334', '2025-04-26 11:11:06', '2025-04-25 13:00:29', '2025-04-26 03:06:06');

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
  `details` varchar(500) DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `original_price`, `description`, `stock`, `discount`, `sold`, `details`, `image_url`, `category`) VALUES
(1, 'Adidas Blue Adjustable Ball Cap', 39.90, 49.9, 'A stylish adjustable cap from Adidas', 100, 20, 0, 'Unisex cap with adjustable strap', 'image\\product\\Caps\\Baseball caps\\Adidas Blue Adjustable Ball Cap.webp', 'cap'),
(2, 'Ball Cap Dilute Wash Deep Luxe', 42.50, 52, 'Washed deep luxe look for streetwear lovers', 120, 18, 0, 'One size fits most', 'image\\product\\Caps\\Baseball caps\\Ball Cap Dilute Wash Deep Luxe.webp', 'cap'),
(3, 'Bulk Supplement Black Ball Cap', 35.00, 40, 'Simple and bold black cap', 90, 12, 0, 'Perfect for gym and casual wear', 'image\\product\\Caps\\Baseball caps\\Bulk Supplement Black Ball Cap.webp', 'cap'),
(4, 'Calvin Klein Pink Ball Cap', 55.90, 65, 'Elegant Calvin Klein pink design', 70, 15, 0, 'Fashion cap with brand logo', 'image\\product\\Caps\\Baseball caps\\Calvin Klein Pink Ball Cap.webp', 'cap'),
(5, 'Djinns Black Ball Cap', 29.99, 39.99, 'Sleek black ball cap from Djinns', 85, 25, 0, 'Minimalist style with comfort fit', 'image\\product\\Caps\\Baseball caps\\Djinns Black Ball Cap.webp', 'cap'),
(6, 'J Rise S Cb Mtl Lm Unisex Ball Cap', 44.99, 54.99, 'Unisex cap with modern design', 60, 18, 0, 'Adjustable and breathable', 'image\\product\\Caps\\Baseball caps\\J Rise S Cb Mtl Lm Unisex Ball Cap.webp', 'cap'),
(7, 'Jordan Green Ball Cap', 48.00, 59, 'Classic green Jordan cap', 110, 19, 0, 'Official Jordan product', 'image\\product\\Caps\\Baseball caps\\Jordan Green Ball Cap.webp', 'cap'),
(8, 'Men\'s Classic Ball Cap Wash Grey', 32.90, 42, 'Washed grey for a worn-in look', 100, 22, 0, 'Comfortable and timeless', 'image\\product\\Caps\\Baseball caps\\Men\'s Classic Ball Cap Wash Grey.webp', 'cap'),
(9, 'New Era MLB Blue Ball Cap', 59.90, 69.9, 'Authentic MLB gear from New Era', 90, 14, 0, 'Perfect for baseball fans', 'image\\product\\Caps\\Baseball caps\\New Era MLB Blue Ball Cap.webp', 'cap'),
(10, 'Under Armour Black Ball Cap', 39.50, 49.5, 'Sporty cap from Under Armour', 75, 15, 0, 'Sweat-resistant material', 'image\\product\\Caps\\Baseball caps\\Under Armour Black Ball Cap.webp', 'cap'),
(11, 'Decathlon Beanie cap', 25.00, 30, 'Warm and affordable beanie', 150, 10, 0, 'Ideal for winter sports', 'image\\product\\Caps\\Beanie Caps\\Decathlon Beanie cap.webp', 'cap'),
(12, 'Decathlon Simple Blue Beanie Cap', 22.50, 28, 'Simple and classic beanie design', 160, 12, 0, 'Soft and durable', 'image\\product\\Caps\\Beanie Caps\\Decathlon Simple Blue Beanie Cap.webp', 'cap'),
(13, 'Equip Black docker Beanie Cap', 27.90, 33, 'Docker-style snug black cap', 80, 10, 0, 'Trendy and comfortable', 'image\\product\\Caps\\Beanie Caps\\Equip Black docker Beanie Cap.webp', 'cap'),
(14, 'Unisex Fisherman Beanie Cap', 29.00, 36, 'Classic fisherman style', 130, 15, 0, 'Unisex with ribbed pattern', 'image\\product\\Caps\\Beanie Caps\\Unisex Fisherman Beanie Cap.webp', 'cap'),
(15, 'Unisex Plain Color Slouchy Knitted Beanie Hat', 24.90, 32, 'Slouchy and comfy for casual wear', 120, 22, 0, 'Knitted design with soft wool', 'image\\product\\Caps\\Beanie Caps\\Unisex Plain Color Slouchy Knitted Beanie Hat.webp', 'cap'),
(16, 'Brixton Brown Flatcap Cap', 34.50, 42, 'Vintage brown flatcap', 95, 18, 0, 'Elegant style for casual/formal', 'image\\product\\Caps\\Flat Caps\\Brixton Brown Flatcap Cap.webp', 'cap'),
(17, 'Jaxon & James Green Flatcap Cap', 38.00, 45, 'Classic green flatcap', 105, 16, 0, 'Timeless English look', 'image\\product\\Caps\\Flat Caps\\Jaxon & James Green Flatcap Cap.webp', 'cap'),
(18, 'Lacoste Blue Flatcap Cap', 62.90, 75, 'Premium flatcap from Lacoste', 60, 16, 0, 'Luxury and comfort combined', 'image\\product\\Caps\\Flat Caps\\Lacoste Blue Flatcap Cap.webp', 'cap'),
(19, 'Men\'s Vintage Newsboy Flatcap Cap', 33.00, 40, 'Newsboy style with a vintage touch', 100, 15, 0, 'Great for formal and retro fits', 'image\\product\\Caps\\Flat Caps\\Men\'s Vintage Newsboy Flatcap Cap.webp', 'cap'),
(20, 'Puma Black Flatcap Cap', 44.00, 55, 'Modern flatcap from Puma', 85, 20, 0, 'Sports meets classic', 'image\\product\\Caps\\Flat Caps\\Puma Black Flatcap Cap.webp', 'cap'),
(21, 'Stetson Black Flatcap Cap', 68.90, 80, 'Premium black flatcap by Stetson', 50, 14, 0, 'Iconic brand heritage', 'image\\product\\Caps\\Flat Caps\\Stetson Black Flatcap Cap.webp', 'cap'),
(22, 'Adidas Classics 3 woman T-Shirt', 49.90, 60, 'Classic Adidas tee for women', 100, 17, 0, 'Comfortable and breathable cotton fabric', 'image\\product\\Clothes\\Adidas Classics 3 woman T-Shirt.webp', 'clothes'),
(23, 'Adidas Classics 4 woman T-Shirt', 51.50, 65, 'Updated design with signature 3-stripes', 90, 21, 0, 'Modern fit for active lifestyle', 'image\\product\\Clothes\\Adidas Classics 4 woman T-Shirt.webp', 'clothes'),
(24, 'Adidas Floral Loose Woman T-Shirt', 54.90, 70, 'Floral pattern loose fit Adidas shirt', 80, 22, 0, 'Floral themed casual wear', 'image\\product\\Clothes\\Adidas Floral Loose Woman T-Shirt.webp', 'clothes'),
(25, 'Adidas Originals Xterwer Woman T-Shirt', 59.00, 75, 'Exclusive Xterwer design by Adidas', 75, 21, 0, 'Limited edition release', 'image\\product\\Clothes\\Adidas Originals Xterwer Woman T-Shirt.webp', 'clothes'),
(26, 'Blue Adidas T-Shirt', 47.90, 55, 'Simple blue Adidas shirt', 120, 13, 0, 'Essential wardrobe item', 'image\\product\\Clothes\\Blue Adidas T-Shirt.jpeg', 'clothes'),
(27, 'Blue Long sleeve jacket for woman', 85.00, 105, 'Stylish blue long sleeve jacket', 60, 19, 0, 'Great for chilly evenings', 'image\\product\\Clothes\\Blue Long sleeve jacket for woman.webp', 'clothes'),
(28, 'Long sleeve jacket for woman', 79.90, 95, 'Versatile jacket for daily wear', 55, 16, 0, 'Durable and elegant design', 'image\\product\\Clothes\\long sleeve jacket for woman.webp', 'clothes'),
(29, 'Nike EQT Long Sleeve Graphic Tee For men', 66.90, 80, 'Nike EQT series with bold graphics', 70, 17, 0, 'Men’s casual graphic tee', 'image\\product\\Clothes\\Nike EQT Long Sleeve Graphic Tee For men.webp', 'clothes'),
(30, 'Puma Ess Logo Solid Hooded Jacket', 92.50, 110, 'Essentials collection by Puma', 40, 16, 0, 'Logo-stamped functional hoodie', 'image\\product\\Clothes\\Puma Ess Logo Solid Hooded Jacket.webp', 'clothes'),
(31, 'Puma Long Sleeve Zip Up Black White Mens Hooded Track Jacket', 99.90, 125, 'High performance track jacket', 50, 20, 0, 'Sleek monochrome colorway', 'image\\product\\Clothes\\Puma Long Sleeve Zip Up Black White Mens Hooded Track Jacket.webp', 'clothes'),
(32, 'Puma Originals Stripe Long Sleeve T-Shirt', 55.00, 65, 'Striped Puma Originals series', 85, 15, 0, 'Eye-catching vintage look', 'image\\product\\Clothes\\Puma Originals Stripe Long Sleeve T-Shirt.webp', 'clothes'),
(33, 'Red Hooded Long-Sleeved Jacket', 77.00, 90, 'Bold red jacket with hood', 65, 14, 0, 'Pop of color for your wardrobe', 'image\\product\\Clothes\\Red Hooded Long-Sleeved Jacket.webp', 'clothes'),
(34, 'Gucci Belted pleated cotton dresses', 299.00, 350, 'High-end Gucci cotton dress', 10, 15, 0, 'Belted pleats with elegance', 'image\\product\\Dresses\\Gucci Belted pleated cotton dresses.webp', 'clothes'),
(35, 'HuYa dress', 45.00, 60, 'Simple and elegant HuYa design', 70, 25, 0, 'Budget-friendly formal wear', 'image\\product\\Dresses\\HuYa dress.jpeg', 'clothes'),
(36, 'Pink Floral Asymmetrical Waist Split Midi Dress', 66.00, 85, 'Elegant asymmetrical floral midi', 45, 22, 0, 'Great for casual dates or events', 'image\\product\\Dresses\\Pink Floral Asymmetrical Waist Split Midi Dress.webp', 'clothes'),
(37, 'product5', 39.90, 50, 'Lightweight and flowy dress', 100, 20, 0, 'Casual minimalist style', 'image\\product\\Dresses\\product5.webp', 'clothes'),
(38, 'Roland Mouret Cady midi dress Woman dress', 189.00, 230, 'Designer mid-length dress', 15, 18, 0, 'Sleek lines and rich color', 'image\\product\\Dresses\\Roland Mouret Cady midi dress Woman dress.webp', 'clothes'),
(39, 'Solid Fold Pleated Cami Dress', 58.00, 70, 'Casual pleated cami dress', 80, 17, 0, 'Solid color with elegant folds', 'image\\product\\Dresses\\Solid Fold Pleated Cami Dress.webp', 'clothes'),
(40, 'women dress how to wear example1', 35.00, 50, 'Example lookbook dress', 60, 30, 0, 'Model reference outfit', 'image\\product\\Dresses\\women dress how to wear example1.jpeg', 'clothes'),
(41, 'women dress how to wear example2', 36.00, 52, 'Lookbook outfit inspiration', 55, 31, 0, 'Style and fit guide', 'image\\product\\Dresses\\women dress how to wear example2.webp', 'clothes'),
(42, 'women dress how to wear example3', 38.00, 55, 'Lookbook dress series', 50, 31, 0, 'Wardrobe suggestion outfit', 'image\\product\\Dresses\\women dress how to wear example3.jpg', 'clothes'),
(43, 'Women\'s Solid Color Spaghetti Strap Minimalist Ruched Casual Dress', 62.00, 75, 'Minimalist spaghetti strap dress', 40, 17, 0, 'Form-fitting and casual', 'image\\product\\Dresses\\Women\'s Solid Color Spaghetti Strap Minimalist Ruched Casual Dress.webp', 'clothes'),
(44, 'Women\'s Spring Autumn Casual Comfortable Waist Decor dress', 66.50, 85, 'Transitional seasonal dress', 45, 22, 0, 'Comfortable with waist accent', 'image\\product\\Dresses\\Women\'s Spring Autumn Casual Comfortable Waist Decor dress.webp', 'clothes'),
(45, 'Zimmermann Wylie belted dresses', 259.00, 310, 'Zimmermann signature belted line', 20, 16, 0, 'Luxury brand piece', 'image\\product\\Dresses\\Zimmermann Wylie belted dresses.webp', 'clothes');

-- --------------------------------------------------------

--
-- Table structure for table `product_color`
--

CREATE TABLE `product_color` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_code` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_review`
--

INSERT INTO `product_review` (`id`, `product_id`, `user_id`, `rating`, `review_text`, `created_at`) VALUES
(24, 1, 15, 5.0, 'This is a review!', '2025-04-25 13:39:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`id`, `user_id`, `product_id`, `quantity`, `color_code`, `size`) VALUES
(68, 2, 10, 1, NULL, ''),
(69, 2, 3, 1, NULL, '');

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
  `gender` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `address_line` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `gender`, `avatar`, `active`, `role`, `address_line`, `city`, `postcode`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$T5cAq0nJxO7ylo560DjG9OwuVDX5AQ703A82ExGnUKKQUL72vILSG', '6a065f4998a9201d201dc3445485b31e', 'male', 'image/avatar/admin.jpg', 1, 'admin', '6, lorong ria 2, Taman Bunga Raya', 'Setapak', '53000', '2025-03-31 05:32:33', '2025-04-26 11:29:18'),
(2, '芙宁娜', 'furina@gmail.com', '$2y$10$BOzoIzLfJcssk2i76oMhrOCRDKAMLRKXdfaBqhKb9yi5dxDdPlY46', 'f82661f3e6459d43d4fbe33470a0f6f8', 'Female', '/image/avatar/芙宁娜.jpg', 0, 'user', '', '', '', '2025-04-09 17:05:24', '2025-04-25 21:38:05'),
(15, 'Pandora', 'pandora.va7@gmail.com', '$2y$10$ilpOrXOVfgT7wNIRT5RWmuWcZMhphgdflQOsA58mcLtiqvcauC5/u', '1eb92080e1ec76eaf791c0da86d56796', 'other', '/image/avatar/Pandora.jpg', 1, 'user', '6, lorong ria 2, Taman Bunga Raya', 'Setapak', '53000', '2025-04-19 15:05:20', '2025-04-26 11:15:04'),
(16, 'Jacky', 'jackyloh5775@gmail.com', '$2y$10$p8DjWMaJwFlbTfjXgl1A2elylkSJ15IgfpYB8aactxoU/jROAP28u', 'b107b375dd62c3ca3bb04ba6a5c33505', NULL, 'image/avatar/Jacky.jpg', 1, 'user', '', '', '', '2025-04-21 15:33:14', '2025-04-22 00:30:00'),
(18, '迷迷', 'mimi@gmail.com', '$2y$10$ShB8YQlcy5f.1hhxxEkiG.H5OybjTptC8mMcHEFJcbQ2o5L3Yc3mi', 'cbf0fa8fd4d42e48c2b8986377123be0', 'female', 'image/avatar/迷迷.jpg', 1, 'user', '星核精的家', '翁法罗斯', '银河', '2025-04-24 19:15:08', '2025-04-25 01:51:06'),
(19, 'qisheng', 'qisheng7615@gmail.com', '$2y$10$xo1lkFTMNEn1syAN.lq4I.P9XUTlDSf8vI9yIn1BYme2WhmwjNg.i', 'e87ed381ddf5dc974ce9f75e7b970937', 'male', 'image/avatar/qisheng.jpg', 0, 'user', '18 Jalan Pelangi 20', 'Tanjong Sepat', '42800', '2025-04-25 10:06:34', '2025-04-25 16:12:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `product_color`
--
ALTER TABLE `product_color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_review`
--
ALTER TABLE `product_review`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_size`
--
ALTER TABLE `product_size`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `shopping_cart_fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
