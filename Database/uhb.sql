-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2021 at 10:56 AM
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
(1, 'Nawal', 'admin', 'cb69e004b3c23a929e5f1718afbd7e897008ad1d', 'ee224b109a');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `SSN` varchar(255) NOT NULL,
  `alu_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `department_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `SSN`, `alu_name`, `email`, `password`, `salt`, `phone`, `department_id`) VALUES
(2, '108546322', 'Amjad Lafi Almutiri', 's2171003385@uhb.edu.sa', 'df079270fd982a014b7247553536140cfafc788b', 'bd85aa5285', '0509125111', 1),
(3, '108546321', 'Nawal Faisal Al Enazy', 'e2171003267@uhb.edu.sa', '2ee9cb7249275a591f745f3b6bafb63e90b04356', '5136e4e6f7', '0509125222', 1),
(4, '108546323', 'Abeer Faisal Alenizy', 's2171003269@uhb.edu.sa', '739bc664f358635e353f67546732d0153c19079f', '7b88fb8c90', '0509125333', 1),
(5, '108546324', 'Noura Saleh Alharbi', 's2171003373@uhb.edu.sa', '69e868e966c3542892f2bb8b18502cade5a0544f', 'c21e46305d', '0509125444', 1);

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

--
-- Dumping data for table `alumnus_course`
--

INSERT INTO `alumnus_course` (`id`, `alumnus_id`, `course_id`, `comment`, `rate`, `certificate`) VALUES
(1, 3, 5, NULL, NULL, NULL);

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

--
-- Dumping data for table `alumnus_workshop`
--

INSERT INTO `alumnus_workshop` (`id`, `alumnus_id`, `workshop_id`, `comment`, `rate`, `certificate`) VALUES
(1, 3, 4, NULL, NULL, NULL),
(2, 2, 4, NULL, NULL, NULL);

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
(1, 'General Health'),
(2, 'Social Affair'),
(3, 'Science'),
(4, 'Engineering'),
(5, 'Computer Science');

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
(1, 'Computer Science and Engineering College'),
(2, 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `crs_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `deadline` date NOT NULL,
  `lecturer_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `crs_name`, `location`, `details`, `start_date`, `end_date`, `deadline`, `lecturer_id`, `category_id`) VALUES
(5, 'Technical writing skills', 'AL Yasmin campus ', '..', '2021-03-20 07:06:00', '1970-01-01 01:33:41', '2021-04-14', 5, 5);

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
(1, 'Computer Science', 1),
(2, 'Data Science', 1),
(3, 'Cyber Security', 1),
(4, 'Software Programming', 1),
(5, 'Mathematics', 2),
(6, 'Biology', 2),
(7, 'Chemistry', 2),
(8, 'Physics ', 2);

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

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_name`, `company`, `details`, `link`) VALUES
(1, 'job1', 'company1', 'a lot of details', 'link.com');

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
  `department_id` int(11) NOT NULL,
  `gender` tinyint(1) NOT NULL COMMENT '0: male, 1:female'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`id`, `SSN`, `lec_name`, `email`, `password`, `salt`, `phone`, `cv`, `department_id`, `gender`) VALUES
(5, '1012345678', 'Manal Hassan', 'manal@uhb.edu.sa', 'b6ec74854fdd31c590fc2958fd69fd155baa97d5', 'ee224b109a', '0501234567', '7622767cv.pdf', 1, 1),
(6, '1234567890', 'Alaa Al Harbi', 'alaa@uhb.edu.sa', '3e1ca33085245e6b60e957b5369ce41de0ee76c5', '24a8a4f2fe', '0507654321', '3547111cv.pdf', 1, 0);

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

--
-- Dumping data for table `lecturer_workshop`
--

INSERT INTO `lecturer_workshop` (`id`, `lecturer_id`, `workshop_id`, `start_date`, `end_date`) VALUES
(1, 5, 4, '0000-00-00', '0000-00-00'),
(2, 6, 4, '0000-00-00', '0000-00-00');

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

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `wshop_name`, `deadline`, `location`, `details`, `category_id`) VALUES
(4, 'Software intensive student projects', '2021-05-04', 'Al Yasmin Campus', '..', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `alumnus_course`
--
ALTER TABLE `alumnus_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumnus_lecturer_rate`
--
ALTER TABLE `alumnus_lecturer_rate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alumnus_workshop`
--
ALTER TABLE `alumnus_workshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `course_job`
--
ALTER TABLE `course_job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lecturers`
--
ALTER TABLE `lecturers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lecturer_workshop`
--
ALTER TABLE `lecturer_workshop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `alumnus_department` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumnus_course`
--
ALTER TABLE `alumnus_course`
  ADD CONSTRAINT `alumnus_course_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_course_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `alumnus_lecturer_rate`
--
ALTER TABLE `alumnus_lecturer_rate`
  ADD CONSTRAINT `alumnus_lecturer_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_lecturer_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `alumnus_lecturer_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumnus_workshop`
--
ALTER TABLE `alumnus_workshop`
  ADD CONSTRAINT `alumnus_workshop_alumnus` FOREIGN KEY (`alumnus_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
