

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `fileno` varchar(100) NOT NULL,
  `pancard` varchar(100) NOT NULL,
  `bussiness_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `user_id`, `email`, `name`, `fileno`, `pancard`, `bussiness_name`) VALUES

(12, 18, 'jd1@jd.com', 'jd1', 'jd1', 'jd1', 'jd1'),
(13, 19, 'jd2@jd.com', 'jd2', 'jd2', 'jd2', 'jd2');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Marketing', '2015-01-25 09:29:36', '2015-01-25 09:29:36'),
(2, 'Sales', '2015-01-25 09:29:47', '2015-01-25 12:20:13'),
(3, 'Documents Collection', '2015-01-25 09:30:22', '2015-01-25 09:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `filename` varchar(64) CHARACTER SET utf8 NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1',
  `modified` int(10) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `name`, `filename`, `status`, `modified`, `created`) VALUES
(2, '6bbbf96580b7e1b5e9bd2bbd308f4e6f.jpg', '5e953ba921125f2d3c5b7a0ea9eccfac6aa57143.jpg', 1, 1425397649, 1425397649);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `inbox_uploads`
--

CREATE TABLE IF NOT EXISTS `inbox_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `sent_from` varchar(256) NOT NULL,
  `receive_to` varchar(256) NOT NULL,
  `status` int(6) NOT NULL COMMENT '1=> read,2=>delete from receiver,3=.delete from sender,4=>delete from sender and receiver',
  `folder_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;


-- --------------------------------------------------------

--
-- Table structure for table `manage_folders`
--

CREATE TABLE IF NOT EXISTS `manage_folders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(256) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Status` int(4) NOT NULL DEFAULT '1' COMMENT '1=> active 2=> inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `manage_folders`
--

INSERT INTO `manage_folders` (`id`, `Name`, `user_id`, `Status`) VALUES
(1, 'Inbox', 0, 1),
(2, 'Sent', 0, 1),
(3, 'Drafts', 0, 1),
(8, 't1', 10, 2),
(12, 'new folder', 10, 2),
(13, 'personal folder', 1, 1),
(14, 'files', 10, 1),
(16, 'Test', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(8) NOT NULL DEFAULT '0',
  `user2id` int(8) NOT NULL DEFAULT '0',
  `message` text CHARACTER SET utf8 NOT NULL,
  `folder_id` int(8) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '0' COMMENT '0 => Normal, 1=> deleted by sender, 2 => deleted by received, 3 => deleted by both',
  `document_id` int(8) NOT NULL DEFAULT '0',
  `modified` int(10) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `user2id`, `message`, `folder_id`, `status`, `document_id`, `modified`, `created`) VALUES
(1, 1, 2, 'Ttttt', 0, 0, 2, 1425397649, 1425397649),
(2, 1, 6, 'Ttttt', 0, 0, 2, 1425397649, 1425397649);

-- --------------------------------------------------------

--
-- Table structure for table `sent_uploads`
--

CREATE TABLE IF NOT EXISTS `sent_uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `upload_id` int(11) NOT NULL,
  `sent_from` varchar(256) NOT NULL,
  `receive_to` varchar(256) NOT NULL,
  `status` int(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `sent_uploads`
--


-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE IF NOT EXISTS `staffs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `father_name` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `references` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`id`, `user_id`, `department_id`, `email`, `name`, `father_name`, `dob`, `references`) VALUES
(3, 10, 1, 'kc@gmai.com', 'khushboo', 'B.Chopra', '1995-02-03', ''),
(4, 12, 1, 'ss@gmail.com', 'sunil sandhu', 'xyz', '2015-02-24', ''),
(5, 16, 3, 'rs@gmail.com', 'ritu', 'pawan', '2015-02-27', 'gggg');

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE IF NOT EXISTS `uploads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `filename` varchar(100) NOT NULL,
  `filetouser` int(11) DEFAULT NULL,
  `upload_by` int(11) NOT NULL,
  `description` text,
  `label_id` int(11) DEFAULT '0',
  `manage_folder_id` int(8) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `uploads`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `group_id`, `created`, `modified`, `status`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, '2012-04-08 15:26:09', '2015-03-03 14:28:04', 1),
(17, 'jd', 'ff9dedefe9ee78b3339d23163d8b29a3c83c6016', 3, '2015-03-03 13:15:41', '2015-03-03 13:15:41', 1),
(18, 'jd1', 'ec78ee911838b94136b5bd9f92e92450c8cb8613', 3, '2015-03-03 18:09:26', '2015-03-03 18:09:26', 0),
(19, 'jd2', '010bd46b1be459ad9792d13f3403981aea157dc3', 3, '2015-03-03 18:21:09', '2015-03-03 18:21:09', 0);
