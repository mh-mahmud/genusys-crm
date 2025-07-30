-- 27-06-2025, Ishtiak add
CREATE TABLE `gplex_crm`.`form_features` (`id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `route` VARCHAR(180) NOT NULL , `created_by` BIGINT NOT NULL , `created_at` TIMESTAMP NOT NULL , `updated_by` BIGINT NULL , `updated_at` TIMESTAMP NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `form_features` ADD `status` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '1 = active, 0 = Inactive' AFTER `route`;

-- 30-07-2025
ALTER TABLE `leads` CHANGE `lead_status` `lead_status` VARCHAR(50) NULL DEFAULT NULL;