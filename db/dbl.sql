-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 08:35 AM
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
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `client_name`) VALUES
(1, 'WL Main'),
(2, 'Code Helix'),
(3, 'WL Bignay'),
(4, 'WL Valenzuela');

-- --------------------------------------------------------

--
-- Table structure for table `dbl_attendance_logs`
--

CREATE TABLE `dbl_attendance_logs` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `time_in` varchar(50) DEFAULT NULL,
  `location_in` varchar(255) DEFAULT NULL,
  `lat_in` double DEFAULT NULL,
  `lng_in` double DEFAULT NULL,
  `time_out` varchar(50) DEFAULT NULL,
  `location_out` varchar(255) DEFAULT NULL,
  `lat_out` double DEFAULT NULL,
  `lng_out` double DEFAULT NULL,
  `status` enum('Pending','Under Hours','Complete Hours','Overtime') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hours_worked` decimal(5,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_attendance_logs`
--

INSERT INTO `dbl_attendance_logs` (`id`, `employee_id`, `username`, `date`, `time_in`, `location_in`, `lat_in`, `lng_in`, `time_out`, `location_out`, `lat_out`, `lng_out`, `status`, `created_at`, `hours_worked`) VALUES
(19, 'EMP002', 'employee', '2025-05-06', 'Tuesday - 5/6/2025 - 01:07 PM', '0', 14.7226624, 121.0056704, NULL, NULL, NULL, NULL, 'Pending', '2025-05-06 05:07:46', 0.00);

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
  `role` varchar(55) DEFAULT NULL,
  `department` varchar(55) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_employees_acc`
--

INSERT INTO `dbl_employees_acc` (`id`, `employee_id`, `username`, `email`, `password`, `full_name`, `role`, `department`, `status`, `created_at`) VALUES
(1, 'EMP001', 'devpat', 'devpat@example.com', '$2y$10$23597VDiwg3yoM0pnVwKIeGm/xSoFf1qu9K.gOx8My.MEYFobSN5K', 'Patrick Nobleza', 'Information Technology', 'Information Technology', 'active', '2025-04-21 17:06:18'),
(2, 'ADM001', 'admin', 'admin@example.com', '$2y$10$LLl1.d/qOJDRBgFgbsREE.O6kcO.9sOlNurZMMX4sdipqd8one1F.', 'DBL Admin', 'Admin', 'Admin', 'active', '2025-04-22 01:10:23'),
(3, 'EMP002', 'employee', 'employee@example.com', '$2y$10$boBoKPni4MbCep63MhB0Qe.TDAGOAWx83OSzzAn1GRn2HLrW6C.Bi', 'Juan Dela Cruz', 'System Integration', 'System Integration', 'active', '2025-04-22 03:19:10'),
(4, 'EMP003', 'ken', 'ken@gmail.com', '$2y$10$biXCQV9hGZyGHWnjPEDQ2e2Au7asu2CZgwdmBGpgD4FCBrh0Yo5L2', 'Jobert Ken Bordamonte', 'Intern', 'Intern', 'active', '2025-05-06 06:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `dbl_employees_dept`
--

CREATE TABLE `dbl_employees_dept` (
  `id` int(55) NOT NULL,
  `department` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_employees_dept`
--

INSERT INTO `dbl_employees_dept` (`id`, `department`) VALUES
(1, 'System Integration'),
(2, 'Information Technology'),
(3, 'Admin'),
(4, 'Sales'),
(5, ' Intern');

-- --------------------------------------------------------

--
-- Table structure for table `itinerary`
--

CREATE TABLE `itinerary` (
  `id` int(11) NOT NULL,
  `employee_id` varchar(20) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('Pending','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itinerary`
--

INSERT INTO `itinerary` (`id`, `employee_id`, `location`, `date`, `time`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'EMP001', 'Code Helix', '2025-04-28', '14:10:23', 'Fix CCTVs', 'Pending', '2025-04-28 06:10:23', '2025-04-30 06:32:23'),
(2, 'EMP001', 'Code Helix', '2025-04-28', '16:11:49', 'Fix servers', 'Completed', '2025-04-28 08:11:49', '2025-04-28 08:12:19'),
(3, 'EMP002', 'Code Helix', '2025-04-28', '16:24:54', 'dsadsdsds', 'Completed', '2025-04-28 08:24:54', '2025-04-30 06:18:56'),
(4, 'EMP001', 'WL Valenzuela', '2025-04-29', '16:15:30', 'fix cctvs', 'Completed', '2025-04-29 08:15:30', '2025-04-30 06:18:40'),
(5, 'EMP002', 'Code Helix', '2025-04-30', '08:38:42', 'fix cctv', 'Completed', '2025-04-30 00:38:42', '2025-04-30 06:18:58'),
(6, 'EMP001', 'WL Main', '2025-04-30', '14:35:54', 'Server Daily Checkup', 'Pending', '2025-04-30 06:35:54', '2025-04-30 06:40:35'),
(7, 'EMP001', 'WL Main', '2025-05-06', '08:43:20', 'Check CCTV', 'Pending', '2025-05-06 00:43:20', '2025-05-06 00:43:20'),
(8, 'EMP003', 'BCP MAIN', '2025-05-06', '14:28:47', 'SUNUGIN MO', 'Pending', '2025-05-06 06:28:47', '2025-05-06 06:28:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `dbl_employees_dept`
--
ALTER TABLE `dbl_employees_dept`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dbl_attendance_logs`
--
ALTER TABLE `dbl_attendance_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dbl_employees_acc`
--
ALTER TABLE `dbl_employees_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `dbl_employees_dept`
--
ALTER TABLE `dbl_employees_dept`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `dbl_employees_acc` (`employee_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
