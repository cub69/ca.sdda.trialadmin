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
    global $current_user;
    CRM_Utils_System::setTitle(E::ts('Trial Application'));
    $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);
    $this->_id = CRM_Utils_Request::retrieve('id', 'String', $this);
    $this->assign('url',$this->_url);
    $id = $this->_id;
    $action = $this->_action;
    error_log("Event in command line is: ".$id);
    error_log("Event action is: ".$action);
    if ( is_user_logged_in() != TRUE ) {
      #User is not logged in, return them to the home page
      error_log("User is not logged in");
      $message = "You must be logged in!  Please go to log in.";
      $title="Not Logged In!";
      $type="Error";
      CRM_Core_Session::setStatus($message, $title, $type,);
      $location = get_site_url()."/login/";
      #wp_redirect( $location, 301 );
      header ("Refresh: 2;URL='$location'"); 
      exit;      
    }
    # RP Check
    $params = array('email' => $current_user->user_email,'display_name' => $current_user->display_name,);
    error_log("Preparing for member: ".print_r($params, TRUE));

    $cuser = get_single_contact($params);
    //$cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_user->display_name,]);
    #error_log(print_r($cuser,TRUE));
    $params = array('sequential' => 1,'contact_id.id' => $cuser['contact_id'],);
    $result = get_single_member($params);
    //$result = civicrm_api3('Membership', 'get', ['sequential' => 1,'contact_id.id' => $cuser['contact_id'],]);
    $resultdetails = $result['values']['0'];
    #error_log(print_r($result,TRUE));
    #error_log(print_r($resultdetails,TRUE));
    #error_log("Action starting is: ".$action);

      
    // Temp create trial admin entry to assign ID too
    if ($action == '1') {
      $result = civicrm_api3('TrialAdmin', 'create', ['approved' => 0,]); 
      $id = $result['id'];
      error_log("New ID is: ".$id );
      $this->setDefaults(array( 
        'id' => $id,
        'Requester' => $cuser['contact_id'],
        'Requester_email' => $current_user->user_email,
        'Location_country' => 'Canada',
      ));  
    } else {
      error_log("Executing an update: ".$id);
      $result = civicrm_api3('TrialAdmin', 'get', ['id' => $id]);
      //$id = $result['id'];
      $values = $result['values'][$id];
      $eventid = $values['event_id'];
      error_log("Retrieved record: ".print_r($result,TRUE));
      $this->setDefaults(array(
        'id' => $values['id'],
        'ta_id' => $values['ta_id'],
        'event_id' => $eventid,
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
        'confirm_judge_contacted' => $values['confirm_judge_contacted'],));
    }

   error_log("Finished retrieving default values.");
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
        'type' => 'done',
        'name' => E::ts('Done'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'submit',
        'name' => E::ts('Add Component'),
        'isDefault' => FALSE,
      ),
    ));
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function addRules() {
    $this->addFormRule(array('CRM_Trialadmin_Form_TrialApplication', 'myRules'));
  }

  /**
   * Here's our custom validation callback
   */
  public static function myRules($values) {
    $errors = array();
    if ($values['Location_city'] == '') {
      $errors['Location_city'] = ts('You must enter a Location City');
    }
    if ($values['Location_name'] == '') {
      $errors['Location_name'] = ts('You must enter a Location name');
    }
    if ($values['Street_address'] == '') {
      $errors['Street_address'] = ts('You must enter a Location Street Address');
    }
    if ($values['hosting_club'] == '') {
      $errors['hosting_club'] = ts('You must enter a Hosting Club');
    }
    if ($values['Location_province'] == '') {
      $errors['Location_province'] = ts('You must enter a Location province');
    }
    if ($values['confirm_square_footage'] == 0) {
      $errors['confirm_square_footage'] = ts('You must check the box to confirm square footage');
    }
    if ($values['confirm_judge_contacted'] == 0) {
      $errors['confirm_judge_contacted'] = ts('You must check the box to confirm you spoke to the judge about the venue');
    }
    if ($values['trial_chairperson'] == '') {
      $errors['trial_chairperson'] = ts('You must select from list a trial Chairperson (hint last name first)');
    }
    if ($values['trial_secretary'] == '') {
      $errors['trial_secretary'] = ts('You must select from list a trial Secretary (hint last name first)');
    }

    return empty($errors) ? TRUE : $errors;
  }

  public function postProcess() {
    $values = $this->exportValues();
    $$values = $this->exportValues();
    $action = $this->_action;

    //error_log("The retrieved values from the form are: ".print_r($values, TRUE));
    
    if ($values["_qf_TrialApplication_submit"] ) {
      error_log("Add component Selected for: ".$id);
      if ($action == '1' ) {
      $eventid = $this->createEvent($values);
      error_log($eventid);
      }
      $result = civicrm_api3('TrialAdmin', 'create', [
            'id' => $values['id'],
            'event_id' => $eventid,
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
          //$url = <a title="Add a Component" class="button_name button crm-popup" href='{crmURL p="civicrm/addcomponent" q="reset=1&action=add&id=`$form.id.value`"}'>
          $location = get_site_url()."/civicrm?civiwp=CiviCRM&q=civicrm/addcomponent&reset=1&action=add&id=".$values['id'];
          #wp_redirect( $location, 301 );
          header ("Refresh: 2;URL='$location'"); 
    }
    if ($values["_qf_TrialApplication_done"] ) {
      error_log("Done button - finished editing or ready to submit ".$id);
      if ($action == '1') {
        $eventid = $this->createEvent($values);
        }
      $result = civicrm_api3('TrialAdmin', 'create', [
            'id' => $values['id'],
            'event_id' => $eventid,
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
        
      error_log("Submitting the trial app: ");
      $template = CRM_Core_Smarty::singleton();
      $params = array('sequential' => 1,'id' => $values['Requester'],);
      $contact = get_single_contact($params);
      //$contact = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['Requester'],]);
      $province = civicrm_api3('state_province', 'getsingle', ['id'=>$values['Location_province']]);
      $template ->assign('province', $province);
      $params = array('sequential' => 1,'id' => $values['trial_chairperson'],);
      $trialchair = get_single_contact($params);
      $params = array('sequential' => 1,'id' => $values['trial_secretary'],);
      $trialsecretary = get_single_contact($params);
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
      $params['from'] = 'Sporting Detection Dogs Association <norm@sdda.ca>';
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
      $turl = E::path('templates/CRM/Trialadmin/email/ApplicationEmailtoAdmin.tpl');
      $emailbody = (CRM_Core_Smarty::singleton()->fetch($turl));
      $params = array();
      $params['from'] = 'Sporting Detection Dogs Association <norm@sdda.ca>';
      $params['subject'] = 'Trial Application for Approval';
      $params['text'] = '';
      $params['html'] = $emailbody;
      $params['toName'] = 'Trial Approvers';
      $params['toEmail'] = 'norm@sdda.ca';
      $params['cc'] = 'karin@sdda.ca';
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
      'start_date' => date("12/31/2025"),
      'end_date' => date("12/31/2025"),
    ));
    error_log('Creating the trialAdmin Event: '.print_r($result, TRUE));
    return($result['id']);

  }

  public function get_next_trial_number() {

    $query = "SELECT max(trial_number) as `h1` FROM `civicrm_trial_components`";;
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
