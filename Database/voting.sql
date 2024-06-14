-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2024 at 12:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting`
--

-- --------------------------------------------------------

--
-- Table structure for table `teaminfo`
--

CREATE TABLE `teaminfo` (
  `TeamID` int(4) NOT NULL,
  `ProjectName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teaminfo`
--

INSERT INTO `teaminfo` (`TeamID`, `ProjectName`) VALUES
(1, 'Unicode Nepali Typing'),
(2, 'Code Sanjal'),
(3, 'ODIR'),
(4, 'Navcom'),
(5, 'Chrome extension trend tabs'),
(6, 'IOUSathi'),
(7, 'Quiz Game'),
(8, 'reReads'),
(9, 'Gamezone'),
(10, 'pshow'),
(11, 'EasyMeds'),
(12, 'Face detection attendance system'),
(13, 'eventmate'),
(14, 'Hamro Bus'),
(15, 'MediDocX'),
(16, 'Digital Kirana'),
(17, 'EasyRecipe'),
(18, 'Laser Light Security'),
(19, 'Adhelp'),
(20, '8 bit Adder'),
(21, 'Platformer'),
(22, 'Customer Support'),
(23, 'Chatbot'),
(24, 'Bookafy'),
(25, 'Fire detection'),
(26, 'GoShopNow'),
(27, 'More Academy'),
(28, 'The Garage'),
(29, 'Kurakani'),
(30, 'Sisu');
(31, 'pic at you');
(32, 'E bike');
(33, 'Phana');



-- use link /voting.php?GroupSN=
-- --------------------------------------------------------

--
-- Table structure for table `votinginfo`
--

CREATE TABLE `votinginfo` (
  `VotingID` int(5) NOT NULL,
  `TeamID` int(3) NOT NULL,
  `TimeStamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votinginfo`
--

INSERT INTO `votinginfo` (`VotingID`, `TeamID`, `TimeStamp`) VALUES
(1, 8, '2024-06-03 07:39:54'),
(2, 12, '2024-06-03 07:40:06'),
(3, 8, '2024-06-03 07:40:21'),
(4, 2, '2024-06-03 07:40:32'),
(5, 2, '2024-06-03 07:40:43'),
(6, 2, '2024-06-03 07:40:53'),
(7, 8, '2024-06-03 08:46:12'),
(8, 10, '2024-06-03 08:47:02'),
(9, 10, '2024-06-03 09:00:27'),
(10, 9, '2024-06-03 09:10:48'),
(11, 7, '2024-06-03 09:12:03'),
(12, 3, '2024-06-03 10:20:15'),
(13, 10, '2024-06-03 10:23:02'),
(14, 2, '2024-06-03 10:23:36'),
(15, 3, '2024-06-03 10:29:50'),
(16, 10, '2024-06-03 10:31:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `teaminfo`
--
ALTER TABLE `teaminfo`
  ADD PRIMARY KEY (`TeamID`);

--
-- Indexes for table `votinginfo`
--
ALTER TABLE `votinginfo`
  ADD PRIMARY KEY (`VotingID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `teaminfo`
--
ALTER TABLE `teaminfo`
  MODIFY `TeamID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `votinginfo`
--
ALTER TABLE `votinginfo`
  MODIFY `VotingID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
