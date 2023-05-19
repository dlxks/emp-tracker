-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 02:59 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `emptracker_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `branch_desc` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_desc`, `created_at`, `updated_at`) VALUES
(1, 'MAIN', 'CvSU-Main Campus', NULL, '2023-05-15 02:16:11'),
(2, 'CEIT', 'College of Engineering and Information Technology', NULL, '2023-05-14 16:29:25'),
(3, 'CED', 'College of Education', NULL, '2023-05-14 04:00:25'),
(5, 'CON', 'College of Nursing', '2023-05-14 04:00:16', '2023-05-14 04:00:16');

-- --------------------------------------------------------

--
-- Table structure for table `quarterlies`
--

CREATE TABLE `quarterlies` (
  `id` int(11) NOT NULL,
  `record_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `quarter` varchar(50) NOT NULL,
  `employed` bigint(20) NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quarterlies`
--

INSERT INTO `quarterlies` (`id`, `record_id`, `year`, `quarter`, `employed`, `percentage`, `created_at`, `updated_at`) VALUES
(15, 3, 2023, '1st', 10, '15.15', '2023-05-16 12:18:04', '2023-05-16 12:18:04'),
(16, 3, 2023, '2nd', 5, '7.58', '2023-05-17 23:44:26', '2023-05-17 23:44:26'),
(17, 3, 2023, '3rd', 10, '15.15', '2023-05-17 23:44:30', '2023-05-17 23:44:30'),
(18, 3, 2023, '4th', 20, '30.30', '2023-05-17 23:44:34', '2023-05-17 23:44:34'),
(19, 5, 2025, '1st', 30, '60.00', '2023-05-18 14:33:16', '2023-05-18 14:33:16'),
(20, 5, 2025, '2nd', 5, '10.00', '2023-05-18 14:33:49', '2023-05-18 14:33:49'),
(21, 5, 2025, '3rd', 5, '10.00', '2023-05-19 12:21:46', '2023-05-19 12:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `total_graduates` bigint(20) NOT NULL,
  `total_employed` bigint(20) NOT NULL,
  `total_percentage` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`id`, `branch_id`, `year`, `total_graduates`, `total_employed`, `total_percentage`, `created_at`, `updated_at`) VALUES
(3, 2, 2023, 66, 45, '68.18', '2023-05-16 06:28:25', '2023-05-16 06:28:25'),
(4, 3, 2023, 76, 0, '0.00', '2023-05-17 16:00:02', '2023-05-17 16:00:02'),
(5, 2, 2025, 50, 40, '80.00', '2023-05-18 14:33:07', '2023-05-18 14:33:07');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'admin'),
(2, 'coordinator');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `remember_token_expire` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `branch_id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `email`, `phone_number`, `password`, `role`, `remember_token`, `remember_token_expire`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 123, 'Admin', '', 'Admin', 'admin@admin.com', '639072203266', '$2y$10$ZMZHBMvwpAwLjLaEFDyxMO6BJBaPWswrg8XuRIMfZ7FCFwnESC5T2', 'admin', NULL, NULL, 'active', NULL, '2023-05-18 14:35:05'),
(15, 2, 456, 'Coordinator', 'w', 'Coordinator', 'coordinator@coordinator.com', '639123456798', '$2y$10$oRarwJ5JkEZPxTNp4m2l4e/vowb7asmjnsI6s2sDbc5Zg789vS3J2', 'coordinator', NULL, NULL, 'active', '2023-05-15 03:46:09', '2023-05-19 12:27:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quarterlies`
--
ALTER TABLE `quarterlies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quarterlies`
--
ALTER TABLE `quarterlies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
