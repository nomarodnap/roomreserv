-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 29, 2023 at 05:23 PM
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
-- Database: `dof`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookingRoom`
--

CREATE TABLE `bookingRoom` (
  `id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `persion` int(11) NOT NULL,
  `U_id` int(11) NOT NULL,
  `B_status` enum('accept','reject','Suspend') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookingRoom`
--

INSERT INTO `bookingRoom` (`id`, `start`, `end`, `title`, `persion`, `U_id`, `B_status`) VALUES
(1, '2023-10-26 08:30:00', '2023-10-26 16:30:00', 'อบรมทั่วไป', 10, 999, 'accept');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `U_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tel` varchar(10) NOT NULL,
  `org` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('admin','user') NOT NULL,
  `u_status` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`U_id`, `fname`, `lname`, `email`, `tel`, `org`, `password`, `status`, `u_status`) VALUES
(1, 'ทดสอบระบบ', 'ขอจองห้องหน่อย', 'ict.dof@dof.in.th', '12345', 'ศูนย์เทคโนโลยีสารสนเทศและการสื่อสาร', '81dc9bdb52d04dc20036dbd8313ed055', 'admin', 1),
(2, 'นายทดสอบ', 'ระบบจองห้อง', 'ict.dev2@dof.in.th', '1234', 'ICT-DOF', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookingRoom`
--
ALTER TABLE `bookingRoom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`U_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookingRoom`
--
ALTER TABLE `bookingRoom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `U_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1007;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
