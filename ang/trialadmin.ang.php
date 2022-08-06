<?php
// This file declares an Angular module which can be autoloaded
// in CiviCRM. See also:
// \https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules/n
return [
  'js' => [
    'ang/trialadmin.js',
    'ang/trialadmin/*.js',
    'ang/trialadmin/*/*.js',
  ],
  'css' => [
    'ang/trialadmin.css',
  ],
  'partials' => [
    'ang/trialadmin',
  ],
  'requires' => [
    'crmUi',
    'crmUtil',
    'ngRoute',
  ],
  'settings' => [],
];
