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
    $action=$this->_action;

//    error_log(print_r($this, TRUE));
    if ($this->_name == "TrialDetails") {
      //$eventID = $context['event_id'];
      
      $this->_eID = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
      $eventid = $this->_eID;
      
      $event = civicrm_api3('TrialAdmin', 'get', ['event_id' => $eventid,]);
      $id = $event["id"];
      
      error_log("This is the event:".$eventid." ".$id);
      $components = civicrm_api3('TrialComponents', 'get', ['ta_id' => $id]);
      
      //$id = "355";
      error_log(print_r($event,TRUE));
      
      error_log("Building the form for...".print_r($eventid,TRUE));
      
      $details = $event['values'][$id];
      error_log("Details: ".print_r($details,TRUE));
      $this->_approved_status = $details['approved'];
      $this->setDefaults(array( 
          'id' => $details['id'],
          'event_id' => $id,
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
    $this->add('advcheckbox', 'approved', 'Approve Trial/Send Email',);
    $this->add('advcheckbox', 'approved2', 'Update Event Information',);
    $this->add('advcheckbox', 'submitMailing', 'Mail PL',);
    //$this->add('button', 'approved', );
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
    ['entity' => 'state_province','api' => ['params' => ['country_id' => 1039]]]);
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
    global $current_user;
    //error_log("Reload Action this array: ".print_r($this,TRUE));    
    $values = $this->exportValues();
    $$values = $this->exportValues();
    $eventid = $this->_eID;

     // add some error control
     error_log(print_r($values,TRUE));

    if ($values["_qf_TrialDetails_done"] == "1") {
      error_log("Current this array: ".print_r($values, TRUE));
      if($values['id'] != 0) {
        error_log("Executing an update of data");
		    $result = civicrm_api3('TrialAdmin', 'create', [
        'id' => $values['id'],
        'event_id' => $eventid, 
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
        //error_log("Returned value is: ".print_r($result,TRUE));
        
        $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
        $result = civicrm_api3('Trialadmin_log', 'create',[ 
          'trial_id' => $values['id'],
          'entity_id' => '200',
          'entity' => "Event Trial Details",
          'data' => "Updating trial details",
          'modified_id' => $cuser['contact_id'],
          'modified_date' => date('Y-m-d H:i:s'),
        ]);
        } else {
          // Create a new entry
          error_log("Executing a new create of data");
          $result = civicrm_api3('TrialAdmin', 'create', [
            'event_id' => $eventid, 
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
            $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
            $result = civicrm_api3('Trialadmin_log', 'create',[ 
              'trial_id' => $values['id'],
              'entity_id' => '210',
              'entity' => "Event Trial Details",
              'data' => "Adding trial details",
              'modified_id' => $cuser['contact_id'],
              'modified_date' => date('Y-m-d H:i:s'),
            ]);
        
        }
		  //error_log("Previous status was: ".$this->_approved_status);
      //error_log("Current status is: ".$values['approved']);
      
      if ($values['approved2'] == '1'){
        error_log("Trial Approved but no email!");
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
        }
        if (!in_array($values['trial_secretary'], $partic )) {
            $result = civicrm_api3('Participant', 'create', [
              'event_id' => $values['event_id'],
              'contact_id' => $values['trial_secretary'],
              'role_id' => "Trial Secretary",
            ]);
            array_push($partic, $values['trial_chairperson']);
        }
        $comp1 = civicrm_api3('TrialComponents', 'get', ['sequential' => 1, 'ta_id' => $values['id']]);
        $judges = $comp1['values'];
        foreach ($judges as $key=>$value) {
          if (!in_array($value['judge'], $partic)) {
            array_push($partic,$value['judge']);
            $result = civicrm_api3('Participant', 'create', [
              'event_id' => $values['event_id'],
              'contact_id' => $value['judge'],
              'role_id' => "Judge",
            ]);
          }
        }
        //Set event values - public, and new look Trial description
        $comp1=$comp1['values'];
        $date_ar = array();
        foreach ($comp1 as $component) {
          array_push($date_ar, $component['trial_date']);
        }
        error_log("dates: ".print_r($date_ar,TRUE));
        error_log('Max: ' . max($date_ar));
        error_log('Min: ' . min($date_ar));
        $start_date = min($date_ar);
        $finish_date = max($date_ar);
        $trial_chair = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_chairperson'],]);
        $trial_secretary = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_secretary'],]);
        error_log(print_r($trial_chair, TRUE));
        $template ->assign('trial_chairperson', $trial_chair);
        $template ->assign('trial_secretary', $trial_secretary);

        $durl = E::path('templates/CRM/Trialadmin/email/trialDescription.tpl');
        $descbody = (CRM_Core_Smarty::singleton()->fetch($durl));
        
        $result = civicrm_api3('Event', 'create', array(
          'id' => $values['event_id'],
          'is_public' => "1",
          'start_date' => $start_date,
          'end_date' => $finish_date,
          'description' => $descbody,
        ));

      }
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
          $params['from'] = 'Sporting Detection Dogs Association <info@sdda.ca>';
          $params['toName'] = $values['Requester_Name'].' '.$values['Requester_lastname'];
          $params['toEmail'] = $values['Requester_email'];
          $params['subject'] = 'Trial Approval';
          $params['text'] = '';
          $params['html'] = $emailbody;
          CRM_Utils_Mail::send($params);
          $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
          $result = civicrm_api3('Trialadmin_log', 'create',[ 
            'trial_id' => $values['id'],
            'entity_id' => '220',
            'entity' => "Event Trial Details",
            'data' => "Trial approved and updating trial details",
            'modified_id' => $cuser['contact_id'],
            'modified_date' => date('Y-m-d H:i:s'),
          ]);
  
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
          }
          if (!in_array($values['trial_secretary'], $partic )) {
              $result = civicrm_api3('Participant', 'create', [
                'event_id' => $values['event_id'],
                'contact_id' => $values['trial_secretary'],
                'role_id' => "Trial Secretary",
              ]);
              array_push($partic, $values['trial_chairperson']);
          }
          $comp1 = civicrm_api3('TrialComponents', 'get', ['sequential' => 1, 'ta_id' => $values['id']]);
          error_log("Stored values are: ".print_r($values,TRUE));
          $judges = $comp1['values'];
          foreach ($judges as $key=>$value) {
            if (!in_array($value['judge'], $partic)) {
              array_push($partic,$value['judge']);
              $result = civicrm_api3('Participant', 'create', [
                'event_id' => $values['event_id'],
                'contact_id' => $value['judge'],
                'role_id' => "Judge",
              ]);
            }
          }
          $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
          $result = civicrm_api3('Trialadmin_log', 'create',[ 
            'trial_id' => $values['id'],
            'entity_id' => '230',
            'entity' => "Event Trial Details",
            'data' => "Adding judge, host and secretary to participants list",
            'modified_id' => $cuser['contact_id'],
            'modified_date' => date('Y-m-d H:i:s'),
          ]);
  
          //Set event values - public, and new look Trial description
          $comp1=$comp1['values'];
          $date_ar = array();
          foreach ($comp1 as $component) {
            array_push($date_ar, $component['trial_date']);
          }
          error_log("dates: ".print_r($date_ar,TRUE));
          error_log('Max: ' . max($date_ar));
          error_log('Min: ' . min($date_ar));
          $start_date = min($date_ar);
          $finish_date = max($date_ar);
          $trial_chair = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_chairperson'],]);
          $trial_secretary = civicrm_api3('Contact', 'getsingle', ['sequential' => 1,'id' => $values['trial_secretary'],]);
          $template ->assign('trial_chairperson', $trial_chair);
          $template ->assign('trial_secretary', $trial_secretary);

          $durl = E::path('templates/CRM/Trialadmin/email/trialDescription.tpl');
          $descbody = (CRM_Core_Smarty::singleton()->fetch($durl));
          
          $result = civicrm_api3('Event', 'create', array(
            'id' => $values['event_id'],
            'is_public' => "1",
            'start_date' => $start_date,
            'end_date' => $finish_date,
            'description' => $descbody,
          ));



        } else {
          error_log("Trial UNapproved or cancelled");
          $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
          $result = civicrm_api3('Trialadmin_log', 'create',[ 
            'trial_id' => $values['id'],
            'entity_id' => '240',
            'entity' => "Event Trial Details",
            'data' => "Trial unapproved or cancelled",
            'modified_id' => $cuser['contact_id'],
            'modified_date' => date('Y-m-d H:i:s'),
          ]);
  
        }
      }
      if ($values['submitMailing'] == '1') {
        error_log("Submit mailing for distribution");

        $group_id = array();
        $params = array();
        #$group_id="13";
        $group_id[0]="1";
        $template = CRM_Core_Smarty::singleton();
        $province = civicrm_api3('state_province', 'getsingle', ['id'=>$values['Location_province']]);
        $template ->assign('province', $province);
       error_log(print_r($values, TRUE));
        foreach ($values as $key => $value) {
          $template->assign($key, $value);
        }
        $result = civicrm_api3('MessageTemplate', 'getsingle', array('id' => 68,));
        $result['msg_html'] = str_replace("{custom.host}",$values['hosting_club'],$result['msg_html']);
        $result['msg_html'] = str_replace("{custom.city}",$values['Location_city'],$result['msg_html']);
        $result['msg_html'] = str_replace("{custom.province}",$province['abbreviation'],$result['msg_html']);
        $event = civicrm_api3('Event', 'getsingle', array('id' => $eventid));
        $result['msg_html'] = str_replace("{custom.trial_start}",$event['start_date'],$result['msg_html']);
        $result['msg_html'] = str_replace(" 00:00:00",'',$result['msg_html']);
        $result['msg_html'] = str_replace("{custom.trial_end}",$event['end_date'],$result['msg_html']);
        $result['msg_html'] = str_replace("{custom.open_RP}",$event['custom_114'],$result['msg_html']);
        $result['msg_html'] = str_replace("{custom.open_general}",$event['custom_61'],$result['msg_html']);
        //$filedetail = civicrm_api3('Attachment', 'get', array('id' => $event['custom_115'],'return' => 'url', 'check_permissions' => 0));
        //$filedetail = $filedetail['values'];
        //$filedetail = $filedetail[$event['custom_115']];
        #error_log("File details: ".print_r($filedetail,TRUE)); 
        #error_log("URL ".$filedetail['url']);
        //$fileUrl = "<a href=".$filedetail['url'].">DOWNLOAD</a>";
        $url = '"'.'https://www.sdda.ca/civicrm/?civiwp=CiviCRM&q=civicrm%2Fevent%2Finfo&reset=1&id='.$eventid.'"';
        $fileUrl = '<a href='.$url.'>EVENT</a>';
        $result['msg_html'] = str_replace("{custom.PLLink}",$fileUrl,$result['msg_html']);
        $result['msg_html'] = str_replace(" 00:00:00",'',$result['msg_html']);
        error_log("Event details: ".print_r($event,TRUE));
        $params = [
          'sequential'         => 1,
          'created_id'         => $contact_id, 
          'created_date'       => date('Y-m-d H:i:s'),
          'scheduled_id'       => $contact_id,
          'scheduled_date'     => date('Y-m-d'),
          'approver_id'        => $contact_id,
          'approval_date'      => date('Y-m-d H:i:s'),
          'approval_status_id' => 1,
          'msg_template_id'    => 68,
          'subject'            => 'Sanctioned SDDA Trial Announcement - '.$values['Location_city'].', '.$province['name'],
          'name'               => 'SDDA Trial Announcement for '.$eventid,

          'body_html' => $result['msg_html'].' '.$event['description'],
          'body_text' => '', 
          'groups'             => [
            'include' => [
              '0' => 13,
            ],
            'exclude' => [
            ],
          ],
          'mailings'           => array(
            'include' => array(),
            'exclude' => array(),
          ),
          'unsubscribe_id'     => 5,  
          'optout_id'          => 7,  
          'resubscribe_id'     => 6,  
          'footer_id'          => 2,  
          'header_id'          => 1,  
          'open_tracking'      => 1,
        ];    
     #  error_log(print_r($params,TRUE));
        try{
          $result = civicrm_api3('Mailing', 'create', $params);
          error_log("Results from Mailing API CALL: ".print_r($result,TRUE));
        }
        catch (CiviCRM_API3_Exception $e) {
          // Handle error here.
          $errorMessage = $e->getMessage();
          $errorCode = $e->getErrorCode();
          $errorData = $e->getExtraParams();
          error_log("Error encountered! ".$error_Message." ".$errorCode." ".$errorData);

          return [
            'is_error' => 1,
            'error_message' => $errorMessage,
            'error_code' => $errorCode,
            'error_data' => $errorData,
          ];
        }     
        $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_users->display_name,]);                
        $result = civicrm_api3('Trialadmin_log', 'create',[ 
          'trial_id' => $values['id'],
          'entity_id' => '250',
          'entity' => "Event Trial Details",
          'data' => "Sending email to Registered Participants",
          'modified_id' => $cuser['contact_id'],
          'modified_date' => date('Y-m-d H:i:s'),
        ]);

      }
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
