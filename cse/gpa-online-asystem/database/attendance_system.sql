-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2026 at 08:11 AM
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
-- Database: `gpaa_attendance_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `profile_image`) VALUES
(1, 'Super Admin', 'admin@example.com', '$2y$10$EtPv.NDVFDSn70E3kmyX8.D.a11jRAA9OCnOrucOpAZ2kh80UjbBO', 'admin_1_1770716336.png');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` enum('Present','Absent') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `teacher_id`, `branch`, `semester`, `year`, `date`, `status`, `created_at`) VALUES
(1, 1, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 08:51:50'),
(2, 2, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:42:32'),
(3, 3, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:42:32'),
(4, 4, NULL, NULL, NULL, NULL, '2026-02-10', 'Absent', '2026-02-10 16:42:32'),
(5, 5, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:42:32'),
(6, 6, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:42:32'),
(7, 11, NULL, NULL, NULL, NULL, '2026-02-10', 'Absent', '2026-02-10 16:42:32'),
(8, 7, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:45:26'),
(9, 8, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:45:26'),
(10, 9, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:45:26'),
(11, 10, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:45:26'),
(12, 12, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:47:17'),
(13, 13, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:47:17'),
(14, 14, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:47:17'),
(15, 15, NULL, NULL, NULL, NULL, '2026-02-10', 'Present', '2026-02-10 16:47:17'),
(16, 17, NULL, NULL, NULL, NULL, '2026-02-10', 'Absent', '2026-02-10 16:47:17'),
(17, 1, NULL, NULL, NULL, NULL, '2026-02-11', 'Present', '2026-02-11 05:21:10'),
(18, 2, NULL, NULL, NULL, NULL, '2026-02-11', 'Absent', '2026-02-11 05:21:10'),
(19, 3, NULL, NULL, NULL, NULL, '2026-02-11', 'Absent', '2026-02-11 05:21:10'),
(20, 4, NULL, NULL, NULL, NULL, '2026-02-11', 'Absent', '2026-02-11 05:21:10'),
(21, 5, NULL, NULL, NULL, NULL, '2026-02-11', 'Present', '2026-02-11 05:21:10'),
(22, 6, NULL, NULL, NULL, NULL, '2026-02-11', 'Present', '2026-02-11 05:21:10'),
(23, 11, NULL, NULL, NULL, NULL, '2026-02-11', 'Present', '2026-02-11 05:21:10'),
(24, 1, NULL, NULL, NULL, NULL, '2026-02-12', 'Present', '2026-02-11 23:58:22'),
(25, 2, NULL, NULL, NULL, NULL, '2026-02-12', 'Present', '2026-02-11 23:58:22'),
(26, 3, NULL, NULL, NULL, NULL, '2026-02-12', 'Present', '2026-02-11 23:58:22'),
(27, 4, NULL, NULL, NULL, NULL, '2026-02-12', 'Absent', '2026-02-11 23:58:22'),
(28, 5, NULL, NULL, NULL, NULL, '2026-02-12', 'Present', '2026-02-11 23:58:22'),
(29, 6, NULL, NULL, NULL, NULL, '2026-02-12', 'Absent', '2026-02-11 23:58:22'),
(30, 11, NULL, NULL, NULL, NULL, '2026-02-12', 'Present', '2026-02-11 23:58:22'),
(31, 1, NULL, NULL, NULL, NULL, '2026-02-17', 'Present', '2026-02-17 15:02:44'),
(32, 2, NULL, NULL, NULL, NULL, '2026-02-17', 'Present', '2026-02-17 15:02:44'),
(33, 3, NULL, NULL, NULL, NULL, '2026-02-17', 'Present', '2026-02-17 15:02:44'),
(34, 4, NULL, NULL, NULL, NULL, '2026-02-17', 'Absent', '2026-02-17 15:02:44'),
(35, 5, NULL, NULL, NULL, NULL, '2026-02-17', 'Absent', '2026-02-17 15:02:44'),
(36, 6, NULL, NULL, NULL, NULL, '2026-02-17', 'Present', '2026-02-17 15:02:44'),
(37, 11, NULL, NULL, NULL, NULL, '2026-02-17', 'Present', '2026-02-17 15:02:44'),
(38, 1, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(39, 2, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(40, 3, NULL, NULL, NULL, NULL, '2026-03-02', 'Absent', '2026-03-02 07:14:20'),
(41, 4, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(42, 5, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(43, 6, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(44, 11, NULL, NULL, NULL, NULL, '2026-03-02', 'Present', '2026-03-02 07:14:20'),
(45, 7, NULL, NULL, NULL, NULL, '2026-03-03', 'Present', '2026-03-03 05:41:20'),
(46, 8, NULL, NULL, NULL, NULL, '2026-03-03', 'Present', '2026-03-03 05:41:20'),
(47, 9, NULL, NULL, NULL, NULL, '2026-03-03', 'Present', '2026-03-03 05:41:20'),
(48, 10, NULL, NULL, NULL, NULL, '2026-03-03', 'Absent', '2026-03-03 05:41:20'),
(49, 7, NULL, NULL, NULL, NULL, '2026-03-04', 'Present', '2026-03-04 09:54:52'),
(50, 8, NULL, NULL, NULL, NULL, '2026-03-04', 'Present', '2026-03-04 09:54:52'),
(51, 9, NULL, NULL, NULL, NULL, '2026-03-04', 'Present', '2026-03-04 09:54:52'),
(52, 10, NULL, NULL, NULL, NULL, '2026-03-04', 'Present', '2026-03-04 09:54:52'),
(53, 1, NULL, NULL, NULL, NULL, '2026-03-13', 'Present', '2026-03-13 16:52:07'),
(54, 2, NULL, NULL, NULL, NULL, '2026-03-13', 'Present', '2026-03-13 16:52:07'),
(55, 3, NULL, NULL, NULL, NULL, '2026-03-13', 'Absent', '2026-03-13 16:52:07'),
(56, 4, NULL, NULL, NULL, NULL, '2026-03-13', 'Present', '2026-03-13 16:52:07'),
(57, 5, NULL, NULL, NULL, NULL, '2026-03-13', 'Present', '2026-03-13 16:52:07'),
(58, 6, NULL, NULL, NULL, NULL, '2026-03-13', 'Present', '2026-03-13 16:52:07'),
(59, 11, NULL, NULL, NULL, NULL, '2026-03-13', 'Absent', '2026-03-13 16:52:07'),
(60, 1, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(61, 2, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(62, 3, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(63, 4, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(64, 5, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(65, 6, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(66, 11, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(67, 26, NULL, NULL, NULL, NULL, '2026-03-25', 'Present', '2026-03-25 17:07:23'),
(68, 1, NULL, NULL, NULL, NULL, '2026-03-27', 'Present', '2026-03-27 06:15:30'),
(69, 2, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(70, 3, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(71, 4, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(72, 5, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(73, 6, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(74, 11, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(75, 26, NULL, NULL, NULL, NULL, '2026-03-27', 'Absent', '2026-03-27 06:15:30'),
(76, 27, NULL, NULL, NULL, NULL, '2026-03-27', 'Present', '2026-03-27 06:15:30'),
(77, 1, NULL, NULL, NULL, NULL, '2026-04-02', 'Absent', '2026-04-02 07:33:21'),
(78, 2, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21'),
(79, 3, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21'),
(80, 4, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21'),
(81, 5, NULL, NULL, NULL, NULL, '2026-04-02', 'Absent', '2026-04-02 07:33:21'),
(82, 6, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21'),
(83, 11, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21'),
(84, 26, NULL, NULL, NULL, NULL, '2026-04-02', 'Absent', '2026-04-02 07:33:21'),
(85, 27, NULL, NULL, NULL, NULL, '2026-04-02', 'Absent', '2026-04-02 07:33:21'),
(86, 31, NULL, NULL, NULL, NULL, '2026-04-02', 'Present', '2026-04-02 07:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `enquiries`
--

CREATE TABLE `enquiries` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `subject` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_schedules`
--

CREATE TABLE `exam_schedules` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `exam_type` varchar(100) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `upload_date` date DEFAULT NULL,
  `exam_start_date` date DEFAULT NULL,
  `exam_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_schedules`
--

INSERT INTO `exam_schedules` (`id`, `title`, `exam_type`, `file_name`, `upload_date`, `exam_start_date`, `exam_end_date`) VALUES
(2, 'First Sessional Exam', 'Sessional Exam', 'Abhigyan 1.pdf', '2026-03-14', NULL, NULL),
(3, 'First Sessional Exam', 'Mid Term', '1600w-FtCaHp3Bl7A.webp', '2026-03-14', '2026-03-10', '2026-03-15'),
(4, 'First Sessional Exam', 'Mid Term', '1600w-FtCaHp3Bl7A.webp', '2026-03-14', '2026-03-10', '2026-03-15'),
(5, 'First Sessional Exam', 'Mid Term', '1600w-FtCaHp3Bl7A.webp', '2026-03-14', '2026-03-10', '2026-03-15'),
(6, 'Second Sessional', 'Mid Term', 'download.png', '2026-03-14', '2026-04-10', '2026-04-16'),
(7, 'third sessional', 'Mid Term', '1600w-FtCaHp3Bl7A.webp', '2026-03-14', '2026-03-15', '2026-03-20'),
(8, 'practical exam', 'Practical', 'ashoka.png', '2026-03-14', '2026-05-12', '2026-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `description`, `image`, `upload_date`) VALUES
(3, 'collage building', 'Government Polytechnic Atraulia Azamgarh', 'main.jpeg', '2026-03-15 22:00:13'),
(4, 'Collage Principal', 'Dr. Subodh Kant Singh is the Principal of Government Polytechnic Atraulia, Azamgarh,', 'images.jpeg', '2026-03-15 22:29:39'),
(5, 'Student Image', 'Nitish Kumar Yadav, who is a third-year Computer Science and Engineering student at this college.', 'Made_with_insMind--removebg-preview.png', '2026-03-15 22:36:41');

-- --------------------------------------------------------

--
-- Table structure for table `grievances`
--

CREATE TABLE `grievances` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `send_to` enum('teacher','admin') NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `status` enum('pending','in_progress','resolved') DEFAULT 'pending',
  `admin_reply` text DEFAULT NULL,
  `teacher_reply` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grievances`
--

INSERT INTO `grievances` (`id`, `student_id`, `teacher_id`, `send_to`, `title`, `description`, `category`, `file`, `status`, `admin_reply`, `teacher_reply`, `created_at`) VALUES
(1, 1, 2, 'teacher', 'Formal Grievance', '\r\nI am writing to formally submit a grievance regarding [briefly state the issue, e.g., unfair treatment, policy violation, safety concern] which occurred on [01/04/2026].\r\n \r\nOn [Date] at [Time, provide a clear, objective account of what happened. Include who was involved, what was said/done, and any witnesses]. \r\n\r\nI previously tried to resolve this issue by [mention previous conversations, emails, or informal reports to managers] on [Date], but [state why it wasn\'t resolved]. \r\n\r\nThis issue has caused [explain how it affected you—e.g., workload, health, work environment]. \r\nLegal Ombudsman\r\n\r\n\r\nTo resolve this matter, I request [state what you want to happen, e.g., formal investigation, policy review, corrective action]. \r\n\r\nI look forward to a reply within [Number] days, as per company policy. Thank you for your attention to this matter.', 'Other', NULL, 'in_progress', 'your complain is approve', 'your complain is approve', '2026-03-31 17:08:54'),
(3, 1, 2, 'teacher', 'Grievance regarding [rejection / delay / incorrect deduction] of my leave application', 'From:\r\n[Aapka Naam]\r\n[Aapka Designation / Department]\r\n[Aapka Employee ID]\r\n\r\nDate: [Aaj ki Date]\r\n\r\nTo:\r\n[Manager ya HR ka Naam]\r\n[Unka Designation, e.g., HR Manager]\r\n[Company ka Naam]\r\n\r\nSubject: Grievance regarding [rejection / delay / incorrect deduction] of my leave application\r\n\r\nDear [Manager/HR ka Naam],\r\n\r\nI am writing to formally lodge a grievance regarding my recent leave application for the period from [Start Date] to [End Date].\r\n\r\nI had applied for [Leave Type, e.g., Sick Leave / Casual Leave / Annual Leave] on [Date of Application] due to [Reason for leave, e.g., a medical emergency / urgent personal work]. However, I was informed that my leave has been [mention the issue: e.g., rejected without clear justification / kept pending for too long / approved but my leave balance was incorrectly deducted].\r\n\r\n(Agar aapne pehle is baare mein baat ki hai, toh yeh line jodein:)\r\nI had previously discussed this issue verbally with [Name of person you spoke to] on [Date of discussion], but the matter remains unresolved.\r\n\r\nAs I had followed all the standard company procedures and provided sufficient notice (or valid documentation), this decision is causing me considerable distress and inconvenience.\r\n\r\nI request you to kindly review my leave application again and resolve this discrepancy at the earliest. I have attached the relevant documents/system screenshots for your reference.\r\n\r\nI look forward to a prompt and fair resolution to this matter.\r\n\r\nSincerely,\r\n\r\n[Aapka Signature]\r\n[Aapka Naam]\r\n[Contact Number]', 'Other', NULL, 'pending', NULL, NULL, '2026-04-02 21:13:41'),
(4, 1, 2, 'teacher', 'Grievance regarding [rejection / delay / incorrect deduction] of my leave application', 'From:\r\n[Aapka Naam]\r\n[Aapka Designation / Department]\r\n[Aapka Employee ID]\r\n\r\nDate: [Aaj ki Date]\r\n\r\nTo:\r\n[Manager ya HR ka Naam]\r\n[Unka Designation, e.g., HR Manager]\r\n[Company ka Naam]\r\n\r\nSubject: Grievance regarding [rejection / delay / incorrect deduction] of my leave application\r\n\r\nDear [Manager/HR ka Naam],\r\n\r\nI am writing to formally lodge a grievance regarding my recent leave application for the period from [Start Date] to [End Date].\r\n\r\nI had applied for [Leave Type, e.g., Sick Leave / Casual Leave / Annual Leave] on [Date of Application] due to [Reason for leave, e.g., a medical emergency / urgent personal work]. However, I was informed that my leave has been [mention the issue: e.g., rejected without clear justification / kept pending for too long / approved but my leave balance was incorrectly deducted].\r\n\r\n(Agar aapne pehle is baare mein baat ki hai, toh yeh line jodein:)\r\nI had previously discussed this issue verbally with [Name of person you spoke to] on [Date of discussion], but the matter remains unresolved.\r\n\r\nAs I had followed all the standard company procedures and provided sufficient notice (or valid documentation), this decision is causing me considerable distress and inconvenience.\r\n\r\nI request you to kindly review my leave application again and resolve this discrepancy at the earliest. I have attached the relevant documents/system screenshots for your reference.\r\n\r\nI look forward to a prompt and fair resolution to this matter.\r\n\r\nSincerely,\r\n\r\n[Aapka Signature]\r\n[Aapka Naam]\r\n[Contact Number]', 'Other', NULL, 'pending', NULL, NULL, '2026-04-02 21:18:52'),
(5, 1, 2, 'teacher', 'Application regarding [Extension of time for fee payment / Fee Concession / Grievance about extra fees]', 'To,\r\nThe Principal / Head of Department,\r\nGovernment Polytechnic Chunar,\r\nMirzapur, Uttar Pradesh\r\n\r\nDate: [Aaj ki Date]\r\n\r\nSubject: Application regarding [Extension of time for fee payment / Fee Concession / Grievance about extra fees]\r\n\r\nRespected Sir/Madam,\r\n\r\nI, Nitish Kumar Yadav, am a student of [Aapka Branch/Course, e.g., Diploma in Computer Science], studying in the [Aapka Year/Semester, e.g., 2nd Year, 4th Semester] at your esteemed institution. My Roll Number / Enrollment Number is [Aapka Roll Number].\r\n\r\nI am writing to respectfully bring to your attention that [yahan apni main problem likhein. Neeche diye gaye 3 options mein se koi ek chunein]:\r\n\r\nOption 1 (Waqt mangne ke liye): ...due to some unexpected financial difficulties in my family, I am unable to pay my semester fees by the upcoming deadline. I kindly request you to grant me an extension of [Number of days/weeks, e.g., 15 days] so that I can arrange the funds.\r\n\r\nOption 2 (Concession mangne ke liye): ...my family is currently facing severe financial hardship, making it very difficult to afford the full tuition fees for this semester. I humbly request you to consider granting me a fee concession so that I can continue my studies without interruption.\r\n\r\nOption 3 (Grievance/Extra fee ke liye): ...I have noticed an additional charge of [Amount] under the head of [Reason given for fee, e.g., Library late fee / Lab charges] in my fee receipt. I believe this has been charged incorrectly because [Reason, e.g., I have already returned all books / paid this amount previously].\r\n\r\nI have always been sincere in my studies and maintain a good academic record. I have attached the necessary documents [jaise ki previous fee receipt, income certificate, etc.] with this application for your reference.\r\n\r\nI humbly request you to look into this matter and grant my request. I will be highly obliged for your support.\r\n\r\nThanking you,\r\n\r\nYours obediently,\r\n\r\nNitish Kumar Yadav\r\n[Aapka Branch / Year]\r\n[Aapka Roll Number]\r\n[Aapka Mobile Number]', 'Fee Issue', NULL, 'pending', NULL, NULL, '2026-04-02 21:20:15'),
(6, 1, 2, 'teacher', 'Application regarding [Extension of time for fee payment / Fee Concession / Grievance about extra fees]', 'To,\r\nThe Principal / Head of Department,\r\nGovernment Polytechnic Chunar,\r\nMirzapur, Uttar Pradesh\r\n\r\nDate: [Aaj ki Date]\r\n\r\nSubject: Application regarding [Extension of time for fee payment / Fee Concession / Grievance about extra fees]\r\n\r\nRespected Sir/Madam,\r\n\r\nI, Nitish Kumar Yadav, am a student of [Aapka Branch/Course, e.g., Diploma in Computer Science], studying in the [Aapka Year/Semester, e.g., 2nd Year, 4th Semester] at your esteemed institution. My Roll Number / Enrollment Number is [Aapka Roll Number].\r\n\r\nI am writing to respectfully bring to your attention that [yahan apni main problem likhein. Neeche diye gaye 3 options mein se koi ek chunein]:\r\n\r\nOption 1 (Waqt mangne ke liye): ...due to some unexpected financial difficulties in my family, I am unable to pay my semester fees by the upcoming deadline. I kindly request you to grant me an extension of [Number of days/weeks, e.g., 15 days] so that I can arrange the funds.\r\n\r\nOption 2 (Concession mangne ke liye): ...my family is currently facing severe financial hardship, making it very difficult to afford the full tuition fees for this semester. I humbly request you to consider granting me a fee concession so that I can continue my studies without interruption.\r\n\r\nOption 3 (Grievance/Extra fee ke liye): ...I have noticed an additional charge of [Amount] under the head of [Reason given for fee, e.g., Library late fee / Lab charges] in my fee receipt. I believe this has been charged incorrectly because [Reason, e.g., I have already returned all books / paid this amount previously].\r\n\r\nI have always been sincere in my studies and maintain a good academic record. I have attached the necessary documents [jaise ki previous fee receipt, income certificate, etc.] with this application for your reference.\r\n\r\nI humbly request you to look into this matter and grant my request. I will be highly obliged for your support.\r\n\r\nThanking you,\r\n\r\nYours obediently,\r\n\r\nNitish Kumar Yadav\r\n[Aapka Branch / Year]\r\n[Aapka Roll Number]\r\n[Aapka Mobile Number]', 'Fee Issue', NULL, 'pending', NULL, NULL, '2026-04-02 21:27:08'),
(7, 1, 2, 'teacher', 'Grievance regarding [Yahan apna main issue likhein, e.g., Incorrect Marks / Withheld Result / Missing Admit Card]', 'To,\r\nThe Principal / Controller of Examinations,\r\nGovernment Polytechnic Chunar,\r\nMirzapur, Uttar Pradesh\r\n\r\nDate: [Aaj ki Date]\r\n\r\nTitle / Subject: Grievance regarding [Yahan apna main issue likhein, e.g., Incorrect Marks / Withheld Result / Missing Admit Card]\r\n\r\nRespected Sir/Madam,\r\n\r\nI, Nitish Kumar Yadav, am a student of [Aapka Branch, e.g., Diploma in Computer Science], currently studying in the [Aapka Year/Semester]. My Board Roll Number / Enrollment Number is [Aapka Roll Number].\r\n\r\nI am writing to formally bring an urgent issue to your attention regarding the [Semester/Subject Name] examination, which was held on [Exam ki Date].\r\n\r\n[Neeche diye gaye options mein se apni problem select karke yahan likhein]:\r\n\r\nOption 1 (Result me Absent ya kam marks ke liye): Although I appeared for the examination and submitted my answer sheet correctly, my official result shows that I have been marked \'Absent\' (or my marks have been incorrectly updated / are unusually low).\r\n\r\nOption 2 (Admit Card na milne ya galti hone par): My upcoming semester exams are scheduled to start from [Date], but I have not yet received my admit card / there is a major error in my subjects/details on the issued admit card.\r\n\r\nOption 3 (Exam ke dauran paper ya technical issue ke liye): During the examination, I faced an issue where [Problem batayein, e.g., the question paper was out of syllabus / there was a severe technical glitch / answer sheet was not provided on time], which severely affected my ability to attempt the paper fairly.\r\n\r\nThis situation is causing me a lot of anxiety as it directly impacts my academic record. I request you to kindly investigate this matter on an urgent basis and take the necessary corrective actions.\r\n\r\nI have attached a copy of my [mention attached documents, e.g., Admit Card / Previous Marksheet / ID Card] for your reference.\r\n\r\nI am looking forward to a prompt and positive resolution.\r\n\r\nThanking you,\r\n\r\nYours obediently,\r\n\r\nNitish Kumar Yadav\r\n[Aapka Branch / Year]\r\n[Aapka Roll Number]\r\n[Aapka Mobile Number]', 'Exam Issue', NULL, 'pending', NULL, NULL, '2026-04-02 21:29:10'),
(8, 1, 2, 'teacher', 'Formal complaint regarding [Yahan apni problem ka chota sa title likhein, e.g., Poor Maintenance of Facilities / Unprofessional Behavior / Equipment Issue]', 'From:\r\nNitish Kumar Yadav\r\n[Aapka Designation/Branch/Course]\r\n[Aapka ID / Roll Number]\r\n\r\nDate: [Aaj ki Date]\r\n\r\nTo,\r\n[Option 1 - Agar College mein dena hai:]\r\nThe Principal / Head of Department\r\nGovernment Polytechnic Chunar,\r\nMirzapur, Uttar Pradesh\r\n\r\n[Option 2 - Agar Office/Company mein dena hai:]\r\nThe HR Manager / [Manager ka Naam]\r\nPolybond India Pvt. Ltd.\r\nSanaswadi Plant, Pune\r\n\r\nSubject: Formal complaint regarding [Yahan apni problem ka chota sa title likhein, e.g., Poor Maintenance of Facilities / Unprofessional Behavior / Equipment Issue]\r\n\r\nRespected Sir/Madam,\r\n\r\nI am writing this letter to formally register a complaint regarding [Apni problem ka brief mention karein, jaise: the continuous malfunctioning of computers in the lab / the lack of proper hygiene in the canteen / an issue with a colleague].\r\n\r\nOver the past [Kitne din/hafte se problem hai, e.g., two weeks], I have noticed that [Ab yahan apni problem detail mein likhein. Jaise kya ho raha hai, aur usse kya pareshani ho rahi hai]. For example: This issue is consistently disrupting my daily work/studies and causing a lot of inconvenience.\r\n\r\n(Agar aapne pehle complain ki hai, toh yeh line jodein:)\r\nI had previously reported this matter informally to [Jisko pehle bataya tha, unka naam] on [Pehle ki date], but unfortunately, no action has been taken yet to resolve it.\r\n\r\nI request you to kindly look into this matter seriously and take appropriate action as soon as possible to ensure a smooth environment for everyone.\r\n\r\nI have attached [Agar koi photo, screenshot, ya proof hai toh uska naam likhein, warna yeh line hata dein] for your reference.\r\n\r\nThank you for your time and understanding. I look forward to a quick resolution.\r\n\r\nYours faithfully/sincerely,\r\n\r\nNitish Kumar Yadav\r\n[Aapka Contact Number]\r\n[Aapka Email ID]', 'Other', NULL, 'resolved', NULL, 'your complain is approve', '2026-04-02 21:34:34');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `holiday_date` date NOT NULL,
  `reason` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `title`, `holiday_date`, `reason`, `created_at`) VALUES
(1, 'holy leave', '2026-03-04', '3 days leave for holy festival', '2026-02-12 00:37:14');

-- --------------------------------------------------------

--
-- Table structure for table `id_card_requests`
--

CREATE TABLE `id_card_requests` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_photo` varchar(255) DEFAULT NULL,
  `student_name` varchar(150) DEFAULT NULL,
  `father_name` varchar(150) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `roll_number` varchar(50) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `hod_signature` varchar(255) DEFAULT NULL,
  `college_mohar` varchar(255) DEFAULT NULL,
  `principal_signature` varchar(255) DEFAULT NULL,
  `status` enum('Pending_Teacher','Pending_Admin','Approved') DEFAULT 'Pending_Teacher',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `id_card_requests`
--

INSERT INTO `id_card_requests` (`id`, `student_id`, `teacher_id`, `student_photo`, `student_name`, `father_name`, `dob`, `roll_number`, `branch`, `semester`, `year`, `mobile`, `hod_signature`, `college_mohar`, `principal_signature`, `status`, `created_at`) VALUES
(2, 7, 8, '17725163764884.png', 'Dhruv Kumar', 'Sanjay', '2006-01-01', 'E23418935600012', 'E.E', NULL, '2023-2026', '9517648760', '17725173056569.png', '17725173058745.png', '17725174307663.png', 'Approved', '2026-03-03 05:39:36'),
(4, 2, 2, '17726015765585.png', 'Aadi Kumar', 'ashok', '2006-01-01', 'E23418935500009', 'CSE', NULL, '2023-2026', '9517648760', '17726017306826.png', '17726017303664.png', '17726017527026.png', 'Approved', '2026-03-04 05:19:36'),
(5, 9, 8, '17726180447198.png', 'Jay Kumar', 'Ramesh Kumar', '2005-02-02', 'E23418935600015', 'E.E', NULL, '2023-2026', '9517648760', '17726181267175.png', '17726181268156.png', '17726181586809.png', 'Approved', '2026-03-04 09:54:04'),
(6, 3, 2, '17730724427422.jpg', 'Avi ', 'Ashok Kumar', '2006-06-21', 'E23418935600015', 'CSE', NULL, '2023-2026', '9517648760', '17730725247732.png', '17730725246823.png', '17730726377540.png', 'Approved', '2026-03-09 16:07:22'),
(7, 1, 2, '17730787394895.png', 'Nitish Kumar Yadav', 'Ramayan Yadav', '2006-09-21', 'E23418935500008', 'Computer Science and Engineering', NULL, '2023-2024', '9517648760', '17730788093861.png', '17730788095834.png', '17730788435521.png', 'Approved', '2026-03-09 17:52:19'),
(8, 5, 2, '17734206013893.png', 'Ana ', 'Rajesh', '2005-09-10', 'E23418935600020', 'CSE', NULL, '2023-2026', '9517648760', '17734206835391.png', '17734206835891.png', '17734216438859.png', 'Approved', '2026-03-13 16:50:01'),
(9, 19, 8, '17734214919430.png', 'Siya', 'Sarvan', '2004-02-15', 'E23418944600020', 'E.E', NULL, '2024-2027', '9517648760', '17734215603832.png', '17734215603746.png', '17734216969508.png', 'Approved', '2026-03-13 17:04:51'),
(10, 6, 2, '17734990797952.png', 'Gia ', 'Ramesh', '0000-00-00', 'E234189355000025', 'CSE', NULL, '2023-2026', '9517648760', '17744594626758.png', '17744594626080.png', '17744603358074.png', 'Approved', '2026-03-14 14:37:59'),
(11, 27, 2, '17745914736999.jpg', 'Mohit Kumar Chaurasia', 'Dinesh Kumar', '2004-10-18', 'E23418935500033', 'CSE', NULL, '2023-2026', '8960335482', '17745915682496.png', '17745915682982.png', '17745916258574.png', 'Approved', '2026-03-27 06:04:33'),
(12, 31, 17, '17751153506862.png', 'Aditya Kumar', 'Ashok Kumar', '2006-05-21', 'E23418935500021', 'CSE', NULL, '2023-2026', '9517648760', '17751154044988.png', '17751154045294.png', '17751154376427.png', 'Approved', '2026-04-02 07:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `leave_type` enum('half','full') NOT NULL,
  `leave_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','in_review','approved','rejected') DEFAULT 'pending',
  `teacher_remark` text DEFAULT NULL,
  `principal_remark` text DEFAULT NULL,
  `parent_verified` enum('yes','no') DEFAULT 'no',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `student_id`, `teacher_id`, `leave_type`, `leave_date`, `reason`, `status`, `teacher_remark`, `principal_remark`, `parent_verified`, `created_at`) VALUES
(1, 1, 2, 'full', '2026-04-03', 'To,\r\nThe HOD / Principal,\r\n[Apne College ka Naam],\r\n[College ka Address].\r\n\r\nSubject: Application for Half-Day Leave.\r\n\r\nRespected Sir/Madam,\r\n\r\nMain [Aapka Naam], aapke college mein [Aapki Branch/Department] ka [Semester/Year] ka student hoon.\r\n\r\nMujhe aaj zaroori kaam se (ya ghar par kisi emergency ki wajah se) lunch ke baad ghar jaana pad raha hai. Isliye, main baaki ke lectures attend nahi kar paaunga.\r\n\r\nKripya karke mujhe aaj, [Aaj ki Date], ko lunch ke baad half-day leave grant karne ki kripa karein.\r\n\r\nMain waada karta hoon ki chhoote huye kaam ko main jald hi poora kar loonga.\r\n\r\nThanking you,\r\n\r\nYours sincerely,\r\n\r\nName: [Aapka Naam]\r\nRoll No: [Aapka Roll Number]\r\nDate: [Aaj ki Date]\r\nSignature: ______________', 'approved', 'nxhsid', 'mslm', 'no', '2026-04-03 00:08:33');

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `notice_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`id`, `title`, `description`, `notice_date`, `created_at`) VALUES
(4, 'jogfx', 'kfpakfpaS  znouadma fisuj9aufa andaih9adua nadnaj', '2026-03-13', '2026-03-14 06:17:45'),
(5, 'first sessional exam', 'सभी स्टूडेंट्स ध्यान दे की फर्स्ट सेशनल एग्जाम २०/०३/२०२६ को स्टार्ट हो रहा है ', '2026-03-20', '2026-03-14 17:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `principal_messages`
--

CREATE TABLE `principal_messages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `principal_messages`
--

INSERT INTO `principal_messages` (`id`, `title`, `message`, `created_at`) VALUES
(5, 'Dear Students,', 'It gives me great pleasure to welcome you to Government Polytechnic Atraulia, Azamgarh. Our institution is dedicated to providing quality technical education and developing practical skills and strong moral values among students.\r\n\r\nIn today’s competitive world, book knowledge alone is not enough. Technical skills, innovative thinking, and discipline are equally important. Our college focuses not only on academic excellence but also on the overall personality development of students.\r\n\r\nOur experienced and dedicated faculty members continuously guide and motivate students to achieve their goals and build a bright future. We strive to create an environment that encourages learning, creativity, and professional growth.\r\n\r\nI encourage all students to take full advantage of the opportunities provided by the institution, work hard, and stay committed to their dreams.\r\n\r\nMy best wishes to all of you for a successful and bright future.\r\n\r\nPrincipal', '2026-03-16 23:17:39'),
(6, 'Dear Students,', 'It gives me great pleasure to welcome you to Government Polytechnic Atraulia, Azamgarh. Our institution is dedicated to providing quality technical education and developing practical skills and strong moral values among students.\r\n\r\nIn today’s competitive world, book knowledge alone is not enough. Technical skills, innovative thinking, and discipline are equally important. Our college focuses not only on academic excellence but also on the overall personality development of students.\r\n\r\nOur experienced and dedicated faculty members continuously guide and motivate students to achieve their goals and build a bright future. We strive to create an environment that encourages learning, creativity, and professional growth.\r\n\r\nI encourage all students to take full advantage of the opportunities provided by the institution, work hard, and stay committed to their dreams.\r\n\r\nMy best wishes to all of you for a successful and bright future.\r\n\r\nPrincipal', '2026-03-16 23:17:53'),
(7, 'प्रिय विद्यार्थियों,', 'Government Polytechnic Atraulia, Azamgarh में आपका स्वागत करते हुए मुझे अत्यंत प्रसन्नता हो रही है। हमारा संस्थान तकनीकी शिक्षा के क्षेत्र में गुणवत्तापूर्ण ज्ञान, व्यावहारिक कौशल और नैतिक मूल्यों के विकास के लिए निरंतर प्रयासरत है।\r\n\r\nआज के प्रतिस्पर्धात्मक युग में केवल पुस्तक ज्ञान ही पर्याप्त नहीं है, बल्कि तकनीकी दक्षता, नवाचार की सोच और अनुशासन भी उतने ही महत्वपूर्ण हैं। हमारा महाविद्यालय विद्यार्थियों को आधुनिक तकनीकी ज्ञान के साथ-साथ उनके व्यक्तित्व के सर्वांगीण विकास पर भी विशेष ध्यान देता है।\r\n\r\nहमारे समर्पित और अनुभवी शिक्षक विद्यार्थियों को बेहतर शिक्षा, मार्गदर्शन और प्रेरणा प्रदान करते हैं ताकि वे अपने भविष्य को उज्ज्वल बना सकें और समाज के विकास में महत्वपूर्ण योगदान दे सकें।\r\n\r\nमैं सभी विद्यार्थियों से अपेक्षा करता हूँ कि वे इस संस्थान द्वारा प्रदान किए गए अवसरों का पूरा लाभ उठाएँ, कड़ी मेहनत करें और अपने लक्ष्यों को प्राप्त करने के लिए निरंतर प्रयासरत रहें।\r\n\r\nआप सभी के उज्ज्वल भविष्य की हार्दिक शुभकामनाएँ।\r\n\r\n(Principal)', '2026-03-16 23:20:01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `full_name`, `branch`, `semester`, `year`, `mobile`, `email`, `password`, `created_at`, `profile_image`) VALUES
(1, 'nitish kumar', 'CSE', 6, 'Third Year', '9517648760', 'nitish@gmail.com', '$2y$10$LomkvE/GaGdk5HjjquTe1uEOWAyIw8DkNNVXfDjjE4LN0btnEz7Na', '2026-02-10 05:53:47', '../assets/images/students/1_WhatsApp Image 2025-07-21 at 10.39.30_b9fe63e1.jpg'),
(2, 'Aadi', 'CSE', 6, 'Third Year', '1236985214', 'aadi@gmail.com', '$2y$10$VdxNX0hjWabuqQqkvG/5kuz9PraRLzKzOIJYyRo2ZVlJNWJVulXDe', '2026-02-10 16:08:40', '../assets/images/students/2_nitish.png'),
(3, 'Avi', 'CSE', 6, 'Third Year', 'avi@gmail.com', 'avi@gmail.com', '$2y$10$I/5myvzDNsojhHz4kwzMIOX7AChXPB/Rj0BnqJlWOvTLnjCd0LWjG', '2026-02-10 16:09:20', NULL),
(4, 'Dev', 'CSE', 6, 'Third Year', '456987898', 'dev@gmail.com', '$2y$10$blkRd2ioE1r4ZEPZhbnB2uoSItwe1j1j7bcdSnwMjLm46ZuQy.9CS', '2026-02-10 16:10:29', NULL),
(5, 'Ana', 'CSE', 6, 'Third Year', '1236547896', 'ana@gmail.com', '$2y$10$J/IfsfivIdA3ScwtnGYKjuybPuXMc.Hh0lkmVYMqDgjoVgi0FQkba', '2026-02-10 16:11:05', NULL),
(6, 'Gia', 'CSE', 6, 'Third Year', '123558974', 'gia@gmail.com', '$2y$10$NJiU0cGL6lT2MN0w0zDQ3OPjiR3t2JbXRe6/3IZZN0Ieqf2mIlwDe', '2026-02-10 16:12:12', NULL),
(7, 'Dhruv', 'E.E', 6, 'Third Year', '1236547898', 'dhruv@gmail.com', '$2y$10$ZzMyULtwZCU.JwvY391nF.QN.mwsorrP9c7/BnovNUWsdsvDYnrnu', '2026-02-10 16:13:04', NULL),
(8, 'Isha', 'E.E', 6, 'Third Year', '4569871236', 'isha@gmail.com', '$2y$10$USEAqJBlE3n46lNg2ZCA4uSnBCpU27f.P4ZzO77jtq.GLHkeWUu8W', '2026-02-10 16:13:41', NULL),
(9, 'jay', 'E.E', 6, 'Third Year', '7896547896', 'jay@gmail.com', '$2y$10$FJCBsppFO1mxhzrBUbQhouvbGuRvhkKnItu9o9ZkIfww3dPeWtw16', '2026-02-10 16:14:49', NULL),
(10, 'KIara', 'E.E', 6, 'Third Year', '456987856', 'kiara@gmail.com', '$2y$10$uFeIPQyZTrpufa7v.Oss7eYJQh.LQl1T6brOUoZFKwD25faHhNKjK', '2026-02-10 16:15:32', NULL),
(11, 'Niitya', 'CSE', 6, 'Third Year', '4587965478', 'nitya@gmail.com', '$2y$10$nNePgtMsyC4A2N9y1UIGEeFSy9Fd82NnjtzyVIs8L7NV1xELA72xu', '2026-02-10 16:16:22', NULL),
(12, 'Sara', 'M.E', 6, 'Third Year', '45669874567', 'sara@gmail.com', '$2y$10$gz/8Lhb8ZcHA8fGt6n8x7uF9GmZlyA25Nlyn7J4JdMhL1czF1v41y', '2026-02-10 16:17:09', NULL),
(13, 'Anu', 'M.E', 6, 'Third Year', '45687755856', 'anu@gmail.com', '$2y$10$MV0kScPEOeSyWeUFsi2Va.sJDcM3a2SFBMbUGUMWafqAi5CdQG8W6', '2026-02-10 16:18:03', NULL),
(14, 'Mokesh', 'M.E', 6, 'Third Year', '7896321478', 'mokesh@gmail.com', '$2y$10$KVyI8Pf0zNr/lw9EcTjof.fo239DtVyp3.wvnHDsUk8d2uYkL1nqK', '2026-02-10 16:18:46', NULL),
(15, 'Rian', 'M.E', 6, 'Third Year', '1236547897', 'rian@gmail.com', '$2y$10$/YjO9Fl.eVRs8v/RecOFAeiK.N09sByio0Kj97dfpnxZypL/RaR/S', '2026-02-10 16:19:57', NULL),
(17, 'Ved', 'M.E', 6, 'Third Year', '4568752144', 'ved@gmail.com', '$2y$10$arn2XVp1CTTrVKEmZEKOI.K3CjDPY4iExJeKzCIjkBgAHfMx4uEFC', '2026-02-10 16:21:27', NULL),
(18, 'Kabir', 'CSE', 4, 'Second Year', '1225447852', 'kabir@gmail.com', '$2y$10$oTK/yShTchZWrJ.zEWZkp.v4VNvA35k9JDYEh/8RWms3WBeMX2r6O', '2026-02-10 16:22:20', NULL),
(19, 'Siya', 'E.E', 4, 'Second Year', '458877445', 'siya@gmail.com', '$2y$10$gPMLUEfV4VtOlrMQsdIC/OwU1WhJrrOyjI62nlmN67qiYIX89IEHG', '2026-02-10 16:23:06', NULL),
(20, 'Kian', 'M.E', 4, 'Second Year', '1114447778', 'kian@gmail.com', '$2y$10$zcJkoCXngRv4RH5BcNKqJO3QOAEiAPmDhrWbvNXWoW1tgUbBnv9Xq', '2026-02-10 16:24:09', NULL),
(21, 'Diya', 'CSE', 2, 'First Year', '9551177665', 'diya@gmail.com', '$2y$10$.X7LWDIufaqDIzvsuLEtQOCBr4lu0T3ttcHUsGWaGTeviwA5nZPBW', '2026-02-10 16:25:01', NULL),
(22, 'Juhi', 'E.E', 2, 'First Year', '8855226655', 'juhi@gmail.com', '$2y$10$Yi4DW3qg3K850i1BWwSRQ.khskdSrmMwMwXoKkc.vgtMSkEYw9fDW', '2026-02-10 16:25:42', NULL),
(24, 'Raj@gmail.com', 'M.E', 2, 'First Year', '7788554477', 'raj@gmail.com', '$2y$10$NUg8qI8YAWAS1iEoayZX4.nL.pafzYAgm4.Sq1nmJardrSuI2Jh4y', '2026-02-10 16:28:04', NULL),
(26, 'satyam maurya', 'CSE', 6, 'Third Year', '9336740367', 'satyam@gmail.com', '$2y$10$3hg6WvR5IhQOfnhGrXRC0eeOozzS68McpE1K8DBPW0ZWzKf0PeUa6', '2026-03-25 16:57:41', NULL),
(27, 'Mohit Kumar Chaurasia', 'CSE', 6, 'Third Year', '8960335482', 'mohit@gmail.com', '$2y$10$FzzKC20s82GCIsL1vMNlSO5sERuSqy2vIx4k5EU023CBFTExmn7KO', '2026-03-27 06:01:42', '../assets/images/students/27_raju.jpg'),
(31, 'aditya kumar', 'CSE', 6, 'Third Year', '1234567890', 'aditya@gmail.com', '$2y$10$TqnRW2VJbWeTXFqw4pL8eOYkvwHTiRdmJ04Jmb5A7XTqlu2U3De3S', '2026-04-02 07:30:41', '../assets/images/students/31_wmremove-transformed (4) (1).png');

-- --------------------------------------------------------

--
-- Table structure for table `syllabus`
--

CREATE TABLE `syllabus` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(255) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `year` varchar(50) DEFAULT NULL,
  `semester` varchar(50) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `download_count` int(11) DEFAULT 0,
  `upload_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `syllabus`
--

INSERT INTO `syllabus` (`id`, `subject_name`, `branch`, `year`, `semester`, `file_name`, `description`, `status`, `download_count`, `upload_date`) VALUES
(1, 'Physics ', 'All Branch', '1st Year', 'Sem 1', 'Screenshot 2025-03-31 184529 (1).png', 'Syllabus Of Physics', 'approved', 0, '2026-03-31 21:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `teacher_id` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `branch` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `year` varchar(20) DEFAULT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `teacher_id`, `full_name`, `branch`, `semester`, `year`, `mobile`, `email`, `password`, `created_at`, `profile_image`) VALUES
(1, '1001', 'manish yadav', 'CSE', 6, 'Third Year', '9453901596', 'manish@gmail.com', '$2y$10$Vpw1KRb2ADrace7BykEI2eoCKfngRN8G1cCxorTssYIxGePIGtyT2', '2026-02-10 05:54:54', 'default.png'),
(2, '1002', 'Amit', 'CSE', 6, 'Third Year', '458787855', 'amit@gmail.com', '$2y$10$gEMtXE63qgmfSueRdtdcf.Pwln2pDIa9LW25oMfE5Y6da.24TQhCi', '2026-02-10 16:36:10', 'teacher_2_1770854049.png'),
(3, '1004', 'Rajesh', 'CSE', 6, 'Third Year', '1122336654', 'rajesh@gmail.com', '$2y$10$gOoMxVSHZEKjv80ICX759eF40e1GvNw9EwumubKta8ajG.zj4.e7W', '2026-02-10 16:36:41', 'default.png'),
(4, '1001', 'Suresh', 'M.E', 6, 'Third Year', '458796654', 'suresh@gmail.com', '$2y$10$6RuN14xqRTxaTzgzK4oeburhwOvodr/n97z.yVZ1S1lMgsgvrl1Dm', '2026-02-10 16:37:18', 'default.png'),
(5, NULL, 'Manoj', NULL, NULL, NULL, '4477889966', 'manoj@gmail.com', '$2y$10$WmXVC0Nlk2Ywn9Wiea.nQuYlexphypylU2hfhmlufFPgC.gQ8aIfm', '2026-02-10 16:38:06', 'default.png'),
(6, NULL, 'Sanjay', NULL, NULL, NULL, '778899888', 'sanjay@gmail.com', '$2y$10$0583mwvaE.1omIFZaSZrZ.mGI3Ef.rBp9Il61GoHZQHQxOrONvgnG', '2026-02-10 16:38:52', 'default.png'),
(7, '1000', 'Vinay', 'E.E', 6, 'Third Year', '4455662255', 'vinay@gmail.com', '$2y$10$WLMoDy8/9Zh0kEFL0BtrmufyJK8jZn4keaoZeyhPfin18JO1oTRBC', '2026-02-10 16:39:41', 'default.png'),
(8, '1003', 'Sunita', 'E.E', 6, 'Third Year', '2233665566', 'sunita@gmail.com', '$2y$10$Aa3dKF/RMJJa0rQEb5P1Eu7t1a0.XjjSdS7IA.QwVme8rGCJb9DWC', '2026-02-10 16:40:06', 'default.png'),
(9, NULL, 'Rekha', NULL, NULL, NULL, '774441112', 'rekha@gmail.com', '$2y$10$RCrS1tgaIsqECWUtjxdgnOyAN83H3cvV2SmsfuawflUaxyfYmJaCK', '2026-02-10 16:40:41', 'default.png'),
(10, NULL, 'Ritu', NULL, NULL, NULL, '5588552255', 'ritu@gmail.com', '$2y$10$foQ7WSyC4HZOqgCrWj7rCeP0MwkyOsNB1FOiHRon80v/ydZLPmYaa', '2026-02-10 16:41:10', 'default.png'),
(11, '1001', 'Amar', 'E.E', 6, 'Third Year', '9517648760', 'amar@gmail.com', '$2y$10$8Y894OpISo57Ex/o8JB52u0jNNctZtqXrzwXjk9MWjMlqZctrDpZi', '2026-03-17 17:33:44', 'default.png'),
(12, '1010', 'Shakti Singh', 'CSE', 6, 'Third Year', '5555555555', 'shakti@gmail.com', '$2y$10$LleN/LjUZ9sc5nmhjVqB0eqpoai2EyOV46OkdfwSxKmeHIZ.dnHC.', '2026-03-27 06:14:36', 'teacher_12_1774592224.png'),
(13, '007', 'akhilesh upadhyay', 'CSE', 6, 'Third Year', '7800365555', 'admin@governmrmtpolytechnicatraulia.com', '$2y$10$lAW1ao50/1PafjwwlHrIxetYdlXZNwqXfli1dmfuM8vxMnSKSjHm6', '2026-03-27 06:45:06', 'default.png'),
(17, '10001', 'Ayush yadav', 'CSE', 6, 'Third Year', '456891230', 'ayush@gmail.com', '$2y$10$Zc4PqSMu2NBgKRukuK85qu4ujnrgN.hwn/BwbUpETqPlsw4r.HRuW', '2026-04-02 07:32:14', 'default.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enquiries`
--
ALTER TABLE `enquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grievances`
--
ALTER TABLE `grievances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `id_card_requests`
--
ALTER TABLE `id_card_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `principal_messages`
--
ALTER TABLE `principal_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `syllabus`
--
ALTER TABLE `syllabus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `enquiries`
--
ALTER TABLE `enquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `exam_schedules`
--
ALTER TABLE `exam_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `grievances`
--
ALTER TABLE `grievances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `id_card_requests`
--
ALTER TABLE `id_card_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `principal_messages`
--
ALTER TABLE `principal_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `syllabus`
--
ALTER TABLE `syllabus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
