<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from ca.sdda.trialadmin/xml/schema/CRM/Trialadmin/TrialadminLog.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:a97ad22404d57696af1aa730cf835878)
 */
use CRM_Trialadmin_ExtensionUtil as E;

/**
 * Database access object for the TrialadminLog entity.
 */
class CRM_Trialadmin_DAO_TrialadminLog extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_trialadmin_log';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Unique TrialadminLog ID
   *
   * @var int unsigned auto_increment
   */
  public $id;

  /**
   * FK to Trialadmin
   *
   * @var int
   */
  public $trial_id;

  /**
   * ID of posting entity
   *
   * @var int
   */
  public $entity_id;

  /**
   * Posting Entity
   *
   * @var string
   */
  public $entity;

  /**
   * Logged data
   *
   * @var text
   */
  public $data;

  /**
   * ID of modifier
   *
   * @var int
   */
  public $modified_id;

  /**
   * Date time stamp of Entry
   *
   * @var datetime NULL ON UPDATE CURRENT_TIMESTAMP
   */
  public $modified_date;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_trialadmin_log';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('Trialadmin Logs') : E::ts('Trialadmin Log');
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'trial_id', 'civicrm_trial_admin', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'modified_id', 'civicrm_contact', 'id');
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
          'description' => E::ts('Unique TrialadminLog ID'),
          'required' => TRUE,
          'where' => 'civicrm_trialadmin_log.id',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'trial_id' => [
          'name' => 'trial_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('FK to Trialadmin'),
          'required' => TRUE,
          'where' => 'civicrm_trialadmin_log.trial_id',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'FKClassName' => 'CRM_Trialadmin_DAO_TrialAdmin',
          'add' => NULL,
        ],
        'entity_id' => [
          'name' => 'entity_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('ID of posting entity'),
          'required' => FALSE,
          'where' => 'civicrm_trialadmin_log.entity_id',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'add' => NULL,
        ],
        'entity' => [
          'name' => 'entity',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Entity'),
          'description' => E::ts('Posting Entity'),
          'required' => FALSE,
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'where' => 'civicrm_trialadmin_log.entity',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'add' => NULL,
        ],
        'data' => [
          'name' => 'data',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Data'),
          'description' => E::ts('Logged data'),
          'required' => TRUE,
          'where' => 'civicrm_trialadmin_log.data',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'add' => NULL,
        ],
        'modified_id' => [
          'name' => 'modified_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => E::ts('ID of modifier'),
          'required' => TRUE,
          'where' => 'civicrm_trialadmin_log.modified_id',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
          'FKClassName' => 'CRM_Contact_DAO_Contact',
          'add' => NULL,
        ],
        'modified_date' => [
          'name' => 'modified_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => E::ts('Modified Date'),
          'description' => E::ts('Date time stamp of Entry'),
          'where' => 'civicrm_trialadmin_log.modified_date',
          'table_name' => 'civicrm_trialadmin_log',
          'entity' => 'TrialadminLog',
          'bao' => 'CRM_Trialadmin_DAO_TrialadminLog',
          'localizable' => 0,
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'trialadmin_log', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'trialadmin_log', $prefix, []);
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
