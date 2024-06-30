-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2024 at 06:57 AM
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
-- Database: `fyp`
--

-- --------------------------------------------------------

--
-- Table structure for table `academic`
--

CREATE TABLE `academic` (
  `academic_id` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `adm_session` varchar(255) DEFAULT NULL,
  `year_sem` varchar(255) DEFAULT NULL,
  `programme` varchar(255) DEFAULT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `campus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `academic`
--

INSERT INTO `academic` (`academic_id`, `matrixnumber`, `adm_session`, `year_sem`, `programme`, `faculty`, `campus`) VALUES
(1, '067797', '2021 / 2022', 'Tahun 1 / Semester 1', 'ISMSKKI', 'Fakulti Informatik dan Komputeran', 'Besut'),
(2, '067798', '2021 / 2022', 'Tahun 1 / Semester 1 ', 'ISMSKKRK', 'Fakulti Informatik dan Komputeran', 'Besut'),
(3, '067799', '2024 / 2025', 'Tahun 1 / Semester 1', 'ISMSKPP', 'Fakulti Informatik dan Komputeran', 'Besut'),
(6, '067796', '2021 / 2022', 'Tahun 1 / Semester 1', 'ISMSKPP', 'Fakulti Informatik dan Komputeran', 'Besut');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `permanent` varchar(255) DEFAULT NULL,
  `current` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `matrixnumber`, `permanent`, `current`) VALUES
(1, '067797', '123, Jalan Harmoni 5/1, Taman Seri Harmoni, 43000 Kajang, Selangor,\r\nMalaysia', '456, Jalan Pantai Besut, Kampung Baru, 22200 Besut, Terengganu, Malaysia.'),
(2, '067798', '789, Jalan Damai 3/2, Taman Sri Damai, 43000 Kajang, Selangor, Malaysia.', '123, Jalan Pantai Besar, Kampung Baru, 22200 Besut, Terengganu, Malaysia.'),
(3, '067799', '123 Jalan Tun Jugah, 93350 Kuching,\r\nSarawak, Malaysia', '456 Jalan Pantai Besut, 22200 Besut,\r\nTerengganu, Malaysia'),
(6, '067796', 'No. 123, Jalan Indah 5, Taman Seri Murni, 47100 Puchong, Selangor, Malaysia', 'Universiti Sultan Zainal Abidin (UniSZA), Kampus Besut, Jalan Tembila, 22200 Besut, Terengganu, Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `ID` int(11) NOT NULL,
  `adminnum` varchar(6) NOT NULL,
  `adminemail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `adminnum`, `adminemail`, `password`) VALUES
(1, '234567', '234567@staff.unisza.edu.my', '$2y$10$y00j4clmyjFW1fnr68HZkO8nCOq.ZmWZHsobDND3IdqyeNzXFZztC');

-- --------------------------------------------------------

--
-- Table structure for table `assigntask`
--

CREATE TABLE `assigntask` (
  `ID` int(11) NOT NULL,
  `degcode` varchar(255) DEFAULT NULL,
  `degcourse` varchar(255) DEFAULT NULL,
  `degdci` varchar(255) DEFAULT NULL,
  `dipprev_inst` varchar(255) DEFAULT NULL,
  `dipprev_prog` varchar(255) DEFAULT NULL,
  `dipcode` varchar(255) DEFAULT NULL,
  `dipcourse` varchar(255) DEFAULT NULL,
  `dipcredithour` varchar(255) DEFAULT NULL,
  `dipdci` varchar(255) DEFAULT NULL,
  `firstsme` int(11) DEFAULT NULL,
  `secsme` int(11) DEFAULT NULL,
  `datetime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigntask`
--

INSERT INTO `assigntask` (`ID`, `degcode`, `degcourse`, `degdci`, `dipprev_inst`, `dipprev_prog`, `dipcode`, `dipcourse`, `dipcredithour`, `dipdci`, `firstsme`, `secsme`, `datetime`) VALUES
(1, 'CSF 11703', 'Operating Systems', '../uploads/taskdci/CSF 11703_OPERATING SYSTEM_UniSZA.pdf', 'Malaysia Institute of Science and Technology', 'Diploma Teknologi Kejuruteraan Komputer', 'DFC 2063', 'Operating Systems', '3', 'uploads/dipdci/DFC2063_OPERATING SYSTEM 3.0_DEC2019.pdf', 3, 5, '2024-06-13 13:01:42'),
(3, 'CSF 11603', 'Discrete Mathematics', '../uploads/taskdci/CSF11603_DISCRETE MATHEMATICS_UniSZA .pdf', 'Malaysia Institute of Science and Technology', 'Diploma Teknologi Kejuruteraan Komputer', 'DBM 2033', 'Discrete Mathematics', '3', 'uploads/dipdci/DBM2033_DISCRETE MATHEMATICS 3.0_DEC2019.pdf', 3, 5, '2024-06-13 13:19:08'),
(27, 'CSF 11803', 'Object Oriented Programming', '../uploads/taskdci/CSF 11803_OBJECT ORIENTED PROGRAMMING_UniSZA.pdf', 'Universiti Malaysia Pintar', 'Diploma Sains Komputer', 'DFT 4024', 'Object Oriented Programming', '4', 'uploads/dipdci/DFT4024_OBJECT ORIENTED PROGRAMMING 3.0_DEC2019.pdf', 3, 7, '2024-06-26 11:04:44'),
(28, 'CSD 23503', 'Web Application Development', '../uploads/taskdci/CSD 23503_WEB APPLICATION DEVELOPMENT_UniSZA.pdf', 'Politeknik Muadzam Shah Pahang', 'Diploma Teknologi Maklumat', 'DFT 3013', 'Web Design Technologies', '3', 'uploads/dipdci/DFT3013_ WEB DESIGN TECHNOLOGIES 3.0_DEC2019.pdf', 5, 7, '2024-06-26 12:36:40');

-- --------------------------------------------------------

--
-- Table structure for table `degcourse`
--

CREATE TABLE `degcourse` (
  `id` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `uniszacoursecode` varchar(255) DEFAULT NULL,
  `uniszacoursename` varchar(255) DEFAULT NULL,
  `uniszacredithour` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `degcourse`
--

INSERT INTO `degcourse` (`id`, `matrixnumber`, `uniszacoursecode`, `uniszacoursename`, `uniszacredithour`, `status`) VALUES
(1, '067797', 'CSF 11603 ', 'Discrete Mathematics', '3', 'PENDING'),
(2, '067797', 'CSF 11703', 'Operating Systems', '3', 'PENDING'),
(3, '067797', 'CSF 11803', 'Object Oriented Programming', '3', 'PENDING'),
(4, '067798', 'CSF 11603', 'Discrete Mathematics', '3', 'APPROVED'),
(5, '067798', 'CSF 11703', 'Operating Systems', '3', 'APPROVED'),
(7, '067799', 'CSF 11603', 'Discrete Mathematics', '3', 'PENDING'),
(8, '067796', 'CSD 23503', 'Web Application Development', '3', 'APPROVED');

-- --------------------------------------------------------

--
-- Table structure for table `dipcourse`
--

CREATE TABLE `dipcourse` (
  `id` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `dipcoursecode` varchar(255) DEFAULT NULL,
  `dipcoursename` varchar(255) DEFAULT NULL,
  `dipcredithour` varchar(255) DEFAULT NULL,
  `dipgrade` varchar(2) DEFAULT NULL,
  `dipfile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dipcourse`
--

INSERT INTO `dipcourse` (`id`, `matrixnumber`, `dipcoursecode`, `dipcoursename`, `dipcredithour`, `dipgrade`, `dipfile`) VALUES
(1, '067797', 'DBM 2033', 'Discrete Mathematics', '3', 'A+', 'uploads/dipdci/DBM2033_DISCRETE MATHEMATICS 3.0_DEC2019.pdf'),
(2, '067797', 'DFC 2063', 'Operating Systems', '3', 'A+', 'uploads/dipdci/DFC2063_OPERATING SYSTEM 3.0_DEC2019.pdf'),
(3, '067797', 'DFT 4024', 'Object Oriented Programming', '4', 'B+', 'uploads/dipdci/DFT4024_OBJECT ORIENTED PROGRAMMING 3.0_DEC2019.pdf'),
(4, '067798', 'DBM 2033', 'Discrete Mathematics', '3', 'A+', 'uploads/dipdci/DBM2033_DISCRETE MATHEMATICS 3.0_DEC2019.pdf'),
(5, '067798', 'DFC 2063', 'Operating Systems', '3', 'A', 'uploads/dipdci/DFC2063_OPERATING SYSTEM 3.0_DEC2019.pdf'),
(7, '067799', 'DCM 2083', 'Discrete Mathematics', '3', 'A-', 'uploads/dipdci/DBM2033_DISCRETE MATHEMATICS 3.0_DEC2019.pdf'),
(8, '067796', 'DFT 3013', 'Web Design Technologies', '3', 'A', 'uploads/dipdci/DFT3013_ WEB DESIGN TECHNOLOGIES 3.0_DEC2019.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `diploma`
--

CREATE TABLE `diploma` (
  `dip_Id` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `prev_inst` varchar(255) DEFAULT NULL,
  `prev_prog` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diploma`
--

INSERT INTO `diploma` (`dip_Id`, `matrixnumber`, `prev_inst`, `prev_prog`, `file`) VALUES
(1, '067797', 'Universiti Malaysia Pintar', 'Diploma Sains Komputer', 'uploads/transcript/transcript_067797.pdf'),
(2, '067798', 'Malaysia Institute of Science and Technology', 'Diploma Teknologi Kejuruteraan Komputer', 'uploads/transcript/trancript_067798.pdf'),
(3, '067799', 'Politeknik Sultan Salahudin Abdul Aziz Shah', 'Diploma Teknologi Maklumat (Teknologi Digital)', 'uploads/transcript/aziz2017.pdf'),
(6, '067796', 'Politeknik Muadzam Shah Pahang', 'Diploma Teknologi Maklumat', 'uploads/transcript/transcript_067796.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `kpplogin`
--

CREATE TABLE `kpplogin` (
  `ID` int(11) NOT NULL,
  `kppnum` varchar(6) NOT NULL,
  `fullname` varchar(60) NOT NULL,
  `kppemail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kppprofilepic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kpplogin`
--

INSERT INTO `kpplogin` (`ID`, `kppnum`, `fullname`, `kppemail`, `password`, `kppprofilepic`) VALUES
(1, '384752', 'Prof. Madya. Dr. Mazlina Binti Arshad', '384752@staff.unisza.edu.my', '$2y$10$e73zf3L81/pC9mYZbuZrWOMQ7ZbR/VBQDej2DtMeE.J0b1d4hlqku', '../uploads/kppprofilepicture/lecturer.png');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `studID` int(11) NOT NULL,
  `matrixnumber` varchar(6) NOT NULL,
  `uniszaemail` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`studID`, `matrixnumber`, `uniszaemail`, `password`) VALUES
(1, '067797', '067797@putra.unisza.edu.my', '$2y$10$Q33hi.WBrI44ii0kLfoi0uU50HjDmSK0BoDVKyr5HJzV0Rgyk4RS6'),
(2, '067798', '067798@putra.unisza.edu.my', '$2y$10$DIokzdCY3Jw0qrXftp.QLuWbyXcCf3FuhuWxs2zQIRLMi8L/f.Wym'),
(3, '067799', '067799@putra.unisza.edu.my', '$2y$10$bA9ar6bzUMMgExnAy4koTuDsmPjML4cGe0FL3UlGgQP2PrIJG2EWi'),
(6, '067796', '067796@putra.unisza.edu.my', '$2y$10$20QKISdbG1oM7xsalyWAXOV1.VEqcRtrZAHiz6cmsLFDN6qlUTf4S');

-- --------------------------------------------------------

--
-- Table structure for table `similarity`
--

CREATE TABLE `similarity` (
  `ID` int(11) NOT NULL,
  `subjectA` varchar(255) DEFAULT NULL,
  `subjectB` varchar(255) DEFAULT NULL,
  `similaritypercent` decimal(10,2) DEFAULT NULL,
  `status` varchar(25) DEFAULT 'PENDING',
  `sme1` int(11) DEFAULT NULL,
  `sme2` int(11) DEFAULT NULL,
  `studID` int(11) DEFAULT NULL,
  `review1` varchar(255) DEFAULT NULL,
  `review2` varchar(255) DEFAULT NULL,
  `decision1` varchar(255) DEFAULT NULL,
  `decision2` varchar(255) DEFAULT NULL,
  `sme1status` varchar(25) DEFAULT 'UNVERIFIED',
  `sme2status` varchar(25) DEFAULT 'UNVERIFIED'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `similarity`
--

INSERT INTO `similarity` (`ID`, `subjectA`, `subjectB`, `similaritypercent`, `status`, `sme1`, `sme2`, `studID`, `review1`, `review2`, `decision1`, `decision2`, `sme1status`, `sme2status`) VALUES
(1, 'CSF 11703', 'DFC 2063', '86.45', 'APPROVED', 3, 5, 2, 'DFC 2063 and CSF 11703 both cover Operating Systems and have a high similarity percentage. They might be equivalent courses.', 'Due to the high similarity between DFC 2063 - Operating Systems and CSF 11703 - Operating Systems, they have likely been approved as equivalent courses.', 'APPROVED', 'APPROVED', 'VERIFIED', 'VERIFIED'),
(3, 'CSF 11603', 'DBM 2033', '83.80', 'APPROVED', 3, 5, 2, 'DBM 2083 (Diploma) and CSF 11603 (Degree) share the subject of Discrete Mathematics, suggesting potential overlap in their curriculum.', 'The diploma course DBM 2033 - Discrete Mathematics and the degree course CSF 11603 - Discrete Mathematics likely cover similar content, given they both focus on Discrete Mathematics.', 'APPROVED', 'APPROVED', 'VERIFIED', 'VERIFIED'),
(27, 'CSF 11803', 'DFT 4024', '71.30', 'PENDING', 3, 7, 1, 'approved', NULL, 'APPROVED', NULL, 'VERIFIED', 'UNVERIFIED'),
(28, 'CSD 23503', 'DFT 3013', '78.68', 'APPROVED', 5, 7, 6, 'Approved', 'Approved', 'APPROVED', 'APPROVED', 'VERIFIED', 'VERIFIED');

-- --------------------------------------------------------

--
-- Table structure for table `smelogin`
--

CREATE TABLE `smelogin` (
  `ID` int(11) NOT NULL,
  `smenum` varchar(6) NOT NULL,
  `smeemail` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `smeprofilepic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smelogin`
--

INSERT INTO `smelogin` (`ID`, `smenum`, `smeemail`, `fullname`, `password`, `smeprofilepic`) VALUES
(3, '123456', '123456@staff.unisza.edu.my', 'Prof. Madya. Dr. Firdaus Bin Ismeth', '$2y$10$x4coD0vESlBkHXeOaA4lnOyYPnhk8ZfLhJ.6qO3m.W/BtF8daKpxK', '../uploads/smeprofilepicture/sme.jpeg'),
(5, '234567', '234567@staff.unisza.edu.my', 'Prof. Madya. Dr. Farouq Bin Hussein', '$2y$10$lb1hegCdzlN6sqHTKI4gqOtvCXpp/es.yx9mZfq/GhOYEjfmiTIuW', '../uploads/smeprofilepicture/sme2.jpeg'),
(7, '246810', '246810@staff.unisza.edu.my', 'Dr Hussein Bin Yusuff', '$2y$10$BswmWANB7fSTZ45QFcpKQ.Z9RziYg3t3AHOKuf5/kqTAYMXFpBKau', '../uploads/smeprofilepicture/sme3.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `smesubject`
--

CREATE TABLE `smesubject` (
  `ID` int(11) NOT NULL,
  `smeid` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `subjectname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `smesubject`
--

INSERT INTO `smesubject` (`ID`, `smeid`, `subject`, `subjectname`) VALUES
(20, 5, 'CSF 11703', 'Operating System'),
(21, 3, 'CSF 11703', 'Operating System'),
(22, 3, 'CSF 11603', 'Discrete Mathematics'),
(25, 3, 'CSF 11803', 'Object Oriented Programming'),
(27, 5, 'CSF 11603', 'Discrete Mathematics'),
(28, 7, 'CSF 11803', 'Object Oriented Programming'),
(30, 5, 'CSD 23503', 'Web Application Development'),
(31, 7, 'CSD 23503', 'Web Application Development');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `matrixnumber` varchar(6) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `icnumber` varchar(12) DEFAULT NULL,
  `numbphone` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'PENDING',
  `confirmationstatus` varchar(255) DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`matrixnumber`, `fullname`, `icnumber`, `numbphone`, `picture`, `status`, `confirmationstatus`) VALUES
('067796', 'Muhammad Khilfi Bin Khairusam', '001112101549', '012-2801395', 'uploads/profilepicture/profile_067796_1719291653.jpg', 'APPROVED', 'COMPLETED'),
('067797', 'Muhammad Mirza Bin Abdul', ' 98010114567', '012-3456789', 'uploads/profilepicture/profile_067797_1713511134.png', 'PENDING', 'PENDING'),
('067798', 'Adam Daniel Bin Arshad', ' 88051214987', '017-6543210', 'uploads/profilepicture/profile_067798_1713516022.png', 'APPROVED', 'COMPLETED'),
('067799', 'Claudia Veronica A/P Zachary', '981230145678', '012-3456789', 'uploads/profilepicture/profile_067799_1715144394.jpeg', 'PENDING', 'PENDING');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `academic`
--
ALTER TABLE `academic`
  ADD PRIMARY KEY (`academic_id`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `assigntask`
--
ALTER TABLE `assigntask`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `assigntask_ibfk_1` (`firstsme`),
  ADD KEY `assigntask_ibfk_2` (`secsme`);

--
-- Indexes for table `degcourse`
--
ALTER TABLE `degcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `dipcourse`
--
ALTER TABLE `dipcourse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `diploma`
--
ALTER TABLE `diploma`
  ADD PRIMARY KEY (`dip_Id`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `kpplogin`
--
ALTER TABLE `kpplogin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`studID`),
  ADD KEY `matrixnumber` (`matrixnumber`);

--
-- Indexes for table `similarity`
--
ALTER TABLE `similarity`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `similarity_ibfk_1` (`sme1`),
  ADD KEY `similarity_ibfk_2` (`sme2`),
  ADD KEY `studID` (`studID`);

--
-- Indexes for table `smelogin`
--
ALTER TABLE `smelogin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `smesubject`
--
ALTER TABLE `smesubject`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `smeid` (`smeid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`matrixnumber`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `academic`
--
ALTER TABLE `academic`
  MODIFY `academic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assigntask`
--
ALTER TABLE `assigntask`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `degcourse`
--
ALTER TABLE `degcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `dipcourse`
--
ALTER TABLE `dipcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `diploma`
--
ALTER TABLE `diploma`
  MODIFY `dip_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kpplogin`
--
ALTER TABLE `kpplogin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `studID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `similarity`
--
ALTER TABLE `similarity`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `smelogin`
--
ALTER TABLE `smelogin`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `smesubject`
--
ALTER TABLE `smesubject`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `academic`
--
ALTER TABLE `academic`
  ADD CONSTRAINT `academic_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `assigntask`
--
ALTER TABLE `assigntask`
  ADD CONSTRAINT `assigntask_ibfk_1` FOREIGN KEY (`firstsme`) REFERENCES `smelogin` (`ID`),
  ADD CONSTRAINT `assigntask_ibfk_2` FOREIGN KEY (`secsme`) REFERENCES `smelogin` (`ID`);

--
-- Constraints for table `degcourse`
--
ALTER TABLE `degcourse`
  ADD CONSTRAINT `degcourse_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `dipcourse`
--
ALTER TABLE `dipcourse`
  ADD CONSTRAINT `dipcourse_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `diploma`
--
ALTER TABLE `diploma`
  ADD CONSTRAINT `diploma_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`matrixnumber`) REFERENCES `student` (`matrixnumber`);

--
-- Constraints for table `similarity`
--
ALTER TABLE `similarity`
  ADD CONSTRAINT `similarity_ibfk_1` FOREIGN KEY (`sme1`) REFERENCES `smelogin` (`ID`),
  ADD CONSTRAINT `similarity_ibfk_2` FOREIGN KEY (`sme2`) REFERENCES `smelogin` (`ID`),
  ADD CONSTRAINT `similarity_ibfk_3` FOREIGN KEY (`studID`) REFERENCES `login` (`studID`);

--
-- Constraints for table `smesubject`
--
ALTER TABLE `smesubject`
  ADD CONSTRAINT `smesubject_ibfk_1` FOREIGN KEY (`smeid`) REFERENCES `smelogin` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
