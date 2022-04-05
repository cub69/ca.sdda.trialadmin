<?php

use CRM_Trialadmin_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Trialadmin_Form_TrialApplication extends CRM_Core_Form {
  public $action;
  public function preProcess() {
    // do prep work  
  //$this->preventAjaxSubmit();
  
    CRM_Utils_System::setTitle(E::ts('Trial Application'));
    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
    $this->assign('url',$this->_url);
    $action = $this->_action;
    error_log("Action starting is: ".$action);
    if ($action == '2') {
      //$eventID = $context['event_id'];
      $this->_event_ID = CRM_Utils_Request::retrieve('eventid', 'Positive', $this, TRUE);
      $eventid = $this->_event_ID;
      $event = civicrm_api3('TrialAdmin', 'get', ['event_id' => $this->_event_ID,]);
      $components = civicrm_api3('TrialComponents', 'get', ['event_id' => $this->_event_ID]);
      $id = $event["id"];
      
      //$id = "355";
      //error_log(print_r($event, TRUE));
      //error_log("Building the form...".$id);
      
      $details = $event['values'][$id];
      //error_log(print_r($details, TRUE)); 
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
    } elseif($action == '1' ) {
      // this is a new trial application!
      global $current_user;
      error_log(print_r($current_user,TRUE));
      if ( is_user_logged_in() != TRUE ) {
        #User is not logged in, return them to the home page
        error_log("User is not logged in");
        $location = get_site_url();
        wp_redirect( $location, 301 );
        exit;      
      }
      try {
      $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);
      }
      catch (CiviCRM_API3_Exception $e) {
        //error handler!
        $errorMessage = "Sorry, something went wrong! "+$e->getMessage();
        $errorCode = $e->getErrorCode();
        $errorData = $e->getExtraParams();
        return [
          'is_error' => 1,
          'error_message' => $errorMessage,
          'error_code' => $errorCode,
          'error_data' => $errorData,
        ];
      }
      //error_log(print_r($cuser,TRUE));
      $this->setDefaults(array( 
        'Requester' => $cuser['contact_id'],
        'Requester_email' => $current_user->user_email,
        'Location_country' => 'Canada',
      ));

    }
   //error_log("Finished retrieving default values.");
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
    $this->addEntityRef('Location_province', ts('Select Province'),
      ['entity' => 'state_province','api' => ['params' => ['country_id' => 1039]]]);
   // $this->addEntityRef('Location_country', ts('Select country'),
   //   ['entity' => 'country', 'api' => ['params' => ['country_id' => 1039]]]);
    $this->add('textarea', 'venue_description', 'Location Description',TRUE);  
    $this->add('textarea', 'space_for_containers', 'Space for Container Searches',TRUE);  
    $this->add('textarea', 'space_for_interior', 'Space for Interior Searches',TRUE);  
    $this->add('textarea', 'space_for_exterior', 'Space for Exterior Searches',TRUE);  
    $this->add('textarea', 'staging_and_crating', 'Space for Staging and Crating',TRUE);  
    $this->add('textarea', 'space_for_secretary', 'Space for Secretary',TRUE);  
    $this->add('textarea', 'space_for_judge', 'Space for Judge',TRUE);  
    $this->add('advcheckbox', 'confirm_square_footage', 'Confirm Square Footage as per Rulebook',) ;
    $this->add('advcheckbox', 'confirm_judge_contacted', 'Confirm you have talked to the judge about venue', );
    $this->addEntityRef('trial_chairperson', ts('Select Trial Chairperson'));
    $this->addEntityRef('trial_secretary', ts('Select Trial Secretary'));
    $this->addButtons(array(
      array(
        'type' => 'next',
        'name' => E::ts('Next Step'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'done',
        'name' => E::ts('Submit Application'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
        'isDefault' => FALSE,
      ),
    ));
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    $$values = $this->exportValues();
    // error_log("The retrieved values from the form are: ".print_r($values, TRUE));

    if ($values["_qf_TrialApplication_next"] ) {

		  error_log("Executing a save/update of data".$this->_action);
      if ($this->_action == '1') {
        // need to add some error checking here
        $event_id = $this->createEvent($values);
        error_log("We are adding a new Trial Admin event: ".$event_id);
        $result = civicrm_api3('TrialAdmin', 'create', [
          'event_id' => $event_id,
          'approved' => 0,
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
        $evd=$event_id;
 	      error_log(print_r($result, TRUE));
      } else {
        //this is an update
        error_log("We are updating the existing Trial admin event ".$values['id']." ".$values['event_id']);
        $result = civicrm_api3('TrialAdmin', 'create', [
          'id' => $values['id'],
          'event_id' => $$values['event_id'],
          'approved' => 0,
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
        $evd = $values['event_id'];
      }
      //go somewhere now that they are done
//      $url = CRM_Utils_System::url('civicrm/TrialDetails', "reset=1&action=update&eventid=$event_id");
      $url = CRM_Utils_System::url( 'civicrm/trialapplication', "action=update&eventid=$evd" );
      error_log("Next steps pressed".$url."    Event ID: ".$evd);        
      CRM_Core_Session::singleton()->pushUserContext($url);
    } elseif ($values["_qf_TrialApplication_done"] ) {
        error_log("Submitting the trial app: ");
        $template = CRM_Core_Smarty::singleton();
        $contact = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['Requester'],]);
        $province = civicrm_api3('state_province', 'getsingle', ['id'=>$values['Location_province']]);
        $template ->assign('province', $province);
        $trialchair = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_chairperson'],]);
        $trialsecretary = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_secretary'],]);
        foreach ($contact as $key => $value) {
          $template->assign($key, $value);
        }         
        foreach ($values as $key => $value) {
          $template->assign($key, $value);
        }
        $template->assign('trial_chair', $trialchair['display_name']);
        $template->assign('trial_secr', $trialsecretary['display_name']);
        $turl = E::path('templates/CRM/Trialadmin/email/ApplicationEmail.tpl');
        $emailbody = (CRM_Core_Smarty::singleton()->fetch($turl));
        $params = array();
        $params['from'] = 'Sporting Detection Dogs Association <norm@sportingdetectiondogs.ca>';
        $params['toName'] = $values['Requester_Name'].' '.$values['Requester_lastname'];
        $params['toEmail'] = $contact['email'];
        $params['subject'] = 'Trial Application';
        $params['text'] = '';
        $params['html'] = $emailbody;
        CRM_Utils_Mail::send($params);
        CRM_Utils_Mail::logger($contact['email'],$params,$emailbody);
        $result = civicrm_api3('Trialadmin_log', 'create',[ 
          'trial_id' => $values['id'],
          'entity_id' => '100',
          'entity' => "Trial Admin",
          'data' => "New trial application - email to requester",
          'modified_id' => $values['Requester'],
          'modified_date' => date('Y-m-d H:i:s'),
        ]);
        error_log("Log entry");
        error_log(print_r($result, TRUE));

        $turl = E::path('templates/CRM/Trialadmin/email/ApplicationEmailtoAdmin.tpl');
        $emailbody = (CRM_Core_Smarty::singleton()->fetch($turl));
        $params = array();
        $params['from'] = 'Sporting Detection Dogs Association <norm@sportingdetectiondogs.ca>';
        $params['subject'] = 'Trial Application for Approval';
        $params['text'] = '';
        $params['html'] = $emailbody;
        $params['toName'] = 'Trial Approvers';
        $params['toEmail'] = 'norm@sportingdetectiondogs.ca';
        $params['cc'] = 'karin@sportingdetectiondogs.ca';
        CRM_Utils_Mail::send($params);
        $result = civicrm_api3('Trialadmin_log', 'create',[ 
          'trial_id' => $values['id'],
          'entity_id' => '100',
          'entity' => "Trial Admin",
          'data' => "New trial application - email to approvers",
          'modified_id' => $values['Requester'],
          'modified_date' => date('Y-m-d H:i:s'),
        ]);
        CRM_Core_Session::singleton()->pushUserContext($url);

    } elseif ($values["_qf_TrialApplication_cancel"] ) {
      // hmmm need to clean this up
      error_log("Cancelling the trial app: ".$url);        
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

  public function createEvent($event) {
    // process of creating the trial event
    $province = $event['Location_province'];
    $stateProvince = civicrm_api3('StateProvince', 'get', ['sequential' => 1,'id' => $province, ]);
    $province = $stateProvince['values'][0];
    $my_event_summary = $event['Location_city'].", ".$province['name']." - Scent Trial Event";
    // Description will be updated once the components have been added for the scent trial
    // needs to be added to both this trial application as well as the trial admin for when its updated
    // dates will also be updated after the components will be added for the time being, we will add a dummy value  
    $result = civicrm_api3('Event', 'create', array(
      'sequential' => 1,
      'event_type_id' => "trial",
      'is_public' => 0,
      'debug' => 1, 
      'summary' => $my_event_summary,
      'event_full_text' => $my_event_summary,
      'title' => $my_event_summary,
      'description' => $my_event_summary,
      'start_date' => date("12/31/2022"),
      'end_date' => date("12/31/2022"),
    ));
    error_log('Creating the trialAdmin Event: '.print_r($result, TRUE));
    return($result['id']);

  }

  public function get_next_trial_number() {

    $query = "SELECT max(trial_number) as `h1` FROM `civicrm_trialcomponents`";;
    $dao = CRM_Core_DAO::executeQuery( $query );
    $dao->fetch();
    error_log("Trial numbers: ".$dao->h1);
    $highesttrialnumber = $dao->h1;
    error_log("Highest trial number ".$highesttrialnumber);
    return($highesttrialnumber);
  }
  public function is_user_logged_in() {
    $user = wp_get_current_user();
 
    return $user->exists();
}

}
