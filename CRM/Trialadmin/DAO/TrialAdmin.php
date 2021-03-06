<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from ca.sdda.trialadmin/xml/schema/CRM/Trialadmin/TrialAdmin.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:81fc6af8d50c8628090cc0c07571d78f)
 */
use CRM_Trialadmin_ExtensionUtil as E;

/**
 * Database access object for the TrialAdmin entity.
 */
class CRM_Trialadmin_DAO_TrialAdmin extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_trial_admin';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique TrialAdmin ID
   *
   * @var int
   */
  public $id;

  /**
   * If Trial Approved
   *
   * @var int
   */
  public $approved;

  /**
   * FK to Event
   *
   * @var int
   */
  public $event_id;

  /**
   * FK to Contact
   *
   * @var int
   */
  public $Requester;

  /**
   * Club hosting trial
   *
   * @var text
   */
  public $hosting_club;

  /**
   * Requester RP Number
   *
   * @var int
   */
  public $Requester_RP;

  /**
   * Requester Name
   *
   * @var text
   */
  public $Requester_Name;

  /**
   * Requester last name
   *
   * @var text
   */
  public $Requester_lastname;

  /**
   * Requester email address
   *
   * @var text
   */
  public $Requester_email;

  /**
   * Name of Trial Location
   *
   * @var text
   */
  public $Location_name;

  /**
   * Location Street Address
   *
   * @var text
   */
  public $Street_address;

  /**
   * Location City
   *
   * @var text
   */
  public $Location_city;

  /**
   * Location Province
   *
   * @var text
   */
  public $Location_province;

  /**
   * Location Country
   *
   * @var text
   */
  public $Location_country;

  /**
   * Trial Charperson
   *
   * @var int
   */
  public $trial_chairperson;

  /**
   * Trial Secretary
   *
   * @var int
   */
  public $trial_secretary;

  /**
   * Venue Description
   *
   * @var text
   */
  public $venue_description;

  /**
   * Space for Containers Description
   *
   * @var text
   */
  public $space_for_containers;

  /**
   * Space for Interior Search Area Description
   *
   * @var text
   */
  public $space_for_interior;

  /**
   * Space for Exterior Search Area Description
   *
   * @var text
   */
  public $space_for_exterior;

  /**
   * Space for Staging and Craiting Description
   *
   * @var text
   */
  public $staging_and_crating;

  /**
   * Space for Secretary Description
   *
   * @var text
   */
  public $space_for_secretary;

  /**
   * Space for Judge Description
   *
   * @var text
   */
  public $space_for_judge;

  /**
   * Confirm appropriate square footage is available
   *
   * @var int
   */
  public $confirm_square_footage;

  /**
   * Confirm you have gone through the venue plans with your judge(s)
   *
   * @var int
   */
  public $confirm_judge_contacted;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_trial_admin';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Trial Admins') : E::ts('Trial Admin');
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'event_id', 'civicrm_event', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'Requester', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'trial_chairperson', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'trial_secretary', 'civicrm_contact', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('Unique TrialAdmin ID'),
          'required' => TRUE,
          'where' => 'civicrm_trial_admin.id',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'approved' => [
          'name' => 'approved',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Approved'),
          'description' => E::ts('If Trial Approved'),
          'required' => TRUE,
          'where' => 'civicrm_trial_admin.approved',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'checkbox',
          ],
          'add' => NULL,
        ],
        'event_id' => [
          'name' => 'event_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Event'),
          'where' => 'civicrm_trial_admin.event_id',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'FKClassName' => 'CRM_Event_DAO_Event',
          'add' => NULL,
        ],
        'Requester' => [
          'name' => 'Requester',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Requester'),
          'description' => E::ts('FK to Contact'),
          'where' => 'civicrm_trial_admin.Requester',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'hosting_club' => [
          'name' => 'hosting_club',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Hosting Club'),
          'description' => E::ts('Club hosting trial'),
          'where' => 'civicrm_trial_admin.hosting_club',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'add' => NULL,
        ],
        'Requester_RP' => [
          'name' => 'Requester_RP',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Requester Rp'),
          'description' => E::ts('Requester RP Number'),
          'where' => 'civicrm_trial_admin.Requester_RP',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Requester_Name' => [
          'name' => 'Requester_Name',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Requester Name'),
          'description' => E::ts('Requester Name'),
          'where' => 'civicrm_trial_admin.Requester_Name',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Requester_lastname' => [
          'name' => 'Requester_lastname',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Requester Lastname'),
          'description' => E::ts('Requester last name'),
          'where' => 'civicrm_trial_admin.Requester_lastname',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Requester_email' => [
          'name' => 'Requester_email',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Requester Email'),
          'description' => E::ts('Requester email address'),
          'where' => 'civicrm_trial_admin.Requester_email',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Location_name' => [
          'name' => 'Location_name',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Location Name'),
          'description' => E::ts('Name of Trial Location'),
          'where' => 'civicrm_trial_admin.Location_name',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Street_address' => [
          'name' => 'Street_address',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Street Address'),
          'description' => E::ts('Location Street Address'),
          'where' => 'civicrm_trial_admin.Street_address',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Location_city' => [
          'name' => 'Location_city',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Location City'),
          'description' => E::ts('Location City'),
          'where' => 'civicrm_trial_admin.Location_city',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'text',
          ],
          'add' => NULL,
        ],
        'Location_province' => [
          'name' => 'Location_province',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Location Province'),
          'description' => E::ts('Location Province'),
          'where' => 'civicrm_trial_admin.Location_province',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_state_province',
            'keyColumn' => 'id',
            'labelColumn' => 'name',
            'nameColumn' => 'abbreviation',
            'condition' => 'country_id = 1039',
          ],
          'add' => NULL,
        ],
        'Location_country' => [
          'name' => 'Location_country',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Location Country'),
          'description' => E::ts('Location Country'),
          'where' => 'civicrm_trial_admin.Location_country',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'select',
          ],
          'add' => NULL,
        ],
        'trial_chairperson' => [
          'name' => 'trial_chairperson',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Trial Chairperson'),
          'description' => E::ts('Trial Charperson'),
          'where' => 'civicrm_trial_admin.trial_chairperson',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_contact',
            'keyColumn' => 'id',
            'labelColumn' => 'legal_name',
            'condition' => 'contact_type = "Individual"',
          ],
          'add' => NULL,
        ],
        'trial_secretary' => [
          'name' => 'trial_secretary',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Trial Secretary'),
          'description' => E::ts('Trial Secretary'),
          'where' => 'civicrm_trial_admin.trial_secretary',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'html' => [
            'type' => 'select',
          ],
          'pseudoconstant' => [
            'table' => 'civicrm_contact',
            'keyColumn' => 'id',
            'labelColumn' => 'legal_name',
            'condition' => 'contact_type = "Individual"',
          ],
          'add' => NULL,
        ],
        'venue_description' => [
          'name' => 'venue_description',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Venue Description'),
          'description' => E::ts('Venue Description'),
          'where' => 'civicrm_trial_admin.venue_description',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'space_for_containers' => [
          'name' => 'space_for_containers',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Space For Containers'),
          'description' => E::ts('Space for Containers Description'),
          'where' => 'civicrm_trial_admin.space_for_containers',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'space_for_interior' => [
          'name' => 'space_for_interior',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Space For Interior'),
          'description' => E::ts('Space for Interior Search Area Description'),
          'where' => 'civicrm_trial_admin.space_for_interior',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'space_for_exterior' => [
          'name' => 'space_for_exterior',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Space For Exterior'),
          'description' => E::ts('Space for Exterior Search Area Description'),
          'where' => 'civicrm_trial_admin.space_for_exterior',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'staging_and_crating' => [
          'name' => 'staging_and_crating',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Staging And Crating'),
          'description' => E::ts('Space for Staging and Craiting Description'),
          'where' => 'civicrm_trial_admin.staging_and_crating',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'space_for_secretary' => [
          'name' => 'space_for_secretary',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Space For Secretary'),
          'description' => E::ts('Space for Secretary Description'),
          'where' => 'civicrm_trial_admin.space_for_secretary',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'space_for_judge' => [
          'name' => 'space_for_judge',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Space For Judge'),
          'description' => E::ts('Space for Judge Description'),
          'where' => 'civicrm_trial_admin.space_for_judge',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'TextArea',
          ],
          'add' => NULL,
        ],
        'confirm_square_footage' => [
          'name' => 'confirm_square_footage',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Confirm Square Footage'),
          'description' => E::ts('Confirm appropriate square footage is available'),
          'where' => 'civicrm_trial_admin.confirm_square_footage',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => NULL,
        ],
        'confirm_judge_contacted' => [
          'name' => 'confirm_judge_contacted',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('Confirm Judge Contacted'),
          'description' => E::ts('Confirm you have gone through the venue plans with your judge(s)'),
          'where' => 'civicrm_trial_admin.confirm_judge_contacted',
          'table_name' => 'civicrm_trial_admin',
          'entity' => 'TrialAdmin',
          'bao' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'trial_admin', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'trial_admin', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
