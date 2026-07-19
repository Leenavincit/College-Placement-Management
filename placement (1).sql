-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 15, 2026 at 06:53 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `placement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `job_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `applied_date` date DEFAULT curdate(),
  `interview_date` date DEFAULT NULL,
  `interview_time` time DEFAULT NULL,
  `interview_location` varchar(255) DEFAULT NULL,
  `call_letter_sent` varchar(10) DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `student_id`, `job_id`, `status`, `applied_date`, `interview_date`, `interview_time`, `interview_location`, `call_letter_sent`) VALUES
(1, 10, 3, 'Applied', '2026-04-01', NULL, NULL, NULL, 'No'),
(2, 14, 6, 'Accepted', '2026-04-07', '2026-05-13', '09:00:00', 'DLF Cyber City, Chennai, Tamil Nadu.', 'Yes'),
(3, 14, 7, 'Pending', '2026-04-07', NULL, NULL, NULL, 'No'),
(4, 10, 9, 'Rejected', '2026-04-08', '2026-04-30', '18:57:00', 'room no 10', 'Yes'),
(5, 10, 8, 'Pending', '2026-04-08', NULL, NULL, NULL, 'No'),
(6, 10, 11, 'Accepted', '2026-04-10', NULL, NULL, NULL, 'No'),
(7, 14, 11, 'Accepted', '2026-04-18', '2026-05-04', '00:00:00', 'room no 10', 'Yes'),
(8, 14, 9, 'Accepted', '2026-04-21', '2026-04-27', '10:29:00', 'chennai', 'Yes'),
(9, 10, 6, 'Pending', '2026-04-21', NULL, NULL, NULL, 'No'),
(10, 35, 6, 'Accepted', '2026-04-29', NULL, NULL, NULL, 'No');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `package` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `password` int(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `location`, `package`, `email`, `industry`, `password`, `phone`) VALUES
(2, 'techspark', 'chennai', NULL, 't@gmail.com', 'software', 123, '987654321'),
(3, 'innovation private limited', 'chennai', NULL, 'innova@gmail.com', 'software', 123, '987654321'),
(10, 'bell lab private limited', 'chennai', NULL, 'bell@gmail.com', 'software', 123, NULL),
(12, 'persian private limited', 'chennai', NULL, 'p@gmail.com', 'software', 123, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `job_role` varchar(100) DEFAULT NULL,
  `salary` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `location` varchar(100) NOT NULL,
  `cgpa` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `company_id`, `job_role`, `salary`, `description`, `skills`, `location`, `cgpa`) VALUES
(6, 2, 'software engineer', '20000', 'passionate about coding', 'python,java , mysql', 'chennai', 8),
(7, 4, 'software engineer', '20000', 'beginner coding', NULL, '', NULL),
(9, 3, 'accountant', '20000', 'candidate with accounts knowledge', 'python,java , mysql', 'chennai', 5),
(11, 3, 'web developer', '3LPA', 'We are looking for talented software engineers to join our dynamic team. Work on cutting-edge projects using modern technologies.', 'python,java , mysql', 'chennai', 8),
(13, 3, 'junior web developer', '3LPA', 'a passionate beginner willing to learn needed  ', 'java ,c++', 'chennai', 8);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `cgpa` float DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Not Placed',
  `roll_no` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `company` varchar(255) DEFAULT '',
  `placed_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `department`, `cgpa`, `password`, `status`, `roll_no`, `phone`, `year`, `skills`, `company`, `placed_date`) VALUES
(8, 'amala', 'amala@gmailcom', 'computer science', 8.5, '123', 'Placed', NULL, NULL, NULL, NULL, 'techspark', '2026-04-01'),
(10, 'leena', 'leena@gmail.com', 'computer science', 8, '123', 'Placed', 'sj8765', '987654321', '1st Year', 'python,java , mysql', 'techspark', '2026-04-01'),
(14, 'mary', 'm@gmail.com', 'computer science', 8, '123', 'Placed', 'cj1234', '987654321', 'final year', 'python,java , mysql', 'techspark', '2026-04-01'),
(15, 'don', 'd@gmail.com', 'computer science', 8, '123', 'Placed', NULL, NULL, NULL, NULL, 'techspark', '2026-04-01'),
(16, 'kavi', 'k@gmail.com', 'computer science', 7, '123', 'Placed', NULL, NULL, NULL, NULL, 'techspark', '2026-04-01'),
(19, 'ravi', 'r@gmail.com', 'computer science', 8, '123', 'Placed', NULL, NULL, NULL, NULL, 'techspark', '2026-04-01'),
(23, 'moni', 'moni@gmail.com', 'computer science', 7.5, '123', 'Not Placed', NULL, NULL, NULL, NULL, 'null', '0000-00-00'),
(27, 'pradeep', 'p@gmail.com', 'computer science', 8, '123', 'Not Placed', 'cjs123', '987654321', NULL, 'python,java , mysql', '', '0000-00-00'),
(31, 'priya', 'priya@gmail.com', 'computer science', 8, '123', 'Not Placed', 'cjs125', '987654321', NULL, 'python,java , mysql', '', NULL),
(33, 'Divya', 'divya@gmail.com', 'computer science', 8, 'divya', 'Not Placed', 'sjc001', '987654321', NULL, 'java ,c++', '', NULL),
(34, 'ram', 'r@gmail.com', 'computer science', 8, '123', 'Not Placed', 'cjs123', '987654321', NULL, 'python,java , mysql', '', NULL),
(35, 'ram', 'ram@gmail.com', 'computer science', 8, '123', 'Not Placed', 'sjc202', '987654321', NULL, 'python,java , mysql', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin123', NULL),
(2, 'admin', 'admin123', 'admin'),
(3, 'admin', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
