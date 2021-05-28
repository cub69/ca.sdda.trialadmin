<?php
use CRM_Trialadmin_ExtensionUtil as E;

class CRM_Trialadmin_BAO_TrialComponents extends CRM_Trialadmin_DAO_TrialComponents {

  /**
   * Create a new TrialComponents based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Trialadmin_DAO_TrialComponents|NULL
   *
  public static function create($params) {
    $className = 'CRM_Trialadmin_DAO_TrialComponents';
    $entityName = 'TrialComponents';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

}
