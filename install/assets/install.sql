-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 08, 2012 at 03:21 PM
-- Server version: 5.5.19
-- PHP Version: 5.3.8

-- --------------------------------------------------------


--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `previous_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_rotate` int(10) unsigned NOT NULL DEFAULT '0',
  `last_write` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`,`previous_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `TB_APISetting`
--

DROP TABLE IF EXISTS `TB_APISetting`;
CREATE TABLE IF NOT EXISTS `TB_APISetting` (
  `PK_APISettingNum` bigint(255) NOT NULL AUTO_INCREMENT,
  `U_Title` varchar(255) DEFAULT NULL,
  `Value` varchar(255) DEFAULT NULL,
  `Display_Title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PK_APISettingNum`),
  UNIQUE KEY `U_Title` (`U_Title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_Department`
--

DROP TABLE IF EXISTS `TB_Department`;
CREATE TABLE IF NOT EXISTS `TB_Department` (
  `PK_DepartmentNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `U_DepartmentTitle` varchar(255) DEFAULT NULL,
  `DepartmentFusionID` bigint(20) NOT NULL,
  PRIMARY KEY (`PK_DepartmentNum`),
  UNIQUE KEY `U_Title_UNIQUE` (`U_DepartmentTitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_Equipment`
--

DROP TABLE IF EXISTS `TB_Equipment`;
CREATE TABLE IF NOT EXISTS `TB_Equipment` (
  `PK_EquipmentNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `FK_TicketNum` bigint(20) NOT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Notes` text,
  PRIMARY KEY (`PK_EquipmentNum`),
  KEY `TB_Equipment_FK_TicketNum` (`FK_TicketNum`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_Priority`
--

DROP TABLE IF EXISTS `TB_Priority`;
CREATE TABLE IF NOT EXISTS `TB_Priority` (
  `PK_PriorityNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `U_PriorityTitle` varchar(255) DEFAULT NULL,
  `PriorityFusionID` bigint(20) NOT NULL,
  PRIMARY KEY (`PK_PriorityNum`),
  UNIQUE KEY `U_Title_UNIQUE` (`U_PriorityTitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_Setting`
--

DROP TABLE IF EXISTS `TB_Setting`;
CREATE TABLE IF NOT EXISTS `TB_Setting` (
  `PK_SettingNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `U_Title` varchar(255) DEFAULT NULL,
  `Default` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PK_SettingNum`),
  UNIQUE KEY `U_Title` (`U_Title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `TB_Setting`
--

INSERT INTO `TB_Setting` (`PK_SettingNum`, `U_Title`, `Default`) VALUES
(1, 'DefaultTicketPriority', 'Normal'),
(2, 'DefaultTicketDepartment', 'General');

-- --------------------------------------------------------

--
-- Table structure for table `TB_Ticket`
--

DROP TABLE IF EXISTS `TB_Ticket`;
CREATE TABLE IF NOT EXISTS `TB_Ticket` (
  `PK_TicketNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `FK_PriorityNum` bigint(20) NOT NULL,
  `FK_DepartmentNum` bigint(20) NOT NULL,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `Issue` text,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) DEFAULT NULL,
  `TicketFusionID` varchar(45) DEFAULT NULL,
  `TicketDisplayID` varchar(255) DEFAULT NULL,
  `Deadline` date DEFAULT NULL,
  `Subject` varchar(45) DEFAULT NULL,
  `FullFusionText` text,
  `Staff` varchar(45) DEFAULT NULL,
  `CreatedDT` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `BarcodeImagePath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PK_TicketNum`),
  KEY `fk_TB_Ticket_TB_Priority1` (`FK_PriorityNum`),
  KEY `fk_TB_Ticket_TB_Department1` (`FK_DepartmentNum`),
  KEY `TicketDisplayID` (`TicketDisplayID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_TicketUser`
--

DROP TABLE IF EXISTS `TB_TicketUser`;
CREATE TABLE IF NOT EXISTS `TB_TicketUser` (
  `PKa_TicketNum` bigint(20) NOT NULL,
  `PKb_UserNum` bigint(20) NOT NULL,
  PRIMARY KEY (`PKa_TicketNum`,`PKb_UserNum`),
  KEY `TB_Ticket_PKa_UserNum` (`PKb_UserNum`),
  KEY `TB_Ticket_PKa_TicketNum` (`PKa_TicketNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `TB_User`
--

DROP TABLE IF EXISTS `TB_User`;
CREATE TABLE IF NOT EXISTS `TB_User` (
  `PK_UserNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `First` varchar(45) NOT NULL DEFAULT '',
  `Last` varchar(45) NOT NULL DEFAULT '',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `Email` varchar(45) NOT NULL DEFAULT '',
  `U_Username` varchar(45) NOT NULL,
  PRIMARY KEY (`PK_UserNum`),
  UNIQUE KEY `TB_User_U_Username` (`U_Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `TB_UserSetting`
--

DROP TABLE IF EXISTS `TB_UserSetting`;
CREATE TABLE IF NOT EXISTS `TB_UserSetting` (
  `PKa_UserNum` bigint(20) NOT NULL,
  `PKb_SettingNum` bigint(20) NOT NULL,
  `Value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`PKa_UserNum`,`PKb_SettingNum`),
  KEY `TB_UserSetting_PKb_SettingNum` (`PKb_SettingNum`),
  KEY `TB_UserSetting_PKa_SettingNum` (`PKa_UserNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Constraints for dumped tables
--

--
-- Constraints for table `TB_Equipment`
--
ALTER TABLE `TB_Equipment`
  ADD CONSTRAINT `fk_TB_Equipment_TB_Ticket1` FOREIGN KEY (`FK_TicketNum`) REFERENCES `TB_Ticket` (`PK_TicketNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `TB_Ticket`
--
ALTER TABLE `TB_Ticket`
  ADD CONSTRAINT `fk_TB_Ticket_TB_Department1` FOREIGN KEY (`FK_DepartmentNum`) REFERENCES `TB_Department` (`PK_DepartmentNum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TB_Ticket_TB_Priority1` FOREIGN KEY (`FK_PriorityNum`) REFERENCES `TB_Priority` (`PK_PriorityNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `TB_TicketUser`
--
ALTER TABLE `TB_TicketUser`
  ADD CONSTRAINT `fk_TB_Ticket_has_TB_User_TB_Ticket` FOREIGN KEY (`PKa_TicketNum`) REFERENCES `TB_Ticket` (`PK_TicketNum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TB_Ticket_has_TB_User_TB_User1` FOREIGN KEY (`PKb_UserNum`) REFERENCES `TB_User` (`PK_UserNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `TB_UserSetting`
--
ALTER TABLE `TB_UserSetting`
  ADD CONSTRAINT `fk_TB_User_has_TB_Setting_TB_Setting1` FOREIGN KEY (`PKb_SettingNum`) REFERENCES `TB_Setting` (`PK_SettingNum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TB_User_has_TB_Setting_TB_User1` FOREIGN KEY (`PKa_UserNum`) REFERENCES `TB_User` (`PK_UserNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;
