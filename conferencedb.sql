-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 12:34 AM
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
-- Database: `conferencedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendee`
--

CREATE TABLE `attendee` (
  `attendeeID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendee`
--

INSERT INTO `attendee` (`attendeeID`, `firstName`, `lastName`, `email`) VALUES
(1, 'Tristan', 'Guevarra', 'tristan.guevarra@student.com'),
(2, 'Dylan', 'Aro', 'dylan@student.com'),
(3, 'Alexa', 'De Jesus', 'dejesus@mac.com'),
(4, 'Atlas', 'Reyes', 'greekatlas@utm.com'),
(5, 'Lynne', 'Guava', 'lynne.guava@hotmail.com'),
(6, 'Jay', 'Woo', 'wwo981@ent.com'),
(7, 'Lebron', 'James', 'lebron.james@celebrity.com'),
(8, 'Stephen', 'Curry', 'stephen.curry@celebrity.com'),
(9, 'Matt', 'Bennett', 'matt.bennett@celebrity.com'),
(10, 'Jayson', 'Tatum', 'jayson.tatum@celebrity.com'),
(11, 'Bronny', 'JamesJr', 'bronny.jamesjr@celebrity.com'),
(12, 'Vince', 'Carter', 'vince.carter@celebrity.com'),
(13, 'Zendaya', 'Carter', 'zendaya.carter@business.com'),
(14, 'Elon', 'Musk', 'elon.musk@business.com'),
(15, 'Bill', 'Gates', 'bill.gates@business.com'),
(16, 'Jalen', 'Green', 'jalen.green@business.com'),
(17, 'Jalen', 'Brown', 'jalen.brown@business.com'),
(18, 'Josh', 'Christopher', 'josh.christopher@business.com'),
(19, 'Jiselle', 'Guevarra', 'jg503@gmail.com'),
(20, 'Jason ', 'Williams', 'whitechocoloate@gmail.com'),
(21, 'Griffin', 'Mbonda', 'griffin.mbonda@pjtpartners.com'),
(22, 'Alexander', 'Soler', 'soler@filo.com'),
(23, 'Jaida', 'Deaon', 'jaida.dean@dominique.ca');

-- --------------------------------------------------------

--
-- Table structure for table `chair`
--

CREATE TABLE `chair` (
  `chairID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chair`
--

INSERT INTO `chair` (`chairID`, `memberID`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `committee`
--

CREATE TABLE `committee` (
  `committeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committee`
--

INSERT INTO `committee` (`committeeID`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10);

-- --------------------------------------------------------

--
-- Table structure for table `committeemembership`
--

CREATE TABLE `committeemembership` (
  `committeeID` int(11) NOT NULL,
  `subCommitteeName` varchar(255) NOT NULL,
  `chairID` int(11) NOT NULL,
  `memberID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `committeemembership`
--

INSERT INTO `committeemembership` (`committeeID`, `subCommitteeName`, `chairID`, `memberID`) VALUES
(1, 'Program Committee', 1, 1),
(3, 'Program Committee', 1, 1),
(1, 'Logistics Committee', 2, 2),
(3, 'Finance Committee', 2, 2),
(1, 'Registration Committee', 3, 3),
(3, 'Sponsorship Committee', 3, 3),
(2, 'Program Committee', 4, 4),
(2, 'Finance Committee', 5, 5),
(6, 'Transportation Committee', 5, 8),
(2, 'Marketing Committee', 6, 6),
(4, 'Event Planning Committee', 6, 7),
(4, 'Event Planning Committee', 6, 10),
(4, 'Security Committee', 6, 7),
(4, 'Security Committee', 6, 10),
(6, 'Security Committee', 6, 9);

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE `hotel` (
  `roomNumber` int(11) NOT NULL,
  `beds` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel`
--

INSERT INTO `hotel` (`roomNumber`, `beds`) VALUES
(201, 1),
(202, 2),
(203, 3),
(204, 1),
(205, 2),
(206, 3);

-- --------------------------------------------------------

--
-- Table structure for table `jobpost`
--

CREATE TABLE `jobpost` (
  `jobID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL,
  `jobTitle` varchar(255) NOT NULL,
  `jobCity` varchar(255) NOT NULL,
  `jobProvince` varchar(255) NOT NULL,
  `jobPay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobpost`
--

INSERT INTO `jobpost` (`jobID`, `companyID`, `jobTitle`, `jobCity`, `jobProvince`, `jobPay`) VALUES
(0, 106, 'Analyst Intern', 'New York City', 'New York', 80000),
(2, 102, 'FPGA Soft Tool Developer', 'Hamilton', 'Ontario', 100000),
(3, 103, 'Meter Developer Software', 'Markham', 'Ontario', 180000),
(4, 104, 'Software Development Engineer II', 'Toronto', 'Ontario', 120000),
(6, 106, 'Investment Banking Consultant', 'New York City', 'New York', 250000),
(7, 106, 'Investment Banking Consultant II', 'New York City', 'New York', 300000),
(8, 106, 'Private Equity', 'New York City', 'New York', 500000),
(9, 104, 'Software Development Engineer Intern', 'Toronto', 'Ontario', 60000),
(10, 104, 'Machine Learning Engineer Intern', 'Markham', 'Ontario', 65000),
(11, 102, 'Embedded System Intern', 'Hamilton', 'Ontario', 50000),
(12, 103, 'Co-op/Intern Android Developer', 'Markham', 'Ontario', 40000),
(13, 103, 'Engineering Manager', 'Markham', 'Ontario', 250000),
(14, 103, 'Co-op/Intern IoT Solution Engineer', 'Markham', 'Ontario', 55000);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `memberID` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`memberID`, `firstName`, `lastName`, `email`) VALUES
(1, 'Olivia', 'Rodrigo', 'olivia.rodrigo@gmail.com'),
(2, 'Gracie', 'Abrams', 'gracie.abrams@gmail.com'),
(3, 'Billie', 'Eilish', 'billie.eilish@gmail.com'),
(4, 'Bea', 'Badobee', 'bea.badobee@gmail.com'),
(5, 'Ariana', 'Grande', 'ariana.grande@gmail.com'),
(6, 'Grent', 'Perez', 'grent.perez@gmail.com'),
(7, 'Gergely', 'Orosz', 'orosz@gmail.com'),
(8, 'Wes', 'Bos', 'wes.bos@gmail.com'),
(9, 'Addy', 'Osmani', 'addy.osmani@gmail.com'),
(10, 'Dan', 'Abramov', 'dan.abramov@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `professional`
--

CREATE TABLE `professional` (
  `professionalID` int(11) NOT NULL,
  `attendeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professional`
--

INSERT INTO `professional` (`professionalID`, `attendeeID`) VALUES
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `sessionID` int(11) NOT NULL,
  `roomNumber` int(11) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `topic` varchar(255) NOT NULL,
  `speakerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`sessionID`, `roomNumber`, `startTime`, `endTime`, `topic`, `speakerID`) VALUES
(1, 101, '08:00:00', '09:30:00', 'Database Management Systems', 7),
(2, 102, '10:00:00', '10:30:00', 'ER Models', 8),
(3, 103, '11:00:00', '11:30:00', 'Relational Model and Data Definition', 9),
(4, 104, '12:00:00', '12:30:00', 'ER to Relational', 10),
(5, 105, '13:00:00', '14:00:00', 'Midterm Preparation', 11),
(6, 106, '15:30:00', '17:00:00', '12 Week Crash Course', 12);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `sponsorID` int(11) NOT NULL,
  `attendeeID` int(11) NOT NULL,
  `companyID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`sponsorID`, `attendeeID`, `companyID`) VALUES
(21, 21, 106),
(23, 23, 106),
(32, 14, 102),
(33, 15, 103),
(34, 16, 104),
(36, 18, 106);

-- --------------------------------------------------------

--
-- Table structure for table `sponsoringcompany`
--

CREATE TABLE `sponsoringcompany` (
  `companyID` int(11) NOT NULL,
  `NumOfEmails` int(11) NOT NULL,
  `companyStatus` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsoringcompany`
--

INSERT INTO `sponsoringcompany` (`companyID`, `NumOfEmails`, `companyStatus`) VALUES
(102, 4, 'Gold'),
(103, 4, 'Platinum'),
(104, 3, 'Bronze'),
(106, 5, 'Platinum');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` int(11) NOT NULL,
  `attendeeID` int(11) NOT NULL,
  `roomNumber` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `attendeeID`, `roomNumber`) VALUES
(1, 1, 201),
(2, 2, 202),
(3, 3, 203),
(4, 4, 204),
(5, 5, 205),
(6, 6, 206),
(19, 19, 201),
(22, 22, 206);

-- --------------------------------------------------------

--
-- Table structure for table `subcommittee`
--

CREATE TABLE `subcommittee` (
  `subCommitteeID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `committeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subcommittee`
--

INSERT INTO `subcommittee` (`subCommitteeID`, `name`, `committeeID`) VALUES
(1, 'Program Committee', 1),
(2, 'Logistics Committee', 1),
(3, 'Registration Committee', 1),
(5, 'Finance Committee', 2),
(6, 'Marketing Committee', 2),
(9, 'Sponsorship Committee', 3),
(11, 'Event Planning Committee', 4),
(17, 'Transportation Committee', 6),
(18, 'Security Committee', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendee`
--
ALTER TABLE `attendee`
  ADD PRIMARY KEY (`attendeeID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `chair`
--
ALTER TABLE `chair`
  ADD PRIMARY KEY (`chairID`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `committee`
--
ALTER TABLE `committee`
  ADD PRIMARY KEY (`committeeID`);

--
-- Indexes for table `committeemembership`
--
ALTER TABLE `committeemembership`
  ADD PRIMARY KEY (`committeeID`,`subCommitteeName`,`memberID`),
  ADD KEY `chairID` (`chairID`),
  ADD KEY `memberID` (`memberID`);

--
-- Indexes for table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`roomNumber`);

--
-- Indexes for table `jobpost`
--
ALTER TABLE `jobpost`
  ADD PRIMARY KEY (`jobID`),
  ADD KEY `companyID` (`companyID`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`memberID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `professional`
--
ALTER TABLE `professional`
  ADD PRIMARY KEY (`professionalID`),
  ADD KEY `attendeeID` (`attendeeID`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`sessionID`),
  ADD KEY `speakerID` (`speakerID`);

--
-- Indexes for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD PRIMARY KEY (`sponsorID`),
  ADD KEY `attendeeID` (`attendeeID`),
  ADD KEY `companyID` (`companyID`);

--
-- Indexes for table `sponsoringcompany`
--
ALTER TABLE `sponsoringcompany`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `attendeeID` (`attendeeID`),
  ADD KEY `roomNumber` (`roomNumber`);

--
-- Indexes for table `subcommittee`
--
ALTER TABLE `subcommittee`
  ADD PRIMARY KEY (`subCommitteeID`),
  ADD KEY `committeeID` (`committeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `sessionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `subcommittee`
--
ALTER TABLE `subcommittee`
  MODIFY `subCommitteeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chair`
--
ALTER TABLE `chair`
  ADD CONSTRAINT `chair_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`) ON DELETE CASCADE;

--
-- Constraints for table `committeemembership`
--
ALTER TABLE `committeemembership`
  ADD CONSTRAINT `committeemembership_ibfk_1` FOREIGN KEY (`committeeID`) REFERENCES `committee` (`committeeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `committeemembership_ibfk_2` FOREIGN KEY (`chairID`) REFERENCES `chair` (`chairID`) ON DELETE CASCADE,
  ADD CONSTRAINT `committeemembership_ibfk_3` FOREIGN KEY (`memberID`) REFERENCES `member` (`memberID`) ON DELETE CASCADE;

--
-- Constraints for table `jobpost`
--
ALTER TABLE `jobpost`
  ADD CONSTRAINT `jobpost_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `sponsoringcompany` (`companyID`) ON DELETE CASCADE;

--
-- Constraints for table `professional`
--
ALTER TABLE `professional`
  ADD CONSTRAINT `professional_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE;

--
-- Constraints for table `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`speakerID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE;

--
-- Constraints for table `sponsor`
--
ALTER TABLE `sponsor`
  ADD CONSTRAINT `sponsor_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `sponsor_ibfk_2` FOREIGN KEY (`companyID`) REFERENCES `sponsoringcompany` (`companyID`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`attendeeID`) REFERENCES `attendee` (`attendeeID`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`roomNumber`) REFERENCES `hotel` (`roomNumber`) ON DELETE SET NULL;

--
-- Constraints for table `subcommittee`
--
ALTER TABLE `subcommittee`
  ADD CONSTRAINT `subcommittee_ibfk_1` FOREIGN KEY (`committeeID`) REFERENCES `committee` (`committeeID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
