<?php
use CRM_Trialadmin_ExtensionUtil as E;

class CRM_Trialadmin_Page_Triallog extends CRM_Core_Page {

  public function run() {
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Triallog'));
    $this->_eID = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
      $eventid = $this->_eID;
      error_log("Event details:    ".$eventid);
      $event = civicrm_api3('Event', 'get', ['id' => $eventid]);
    error_log("Event details:    ".print_r($event,TRUE));
    $title = $event['values'][$eventid]['title'];
    $form = $this->get_template_vars('form');
    $form['trialname'] = $title;
    //gets the variable 'form' from smarty and puts it in your php scope so you can play with it
    //$form = $this->get_template_vars('form');
    
//    $form->assign('trialname',$title);

    $trial = civicrm_api3('TrialAdmin', 'get', ['event_id' => $event['id'],]);
    $id = $trial["id"];
    error_log("The id of this trial is: ".$event['id'].print_r($id,TRUE));
    $logged = civicrm_api3('TrialadminLog', 'get', ['trial_id' => $id]);
    $form['logged'] = $logged;
    $this->assign('form',$form); 
    parent::run();

  }

}
