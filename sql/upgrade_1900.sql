-- /*******************************************************
-- *
-- * civicrm_trialadmin_log
-- *
-- * Log file for changes to the Trial Application
-- *
-- *******************************************************/
CREATE TABLE IF NOT EXISTS `civicrm_trialadmin_log` (
  `id` int unsigned auto_increment NOT NULL AUTO_INCREMENT COMMENT 'Unique TrialadminLog ID',
  `trial_id` int unsigned NOT NULL COMMENT 'FK to Trialadmin',
  `entity_id` int unsigned NULL COMMENT 'ID of posting entity',
  `entity` varchar(64) NULL COMMENT 'Posting Entity',
  `data` text NOT NULL COMMENT 'Logged data',
  `modified_id` int unsigned NOT NULL COMMENT 'ID of modifier',
  `modified_date` datetime NULL ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date time stamp of Entry',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_trialadmin_log_trial_id FOREIGN KEY (`trial_id`) REFERENCES `civicrm_trial_admin`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trialadmin_log_modified_id FOREIGN KEY (`modified_id`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;