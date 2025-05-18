-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 11:47 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `slider_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `svg_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `category`, `title`, `subtitle`, `description`, `image_path`, `svg_path`) VALUES
(1, 'Learning', 'Usability enhancement and Training for Transaction Portal for Customers', 'DIGITAL LEARNING INFRASTRUCTURE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'uploads/6828fd8cf04fe.jpg', 'uploads/6828fd8cf0bb2.svg'),
(2, 'Technology', 'Advanced Solutions for Modern Business', 'TECH INNOVATION', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'uploads/6828fdb0d896c.jpg', 'uploads/6828fdb0d8ca9.svg'),
(3, 'Communication', 'Streamlined Channels for Better Reach', 'EFFECTIVE COMMUNICATION', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'uploads/6828fdc867c28.jpg', 'uploads/6828fdc867f33.svg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
