-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 17, 2021 at 07:56 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cicjournal`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE IF NOT EXISTS `activity_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(100) NOT NULL,
  `activity` text NOT NULL,
  `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `id_number`, `activity`, `date_time`) VALUES
(42, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:45:42'),
(41, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:45:31'),
(40, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:44:53'),
(39, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 12:44:45'),
(38, '2016-00361', 'DELETED PAPER POST_ID(31)', '2021-06-12 12:44:17'),
(37, '2016-00361', 'DELETED PAPER POST_ID(31)', '2021-06-12 12:41:37'),
(36, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 12:41:28'),
(35, '2016-00361', 'DELETED PAPER POST_ID(30)', '2021-06-12 12:37:33'),
(34, '2016-00361', 'EDIT PAPER POST_ID(30)', '2021-06-12 12:37:27'),
(33, '2016-00361', 'EDIT PAPER POST_ID(30)', '2021-06-12 12:36:53'),
(32, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 12:36:42'),
(30, '2016-00361', 'EDIT PAPER POST_ID(29)', '2021-06-12 12:32:52'),
(31, '2016-00361', 'DELETED PAPER POST_ID(29)', '2021-06-12 12:35:07'),
(29, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 12:29:28'),
(28, '2016-00361', 'DELETED PAPER POST_ID(28)', '2021-06-12 12:27:35'),
(27, '2016-00361', 'LOGGED IN', '2021-06-12 11:50:02'),
(43, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:46:22'),
(44, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:46:23'),
(45, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 12:56:03'),
(46, '2016-00361', 'DELETED PAPER POST_ID(33)', '2021-06-12 12:56:46'),
(47, '2016-00361', 'DELETED PAPER POST_ID(33)', '2021-06-12 12:57:13'),
(48, '2016-00361', 'EDIT PAPER POST_ID(32)', '2021-06-12 12:58:49'),
(49, '2016-00361', 'DELETED PAPER POST_ID(32)', '2021-06-12 12:58:59'),
(50, '2016-00361', 'ADDED NEW PAPER', '2021-06-12 13:00:16'),
(51, '2016-00361', 'LOGGED OUT', '2021-06-12 13:18:53'),
(52, '2016-00361', 'LOGGED IN', '2021-06-12 13:19:10'),
(53, '2016-00361', 'LOGGED IN', '2021-06-13 03:01:41'),
(54, '2016-00361', 'ADDED NEW USER ID_NUM()', '2021-06-13 04:38:03'),
(55, '2016-00361', 'ADDED NEW USER ID_NUM()', '2021-06-13 04:41:23'),
(56, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-13 16:52:21'),
(57, '2016-00361', 'EDIT USER ID_NUM(2014-00999)', '2021-06-13 16:52:55'),
(58, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-13 16:54:25'),
(59, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-13 16:55:08'),
(60, '2016-00361', 'EDIT USER ID_NUM(2014-00999)', '2021-06-13 16:56:35'),
(61, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-13 17:49:03'),
(62, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-13 18:10:02'),
(63, '2016-00361', 'ADDED NEW PAPER', '2021-06-13 21:36:06'),
(64, '2016-00361', 'ADDED NEW PAPER', '2021-06-13 21:38:01'),
(65, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:45:04'),
(66, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:45:14'),
(67, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:47:13'),
(68, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:49:45'),
(69, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:51:44'),
(70, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:51:54'),
(71, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 21:53:10'),
(72, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 21:57:37'),
(73, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 21:59:05'),
(74, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 21:59:31'),
(75, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 21:59:47'),
(76, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:01:24'),
(77, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 22:03:06'),
(78, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 22:03:17'),
(79, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:04:34'),
(80, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:05:15'),
(81, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:07:00'),
(82, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:11:43'),
(83, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:13:25'),
(84, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:14:18'),
(85, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:16:11'),
(86, '2016-00361', 'ADDED NEW PAPER', '2021-06-13 22:18:33'),
(87, '2016-00361', 'EDIT PAPER POST_ID(37)', '2021-06-13 22:18:51'),
(88, '2016-00361', 'EDIT PAPER POST_ID(37)', '2021-06-13 22:19:06'),
(89, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 22:28:13'),
(90, '2016-00361', 'ADDED NEW PAPER', '2021-06-13 22:34:46'),
(91, '2016-00361', 'ADDED NEW PAPER', '2021-06-13 22:36:03'),
(92, '2016-00361', 'EDIT PAPER POST_ID(34)', '2021-06-13 23:41:58'),
(93, '2016-00361', 'EDIT PAPER POST_ID(36)', '2021-06-13 23:42:15'),
(94, '2016-00361', 'EDIT PAPER POST_ID(37)', '2021-06-13 23:42:26'),
(95, '2016-00361', 'EDIT PAPER POST_ID(38)', '2021-06-13 23:42:36'),
(96, '2016-00361', 'EDIT PAPER POST_ID(39)', '2021-06-13 23:42:45'),
(97, '2016-00361', 'DELETED PAPER POST_ID(39)', '2021-06-13 23:49:35'),
(98, '2016-00361', 'DELETED PAPER POST_ID(38)', '2021-06-13 23:49:41'),
(99, '2016-00361', 'DELETED PAPER POST_ID(37)', '2021-06-13 23:49:59'),
(100, '2016-00361', 'ADDED NEW PAPER', '2021-06-14 00:01:09'),
(101, '2016-00361', 'DELETED PAPER POST_ID(34)', '2021-06-14 00:02:31'),
(102, '2016-00361', 'DELETED PAPER POST_ID(36)', '2021-06-14 00:02:36'),
(103, '2016-00361', 'EDIT PAPER POST_ID(40)', '2021-06-14 00:04:10'),
(104, '2016-00361', 'EDIT USER ID_NUM(2015-19622)', '2021-06-14 00:04:31'),
(105, '2016-00361', 'EDIT USER ID_NUM(2015-19621)', '2021-06-14 11:33:21'),
(106, '2016-00361', 'LOGGED OUT', '2021-06-14 11:33:28'),
(107, '2016-00361', 'LOGGED IN', '2021-06-14 12:37:59'),
(108, '2016-00361', 'LOGGED IN', '2021-06-14 20:19:00'),
(109, '2016-00361', 'EDIT USER ID_NUM(1980-00001)', '2021-06-14 20:34:41'),
(110, '2016-00361', 'EDIT USER ID_NUM(1989-99999)', '2021-06-14 20:36:05'),
(111, '2016-00361', 'EDIT USER ID_NUM(1999-99999)', '2021-06-14 20:36:40'),
(112, '2016-00361', 'ADDED NEW PAPER', '2021-06-14 20:38:06'),
(113, '2016-00361', 'ADDED NEW PAPER', '2021-06-14 20:39:54'),
(114, '2016-00361', 'LOGGED IN', '2021-06-15 01:59:51'),
(115, '2016-00361', 'LOGGED IN', '2021-06-15 13:16:44'),
(116, '2016-00361', 'EDIT USER ID_NUM(2038-00001)', '2021-06-15 18:00:29'),
(117, '2016-00361', 'EDIT PAPER POST_ID(40)', '2021-06-16 00:15:02'),
(118, '2016-00361', 'LOGGED IN', '2021-06-16 23:20:22'),
(119, '2016-00361', 'LOGGED IN', '2021-06-17 14:25:07');

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `id_number` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `post_id`, `id_number`) VALUES
(40, 41, '2015-19621'),
(39, 41, '1980-00001'),
(38, 41, '2038-00001'),
(43, 42, '2038-00001'),
(42, 42, '1989-99999'),
(41, 42, '1999-99999');

--
-- Triggers `author`
--
DROP TRIGGER IF EXISTS `after_author_idnumber_edit`;
DELIMITER $$
CREATE TRIGGER `after_author_idnumber_edit` AFTER UPDATE ON `author` FOR EACH ROW UPDATE react SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'DUMMY CATEGORY 1'),
(2, 'DUMMY CATEGORY 2'),
(3, 'DUMMY CATEGORY 3'),
(4, 'DUMMY CATEGORY 4'),
(5, 'DUMMY CATEGORY 5');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `id_number` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'VISIBLE',
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `post_id`, `id_number`, `comment`, `status`, `comment_date`) VALUES
(6, 42, '1980-00001', 'Wow kuyawa na ba jud ani nila', 'VISIBLE', '2021-06-14 17:59:06'),
(5, 41, '1980-00001', 'May pamily is da mows emportant persons in may layp layp', 'VISIBLE', '2021-06-14 17:50:31'),
(7, 41, '1999-99999', 'Hilom sir yaya ra ka!', 'VISIBLE', '2021-06-14 18:01:11'),
(8, 40, '1999-99999', 'Mic check mic check test mic 123 mic test', 'VISIBLE', '2021-06-14 18:02:16'),
(14, 41, '2038-00001', 'anak kong gong2', 'VISIBLE', '2021-06-15 08:46:42'),
(10, 42, '1980-00001', 'bla bla bla sigeg mama si sir', 'VISIBLE', '2021-06-15 08:29:18'),
(11, 41, '1980-00001', 'Im here again mga vovo', 'VISIBLE', '2021-06-15 08:31:02'),
(13, 42, '1980-00001', 'bts biot', 'VISIBLE', '2021-06-15 08:34:25'),
(15, 42, '2038-00001', 'ayaw pag ana sir oy gago ka', 'VISIBLE', '2021-06-15 08:55:47');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`course_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`course_id`, `name`) VALUES
(1, 'BSIT'),
(2, 'BSCS'),
(3, 'BSLM'),
(4, 'BSIS');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
CREATE TABLE IF NOT EXISTS `login` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(60) NOT NULL,
  `user_type` varchar(10) NOT NULL,
  `password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`id_number`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`user_id`, `id_number`, `user_type`, `password`) VALUES
(26, '2016-00361', 'SUPER', '$2y$10$na91LW2O7WYpWFPVEuH7QO/0wkyovLzxEyTVGx0TgqNM6ho71Visy'),
(27, '2015-19621', 'STUDENT', '$2y$10$na91LW2O7WYpWFPVEuH7QO/0wkyovLzxEyTVGx0TgqNM6ho71Visy'),
(34, '1980-00001', 'STUDENT', '$2y$10$UalCMvRi9sIXbkSZc8atvuJJkX.h/ayLW4RkhNHdzVike3AoVXTx6'),
(35, '2014-00999', 'ADMIN', '$2y$10$go2lSNL7rFMUu4jgpj4Fj.e/CWdV0Z4qTlxkbx1Qg282FxbKgICJG'),
(36, '2014-33981', 'ADMIN', '$2y$10$CiofqGhM52CRMcafY3en0.na2jwDo4Y8a5lQWL6JKWVYIyo4LwRgG'),
(37, '2008-19629', 'ADMIN', '$2y$10$mKoapVLHngvnw/oi8cLM4eHMIHCAnZonCIGdSda5wF1QDWwJDc6sq'),
(38, '2038-00001', 'STUDENT', '$2y$10$hud3WnKvlLqr0OZ5W13VnOU6lIIim9EQXZN3PT9cnpu69n4cJk4ny'),
(39, '1989-99999', 'STUDENT', '$2y$10$2k4NYZA1RsupF1jWVFEQwOz.htlFv6h9IXO2hNrzSleoCyJbn1GWG'),
(40, '1999-99999', 'STUDENT', '$2y$10$uFpZyxkOvZOnsUyGj/BrMuWhh3Qcg603SZaoaneEGQSA.Uwei0IO6');

--
-- Triggers `login`
--
DROP TRIGGER IF EXISTS `after_login_idnumber_edit`;
DELIMITER $$
CREATE TRIGGER `after_login_idnumber_edit` AFTER UPDATE ON `login` FOR EACH ROW IF (new.user_type = "STUDENT") THEN
	UPDATE student SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number;
ELSE
    UPDATE reg_info SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number;
END IF
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_login_insert`;
DELIMITER $$
CREATE TRIGGER `after_login_insert` AFTER INSERT ON `login` FOR EACH ROW IF (new.user_type = "STUDENT") THEN
    INSERT INTO student
    (`id_number`)VALUES
    (new.id_number);
ELSE
    INSERT INTO reg_info
    (`id_number`)VALUES
    (new.id_number);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `major`
--

DROP TABLE IF EXISTS `major`;
CREATE TABLE IF NOT EXISTS `major` (
  `major_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  PRIMARY KEY (`major_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `major`
--

INSERT INTO `major` (`major_id`, `name`) VALUES
(1, 'PA HAWD HAWD'),
(2, 'BIDA BIDA'),
(3, 'PASIKAT'),
(4, 'DAKOG AGTANG'),
(5, 'BAHOG ULO!!'),
(6, 'N/A');

-- --------------------------------------------------------

--
-- Stand-in structure for view `manage_user_view`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `manage_user_view`;
CREATE TABLE IF NOT EXISTS `manage_user_view` (
`id_number` varchar(60)
,`full_name` mediumtext
,`user_type` varchar(10)
,`status` varchar(25)
);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(300) NOT NULL,
  `title` varchar(250) NOT NULL,
  `category_id` int(11) NOT NULL,
  `year_publish` year(4) NOT NULL,
  `synopsis` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'ACTIVE',
  `upvotes` int(11) NOT NULL DEFAULT '0',
  `views` int(11) NOT NULL DEFAULT '0',
  `file_name` varchar(100) NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`post_id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_id`, `id_number`, `title`, `category_id`, `year_publish`, `synopsis`, `status`, `upvotes`, `views`, `file_name`, `date_posted`) VALUES
(41, '2016-00361', 'EGRESS: AN EMERGENCY EVACUATION APPLICATION WITH INDOOR ROUTE PLANNING AND VOICE-GUIDED NAVIGATION', 4, 2021, 'There are some events that people may be wished and appreciated while there are others that should be avoided or stopped if possible. Though bad events may happen without precaution and the victims will be caught unready. Every year, a large number of disasters happen because of natural events and commonly human liabilities. The consequences may include causalities of several types and severity as well as damage to the environment. Some examples include earthquakes, terror attacks, and building fires.', 'ACTIVE', 0, 0, 'file-60c74dae1d0eb5.79553326.pdf', '2021-06-14 20:38:06'),
(40, '2016-00361', 'Test paper 3', 2, 2002, ' Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet.', 'ACTIVE', 0, 0, 'file-60c62bc5142758.35441241.pdf', '2021-06-14 00:01:09'),
(42, '2016-00361', 'DriveCare: Driver Drowsiness Detection based on Eye Blink Analysis', 5, 2020, 'Sleep is a naturally reversible process that plays an essential role in human well-being. Sleep is linked to functional physical and mental health and contributes to life and safety. Many individuals do not realize they are sleeping deficient and thus are unaware of their degree of impairment from sleep deficiency, one of the significant factors that increase motor vehicle crashes [1]. Fatigued driving is a state with reduced mental alertness that impairs cognitive and psychomotor performance during driving [7].', 'ACTIVE', 0, 0, 'file-60c74e1acbaa88.74041865.pdf', '2021-06-14 20:39:54');

--
-- Triggers `post`
--
DROP TRIGGER IF EXISTS `admin_insert_to_log`;
DELIMITER $$
CREATE TRIGGER `admin_insert_to_log` AFTER INSERT ON `post` FOR EACH ROW INSERT INTO activity_log
(id_number,	activity) VALUES
(new.id_number, "ADDED NEW PAPER")
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `react`
--

DROP TABLE IF EXISTS `react`;
CREATE TABLE IF NOT EXISTS `react` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `id_number` varchar(30) NOT NULL,
  `react_type` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `react`
--

INSERT INTO `react` (`id`, `post_id`, `id_number`, `react_type`) VALUES
(18, 40, '2015-19621', 'LIKE'),
(48, 41, '2015-19621', 'LIKE'),
(20, 40, '1980-00001', 'LIKE'),
(21, 42, '1980-00001', 'LIKE'),
(40, 41, '1980-00001', 'LIKE'),
(44, 41, '1999-99999', 'LIKE'),
(42, 42, '1999-99999', 'LIKE'),
(43, 40, '1999-99999', 'LIKE'),
(45, 41, '2038-00001', 'LIKE'),
(46, 42, '2038-00001', 'UNLIKE'),
(47, 40, '2038-00001', 'LIKE');

--
-- Triggers `react`
--
DROP TRIGGER IF EXISTS `after_react_idnumber_edit`;
DELIMITER $$
CREATE TRIGGER `after_react_idnumber_edit` AFTER UPDATE ON `react` FOR EACH ROW UPDATE comment SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reg_info`
--

DROP TABLE IF EXISTS `reg_info`;
CREATE TABLE IF NOT EXISTS `reg_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(40) NOT NULL,
  `first_name` text,
  `middle_name` text,
  `last_name` text,
  `sex` varchar(50) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `prof_pic` varchar(100) DEFAULT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'ENABLED',
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reg_info`
--

INSERT INTO `reg_info` (`id`, `id_number`, `first_name`, `middle_name`, `last_name`, `sex`, `dob`, `prof_pic`, `status`, `reg_date`) VALUES
(1, '2016-00361', 'James Claude', 'Bongaitan', 'Lequin', 'MALE', '1998-10-04', NULL, 'ENABLED', '2021-06-12 11:38:47'),
(2, '2015-19621', 'Kimberly', 'Alegarme', 'Devocion', 'FEMALE', '1998-08-21', NULL, 'DISABLED', '2021-06-12 11:39:47'),
(9, '1980-00001', 'Sir Ar Es', 'Middle', 'Ji', 'MALE', '1969-09-30', NULL, 'ENABLED', '2021-06-13 04:14:19'),
(10, '2014-00999', 'Firstt Admin', 'Midd admin', 'Lastt admin', 'MALE', '1997-08-09', NULL, 'ENABLED', '2021-06-13 04:15:24'),
(11, '2014-33981', 'Admin22', 'Mid Admin22', 'Last Admin22', 'MALE', '1995-08-05', NULL, 'ENABLED', '2021-06-13 04:17:41'),
(12, '2008-19629', 'Admin3', 'Mid def admin', 'Last def admin', 'MALE', '1990-07-08', NULL, 'DISABLED', '2021-06-13 04:20:27'),
(13, '2038-00001', 'Royena Elise', 'Devocion', 'Lequin', 'FEMALE', '2020-10-03', 'file-60ca12438e1439.81394943.jpg', 'ENABLED', '2021-06-13 04:26:16'),
(14, '1989-99999', 'Lois', 'Middle', 'Lane', 'FEMALE', '1969-12-22', NULL, 'ENABLED', '2021-06-13 04:38:03'),
(15, '1999-99999', 'Chaknu', 'Lang', 'Sakalam', 'NON BINARY', '1998-09-27', 'file-60c9e9568a1f94.21769473.jpg', 'ENABLED', '2021-06-13 04:41:23');

--
-- Triggers `reg_info`
--
DROP TRIGGER IF EXISTS `after_reginfo_idnumber_edit`;
DELIMITER $$
CREATE TRIGGER `after_reginfo_idnumber_edit` AFTER UPDATE ON `reg_info` FOR EACH ROW UPDATE author SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_number` varchar(20) DEFAULT NULL,
  `course_id` int(11) DEFAULT NULL,
  `major_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_number` (`id_number`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `id_number`, `course_id`, `major_id`) VALUES
(7, '2015-19621', 2, 2),
(15, '2038-00001', 1, 6),
(14, '1980-00001', 2, 2),
(16, '1989-99999', 4, 2),
(17, '1999-99999', 1, 1);

--
-- Triggers `student`
--
DROP TRIGGER IF EXISTS `after_student_idnumber_edit`;
DELIMITER $$
CREATE TRIGGER `after_student_idnumber_edit` AFTER UPDATE ON `student` FOR EACH ROW UPDATE reg_info SET 
    id_number = new.id_number 
    WHERE id_number = old.id_number
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `after_student_insert`;
DELIMITER $$
CREATE TRIGGER `after_student_insert` AFTER INSERT ON `student` FOR EACH ROW INSERT INTO reg_info
(`id_number`) VALUES
(new.id_number)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `test_table`
--

DROP TABLE IF EXISTS `test_table`;
CREATE TABLE IF NOT EXISTS `test_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stringni` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `test_table`
--

INSERT INTO `test_table` (`id`, `stringni`) VALUES
(1, 'test-60bf5a24df2944.61045950'),
(2, 'test-60bf5a24ecb887.81038039'),
(3, 'test-60bf5a24ecd285.78119639'),
(4, 'test-60bf5a24ecec45.10838440'),
(5, 'test-60bf5a24ed19f0.16893435'),
(6, 'test-60bf5a24ed3df0.46765228'),
(7, 'test-60bf5a24ed6b23.28460094'),
(8, 'test-60bf5a24ed9279.30207952'),
(9, 'test-60bf5a24edb5e4.43878117'),
(10, 'test-60bf5a24ede1e7.47824382'),
(11, 'test-60bf5a24ee0db5.75129922'),
(12, 'test-60bf5a24ee3217.53813454'),
(13, 'test-60bf5a24ee5df8.86084503'),
(14, 'test-60bf5a24ee90b2.12326392'),
(15, 'test-60bf5a24eebb32.06758536'),
(16, 'test-60bf5a24ef08d0.80765020'),
(17, 'test-60bf5a24ef5ad5.58894121'),
(18, 'test-60bf5a24ef88a0.59951154'),
(19, 'test-60bf5a24efb507.47773724'),
(20, 'test-60bf5a24f004c7.06379112'),
(21, 'test-60bf5a24f02ca3.87969229'),
(22, 'test-60bf5a24f05f27.87121238'),
(23, 'test-60bf5a24f092a0.61865006'),
(24, 'test-60bf5a24f0ba75.31528228'),
(25, 'test-60bf5a24f0e130.17698716'),
(26, 'test-60bf5a24f10990.55340612'),
(27, 'test-60bf5a24f13146.83140061'),
(28, 'test-60bf5a24f15f11.85956891'),
(29, 'test-60bf5a24f18482.17074634'),
(30, 'test-60bf5a24f1a869.31828974'),
(31, 'test-60bf5a24f1cff2.32283250'),
(32, 'test-60bf5a24f1f7d9.74849117'),
(33, 'test-60bf5a24f21f62.67109581'),
(34, 'test-60bf5a24f246c3.62107866'),
(35, 'test-60bf5a24f26e67.79461441'),
(36, 'test-60bf5a24f29692.71406521'),
(37, 'test-60bf5a24f2bee6.88738435'),
(38, 'test-60bf5a24f30185.88178982'),
(39, 'test-60bf5a24f34282.48136453'),
(40, 'test-60bf5a24f37266.83994950'),
(41, 'test-60bf5a24f391d1.38492482'),
(42, 'test-60bf5a24f3a8b1.17390913'),
(43, 'test-60bf5a24f3bf63.90379555'),
(44, 'test-60bf5a24f3d2f1.01222808'),
(45, 'test-60bf5a24f3e782.59261547'),
(46, 'test-60bf5a24f3f764.77950652'),
(47, 'test-60bf5a24f40a69.26552778'),
(48, 'test-60bf5a24f41cb9.43598675');

-- --------------------------------------------------------

--
-- Table structure for table `visitors_log`
--

DROP TABLE IF EXISTS `visitors_log`;
CREATE TABLE IF NOT EXISTS `visitors_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visited` varchar(30) NOT NULL,
  `visitor` varchar(30) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitors_log`
--

INSERT INTO `visitors_log` (`id`, `visited`, `visitor`, `date`) VALUES
(1, '2015-19621', '2038-00001', '2021-06-17 12:20:29'),
(2, '2015-19621', '2038-00001', '2021-06-17 12:20:51'),
(3, '1999-99999', '2038-00001', '2021-06-17 12:21:02'),
(4, '2015-19621', '1999-99999', '2021-06-17 13:16:48'),
(5, '2015-19621', '1999-99999', '2021-06-17 13:16:57'),
(6, '2015-19621', '1999-99999', '2021-06-17 13:16:59'),
(7, '2015-19621', '1980-00001', '2021-06-17 13:25:21'),
(8, '2015-19621', '1999-99999', '2021-06-17 13:29:51'),
(9, '2015-19621', '1999-99999', '2021-06-17 13:29:53'),
(10, '2015-19621', '1999-99999', '2021-06-17 13:29:53'),
(11, '2015-19621', '1999-99999', '2021-06-17 13:29:53'),
(12, '2015-19621', '1999-99999', '2021-06-17 13:29:53'),
(13, '2015-19621', '1999-99999', '2021-06-17 13:29:54'),
(14, '2015-19621', '1999-99999', '2021-06-17 13:29:54'),
(15, '2015-19621', '1999-99999', '2021-06-17 13:29:54'),
(16, '2015-19621', '1999-99999', '2021-06-17 13:29:54'),
(17, '', '2015-19621', '2021-06-17 13:54:37'),
(18, '', '2015-19621', '2021-06-17 13:54:37'),
(19, '', '2015-19621', '2021-06-17 13:55:05'),
(20, '', '2015-19621', '2021-06-17 13:55:05'),
(21, '1999-99999', '2015-19621', '2021-06-17 13:55:24'),
(22, '1999-99999', '2015-19621', '2021-06-17 13:58:12');

-- --------------------------------------------------------

--
-- Structure for view `manage_user_view`
--
DROP TABLE IF EXISTS `manage_user_view`;

DROP VIEW IF EXISTS `manage_user_view`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `manage_user_view`  AS  select `login`.`id_number` AS `id_number`,concat(`reg_info`.`first_name`,' ',`reg_info`.`middle_name`,' ',`reg_info`.`last_name`) AS `full_name`,`login`.`user_type` AS `user_type`,`reg_info`.`status` AS `status` from (`login` join `reg_info` on((`login`.`id_number` = `reg_info`.`id_number`))) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
