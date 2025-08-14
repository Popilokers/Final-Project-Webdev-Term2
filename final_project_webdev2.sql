-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 03:57 PM
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
-- Database: `final_project_webdev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`) VALUES
(1, 'dank'),
(2, 'funny');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `category_id`, `title`, `image`, `caption`, `updated_at`, `uploaded_at`) VALUES
(30, 1, 'a', 'uploads\\To Do.png', 'a', '2025-08-14 10:07:21', '2025-08-14 10:07:21'),
(31, 1, 'is that a sword?', 'uploads\\MIHAWK UPSCALE.png', 'MIHAWK UPSCALE', '2025-08-14 10:19:57', '2025-08-14 10:19:57'),
(32, 1, 'are you chopping onions?', 'uploads\\MIHAWK UPSCALE.png', 'with a knife?', '2025-08-14 10:21:30', '2025-08-14 10:21:30'),
(33, 1, 'king arthur?', 'uploads\\MIHAWK UPSCALE.png', 'EXCALIBUR?', '2025-08-14 10:21:53', '2025-08-14 10:21:53'),
(34, 1, 'three sword style?', 'uploads\\MIHAWK UPSCALE.png', 'SWORD?!!', '2025-08-14 10:22:35', '2025-08-14 10:22:35'),
(35, 1, 'oden?', 'uploads\\MIHAWK UPSCALE.png', 'TWO SWORDS??', '2025-08-14 10:22:55', '2025-08-14 10:22:55'),
(36, 1, 'ace was named after what?', 'uploads\\MIHAWK UPSCALE.png', 'ROGERS SWORD?', '2025-08-14 10:23:22', '2025-08-14 10:23:22'),
(37, 1, 'napoleon turns into a what?', 'uploads\\MIHAWK UPSCALE.png', 'A SWORD?!?!', '2025-08-14 10:24:14', '2025-08-14 10:24:14'),
(38, 1, 'whats seven&#39;s weapon called?', 'uploads\\MIHAWK UPSCALE.png', 'thousand demon DAGGER???!', '2025-08-14 10:24:50', '2025-08-14 10:24:50'),
(39, 1, 'POV don krieg', 'uploads\\MIHAWK UPSCALE.png', 'you woke me from my nap', '2025-08-14 10:25:48', '2025-08-14 10:25:48'),
(40, 1, 'did i just see mihawk?', 'uploads\\VISTA UPSCALE.jpg', 'cmere boy', '2025-08-14 10:33:26', '2025-08-14 10:33:26'),
(41, 1, 'DID SOMEONE SAY STREET', 'uploads\\DEKU UPSCALE.jpg', 'SMAASHH', '2025-08-14 10:34:19', '2025-08-14 10:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `post_interactions`
--

CREATE TABLE `post_interactions` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_fav` tinyint(1) NOT NULL,
  `is_liked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `type`, `username`, `password`, `email`) VALUES
(1, 'admin', 'im_admin', 'admin', 'admin@admin.php');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `post` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `post_interactions`
--
ALTER TABLE `post_interactions`
  ADD UNIQUE KEY `interaction_id` (`post_id`,`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
