-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2024 at 03:20 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(107, 'Jeralyn Peritos', 'jeralynpreitos@gmail.com', 'jera', '$2y$10$vP1UMak33Y5L/54CLrP9Ge2RUxluRRgGG/HQVQIFFtKgmcOPBcu0W', 'User', '107/1733032557_g1.jpg', 'Active', NULL),
(108, 'Kyle Canete', 'angelcanete86@yahoo.com', 'kyle', '$2y$10$DVkKjZXt2h.5sBRIzCPPw.wirCj5fCUwhSD6pC3keBgGaa7OqE056', 'User', '108/1733061629_demon.jpg', 'Active', NULL),
(109, 'James Arpilang', 'jamesaripliang@gmail.com', 'james', '$2y$10$Y5ozT1Q30qAFY4ToLikUcuOTB1czb41joCopQTY425g1gsWsS4KI6', 'User', '109/1733034198_stroke.jpg', 'Active', NULL),
(110, 'Loren Canete', 'lorencanete@yahoo.com', 'loren', '$2y$10$GrkL3ayhPBZVjAWoA2JxdesxZneJhlCUzxZMQ2v0f6W.fzP8fm7N.', 'User', '110/1733034171_digital.jpg', 'Active', '2024-12-15 14:04:36'),
(116, 'Genesis La Rosa', 'lorencanete@yahoo.com', 'gen', '$2y$10$emIo.h7Ct5ZEOFCcPShQqOYPTCKWob5/ZNW4zvl3NxRaFAtdG4.mG', 'User', '116/1733631671_demon.jpg', 'Active', '2024-12-11 13:57:05'),
(117, 'Jhon Doe', 'jhondoe@gmail.com', 'john', '$2y$10$PU..zvJokxq9bEnwcbLT7evL/RIJYDF0Gt0UKQfGC86JeWfO/RGlC', 'User', '', 'Active', '2024-12-15 14:24:15');

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
(122, 107, 'Demon', 'This is my first upload.', 'Painting', 'files/nyW0NGhM/demon.jpg', '2024-12-01', 'Approved'),
(123, 107, 'Ai Art', 'My first digital art.', 'Digital Art', 'files/fvreO2HO/ai.jpg', '2024-12-01', 'Approved'),
(124, 107, 'Abstract', 'This and abstarat.', 'Abstract', 'files/sJlTIG8S/eternity.jpg', '2024-12-01', 'Approved'),
(125, 108, 'Human Body', 'Lorem ipsum norem.', 'Painting', 'files/ngjSMyHo/body.jpg', '2024-12-01', 'Approved'),
(126, 108, 'Mona Lisacat', 'Monalisa Art Painting wiith garfield.', 'Painting', 'files/GNk6KGzR/cat.jpg', '2024-12-01', 'Approved'),
(127, 108, 'Touch', 'A love language of physical touch.', 'Painting', 'files/RuHYnX5U/hands.jpg', '2024-12-01', 'Approved'),
(128, 108, 'Digital Art', 'This is modern virtual art.', 'Digital Art', 'files/noqFeMZo/contemporary.jpg', '2024-12-01', 'Approved'),
(129, 109, 'Revenge', 'The revenge of the deepest shallow.', 'Sketches', 'files/niK2XCKg/girl.jpg', '2024-12-01', 'Approved'),
(130, 109, 'Insecurities', 'The enemy of one self.', 'Expressionism', 'files/ACyUtJ2w/heat.jpg', '2024-12-01', 'Approved'),
(131, 110, 'The Eyes', 'The eyes that never lies.', 'Expressionism', 'files/YCjzpscg/eyes.jpg', '2024-12-01', 'Approved'),
(132, 110, 'Stroke', 'The seven temptation.', 'Digital Art', 'files/oxBNnUuB/stroke.jpg', '2024-12-01', 'Approved'),
(133, 110, 'Intrusive', 'The forbidden whisper.', 'Painting', 'files/XMVEcN7d/skel.jpg', '2024-12-01', 'Declined'),
(139, 117, 'saasd', 'asd', 'Fantasy', 'files/Enbt5LGy/digital.jpg', '2024-12-08', 'Declined'),
(140, 117, 'asd', 'asd', 'Sketches', 'files/RSL1heEs/demon.jpg', '2024-12-08', 'Declined'),
(141, 116, 'Sample', 'This is for sample', 'Abstract', 'files/0vnDwRNM/cat.jpg', '2024-12-08', 'Approved'),
(142, 116, 'Sample', 'This is for sample', 'Abstract', 'files/8VMSVt72/cat.jpg', '2024-12-08', 'Approved'),
(143, 116, 'sdf', 'sdf', 'Sketches', 'files/XOzghJpK/contemporary.jpg', '2024-12-08', 'Approved'),
(144, 116, 'sdf', 'sdf', 'Sketches', 'files/jWcG0hXL/contemporary.jpg', '2024-12-08', 'Approved'),
(145, 83, 'Jai', 'jai ni', 'Painting', 'files/PNxrpoCe/heat.jpg', '2024-12-08', 'Pending'),
(146, 83, 'Jai', 'jai ni', 'Painting', 'files/2UranoAh/heat.jpg', '2024-12-08', 'Pending');

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
(85, 222, 108),
(86, 222, 116),
(87, 222, 83),
(88, 222, 109),
(89, 222, 117),
(90, 224, 108),
(91, 224, 116),
(92, 224, 109),
(94, 224, 110),
(95, 225, 116);

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
(236, 221, 123),
(237, 221, 124),
(238, 222, 123),
(239, 223, 122),
(240, 223, 123),
(241, 224, 122),
(242, 224, 123),
(243, 224, 124),
(244, 224, 141),
(245, 224, 143),
(246, 224, 142),
(247, 224, 144),
(248, 224, 125),
(249, 224, 126),
(250, 224, 127),
(251, 224, 128),
(252, 224, 129),
(253, 224, 130),
(254, 225, 129),
(255, 225, 130),
(256, 225, 141),
(257, 225, 143),
(258, 225, 144),
(259, 225, 142),
(260, 226, 122),
(261, 227, 125),
(262, 227, 128);

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
(217, 107, 'Collab Exhibit', 'Sharing our masterpiece with diferent art categories.', '2024-12-25', 'Collaborate', 'Cancelled', '2024-12-01 07:23:29'),
(218, 107, 'asd', 'asd', '2024-12-25', 'Solo', 'Declined', NULL),
(219, 107, 'Solo Exhibit', 'asda', '2024-12-01', 'Solo', 'Completed', '2024-12-01 07:53:26'),
(220, 107, 'asd', 'asd', '2024-12-02', 'Solo', 'Cancelled', '2024-12-01 07:54:03'),
(221, 107, 'Collab Exhibit', 'asd', '2024-12-28', 'Collaborate', 'Cancelled', '2024-12-01 08:52:53'),
(222, 107, 'Colllab Exhibit', 'This is an example of a collab exhibit.', '2024-12-25', 'Collaborate', 'Cancelled', NULL),
(223, 107, 'First Exhibit', 'asd', '2024-12-26', 'Solo', 'Cancelled', NULL),
(224, 107, 'Colllab Exhibit', 'asdasd', '2024-12-30', 'Collaborate', 'Cancelled', '2024-12-08 11:14:22'),
(225, 109, 'Sample', 'This is sample', '2024-12-26', 'Collaborate', 'Pending', '2024-12-08 11:50:50'),
(226, 107, 'Solo', 'Sample Vladidaitons', '2024-12-31', 'Solo', 'Pending', '2024-12-08 13:55:43'),
(227, 108, 'First Exhibit', 'kyle', '2024-12-21', 'Solo', 'Accepted', '2024-12-08 15:18:27');

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
(55, 110, NULL, 'Your artwork has been declined and your account is banned for posting artwork for 7 days.', 0, '2024-12-08 06:04:36'),
(56, 117, NULL, 'Your artwork has been approved.', 0, '2024-12-08 06:08:43'),
(57, 117, NULL, 'Your artwork has been declined and your account is banned for posting artwork for 7 days.', 0, '2024-12-08 06:09:18'),
(58, 117, NULL, 'Your artwork has been declined and your account is banned for posting artwork for 7 days.', 0, '2024-12-08 06:24:15'),
(59, 108, 222, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:08:21'),
(60, 116, 222, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:08:21'),
(61, 83, 222, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:08:21'),
(62, 109, 222, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:08:21'),
(63, 117, 222, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:08:21'),
(64, 108, 224, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:11:54'),
(65, 116, 224, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:11:54'),
(66, 109, 224, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:11:54'),
(67, 83, 224, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:11:54'),
(68, 110, 224, 'You have been added as a collaborator to the exhibit: Colllab Exhibit.', 0, '2024-12-08 10:11:54'),
(69, 107, 224, 'Your exhibit status is Accepted', 0, '2024-12-08 10:14:22'),
(70, 116, NULL, 'Your artwork has been approved.', 0, '2024-12-08 10:41:18'),
(71, 116, NULL, 'Your artwork has been approved.', 0, '2024-12-08 10:41:29'),
(72, 116, NULL, 'Your artwork has been approved.', 0, '2024-12-08 10:41:33'),
(73, 116, NULL, 'Your artwork has been approved.', 0, '2024-12-08 10:41:52'),
(74, 116, 225, 'You have been added as a collaborator to the exhibit: Sample.', 0, '2024-12-08 10:49:08'),
(75, 109, 225, 'Your exhibit status is Accepted', 0, '2024-12-08 10:50:50'),
(76, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:36:40'),
(77, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:37:38'),
(78, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:41:45'),
(79, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:51:33'),
(80, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:51:54'),
(81, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:53:33'),
(82, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:54:32'),
(83, 108, 227, 'Your exhibit status is Accepted', 0, '2024-12-08 12:55:27'),
(84, 107, 226, 'Your exhibit status is Accepted', 0, '2024-12-08 12:55:43'),
(85, 108, 227, 'Your exhibit status is Accepted', 0, '2024-12-08 12:57:54'),
(86, 108, 227, 'Your exhibit status is Accepted', 0, '2024-12-08 13:05:40'),
(87, 108, 227, 'Your exhibit status is Accepted', 0, '2024-12-08 14:18:27');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `art_info`
--
ALTER TABLE `art_info`
  MODIFY `a_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=147;

--
-- AUTO_INCREMENT for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  MODIFY `collab_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  MODIFY `exbtArwork_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;

--
-- AUTO_INCREMENT for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  MODIFY `exbt_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=228;

--
-- AUTO_INCREMENT for table `favorite`
--
ALTER TABLE `favorite`
  MODIFY `fav_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `saved`
--
ALTER TABLE `saved`
  MODIFY `save_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
