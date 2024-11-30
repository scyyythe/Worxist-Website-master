-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2024 at 05:24 PM
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
-- Database: `gallery_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `u_id` int(100) NOT NULL,
  `u_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `u_type` varchar(50) NOT NULL,
  `profile` varchar(100) NOT NULL,
  `u_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`u_id`, `u_name`, `email`, `username`, `password`, `u_type`, `profile`, `u_status`) VALUES
(82, 'Jeralyn Peritos', 'jeralynpreitos@gmail.com', 'jera', '$2y$10$rn70sVxqhjRMS87rQ7uoJevSLdOWGFr6VlLDK.8LEW6e8vBj2Coj.', 'User', '82/1732025894_eyes.jpg', 'Active'),
(83, 'Jamaica Anuba', 'jamaicaanuba@gmail.com', 'jai', '$2y$10$HIjyKTX/TVqQVg7G.ymNo.5qn3OE4zUIh3M.SZvi8FeCbis2.wa.a', 'Admin', '', 'Active'),
(84, 'Kyle Canete', 'kylecanete@gmail.om', 'kyle', '$2y$10$IZETVl5oO2fVJaJqqNnLaOSY5TdZzs1nFlK7jsN3MX.ZncvphdYXa', 'User', '84/1732026167_girl(1).jpg', 'Archived'),
(85, 'Angel Canete', 'angelcanete86@yahoo.com', 'angel', '$2y$10$yNMFQlS4nUGtc6rBQQDuru3rpM0zTwy14M5EQTAt5LxsmX8LJKJSO', 'Organizer', '85/1732187862_lips.jpg', 'Active'),
(92, 'Kyle Canete', 'kylecanete@gmail.om', 'kyle', '$2y$10$7Okiy6ksSVhCXZqVzake4e2T669XQs42buCobwZCjvZQR.V21vb3K', 'User', '', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `art_info`
--

CREATE TABLE `art_info` (
  `a_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(50) NOT NULL,
  `file` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `a_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collab_exhibit`
--

CREATE TABLE `collab_exhibit` (
  `collab_id` int(100) NOT NULL,
  `exbt_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_artworks`
--

CREATE TABLE `exhibit_artworks` (
  `exbtArwork_id` int(100) NOT NULL,
  `exbt_id` int(100) NOT NULL,
  `a_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_tbl`
--

CREATE TABLE `exhibit_tbl` (
  `exbt_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `exbt_title` varchar(100) NOT NULL,
  `exbt_descrip` text NOT NULL,
  `exbt_date` date NOT NULL,
  `exbt_type` varchar(20) NOT NULL,
  `exbt_status` varchar(20) NOT NULL,
  `accepted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `fav_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `a_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `exbt_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `save_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`u_id`);

--
-- Indexes for table `art_info`
--
ALTER TABLE `art_info`
  ADD PRIMARY KEY (`a_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  ADD PRIMARY KEY (`collab_id`),
  ADD KEY `exbt_id` (`exbt_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `a_id` (`a_id`);

--
-- Indexes for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  ADD PRIMARY KEY (`exbtArwork_id`),
  ADD KEY `a_id` (`a_id`),
  ADD KEY `exbt_id` (`exbt_id`);

--
-- Indexes for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  ADD PRIMARY KEY (`exbt_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`fav_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `a_id` (`a_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `a_id` (`a_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `exbt_id` (`exbt_id`);

--
-- Indexes for table `saved`
--
ALTER TABLE `saved`
  ADD PRIMARY KEY (`save_id`),
  ADD KEY `u_id` (`u_id`),
  ADD KEY `a_id` (`a_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `art_info`
--
ALTER TABLE `art_info`
  MODIFY `a_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  MODIFY `collab_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  MODIFY `exbtArwork_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  MODIFY `exbt_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `fav_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `saved`
--
ALTER TABLE `saved`
  MODIFY `save_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `art_info`
--
ALTER TABLE `art_info`
  ADD CONSTRAINT `art_info_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`);

--
-- Constraints for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  ADD CONSTRAINT `collab_exhibit_ibfk_1` FOREIGN KEY (`exbt_id`) REFERENCES `exhibit_tbl` (`exbt_id`),
  ADD CONSTRAINT `collab_exhibit_ibfk_2` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`);

--
-- Constraints for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  ADD CONSTRAINT `exhibit_artworks_ibfk_1` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`),
  ADD CONSTRAINT `exhibit_artworks_ibfk_2` FOREIGN KEY (`exbt_id`) REFERENCES `exhibit_tbl` (`exbt_id`);

--
-- Constraints for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  ADD CONSTRAINT `exhibit_tbl_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`);

--
-- Constraints for table `favorite`
--
ALTER TABLE `favorite`
  ADD CONSTRAINT `favorite_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`exbt_id`) REFERENCES `exhibit_tbl` (`exbt_id`);

--
-- Constraints for table `saved`
--
ALTER TABLE `saved`
  ADD CONSTRAINT `saved_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `saved_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
