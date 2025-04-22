-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 08:19 PM
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
-- Database: `dbl`
--

-- --------------------------------------------------------

--
-- Table structure for table `dbl_attendance_logs`
--

CREATE TABLE `dbl_attendance_logs` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time_in` datetime DEFAULT NULL,
  `location_in` varchar(255) DEFAULT NULL,
  `lat_in` double DEFAULT NULL,
  `lng_in` double DEFAULT NULL,
  `time_out` datetime DEFAULT NULL,
  `location_out` varchar(255) DEFAULT NULL,
  `lat_out` double DEFAULT NULL,
  `lng_out` double DEFAULT NULL,
  `status` enum('On Time','Late','Missed Out') DEFAULT 'On Time',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_attendance_logs`
--

INSERT INTO `dbl_attendance_logs` (`id`, `employee_id`, `username`, `date`, `time_in`, `location_in`, `lat_in`, `lng_in`, `time_out`, `location_out`, `lat_out`, `lng_out`, `status`, `created_at`) VALUES
(45, '0', '', '2025-04-21', '2025-04-21 20:05:39', 'Detected Location', 0, 0, NULL, NULL, NULL, NULL, 'On Time', '2025-04-21 18:05:39'),
(46, '0', '', '2025-04-21', '2025-04-21 20:05:51', 'Detected Location', 0, 0, NULL, NULL, NULL, NULL, 'On Time', '2025-04-21 18:05:51'),
(47, '0', '', '2025-04-21', '2025-04-21 20:06:18', 'Detected Location', 0, 0, NULL, NULL, NULL, NULL, 'On Time', '2025-04-21 18:06:18'),
(48, '0', '', '2025-04-21', '2025-04-21 20:09:47', 'Detected Location', 14.7095552, 121.0056704, NULL, NULL, NULL, NULL, 'On Time', '2025-04-21 18:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `dbl_employees_acc`
--

CREATE TABLE `dbl_employees_acc` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `role` enum('admin','staff','employee') DEFAULT 'employee',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_employees_acc`
--

INSERT INTO `dbl_employees_acc` (`id`, `employee_id`, `username`, `email`, `password`, `full_name`, `role`, `status`, `created_at`) VALUES
(1, 'EMP001', 'devpat', 'devpat@example.com', '$2y$10$23597VDiwg3yoM0pnVwKIeGm/xSoFf1qu9K.gOx8My.MEYFobSN5K', 'Patrick Nobleza', 'employee', 'active', '2025-04-21 17:06:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbl_attendance_logs`
--
ALTER TABLE `dbl_attendance_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dbl_employees_acc`
--
ALTER TABLE `dbl_employees_acc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employee_id` (`employee_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbl_attendance_logs`
--
ALTER TABLE `dbl_attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `dbl_employees_acc`
--
ALTER TABLE `dbl_employees_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
