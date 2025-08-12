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