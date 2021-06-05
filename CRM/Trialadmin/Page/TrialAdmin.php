<?php
use CRM_Trialadmin_ExtensionUtil as E;

class CRM_Trialadmin_Page_TrialAdmin extends CRM_Core_Page {

  public function run() {
    
    //$this->_eventid = CRM_Utils_Request::retrieve('eventid', 'Positive', $this, TRUE);
    $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
    //$this->assign('eventid', $this->_eventid);
    $this->assign('id', $this->_id);
    CRM_Utils_System::setTitle(E::ts('TrialAdmin'));
    $eventid = $this->_id;
    error_log( print_r($this, TRUE) );
    //error_log("The event id is: ".$eventid);
    // Example: Assign a variable for use in a template
    $this->assign('currentTime', date('Y-m-d H:i:s'));
    
    CRM_Core_Resources::singleton()->addSetting(array('trialEvent' => array('event' => strval($eventid))));
 
    $loader = new \Civi\Angular\AngularLoader();
    $loader->setModules(array('trialadmin'));
    $loader->setPageName('Administration');
    $loader->useApp(['activeRoute' => '/trialadmin/trialdetails']);
    $loader->load();
    parent::run();
  }

}
