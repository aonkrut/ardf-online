-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 11:14 PM
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
-- Database: `ardf_ online`
--

-- --------------------------------------------------------

--
-- Table structure for table `ardf_all_categories`
--

CREATE TABLE `ardf_all_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `category_sex` enum('M','W') DEFAULT NULL,
  `category_youngest` int(11) DEFAULT NULL,
  `category_oldest` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ardf_all_categories`
--

INSERT INTO `ardf_all_categories` (`category_id`, `category_name`, `category_sex`, `category_youngest`, `category_oldest`) VALUES
(1, 'kadeti', 'M', 8, 14),
(2, 'juniori', 'M', 8, 19),
(3, 'juniorke ', 'W', 8, 19),
(4, 'seniori', 'M', 8, 90),
(5, 'seniorke', 'W', 8, 90),
(6, 'stariji seniori', 'M', 40, 90),
(7, 'starije seniorke', 'W', 35, 90),
(8, 'veterani', 'M', 60, 102),
(9, 'veteranke', 'W', 55, 102),
(10, 'kadetkinje', 'W', 8, 14);

-- --------------------------------------------------------

--
-- Table structure for table `ardf_club`
--

CREATE TABLE `ardf_club` (
  `club_id` int(11) NOT NULL,
  `club_name` varchar(255) DEFAULT NULL,
  `club_country_id` int(11) DEFAULT NULL,
  `club_call` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ardf_club_members`
--

CREATE TABLE `ardf_club_members` (
  `member_user_id` int(11) DEFAULT NULL,
  `member_club_id` int(11) DEFAULT NULL,
  `member_admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ardf_competition`
--

CREATE TABLE `ardf_competition` (
  `competition_id` int(11) NOT NULL,
  `competition_name` varchar(255) DEFAULT NULL,
  `competition_type_id` int(11) DEFAULT NULL,
  `competition_start_entry_date` date DEFAULT NULL,
  `competition_end_entry_date` date DEFAULT NULL,
  `competition_entries` tinyint(1) DEFAULT NULL,
  `competition_location` varchar(255) DEFAULT NULL,
  `competition_coordinates` varchar(255) DEFAULT NULL,
  `competition_description` longtext DEFAULT NULL,
  `competition_path_to_file` varchar(255) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `competition_start_time` time DEFAULT NULL,
  `gathering_time` time DEFAULT NULL,
  `departure_to_start` time DEFAULT NULL,
  `goniometer_delay` time DEFAULT NULL,
  `competition_start_date` date DEFAULT NULL,
  `competition_fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ardf_country`
--

CREATE TABLE `ardf_country` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `country_short` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ardf_country`
--

INSERT INTO `ardf_country` (`country_id`, `country_name`, `country_short`) VALUES
(1, 'Hrvatska', 'CRO');

-- --------------------------------------------------------

--
-- Table structure for table `ardf_entries`
--

CREATE TABLE `ardf_entries` (
  `entry_id` int(11) NOT NULL,
  `entry_competition_id` int(11) DEFAULT NULL,
  `entry_user_id` int(11) DEFAULT NULL,
  `entry_category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ardf_event`
--

CREATE TABLE `ardf_event` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL,
  `event_club_id` int(11) DEFAULT NULL,
  `event_country_id` int(11) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_competition_web` varchar(255) DEFAULT NULL,
  `event_email` varchar(255) DEFAULT NULL,
  `event_organizer_id` int(11) DEFAULT NULL,
  `event_cordinates` varchar(255) DEFAULT NULL,
  `event_public` tinyint(1) DEFAULT 0,
  `event_file_path` text DEFAULT NULL,
  `event_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ardf_type`
--

CREATE TABLE `ardf_type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ardf_type`
--

INSERT INTO `ardf_type` (`type_id`, `type_name`) VALUES
(1, 'UKV'),
(2, 'KV'),
(3, 'Foxoring'),
(4, 'Sprint'),
(5, 'Eksperimentalno');

-- --------------------------------------------------------

--
-- Table structure for table `ardf_user`
--

CREATE TABLE `ardf_user` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_date_of_birth` date DEFAULT NULL,
  `user_sex` varchar(1) DEFAULT NULL,
  `user_call` text DEFAULT NULL,
  `user_og` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ardf_user`
--

INSERT INTO `ardf_user` (`user_id`, `name`, `surname`, `username`, `email`, `password`, `user_date_of_birth`, `user_sex`, `user_call`, `user_og`) VALUES
(7, 'Noa', 'Turk', 'aonkrut', '4@4.hr', '$2y$10$yIWbdN0RTp3ZM4VnDtHoweYfcuPC7m7nHS0D2b8Ot5.wmPp9ofAjG', '2005-02-06', 'M', '9A3TOB', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ardf_all_categories`
--
ALTER TABLE `ardf_all_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `ardf_club`
--
ALTER TABLE `ardf_club`
  ADD PRIMARY KEY (`club_id`),
  ADD KEY `club_country_id` (`club_country_id`);

--
-- Indexes for table `ardf_club_members`
--
ALTER TABLE `ardf_club_members`
  ADD KEY `member_user_id` (`member_user_id`),
  ADD KEY `member_club_id` (`member_club_id`);

--
-- Indexes for table `ardf_competition`
--
ALTER TABLE `ardf_competition`
  ADD PRIMARY KEY (`competition_id`),
  ADD KEY `competition_type_id` (`competition_type_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `ardf_country`
--
ALTER TABLE `ardf_country`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `ardf_entries`
--
ALTER TABLE `ardf_entries`
  ADD PRIMARY KEY (`entry_id`),
  ADD KEY `entry_competition_id` (`entry_competition_id`),
  ADD KEY `entry_user_id` (`entry_user_id`),
  ADD KEY `entry_category_id` (`entry_category_id`);

--
-- Indexes for table `ardf_event`
--
ALTER TABLE `ardf_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_club_id` (`event_club_id`),
  ADD KEY `event_country_id` (`event_country_id`),
  ADD KEY `fk_event_organizer_id` (`event_organizer_id`);

--
-- Indexes for table `ardf_type`
--
ALTER TABLE `ardf_type`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `ardf_user`
--
ALTER TABLE `ardf_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ardf_all_categories`
--
ALTER TABLE `ardf_all_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ardf_club`
--
ALTER TABLE `ardf_club`
  MODIFY `club_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ardf_competition`
--
ALTER TABLE `ardf_competition`
  MODIFY `competition_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ardf_country`
--
ALTER TABLE `ardf_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ardf_entries`
--
ALTER TABLE `ardf_entries`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ardf_event`
--
ALTER TABLE `ardf_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `ardf_type`
--
ALTER TABLE `ardf_type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ardf_user`
--
ALTER TABLE `ardf_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ardf_club`
--
ALTER TABLE `ardf_club`
  ADD CONSTRAINT `ardf_club_ibfk_1` FOREIGN KEY (`club_country_id`) REFERENCES `ardf_country` (`country_id`);

--
-- Constraints for table `ardf_club_members`
--
ALTER TABLE `ardf_club_members`
  ADD CONSTRAINT `ardf_club_members_ibfk_1` FOREIGN KEY (`member_user_id`) REFERENCES `ardf_user` (`user_id`),
  ADD CONSTRAINT `ardf_club_members_ibfk_2` FOREIGN KEY (`member_club_id`) REFERENCES `ardf_club` (`club_id`);

--
-- Constraints for table `ardf_competition`
--
ALTER TABLE `ardf_competition`
  ADD CONSTRAINT `fk_event_id` FOREIGN KEY (`event_id`) REFERENCES `ardf_competition` (`competition_id`);

--
-- Constraints for table `ardf_entries`
--
ALTER TABLE `ardf_entries`
  ADD CONSTRAINT `ardf_entries_ibfk_1` FOREIGN KEY (`entry_competition_id`) REFERENCES `ardf_competition` (`competition_id`),
  ADD CONSTRAINT `ardf_entries_ibfk_2` FOREIGN KEY (`entry_user_id`) REFERENCES `ardf_user` (`user_id`),
  ADD CONSTRAINT `ardf_entries_ibfk_3` FOREIGN KEY (`entry_category_id`) REFERENCES `ardf_all_categories` (`category_id`);

--
-- Constraints for table `ardf_event`
--
ALTER TABLE `ardf_event`
  ADD CONSTRAINT `ardf_event_ibfk_1` FOREIGN KEY (`event_club_id`) REFERENCES `ardf_club` (`club_id`),
  ADD CONSTRAINT `ardf_event_ibfk_2` FOREIGN KEY (`event_country_id`) REFERENCES `ardf_country` (`country_id`),
  ADD CONSTRAINT `fk_event_organizer_id` FOREIGN KEY (`event_organizer_id`) REFERENCES `ardf_user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
