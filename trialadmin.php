<?php

require_once 'trialadmin.civix.php';
// phpcs:disable
use CRM_Trialadmin_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function trialadmin_civicrm_config(&$config) {
  _trialadmin_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function trialadmin_civicrm_xmlMenu(&$files) {
  _trialadmin_civix_civicrm_xmlMenu($files);
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
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function trialadmin_civicrm_managed(&$entities) {
  _trialadmin_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function trialadmin_civicrm_caseTypes(&$caseTypes) {
  _trialadmin_civix_civicrm_caseTypes($caseTypes);
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
function trialadmin_civicrm_angularModules(&$angularModules) {
  _trialadmin_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function trialadmin_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _trialadmin_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

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

/**
 * Implements hook_civicrm_themes().
 */
function trialadmin_civicrm_themes(&$themes) {
  _trialadmin_civix_civicrm_themes($themes);
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
    //CRM_Core_Session::setStatus("in the Trial Admin", "EventID is ".$eid);
    //error_log("I'm in the Trial Admin region Event #".$eid);
    if ($eid) {
    //$url = CRM_Utils_System::url( 'civicrm/event/manage/TrialAdmin', "reset=1&force=1&id=$eid&snippet=5&angularDebug=1" );
    $url = CRM_Utils_System::url( 'civicrm/event/manage/TrialAdmin/trialdetails', "reset=1&force=1&eventid=$eid" );
    //$url = CRM_Utils_System::url( 'civicrm/tdetails', "reset=1&force=1&eventid=$eid" );
  
    error_log($url);
    $tab['Administration'] = array(
      'title' => "Administration",
      'link' => $url,
      'valid' => 1,
      'active' => 1,
      'current' => false,  
    );

  // Add our Angular module to the page
//      Civi::service('angularjs.loader')->addModules(['trialadmin']);
      // Add the tab
//      $tab['Administration'] = [
//        'title' => "Administration",
//        'templateurl' => '~/ang/trialadmin/details.aff.html',
//        'valid' => 1,
//        'active' => 1,
//        'current' => false,
//      ];
      
  }
  else {
    $tab['Administration'] = array(
    'title' => "Administration",
      'url' => 'civicrm/Tdetails',
    );
  };
  //Insert this tab into position 4
  $tabs = array_merge(
    array_slice($tabs, 0, 2),
    $tab,
    array_slice($tabs, 2)
  );
}
}
}


