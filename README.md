whois
=====

Databse Structure of whois server

-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 17, 2014 at 06:23 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `ciwho`
--

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countries_id` int(11) NOT NULL AUTO_INCREMENT,
  `countries_name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `countries_iso_code_2` char(2) CHARACTER SET latin1 NOT NULL,
  `countries_iso_code_3` char(3) CHARACTER SET latin1 NOT NULL,
  `address_format_id` int(11) NOT NULL,
  PRIMARY KEY (`countries_id`),
  KEY `IDX_COUNTRIES_NAME` (`countries_name`),
  KEY `countries_iso_code_2` (`countries_iso_code_2`),
  KEY `countries_iso_code_3` (`countries_iso_code_3`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=240 ;

-- --------------------------------------------------------

--
-- Table structure for table `domain_dns`
--

CREATE TABLE IF NOT EXISTS `domain_dns` (
  `dnsid` bigint(20) NOT NULL AUTO_INCREMENT,
  `dnsofdomain` varchar(255) NOT NULL,
  `a_record` text NOT NULL,
  `ns_record` text NOT NULL,
  `mx_record` text NOT NULL,
  `soa_record` text NOT NULL,
  `aaa_record` text NOT NULL,
  `txt_record` text NOT NULL,
  `fetchtime` varchar(20) NOT NULL,
  PRIMARY KEY (`dnsid`),
  UNIQUE KEY `dnsofdomain` (`dnsofdomain`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

-- --------------------------------------------------------

--
-- Table structure for table `domain_os_headers`
--

CREATE TABLE IF NOT EXISTS `domain_os_headers` (
  `did` bigint(20) NOT NULL AUTO_INCREMENT,
  `domainname` varchar(255) NOT NULL,
  `opensource` varchar(50) NOT NULL,
  `http_server` varchar(255) NOT NULL,
  `http_x_powered_by` varchar(255) NOT NULL,
  `http_set_cookie` varchar(255) NOT NULL,
  `http_vary` varchar(255) NOT NULL,
  `http_transfer_encoding` varchar(255) NOT NULL,
  `http_content_type` varchar(255) NOT NULL,
  `record_added` bigint(20) NOT NULL,
  `os_version` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `fetched` tinyint(1) NOT NULL,
  PRIMARY KEY (`did`),
  KEY `opensource` (`opensource`,`http_x_powered_by`),
  KEY `domainname` (`domainname`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34551 ;

-- --------------------------------------------------------

--
-- Table structure for table `domain_whois`
--

CREATE TABLE IF NOT EXISTS `domain_whois` (
  `domain_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `domain_ip` text,
  `domain_name` varchar(255) NOT NULL,
  `ns1` varchar(100) NOT NULL,
  `ns2` varchar(100) NOT NULL,
  `ns3` varchar(100) DEFAULT NULL,
  `ns4` varchar(100) DEFAULT NULL,
  `nsip1` varchar(255) DEFAULT NULL,
  `nsip2` varchar(255) DEFAULT NULL,
  `nsip3` varchar(255) DEFAULT NULL,
  `nsip4` varchar(255) DEFAULT NULL,
  `dc_org` varchar(255) DEFAULT NULL,
  `owneremail` varchar(255) DEFAULT NULL,
  `adminemail` varchar(255) DEFAULT NULL,
  `techemail` varchar(255) DEFAULT NULL,
  `dc_name` varchar(255) DEFAULT NULL,
  `ownername` varchar(255) DEFAULT NULL,
  `phonedetails` varchar(255) DEFAULT NULL,
  `spensorname` varchar(255) DEFAULT NULL,
  `address` text,
  `created` varchar(255) DEFAULT NULL,
  `expire` varchar(255) DEFAULT NULL,
  `status_info` text,
  `registrarname` varchar(255) DEFAULT NULL,
  `reffername` varchar(255) DEFAULT NULL,
  `dc_country` varchar(255) DEFAULT NULL,
  `adddate` bigint(20) DEFAULT NULL,
  `rawdata` text,
  `dc_address` text,
  `updatedon` varchar(255) DEFAULT NULL,
  `host_org` varchar(255) NOT NULL,
  PRIMARY KEY (`domain_id`),
  UNIQUE KEY `domain_name` (`domain_name`),
  KEY `dc_country` (`dc_country`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4432006 ;

-- --------------------------------------------------------

--
-- Table structure for table `domain_whois_history`
--

CREATE TABLE IF NOT EXISTS `domain_whois_history` (
  `domain_id` bigint(20) NOT NULL,
  `domain_ip` text,
  `domain_name` varchar(255) NOT NULL,
  `ns1` varchar(100) NOT NULL,
  `ns2` varchar(100) NOT NULL,
  `ns3` varchar(100) DEFAULT NULL,
  `ns4` varchar(100) DEFAULT NULL,
  `nsip1` varchar(255) DEFAULT NULL,
  `nsip2` varchar(255) DEFAULT NULL,
  `nsip3` varchar(255) DEFAULT NULL,
  `nsip4` varchar(255) DEFAULT NULL,
  `dc_org` varchar(255) DEFAULT NULL,
  `owneremail` varchar(255) DEFAULT NULL,
  `adminemail` varchar(255) DEFAULT NULL,
  `techemail` varchar(255) DEFAULT NULL,
  `dc_name` varchar(255) DEFAULT NULL,
  `ownername` varchar(255) DEFAULT NULL,
  `phonedetails` varchar(255) DEFAULT NULL,
  `spensorname` varchar(255) DEFAULT NULL,
  `address` text,
  `created` varchar(255) DEFAULT NULL,
  `expire` varchar(255) DEFAULT NULL,
  `status_info` text,
  `registrarname` varchar(255) DEFAULT NULL,
  `reffername` varchar(255) DEFAULT NULL,
  `dc_country` varchar(255) DEFAULT NULL,
  `adddate` bigint(20) DEFAULT NULL,
  `rawdata` text,
  `dc_address` varchar(255) DEFAULT NULL,
  `updatedon` varchar(255) NOT NULL,
  `host_org` varchar(255) DEFAULT NULL,
  KEY `domain_id` (`domain_id`),
  KEY `domain_name` (`domain_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

