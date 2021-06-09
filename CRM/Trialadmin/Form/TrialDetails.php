<?php

use CRM_Trialadmin_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Trialadmin_Form_TrialDetails extends CRM_Core_Form {
  public function preProcess() {
    // do prep work  
  //$this->preventAjaxSubmit();
  
    CRM_Utils_System::setTitle(E::ts('Trial Details'));
    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);	
    $this->assign('url',$this->_url);

//    error_log(print_r($this, TRUE));
    if ($this->_name == "TrialDetails") {
      //$eventID = $context['event_id'];
      $this->_eID = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
      $id = $this->_eID;
      
      $event = civicrm_api3('TrialAdmin', 'get', ['event_id' => $id,]);
      $eventid = $event["id"];
      $components = civicrm_api3('TrialComponents', 'get', ['event_id' => $eventid]);
      //$id = "355";
      error_log("This is the event:".print_r($event, TRUE));
      error_log("Building the form...");
      
      $details = $event['values'][$eventid];
      error_log("Details: ".print_r($details,TRUE));
      $this->_approved_status = $details['approved'];
      $this->setDefaults(array( 
          'id' => $details['id'],
          'approved' => $details['approved'],
          'event_id' => $details['event_id'],
          'hosting_club' => $details['hosting_club'],
          'Requester' => $details['Requester'],
          'Requester_RP' => $details['Requester_RP'],
          'Requester_Name' => $details['Requester_Name'],
          'Requester_lastname' => $details['Requester_lastname'],
          'Requester_email' => $details['Requester_email'],
          'Location_name' => $details['Location_name'],
          'Street_address' => $details['Street_address'],
          'Location_city' => $details['Location_city'],
          'Location_province' => $details['Location_province'],
          'Location_country' => $details['Location_country'],
          'trial_chairperson' => $details['trial_chairperson'],
          'trial_secretary' => $details['trial_secretary'],
          'venue_description' => $details['venue_description'],
          'space_for_containers' => $details['space_for_containers'],
          'space_for_interior' => $details['space_for_interior'],
          'space_for_exterior' => $details['space_for_exterior'],
          'staging_and_crating' => $details['staging_and_crating'],
          'space_for_secretary' => $details['space_for_secretary'],
          'space_for_judge' => $details['space_for_judge'],
          'confirm_square_footage' => $details['confirm_square_footage'],
          'confirm_judge_contacted' => $details['confirm_judge_contacted'],
          
      ));
    } 
  }
  public function buildQuickForm() {
    $this->add('text','id','id',TRUE);
    $this->add('text','event_id','event_id',TRUE);

    // add action buttons for automation
    $this->add('advcheckbox', 'approved', 'Approve Trial',);
    
    $this->addEntityRef('Requester', ts('Select Contact'));
    $this->add('text','Requester_email','Requester Email',TRUE);
    $this->add('text','hosting_club','Hosting Club',TRUE);
    $this->add('text','Location_name','Location Name',TRUE);
//    $this->addEntityRef('location_entry',ts('Select Location'), [
//        'entity' => 'Address',
//        'api' => ['params' => ['location_type_id' => '1'],],
//        'select' => ['street_address'],
//        ]);
        
    $this->add('text','Street_address','Address',TRUE);
    $this->add('text','Location_city','City',TRUE);
    $this->addEntityRef('Location_province', ts('Select Province'),
      ['entity' => 'state_province',]);
//    $this->addEntityRef('Location_country', ts('Select country'),
//      ['entity' => 'country',]);
    $this->add('textarea', 'venue_description', 'Location Description',TRUE);  
    $this->add('textarea', 'space_for_containers', 'Space for Container Searches',TRUE);  
    $this->add('textarea', 'space_for_interior', 'Space for Interior Searches',TRUE);  
    $this->add('textarea', 'space_for_exterior', 'Space for Exterior Searches',TRUE);  
    $this->add('textarea', 'staging_and_crating', 'Space for Staging and Crating',TRUE);  
    $this->add('textarea', 'space_for_secretary', 'Space for Secretary',TRUE);  
    $this->add('textarea', 'space_for_judge', 'Space for Judge',TRUE);  
    $this->add('advcheckbox', 'confirm_square_foodtage', 'Confirm Square Footage as per Rulebook',) ;
    $this->add('advcheckbox', 'confirm_judge_contacted', 'Confirm you have talked to the judge about venue', );
    $this->addEntityRef('trial_chairperson', ts('Select Trial Chairperson'));
    $this->addEntityRef('trial_secretary', ts('Select Trial Secretary'));

    $this->addButtons(array(
      array(
        'type' => 'done',
        'name' => E::ts('Done'),
        'isDefault' => TRUE,
      ),
      )    
    );

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    
    $values = $this->exportValues();
    $$values = $this->exportValues();
    
     // add some error control
    if ($values["_qf_TrialDetails_submit"] = "done") {
		  error_log("Executing a save/update of data");
      error_log("Current this array: ".print_r($values, TRUE));
      
		    $result = civicrm_api3('TrialAdmin', 'create', [
        'id' => $values['id'],
        'event_id' => $values['event_id'], 
        'approved' => $values['approved'],
        'hosting_club' => $values['hosting_club'],
        'Requester' => $values['Requester'],
        'Requester_RP' => $values['Requester_RP'],
        'Requester_Name' => $values['Requester_Name'],
        'Requester_lastname' => $values['Requester_lastname'],
        'Requester_email' => $values['Requester_email'],
        'Location_name' => $values['Location_name'],
        'Street_address' => $values['Street_address'],
        'Location_city' => $values['Location_city'],
        'Location_province' => $values['Location_province'],
        'Location_country' => "Canada",
        'trial_chairperson' => $values['trial_chairperson'],
        'trial_secretary' => $values['trial_secretary'],
        'venue_description' => $values['venue_description'],
        'space_for_containers' => $values['space_for_containers'],
        'space_for_interior' => $values['space_for_interior'],
        'space_for_exterior' => $values['space_for_exterior'],
        'staging_and_crating' => $values['staging_and_crating'],
        'space_for_secretary' => $values['space_for_secretary'],
        'space_for_judge' => $values['space_for_judge'],
        'confirm_square_footage' => $values['confirm_square_footage'],
        'confirm_judge_contacted' => $values['confirm_judge_contacted'],
		    ]); 
        error_log("Returned value is: ".print_r($result,TRUE));
		  //error_log("Previous status was: ".$this->_approved_status);
      //error_log("Current status is: ".$values['approved']);
      if ($values['approved'] != $this->_approved_status) {
        error_log("Approval status has changed");
        if ($values['approved'] == '1') {
          error_log("Trial Approved!");
          //prepare email to requester
          // get contact details
          $template = CRM_Core_Smarty::singleton();
          $contact = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['Requester'],]);
          $province = civicrm_api3('state_province', 'getsingle', ['id'=>$values['Location_province']]);
          $template ->assign('province', $province);
          error_log(print_r($province, TRUE));
          foreach ($contact as $key => $value) {
            $template->assign($key, $value);
          }         
          foreach ($values as $key => $value) {
            $template->assign($key, $value);
          }
          $turl = E::path('templates/CRM/Trialadmin/email/trialApproval.tpl');
          $emailbody = (CRM_Core_Smarty::singleton()->fetch($turl));
          $params = array();
          $params['from'] = 'Sporting Detection Dogs Association <norm@sportingdetectiondogs.ca>';
          $params['toName'] = $values['Requester_Name'].' '.$values['Requester_lastname'];
          $params['toEmail'] = $values['Requester_email'];
          $params['subject'] = 'Trial Approval';
          $params['text'] = '';
          $params['html'] = $emailbody;
          CRM_Utils_Mail::send($params);
        
          //Register host, trial secretary and judge(s) for the event
          $partic= array();
          $curr = civicrm_api3('Participant', 'get', [
            'event_id' => $values['event_id'],
          ]);
          $curr = $curr['values'];
          foreach($curr as $key=>$value) {
            if (!in_array($value['contact_id'], $partic)) {
              array_push($partic, $value['contact_id']);
            }
          };
          error_log("loaded from database ".print_r("$partic",TRUE));
          if (!in_array($values['trial_chairperson'], $partic )) {
              $result = civicrm_api3('Participant', 'create', [
                'event_id' => $values['event_id'],
                'contact_id' => $values['trial_chairperson'],
                'role_id' => "Host",
              ]);
              array_push($partic, $values['trial_chairperson']);
              error_log("Trial chair added");
          }
          if (!in_array($values['trial_secretary'], $partic )) {
              $result = civicrm_api3('Participant', 'create', [
                'event_id' => $values['event_id'],
                'contact_id' => $values['trial_secretary'],
                'role_id' => "Trial Secretary",
              ]);
              array_push($partic, $values['trial_chairperson']);
              error_log("Trial secretary added");
          }
          $comp1 = civicrm_api3('TrialComponents', 'get', ['sequential' => 1, 'event_id' => $values['event_id']]);
          $judges = $comp1['values'];
          error_log(print_r($partic, TRUE));
          foreach ($judges as $key=>$value) {
            if (!in_array($value['judge'], $partic)) {
              array_push($partic,$value['judge']);
              error_log("Judge added");
              $result = civicrm_api3('Participant', 'create', [
                'event_id' => $values['event_id'],
                'contact_id' => $value['judge'],
                'role_id' => "Judge",
              ]);
            }
          }
          error_log(print_r($partic,TRUE));
          //Set event values - public, and new look Trial description
    
        } else {
          error_log("Trial UNapproved or cancelled");
        }
      }
      $eventid = $values['event_id'];
      $url = CRM_Utils_System::url( 'civicrm/event/manage/settings', "reset=1&force=1&action=update&id=$eventid" );
      CRM_Core_Session::singleton()->pushUserContext($url);
    }
  }

   /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }


}
