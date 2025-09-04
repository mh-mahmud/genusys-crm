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


CREATE TABLE `crm_insurance`.`lead_result_code` (`id` BIGINT NOT NULL AUTO_INCREMENT , `lead_id` BIGINT NOT NULL , `result_codes_id` INT NOT NULL , `lead_note` TEXT NULL , `created_by` BIGINT NOT NULL , `created_at` TIMESTAMP NOT NULL , `updted_by` TIMESTAMP NULL , `updated_at` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;



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


-- insert new table
CREATE TABLE IF NOT EXISTS `lead_result_code` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `lead_id` bigint NOT NULL,
  `result_codes_id` int NOT NULL,
  `lead_notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` bigint NOT NULL,
  `created_at` timestamp NOT NULL,
  `updted_by` int DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `lead_result_code` (`id`, `lead_id`, `result_codes_id`, `lead_notes`, `created_by`, `created_at`, `updted_by`, `updated_at`) VALUES
(1, 18, 2, 'dsfgvdre rgh erhe 5hth te\r\ne gerer et ergergert erer er\r\n errgre er erwre\r\n  ge rgreereger g', 1, '2025-08-14 09:20:24', NULL, '2025-08-14 09:20:24');


ALTER TABLE `lead_result_code` CHANGE `result_codes_id` `result_codes_id` INT NULL DEFAULT NULL;
ALTER TABLE `lead_result_code` CHANGE `created_by` `created_by` INT NULL DEFAULT NULL;


-- 18th Aug 2025
ALTER TABLE `leads` ADD `updated_by` INT NULL DEFAULT NULL AFTER `created_by`;




--18th aug 2025
ALTER TABLE `result_action`
ADD `created_by` INT(11) NOT NULL AFTER `status`;

ALTER TABLE `result_action`
ADD `updated_by` INT(11) NOT NULL AFTER `created_by`;


-- cycle table
CREATE TABLE IF NOT EXISTS `lead_cycle` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `priority` tinyint DEFAULT NULL,
  `no_of_attempt` tinyint DEFAULT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cycle_time` datetime DEFAULT NULL,
  `status` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



-- Result Action Table 24-08-2025
CREATE TABLE `result_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rule_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rule_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rule_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `distribution_priority` tinyint(4) DEFAULT NULL,
  `after_1st_park_priority` tinyint(4) DEFAULT NULL,
  `after_2nd_park_priority` tinyint(4) DEFAULT NULL,
  `distribution_time` int(11) DEFAULT NULL,
  `after_1st_park_time` int(11) DEFAULT NULL,
  `after_2nd_park_time` int(11) DEFAULT NULL,
  `attempts_general` int(11) DEFAULT NULL,
  `after_1st_park_priority_general` int(11) DEFAULT NULL,
  `after_2nd_park_priority_general` int(11) DEFAULT NULL,
  `apply_condition` tinyint(1) DEFAULT 0,
  `rule_based` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `num_attempts` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `callback` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dead` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lead_status_id` int(11) DEFAULT NULL,
  `next_dist` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `result_code` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `park_cycle_before_dead` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci



ALTER TABLE `result_action` CHANGE `result_code` `result_code` INT(11) NULL;

-- 25-08-2025
ALTER TABLE `lead_result_code` CHANGE `result_codes_id` `result_codes_id` VARCHAR(255) NULL DEFAULT NULL; 

-- 31-08-2025
ALTER TABLE `lead_cycle` CHANGE `status` `status` TINYINT NULL DEFAULT '1' COMMENT '1=active,0=pending,2=done,3=failed distribution, 4=disabled';

CREATE TABLE IF NOT EXISTS `schedule_call` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lead_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `call_note` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;