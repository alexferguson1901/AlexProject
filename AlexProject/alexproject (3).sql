-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 30, 2025 at 06:01 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alexproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `coast`
--

DROP TABLE IF EXISTS `coast`;
CREATE TABLE IF NOT EXISTS `coast` (
  `user` int NOT NULL,
  `reviews` int NOT NULL,
  `destinations` int NOT NULL,
  `tips` int NOT NULL,
  `photos` int NOT NULL,
  `activities` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `comment_type` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_name`, `comment_type`, `comment`, `created_at`, `avatar_path`) VALUES
(1, 'alex', 'tip', 'I recommend to travel with a backpack and not a suitcase', '2025-04-30 01:30:37', NULL),
(2, 'alex', 'tip', 'I recommend to travel with a backpack and not a suitcase', '2025-04-30 01:30:42', NULL),
(3, 'viv', 'tip', 'You should get goggles and go snorkeling, there are so many cool and pretty fish!', '2025-04-30 02:04:56', NULL),
(4, 'J', 'experience', 'The food tastes amazing wherever you go! Check out the food stands', '2025-04-30 02:16:41', NULL),
(5, 'alex', 'tip', 'Rent a paddleboard', '2025-04-30 05:18:08', 'avatars/Alex_Ferguson.jpg'),
(6, 'Lillian', 'tip', 'Rent a scooter so you can visit more of the islands', '2025-04-30 05:20:36', 'avatars/Lillian_Yudari.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `destination_id` int NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `destinations`
--

INSERT INTO `destinations` (`destination_id`) VALUES
(0),
(0),
(0),
(0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `rating` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_name`, `rating`, `comment`, `created_at`, `avatar_path`) VALUES
(1, 'alex', 4, 'lovely place thank you for the suggestion', '2024-12-09 16:20:48', NULL),
(2, 'viv', 5, 'Thanks for the info', '2024-12-09 21:51:04', NULL),
(3, 'J', 4, 'Thanks for the information will be booking soon!', '2024-12-10 12:21:05', NULL),
(4, 'Aaron', 4, 'I love Indonesia. It is too sunny for me', '2024-12-11 09:55:15', NULL),
(5, 'Lillian', 3, 'Thanks for the recommendations! Booking flights now!', '2025-04-30 02:24:38', NULL),
(6, 'alex', 1, 'Hotels are so cheap!', '2025-04-30 05:54:13', 'avatars/Alex_Ferguson.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `saved_destinations`
--

DROP TABLE IF EXISTS `saved_destinations`;
CREATE TABLE IF NOT EXISTS `saved_destinations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `destination_name` varchar(255) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `saved_destinations`
--

INSERT INTO `saved_destinations` (`id`, `username`, `destination_name`, `description`) VALUES
(2, 'Alex Ferguson', 'Legian Beach', 'Legian Beach is a lively destination known for its golden sand, beautiful sunsets, and great surfing waves. Located between Kuta and Seminyak, it offers a perfect mix of relaxation and vibrant nightlife, with beachside cafes, shops, and entertainment options.\r\n\r\nHere are some activity ideas to do near the area:\r\nSurfing: Legian Beach is famous for its consistent waves, making it perfect for surfers of all levels.\r\nBeach Clubs: Enjoy relaxing at beachfront cafes and bars with live music, perfect for a sunset view.\r\nShopping: Explore the nearby Legian street markets for souvenirs, clothes, and local handicrafts.\r\nMassage and Spas: Many spas are located along Legian Beach for a relaxing treatment after a day at the beach.\r\nNightlife: The Legian area has a vibrant nightlife with bars, clubs, and restaurants.'),
(3, 'Alex Ferguson', 'Legian Beach', 'Legian Beach is a lively destination known for its golden sand, beautiful sunsets, and great surfing waves. Located between Kuta and Seminyak, it offers a perfect mix of relaxation and vibrant nightlife, with beachside cafes, shops, and entertainment options.\r\n\r\nHere are some activity ideas to do near the area:\r\nSurfing: Legian Beach is famous for its consistent waves, making it perfect for surfers of all levels.\r\nBeach Clubs: Enjoy relaxing at beachfront cafes and bars with live music, perfect for a sunset view.\r\nShopping: Explore the nearby Legian street markets for souvenirs, clothes, and local handicrafts.\r\nMassage and Spas: Many spas are located along Legian Beach for a relaxing treatment after a day at the beach.\r\nNightlife: The Legian area has a vibrant nightlife with bars, clubs, and restaurants.'),
(4, 'Alex Ferguson', 'Padma Beach', 'Padma Beach is a peaceful stretch of sand located in Legian, Bali. Known for its calm waters and beautiful sunset views, it’s perfect for swimming, sunbathing, and leisurely walks along the shore. The beach is also home to upscale resorts, making it a relaxing escape with easy access to local amenities.\r\nHere are some activity ideas to do near the area:\r\nSurfing: Like Legian, Padma Beach also offers great surfing conditions.\r\nRelaxing on the Beach: Less crowded than other beaches.\r\nWalks and Cycling: Rent a bicycle along the beach path.\r\nSpa and Wellness: Enjoy luxury spa facilities nearby.');

-- --------------------------------------------------------

--
-- Table structure for table `tips`
--

DROP TABLE IF EXISTS `tips`;
CREATE TABLE IF NOT EXISTS `tips` (
  `tips` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `users` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_path` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`users`, `email`, `username`, `password`, `avatar_path`) VALUES
('', 'g00399754@atu.ie', 'Alex Ferguson', '$2y$10$aI9lwuiLMF2pTQyoVKAFeuau/mU1qaEr36i1lcC/kk8vJr0PNsyNy', 'avatars/Alex_Ferguson.jpg'),
('', 'vivienpunch@gmail.com', 'Vivien punch', '$2y$10$M281MaSOrF4cEBLe6LOyouhl4ypItUKL9LRiK15Z.m46PZ1w4j7WC', NULL),
('', 'jd@gmail.com', 'jess desbrus', '$2y$10$RBKWn1iU0UP.QGpbEs3Tq.C9cQ2.GAlWUvnqKKP9rHeuiMqAXdjxW', NULL),
('', 'lillian@yahoo.ie', 'Lillian Yudari', '$2y$10$S8wHpGTfOfalbOQnvzLNjOagt8Ih/WBy1FI6hcLZ0cDrd2pXxWaGq', '0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
