-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 10, 2017 at 05:28 AM
-- Server version: 5.5.31
-- PHP Version: 5.5.24

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cob_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_group`
--

CREATE TABLE IF NOT EXISTS `access_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `submodule_id` int(11) NOT NULL,
  `access_permission` int(11) NOT NULL,
  `insert_permission` int(11) NOT NULL,
  `update_permission` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1310 ;

--
-- Dumping data for table `access_group`
--

INSERT INTO `access_group` (`id`, `role_id`, `submodule_id`, `access_permission`, `insert_permission`, `update_permission`, `created_at`, `updated_at`) VALUES
(1309, 1, 24, 1, 0, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1308, 1, 23, 1, 0, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1307, 1, 22, 1, 0, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1306, 1, 21, 1, 0, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1305, 1, 20, 1, 0, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1304, 1, 19, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1303, 1, 18, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1302, 1, 17, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1301, 1, 16, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1300, 1, 15, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1299, 1, 14, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1298, 1, 13, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1297, 1, 12, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1296, 1, 11, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1295, 1, 10, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1294, 1, 9, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1293, 1, 8, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1292, 1, 7, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1291, 1, 6, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1290, 1, 5, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1289, 1, 4, 1, 0, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1288, 1, 3, 1, 0, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1287, 1, 2, 1, 1, 0, '2016-12-07 15:03:46', '2016-12-07 15:03:46'),
(1286, 1, 1, 1, 1, 1, '2016-12-07 15:03:46', '2016-12-07 15:03:46');

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE IF NOT EXISTS `agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `address3` varchar(255) NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ajk_details`
--

CREATE TABLE IF NOT EXISTS `ajk_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `monitoring_id` int(11) NOT NULL,
  `designation` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `year` year(4) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE IF NOT EXISTS `audit_trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `audit_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE IF NOT EXISTS `buyer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `unit_no` varchar(45) NOT NULL,
  `unit_share` varchar(45) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `ic_company_no` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `commercial_block`
--

CREATE TABLE IF NOT EXISTS `commercial_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `strata_id` int(11) NOT NULL,
  `unit_no` varchar(255) NOT NULL,
  `maintenance_fee` double NOT NULL,
  `maintenance_fee_option` int(11) NOT NULL,
  `sinking_fund` double NOT NULL,
  `sinking_fund_option` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rob_roc_no` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `address3` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `name`, `rob_roc_no`, `phone_no`, `fax_no`, `email`, `address1`, `address2`, `address3`, `city`, `poscode`, `state`, `country`, `image_url`, `created_at`, `updated_at`) VALUES
(1, 'MAJLIS PERBANDARAN AMPANG JAYA (MPAJ)', '1800-22-8100', 'Office Number', 'Fax Number', 'company@company.com', 'Menara MPAJ,', ' Jalan Pandan Utama,', 'Pandan Indah,', '3', '55100', '1', '1', 'http://localhost/eCOB/assets/common/img/logo/20161129171009_e3a75991-514c-41ea-b404-3247cedd1a78.gif', '2016-11-10 00:00:00', '2016-12-29 11:25:23');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `designation`
--

CREATE TABLE IF NOT EXISTS `designation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

CREATE TABLE IF NOT EXISTS `developer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `address3` varchar(255) NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dun`
--

CREATE TABLE IF NOT EXISTS `dun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parliament` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `facility`
--

CREATE TABLE IF NOT EXISTS `facility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `strata_id` int(11) NOT NULL,
  `management_office` int(11) NOT NULL,
  `swimming_pool` int(11) NOT NULL,
  `surau` int(11) NOT NULL,
  `multipurpose_hall` int(11) NOT NULL,
  `gym` int(11) NOT NULL,
  `playground` int(11) NOT NULL,
  `guardhouse` int(11) NOT NULL,
  `kindergarten` int(11) NOT NULL,
  `open_space` int(11) NOT NULL,
  `lift` int(11) NOT NULL,
  `rubbish_room` int(11) NOT NULL,
  `gated` int(11) NOT NULL,
  `others` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fileprefix`
--

CREATE TABLE IF NOT EXISTS `fileprefix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_no` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `house_scheme`
--

CREATE TABLE IF NOT EXISTS `house_scheme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `developer` int(11) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `fax_no` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `land_title`
--

CREATE TABLE IF NOT EXISTS `land_title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE IF NOT EXISTS `management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `is_jmb` int(11) NOT NULL,
  `is_mc` int(11) NOT NULL,
  `is_agent` int(11) NOT NULL,
  `is_others` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `management_agent`
--

CREATE TABLE IF NOT EXISTS `management_agent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `management_id` int(11) NOT NULL,
  `selected_by` varchar(255) NOT NULL,
  `agent` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `fax_no` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `management_jmb`
--

CREATE TABLE IF NOT EXISTS `management_jmb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `management_id` int(11) NOT NULL,
  `date_formed` datetime NOT NULL,
  `certificate_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `fax_no` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `management_mc`
--

CREATE TABLE IF NOT EXISTS `management_mc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `management_id` int(11) NOT NULL,
  `date_formed` datetime NOT NULL,
  `first_agm` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `fax_no` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `management_others`
--

CREATE TABLE IF NOT EXISTS `management_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `management_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `phone_no` varchar(45) NOT NULL,
  `fax_no` varchar(45) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meeting_document`
--

CREATE TABLE IF NOT EXISTS `meeting_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `monitoring_id` int(11) NOT NULL,
  `agm_date` datetime NOT NULL,
  `agm` int(11) NOT NULL,
  `egm` int(11) NOT NULL,
  `minit_meeting` int(11) NOT NULL,
  `letter_integrity_url` text NOT NULL,
  `letter_bankruptcy_url` text NOT NULL,
  `jmc_spa` int(11) NOT NULL,
  `identity_card` int(11) NOT NULL,
  `attendance` int(11) NOT NULL,
  `financial_report` int(11) NOT NULL,
  `audit_start_date` datetime NOT NULL,
  `audit_end_date` datetime NOT NULL,
  `audit_report` varchar(255) NOT NULL,
  `audit_report_url` text NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE IF NOT EXISTS `memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `memo_type_id` int(11) NOT NULL,
  `memo_date` datetime NOT NULL,
  `publish_date` datetime NOT NULL,
  `expired_date` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `memo_type`
--

CREATE TABLE IF NOT EXISTS `memo_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE IF NOT EXISTS `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name_en` varchar(255) NOT NULL,
  `name_my` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id`, `name_en`, `name_my`, `created_at`, `updated_at`) VALUES
(1, 'COB Maintenance', 'Pengurusan COB', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(2, 'Administration', 'Pentadbiran', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(3, 'Master Setup', 'Pengurusan Master Data', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(4, 'Reporting', 'Laporan', '2016-11-14 00:00:00', '2016-11-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `monitoring`
--

CREATE TABLE IF NOT EXISTS `monitoring` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `pre_calculate` int(11) NOT NULL,
  `buyer_registration` int(11) NOT NULL,
  `certificate_no` varchar(45) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `others_details`
--

CREATE TABLE IF NOT EXISTS `others_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` text NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `description` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `park`
--

CREATE TABLE IF NOT EXISTS `park` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dun` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `parliment`
--

CREATE TABLE IF NOT EXISTS `parliment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `perimeter`
--

CREATE TABLE IF NOT EXISTS `perimeter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `residential_block`
--

CREATE TABLE IF NOT EXISTS `residential_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `strata_id` int(11) NOT NULL,
  `unit_no` varchar(255) NOT NULL,
  `maintenance_fee` double NOT NULL,
  `maintenance_fee_option` int(11) NOT NULL,
  `sinking_fund` double NOT NULL,
  `sinking_fund_option` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `is_active`, `is_deleted`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 1, 0, 'Administrator', '2016-11-08 00:00:00', '2016-12-06 15:18:35');

-- --------------------------------------------------------

--
-- Table structure for table `scoring_quality_index`
--

CREATE TABLE IF NOT EXISTS `scoring_quality_index` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `survey` varchar(255) NOT NULL,
  `score1` int(11) NOT NULL,
  `score2` int(11) NOT NULL,
  `score3` int(11) NOT NULL,
  `score4` int(11) NOT NULL,
  `score5` int(11) NOT NULL,
  `score6` int(11) NOT NULL,
  `score7` int(11) NOT NULL,
  `score8` int(11) NOT NULL,
  `score9` int(11) NOT NULL,
  `score10` int(11) NOT NULL,
  `score11` int(11) NOT NULL,
  `score12` int(11) NOT NULL,
  `score13` int(11) NOT NULL,
  `score14` int(11) NOT NULL,
  `score15` int(11) NOT NULL,
  `score16` int(11) NOT NULL,
  `score17` int(11) NOT NULL,
  `score18` int(11) NOT NULL,
  `score19` int(11) NOT NULL,
  `score20` int(11) NOT NULL,
  `score21` int(11) NOT NULL,
  `total_score` decimal(5,2) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `strata`
--

CREATE TABLE IF NOT EXISTS `strata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parliament` int(11) NOT NULL,
  `dun` int(11) NOT NULL,
  `park` int(11) NOT NULL,
  `address1` text NOT NULL,
  `address2` text NOT NULL,
  `address3` text NOT NULL,
  `city` int(11) NOT NULL,
  `poscode` varchar(45) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `block_no` varchar(255) NOT NULL,
  `ownership_no` varchar(255) NOT NULL,
  `town` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `land_area` varchar(45) NOT NULL,
  `land_area_unit` int(11) NOT NULL,
  `lot_no` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `land_title` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `perimeter` int(11) NOT NULL,
  `file_url` text NOT NULL,
  `is_residential` int(11) NOT NULL,
  `is_commercial` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_module`
--

CREATE TABLE IF NOT EXISTS `sub_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `name_en` varchar(255) NOT NULL,
  `name_my` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `sub_module`
--

INSERT INTO `sub_module` (`id`, `module_id`, `name_en`, `name_my`, `created_at`, `updated_at`) VALUES
(1, 1, 'COB File Prefix', 'Awalan Fail COB', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(2, 1, 'Add COB File', 'Tambah Fail COB', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(3, 1, 'COB File List', 'Senarai Fail COB', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(4, 2, 'Edit Organization Profile', 'Edit Profil Organisasi', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(5, 2, 'Access Group Management', 'Akses Kumpulan', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(6, 2, 'User Management', 'Pengurusan Pengguna', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(7, 2, 'Memo Maintenance', 'Pengurusan Memo', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(8, 3, 'Area', 'Daerah', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(9, 3, 'City', 'Bandar', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(10, 3, 'Category', 'Kategori', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(11, 3, 'Land Title', 'Jenis Tanah', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(12, 3, 'Developer', 'Pemaju', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(13, 3, 'Agent', 'Ejen', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(14, 3, 'Parliment', 'Parlimen', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(15, 3, 'DUN', 'DUN', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(16, 3, 'Park', 'Taman', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(17, 3, 'Memo Type', 'Jenis Memo', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(18, 3, 'Designation', 'Jawatan', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(19, 3, 'Unit of Measure', 'Unit Ukuran', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(20, 4, 'Audit Trail', 'Audit Trail', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(21, 4, 'File By Location', 'Fail Mengikut Lokasi', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(22, 4, 'Rating Summary', 'Penakrifan Bintang', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(23, 4, 'Management Summary', 'Rumusan Pengurusan', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(24, 4, 'COB File / Management (%)', 'Fail COB / Pengurusan (%)', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(26, 0, 'Administration', '', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(27, 0, 'Master Setup', '', '2016-11-14 00:00:00', '2016-11-14 00:00:00'),
(28, 0, 'Reporting', '', '2016-11-14 00:00:00', '2016-11-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `unit_measure`
--

CREATE TABLE IF NOT EXISTS `unit_measure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `unit_measure`
--

INSERT INTO `unit_measure` (`id`, `description`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'sf', 1, 0, '2016-11-10 14:53:45', '2016-11-10 14:58:10'),
(2, 'mp', 1, 0, '2016-11-17 17:24:12', '2016-12-06 11:10:16');

-- --------------------------------------------------------

--
-- Table structure for table `unit_option`
--

CREATE TABLE IF NOT EXISTS `unit_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `unit_option`
--

INSERT INTO `unit_option` (`id`, `description`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'PER SQ FT', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'PER SHARE UNIT', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'LUM SUM', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `role` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `remember_token` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `phone_no`, `role`, `remarks`, `remember_token`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$WfOeun/koHCwjBEY4NpczOv2LfqLoR0LPWxvJ.eY9n6y09XorzT22', 'System Administrator', 'admin@admin.com', '0123455678', 1, 'Admin', 'q6DNhgaB18qnuhr9Wj0uytHWgCT6LdNu70hTvmO3uIxVahuOW7Z2tApFOjgl', 1, 0, '2016-11-08 00:00:00', '2017-01-06 11:23:33');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
