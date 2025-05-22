-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2025 at 09:35 AM
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
(28, 'EMP003', 'ken', '2025-05-22', 'Thursday - 09:11 AM', '2025-05-22 09:11:52', 'DBL ISTS', 14.73998, 120.9874, 'Thursday - 02:42 PM', '2025-05-22 14:42:56', 'DBL ISTS', 14.73998, 120.9874, 'Under Hours', '2025-05-22 01:11:52', 5.52),
(30, 'EMP002', 'employee', '2025-05-22', 'Thursday - 09:12 AM', '2025-05-22 09:12:25', 'DBL ISTS', 14.73998, 120.9874, NULL, NULL, NULL, NULL, NULL, 'Pending', '2025-05-22 01:12:25', 0.00),
(34, 'EMP007', 'vin', '2025-05-22', 'Thursday - 10:30 AM', '2025-05-22 10:30:28', 'DBL ISTS', 14.73998, 120.9874, NULL, NULL, NULL, NULL, NULL, 'Pending', '2025-05-22 02:30:28', 0.00),
(36, 'EMP008', 'asd', '2025-05-22', 'Thursday - 10:35 AM', '2025-05-22 10:35:59', 'DBL ISTS', 14.73998, 120.9874, NULL, NULL, NULL, NULL, NULL, 'Pending', '2025-05-22 02:35:59', 0.00),
(47, 'EMP001', 'devpat', '2025-05-22', 'Thursday - 11:00 AM', '2025-05-22 11:00:25', 'Labella Villa Homes', 14.74117, 120.98624, 'Thursday - 11:00 AM', '2025-05-22 11:00:35', 'Labella Villa Homes', 14.74117, 120.98624, 'Under Hours', '2025-05-22 03:00:25', 0.00),
(49, 'EMP005', 'yuji', '2025-05-22', 'Thursday - 11:07 AM', '2025-05-22 11:07:16', 'DBL ISTS', 14.73998, 120.9874, 'Thursday - 11:07 AM', '2025-05-22 11:07:25', 'DBL ISTS', 14.73998, 120.9874, 'Under Hours', '2025-05-22 03:07:16', 0.00),
(54, 'EMP009', 'emp', '2025-05-22', 'Thursday - 02:47 PM', '2025-05-22 14:47:28', 'Kai Mall', 14.7567, 121.04391, 'Thursday - 02:47 PM', '2025-05-22 14:47:52', 'DBL ISTS', 14.73998, 120.9874, 'Under Hours', '2025-05-22 06:47:28', 0.01);

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

--
-- Dumping data for table `dbl_leave_requests`
--

INSERT INTO `dbl_leave_requests` (`id`, `employee_id`, `department_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `created_at`, `updated_at`) VALUES
(3, 1, 'Information Technolo', 'Sick', '2025-05-15', '2025-05-23', 'sds', 'Approved', '2025-05-13 03:32:25', '2025-05-22 01:53:26'),
(4, 3, 'System Integration', 'Sick', '2025-05-14', '2025-05-17', 'sdsd', 'Rejected', '2025-05-13 03:43:10', '2025-05-22 01:48:06'),
(5, 1, 'Information Technolo', 'Emergency', '2025-05-14', '2025-05-17', 'sds', 'Approved', '2025-05-13 03:46:05', '2025-05-22 01:48:03');

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
  `departure_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itinerary`
--

INSERT INTO `itinerary` (`id`, `employee_id`, `location`, `date`, `time`, `description`, `status`, `created_at`, `updated_at`, `arrival_time`, `departure_time`) VALUES
(1, 'EMP001', 'Code Helix', '2025-04-28', '14:10:23', 'Fix CCTVs', 'Pending', '2025-04-28 06:10:23', '2025-05-21 00:19:37', NULL, NULL),
(2, 'EMP001', 'Code Helix', '2025-04-28', '16:11:49', 'Fix servers', 'Completed', '2025-04-28 08:11:49', '2025-04-28 08:12:19', NULL, NULL),
(3, 'EMP002', 'Code Helix', '2025-04-28', '16:24:54', 'dsadsdsds', 'Completed', '2025-04-28 08:24:54', '2025-04-30 06:18:56', NULL, NULL),
(4, 'EMP001', 'WL Valenzuela', '2025-04-29', '16:15:30', 'fix cctvs', 'Completed', '2025-04-29 08:15:30', '2025-04-30 06:18:40', NULL, NULL),
(5, 'EMP002', 'Code Helix', '2025-04-30', '08:38:42', 'fix cctv', 'Completed', '2025-04-30 00:38:42', '2025-04-30 06:18:58', NULL, NULL),
(6, 'EMP001', 'WL Main', '2025-04-30', '14:35:54', 'Server Daily Checkup', 'Completed', '2025-04-30 06:35:54', '2025-05-09 03:51:05', NULL, NULL),
(7, 'EMP001', 'WL Main', '2025-05-06', '08:43:20', 'Check CCTV', 'Completed', '2025-05-06 00:43:20', '2025-05-09 03:51:07', NULL, NULL),
(8, 'EMP003', 'BCP MAIN', '2025-05-06', '14:28:47', 'SUNUGIN MO', 'Pending', '2025-05-06 06:28:47', '2025-05-06 06:28:47', NULL, NULL),
(9, 'EMP001', 'Code Helix', '2025-05-07', '09:21:40', 'Develop a Attendance Tracking System', 'Completed', '2025-05-07 01:21:40', '2025-05-09 03:51:06', NULL, NULL),
(10, 'EMP001', 'Code Helix', '2025-05-07', '15:49:22', 'Fix Internet', 'Completed', '2025-05-07 07:49:22', '2025-05-09 03:51:09', '2025-05-07 15:49:45', NULL),
(11, 'EMP001', 'DBL ISTS', '2025-05-09', '10:17:53', 'Develop ATS', 'Completed', '2025-05-09 02:17:53', '2025-05-09 03:49:15', NULL, NULL),
(12, 'EMP002', 'Labella Villa Homes', '2025-05-09', '11:51:57', 'Cables', 'Pending', '2025-05-09 03:51:57', '2025-05-09 03:53:07', '2025-05-09 11:53:05', '2025-05-09 11:53:07'),
(13, 'EMP001', 'DBL ISTS', '2025-05-20', '14:34:46', 'matulog', 'Pending', '2025-05-20 06:34:46', '2025-05-20 06:34:46', NULL, NULL),
(14, 'EMP001', 'Kai Mall', '2025-05-21', '08:18:12', 'qwe', 'Pending', '2025-05-21 00:18:12', '2025-05-21 00:19:12', '2025-05-21 08:19:12', NULL),
(15, 'EMP006', 'DBL ISTS', '2025-05-22', '14:50:17', 'sdsdsdsds', 'Pending', '2025-05-22 06:50:17', '2025-05-22 06:50:17', NULL, NULL),
(16, 'EMP004', 'WL Headquarter', '2025-05-22', '14:50:29', 'sdsdsds', 'Pending', '2025-05-22 06:50:29', '2025-05-22 06:50:29', NULL, NULL),
(17, 'EMP001', 'DBL ISTS', '2025-05-22', '14:50:51', 'sdsdsds', 'Completed', '2025-05-22 06:50:51', '2025-05-22 06:51:18', NULL, NULL);

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
(1, 'CodeHelixCorp', 'Network', 'No internet connection', 'medium', '2025-05-07', 'uploads/1746598738-SHREK ASH.jfif', '2025-05-07 06:18:58'),
(2, 'WL Bignay', 'Electronics', 'Sira printers', 'low', '2025-05-13', 'uploads/1747098171-SHREK ASH.jfif', '2025-05-13 01:02:51');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
