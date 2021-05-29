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
      $this->_event_ID = CRM_Utils_Request::retrieve('eventid', 'Positive', $this, TRUE);
      $event = civicrm_api3('TrialAdmin', 'get', ['event_id' => $this->_event_ID,]);
      $components = civicrm_api3('TrialComponents', 'get', ['event_id' => $this->_event_ID]);
      $id = $event["id"];
      //$id = "355";
      //error_log(print_r($event, TRUE));
      error_log("Building the form...".$id);
      
      $details = $event['values'][$id];
      error_log(print_r($details, TRUE));
      $this->setDefaults(array( 
          'id' => $details['id'],
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

    $this->addEntityRef('Requester', ts('Select Contact'));
    $this->add('text','Requester_email','Requester Email',TRUE);
    
    // add form elements
    $this->add('text','hosting_club','Hosting Club',TRUE);
    $this->add('text','Location_name','Location Name',TRUE);
    $this->add('text','Street_address','Address',TRUE);
    $this->add('text','Location_city','City',TRUE);
    //$this->add('text','Location_province','Province',TRUE);
    $this->addEntityRef('Location_province', ts('Select Province'),
      ['entity' => 'state_province',]);
    $this->addEntityRef('Location_country', ts('Select country'),
      ['entity' => 'country',]);
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

    //$this->add(
    //  'select', // field type
    //  'favorite_color', // field name
    //  'Favorite Color', // field label
    //  $this->getColorOptions(), // list of options
    //  TRUE // is required
    //);
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $$values = $this->exportValues();
    error_log(print_r($values, TRUE));

     
    if ($values["_qf_TrialDetails_submit"] = "Submit") {
		  error_log("Executing a save/update of data");
		    $result = civicrm_api3('TrialAdmin', 'create', [
        'id' 	=> $values['id'],
        'event_id' => $values['event_id'], 
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
        'Location_country' => $values['Location_country'],
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
		    error_log(print_r($result, TRUE));
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
    error_log(print_r($elementNames, TRUE));
    return $elementNames;
  }

}
