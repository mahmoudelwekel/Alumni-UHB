-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2021 at 07:27 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uhb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `salt`) VALUES
(1, 'Absy', 'a@a.com', 'b6ec74854fdd31c590fc2958fd69fd155baa97d5', 'ee224b109a');

-- --------------------------------------------------------

--
-- Table structure for table `alumnuses`
--

CREATE TABLE `alumnuses` (
  `id` int(11) NOT NULL,
  `SSN` varchar(255) NOT NULL,
  `alu_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `alumnus_course`
--

CREATE TABLE `alumnus_course` (
  `id` int(11) NOT NULL,
  `alumnus_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `rate` tinyint(3) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `alumnus_lecturer_rate`
--

CREATE TABLE `alumnus_lecturer_rate` (
  `id` int(11) NOT NULL,
  `alumnus_id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `rate` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `alumnus_workshop`
--

CREATE TABLE `alumnus_workshop` (
  `id` int(11) NOT NULL,
  `alumnus_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `rate` tinyint(3) DEFAULT NULL,
  `certificate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `catg_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catg_name`) VALUES
(1, 'catg');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `colg_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `colleges`
--

INSERT INTO `colleges` (`id`, `colg_name`) VALUES
(1, 'fci'),
(2, 'engineering'),
(3, 'medicine ');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `crs_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `deadline` date NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `crs_name`, `location`, `details`, `start_date`, `end_date`, `deadline`, `lecturer_id`, `category_id`) VALUES
(2, 'php', 'cairo', 'php course', '2021-02-01', '2021-05-01', '2021-05-25', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_job`
--

CREATE TABLE `course_job` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dept_name` varchar(255) NOT NULL,
  `college_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `college_id`) VALUES
(1, 'se', 1);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `job_name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE `lecturers` (
  `id` int(11) NOT NULL,
  `SSN` varchar(255) NOT NULL,
  `lec_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `cv` varchar(255) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `SSN`, `lec_name`, `email`, `password`, `salt`, `phone`, `cv`, `department_id`) VALUES
(5, '123654', 'Amr El-Absy', 'amrelabsy55@gmail.com', 'b6ec74854fdd31c590fc2958fd69fd155baa97d5', 'ee224b109a', '01066484685', '7622767cv.pdf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_workshop`
--

CREATE TABLE `lecturer_workshop` (
  `id` int(11) NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `wshop_name` varchar(255) NOT NULL,
  `deadline` date NOT NULL,
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `workshop_job`
--

CREATE TABLE `workshop_job` (
  `id` int(11) NOT NULL,
  `workshop_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumnuses`
--
ALTER TABLE `alumnuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `SSN` (`SSN`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `alumnus_department` (`department_id`);

--
-- Indexes for table `alumnus_course`
--
ALTER TABLE `alumnus_course`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnus_course_alumnus` (`alumnus_id`),
  ADD KEY `alumnus_course_course` (`course_id`);

--
-- Indexes for table `alumnus_lecturer_rate`
--
ALTER TABLE `alumnus_lecturer_rate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnus_lecturer_alumnus` (`alumnus_id`),
  ADD KEY `alumnus_lecturer_lecturer` (`lecturer_id`),
  ADD KEY `alumnus_lecturer_course` (`course_id`);

--
-- Indexes for table `alumnus_workshop`
--
ALTER TABLE `alumnus_workshop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumnus_workshop_alumnus` (`alumnus_id`),
  ADD KEY `alumnus_workshop_workshop` (`workshop_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_lecturer` (`lecturer_id`),
  ADD KEY `course_category` (`category_id`);

--
-- Indexes for table `course_job`
--
ALTER TABLE `course_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_job_course` (`course_id`),
  ADD KEY `course_job_job` (`job_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_college` (`college_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `SSN` (`SSN`),
  ADD KEY `lecturer_department` (`department_id`);

--
-- Indexes for table `lecturer_workshop`
--
ALTER TABLE `lecturer_workshop`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lecturer_workshop_lecturer` (`lecturer_id`),
  ADD KEY `lecturer_workshop_workshop` (`workshop_id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_category` (`category_id`);

--
-- Indexes for table `workshop_job`
--
ALTER TABLE `workshop_job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workshop_job_workshop` (`workshop_id`),
  ADD KEY `workshop_job_job` (`job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumnuses`
--
ALTER TABLE `alumnuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumnus_course`
--
ALTER TABLE `alumnus_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumnus_lecturer_rate`
--
ALTER TABLE `alumnus_lecturer_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alumnus_workshop`
--
ALTER TABLE `alumnus_workshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_job`
--
ALTER TABLE `course_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workshop_job`
--
ALTER TABLE `workshop_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumnuses`
--
ALTER TABLE `alumnuses`
  ADD CONSTRAINT `alumnus_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumnus_course`
--
ALTER TABLE `alumnus_course`
  ADD CONSTRAINT `alumnus_course_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumnuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_course_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumnus_lecturer_rate`
--
ALTER TABLE `alumnus_lecturer_rate`
  ADD CONSTRAINT `alumnus_lecturer_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumnuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_lecturer_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_lecturer_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumnus_workshop`
--
ALTER TABLE `alumnus_workshop`
  ADD CONSTRAINT `alumnus_workshop_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumnuses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_workshop_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `course_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_job`
--
ALTER TABLE `course_job`
  ADD CONSTRAINT `course_job_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `course_job_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `department_college` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lecturers`
--
ALTER TABLE `lecturers`
  ADD CONSTRAINT `lecturer_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lecturer_workshop`
--
ALTER TABLE `lecturer_workshop`
  ADD CONSTRAINT `lecturer_workshop_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lecturer_workshop_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshops`
--
ALTER TABLE `workshops`
  ADD CONSTRAINT `workshop_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workshop_job`
--
ALTER TABLE `workshop_job`
  ADD CONSTRAINT `workshop_job_job` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `workshop_job_workshop` FOREIGN KEY (`workshop_id`) REFERENCES `workshops` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
