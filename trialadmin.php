<?php

require_once 'trialadmin.civix.php';
// phpcs:disable
use CRM_Trialadmin_ExtensionUtil as E;
// phpcs:enable

function trialadmin_civicrm_permission(&$permissions) {
  $version = CRM_Utils_System::version();
  if (version_compare($version, '4.6.1') >= 0) {
    $permissions['access TrialAdmin'] = [
        E::ts('Access TrialAdmin'),
        E::ts('Grants the necessary API permissions for applying for and administering trial events'),
      ];
    $permissions['edit TrialAdmin'] = [
        E::ts('TrialAdmin: edit TrialAdmin'),                     // label
        E::ts('TrialAdmin: Create or edit various data tables and forms in TrialAdmin'),  // description
      ];
    $permissions['delete in TrialAdmin'] = [
        E::ts('TrialAdmin: delete TrialAdmin'),                    // if no description, just give an array with the label
      ];
    
  }
  else {
    $permissions += [
      'access TrialAdmin' => E::ts('Access TrialAdmin'),
    ];
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function trialadmin_civicrm_config(&$config) {
  _trialadmin_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function trialadmin_civicrm_install() {
  _trialadmin_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function trialadmin_civicrm_postInstall() {
  _trialadmin_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function trialadmin_civicrm_uninstall() {
  _trialadmin_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function trialadmin_civicrm_enable() {
  _trialadmin_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function trialadmin_civicrm_disable() {
  _trialadmin_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function trialadmin_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _trialadmin_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
//function trialadmin_civicrm_angularModules(&$angularModules) {
//  _trialadmin_civix_civicrm_angularModules($angularModules);
//}



/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function trialadmin_civicrm_entityTypes(&$entityTypes) {
  _trialadmin_civix_civicrm_entityTypes($entityTypes);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function trialadmin_civicrm_preProcess($formName, &$form) {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function trialadmin_civicrm_navigationMenu(&$menu) {
//  _trialadmin_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _trialadmin_civix_navigationMenu($menu);
//}

function trialadmin_civicrm_tabset($tabsetName, &$tabs, $context) {
  //CRM_Core_Session::setStatus("in the Trial Admin", "Is this working?");


 //check if the tab set is Event manage
 if ($tabsetName == 'civicrm/event/manage') {
   error_log(print_r($context, TRUE));
  if (!empty($context)) {
      $eid = $context['event_id'];
  //if ($eid) {
    //$url = CRM_Utils_System::url( 'civicrm/event/manage/TrialAdmin', "reset=1&force=1&id=$eid&snippet=5&angularDebug=1" );
    $url = CRM_Utils_System::url( 'civicrm/event/manage/TrialAdmin/trialdetails', "reset=1&force=1&id=$eid" );
   //$url = CRM_Utils_System::url( 'civicrm/a/#/trialadmin/administration' );
  
      error_log($url);
//    Civi::service('angularjs.loader')->addModules(['trialadmin']);
      // Add the tab
      
      $tab['Administration'] = [
        'title' => "Administration",
        'link' => $url,
        'valid' => 1,
        'active' => 1,
        'current' => false,
      ];
      $url = CRM_Utils_System::url( 'civicrm/event/manage/Trialadmin/Triallog', "reset=1&force=1&id=$eid" );
      $tab['Trial Log'] = [
        'title' => "Trial Log",
        'link' => $url,
        'valid' => 1,
        'active' => 1,
        'current' => false,
      ];

  }
  else {
    $tab['Administration'] = array(
    'title' => "Administration",
      'url' => 'civicrm/Tdetails',
    );
    $tab['Trial Log'] = array(
      'title' => "Trial Log",
      'url' => 'civicrm/tlog');

  };

  //Insert this tab into position 4
  $tabs = array_merge(
    array_slice($tabs, 0, 2),
    $tab,
    array_slice($tabs, 2)
  );
}
}

