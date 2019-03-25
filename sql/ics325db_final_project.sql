-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2019 at 09:12 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ics325db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cadence`
--

CREATE TABLE `cadence` (
  `sequence` int(11) NOT NULL,
  `PI_id` varchar(255) NOT NULL,
  `iteration_id` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` int(5) DEFAULT NULL,
  `safe_comments` varchar(255) DEFAULT NULL,
  `release_overlay` varchar(255) DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `capacity`
--

CREATE TABLE `capacity` (
  `id` int(11) NOT NULL,
  `team_id` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `team_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `program_increment` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `iteration_1` int(11) NOT NULL,
  `iteration_2` int(11) NOT NULL,
  `iteration_3` int(11) NOT NULL,
  `iteration_4` int(11) NOT NULL,
  `iteration_5` int(11) NOT NULL,
  `iteration_6` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `number` int(10) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `status` varchar(15) DEFAULT NULL,
  `exempt` varchar(10) DEFAULT NULL,
  `work_city` varchar(30) DEFAULT NULL,
  `work_ctry` char(2) DEFAULT NULL,
  `cost_center` varchar(10) DEFAULT NULL,
  `cost_center_manager` varchar(30) DEFAULT NULL,
  `managers_first_name` varchar(30) DEFAULT NULL,
  `managers_last_name` varchar(30) DEFAULT NULL,
  `admin_name` varchar(30) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `level_3_mgr_last_name` varchar(30) DEFAULT NULL,
  `level_3_mgr_first_name` varchar(30) DEFAULT NULL,
  `primary_project` varchar(50) DEFAULT NULL,
  `secondary_project` varchar(50) DEFAULT NULL,
  `org` varchar(3) NOT NULL,
  `managers_number` varchar(10) NOT NULL,
  `lvl_3_mgr_number` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='This table is used to store Employees';

-- --------------------------------------------------------

--
-- Table structure for table `employee_identification`
--

CREATE TABLE `employee_identification` (
  `tool_id` varchar(25) NOT NULL,
  `name` varchar(255) NOT NULL,
  `division` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `hr_id` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `art_name` varchar(50) DEFAULT NULL,
  `team_name` varchar(50) NOT NULL,
  `employee_name` varchar(50) NOT NULL,
  `polarion_id` varchar(15) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `id` int(2) NOT NULL,
  `name` varchar(40) NOT NULL,
  `value` varchar(10) NOT NULL,
  `comments` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='for storing model and UI preferences';

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`, `comments`) VALUES
(1, 'OVERHEAD_PERCENTAGE', '20', ''),
(2, 'AGILE_TEAM_MEMBER_ALLOCATION', '100', ''),
(3, 'PRODUCT_OWNER_ALLOCATION', '50', ''),
(4, 'SCRUM_MASTER_ALLOCATION', '50', ''),
(5, 'UPDATE_DEFAULT_CAPACITY', '1', '(0 is false; 1 is true)'),
(6, 'ART_SIZE_TEAMS_MIN_SAFE', '5', ''),
(7, 'ART_SIZE_TEAMS_MIN_ORG', '3', ''),
(8, 'ART_SIZE_TEAMS_MAX_SAFE', '9', ''),
(9, 'ART_SIZE_TEAMS_MAX_ORG', '15', ''),
(10, 'ART_SIZE_TEAM_MEMBERS_MIN_SAFE', '50', ''),
(11, 'ART_SIZE_TEAM_MEMBERS_MIN_ORG', '20', ''),
(12, 'ART_SIZE_TEAM_MEMBERS_MAX_SAFE', '125', ''),
(13, 'ART_SIZE_TEAM_MEMBERS_MAX_SAFE', '150', ''),
(14, 'PI_DURATION_WEEKS_MIN_SAFE', '8', ''),
(15, 'PI_DURATION_WEEKS_MIN_ORG', '12', ''),
(16, 'PI_DURATION_WEEKS_MAX_SAFE', '12', ''),
(17, 'PI_DURATION_WEEKS_MAX_ORG', '12', ''),
(18, 'NUMBER_OF_ITERATIONS_MIN_SAFE', '4', ''),
(19, 'NUMBER_OF_ITERATIONS_MIN_ORG', '6', ''),
(20, 'NUMBER_OF_ITERATIONS_MAX_SAFE', '6', ''),
(21, 'NUMBER_OF_ITERATIONS_MAX_ORG', '6', ''),
(22, 'DEVELOPER_IN_MULTIPLE_TEAMS_SAFE', 'FALSE', ''),
(23, 'DEVELOPER_IN_MULTIPLE_TEAMS_ORG', 'FALSE', ''),
(24, 'SCRUM_MASTER_SUPPORTS_MULTIPLE_TEAMS_SAF', 'TRUE', ''),
(25, 'SCRUM_MASTER_SUPPORTS_MULTIPLE_TEAMS_ORG', 'TRUE', ''),
(26, 'PRODUCT_OWNER_SUPPORTS_MULTIPLE_TEAMS_SA', 'TRUE', ''),
(27, 'PRODUCT_OWNER_SUPPORTS_MULTIPLE_TEAMS_OR', 'TRUE', '');

-- --------------------------------------------------------

--
-- Table structure for table `training_calendar`
--

CREATE TABLE `training_calendar` (
  `training_id` varchar(30) NOT NULL,
  `course_name` varchar(40) NOT NULL,
  `course_code` varchar(5) NOT NULL,
  `trainer_number` varchar(10) NOT NULL,
  `trainer_last_name` varchar(30) NOT NULL,
  `trainer_first_name` varchar(30) NOT NULL,
  `location` varchar(30) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `no_of_days` int(2) NOT NULL,
  `status` varchar(10) NOT NULL,
  `cost` int(5) NOT NULL,
  `comments` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_enrollment`
--

CREATE TABLE `training_enrollment` (
  `enrollment_no` int(5) NOT NULL,
  `training_id` varchar(30) NOT NULL,
  `employee_email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='For storing the enrollments (to be uploaded after each training)';

-- --------------------------------------------------------

--
-- Table structure for table `trains_and_teams`
--

CREATE TABLE `trains_and_teams` (
  `team_id` varchar(50) NOT NULL,
  `team_name` varchar(55) NOT NULL,
  `parent_name` varchar(55) DEFAULT NULL,
  `type` varchar(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `role` varchar(32) NOT NULL DEFAULT 'USER',
  `ModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `CreatedTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `hash`, `active`, `role`, `ModifiedTime`, `CreatedTime`) VALUES
(31, 'MASTER', 'ADMIN', 'siva.jasthi@metrostate.edu', '5b4da3d47ec8dbdffbd5eea70a28d8', 1, 'SUPER-ADMIN', '2019-02-06 18:52:04', '0000-00-00 00:00:00'),
(67, 'Test', 'User', 'user@test.com', '5b4da3d47ec8dbdffbd5eea70a28d832', 1, 'SUPER-ADMIN', '2018-05-30 18:01:28', '0000-00-00 00:00:00'),
(68, 'Test', 'User', 'test_admin@google.com', 'bf6f61616471c7d836e437301252d062', 1, 'SUPER-ADMIN', '2019-02-06 18:52:41', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cadence`
--
ALTER TABLE `cadence`
  ADD PRIMARY KEY (`sequence`);

--
-- Indexes for table `capacity`
--
ALTER TABLE `capacity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`number`);

--
-- Indexes for table `employee_identification`
--
ALTER TABLE `employee_identification`
  ADD PRIMARY KEY (`email_address`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`team_name`,`polarion_id`,`role`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `training_calendar`
--
ALTER TABLE `training_calendar`
  ADD PRIMARY KEY (`training_id`);

--
-- Indexes for table `training_enrollment`
--
ALTER TABLE `training_enrollment`
  ADD PRIMARY KEY (`enrollment_no`);

--
-- Indexes for table `trains_and_teams`
--
ALTER TABLE `trains_and_teams`
  ADD PRIMARY KEY (`team_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cadence`
--
ALTER TABLE `cadence`
  MODIFY `sequence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT for table `capacity`
--
ALTER TABLE `capacity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
