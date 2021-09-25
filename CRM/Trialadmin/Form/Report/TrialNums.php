<?php
use CRM_Trialadmin_ExtensionUtil as E;

class CRM_Trialadmin_Form_Report_TrialNums extends CRM_Report_Form {

  protected $_addressField = FALSE;

  protected $_emailField = FALSE;

  protected $_summary = NULL;

  protected $_customGroupGroupBy = FALSE; function __construct() {
    $this->_columns = array(
      'civicrm_event' => array(
        'dao' => 'CRM_Event_DAO_Event',
        'fields' => array(
          'title' => array(
            'title' => E::ts('Event Title'),
          ),
          'start_date' => array(
            'title' => E::ts('Start Date'),
          ),
          'end_date' => array(
            'title' => E::ts('End Date'),
          ),
        ),
      ),
      'civicrm_trial_admin' => array(
        'dao' => 'CRM_Trialadmin_DAO_TrialAdmin',
        'fields' => array(
          'Requester_RP' => array(
            'title' => 'Requester',
          ),
          'Requester_email' => array(
            'title' => 'Email Address',
          ),
          'hosting_club' => array(
            'title' => E::ts('Hosting Club'),
          ),
        ),
      ),
      'civicrm_trial_components' => array(
        'dao' => 'CRM_Trialadmin_DAO_TrialComponents',
        'fields' => array(
          'trial_number' => array(
            'title' => E::ts('Trial Number'),
            'default' => TRUE,
          ),
          'trial_date' => array(
            'title' => E::ts('Trial Date'),
            'default' => TRUE,
          ),
        ),
      ),
    );
    $this->_groupFilter = TRUE;
    $this->_tagFilter = TRUE;
    parent::__construct();
  }

  function preProcess() {
    $this->assign('reportTitle', E::ts('Membership Detail Report'));
    parent::preProcess();
  }
// Original SQL to get the CSV files
//  select SQL_CALC_FOUND_ROWS event.title_en_CA, event.start_date, event.end_date, admin.Requester, admin.hosting_club, components.trial_number, components.trial_date
//  FROM civicrm_event event
//      LEFT JOIN civicrm_trial_admin admin ON event.id = admin.event_id
//      LEFT JOIN civicrm_trial_components components ON event.id = components.event_id
//  WHERE components.trial_number IS NOT null  
//  ORDER BY `components`.`trial_number` ASC
  
  function from() {
    $this->_from = NULL;

    $this->_from = "
         FROM  civicrm_event {$this->_aliases['civicrm_event']} {$this->_aclFrom}
               LEFT JOIN civicrm_trial_admin {$this->_aliases['civicrm_trial_admin']}
                          ON {$this->_aliases['civicrm_event']}.id =
                             {$this->_aliases['civicrm_trial_admin']}.event_id
               LEFT  JOIN civicrm_trial_components {$this->_aliases['civicrm_trial_components']}
                          ON {$this->_aliases['civicrm_event']}.id =
                             {$this->_aliases['civicrm_trial_components']}.event_id ";


    
  }
  function where() { 
    $this->_where = "WHERE {$this->_aliases['civicrm_trial_components']}.trial_number IS NOT null "; 
  }

  /**
   * Add field specific select alterations.
   *
   * @param string $tableName
   * @param string $tableKey
   * @param string $fieldName
   * @param array $field
   *
   * @return string
   */
  function selectClause(&$tableName, $tableKey, &$fieldName, &$field) {
    return parent::selectClause($tableName, $tableKey, $fieldName, $field);
  }

  /**
   * Add field specific where alterations.
   *
   * This can be overridden in reports for special treatment of a field
   *
   * @param array $field Field specifications
   * @param string $op Query operator (not an exact match to sql)
   * @param mixed $value
   * @param float $min
   * @param float $max
   *
   * @return null|string
   */
  public function whereClause(&$field, $op, $value, $min, $max) {
    return parent::whereClause($field, $op, $value, $min, $max);
  }

  function alterDisplay(&$rows) {
    // custom code to alter rows
    $entryFound = FALSE;
    $checkList = array();
    foreach ($rows as $rowNum => $row) {

      if (!empty($this->_noRepeats) && $this->_outputMode != 'csv') {
        // not repeat contact display names if it matches with the one
        // in previous row
        $repeatFound = FALSE;
        foreach ($row as $colName => $colVal) {
          if (CRM_Utils_Array::value($colName, $checkList) &&
            is_array($checkList[$colName]) &&
            in_array($colVal, $checkList[$colName])
          ) {
            $rows[$rowNum][$colName] = "";
            $repeatFound = TRUE;
          }
          if (in_array($colName, $this->_noRepeats)) {
            $checkList[$colName][] = $colVal;
          }
        }
      }

      if (!$entryFound) {
        break;
      }
    }
  }

}
