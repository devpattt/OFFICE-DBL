-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 11:10 AM
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
(3, 1, 'Information Technolo', 'Sick', '2025-05-15', '2025-05-23', 'sds', 'Pending', '2025-05-13 03:32:25', '2025-05-13 03:32:25'),
(4, 3, 'System Integration', 'Sick', '2025-05-14', '2025-05-17', 'sdsd', 'Pending', '2025-05-13 03:43:10', '2025-05-13 03:43:10'),
(5, 1, 'Information Technolo', 'Emergency', '2025-05-14', '2025-05-17', 'sds', 'Pending', '2025-05-13 03:46:05', '2025-05-13 03:46:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dbl_leave_requests`
--
ALTER TABLE `dbl_leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dbl_leave_requests`
--
ALTER TABLE `dbl_leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
