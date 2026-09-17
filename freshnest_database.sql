-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Sep 14, 2026 at 07:45 PM
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
-- Database: `project_data1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Norah', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`) VALUES
(1, 1),
(2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `product_id`, `quantity`) VALUES
(16, 2, 2, 7),
(17, 2, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Living Room'),
(2, 'Bedroom Furniture'),
(3, 'Kids Bedroom Furniture'),
(4, 'Dining Room Furniture');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `message_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `date_sent` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`message_id`, `name`, `email`, `message`, `date_sent`) VALUES
(1, '', '', '', '2026-04-20'),
(2, '', '', '', '2026-04-20'),
(3, 'YOUSEF', 'capt@gmail.com', 'hello', NULL),
(4, 'Dana', 'danaaldabas@gmail.com', 'aaaa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `product_id`) VALUES
(7, 4, 2),
(8, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notify_requests`
--

CREATE TABLE `notify_requests` (
  `notify_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notify_requests`
--

INSERT INTO `notify_requests` (`notify_id`, `product_id`, `email`, `created_at`) VALUES
(1, 3, 'af@gmail.com', '2026-05-08 12:15:13');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`) VALUES
(4, 1, '2026-04-19', 698.00),
(5, 1, '2026-04-19', 698.00),
(6, 1, '2026-04-19', 698.00),
(7, 1, '2026-04-19', 698.00),
(8, 1, '2026-04-19', 698.00),
(9, 1, '2026-04-19', 1188.00),
(10, 1, '2026-04-26', 943.00),
(11, 1, '2026-05-04', 8490.00),
(12, 1, '2026-05-04', 189.00),
(13, 1, '2026-05-05', 189.00),
(14, 1, '2026-05-05', 434.00),
(15, 1, '2026-05-05', 628.00),
(16, 1, '2026-05-05', 428.00),
(17, 1, '2026-05-05', 400.00),
(18, 1, '2026-05-08', 1715.00),
(19, 1, '2026-05-08', 756.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 11, 1, 7, 400.00),
(2, 11, 3, 2, 245.00),
(3, 12, 2, 1, 189.00),
(4, 13, 2, 1, 189.00),
(5, 14, 2, 3, 189.00),
(6, 14, 3, 4, 245.00),
(7, 15, 4, 4, 199.00),
(8, 15, 5, 3, 429.00),
(9, 16, 6, 1, 129.00),
(10, 16, 7, 1, 299.00),
(11, 17, 1, 1, 400.00),
(12, 18, 3, 7, 245.00),
(13, 19, 2, 4, 189.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `product_condition` varchar(50) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `image`, `product_condition`, `category_id`, `stock`, `description`) VALUES
(1, 'Mid-Century Sofa', 400.00, 'images/sofa-details.jpg', 'Refurbished', 1, 6, 'A stylish mid-century inspired sofa built with a durable wooden frame and premium upholstery fabric. This refurbished piece has been professionally restored to ensure comfort and long-lasting quality while preserving its classic aesthetic appeal.'),
(2, 'Vintage Coffee Table', 189.00, 'images/coffee-table-details.jpg', 'Like New', 1, 3, 'A charming coffee table with a warm finish and classic design. It is perfect for serving drinks, displaying books, or completing your living room style.'),
(3, 'Oak Bookshelf', 245.00, 'images/bookshelf-details.jpg', 'Pre-loved', 1, 0, 'A practical oak bookshelf with a natural finish and generous storage space. Ideal for books, plants, and decorative pieces in any modern home.'),
(4, 'Green Armchair', 199.00, 'images/armchair-details.jpg', 'Refurbished', 1, 7, 'A cozy armchair with a modern curved shape and comfortable seat. This refurbished piece is ideal for reading corners, bedrooms, and stylish living spaces.'),
(5, 'Oak Bed Frame', 429.00, 'images/bed-details.jpg', 'Refurbished', 2, 7, 'A clean and elegant bed frame designed for comfort and durability. Its soft curves and neutral tone make it a perfect centerpiece for a relaxing bedroom.'),
(6, 'Wooden Nightstand', 129.00, 'images/nightstand-details.jpg', 'Like New', 2, 7, 'A compact wooden nightstand with practical drawers and a warm natural finish. Perfect for keeping bedside essentials organized while adding charm to your room.'),
(7, 'Classic Dresser', 299.00, 'images/dresser-details.jpg', 'Pre-loved', 2, 4, 'A spacious dresser with a clean design and multiple drawers for storage. This pre-loved piece is practical, stylish, and suitable for any bedroom.'),
(8, 'Study Desk for Kids', 159.00, 'images/study-desk-details.jfif', 'Like New', 3, 6, 'A simple and useful desk for children\'s study areas. It provides a comfortable space for reading, drawing, and homework with a clean modern look.'),
(9, 'Playroom Furniture Set', 279.00, 'images/playroom-set-details.jpg', 'Pre-loved', 3, 2, 'A playful furniture set designed for children’s rooms and activity spaces. It brings storage, comfort, and a cheerful look to any playroom.'),
(10, 'Kids Bed', 319.00, 'images/kids-bed-details.jpg', 'Refurbished', 3, 4, 'A soft and safe children’s bed designed with comfort in mind. Its simple design and gentle finish make it perfect for a calm and cozy bedroom.'),
(11, 'Kids Wardrobe', 249.00, 'images/kids-wardrobe-details.jfif', 'Like New', 3, 7, 'A bright and practical wardrobe designed for children\'s clothing and toys. It provides useful storage while keeping the bedroom neat and organized.'),
(12, 'Dining Table', 399.00, 'images/dining-table-details.webp', 'Refurbished', 4, 3, 'A beautiful dining table with a clean modern design and sturdy base. It is ideal for family meals, gatherings, and stylish dining spaces.'),
(13, 'Serving Cart', 179.00, 'images/serving-cart-details.webp', 'Like New', 4, 5, 'A practical serving cart with shelves and wheels for easy movement. It is great for kitchens, dining rooms, and stylish home organization.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`) VALUES
(1, 'Norah', 'norah@gmail.com', '12345', '0564182050'),
(2, 'rehab alshehri', 'rehab@gmail.com', '1234', '0556789816'),
(3, 'Danah Aldbas', 'danahaldabas@gmail.com', '1234', '599610722'),
(4, 'Safa ALSALEM', 'Sa2@gmail.com', '12345678', '0555678900'),
(6, 'af', 'af@gmail.com', '0000', '0586958959'),
(7, 'sara', 'sara@gmail.com', 'sara@gmail.com', '0545448548'),
(8, 'dana', 'danah@gmail.com', '$2y$10$jWnJfj7SbtL7JwpKQBO8GOVZFOPQeehvXTrgB.eJJQeF5Ngpi9GbG', '0599999999'),
(9, 'Danah', 'danaaldabas@gmail.com', '$2y$10$zBB1nK06UkmMkkvxGua66u1FBQV51YfW1ZZygbfnMCCMZB6E06iSW', '0599610722');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notify_requests`
--
ALTER TABLE `notify_requests`
  ADD PRIMARY KEY (`notify_id`),
  ADD UNIQUE KEY `unique_notify` (`product_id`,`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notify_requests`
--
ALTER TABLE `notify_requests`
  MODIFY `notify_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
