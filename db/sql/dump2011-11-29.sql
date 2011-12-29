-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 29, 2011 at 08:39 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `db_kayako`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `TB_Equipment`
--

CREATE TABLE `TB_Equipment` (
  `PK_EquipmentNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `FK_TicketNum` bigint(20) NOT NULL,
  `Type` varchar(45) DEFAULT NULL,
  `Model` varchar(45) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Notes` text,
  PRIMARY KEY (`PK_EquipmentNum`),
  KEY `TB_Equipment_FK_TicketNum` (`FK_TicketNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `TB_Equipment`
--


-- --------------------------------------------------------

--
-- Table structure for table `TB_Ticket`
--

CREATE TABLE `TB_Ticket` (
  `PK_TicketNum` bigint(20) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) DEFAULT NULL,
  `LastName` varchar(45) DEFAULT NULL,
  `Issue` text,
  `Phone` varchar(45) DEFAULT NULL,
  `Email` varchar(45) NOT NULL,
  `SupportSuiteID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`PK_TicketNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `TB_Ticket`
--


-- --------------------------------------------------------

--
-- Table structure for table `TB_Ticket_has_TB_User`
--

CREATE TABLE `TB_Ticket_has_TB_User` (
  `PKa_TicketNum` bigint(20) NOT NULL,
  `PKb_UserNum` int(11) NOT NULL,
  PRIMARY KEY (`PKa_TicketNum`,`PKb_UserNum`),
  KEY `TB_Ticket_PKa_UserNum` (`PKb_UserNum`),
  KEY `TB_Ticket_PKa_TicketNum` (`PKa_TicketNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `TB_Ticket_has_TB_User`
--


-- --------------------------------------------------------

--
-- Table structure for table `TB_User`
--

CREATE TABLE `TB_User` (
  `PK_UserNum` int(11) NOT NULL AUTO_INCREMENT,
  `First` varchar(45) NOT NULL DEFAULT '',
  `Last` varchar(45) NOT NULL DEFAULT '',
  `Password` varchar(255) NOT NULL DEFAULT '',
  `Email` varchar(45) NOT NULL DEFAULT '',
  `U_Username` varchar(45) NOT NULL,
  PRIMARY KEY (`PK_UserNum`),
  UNIQUE KEY `U_Username_UNIQUE` (`U_Username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `TB_User`
--

INSERT INTO `TB_User` (`PK_UserNum`, `First`, `Last`, `Password`, `Email`, `U_Username`) VALUES
(1, 'TEST', 'TEST', '098f6bcd4621d373cade4e832627b4f6', 'test@test.test', 'test');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `TB_Equipment`
--
ALTER TABLE `TB_Equipment`
  ADD CONSTRAINT `fk_TB_Equipment_TB_Ticket1` FOREIGN KEY (`FK_TicketNum`) REFERENCES `TB_Ticket` (`PK_TicketNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `TB_Ticket_has_TB_User`
--
ALTER TABLE `TB_Ticket_has_TB_User`
  ADD CONSTRAINT `fk_TB_Ticket_has_TB_User_TB_Ticket` FOREIGN KEY (`PKa_TicketNum`) REFERENCES `TB_Ticket` (`PK_TicketNum`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_TB_Ticket_has_TB_User_TB_User1` FOREIGN KEY (`PKb_UserNum`) REFERENCES `TB_User` (`PK_UserNum`) ON DELETE NO ACTION ON UPDATE NO ACTION;
