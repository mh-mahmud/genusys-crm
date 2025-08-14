-- 27-06-2025, Ishtiak add
CREATE TABLE `gplex_crm`.`form_features` (`id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `route` VARCHAR(180) NOT NULL , `created_by` BIGINT NOT NULL , `created_at` TIMESTAMP NOT NULL , `updated_by` BIGINT NULL , `updated_at` TIMESTAMP NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `form_features` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = Inactive' AFTER `route`;

-- 30-07-2025
ALTER TABLE `leads` CHANGE `lead_status` `lead_status` VARCHAR(50) NULL DEFAULT NULL;

-- 10-08-2025
ALTER TABLE `lead_form_details` ADD `form_serial` INT NULL DEFAULT NULL AFTER `form_size`;
ALTER TABLE `leads` ADD `home_phone` VARCHAR(50) NULL DEFAULT NULL AFTER `phone`, ADD `work_phone` VARCHAR(50) NULL DEFAULT NULL AFTER `home_phone`;
ALTER TABLE `leads` ADD `prior_address` TEXT NULL DEFAULT NULL AFTER `address`;
ALTER TABLE `leads` ADD `time_at_residence` VARCHAR(255) NULL DEFAULT NULL AFTER `work_phone`;
ALTER TABLE `leads` ADD `language` VARCHAR(50) NULL DEFAULT NULL AFTER `country`;

--12-Aug-2025, Ishtiak Add

ALTER TABLE `vehicle_attributes` ADD `vehicle_info_id` BIGINT(20) NULL AFTER `form_id`;
ALTER TABLE `driver_attributes` ADD `driver_info_id` BIGINT NULL AFTER `form_id`;

-- provided by Hasan
DROP TABLE IF EXISTS `rate_analysis_data`;
CREATE TABLE IF NOT EXISTS `rate_analysis_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int NOT NULL,
  `form_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `rate_analysis_data` longtext COLLATE utf8mb4_unicode_ci,
  `quote_data` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `leads` ADD `middlename` VARCHAR(100) NULL DEFAULT NULL AFTER `last_name`; 

-- 2025-08-14, Ishtiak
CREATE TABLE `result_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `result_group_id` int(11) DEFAULT NULL,
  `result_action_id` int(11) DEFAULT NULL,
  `lead_status_id` int(11) DEFAULT NULL,
  `comment_required` char(1) DEFAULT NULL COMMENT 'y = Yes, n = Not Required',
  `selectable` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `lead_status` (`id`, `status_name`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'Hot', '1', current_timestamp(), NULL), (NULL, 'Warm', '1', current_timestamp(), NULL);

INSERT INTO `lead_status` (`id`, `status_name`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'Sold', '1', current_timestamp(), NULL), (NULL, 'Dead', '1', current_timestamp(), NULL);

INSERT INTO `group_code` (`id`, `group_code`, `group_description`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'CP', 'Contact Positive', '1', current_timestamp(), NULL), (NULL, 'CN', 'Contact Negative', '1', current_timestamp(), NULL);

INSERT INTO `group_code` (`id`, `group_code`, `group_description`, `status`, `created_at`, `updated_at`) VALUES (NULL, 'NC', 'Not Contact', '1', current_timestamp(), NULL);


INSERT INTO `result_action` (`id`, `rule_code`, `rule_description`, `rule_based`, `num_attempts`, `callback`, `dead`, `lead_status_id`, `next_dist`, `result_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'CC', 'Close Contact', 'No', '0', 'No', 'Yes', 4, '0', NULL, 1, '2025-08-14 05:26:21', NULL),
(2, 'SC', 'Schedule a Callback', 'No', '1', 'Yes', 'Yes', 2, '1', NULL, 1, '2025-08-14 05:26:21', NULL),
(3, 'LV', 'Left Voice-Mail', 'Yes', '6', 'No', 'No', 2, '60', 'PARK', 1, '2025-08-14 05:30:10', NULL),
(4, 'NC4A', 'NC After 4 Attempts', 'Yes', '6', 'No', 'No', 2, '60', 'PARK', 1, '2025-08-14 05:30:10', NULL),
(5, 'PARK', 'Parked', 'No', '0', 'No', 'No', 2, '1440', NULL, 1, '2025-08-14 05:31:20', NULL);


-- 2025-08-13, Ishtiak
CREATE TABLE `crm_insurance`.`result_codes` (`id` INT NOT NULL AUTO_INCREMENT , `code` VARCHAR(10) NOT NULL , `title` VARCHAR(255) NOT NULL , `status` INT NOT NULL DEFAULT '1' , `created_at` TIMESTAMP NOT NULL , `created_by` BIGINT NOT NULL , `updated_at` TIMESTAMP NULL DEFAULT NULL , `updated_by` BIGINT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `vehicle_attributes` ADD `vehicle_info_id` BIGINT(20) NULL AFTER `form_id`;
ALTER TABLE `driver_attributes` ADD `driver_info_id` BIGINT NULL AFTER `form_id`;



-- 2025-08-14 ==================================
CREATE TABLE IF NOT EXISTS `lead_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `group_code` (
  `id` int NOT NULL AUTO_INCREMENT,
  `group_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `group_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `result_action` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rule_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rule_based` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_attempts` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `callback` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dead` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_status_id` int DEFAULT NULL,
  `next_dist` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `leads` ADD `assigned_to` INT NULL DEFAULT NULL AFTER `lead_notes`; 
