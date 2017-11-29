-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2017 at 07:01 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `databaseproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `timest` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment_text` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `timest` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `file_path` varchar(10000) DEFAULT NULL,
  `content_name` varchar(50) DEFAULT NULL,
  `public` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `username`, `timest`, `file_path`, `content_name`, `public`) VALUES
(1, 'AA', '2017-11-29 02:17:27', 'https://images.fineartamerica.com/images/artworkimages/mediumlarge/1/cat-art-super-whiskers-sharon-cummings.jpg', 'Whiskers', 0),
(2, 'AA', '2017-11-29 02:18:20', 'http://s3.r29static.com//bin/entry/f85/0,356,2000,750/x/1835589/image.png', 'My birthday party', 0),
(3, 'BB', '2017-11-29 02:19:01', 'https://www.rover.com/static/new_design/images/logo@200x200.ce2f57dbe3e4.png', 'Rover', 1);

-- --------------------------------------------------------

--
-- Table structure for table `friendgroup`
--

CREATE TABLE `friendgroup` (
  `group_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `description` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendgroup`
--

INSERT INTO `friendgroup` (`group_name`, `username`, `description`) VALUES
('besties', 'AA', ''),
('family', 'AA', ''),
('family', 'BB', '');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `username` varchar(50) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `username_creator` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`username`, `group_name`, `username_creator`) VALUES
('AA', 'besties', 'AA'),
('AA', 'family', 'AA'),
('BB', 'family', 'BB'),
('CC', 'family', 'AA'),
('DD', 'family', 'AA'),
('EE', 'family', 'AA'),
('EE', 'family', 'BB'),
('FF', 'family', 'BB'),
('GG', 'besties', 'AA'),
('HH', 'besties', 'AA');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `username` varchar(50) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`username`, `password`, `first_name`, `last_name`) VALUES
('AA', '$2y$10$k8rFk/1pVjD8r8JEYruEq.jwCKLx9AfLJr7JXgJ321zJ3y3Hkg6Xe', 'Ann', 'Anderson'),
('BB', '$2y$10$6HwVKhWxm3Ecigrmo6inHOGdzAGhmuQKEEFWimThscxGB4skHo6QO', 'Bob', 'Baker'),
('CC', '$2y$10$KkaSfbIoQ4hFMRH9xMEv8OUZLA5RXh..P7pxaUVaG6iQ.2q6x5SPm', 'Cathy', 'Chang'),
('DD', '$2y$10$.QbIqICkgIZu95bFjLAypOqU4Ix00/N4U/iq5krRHrrYTVPmIhz7m', 'David', 'Davidson'),
('EE', '$2y$10$x3Ek2G4HMEqRbVg9KefwzeBF/tlw39D6ygvwKFTYX3lRwIeBbllwa', 'Ellen', 'Ellenberg'),
('FF', '$2y$10$n.4CE8F6nFd1yOwLPxEqh.GzilIdCs3hoFtwt.5BtLZf5c26tHG1C', 'Fred', 'Fox'),
('GG', '$2y$10$hzJk0QfWHwjxLLX8/A8RdeBaGN5e6jtFo3g/i0u/RcMjXai0kr98a', 'Gina', 'Gupta'),
('HH', '$2y$10$5qICGTB3aVCna9FlE0hpveSAJjs1/IKbwDCI0/bIVzZDSz68Ie72C', 'Helen', 'Harper'),
('t', '$2y$10$XsvfY.Eeb/Ui2S8Zf9SR8.2KWJieJXA7VO6BrrIVDHTwfjQ0M0o5a', 't', 't');

-- --------------------------------------------------------

--
-- Table structure for table `share`
--

CREATE TABLE `share` (
  `id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `username_tagger` varchar(50) NOT NULL,
  `username_taggee` varchar(50) NOT NULL,
  `timest` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`username`,`timest`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `friendgroup`
--
ALTER TABLE `friendgroup`
  ADD PRIMARY KEY (`group_name`,`username`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`username`,`group_name`,`username_creator`),
  ADD KEY `group_name` (`group_name`,`username_creator`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `share`
--
ALTER TABLE `share`
  ADD PRIMARY KEY (`id`,`group_name`,`username`),
  ADD KEY `group_name` (`group_name`,`username`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`,`username_tagger`,`username_taggee`),
  ADD KEY `username_tagger` (`username_tagger`),
  ADD KEY `username_taggee` (`username_taggee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id`) REFERENCES `content` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`username`) REFERENCES `person` (`username`);

--
-- Constraints for table `content`
--
ALTER TABLE `content`
  ADD CONSTRAINT `content_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`);

--
-- Constraints for table `friendgroup`
--
ALTER TABLE `friendgroup`
  ADD CONSTRAINT `friendgroup_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`);

--
-- Constraints for table `member`
--
ALTER TABLE `member`
  ADD CONSTRAINT `member_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`),
  ADD CONSTRAINT `member_ibfk_2` FOREIGN KEY (`group_name`,`username_creator`) REFERENCES `friendgroup` (`group_name`, `username`);

--
-- Constraints for table `share`
--
ALTER TABLE `share`
  ADD CONSTRAINT `share_ibfk_1` FOREIGN KEY (`id`) REFERENCES `content` (`id`),
  ADD CONSTRAINT `share_ibfk_2` FOREIGN KEY (`group_name`,`username`) REFERENCES `friendgroup` (`group_name`, `username`);

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`id`) REFERENCES `content` (`id`),
  ADD CONSTRAINT `tag_ibfk_2` FOREIGN KEY (`username_tagger`) REFERENCES `person` (`username`),
  ADD CONSTRAINT `tag_ibfk_3` FOREIGN KEY (`username_taggee`) REFERENCES `person` (`username`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
