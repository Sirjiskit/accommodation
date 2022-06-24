-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2021 at 03:39 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accommodation`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contactNo` varchar(11) NOT NULL,
  `gender` varchar(7) NOT NULL DEFAULT 'male',
  `password` varchar(300) NOT NULL,
  `villa` varchar(250) NOT NULL,
  `villa_for` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `image` text NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updation_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `contactNo`, `gender`, `password`, `villa`, `villa_for`, `address`, `image`, `reg_date`, `updation_date`) VALUES
(1, 'idris garba', 'idris@gmail.com', '07064809770', 'male', 'MTIzNDU=', '', '', '', '', '2021-07-16 13:25:44', '2021-07-16'),
(2, 'RILWAN', 'rilwan@gmail.com', '07036188150', 'male', 'MTIzNA==', '', '', '', '', '2021-07-16 14:27:51', '2021-07-16'),
(3, 'Bello Ibrahim', 'bello@gmail.com', '09012345678', 'male', 'MTIzNDU=', '', '', '', 'IMG_20170225_165418.jpg', '2021-07-16 21:05:38', '2021-07-16'),
(4, 'usman lungi', 'lungi@gmail.com', '07064809770', 'male', 'bHVuZ2k=', '', '', '', 'img3.jpg', '2021-07-19 10:19:58', '2021-07-19'),
(5, 'sansiro lodge', 'sansiro@gmail.com', '09080808080', 'male', 'c2Fuc2lybw==', '', '', '', 'passport.jpg', '2021-07-19 13:07:03', '2021-07-19'),
(6, 'kashim shettima', 'shettima@gmail.com', '07074653532', 'male', 'c2hldHRpbWE=', '', '', '', 'Nigerian-university.jpg', '2021-07-19 13:13:33', '2021-07-19'),
(7, 'Igbashio Julius Iorlumun', 'jigbashio@gmail.com', '09017828272', 'male', '12345', '', '', 'Rest House street', 'images.jpeg', '2021-07-28 18:06:01', '2021-07-29');

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `houseid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `villa_name` varchar(50) NOT NULL,
  `villa_for` tinytext NOT NULL,
  `villa_address` tinytext NOT NULL,
  `image` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`houseid`, `aid`, `villa_name`, `villa_for`, `villa_address`, `image`) VALUES
(1, 7, 'Kulvuki', 'Accommodation for Both Boy and Girls', 'JWT Way Ayoko City', 'IMG-20210311-WA0014.jpg'),
(2, 7, 'Vaki Complex', 'Accommodation for Both Boy and Girls', 'JWT Way Ayoko City', 'IMG-20210311-WA0011.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `villa_id` int(11) NOT NULL,
  `admission_no` varchar(250) NOT NULL,
  `program` varchar(100) NOT NULL,
  `department` varchar(250) NOT NULL,
  `level` varchar(250) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `img` text NOT NULL,
  `contactno` varchar(250) NOT NULL,
  `gname` varchar(250) NOT NULL,
  `villa` varchar(250) NOT NULL,
  `villa_address` text NOT NULL,
  `roomno` int(11) NOT NULL,
  `stayfrom` date NOT NULL,
  `need_roomate` varchar(250) NOT NULL,
  `room_details` text NOT NULL,
  `amount` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `student_id`, `villa_id`, `admission_no`, `program`, `department`, `level`, `firstname`, `middlename`, `lastname`, `gender`, `img`, `contactno`, `gname`, `villa`, `villa_address`, `roomno`, `stayfrom`, `need_roomate`, `room_details`, `amount`, `status`, `reg_date`) VALUES
(1, 6, 1, '23354972', 'Bsc', 'Computer Science', '4', 'Igbashio', 'Julius', 'Igbashio', 'male', 'Custom-Icon-Design-Pretty-Office-2-Man.ico', '07018277223', 'Giwa', 'Kulvuki', 'JWT Way Ayoko City', 3, '2021-07-29', 'Yes', '2 bed flat', '50000', 'Paid', '2021-07-29 09:48:05'),
(2, 8, 2, '23354972', 'Bsc', 'Computer Science', '4', 'Igbashio', 'Julius', 'Igbashio', 'male', 'profile.jpg', '07018277223', 'Giwa', 'Vaki Complex', 'JWT Way Ayoko City', 2, '2021-12-14', 'Yes', 'single room with toilet and kitchen', '45000', 'Not Paid', '2021-12-15 15:35:32');

-- --------------------------------------------------------

--
-- Table structure for table `roommate_char`
--

CREATE TABLE `roommate_char` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `roommate_id` int(11) NOT NULL,
  `roommate` int(11) NOT NULL,
  `alcohol` varchar(250) NOT NULL,
  `smokes` varchar(250) NOT NULL,
  `cook` varchar(250) NOT NULL,
  `habit` varchar(250) NOT NULL,
  `studies` varchar(250) NOT NULL,
  `visitors` varchar(250) NOT NULL,
  `gender` varchar(250) NOT NULL,
  `firstName` varchar(250) NOT NULL,
  `middleName` varchar(250) NOT NULL,
  `lastName` varchar(250) NOT NULL,
  `img` text NOT NULL,
  `department` varchar(250) NOT NULL,
  `level` varchar(250) NOT NULL,
  `contactNo` varchar(250) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roommate_char`
--

INSERT INTO `roommate_char` (`id`, `student_id`, `roommate_id`, `roommate`, `alcohol`, `smokes`, `cook`, `habit`, `studies`, `visitors`, `gender`, `firstName`, `middleName`, `lastName`, `img`, `department`, `level`, `contactNo`, `time`) VALUES
(1, 6, 7, 7, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'male', 'Igbashio', 'Julius', 'Igbashio', 'Custom-Icon-Design-Pretty-Office-2-Man.ico', 'Computer Science', '4', '07018277223', '2021-07-29 09:44:55'),
(2, 7, 6, 6, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'male', 'Igbashio', 'Julius', 'Igbashio', '', 'Computer Science', '4', '09017828274', '2021-07-29 10:25:37'),
(3, 8, 0, 0, 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'Yes', 'male', 'Igbashio', 'Julius', 'Igbashio', 'profile.jpg', 'Computer Science', '4', '07018277223', '2021-12-15 14:35:07');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `aid` int(11) DEFAULT NULL,
  `houseid` int(11) NOT NULL,
  `room_no` int(11) DEFAULT NULL,
  `room_details` text NOT NULL,
  `room_img` text NOT NULL,
  `fees` varchar(250) DEFAULT NULL,
  `posting_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `aid`, `houseid`, `room_no`, `room_details`, `room_img`, `fees`, `posting_date`) VALUES
(1, 7, 1, 1, '2 bed flat', 'Awicons-Vista-Artistic-2-Hot-Home.ico', '50000', '2021-07-28 19:04:39'),
(2, 7, 1, 2, '2 bed flat', 'IMG-20210311-WA0014.jpg', '50000', '2021-07-29 07:27:23'),
(3, 7, 1, 3, '2 bed flat', 'IMG-20210311-WA0011.jpg', '50000', '2021-07-29 07:30:27'),
(4, 7, 1, 4, '2 bed flat', 'IMG-20210311-WA0011.jpg', '50000', '2021-07-29 07:30:37'),
(5, 7, 1, 5, '2 bed flat', 'IMG-20210311-WA0011.jpg', '50000', '2021-07-29 07:30:47'),
(6, 7, 2, 1, 'single room with toilet and kitchen', 'IMG-20210311-WA0014.jpg', '45000', '2021-07-29 07:37:06'),
(7, 7, 2, 2, 'single room with toilet and kitchen', 'IMG-20210311-WA0011.jpg', '45000', '2021-07-29 07:37:19'),
(8, 7, 2, 3, 'single room with toilet and kitchen', 'IMG-20210311-WA0011.jpg', '45000', '2021-07-29 07:37:31'),
(9, 7, 2, 4, 'single room with toilet and kitchen', 'IMG-20210311-WA0011.jpg', '45000', '2021-07-29 07:37:43'),
(10, 7, 2, 5, 'single room with toilet and kitchen', 'IMG-20210311-WA0014.jpg', '45000', '2021-07-29 07:37:54'),
(11, 7, 2, 6, 'single room with toilet and kitchen', 'IMG-20210311-WA0011.jpg', '45000', '2021-07-29 07:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `schoollog`
--

CREATE TABLE `schoollog` (
  `id` int(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schoollog`
--

INSERT INTO `schoollog` (`id`, `username`, `password`) VALUES
(1, 'Admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userIp` varbinary(16) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userregistration`
--

CREATE TABLE `userregistration` (
  `id` int(11) NOT NULL,
  `admission_no` varchar(255) DEFAULT NULL,
  `program` varchar(20) NOT NULL,
  `department` varchar(250) NOT NULL,
  `level` varchar(250) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `img` varchar(250) NOT NULL,
  `contactNo` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `regDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updationDate` varchar(45) DEFAULT NULL,
  `passUdateDate` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userregistration`
--

INSERT INTO `userregistration` (`id`, `admission_no`, `program`, `department`, `level`, `firstName`, `middleName`, `lastName`, `gender`, `img`, `contactNo`, `password`, `regDate`, `updationDate`, `passUdateDate`) VALUES
(1, 'CST/17/COM/01176', 'Bsc', 'Computer Science', '400 level', 'mohammed', 'yunus', 'sani', 'male', 'IMG_20171005_084027.jpg', '07064809770', 'c2FuaWk0Nw==', '2021-07-16 13:19:19', '16-07-2021 04:53:38', NULL),
(2, 'CST/17/COM/01177', 'Bsc', 'Cyber Security', '300 Level', 'Haruna', 'Mohammed', 'Aliyu', 'male', 'IMG_20170707_103418.jpg', '07064809770', 'YWxpeXUxMjM0', '2021-07-16 13:21:19', NULL, NULL),
(3, 'CST/17/COM/01178', 'Bsc', 'Info Tech', '400 level', 'isiak', 'ndazola', 'abdullahi', 'male', 'FB_IMG_15011386256915153.jpg', '08143856548', 'b3ppbDEyMw==', '2021-07-16 13:24:14', NULL, NULL),
(4, '23354972', 'Bsc', 'Computer Science', '5', 'Yua', 'Mimi', 'Vernen', 'male', '20171230_173816.jpg', '09078575751', 'MTExMTEx', '2021-07-17 12:33:13', NULL, NULL),
(5, 'CST/17/COM/01178', 'Bsc', 'Software Eng', '400 level', 'isiak', 'ndazola', 'abdullahi', 'male', 'Nigerian-university.jpg', '09080808080', 'YmFiczEyMzQ=', '2021-07-21 11:23:53', NULL, NULL),
(6, '23354972', 'Bsc', 'Computer Science', '4', 'Igbashio', 'Julius', 'Igbashio', 'Male', 'Custom-Icon-Design-Pretty-Office-2-Man.ico', '07018277223', '12345', '2021-07-29 07:46:44', NULL, NULL),
(7, '23354974', 'Bsc', 'Computer Science', '4', 'Igbashio', 'Julius', 'Igbashio', 'male', '20171230_173816.jpg', '09017828274', '12345', '2021-07-29 10:24:20', '29-07-2021 11:46:50', NULL),
(8, '23354972', 'Bsc', 'Computer Science', '4', 'Igbashio', 'Julius', 'Igbashio', 'male', 'profile.jpg', '07018277223', '11111', '2021-12-15 14:34:03', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`houseid`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roommate_char`
--
ALTER TABLE `roommate_char`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_no` (`room_no`);

--
-- Indexes for table `schoollog`
--
ALTER TABLE `schoollog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userregistration`
--
ALTER TABLE `userregistration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `houseid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roommate_char`
--
ALTER TABLE `roommate_char`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `schoollog`
--
ALTER TABLE `schoollog`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userregistration`
--
ALTER TABLE `userregistration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
