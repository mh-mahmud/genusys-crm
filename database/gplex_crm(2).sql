-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 23, 2024 at 11:00 AM
-- Server version: 8.3.0
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gplex_crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
CREATE TABLE IF NOT EXISTS `agents` (
  `agent_id` char(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_day` date DEFAULT NULL,
  `status` tinyint NOT NULL,
  `role_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `did` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seat_id` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `skill_id` char(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `performance` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`agent_id`),
  KEY `agents_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `user_id`, `first_name`, `last_name`, `phone_number`, `birth_day`, `status`, `role_id`, `did`, `seat_id`, `skill_id`, `gender`, `address`, `description`, `performance`, `created_at`, `updated_at`) VALUES
('1538', 2, 'Md', 'Rokibuzzaman', '01731214425', '2024-05-22', 1, NULL, NULL, NULL, NULL, NULL, 'Mirpur', 'note that', NULL, '2024-05-20 11:26:27', '2024-09-12 00:52:30'),
('1979', 7, 'Ali', 'Hossian', '01919102030', '2024-09-01', 1, NULL, NULL, NULL, NULL, 'Male', NULL, NULL, NULL, '2024-09-11 01:08:09', '2024-09-12 00:59:30'),
('2125', 6, 'Alamin', 'Khan', '01731214425', '2024-06-12', 1, NULL, NULL, NULL, NULL, 'Female', '441/5,senpara', '441/5,senpara', NULL, '2024-06-02 14:17:30', '2024-07-07 19:43:08'),
('2479', 8, 'Agent', 'New', NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-15 04:07:26', '2024-09-15 04:07:26'),
('9271', 4, 'jaman', 'hasans', '01731214425', '2024-05-01', 1, NULL, NULL, NULL, NULL, NULL, 'dfdfd', 'ddfdd', NULL, '2024-05-27 12:59:32', '2024-07-04 13:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `api_users`
--

DROP TABLE IF EXISTS `api_users`;
CREATE TABLE IF NOT EXISTS `api_users` (
  `username` char(15) NOT NULL,
  `password` char(30) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `api_users`
--

INSERT INTO `api_users` (`username`, `password`, `status`) VALUES
('gplex_crm', 'GLXS_OKTaYHRs@6', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `state_id` int DEFAULT NULL,
  `city_id` int DEFAULT NULL,
  `branch_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
CREATE TABLE IF NOT EXISTS `campaigns` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template_id` int DEFAULT NULL,
  `sms_template_id` int DEFAULT NULL,
  `campaign_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `campaign_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `template_type` varchar(192) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `campaign_limit` int DEFAULT NULL,
  `campaign_service` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `promotion_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `campaigns_promotion_id_index` (`promotion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `campaigns`
--

INSERT INTO `campaigns` (`id`, `form_id`, `email_template_id`, `sms_template_id`, `campaign_title`, `start_date`, `end_date`, `description`, `campaign_type`, `template_type`, `campaign_limit`, `campaign_service`, `status`, `promotion_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 'Sell Home Loan Campaign', '2024-06-01', '2024-06-21', 'zzzdsds', 'Direct mail', NULL, 20, 'Marketing', 1, 44, '2024-06-11 11:33:01', '2024-06-11 15:36:00'),
(2, NULL, NULL, NULL, 'demo', '2024-05-31', '2024-06-01', 'des', 'Social Media', NULL, 34, 'dsds', 1, 45, '2024-06-11 13:24:26', '2024-06-11 17:17:16'),
(3, NULL, NULL, NULL, 'demo', '2024-06-01', '2024-06-13', NULL, 'Phone calls', NULL, 33, 'adasdaa', 1, 45, '2024-06-13 12:26:21', '2024-07-03 10:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `campaign_data`
--

DROP TABLE IF EXISTS `campaign_data`;
CREATE TABLE IF NOT EXISTS `campaign_data` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_template_id` int DEFAULT NULL,
  `sms_template_id` int DEFAULT NULL,
  `csv_id` char(10) DEFAULT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campaign_data_email_unique` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

DROP TABLE IF EXISTS `city`;
CREATE TABLE IF NOT EXISTS `city` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int NOT NULL,
  `state_id` int NOT NULL,
  `city_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(4, 'United States', 1, '2024-10-06 09:35:55', NULL),
(5, 'England', 1, '2024-10-06 09:35:55', NULL),
(6, 'Bangladesh', 1, '2024-10-06 09:36:16', NULL),
(7, 'Australia', 1, '2024-10-06 09:36:16', NULL),
(8, 'Saudi Arabia', 1, '2024-10-06 09:41:22', NULL),
(9, 'Iran', 1, '2024-10-06 09:41:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
CREATE TABLE IF NOT EXISTS `country` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `name` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `symbol`, `status`, `created_at`, `updated_at`) VALUES
(4, 'USD', '$', 1, '2024-08-25 07:03:24', '2024-08-25 07:03:24'),
(5, 'BDT', NULL, 0, NULL, NULL),
(6, 'EURO', NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `lead_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_group` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `lead_id`, `customer_id`, `customer_group`, `customer_notes`, `created_at`, `updated_at`) VALUES
(1, '201', 'G0I20', 'NEW CLIENT', 'this is a test note.', '2024-08-21 22:03:11', '2024-08-21 22:03:11'),
(3, '201', '0DE1G', 'NEW CLIENT', 'hyy byj tyjyt jytj', '2024-08-21 22:05:06', '2024-08-21 22:05:06'),
(4, '201', 'B88GA', 'NEW CLIENT', 'This is a test note.', '2024-08-21 22:06:57', '2024-08-21 22:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `email_log`
--

DROP TABLE IF EXISTS `email_log`;
CREATE TABLE IF NOT EXISTS `email_log` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` bigint UNSIGNED DEFAULT NULL,
  `lead_id` bigint UNSIGNED DEFAULT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `email_from` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_to` char(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_time` datetime DEFAULT NULL,
  `delivery_time` datetime DEFAULT NULL,
  `send_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_queue`
--

DROP TABLE IF EXISTS `email_queue`;
CREATE TABLE IF NOT EXISTS `email_queue` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint DEFAULT NULL,
  `email_from` char(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_to` char(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_subject` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `csv_id` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority_level` tinyint DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email_subject` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

DROP TABLE IF EXISTS `leads`;
CREATE TABLE IF NOT EXISTS `leads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `marital_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `company` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_status` tinyint NOT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_rating` int DEFAULT NULL,
  `website` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_owner` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `industry` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_employee` int DEFAULT NULL,
  `lead_source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `leads_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads`
--

INSERT INTO `leads` (`id`, `form_id`, `first_name`, `last_name`, `email`, `phone`, `profile_image`, `alternative_number`, `gender`, `dob`, `marital_status`, `address`, `age`, `company`, `lead_status`, `title`, `lead_rating`, `website`, `lead_owner`, `industry`, `no_of_employee`, `lead_source`, `street`, `city`, `zip`, `state`, `country`, `lead_notes`, `created_by`, `created_at`, `updated_at`) VALUES
(197, '3092288972', 'Hasan', 'Mahmudss', 'mahmud@gmail.com', '01731214426', '27164663_987829178034171_2149106983021255887_o_1725360931.jpg', NULL, 'Male', '2024-07-10', NULL, NULL, 23, NULL, 1, 'Event Lead', 34, NULL, 'www', 'CAR', NULL, 'Email marketing', 'd block', NULL, '2311', NULL, 'BD', NULL, 1, '2024-07-09 18:37:43', '2024-09-03 04:55:31'),
(201, '4066346214', 'Md', 'Rahat', 'rahat@gmail.com', '01741214453', NULL, NULL, NULL, '1990-11-07', NULL, NULL, NULL, NULL, 1, 'Rahat Lead', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL),
(213, '3092288972', 'sefsef', 'sgfv', NULL, '543544353', '435716252_1489407025314087_3950906095775722499_n_1725360976.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'Business Man', NULL, 'gplex.com', 'Daud Ibrahim', 'GMG', NULL, 'Social media', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-03 00:58:52', '2024-09-03 04:56:16'),
(214, '3092288972', 'fvdvg', 'dv dfvdv d', NULL, '(123) 456-7890', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-04 23:16:52', '2024-09-04 23:16:52'),
(215, '3092288972', 'trryr', 'rtgrr', NULL, '+1 123 456 7890', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'Social media', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-09-04 23:33:28', '2024-09-04 23:35:54');

-- --------------------------------------------------------

--
-- Table structure for table `leads_custom_data`
--

DROP TABLE IF EXISTS `leads_custom_data`;
CREATE TABLE IF NOT EXISTS `leads_custom_data` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `custom_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `lead_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `leads_custom_data_lead_id_foreign` (`lead_id`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `leads_form`
--

DROP TABLE IF EXISTS `leads_form`;
CREATE TABLE IF NOT EXISTS `leads_form` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `form_status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leads_form`
--

INSERT INTO `leads_form` (`id`, `form_id`, `parent_id`, `form_name`, `form_description`, `form_status`, `created_at`, `updated_at`) VALUES
(10, '3092288972', NULL, 'Basic Survey Form', 'Basic Survey Form is main survey form e', 1, '2024-05-28 11:23:23', '2024-07-02 18:56:59'),
(11, '9426101292', '3092288972', 'Sub Survey Data', 'Sub Survey form parent is Basic survey form', 1, '2024-05-28 11:24:16', '2024-05-28 11:24:16'),
(13, '4066346214', NULL, 'demo form', 'demo form', 1, '2024-06-09 12:40:51', '2024-06-09 12:40:51'),
(14, '1238362011', NULL, 'Car Business', 'This data will hold car data', 1, '2024-07-31 15:44:23', '2024-07-31 15:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `leads_form_json`
--

DROP TABLE IF EXISTS `leads_form_json`;
CREATE TABLE IF NOT EXISTS `leads_form_json` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `form_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `form_status` tinyint NOT NULL,
  `custom_form_fields` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `leads_form_json`
--

INSERT INTO `leads_form_json` (`id`, `form_id`, `form_name`, `form_description`, `form_status`, `custom_form_fields`, `created_at`, `updated_at`) VALUES
(1, '2', 'Customer Data', '', 0, '{\"key1\": \"value1\", \"key2\": \"value2\"}', '2024-04-29 02:31:45', '2024-04-29 02:31:48');

-- --------------------------------------------------------

--
-- Table structure for table `lead_form_details`
--

DROP TABLE IF EXISTS `lead_form_details`;
CREATE TABLE IF NOT EXISTS `lead_form_details` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `character_length` int DEFAULT NULL,
  `is_index` tinyint DEFAULT NULL,
  `is_null` tinyint DEFAULT NULL,
  `is_unique` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_survey_child`
--

DROP TABLE IF EXISTS `lead_survey_child`;
CREATE TABLE IF NOT EXISTS `lead_survey_child` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `parent_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_age` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_education` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_habit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_food_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `national_birth_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_survey_child`
--

INSERT INTO `lead_survey_child` (`id`, `form_id`, `lead_id`, `parent_id`, `child_name`, `child_age`, `child_education`, `child_habit`, `child_food_details`, `blood_group`, `date_of_birth`, `national_birth_id`, `created_at`, `updated_at`) VALUES
(1, '885013', 1, '885012', 'Raseduzzaman', '5', 'class 1', '3 meals and 2 to 3 snacks each day', 'dairy, eggs, meat, fish and poultry', 'AB+', '2019-03-01', '2132223232424242', NULL, NULL),
(2, '885013', 1, '885012', 'Khairul Hasan', '7', 'class 2', '3 meals and 2 to 3 snacks each day', 'dairy, eggs, meat, fish and poultry', 'B+', '2018-03-01', '2132223232424241', NULL, NULL),
(3, '885013', 2, '885012', 'Amanuzzaman', '8', 'class 3', '3 meals and 2 to 3 snacks each day', 'dairy, eggs, meat, fish and poultry', 'B-', '2017-03-01', '2132223232424245', NULL, NULL),
(4, '885013', 1, '885012', 'Azaduzzaman', '10', 'class 4', '3 meals and 2 to 3 snacks each day', 'oily, fish, nuts', 'B-', '2016-03-01', '2132223232424246', NULL, NULL),
(5, '885013', 1, '885012', 'Sayed Khan', '11', 'class 5', '3 meals and 2 to 3 snacks each day', 'Vegetables,Grains,Dairy', 'AB-', '2015-03-01', '2132223232424247', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lead_survey_people`
--

DROP TABLE IF EXISTS `lead_survey_people`;
CREATE TABLE IF NOT EXISTS `lead_survey_people` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lead_id` bigint UNSIGNED NOT NULL,
  `profession` char(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_child` char(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permanent_address` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `spouse_name` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `spouse_profession` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hobby` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `monthly_income` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `parents_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `other_member_details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lead_survey_people`
--

INSERT INTO `lead_survey_people` (`id`, `form_id`, `lead_id`, `profession`, `number_of_child`, `permanent_address`, `spouse_name`, `spouse_profession`, `hobby`, `monthly_income`, `child_details`, `parents_details`, `other_member_details`, `updated_at`, `created_at`) VALUES
(1, '885012', 1, 'Engineer', '3', '444/5,senpara,Mirpur-10', 'Rahima Begum', 'Teacher', 'Gardening', '45000', '3 Children', NULL, NULL, NULL, NULL),
(2, '885012', 1, 'Teacher', '2', '444/5,senpara,Mirpur-10', 'Romesha Khatun', 'Teacher', 'Teaching', '', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `module` varchar(180) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sub_module` varchar(180) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `log_message` varchar(500) COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sub_name` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_in_menu` tinyint(1) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `parent_id`, `name`, `sub_name`, `show_in_menu`, `status`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Agents', '', 1, 1, '2024-05-21 19:24:20', NULL),
(2, NULL, 'Leads Form', '', 1, 1, '2024-05-21 19:24:20', NULL),
(3, NULL, 'Contractors', '', 1, 1, '2024-05-21 19:24:44', NULL),
(4, NULL, 'Campaign', '', 1, 1, '2024-05-21 19:24:44', NULL),
(5, NULL, 'Email Module', '', 1, 1, '2024-05-21 19:25:33', NULL),
(6, NULL, 'SMS Module', '', 1, 1, '2024-05-21 19:25:33', NULL),
(7, 1, 'Agent List', 'agents-index', 1, 1, '2024-05-30 22:20:20', '2024-07-16 11:34:39'),
(8, 1, 'Create Agent', 'agents-create', 1, 1, '2024-05-30 22:21:34', NULL),
(9, 2, 'Form List', 'leadsform-index', 1, 1, '2024-06-02 17:15:59', NULL),
(10, 2, 'Create Form', 'leadsform-create', 1, 1, '2024-06-02 17:17:55', NULL),
(11, 2, 'Create Dynamic Tables', 'dynamictable-create', 1, 1, '2024-06-02 17:18:13', NULL),
(12, 2, 'Dynamic Tables List', 'dynamictable-index', 1, 1, '2024-06-02 17:18:17', NULL),
(13, 3, 'Contractor List', 'lead-index', 1, 1, '2024-06-02 17:19:20', '2024-09-12 03:12:01'),
(14, 3, 'Create a Contractor', 'lead-create', 1, 1, '2024-06-02 17:19:59', '2024-09-12 03:33:20'),
(15, 4, 'Campaign List', 'campaign-index', 1, 1, '2024-06-02 17:22:56', '2024-06-12 10:28:48'),
(16, 4, 'Create a Campaign', 'campaign-create', 1, 1, '2024-06-02 17:23:07', '2024-06-12 10:29:55'),
(17, 4, 'Promotion List', 'promotion-index', 0, 1, '2024-06-02 17:23:26', '2024-07-28 11:48:25'),
(18, 4, 'Create Promotion', 'promotion-create', 1, 1, '2024-06-02 17:23:27', NULL),
(19, 5, 'Send an Email', 'send-email', 1, 1, '2024-06-02 17:34:05', NULL),
(20, 5, 'Emails', 'send-email-list', 0, 0, '2024-06-02 17:40:06', '2024-06-06 17:39:31'),
(21, 5, 'Email Templates', 'email-template', 1, 1, '2024-06-02 17:41:38', NULL),
(22, 5, 'Create Template', 'email-template-create', 1, 1, '2024-06-02 17:41:59', '2024-06-06 17:39:55'),
(23, 6, 'SMS List', 'send-sms-list', 0, 0, '2024-06-02 17:42:59', NULL),
(24, 6, 'Send SMS', 'send-sms', 0, 0, '2024-06-02 17:43:26', NULL),
(25, 6, 'SMS Templates', 'sms-template', 0, 0, '2024-06-02 17:44:29', NULL),
(26, 6, 'Create Template', 'sms-template-create', 0, 0, '2024-06-02 17:44:51', NULL),
(28, 6, 'Send Bulk SMS', 'send-bulk-sms', 1, 1, '2024-06-06 17:22:37', '2024-06-06 17:22:37'),
(31, NULL, 'Tasks', 'tasks', 1, 1, '2024-09-12 03:06:31', '2024-09-12 03:06:31'),
(32, 31, 'Task List', 'task-list', 1, 1, '2024-09-12 03:07:08', '2024-09-12 03:07:08'),
(33, 31, 'Add Task', 'add-task', 1, 1, '2024-09-12 03:07:22', '2024-09-12 03:07:22'),
(34, 1, 'Agent Store', 'agents-store', 0, 1, '2024-09-15 03:09:22', '2024-09-15 03:09:22'),
(35, 1, 'Agent Show', 'agents-show', 0, 1, '2024-09-15 03:09:52', '2024-09-15 05:01:47'),
(36, 1, 'Agent Edit', 'agents-edit', 0, 1, '2024-09-15 03:10:13', '2024-09-15 03:10:13'),
(37, 1, 'Agent Update', 'agents-update', 0, 1, '2024-09-15 03:10:30', '2024-09-15 03:10:30'),
(38, 1, 'Agent Search', 'agents-search', 0, 1, '2024-09-15 03:10:55', '2024-09-15 03:10:55'),
(39, 1, 'Agent Delete', 'agents-destroy', 0, 1, '2024-09-15 03:11:19', '2024-09-15 03:11:19'),
(41, NULL, 'Proposal', NULL, 1, 1, '2024-09-26 04:01:28', '2024-09-26 04:01:28'),
(42, 41, 'Proposal List', 'proposal-list', 1, 1, '2024-09-26 04:02:09', '2024-09-26 04:02:09'),
(43, 41, 'Send a Proposal', 'add-proposal', 1, 1, '2024-09-26 04:03:27', '2024-09-26 04:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_11_19_033501_create_sessions_table', 1),
(6, '2023_11_19_051107_create_products_table', 1),
(7, '2023_12_21_061156_create_salesman_table;', 1),
(8, '2024_01_03_072535_create_country_table', 1),
(9, '2024_01_03_072636_create_state_table', 1),
(10, '2024_01_03_085517_create_branches_table', 1),
(11, '2024_01_03_085813_create_city_table', 1),
(12, '2024_01_23_105143_create_sms_templates_table', 1),
(13, '2024_01_23_122842_create_email_templates_table', 1),
(14, '2024_01_29_100457_create_table_sms_queue_table', 1),
(15, '2024_01_29_100510_create_table_sms_log_table', 1),
(16, '2024_02_01_035044_add_additional_fields_to_users_table', 1),
(17, '2024_02_07_074144_create_email_queue_table', 2),
(18, '2024_02_07_074625_create_email_log_table', 3),
(19, '2024_04_24_090556_create_leads_table', 4),
(22, '2024_04_25_110936_create_promotions_table', 5),
(23, '2024_04_25_111147_create_campaigns_table', 6),
(24, '2024_04_28_095043_create_leads_forms_table', 7),
(25, '2024_04_28_103607_create_lead_form_details_table', 8),
(26, '2024_04_28_121706_create_leads_table', 9),
(27, '2024_04_28_124539_create_leads_custom_data_table', 10),
(28, '2024_04_28_125650_create_leads_form_json_table', 11),
(29, '2024_04_29_034649_create_lead_survey_people_table', 12),
(30, '2024_04_29_035234_create_lead_survey_child_table', 13),
(31, '2024_04_30_044646_create_users_table', 14),
(32, '2024_04_30_050803_create_leads_form_table', 15),
(33, '2024_04_30_053636_create_lead_form_details_table', 16),
(34, '2024_04_30_074713_create_permission_groups_table', 17),
(35, '2024_04_30_073603_create_permissions_table', 18),
(36, '2024_04_30_092116_create_roles_table', 19),
(37, '2024_04_30_101349_create_roles_table', 20),
(38, '2024_04_30_101511_create_permissions_table', 21),
(39, '2024_04_30_102006_create_roles_permissions_table', 22),
(40, '2024_05_13_092102_create_agents_table', 23),
(41, '2024_05_13_095540_create_agents_table', 24),
(42, '2024_05_13_130323_create_agents_table', 25),
(43, '2024_05_13_131409_create_agents_table', 26),
(44, '2024_05_15_092501_create_users_table', 27),
(45, '2024_05_15_095923_create_agents_table', 28),
(46, '2024_05_16_085211_create_users_table', 29),
(47, '2024_05_16_085710_create_agents_table', 30),
(48, '2024_05_20_041755_create_users_table', 31),
(49, '2024_05_20_042013_create_agents_table', 32),
(50, '2024_05_28_034337_create_lead_form_details_table', 33),
(51, '2024_05_28_034612_create_lead_form_details_table', 34);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `permission_group_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permissions_permission_group_id_foreign` (`permission_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

DROP TABLE IF EXISTS `permission_groups`;
CREATE TABLE IF NOT EXISTS `permission_groups` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'gpleCRMToken', '0970f2e9be65303bee4b46dd2c7cf229d55ec3a94520768872b4fab7196431a9', '[\"*\"]', NULL, NULL, '2024-04-30 16:39:52', '2024-04-30 16:39:52'),
(2, 'App\\Models\\User', 1, 'gpleCRMToken', '3d2c3352dd17459faac06bf4f2a2f7352dca86f488321ddaa0a3e5627e64f44a', '[\"*\"]', NULL, NULL, '2024-05-05 12:55:07', '2024-05-05 12:55:07'),
(3, 'App\\Models\\User', 1, 'gpleCRMToken', 'a0c7fbeb9117eb8a2cd220b47e0381b035218a70fb95615f1a17c88d0891510f', '[\"*\"]', '2024-05-05 13:32:16', NULL, '2024-05-05 12:56:06', '2024-05-05 13:32:16'),
(4, 'App\\Models\\User', 1, 'gpleCRMToken', '2858a3a1658d14c48d2b22e9737ece0c79a33dbd83fbdb008950f3c88f4ae3fe', '[\"*\"]', '2024-05-05 13:31:57', NULL, '2024-05-05 13:30:34', '2024-05-05 13:31:57'),
(5, 'App\\Models\\User', 1, 'gpleCRMToken', '6834f92012607dce3757beb3b051fa7ca816ed66697533035e16374b9c9b8a2b', '[\"*\"]', '2024-05-07 19:48:27', NULL, '2024-05-05 14:25:59', '2024-05-07 19:48:27'),
(6, 'App\\Models\\User', 1, 'gpleCRMToken', 'c7e87624bf37316db967aa11e69d29ce25986a898828d8faa7eba29d5a7098ea', '[\"*\"]', '2024-05-07 19:47:52', NULL, '2024-05-05 15:58:12', '2024-05-07 19:47:52'),
(7, 'App\\Models\\User', 1, 'gpleCRMToken', '068b7d9dcfdb1998324d54275c37856078ae44277a5afa73167c97166523d052', '[\"*\"]', '2024-05-05 16:53:54', NULL, '2024-05-05 16:38:15', '2024-05-05 16:53:54'),
(8, 'App\\Models\\User', 1, 'gpleCRMToken', '474a0f9194148a5ea7b78e5bca25ba2b66371ebdb41ce38c1dc2fe813e164d90', '[\"*\"]', NULL, NULL, '2024-05-05 16:40:34', '2024-05-05 16:40:34'),
(9, 'App\\Models\\User', 1, 'gpleCRMToken', 'e8de52ea86403848356bf96d04232ede81bbbe05b0498cf95bf27b2261836c99', '[\"*\"]', '2024-05-07 19:48:24', NULL, '2024-05-05 16:40:58', '2024-05-07 19:48:24'),
(10, 'App\\Models\\User', 4, 'gpleCRMToken', '70a6abf5b1b961e39cb3bd6f78bbb5b45d4cd876ab50987da5839dd174293e7d', '[\"*\"]', NULL, NULL, '2024-05-13 19:20:17', '2024-05-13 19:20:17'),
(11, 'App\\Models\\User', 2, 'gpleCRMToken', '860eca8582c2c8f2713aca3eed8704c90572d2ca9106d105921c062dee8a89d3', '[\"*\"]', NULL, NULL, '2024-05-15 17:44:35', '2024-05-15 17:44:35'),
(12, 'App\\Models\\User', 1, 'gpleCRMToken', 'e7afa19f6d684a2fee3b5d82d52b7263ab841717e950174af3798747a4c73253', '[\"*\"]', NULL, NULL, '2024-05-16 16:17:59', '2024-05-16 16:17:59'),
(13, 'App\\Models\\User', 1, 'gpleCRMToken', 'c64612dccc667876dcf0137036d1e5ca032f82ac9369207de24b21ff022c258d', '[\"*\"]', NULL, NULL, '2024-05-20 11:24:44', '2024-05-20 11:24:44');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `product_type` tinyint(1) NOT NULL,
  `product_cost` decimal(8,2) DEFAULT NULL,
  `product_value` decimal(8,2) DEFAULT NULL,
  `product_code` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `img_path` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `invoice_amount` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `product_type`, `product_cost`, `product_value`, `product_code`, `img_path`, `status`, `created_at`, `updated_at`, `invoice_amount`) VALUES
(1, 'Call Center', 'demo', 1, 0.00, 0.00, NULL, NULL, 0, '2024-08-01 07:14:32', '2024-08-01 07:14:37', NULL),
(2, 'Email Bluster', 'Email bluster project', 1, 0.00, 0.00, NULL, NULL, 0, '2024-08-01 07:14:41', '2024-08-01 07:14:44', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

DROP TABLE IF EXISTS `promotions`;
CREATE TABLE IF NOT EXISTS `promotions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `promotion_title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_location` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `promo_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `promotion_title`, `description`, `file_location`, `start_date`, `end_date`, `promo_type`, `status`, `created_at`, `updated_at`) VALUES
(44, 'Web Development', NULL, '', NULL, NULL, NULL, 1, '2024-05-27 14:40:04', '2024-05-27 14:40:04'),
(45, 'Android', NULL, '', NULL, NULL, NULL, 1, '2024-05-27 14:40:13', '2024-05-27 14:40:13'),
(48, 'demo edit', NULL, 'sample-file_1719915611.csv', '2024-07-01', '2024-07-03', 'adsss', 1, '2024-07-02 17:18:20', '2024-07-03 10:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `proposals`
--

DROP TABLE IF EXISTS `proposals`;
CREATE TABLE IF NOT EXISTS `proposals` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `lead_id` bigint DEFAULT NULL,
  `company_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `customer_id` bigint DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `currency` char(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `assigned_agent_id` int DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send_to` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `city` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country_name` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `proposal_file_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `item_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `item_description` text COLLATE utf8mb4_general_ci,
  `zip_code` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `send_to_email` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount` decimal(10,2) DEFAULT NULL,
  `tax_percent` decimal(3,1) DEFAULT NULL,
  `tax_amount` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `offer_price` decimal(10,2) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` char(15) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `proposal_products`
--

DROP TABLE IF EXISTS `proposal_products`;
CREATE TABLE IF NOT EXISTS `proposal_products` (
  `id` bigint NOT NULL,
  `proposal_id` bigint NOT NULL,
  `product_id` bigint NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `total_price` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_details` longtext COLLATE utf8mb4_unicode_ci,
  `permission_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `permission_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` tinyint NOT NULL COMMENT '0 => Inactive, 1 => Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `menu_details`, `permission_details`, `permission_ids`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', NULL, '[]', '[]', 1, '2024-01-11 08:27:56', '2024-07-16 11:34:12'),
(2, 'Saless Agent', 'saless_agent', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\"},\"Leads_Form\":{\"leadsform-index\":\"Form List\"},\"Contractors\":{\"lead-index\":\"Contractor List\",\"lead-create\":\"Create a Contractor\"},\"Campaign\":{\"campaign-index\":\"Campaign List\",\"campaign-create\":\"Create a Campaign\",\"promotion-create\":\"Create Promotion\"}}', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\",\"agents-edit\":\"Agent Edit\",\"agents-search\":\"Agent Search\"},\"Leads_Form\":{\"leadsform-index\":\"Form List\"},\"Contractors\":{\"lead-index\":\"Contractor List\",\"lead-create\":\"Create a Contractor\"},\"Campaign\":{\"campaign-index\":\"Campaign List\",\"campaign-create\":\"Create a Campaign\",\"promotion-index\":\"Promotion List\",\"promotion-create\":\"Create Promotion\"}}', '{\"Agents\":[\"7\",\"8\",\"36\",\"38\"],\"Leads_Form\":[\"9\"],\"Contractors\":[\"13\",\"14\"],\"Campaign\":[\"15\",\"16\",\"17\",\"18\"]}', 1, '2024-01-11 11:26:06', '2024-09-15 04:43:33'),
(4, 'Supervisor Panel', 'supervisor-panel', NULL, NULL, NULL, 1, NULL, NULL),
(5, 'Super Admin', 'super_admin', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\"},\"Leads_Form\":{\"leadsform-index\":\"Form List\",\"leadsform-create\":\"Create Form\",\"dynamictable-create\":\"Create Dynamic Tables\",\"dynamictable-index\":\"Dynamic Tables List\"},\"Contractors\":{\"lead-index\":\"Contractor List\",\"lead-create\":\"Create a Contractor\"},\"Campaign\":{\"campaign-index\":\"Campaign List\",\"campaign-create\":\"Create a Campaign\",\"promotion-create\":\"Create Promotion\"},\"Email_Module\":{\"send-email\":\"Send an Email\",\"email-template\":\"Email Templates\",\"email-template-create\":\"Create Template\"},\"SMS_Module\":{\"send-bulk-sms\":\"Send Bulk SMS\"},\"Tasks\":{\"task-list\":\"Task List\",\"add-task\":\"Add Task\"},\"Proposal\":{\"proposal-list\":\"Proposal List\",\"add-proposal\":\"Send a Proposal\"}}', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\",\"agents-store\":\"Agent Store\",\"agents-show\":\"Agent Show\",\"agents-edit\":\"Agent Edit\",\"agents-update\":\"Agent Update\",\"agents-search\":\"Agent Search\",\"agents-destroy\":\"Agent Delete\"},\"Leads_Form\":{\"leadsform-index\":\"Form List\",\"leadsform-create\":\"Create Form\",\"dynamictable-create\":\"Create Dynamic Tables\",\"dynamictable-index\":\"Dynamic Tables List\"},\"Contractors\":{\"lead-index\":\"Contractor List\",\"lead-create\":\"Create a Contractor\"},\"Campaign\":{\"campaign-index\":\"Campaign List\",\"campaign-create\":\"Create a Campaign\",\"promotion-index\":\"Promotion List\",\"promotion-create\":\"Create Promotion\"},\"Email_Module\":{\"send-email\":\"Send an Email\",\"send-email-list\":\"Emails\",\"email-template\":\"Email Templates\",\"email-template-create\":\"Create Template\"},\"SMS_Module\":{\"send-sms-list\":\"SMS List\",\"send-sms\":\"Send SMS\",\"sms-template\":\"SMS Templates\",\"sms-template-create\":\"Create Template\",\"send-bulk-sms\":\"Send Bulk SMS\"},\"Tasks\":{\"task-list\":\"Task List\",\"add-task\":\"Add Task\"},\"Proposal\":{\"proposal-list\":\"Proposal List\",\"add-proposal\":\"Send a Proposal\"}}', '{\"Agents\":[\"7\",\"8\",\"34\",\"35\",\"36\",\"37\",\"38\",\"39\"],\"Leads_Form\":[\"9\",\"10\",\"11\",\"12\"],\"Contractors\":[\"13\",\"14\"],\"Campaign\":[\"15\",\"16\",\"17\",\"18\"],\"Email_Module\":[\"19\",\"20\",\"21\",\"22\"],\"SMS_Module\":[\"23\",\"24\",\"25\",\"26\",\"28\"],\"Tasks\":[\"32\",\"33\"],\"Proposal\":[\"42\",\"43\"]}', 1, '2024-06-02 11:47:22', '2024-09-26 04:03:51'),
(6, 'Agent Supervisor', 'agent_supervisor', NULL, '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\"},\"Leads_Form\":{\"leadsform-index\":\"Form List\",\"leadsform-create\":\"Create Form\",\"dynamictable-create\":\"Create Dynamic Tables\",\"dynamictable-index\":\"Dynamic Tables List\"},\"Lead_Management\":{\"lead-index\":\"Leads\",\"lead-create\":\"Create a Lead\"},\"Campaign\":{\"campaign-index\":\"Campaign List\",\"campaign-create\":\"Create a Campaign\",\"promotion-index\":\"Promotion List\",\"promotion-create\":\"Create Promotion\"},\"Email_Module\":{\"send-email\":\"Send an Email\",\"send-email-list\":\"Emails\",\"email-template\":\"Email Templates\",\"email-template-create\":\"Create Template\"},\"SMS_Module\":{\"send-sms-list\":\"SMS List\",\"send-sms\":\"Send SMS\",\"sms-template\":\"SMS Templates\",\"sms-template-create\":\"Create Template\",\"send-bulk-sms\":\"Send Bulk SMS\"}}', '{\"Agents\":[\"7\",\"8\"],\"Leads_Form\":[\"9\",\"10\",\"11\",\"12\"],\"Lead_Management\":[\"13\",\"14\"],\"Campaign\":[\"15\",\"16\",\"17\",\"18\"],\"Email_Module\":[\"19\",\"20\",\"21\",\"22\"],\"SMS_Module\":[\"23\",\"24\",\"25\",\"26\",\"28\"]}', 1, '2024-06-02 12:46:55', '2024-06-12 10:32:21'),
(12, 'Primary Agents', 'primary_agents', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\"},\"Tasks\":{\"task-list\":\"Task List\",\"add-task\":\"Add Task\"}}', '{\"Agents\":{\"agents-index\":\"Agent List\",\"agents-create\":\"Create Agent\",\"agents-store\":\"Agent Store\",\"agents-show\":\"Agent Show\",\"agents-search\":\"Agent Search\"},\"SMS_Module\":{\"send-sms-list\":\"SMS List\",\"send-sms\":\"Send SMS\"},\"Tasks\":{\"task-list\":\"Task List\",\"add-task\":\"Add Task\"}}', '{\"Agents\":[\"7\",\"8\",\"34\",\"35\",\"38\"],\"SMS_Module\":[\"23\",\"24\"],\"Tasks\":[\"32\",\"33\"]}', 1, '2024-09-15 05:44:23', '2024-09-15 05:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

DROP TABLE IF EXISTS `roles_permissions`;
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `role_id` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_id` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `roles_permissions_permission_id_foreign` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

DROP TABLE IF EXISTS `salesman`;
CREATE TABLE IF NOT EXISTS `salesman` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_log`
--

DROP TABLE IF EXISTS `sms_log`;
CREATE TABLE IF NOT EXISTS `sms_log` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_from` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_to` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_time` datetime DEFAULT NULL,
  `delivery_time` datetime DEFAULT NULL,
  `send_status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_queue`
--

DROP TABLE IF EXISTS `sms_queue`;
CREATE TABLE IF NOT EXISTS `sms_queue` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `campaign_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` bigint DEFAULT NULL,
  `sms_from` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_to` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sms_text` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `send_status` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `csv_id` char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority_level` tinyint DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `schedule_time` datetime DEFAULT NULL,
  `retry_status` tinyint DEFAULT NULL,
  `delete_request` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_templates`
--

DROP TABLE IF EXISTS `sms_templates`;
CREATE TABLE IF NOT EXISTS `sms_templates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sms_templates`
--

INSERT INTO `sms_templates` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'demo 12', 'demodsss ss ssssssss sssssssssssssssssssssssss sssssssssssssssssssss ssssssssssssssssssssssssssssssss', 1, '2024-06-23 19:03:05', '2024-07-03 18:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `country_id` int NOT NULL,
  `state_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `task_name` char(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `due_date` datetime NOT NULL,
  `assigned_to` bigint NOT NULL,
  `created_by` bigint NOT NULL,
  `status` tinyint DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `description`, `due_date`, `assigned_to`, `created_by`, `status`, `created_at`, `updated_at`) VALUES
(4, 'This is my task', 'This is a description', '2024-09-25 00:00:00', 4, 1, 1, '2024-09-11 00:42:18', '2024-09-11 00:42:35'),
(5, 'My task', 'This is a new task', '2024-09-16 00:00:00', 7, 7, 2, '2024-09-11 01:09:01', '2024-09-11 01:10:16'),
(6, 'fgvbfdvbdf', 'dfv dfvdfvd', '2024-09-11 07:15:52', 7, 1, 1, NULL, NULL),
(7, 'sdfvs', 'dfvsdfvdsv', '2024-09-11 07:15:52', 2, 1, 1, NULL, NULL),
(8, 'Find a shape', NULL, '2024-09-17 00:00:00', 8, 8, 1, '2024-09-15 05:47:37', '2024-09-15 05:47:37'),
(9, 'bhfg', 'fghdbhd', '2024-09-18 00:00:00', 8, 8, 2, '2024-09-15 05:57:39', '2024-09-15 05:57:46'),
(10, 'dsfds', 'dfvdsv', '2024-09-10 00:00:00', 8, 8, 0, '2024-09-18 05:33:39', '2024-09-18 05:33:39'),
(11, 'erfgvrfvvdsvsd', 'vf svsdds sdsdf df dfvsdf sds', '2024-09-26 00:00:00', 8, 8, 0, '2024-09-18 05:33:53', '2024-09-18 05:33:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` char(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `role_id` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `username`, `first_name`, `last_name`, `email`, `phone_number`, `user_type`, `gender`, `profile_image`, `address`, `role_id`, `email_verified_at`, `password`, `remember_token`, `status`, `created_at`, `updated_at`) VALUES
(1, '6798657284978', 'root', 'Momin', 'Riyads', 'momin@gmail.com', '01731415537', 'admin', NULL, '150-26_1719113695.jpg', '443/5,senpara edit final', '5', NULL, '$2y$12$JRvyCWa35X6er4gfDJcYbOTj1X.HlQa2xeYUnd7sZyNA2OR4Xpgye', NULL, '1', '2024-05-20 11:24:44', '2024-07-18 11:27:14'),
(2, '6798657284999', 'hasan', 'Md', 'Rokibuzzaman', 'rokib@gmail.com', '01731214425', 'agent', NULL, 'mypic_recent_1718885568.jpg', 'Mirpur', '6', NULL, '$2y$12$efRMYUX2gcD5s65PgOsz4uDVlukLV/021ljRk3KbP/Cpx4Z1GJjam', NULL, '1', '2024-05-20 11:26:27', '2024-09-12 00:52:30'),
(4, '7620974445398', '9271', 'jaman', 'hasans', 'jaman@gmail.com', '01731214425', 'agent', NULL, '', 'dfdfd', NULL, NULL, '$2y$12$CoS4dSJLFC1OjWLJVH9yKO9xaDlOGzOzVx63ETWaAIpFbfEIdIrLW', NULL, '1', '2024-05-27 12:59:32', '2024-07-04 13:26:37'),
(6, '1634034265973', '2125', 'Alamin', 'Khan', 'alamin@gmail.com', '01731214425', 'agent', 'Female', 'image_profile_1717312650.png', '441/5,senpara', NULL, NULL, '$2y$12$OuJNqIdHRS7DT6cfIhuEWOU2u1j/TC/NmieLMYIVplrxTQ3qYnTXK', NULL, '1', '2024-06-02 14:17:30', '2024-08-21 22:14:56'),
(7, '2691710845749', '1979', 'Ali', 'Hossian', 'ali@gmail.com', '01919102030', 'agent', 'Male', '', NULL, '2', NULL, '$2y$12$4mn6qyOhpAuV46gOO4VjZuK2zvIUgWmyOyBGIoV6lypN1vfN4Gz22', NULL, '1', '2024-09-11 01:08:09', '2024-09-12 04:49:25'),
(8, '6487901907748', '1600', 'Agent', 'New', 'new@gmail.com', NULL, 'agent', NULL, '', NULL, '12', NULL, '$2y$12$acw1ZhoYwqemn6GyPUC0x.XAFv5s0zLUDT3MaPumPrKFjxYBPW0C2', NULL, '1', '2024-09-15 04:07:26', '2024-09-15 05:47:01');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `user_id` char(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agents`
--
ALTER TABLE `agents`
  ADD CONSTRAINT `agents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `campaigns`
--
ALTER TABLE `campaigns`
  ADD CONSTRAINT `campaigns_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `leads_custom_data`
--
ALTER TABLE `leads_custom_data`
  ADD CONSTRAINT `leads_custom_data_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
