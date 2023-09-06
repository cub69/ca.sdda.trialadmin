<?php
// This file declares a managed database record of type "ReportTemplate".
// The record will be automatically inserted, updated, or deleted from the
// database as appropriate. For more details, see "hook_civicrm_managed" at:
// https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
return [
  [
    'name' => 'CRM_Trialadmin_Form_Report_Judges',
    'entity' => 'ReportTemplate',
    'params' => [
      'version' => 3,
      'label' => 'Judges',
      'description' => 'Judges (ca.sdda.trialadmin)',
      'class_name' => 'CRM_Trialadmin_Form_Report_Judges',
      'report_url' => 'ca.sdda.trialadmin/judges',
      'component' => '',
    ],
  ],
];
