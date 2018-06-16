-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2018 at 12:07 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resultsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE IF NOT EXISTS `administrators` (
  `userID` int(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `interface` varchar(100) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `department` varchar(40) NOT NULL,
  `thumbnails` varchar(1000) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`userID`, `email`, `password`, `interface`, `firstName`, `lastName`, `department`, `thumbnails`) VALUES
(2, 'admin@gmail.com', 'e64b78fc3bc91bcbc7dc232ba8ec59e0', 'bursar', 'Nasasira', 'Edith', '', ''),
(12, 'jlwomwa@cis.mak.ac.ug', '5a05254570cc97ac9582ad7c5877f1ad', 'lecturer', 'LWOMWA ', 'JOSEPH', 'Information Systems', ''),
(13, 'hserugunda@cis.mak.ac.ug', '5a05254570cc97ac9582ad7c5877f1ad', 'lecturer', 'SERUGUNDA', 'HENRY', 'Information Technology', ''),
(14, 'nhawa@cis.mak.ac.ug', '5a05254570cc97ac9582ad7c5877f1ad', 'lecturer', 'HAWA', 'NYENDE', 'Computer Science', ''),
(16, 'emma2016@gmail.com', '3611c9869b14251ed263f8071e6020a4', 'lecturer', 'Din', 'Dan', 'Primary seven', ''),
(17, 'emma2016@gmail.com', '8724aa758c2f662d79952870ef486ea6', 'bursar', 'Matovu', 'John', 'Primary two', ''),
(18, 'dk@gmail.com', '1604f426ae54dcd53e6b88210296f9fa', 'bursar', 'Dan', 'Kibuka', 'Primary six', 'uploads/NO-IMAGE-AVAILABLE.jpg'),
(19, 'jm@gmail.com', '7f27e3bcc6c33d8b69989533567327a7', 'teacher', 'John', 'Makinda', 'Primary six', 'twitter.png'),
(20, 'admin@gmail.com', '09bda4e7d11002d3851913f6363ee0bb', 'admin', 'Christine', 'Nak', 'Top class', 'linkedin.png');

-- --------------------------------------------------------

--
-- Table structure for table `course_units`
--

CREATE TABLE IF NOT EXISTS `course_units` (
  `courseCode` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `creditUnit` int(11) NOT NULL,
  PRIMARY KEY (`courseCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_units`
--

INSERT INTO `course_units` (`courseCode`, `name`, `creditUnit`) VALUES
('BIS1204', 'DATA & INFORMATION MANAGEMENT 1', 4),
('CSC1107', 'STRUCTURED PROGERAMMING', 3);

-- --------------------------------------------------------

--
-- Table structure for table `fees_lower`
--

CREATE TABLE IF NOT EXISTS `fees_lower` (
  `fees_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_lid` int(11) NOT NULL,
  `date` varchar(11) NOT NULL,
  `paid` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `class` varchar(15) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` int(10) NOT NULL,
  PRIMARY KEY (`fees_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fees_upper`
--

CREATE TABLE IF NOT EXISTS `fees_upper` (
  `fee_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) NOT NULL,
  `date` varchar(15) NOT NULL,
  `paid` int(10) NOT NULL,
  `balance` int(10) NOT NULL,
  PRIMARY KEY (`fee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `graded_result`
--

CREATE TABLE IF NOT EXISTS `graded_result` (
  `grade_id` int(20) NOT NULL AUTO_INCREMENT,
  `student_lid` int(20) NOT NULL,
  `class` varchar(20) NOT NULL,
  `term` varchar(20) NOT NULL,
  `year` int(20) NOT NULL,
  `math_av` int(4) NOT NULL,
  `eng_av` int(4) NOT NULL,
  `sci_av` int(4) NOT NULL,
  `sst_av` int(4) NOT NULL,
  `total_avg` int(4) NOT NULL,
  `math_agg` int(4) NOT NULL,
  `eng_agg` int(4) NOT NULL,
  `sci_agg` int(4) NOT NULL,
  `sst_agg` int(4) NOT NULL,
  `total_agg` int(4) NOT NULL,
  `div` varchar(10) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `graded_result`
--

INSERT INTO `graded_result` (`grade_id`, `student_lid`, `class`, `term`, `year`, `math_av`, `eng_av`, `sci_av`, `sst_av`, `total_avg`, `math_agg`, `eng_agg`, `sci_agg`, `sst_agg`, `total_agg`, `div`) VALUES
(3, 16, 'Primary four', 'one', 2002, 90, 73, 87, 79, 327, 1, 3, 1, 2, 7, '1'),
(4, 17, 'Primary four', 'one', 2002, 67, 83, 78, 88, 316, 3, 1, 2, 1, 7, '1');

-- --------------------------------------------------------

--
-- Table structure for table `lecturers`
--

CREATE TABLE IF NOT EXISTS `lecturers` (
  `lectID` int(11) NOT NULL AUTO_INCREMENT,
  `lecturerName` varchar(50) NOT NULL,
  `department` varchar(200) NOT NULL,
  `email` varchar(50) NOT NULL,
  `compID` int(11) NOT NULL,
  PRIMARY KEY (`lectID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `lecturers`
--

INSERT INTO `lecturers` (`lectID`, `lecturerName`, `department`, `email`, `compID`) VALUES
(1, 'Emmanuel Mugejjera', 'Information Technology', 'emugejjera@cis.mak.ac.ug', 12),
(2, 'Hawa Nyende', 'Information Technology', 'hnyende@cit.ac.ug', 22),
(3, 'Henry Serugunda', 'Information Technology', 'hserugunda@cis.mak.ac.ug', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lower_grade`
--

CREATE TABLE IF NOT EXISTS `lower_grade` (
  `lower_grade_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_lid` int(20) NOT NULL,
  `math_avg` int(4) NOT NULL,
  `health_avg` int(4) NOT NULL,
  `ld1_avg` int(4) NOT NULL,
  `social_avg` int(4) NOT NULL,
  `reading_avg` int(4) NOT NULL,
  `writing_avg` int(4) NOT NULL,
  `total_avg` int(4) NOT NULL,
  `total_end` int(5) NOT NULL,
  `total_mid` int(5) NOT NULL,
  `class` varchar(10) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` int(6) NOT NULL,
  PRIMARY KEY (`lower_grade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `lower_position`
--

CREATE TABLE IF NOT EXISTS `lower_position` (
  `l_position_id` int(11) NOT NULL AUTO_INCREMENT,
  `lower_grade_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`l_position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mid_lower`
--

CREATE TABLE IF NOT EXISTS `mid_lower` (
  `mid_lid` int(11) NOT NULL AUTO_INCREMENT,
  `lower_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` int(10) NOT NULL,
  PRIMARY KEY (`mid_lid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `mid_lower`
--

INSERT INTO `mid_lower` (`mid_lid`, `lower_id`, `total`, `class`, `term`, `year`) VALUES
(9, 11, 505, 'Baby', 'one', 2012),
(10, 12, 376, 'Top', 'one', 2008),
(11, 13, 528, 'Top', 'one', 2008);

-- --------------------------------------------------------

--
-- Table structure for table `mid_lower_position`
--

CREATE TABLE IF NOT EXISTS `mid_lower_position` (
  `mid_position_id` int(11) NOT NULL AUTO_INCREMENT,
  `mid_lid` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`mid_position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `mid_lower_position`
--

INSERT INTO `mid_lower_position` (`mid_position_id`, `mid_lid`, `position`) VALUES
(37, 9, 1),
(38, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mid_upper`
--

CREATE TABLE IF NOT EXISTS `mid_upper` (
  `mid_id` int(11) NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `english` int(11) NOT NULL,
  `math` int(11) NOT NULL,
  `science` int(11) NOT NULL,
  `sst` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `total_agg` int(11) NOT NULL,
  `div` varchar(11) NOT NULL,
  `class` varchar(20) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` int(10) NOT NULL,
  PRIMARY KEY (`mid_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `mid_upper`
--

INSERT INTO `mid_upper` (`mid_id`, `result_id`, `english`, `math`, `science`, `sst`, `total`, `total_agg`, `div`, `class`, `term`, `year`) VALUES
(19, 23, 2, 1, 2, 6, 300, 11, '1', 'Primary three', 'one', 2004),
(20, 24, 5, 7, 8, 9, 175, 29, '4', 'Primary three', 'one', 2004),
(21, 25, 5, 1, 2, 3, 290, 11, '1', 'Primary four', 'one', 2002),
(22, 26, 1, 1, 1, 1, 366, 4, '1', 'Primary four', 'one', 2002),
(23, 29, 3, 1, 6, 2, 260, 12, '1', 'Primary four', 'one', 2002);

-- --------------------------------------------------------

--
-- Table structure for table `mid_upper_position`
--

CREATE TABLE IF NOT EXISTS `mid_upper_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `mid_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=134 ;

--
-- Dumping data for table `mid_upper_position`
--

INSERT INTO `mid_upper_position` (`position_id`, `mid_id`, `position`) VALUES
(128, 19, 1),
(129, 19, 1),
(130, 20, 2),
(131, 21, 2),
(132, 22, 1),
(133, 21, 2);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `result_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_lid` int(10) NOT NULL,
  `class` varchar(15) NOT NULL,
  `session` varchar(10) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` varchar(4) NOT NULL,
  `english` int(3) NOT NULL,
  `science` int(3) NOT NULL,
  `sst` int(3) NOT NULL,
  `math` int(3) NOT NULL,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`result_id`, `student_lid`, `class`, `session`, `term`, `year`, `english`, `science`, `sst`, `math`) VALUES
(23, 14, 'Primary three', 'MID', 'one', '2004', 78, 78, 54, 90),
(24, 15, 'Primary three', 'MID', 'one', '2004', 56, 42, 32, 45),
(25, 16, 'Primary four', 'MID', 'one', '2002', 56, 78, 67, 89),
(26, 17, 'Primary four', 'MID', 'one', '2002', 90, 89, 98, 89),
(27, 16, 'Primary four', 'EOT', 'one', '2002', 89, 95, 90, 90),
(28, 17, 'Primary four', 'EOT', 'one', '2002', 76, 67, 78, 45),
(29, 19, 'Primary four', 'MID', 'one', '2002', 70, 50, 60, 80);

-- --------------------------------------------------------

--
-- Table structure for table `result_lower`
--

CREATE TABLE IF NOT EXISTS `result_lower` (
  `lower_id` int(10) NOT NULL AUTO_INCREMENT,
  `student_lid` int(20) NOT NULL,
  `math_concepts` int(4) NOT NULL,
  `social_devt` int(4) NOT NULL,
  `health_habits` int(4) NOT NULL,
  `laguage_devt_1` int(4) NOT NULL,
  `writing` int(4) NOT NULL,
  `reading` int(4) NOT NULL,
  `session` varchar(10) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` varchar(10) NOT NULL,
  `class` varchar(10) NOT NULL,
  PRIMARY KEY (`lower_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `result_lower`
--

INSERT INTO `result_lower` (`lower_id`, `student_lid`, `math_concepts`, `social_devt`, `health_habits`, `laguage_devt_1`, `writing`, `reading`, `session`, `term`, `year`, `class`) VALUES
(11, 12, 90, 87, 67, 79, 96, 86, 'MID', 'one', '2012', 'Baby'),
(12, 13, 45, 87, 67, 56, 76, 45, 'MID', 'one', '2008', 'Top'),
(13, 20, 78, 90, 89, 89, 97, 85, 'MID', 'one', '2008', 'Top');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `studentNo` int(11) NOT NULL,
  `regNo` varchar(50) NOT NULL,
  `course` varchar(50) NOT NULL,
  `yearOfStudy` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `courseCode` varchar(50) NOT NULL,
  `interface` varchar(50) NOT NULL,
  PRIMARY KEY (`studentNo`),
  UNIQUE KEY `studentNo` (`studentNo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentNo`, `regNo`, `course`, `yearOfStudy`, `email`, `password`, `firstName`, `lastName`, `courseCode`, `interface`) VALUES
(111111111, '15/u/500000', 'CSC', '2', 'ac@gmail.com', '2e6e5a2b38ba905790605c9b101497bc', 'Nicholas', 'Muk', '', 'student'),
(213000432, '13/U/581', 'BSSE', '4', 'bagarukayo@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'BAGARUKAYO', 'BRUCE', '', 'student'),
(213000843, '13/U/1287', 'BIT', '3', 'pouline200@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'TWESIGYE', 'PAULINE', '', 'student'),
(213001231, '13/U/17901/ps', 'BIT', '3', 'atuhaire26@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'Atuhaire', 'Shallon', '', 'student'),
(213004518, '13/U/3465/PS', 'CSC', '3', 'amanyadanny@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'AMANYA', 'DAN', '', 'student'),
(213008361, '13/U/4872/PS', 'BIT', '3', 'bdismas05@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'Bwire', 'Dismas', '', 'student'),
(213016998, '13/U/3780/PS', 'BIT', '3', 'sharonarinaitwe93@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'Shallon ', 'Arineitwe', '', 'student'),
(213500345, '13/u/700', 'csc', '3', 'amanya20@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'Amanya', 'Danny', '', 'student'),
(214888989, '13/u/687/ps', 'BIT', '4', 'anything@gmail.com', '5a05254570cc97ac9582ad7c5877f1ad', 'Denis', 'Mukasa', '', 'student');

-- --------------------------------------------------------

--
-- Table structure for table `student_lower`
--

CREATE TABLE IF NOT EXISTS `student_lower` (
  `student_lid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `DOB` varchar(20) NOT NULL,
  `parent` varchar(20) NOT NULL,
  `address` varchar(20) NOT NULL,
  `class` varchar(15) NOT NULL,
  `fees` int(10) NOT NULL,
  `term` varchar(10) NOT NULL,
  `year` int(10) NOT NULL,
  `balance` int(10) NOT NULL,
  PRIMARY KEY (`student_lid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `student_lower`
--

INSERT INTO `student_lower` (`student_lid`, `name`, `DOB`, `parent`, `address`, `class`, `fees`, `term`, `year`, `balance`) VALUES
(13, 'mark kaddu', '2018-02-01', 'emma dcu', '078993652', 'Top ', 40000, 'one', 2008, 40000),
(14, 'bosco mpangi', '2016-01-28', 'kinti juko', '078993652', 'Primary three', 600000, 'one', 2004, 600000),
(15, 'emma nyanzi', '2018-02-01', 'kiberu', '078993652', 'Primary three', 46789, 'one', 2004, 46789),
(16, 'jane kane', '2018-02-07', 'kiberu', '07846543', 'Primary four', 345678, 'one', 2002, 345678),
(17, 'nevia veda', '2018-02-07', 'yan fen', '078993652', 'Primary four', 3456789, 'one', 2002, 3456789),
(18, 'willis welivis', '2018-02-10', 'ran mark', '078993652', 'Top ', 234567, 'one', 2014, 234567),
(19, 'vicky nalule', '2018-02-16', '3000', '098765432', 'Primary four', 456789, 'one', 2002, 456789),
(20, 'lumasi david', '12/08/1990', 'john kaka', '078993652', 'Top ', 34567, 'one', 2008, 34567);

-- --------------------------------------------------------

--
-- Table structure for table `upper_position`
--

CREATE TABLE IF NOT EXISTS `upper_position` (
  `position_id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `upper_position`
--

INSERT INTO `upper_position` (`position_id`, `grade_id`, `position`) VALUES
(4, 3, 1),
(5, 3, 1),
(6, 4, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
