-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 11, 2025 at 05:44 PM
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
-- Database: `user_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_crash`
--

CREATE TABLE `car_crash` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` varchar(15) NOT NULL,
  `status` enum('Sent','Failed') NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(15) NOT NULL,
  `crash_location` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_crash`
--

INSERT INTO `car_crash` (`id`, `message`, `recipient`, `status`, `user_id`, `user_name`, `user_phone`, `crash_location`, `created_at`) VALUES
(1, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919542629626', 'Sent', 16, 'Poorna Ajay', '9912719575', 'Unknown', '2025-01-02 13:02:40'),
(2, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919133159867', 'Sent', 16, 'Poorna Ajay', '9912719575', 'Unknown', '2025-01-02 13:02:40'),
(3, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919542629626', 'Sent', 16, 'Poorna Ajay', '9912719575', 'Unknown', '2025-01-06 05:42:04'),
(4, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919133159867', 'Sent', 16, 'Poorna Ajay', '9912719575', 'Unknown', '2025-01-06 05:42:05'),
(5, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919542629626', 'Sent', 17, 'anandh krishna', '9912719575', 'Unknown', '2025-01-06 06:48:21'),
(6, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919133159867', 'Sent', 17, 'anandh krishna', '9912719575', 'Unknown', '2025-01-06 06:48:21'),
(7, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919542629626', 'Sent', 18, 'rohit derangula', '7207245888', 'Unknown', '2025-01-06 13:31:17'),
(8, 'Emergency! A vehicle&#039;s crash detected at high speed!', '+919133159867', 'Sent', 18, 'rohit derangula', '7207245888', 'Unknown', '2025-01-06 13:31:18');

-- --------------------------------------------------------

--
-- Table structure for table `cyber_harassment_complaints`
--

CREATE TABLE `cyber_harassment_complaints` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `victim_name` varchar(255) NOT NULL,
  `victim_address` text NOT NULL,
  `username` varchar(255) NOT NULL,
  `complaint_details` text NOT NULL,
  `proof_images` text NOT NULL,
  `incident_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cyber_harassment_complaints`
--

INSERT INTO `cyber_harassment_complaints` (`id`, `user_id`, `category`, `victim_name`, `victim_address`, `username`, `complaint_details`, `proof_images`, `incident_date`, `created_at`) VALUES
(1, 17, 'Facebook', 'poorna', 'mtm', 'lovelu_poorna', 'hii', 'proof_6776385fa843e6.00665775.jpg', '0000-00-00', '2025-01-02 06:55:27'),
(2, 17, 'Facebook', 'poorna', 'mtm', 'lovelu_poorna', 'hii', 'proof_67763908903c77.47746123.jpg', '0000-00-00', '2025-01-02 06:58:16'),
(3, 17, 'Facebook', 'poorna', 'mtm', 'lovelu_poorna', 'hii', 'proof_6776391b70a9c4.44047105.jpg', '0000-00-00', '2025-01-02 06:58:35'),
(4, 17, 'Facebook', 'poorna', 'mtm', 'lovelu_poorna', 'hoi', 'proof_677639700ab845.33956556.jpg', '2002-12-06', '2025-01-02 07:00:00'),
(5, 17, 'Instagram', 'poorna', 'mtm', 'lovelu_poorna', 'hello', 'proof_67763a117ae555.93428980.png', '2004-12-24', '2025-01-02 07:02:41'),
(6, 17, 'Twitter', 'poorna', 'mtm', 'jhfyfik', 'i am poorna', 'proof_67763abc036115.73188395.jpg', '2024-06-25', '2025-01-02 07:05:32'),
(7, 17, 'WhatsApp', 'poorna', 'mtm', 'poornapoorna39@gmail.com', 'hi', 'proof_67763bdd6126f8.24588536.png', '2005-05-12', '2025-01-02 07:10:21'),
(8, 17, 'Facebook', 'poorna', 'mtm', 'poornapoorna39@gmail.com', 'hiiii', 'proof_677b7ac8870834.45536040.jpg', '2020-01-12', '2025-01-06 06:40:08'),
(9, 17, 'WhatsApp', 'poorna', 'mtm', 'poornapoorna39@gmail.com', 'hii', 'proof_677b7b3ab116a3.87733572.jpg', '2020-05-12', '2025-01-06 06:42:02'),
(10, 18, 'WhatsApp', 'poorna', 'mtm', 'poornapoorna39@gmail.com', 'hh', 'proof_677bda962e5cb6.63796357.png', '2005-02-01', '2025-01-06 13:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `geofence`
--

CREATE TABLE `geofence` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `entry_time` datetime NOT NULL,
  `exit_time` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `location_db` varchar(255) NOT NULL,
  `location_html` varchar(255) NOT NULL,
  `radius` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `login_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`id`, `user_id`, `username`, `user_location`, `contact_number`, `login_time`) VALUES
(2, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=16.9538024,81.9425701', '9912719575', '2024-12-20 11:16:32'),
(4, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=17.4358528,78.4400384', '9912719575', '2024-12-21 06:52:26'),
(5, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=17.5177728,78.3908864', '9912719575', '2024-12-31 05:50:16'),
(6, 17, 'anandh krishna', 'https://www.google.com/maps?q=17.5177728,78.3908864', '9912719575', '2024-12-31 07:07:10'),
(7, 17, 'anandh krishna', 'https://www.google.com/maps?q=17.5177728,78.3908864', '9912719575', '2024-12-31 10:48:55'),
(8, 17, 'anandh krishna', 'https://www.google.com/maps?q=17.5177728,78.3908864', '9912719575', '2025-01-01 13:22:23'),
(9, 17, 'anandh krishna', 'https://www.google.com/maps?q=16.1901437,81.1354621', '9912719575', '2025-01-01 16:19:11'),
(10, 17, 'anandh krishna', 'https://www.google.com/maps?q=16.1901434,81.1354618', '9912719575', '2025-01-02 03:29:46'),
(11, 17, 'anandh krishna', 'https://www.google.com/maps?q=16.7510016,78.0075008', '9912719575', '2025-01-02 07:27:47'),
(12, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=16.7510016,78.0075008', '9912719575', '2025-01-02 08:32:06'),
(13, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=16.7510016,78.0075008', '9912719575', '2025-01-02 13:44:48'),
(14, 17, 'anandh krishna', 'https://www.google.com/maps?q=16.7510016,78.0075008', '9912719575', '2025-01-02 14:50:13'),
(15, 17, 'anandh krishna', 'https://www.google.com/maps?q=17.4948352,78.4072704', '9912719575', '2025-01-04 09:09:15'),
(16, 16, 'Poorna Ajay', 'https://www.google.com/maps?q=17.4358528,78.4400384', '9912719575', '2025-01-06 06:39:32'),
(17, 17, 'anandh krishna', 'https://www.google.com/maps?q=17.4358528,78.4400384', '9912719575', '2025-01-06 07:26:04'),
(18, 18, 'rohit derangula', 'https://www.google.com/maps?q=17.4424064,78.381056', '7207245888', '2025-01-06 14:26:20');

-- --------------------------------------------------------

--
-- Table structure for table `panic_msg`
--

CREATE TABLE `panic_msg` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `user_location` text NOT NULL,
  `message` text NOT NULL,
  `status_code` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panic_msg`
--

INSERT INTO `panic_msg` (`id`, `user_id`, `firstname`, `lastname`, `phone_no`, `user_location`, `message`, `status_code`, `created_at`) VALUES
(1, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 0, '2024-12-31 05:53:51'),
(2, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 05:59:18'),
(3, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 06:02:27'),
(4, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 06:07:34'),
(5, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 06:14:38'),
(6, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 06:18:14'),
(7, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'Alert! Someone needs help urgently!', 1, '2024-12-31 06:25:36'),
(8, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=16.7510016,78.0075008', 'Alert! Someone needs help urgently!', 1, '2025-01-02 13:38:09'),
(9, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:40:43'),
(10, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:40:45'),
(11, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:45:35'),
(12, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:47:09'),
(13, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:47:28'),
(14, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:47:55'),
(15, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:48:41'),
(16, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 05:50:28'),
(17, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 06:26:25'),
(18, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'Alert! Someone needs help urgently!', 1, '2025-01-06 06:28:29'),
(19, 18, 'rohit', 'derangula', '7207245888', 'https://www.google.com/maps?q=17.4424064,78.381056', 'Alert! Someone needs help urgently!', 1, '2025-01-06 13:26:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profession` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `district` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `landmarks` varchar(255) DEFAULT NULL,
  `houseNumber` varchar(50) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `mobile1` varchar(15) DEFAULT NULL,
  `relation1` varchar(50) DEFAULT NULL,
  `mobile2` varchar(15) DEFAULT NULL,
  `relation2` varchar(50) DEFAULT NULL,
  `mobile3` varchar(15) DEFAULT NULL,
  `relation3` varchar(50) DEFAULT NULL,
  `mobile4` varchar(15) DEFAULT NULL,
  `relation4` varchar(50) DEFAULT NULL,
  `mobile5` varchar(15) DEFAULT NULL,
  `relation5` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `phone_no`, `password`, `created_at`, `profession`, `country`, `state`, `district`, `city`, `landmarks`, `houseNumber`, `bio`, `mobile1`, `relation1`, `mobile2`, `relation2`, `mobile3`, `relation3`, `mobile4`, `relation4`, `mobile5`, `relation5`) VALUES
(16, 'Poorna', 'Ajay', '123@gmail.com', '9912719575', '$2y$10$P644otE6JOJ2g4JI/xJ4le3SbEcQA1JOtL8DbY31uFOSljh/HsPdi', '2024-12-17 06:37:27', 'Student', 'india', 'andhra pradesh', 'krishna', 'machlipatnam ', 'busstand back side', '27-2', 'I am an Student at Krishna University', '', '', '', '', '', '', '', '', '', ''),
(17, 'anandh', 'krishna', '1234@gmail.com', '9912719575', '$2y$10$pK.751FCFJ.WVY6pPL1fmOZrTk76Hi2vaPk1Hm1u8wfW2Pahha.Q2', '2024-12-31 06:06:55', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'rohit', 'derangula', 'rohit123@gmail.com', '7207245888', '$2y$10$Sq.mnTIOmVVe1vRVr.2QUuLdvwH.cVBzcFHM8L0g4E.uFW4n6baJm', '2025-01-06 13:25:59', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_videos`
--

CREATE TABLE `user_videos` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `phone_no` varchar(15) DEFAULT NULL,
  `user_location` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `video_type` varchar(50) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_videos`
--

INSERT INTO `user_videos` (`id`, `user_id`, `firstname`, `lastname`, `phone_no`, `user_location`, `video_path`, `video_type`, `uploaded_at`) VALUES
(1, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'uploads/67753b7c36186-video.mp4', '⚠️ Others', '2025-01-01 12:56:28'),
(2, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'uploads/67753d1ca7abe-video.mp4', '🚨 Harassment', '2025-01-01 13:03:24'),
(3, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'uploads/67753d6beb191-video.mp4', 'Violence', '2025-01-01 13:04:43'),
(4, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.5177728,78.3908864', 'uploads/67753da44557f-video.mp4', '🚨 Harassment', '2025-01-01 13:05:40'),
(5, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=16.7510016,78.0075008', 'uploads/6776972ea91b3-video.mp4', '⚠️ Others', '2025-01-02 13:39:58'),
(6, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=16.7510016,78.0075008', 'uploads/677697752dcd8-video.mp4', '🚨 Harassment', '2025-01-02 13:41:09'),
(7, 16, 'Poorna', 'Ajay', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'uploads/677b6cefdf946-video.mp4', '🚨 Harassment', '2025-01-06 05:41:03'),
(8, 17, 'anandh', 'krishna', '9912719575', 'https://www.google.com/maps?q=17.4358528,78.4400384', 'uploads/677b7a60e9d88-video.mp4', '🚨 Harassment', '2025-01-06 06:38:24'),
(9, 18, 'rohit', 'derangula', '7207245888', 'https://www.google.com/maps?q=17.4424064,78.381056', 'uploads/677bdae5b84ee-video.mp4', '🚨 Harassment', '2025-01-06 13:30:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_crash`
--
ALTER TABLE `car_crash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cyber_harassment_complaints`
--
ALTER TABLE `cyber_harassment_complaints`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `geofence`
--
ALTER TABLE `geofence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `panic_msg`
--
ALTER TABLE `panic_msg`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_videos`
--
ALTER TABLE `user_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_crash`
--
ALTER TABLE `car_crash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cyber_harassment_complaints`
--
ALTER TABLE `cyber_harassment_complaints`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `geofence`
--
ALTER TABLE `geofence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `panic_msg`
--
ALTER TABLE `panic_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_videos`
--
ALTER TABLE `user_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cyber_harassment_complaints`
--
ALTER TABLE `cyber_harassment_complaints`
  ADD CONSTRAINT `cyber_harassment_complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `geofence`
--
ALTER TABLE `geofence`
  ADD CONSTRAINT `geofence_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `panic_msg`
--
ALTER TABLE `panic_msg`
  ADD CONSTRAINT `panic_msg_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_videos`
--
ALTER TABLE `user_videos`
  ADD CONSTRAINT `user_videos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
