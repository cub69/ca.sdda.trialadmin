-- +--------------------------------------------------------------------+
-- | Copyright CiviCRM LLC. All rights reserved.                        |
-- |                                                                    |
-- | This work is published under the GNU AGPLv3 license with some      |
-- | permitted exceptions and without any warranty. For full license    |
-- | and copyright information, see https://civicrm.org/licensing       |
-- +--------------------------------------------------------------------+
--
-- Generated from schema.tpl
-- DO NOT EDIT.  Generated by CRM_Core_CodeGen
--
-- /*******************************************************
-- *
-- * Clean up the existing tables - this section generated from drop.tpl
-- *
-- *******************************************************/

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `civicrm_trialadmin_log`;
DROP TABLE IF EXISTS `civicrm_trial_components`;
DROP TABLE IF EXISTS `civicrm_trial_admin`;

SET FOREIGN_KEY_CHECKS=1;
-- /*******************************************************
-- *
-- * Create new tables
-- *
-- *******************************************************/

-- /*******************************************************
-- *
-- * civicrm_trial_admin
-- *
-- * Trial Details provided by Hosts
-- *
-- *******************************************************/
CREATE TABLE `civicrm_trial_admin` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique TrialAdmin ID',
  `approved` tinyint NOT NULL COMMENT 'If Trial Approved',
  `event_id` int unsigned COMMENT 'FK to Event',
  `Requester` int unsigned COMMENT 'FK to Contact',
  `hosting_club` text COMMENT 'Club hosting trial',
  `Requester_RP` int COMMENT 'Requester RP Number',
  `Requester_Name` text COMMENT 'Requester Name',
  `Requester_lastname` text COMMENT 'Requester last name',
  `Requester_email` text COMMENT 'Requester email address',
  `Location_name` text COMMENT 'Name of Trial Location',
  `Street_address` text COMMENT 'Location Street Address',
  `Location_city` text COMMENT 'Location City',
  `Location_province` text COMMENT 'Location Province',
  `Location_country` text COMMENT 'Location Country',
  `trial_chairperson` int unsigned COMMENT 'Trial Charperson',
  `trial_secretary` int unsigned COMMENT 'Trial Secretary',
  `venue_description` text COMMENT 'Venue Description',
  `space_for_containers` text COMMENT 'Space for Containers Description',
  `space_for_interior` text COMMENT 'Space for Interior Search Area Description',
  `space_for_exterior` text COMMENT 'Space for Exterior Search Area Description',
  `staging_and_crating` text COMMENT 'Space for Staging and Craiting Description',
  `space_for_secretary` text COMMENT 'Space for Secretary Description',
  `space_for_judge` text COMMENT 'Space for Judge Description',
  `confirm_square_footage` tinyint COMMENT 'Confirm appropriate square footage is available',
  `confirm_judge_contacted` tinyint COMMENT 'Confirm you have gone through the venue plans with your judge(s)',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_trial_admin_event_id FOREIGN KEY (`event_id`) REFERENCES `civicrm_event`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trial_admin_Requester FOREIGN KEY (`Requester`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trial_admin_trial_chairperson FOREIGN KEY (`trial_chairperson`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trial_admin_trial_secretary FOREIGN KEY (`trial_secretary`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;

-- /*******************************************************
-- *
-- * civicrm_trial_components
-- *
-- * FIXME
-- *
-- *******************************************************/
CREATE TABLE `civicrm_trial_components` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Unique TrialComponents ID',
  `ta_id` int unsigned COMMENT 'FK to TrialAdmin',
  `event_id` int unsigned COMMENT 'FK to Event',
  `trial_number` int unsigned COMMENT 'Trial Number',
  `trial_date` datetime COMMENT 'Date of this Trial Event',
  `judge` int unsigned COMMENT 'Judge',
  `started_components` text COMMENT 'Started components',
  `advanced_components` text COMMENT 'advanced components',
  `excellent_components` text COMMENT 'Excellent components',
  `elite_offered` tinyint COMMENT 'Started components',
  `games_components` text COMMENT 'Games components',
  PRIMARY KEY (`id`),
  CONSTRAINT FK_civicrm_trial_components_ta_id FOREIGN KEY (`ta_id`) REFERENCES `civicrm_trial_admin`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trial_components_event_id FOREIGN KEY (`event_id`) REFERENCES `civicrm_event`(`id`) ON DELETE CASCADE,
  CONSTRAINT FK_civicrm_trial_components_judge FOREIGN KEY (`judge`) REFERENCES `civicrm_contact`(`id`) ON DELETE CASCADE
)
ENGINE=InnoDB;

-- /*******************************************************
-- *
-- * civicrm_trialadmin_log
-- *
-- * Log file for changes to the Trial Application
-- *
-- *******************************************************/
CREATE TABLE `civicrm_trialadmin_log` (
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
