-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 03:49 PM
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
  `u_status` varchar(50) NOT NULL,
  `ban_end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`u_id`, `u_name`, `email`, `username`, `password`, `u_type`, `profile`, `u_status`, `ban_end_date`) VALUES
(83, 'Jamaica Anuba', 'jamaicaanuba@gmail.com', 'jai', '$2y$10$HIjyKTX/TVqQVg7G.ymNo.5qn3OE4zUIh3M.SZvi8FeCbis2.wa.a', 'Admin', '', 'Active', NULL),
(85, 'Angel Canete', 'angelcanete86@yahoo.com', 'angel', '$2y$10$yNMFQlS4nUGtc6rBQQDuru3rpM0zTwy14M5EQTAt5LxsmX8LJKJSO', 'Organizer', '85/1732187862_lips.jpg', 'Active', NULL),
(114, 'Kyle Canete', 'kylecanete@gmail.om', 'kyle', '$2y$10$Oh8BX/WWbv07ktPTLTd4y.qbdBnj/F3nLxl3FCafTs9g.j43KoOzS', 'User', '114/1734097297_lips.jpg', 'Active', NULL),
(115, 'Jeralyn Peritos', 'jeralynpreitos@gmail.com', 'jeralyn', '$2y$10$Gnzz3zvzwD4FffrGUAgazObBKm6V6ieKkLMOc7Pnl3DQ6PjArb0zC', 'User', '115/1734098285_photography.jpg', 'Active', NULL),
(117, 'James Arpilang', 'jamesaripliang@gmail.com', 'james', '$2y$10$TxYFCuEEAa.j6HnHYxFPn.0cHbfVAqvWzU5Bc801sPBhK3RyLe.KK', 'User', '117/1734098534_contemporary.jpg', 'Active', NULL),
(119, 'John Dave Laparan', 'jhondoe@gmail.com', 'dave', '$2y$10$0hrlyX7rn9g.XKdtivXVkuTAFLgsEwP2tWhFqwD6Me8fKdgfMkbRC', 'User', '119/1734097570_magma face.jpg', 'Active', NULL),
(120, 'Glendon Dave Taraya', 'glendondavetaraya@gmail.com', 'glendon', '$2y$10$/9HeDYWwLRy66QMX4oBWWe68H55Jo5zfxru.j5nyxiNPOWIsFGM6K', 'User', '120/1734099155_photography.jpg', 'Active', NULL);

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

--
-- Dumping data for table `art_info`
--

INSERT INTO `art_info` (`a_id`, `u_id`, `title`, `description`, `category`, `file`, `date`, `a_status`) VALUES
(153, 114, 'Digital Art', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales sagittis sagittis. Donec nec lorem dictum, ornare magna posuere, tristique lectus', 'Digital Art', 'files/KRD80bIc/ai.jpg', '2024-12-13', 'Approved'),
(154, 114, 'The Art of Touch', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales sagittis sagittis. Donec nec lorem dictum, ornare magna posuere, tristique lectus.', 'Painting', 'files/KTJnBELE/hands.jpg', '2024-12-13', 'Approved'),
(155, 114, 'Sculpture', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales sagittis sagittis. Donec nec lorem dictum, ornare magna posuere, tristique lectus. Proin vel ipsum pellentesque, ullamcorper ex feugiat, elementum lectus. Suspendisse sed mollis massa, ut elementum', 'Sculpture', 'files/d4LPgZ8F/sculpture.jpg', '2024-12-13', 'Approved'),
(156, 119, 'Expressionism', 'Cras blandit convallis orci a elementum. In tempus finibus nisi, quis mollis eros dignissim eget. Cras in convallis mi. Nulla imperdiet interdum nisl, a pellentesque ex placerat id. ', 'Expressionism', 'files/wkQ5zwRC/lips.jpg', '2024-12-13', 'Pending'),
(158, 119, 'Autumn', 'Cras blandit convallis orci a elementum. In tempus finibus nisi, quis mollis eros dignissim eget. Cras in convallis mi. Nulla imperdiet interdum nisl, a pellentesque ex placerat id. ', 'Painting', 'files/dUHb2c5S/color essence of autumn.jpg', '2024-12-13', 'Approved'),
(159, 119, 'Girl', 'Cras blandit convallis orci a elementum. In tempus finibus nisi, quis mollis eros dignissim eget. Cras in convallis mi. Nulla imperdiet interdum nisl, a pellentesque ex placerat id. ', 'Sketches', 'files/FCRF5VmC/sketch.jpg', '2024-12-13', 'Approved'),
(160, 115, 'Beauty', 'Cras blandit convallis orci a elementum. In tempus finibus nisi, quis mollis eros dignissim eget. Cras in convallis mi. Nulla imperdiet interdum nisl, a pellentesque ex placerat id. Cras blandit convallis orci a elementum. In tempus finibus nisi, quis mollis eros dignissim eget. Cras in convallis mi. Nulla imperdiet interdum nisl, a pellentesque ex placerat id. ', 'Abstract', 'files/Yel9eJf2/beauty.jpg', '2024-12-13', 'Pending'),
(161, 115, 'Photo Graphy', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed posuere libero sed rhoncus rutrum. Nulla cursus ut metus vitae ultrices. Pellentesque aliquam urna malesuada risus varius, eu dapibus urna ultricies. Nullam laoreet, tortor a finibus finibus, lectus turpis sodales sem, in efficitur orci dui at justo. ', 'Photography', 'files/YOWKqlyL/photography.jpg', '2024-12-13', 'Approved'),
(162, 115, 'Invisible College', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed posuere libero sed rhoncus rutrum. Nulla cursus ut metus vitae ultrices. Pellentesque aliquam urna malesuada risus varius, eu dapibus urna ultricies.', 'Contemporary Art', 'files/LNzb6wx1/contemporary.jpg', '2024-12-13', 'Approved'),
(163, 115, 'Abstract Art', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed posuere libero sed rhoncus rutrum. Nulla cursus ut metus vitae ultrices. Pellentesque aliquam urna malesuada risus varius, eu dapibus urna ultricies. Nullam laoreet, tortor a finibus finibus, lectus turpis sodales sem, in efficitur orci dui at justo. ', 'Abstract', 'files/gdOoJnhy/abstract.jpg', '2024-12-13', 'Approved'),
(164, 115, 'Abstract Art', 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Sed posuere libero sed rhoncus rutrum. Nulla cursus ut metus vitae ultrices. Pellentesque aliquam urna malesuada risus varius, eu dapibus urna ultricies. Nullam laoreet, tortor a finibus finibus, lectus turpis sodales sem, in efficitur orci dui at justo. ', 'Abstract', 'files/1siBQbey/abstract.jpg', '2024-12-13', 'Pending'),
(165, 117, 'Hand Sculpture', 'Nam at lobortis dolor. Quisque enim libero, pulvinar sit amet dui ut, ullamcorper lobortis ligula. Etiam arcu leo, aliquam dapibus augue vel, pellentesque laoreet tellus.', 'Sculpture', 'files/YKty4ntC/sculpture-hand.jpg', '2024-12-13', 'Approved'),
(166, 117, 'Magma Face', 'Nam at lobortis dolor. Quisque enim libero, pulvinar sit amet dui ut, ullamcorper lobortis ligula. Etiam arcu leo, aliquam dapibus augue vel, pellentesque laoreet tellus.', 'Sculpture', 'files/hw1GI50K/magma face.jpg', '2024-12-13', 'Approved'),
(167, 120, 'Portrait', 'Nulla pharetra diam et leo ornare, a varius dui lacinia. Duis dictum augue eu consequat luctus. Suspendisse potenti. In pulvinar sed sapien ac viverra. Nunc ut tincidunt dolor. Nam sed magna eu diam tincidunt viverra at sit amet arcu. ', 'Portrait', 'files/C4VYVuHn/portrait.jpg', '2024-12-13', 'Approved'),
(168, 120, 'Mental Helath', 'Nulla pharetra diam et leo ornare, a varius dui lacinia. Duis dictum augue eu consequat luctus. Suspendisse potenti. In pulvinar sed sapien ac viverra. Nunc ut tincidunt dolor. Nam sed magna eu diam tincidunt viverra at sit amet arcu. ', 'Photography', 'files/7A05b0Ew/mental health.jpg', '2024-12-13', 'Pending'),
(169, 120, 'Digtal Art', 'Nulla pharetra diam et leo ornare, a varius dui lacinia. Duis dictum augue eu consequat luctus. Suspendisse potenti. In pulvinar sed sapien ac viverra. Nunc ut tincidunt dolor. Nam sed magna eu diam tincidunt viverra at sit amet arcu. ', 'Digital Art', 'files/C8Aqk4QD/digtialart.jpg', '2024-12-13', 'Approved'),
(170, 114, 'Collage Art', 'Nulla pharetra diam et leo ornare, a varius dui lacinia. Duis dictum augue eu consequat luctus. Suspendisse potenti. In pulvinar sed sapien ac viverra. Nunc ut tincidunt dolor. Nam sed magna eu diam tincidunt viverra at sit amet arcu. ', 'Crafts', 'files/kvozyq9G/Collage Art Row Boat on Water.jpeg', '2024-12-13', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `collab_exhibit`
--

CREATE TABLE `collab_exhibit` (
  `collab_id` int(100) NOT NULL,
  `exbt_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collab_exhibit`
--

INSERT INTO `collab_exhibit` (`collab_id`, `exbt_id`, `u_id`) VALUES
(109, 265, 115),
(110, 265, 117),
(111, 265, 120);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) DEFAULT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`comment_id`, `u_id`, `a_id`, `content`) VALUES
(42, 120, 153, 'Nice'),
(43, 114, 153, 'First Upload'),
(44, 114, 153, 'Sample Comment');

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_artworks`
--

CREATE TABLE `exhibit_artworks` (
  `exbtArwork_id` int(100) NOT NULL,
  `exbt_id` int(100) NOT NULL,
  `a_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exhibit_artworks`
--

INSERT INTO `exhibit_artworks` (`exbtArwork_id`, `exbt_id`, `a_id`) VALUES
(323, 265, 153),
(324, 265, 154),
(325, 265, 155),
(326, 265, 170),
(327, 265, 167),
(328, 265, 169),
(329, 265, 165),
(330, 265, 166),
(331, 266, 165),
(332, 266, 166),
(333, 265, 161),
(334, 265, 162),
(335, 265, 163),
(336, 267, 158),
(337, 267, 159);

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

--
-- Dumping data for table `exhibit_tbl`
--

INSERT INTO `exhibit_tbl` (`exbt_id`, `u_id`, `exbt_title`, `exbt_descrip`, `exbt_date`, `exbt_type`, `exbt_status`, `accepted_at`) VALUES
(265, 114, '\"Beyond Boundaries: A Journey Through Art\"', ' \"Beyond Boundaries: A Journey Through Art\" explores the limitless power of creative expression and the diverse paths artists take to transcend conventional limitations. This exhibit features a variety of mediums, from classical oil paintings to modern digital art, showcasing how art continuously evolves and challenges our perceptions. Visitors will be immersed in the stories behind each piece, discovering the passion, struggles, and triumphs of the artists. This exhibit encourages viewers to step outside their comfort zones and embrace the transformative power of art.', '2024-12-14', 'Collaborate', 'Accepted', '2024-12-13 15:44:07'),
(266, 117, 'Solo Exhibit', ' \"Beyond Boundaries: A Journey Through Art\" explores the limitless power of creative expression and the diverse paths artists take to transcend conventional limitations. This exhibit features a variety of mediums, from classical oil paintings to modern digital art, showcasing how art continuously ', '2024-12-14', 'Solo', 'Pending', NULL),
(267, 119, 'Solo Exhibit', 'Nulla pharetra diam et leo ornare, a varius dui lacinia. Duis dictum augue eu consequat luctus. Suspendisse potenti. In pulvinar sed sapien ac viverra. Nunc ut tincidunt dolor. Nam sed magna eu diam tincidunt viverra at sit amet arcu. Nulla faucibus sit amet ex et rhoncus. Phasellus quis t', '2024-12-14', 'Solo', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `fav_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `u_id`, `a_id`) VALUES
(127, 115, 153),
(128, 115, 159),
(129, 115, 155),
(131, 117, 153),
(132, 117, 163),
(133, 117, 159),
(134, 117, 162),
(135, 117, 166),
(137, 120, 154),
(138, 120, 153),
(139, 114, 167),
(140, 114, 161);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `u_id` int(100) NOT NULL,
  `exbt_id` int(100) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `u_id`, `exbt_id`, `message`, `is_read`, `created_at`) VALUES
(147, 114, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:45:25'),
(148, 114, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:45:28'),
(149, 114, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:45:33'),
(150, 119, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:52:19'),
(151, 119, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:52:23'),
(152, 115, NULL, 'Your artwork has been approved.', 0, '2024-12-13 13:57:45'),
(153, 115, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:00:33'),
(154, 117, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:10:52'),
(155, 114, NULL, 'You have a new follower!', 0, '2024-12-13 14:11:15'),
(156, 120, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:19:43'),
(157, 120, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:19:43'),
(158, 117, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:19:49'),
(159, 115, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:19:56'),
(160, 120, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:20:06'),
(161, 114, NULL, 'Your artwork has been approved.', 0, '2024-12-13 14:22:14'),
(162, 115, 265, 'You have been added as a collaborator to the exhibit: \"Beyond Boundaries: A Journey Through Art\".', 0, '2024-12-13 14:29:01'),
(163, 117, 265, 'You have been added as a collaborator to the exhibit: \"Beyond Boundaries: A Journey Through Art\".', 0, '2024-12-13 14:29:01'),
(164, 120, 265, 'You have been added as a collaborator to the exhibit: \"Beyond Boundaries: A Journey Through Art\".', 0, '2024-12-13 14:29:01'),
(165, 114, 265, 'Your exhibit status is Accepted', 0, '2024-12-13 14:44:07');

-- --------------------------------------------------------

--
-- Table structure for table `saved`
--

CREATE TABLE `saved` (
  `save_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saved`
--

INSERT INTO `saved` (`save_id`, `u_id`, `a_id`) VALUES
(45, 117, 159);

-- --------------------------------------------------------

--
-- Table structure for table `user_follows`
--

CREATE TABLE `user_follows` (
  `follow_id` int(11) NOT NULL,
  `follower_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `follow_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_follows`
--

INSERT INTO `user_follows` (`follow_id`, `follower_id`, `following_id`, `follow_date`) VALUES
(9, 117, 114, '2024-12-13 14:11:15');

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
  ADD KEY `comment_ibfk_2` (`a_id`);

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
-- Indexes for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`follow_id`),
  ADD KEY `follower_id` (`follower_id`),
  ADD KEY `following_id` (`following_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `art_info`
--
ALTER TABLE `art_info`
  MODIFY `a_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  MODIFY `collab_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  MODIFY `exbtArwork_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=338;

--
-- AUTO_INCREMENT for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  MODIFY `exbt_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `fav_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `saved`
--
ALTER TABLE `saved`
  MODIFY `save_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `user_follows`
--
ALTER TABLE `user_follows`
  MODIFY `follow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `favorite_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`) ON DELETE SET NULL;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`) ON DELETE SET NULL;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`exbt_id`) REFERENCES `exhibit_tbl` (`exbt_id`) ON DELETE SET NULL;

--
-- Constraints for table `saved`
--
ALTER TABLE `saved`
  ADD CONSTRAINT `saved_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `saved_ibfk_2` FOREIGN KEY (`a_id`) REFERENCES `art_info` (`a_id`) ON DELETE SET NULL;

--
-- Constraints for table `user_follows`
--
ALTER TABLE `user_follows`
  ADD CONSTRAINT `user_follows_ibfk_1` FOREIGN KEY (`follower_id`) REFERENCES `accounts` (`u_id`),
  ADD CONSTRAINT `user_follows_ibfk_2` FOREIGN KEY (`following_id`) REFERENCES `accounts` (`u_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
