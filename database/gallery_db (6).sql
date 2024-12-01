-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2024 at 03:48 PM
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
(83, 'Jamaica Anuba', 'jamaicaanuba@gmail.com', 'jai', '$2y$10$HIjyKTX/TVqQVg7G.ymNo.5qn3OE4zUIh3M.SZvi8FeCbis2.wa.a', 'Admin', '', 'Active'),
(85, 'Angel Canete', 'angelcanete86@yahoo.com', 'angel', '$2y$10$yNMFQlS4nUGtc6rBQQDuru3rpM0zTwy14M5EQTAt5LxsmX8LJKJSO', 'Organizer', '85/1732187862_lips.jpg', 'Active'),
(107, 'Jeralyn Peritos', 'jeralynpreitos@gmail.com', 'jera', '$2y$10$1bu10Z2ST0pmIIQeUL5DkOEaAU3.3PX1zQ.H0rV/RokOD6xNb1Gl.', 'User', '107/1733032557_g1.jpg', 'Active'),
(108, 'Kyle Canete', 'angelcanete86@yahoo.com', 'kyle', '$2y$10$DVkKjZXt2h.5sBRIzCPPw.wirCj5fCUwhSD6pC3keBgGaa7OqE056', 'User', '108/1733061629_demon.jpg', 'Active'),
(109, 'James Arpilang', 'jamesaripliang@gmail.com', 'james', '$2y$10$Y5ozT1Q30qAFY4ToLikUcuOTB1czb41joCopQTY425g1gsWsS4KI6', 'User', '109/1733034198_stroke.jpg', 'Active'),
(110, 'Loren Canete', 'lorencanete@yahoo.com', 'loren', '$2y$10$GrkL3ayhPBZVjAWoA2JxdesxZneJhlCUzxZMQ2v0f6W.fzP8fm7N.', 'User', '110/1733034171_digital.jpg', 'Active');

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
(133, 110, 'Intrusive', 'The forbidden whisper.', 'Painting', 'files/XMVEcN7d/skel.jpg', '2024-12-01', 'Approved');

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
(81, 217, 108),
(82, 217, 109),
(83, 217, 110),
(84, 221, 108);

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
(29, 107, 123, 'Wow'),
(30, 107, 122, 'This is great.'),
(31, 108, 123, 'Great!'),
(32, 107, 123, 'Wow'),
(33, 108, 126, 'Wow'),
(34, 108, 123, 'Ai Art'),
(35, 108, 123, 'This is so cool'),
(36, 107, 126, 'Cutie Cat'),
(37, 110, 126, 'Mystie'),
(38, 110, 133, 'Delete ko ni\n'),
(39, 110, NULL, 'My first sketch');

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
(211, 216, 122),
(212, 216, 123),
(213, 216, 124),
(214, 217, 122),
(215, 217, 123),
(216, 217, 124),
(217, 217, 125),
(218, 217, 126),
(219, 217, 127),
(220, 217, 128),
(221, 217, 129),
(222, 217, 130),
(223, 217, 131),
(224, 217, 132),
(225, 217, 133),
(226, 218, 122),
(227, 218, 123),
(228, 218, 124),
(229, 219, 122),
(230, 219, 123),
(231, 219, 124),
(232, 220, 122),
(233, 220, 123),
(234, 220, 124),
(235, 221, 122),
(236, 221, 123),
(237, 221, 124);

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
(216, 107, 'Solo Exhibit', 'Sharing the masterpiece.', '2024-12-25', 'Solo', 'Completed', '2024-12-01 07:15:02'),
(217, 107, 'Collab Exhibit', 'Sharing our masterpiece with diferent art categories.', '2024-12-25', 'Collaborate', 'Cancelled', '2024-12-01 07:23:29'),
(218, 107, 'asd', 'asd', '2024-12-25', 'Solo', 'Declined', NULL),
(219, 107, 'Solo Exhibit', 'asda', '2024-12-01', 'Solo', 'Ongoing', '2024-12-01 07:53:26'),
(220, 107, 'asd', 'asd', '2024-12-02', 'Solo', 'Cancelled', '2024-12-01 07:54:03'),
(221, 107, 'Collab Exhibit', 'asd', '2024-12-28', 'Collaborate', 'Pending', '2024-12-01 08:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `fav_id` int(100) NOT NULL,
  `u_id` int(100) NOT NULL,
  `a_id` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`fav_id`, `u_id`, `a_id`) VALUES
(52, 107, 122),
(53, 107, NULL),
(54, 108, 126);

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
(108, 107, 122),
(109, 107, NULL),
(110, 107, 124),
(111, 108, 122),
(112, 108, 123),
(113, 108, 126),
(116, 110, 122),
(118, 110, 133),
(120, 110, 127),
(122, 110, 132),
(124, 110, 131),
(125, 110, 129);

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
(40, 107, 122),
(41, 107, NULL),
(42, 108, 126),
(43, 110, 123);

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
  MODIFY `u_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `art_info`
--
ALTER TABLE `art_info`
  MODIFY `a_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT for table `collab_exhibit`
--
ALTER TABLE `collab_exhibit`
  MODIFY `collab_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `exhibit_artworks`
--
ALTER TABLE `exhibit_artworks`
  MODIFY `exbtArwork_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT for table `exhibit_tbl`
--
ALTER TABLE `exhibit_tbl`
  MODIFY `exbt_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=222;

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
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
