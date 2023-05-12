<?php

use CRM_Trialadmin_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://docs.civicrm.org/dev/en/latest/framework/quickform/
 */
class CRM_Trialadmin_Form_CheckRP extends CRM_Core_Form {

  public function preProcess() {
  
    CRM_Utils_System::setTitle(E::ts('Registered Participant Check'));
    global $current_user;
    #error_log(print_r($current_user,TRUE));
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
    $params = array('email' => $current_user->user_email,'display_name' => $current_user->display_name);
    $cuser = get_single_contact($params);
    write_log($params);
    write_log($cuser);
    $params = array('sequential' => 1,'contact_id.id' => $cuser['contact_id']);
    $result = get_single_member($params);
    write_log($params);
    write_log($result);
//    $cuser = civicrm_api3('Contact', 'getsingle', ['email' => $current_user->user_email,'display_name' => $current_user->display_name,]);
//    $result = civicrm_api3('Membership', 'get', ['sequential' => 1,'contact_id.id' => $cuser['contact_id'],]);

    if ( $cuser['is_error'] == 1 OR $result['is_error'] == 1)  {
      $message = "You must be an active trial host or secretary to use this feature";
      $title="Not an Active Registered Participant";
      $type="Error";
      CRM_Core_Session::setStatus($message, $title, $type,);
      $location = get_site_url()."/my-registered-participant-status/";
      #wp_redirect( $location, 301 );
      header ("Refresh: 2;URL='$location'"); 
    }
    $resultdetails = $result['values']['0'];
    $params = array('trial_chairperson' => $cuser['contact_id'], 'return' => 'event_id.start_date',);
    $chair = get_trialadmin($params);
    $params = array('trial_secretary' => $cuser['contact_id'], 'return' => 'event_id.start_date');
    $secretary = get_trialadmin($params);
    if ($chair['count'] == 0 && $secretary['count'] == 0 ) {
      $message = "You must be an active trial host or secretary to use this feature";
      $title="Not an Active Trial host or Secretary";
      $type="Error";
      CRM_Core_Session::setStatus($message, $title, $type,);
      $location = get_site_url();
      #wp_redirect( $location, 301 );
      header ("Refresh: 2;URL='$location'"); 
    }
    write_log($chair);
    write_log($secretary);
  }

  public function buildQuickForm() {
    $this->add('textarea', 'rpnums', 'Registered Participant Numbers',TRUE);  

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
    // Generate output based on input
    $result = check_rp_status($values['rpnums']);
    
    parent::postProcess();
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
