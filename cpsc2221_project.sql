-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 12:47 AM
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
-- Database: `cpsc2221_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `DOB` date NOT NULL,
  `Street` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Postal` varchar(10) NOT NULL,
  `PhoneNr` varchar(15) NOT NULL,
  `ClientType` enum('Senior','Disabled','Other') NOT NULL,
  `ContractID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `fName`, `lName`, `DOB`, `Street`, `City`, `Postal`, `PhoneNr`, `ClientType`, `ContractID`) VALUES
(1, 'John', 'Doe', '1990-12-05', 'Gogen St', 'Vancouver', 'V4G 3J6', '123-456-7890', 'Senior', 1001),
(2, 'Jane', 'Smith', '1996-11-06', 'Mogen St', 'Burnaby', 'V4G 3J6', '111-222-3333', 'Senior', 1003);

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `ContractID` int(11) NOT NULL,
  `DayOfWeek` varchar(10) NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `Street` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Postal` varchar(10) NOT NULL,
  `PhoneNr` varchar(15) NOT NULL,
  `Diagnose` text NOT NULL,
  `ClientID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`ContractID`, `DayOfWeek`, `StartTime`, `EndTime`, `Street`, `City`, `Postal`, `PhoneNr`, `Diagnose`, `ClientID`) VALUES
(1001, 'Monday', '13:00:00', '15:00:00', 'Gogen St', 'Vancouver', 'V4G 3J6', '123-456-7890', 'Alzheimers', 1),
(1002, 'Tuesday', '14:30:00', '17:00:00', 'Mogen St', 'Burnaby', 'V4G 3J6', '111-222-3333', 'Cancer', 2),
(1003, 'Friday', '12:00:00', '14:00:00', 'Togen St', 'Delta', 'V4G 3J6', '444-555-6666', 'Flu', 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `detailedvisitreports`
-- (See below for the actual view)
--
CREATE TABLE `detailedvisitreports` (
`ReportID` int(11)
,`VisitDate` date
,`ServicesProvided` text
,`NurseName` varchar(50)
,`NurseLastName` varchar(50)
,`ClientName` varchar(50)
,`ClientLastName` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `nurse`
--

CREATE TABLE `nurse` (
  `NurseID` int(11) NOT NULL,
  `fName` varchar(50) NOT NULL,
  `lName` varchar(50) NOT NULL,
  `PhoneNr` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `DOB` date NOT NULL,
  `RegistrationNr` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse`
--

INSERT INTO `nurse` (`NurseID`, `fName`, `lName`, `PhoneNr`, `Email`, `DOB`, `RegistrationNr`) VALUES
(1, 'Anna', 'Smith', '604-879-6587', 'annasmith@test.com', '1989-12-23', '#123A4BC'),
(2, 'Jane', 'Hill', '900-855-3125', 'jHill97@test.com', '1997-04-12', '#978Z5YR'),
(3, 'Troy', 'Grey', '778-528-6354', 'troydaboy@test.com', '2000-07-31', '#568FG3S');

-- --------------------------------------------------------

--
-- Table structure for table `substitution`
--

CREATE TABLE `substitution` (
  `SubstitutionID` int(11) NOT NULL,
  `NurseID` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `EndDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `substitution`
--

INSERT INTO `substitution` (`SubstitutionID`, `NurseID`, `StartDate`, `EndDate`) VALUES
(1, 1, '2024-02-28', '2024-03-07'),
(2, 2, '2024-05-08', '2024-05-15'),
(3, 3, '2024-06-10', '2024-06-17');

-- --------------------------------------------------------

--
-- Table structure for table `visitreport`
--

CREATE TABLE `visitreport` (
  `ReportID` int(11) NOT NULL,
  `NurseID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `ContractID` int(11) NOT NULL,
  `HealthCondition` text NOT NULL,
  `VisitDate` date NOT NULL,
  `StartTime` time NOT NULL,
  `EndTime` time NOT NULL,
  `ServicesProvided` text NOT NULL,
  `MetAsScheduled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitreport`
--

INSERT INTO `visitreport` (`ReportID`, `NurseID`, `ClientID`, `ContractID`, `HealthCondition`, `VisitDate`, `StartTime`, `EndTime`, `ServicesProvided`, `MetAsScheduled`) VALUES
(1, 1, 1, 1001, 'Recovering', '2024-02-28', '07:00:00', '09:00:00', 'Insulin Injection', 1),
(2, 2, 2, 1002, 'Stable', '2024-05-08', '15:30:00', '18:00:00', 'Oral Chemotherapy', 1),
(3, 3, 2, 1003, 'Stable', '2024-06-10', '12:00:00', '14:00:00', 'Anti-Flu shot', 1);

-- --------------------------------------------------------

--
-- Structure for view `detailedvisitreports`
--
DROP TABLE IF EXISTS `detailedvisitreports`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `detailedvisitreports`  AS SELECT `vr`.`ReportID` AS `ReportID`, `vr`.`VisitDate` AS `VisitDate`, `vr`.`ServicesProvided` AS `ServicesProvided`, `n`.`fName` AS `NurseName`, `n`.`lName` AS `NurseLastName`, `c`.`fName` AS `ClientName`, `c`.`lName` AS `ClientLastName` FROM ((`visitreport` `vr` join `nurse` `n` on(`vr`.`NurseID` = `n`.`NurseID`)) join `client` `c` on(`vr`.`ClientID` = `c`.`ClientID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`ContractID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- Indexes for table `nurse`
--
ALTER TABLE `nurse`
  ADD PRIMARY KEY (`NurseID`);

--
-- Indexes for table `substitution`
--
ALTER TABLE `substitution`
  ADD PRIMARY KEY (`SubstitutionID`),
  ADD KEY `NurseID` (`NurseID`);

--
-- Indexes for table `visitreport`
--
ALTER TABLE `visitreport`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `NurseID` (`NurseID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `ContractID` (`ContractID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `ContractID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT for table `nurse`
--
ALTER TABLE `nurse`
  MODIFY `NurseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `substitution`
--
ALTER TABLE `substitution`
  MODIFY `SubstitutionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visitreport`
--
ALTER TABLE `visitreport`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contract`
--
ALTER TABLE `contract`
  ADD CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`);

--
-- Constraints for table `substitution`
--
ALTER TABLE `substitution`
  ADD CONSTRAINT `substitution_ibfk_1` FOREIGN KEY (`NurseID`) REFERENCES `nurse` (`NurseID`);

--
-- Constraints for table `visitreport`
--
ALTER TABLE `visitreport`
  ADD CONSTRAINT `visitreport_ibfk_1` FOREIGN KEY (`NurseID`) REFERENCES `nurse` (`NurseID`),
  ADD CONSTRAINT `visitreport_ibfk_2` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`),
  ADD CONSTRAINT `visitreport_ibfk_3` FOREIGN KEY (`ContractID`) REFERENCES `contract` (`ContractID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
