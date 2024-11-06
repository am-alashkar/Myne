-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 09:25 AM
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
-- Database: `crm_nse`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(10) UNSIGNED NOT NULL,
  `file_name` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `m_date` bigint(20) DEFAULT NULL,
  `file_format` text DEFAULT NULL,
  `n_p` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `selectable` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `selectable`) VALUES
(1, '{{gr_admins}}', 0),
(3, '{{gr_staff}}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `login` varchar(256) NOT NULL,
  `name` text NOT NULL,
  `password` text NOT NULL,
  `email` varchar(512) DEFAULT NULL,
  `info` longtext DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT NULL,
  `last_seen` datetime DEFAULT NULL,
  `disabled` tinyint(1) DEFAULT NULL,
  `disable_note` text DEFAULT NULL,
  `last_try` bigint(20) DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `lang_name` varchar(16) DEFAULT NULL,
  `timezone` varchar(255) DEFAULT NULL,
  `price_group` tinyint(2) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `login`, `name`, `password`, `email`, `info`, `sex`, `group_id`, `deleted`, `last_seen`, `disabled`, `disable_note`, `last_try`, `register_date`, `parent_id`, `lang_name`, `timezone`, `price_group`, `balance`, `credit`) VALUES
(1, 'admin', 'Administrator', '$2y$10$jOpm79FPJlQDHywHqWKbc.POA7gtYCyY77fuSwy6hYc2kgeeb9dcO', NULL, NULL, 1, 1, NULL, '2022-01-27 00:32:55', NULL, NULL, 1730708274, '2022-01-27 00:32:55', NULL, 'ar', NULL, NULL, 598985, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `group_id` int(10) UNSIGNED DEFAULT NULL,
  `script` varchar(256) DEFAULT NULL,
  `needs` varchar(256) DEFAULT NULL,
  `only_group` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`user_id`, `group_id`, `script`, `needs`, `only_group`) VALUES
(1, NULL, 'administration', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sid` text NOT NULL,
  `last_active` datetime DEFAULT NULL,
  `info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `sid`, `last_active`, `info`) VALUES
(1, NULL, '58386ae20c092f8f0f5bd8c486d4861c7bb4fd7b', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `var_name` text NOT NULL,
  `var_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`var_name`, `var_value`) VALUES
('website_title', 'Myne'),
('force_login', '0'),
('nshortdate', 'Y-m-d'),
('nshorttime12', 'h:i A'),
('nshorttime24', 'H:i'),
('nlongdate', 'Y-m-d'),
('shortdate', 'Y-m-d'),
('nlongtime12', 'h:i A'),
('nlongtime24', 'H:i:s');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `login` (`login`),
  ADD KEY `disabled` (`disabled`),
  ADD KEY `deleted` (`deleted`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD UNIQUE KEY `user_id` (`user_id`,`group_id`,`script`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD UNIQUE KEY `var_name` (`var_name`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
