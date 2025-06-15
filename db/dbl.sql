-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 06:44 PM
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
  `time_in_raw` datetime DEFAULT NULL,
  `location_in` varchar(255) DEFAULT NULL,
  `lat_in` double DEFAULT NULL,
  `lng_in` double DEFAULT NULL,
  `time_out` varchar(50) DEFAULT NULL,
  `time_out_raw` datetime DEFAULT NULL,
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

INSERT INTO `dbl_attendance_logs` (`id`, `employee_id`, `username`, `date`, `time_in`, `time_in_raw`, `location_in`, `lat_in`, `lng_in`, `time_out`, `time_out_raw`, `location_out`, `lat_out`, `lng_out`, `status`, `created_at`, `hours_worked`) VALUES
(1, 'EMP006', 'pat', '2025-06-15', 'Sunday - 03:08 PM', '2025-06-15 15:08:33', 'DBL ISTS', 14.7399, 120.98754, NULL, NULL, NULL, NULL, NULL, 'Pending', '2025-06-15 07:08:33', 0.00),
(2, 'EMP001', 'devpat', '2025-06-15', 'Sunday - 03:30 PM', '2025-06-15 15:30:36', 'DBL ISTS', 14.7399, 120.98754, 'Monday - 12:37 AM', '2025-06-16 00:37:56', 'DBL ISTS', 14.7399, 120.98754, 'Overtime', '2025-06-15 07:30:36', 9.12);

-- --------------------------------------------------------

--
-- Table structure for table `dbl_client_locations`
--

CREATE TABLE `dbl_client_locations` (
  `id` int(11) NOT NULL,
  `client` varchar(255) NOT NULL,
  `lat` decimal(10,6) NOT NULL,
  `lng` decimal(10,6) NOT NULL,
  `radius` int(11) DEFAULT 50
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_client_locations`
--

INSERT INTO `dbl_client_locations` (`id`, `client`, `lat`, `lng`, `radius`) VALUES
(1, 'DBL ISTS', 14.739900, 120.987540, 50),
(2, 'WL Headquarter', 14.737567, 120.990180, 50),
(3, 'WL Bignay', 14.747861, 121.003900, 50),
(4, 'Labella Villa Homes', 14.741170, 120.986240, 50),
(5, 'Biglite Makati', 14.539840, 121.014330, 50),
(6, 'Demo Location', 14.732630, 121.002700, 50),
(7, 'Weshop Taft', 14.562450, 120.996120, 50),
(8, 'Kai Mall', 14.756700, 121.043910, 50),
(9, 'Ellec Parada', 14.695640, 120.995300, 50);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dbl_employees_acc`
--

INSERT INTO `dbl_employees_acc` (`id`, `employee_id`, `username`, `email`, `password`, `full_name`, `role`, `department`, `status`, `created_at`, `profile_pic`) VALUES
(1, 'EMP001', 'devpat', 'devpat@example.com', '$2y$10$dckmKEkSHe1IsPxdK46TdeXpC1q92tzsxV7Uxgb2BwdN9vGfvrFnC', 'Patrick Nobleza', 'Information Technology', 'Information Technology', 'active', '2025-04-21 17:06:18', 'profile_682d1eb5153e08.28056977.jfif'),
(2, 'ADM001', 'admin', 'admin@example.com', '$2y$10$LLl1.d/qOJDRBgFgbsREE.O6kcO.9sOlNurZMMX4sdipqd8one1F.', 'DBL Admin', 'Admin', 'Admin', 'active', '2025-04-22 01:10:23', NULL),
(3, 'EMP002', 'employee', 'employee@example.com', '$2y$10$boBoKPni4MbCep63MhB0Qe.TDAGOAWx83OSzzAn1GRn2HLrW6C.Bi', 'Juan Dela Cruz', 'System Integration', 'System Integration', 'active', '2025-04-22 03:19:10', NULL),
(4, 'EMP003', 'ken', 'ken@gmail.com', '$2y$10$Pd1iIQeigBgGS1rXxy4tnOLXMsg85vUEaD1ikWRvUK.twi9vRkj/y', 'Jobert Ken Bordamonte', 'Intern', 'Intern', 'active', '2025-05-06 06:20:32', 'profile_682d34a2585384.03707639.png'),
(5, 'EMP004', 'qwee', 'qwe@gmail.com', '$2y$10$rElSgMPZDFQ9NDiAmflMfu.8QijGZ.EB05CUbO.yWnkuU1lm0u3eS', 'qwe', 'System Integration', 'System Integration', 'active', '2025-05-20 07:31:59', NULL),
(6, 'EMP005', 'yuji', 'yuji@gmail.com', '$2y$10$NMeb1C87SAUp4mnefoe1FOceNX.JSiQPhTPA62TwPxuMFkov4MSpW', 'Yuji', 'Intern', 'Intern', 'active', '2025-05-21 05:52:59', NULL),
(7, 'EMP006', 'pat', 'pat@gmail.com', '$2y$10$X2aSkjhVB0dUdryVppTLpeUkw6Z5pRMWfQ0JddO1Eq57wHVM0ZZJq', 'Patrick San Bartolome', 'Information Technology', 'Information Technology', 'active', '2025-05-22 01:13:03', NULL),
(8, 'EMP007', 'vin', 'vin@gmail.com', '$2y$10$isAwk5zPgLF2z2mmtlL/3e4BH1jHEEMQJDJOpMOHH22rDjZbpjize', 'Rheybin Pilon', 'Information Technology', 'Information Technology', 'active', '2025-05-22 01:26:39', NULL),
(9, 'EMP008', 'asd', 'asd@gmail.com', '$2y$10$eikmAaT1SgpocT590pdSzeT/IoE9G54t7EdmSWz5c4uaIiGgHDxR.', 'Hello World', 'System Integration', 'System Integration', 'active', '2025-05-22 02:31:42', NULL),
(10, 'EMP009', 'emp', 'emp@gmil.com', '$2y$10$KxQwRhD3Puba3Xar2JE3hOTVKSwGhEljNasqw.r8zvjqtBNUuNC2G', 'Test User', 'Information Technology', 'Information Technology', 'active', '2025-05-22 03:43:46', NULL);

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
-- Table structure for table `dbl_leave_requests`
--

CREATE TABLE `dbl_leave_requests` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `department_id` varchar(20) NOT NULL,
  `leave_type` enum('Vacation','Sick','Emergency','Maternity','Paternity','Other') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `arrival_time` datetime DEFAULT NULL,
  `departure_time` datetime DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `auto_moved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itinerary`
--

INSERT INTO `itinerary` (`id`, `employee_id`, `location`, `date`, `time`, `description`, `status`, `created_at`, `updated_at`, `arrival_time`, `departure_time`, `image`, `auto_moved`) VALUES
(1, 'EMP006', 'WL Bignay', '2025-06-15', '15:19:42', 'Issue Type: Electronics\r\nDescription: Sira printers\r\nPriority: low\r\nDate Observed: 2025-05-13', 'Pending', '2025-06-15 07:19:42', '2025-06-15 07:19:42', NULL, NULL, NULL, 0),
(2, 'EMP006', 'WL Bignay', '2025-06-15', '15:19:48', 'Issue Type: Electronics\r\nDescription: Sira printers\r\nPriority: low\r\nDate Observed: 2025-05-13', 'Pending', '2025-06-15 07:19:48', '2025-06-15 07:19:48', NULL, NULL, NULL, 0),
(3, 'EMP002', 'DBL ISTS', '2025-06-15', '15:20:10', 'Issue Type: Network\r\nDescription: No internet connection\r\nPriority: medium\r\nDate Observed: 2025-05-07', 'Pending', '2025-06-15 07:20:10', '2025-06-15 07:20:10', NULL, NULL, NULL, 0),
(4, 'EMP006', 'Demo Location', '2025-06-15', '15:21:13', '3456U7I9[', 'Pending', '2025-06-15 07:21:13', '2025-06-15 07:21:13', NULL, NULL, NULL, 0),
(5, 'EMP007', 'WL Bignay', '2025-06-15', '15:21:38', 'sdsd', 'Pending', '2025-06-15 07:21:38', '2025-06-15 07:21:38', NULL, NULL, NULL, 0),
(6, 'EMP002', 'WL Bignay', '2025-06-15', '15:23:11', '12e3r5tyio', 'Pending', '2025-06-15 07:23:11', '2025-06-15 07:23:11', NULL, NULL, NULL, 0),
(7, 'EMP002', 'WL Bignay', '2025-06-15', '15:24:09', 'sdsdsd', 'Pending', '2025-06-15 07:24:09', '2025-06-15 07:24:09', NULL, NULL, NULL, 0),
(8, 'EMP002', 'DBL ISTS', '2025-06-15', '15:26:57', 'Issue Type: Electronics\r\nDescription: SDSDSDSDSDSDSDSDS\r\nPriority: high\r\nDate Observed: 2025-06-15', 'Pending', '2025-06-15 07:26:57', '2025-06-15 07:26:57', NULL, NULL, NULL, 0),
(9, 'EMP001', 'WL Headquarter', '2025-06-15', '15:30:10', 'sdsdsd', 'Pending', '2025-06-15 07:30:10', '2025-06-15 07:30:10', NULL, NULL, NULL, 0),
(10, 'EMP002', 'WL Headquarter', '2025-06-15', '15:31:24', 'Issue Type: Network\r\nDescription: No Internet Connection\r\nPriority: medium\r\nDate Observed: 2025-06-15', 'Pending', '2025-06-15 07:31:24', '2025-06-15 07:31:24', NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `issue_type` varchar(100) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `priority` varchar(50) DEFAULT NULL,
  `date_observed` date DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `client_name`, `issue_type`, `issue_description`, `priority`, `date_observed`, `attachments`, `submitted_at`) VALUES
(5, 'DBL ISTS', 'Software', 'qwerty', 'low', '2025-06-16', '', '2025-06-15 16:10:30'),
(6, 'DBL ISTS', 'Network', 'SDSD', 'low', '2025-06-16', '', '2025-06-15 16:11:48'),
(7, 'WL MAIN', 'Software', 'ergtju', 'high', '2025-06-16', '', '2025-06-15 16:26:28'),
(8, 'DBL ISTS', 'Software', 's', 'medium', '2025-06-16', '', '2025-06-15 16:27:40'),
(9, 'DBL ISTS', 'Network', 'SDSD', 'medium', '2025-06-16', '', '2025-06-15 16:29:04'),
(10, 'DBL ISTS', 'Network', 'sdsd', 'high', '2025-06-17', '', '2025-06-15 16:37:41');

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
-- Indexes for table `dbl_client_locations`
--
ALTER TABLE `dbl_client_locations`
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
-- Indexes for table `dbl_leave_requests`
--
ALTER TABLE `dbl_leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `dbl_client_locations`
--
ALTER TABLE `dbl_client_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `dbl_employees_acc`
--
ALTER TABLE `dbl_employees_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `dbl_employees_dept`
--
ALTER TABLE `dbl_employees_dept`
  MODIFY `id` int(55) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dbl_leave_requests`
--
ALTER TABLE `dbl_leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
