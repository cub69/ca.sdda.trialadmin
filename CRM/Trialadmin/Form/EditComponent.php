<?php

use CRM_TrialAdmin_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */ 
class CRM_TrialAdmin_Form_EditComponent extends CRM_Core_Form {

  public $_id;
  public $_action;
  //public $_event_id;

  public function preProcess() {
	  // do prep work  
    $this->preventAjaxSubmit();

	  CRM_Utils_System::setTitle(E::ts('Edit Component'));
	  $this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);	
	  error_log("The action of this record is: ".$this->_action);
    
    if ($this->_action == 2) {
      $this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
      error_log("The ID of this record is: ".$this->_id);
      $components = civicrm_api3('TrialComponents', 'get', ['id' => $this->_id,]);
      
        $component = $components['values'][$this->_id];
        error_log(print_r($component,TRUE));
        $this->setDefaults(array( 
            'event_id' => $component['event_id'],
            'trial_number' => $component['trial_number'],
            'trial_date' => $component['trial_date'],
            'judge' => $component['judge'],
            'started_components' => $component['started_components'],
            'advanced_components' => $component['advanced_components'],
            'excellent_components' => $component['excellent_components'],
            'elite_offered' => $component['elite_offered'],
            'games_components' => $component['games_components'],
        ));
        //error_log('Started components: '. print_r($component['started_components'], TRUE));
    } elseif ($this->_action == 1) {
          error_log("processing as new");    
          $this->_eventid = CRM_Utils_Request::retrieve('eventid', 'Positive', $this, TRUE);
          $this->setDefaults(array( 
            'event_id' => $this->_eventid,
          ));
          error_log("processing as new completed setting defaults");
      }
  }

  public function buildQuickForm() {
	  
	 // add form elements
   $this->add('text','event_id','Event ID', TRUE);
   $this->add('text','trial_number','Trial Number',TRUE);
   $this->add('datepicker','trial_date', ts('Trial Date'), array('class' => 'some-css-class'), TRUE, array('time' => FALSE, 'date' => 'mm-dd-yy', 'minDate' => '2021-01-01') );
  
   //$this->add('date','Trial_Date',ts('Trial Date'),CRM_Core_SelectValues::date(NULL, 'Y M d',0,1) );
    $this->addEntityRef('judge',ts('Assigned Judge'),['api' => ['params' => ['group' => 'Judges_4']]],);
    $this->add('select', 'started_components', ts('Started Components'), $this->getOptions("regComponents"), FALSE,
        array('id' => 'started_components', 'multiple' => 'multiple', 'class' => 'crm-select2 huge'));
    $this->add('select', 'advanced_components', ts('Advanced Components'), $this->getOptions("regComponents"), FALSE,
        array('id' => 'advanced_components', 'multiple' => 'multiple', 'class' => 'crm-select2 huge'));
    $this->add('select', 'excellent_components', ts('Excellent Components'), $this->getOptions("regComponents"), FALSE,
        array('id' => 'excellent_components', 'multiple' => 'multiple', 'class' => 'crm-select2 huge'));
    $this->add('checkbox','elite_offered','Elite Offered',FALSE);
    $this->add('select', 'games_components', ts('Games Components'), $this->getOptions("gameComponents"), FALSE,
        array('id' => 'games_components', 'multiple' => 'multiple', 'class' => 'crm-select2 huge'));
    
    $this->addButtons(array(
      array(
        'type' => 'done',
        'name' => E::ts('Submit'),
        'isDefault' => FALSE,
      ),
      array(
        'type' => 'cancel',
        'name' => E::ts('Cancel'),
        'isDefault' => TRUE,
      ),
      
    ));
    error_log("Entering the quickform after build");
    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
    $values = $this->exportValues();
    error_log("Post processing ...".print_r($values, TRUE));
    $started_components = '';
    $advanced_components = '';
    $excellent_components = '';
    $games_components = '';
    foreach ($values['started_components'] as $value) {$started_components .= $value.' '; }
    foreach ($values['advanced_components'] as $value) {$advanced_components .= $value.' '; }
    foreach ($values['excellent_components'] as $value) {$excellent_components .= $value.' '; }
    foreach ($values['games_components'] as $value) {$games_components .= $value.' '; }
    $id = $this->_id;
    if ($values["_qf_EditComponent_submit"] = "Submit") {
  	  if ($this->_action == 2){
      	$values["id"] = $this->_id;
		    $result = civicrm_api3('TrialComponents', 'create', [
		      'id' 	=> $values['id'],
          'event_id' => $values['event_id'],
		      'trial_number' => $values['trial_number'],
		      'trial_date' => $values['trial_date'],
          'judge' => $values['judge'],
          'started_components' => $started_components,
          'advanced_components' => $advanced_components, 
          'excellent_components' => $excellent_components,
          'elite_offered' => $values['elite_offered'],
          'games_components' => $games_components,
		    ]); 
	    } elseif ($this->_action == 1) {
        $result = civicrm_api3('TrialComponents', 'create', [
          //'id' 	=> $values['id'],
          'event_id' => $values['event_id'],
          'trial_number' => $values['trial_number'],
          'trial_date' => $values['trial_date'],
          'judge' => $values['judge'],
          'started_components' => $started_components,
          'advanced_components' => $advanced_components,
          'excellent_components' => $excellent_components,
          'elite_offered' => $values['elite_offered'],
          'games_components' => $games_components,
        ]) ;
      }
    }
    $url = CRM_Utils_System::url( 'civicrm/event/manage/settings', "reset=1&force=1&action=update&id=$id" );
    CRM_Core_Session::singleton()->pushUserContext($url);
  }

  public function getOptions($optionType) {
    if ($optionType =="gameComponents") {
    	$goptions = array(
      'Distance' => E::ts('Distance'),
      'Speed' => E::ts('Speed'),
      'Team' => E::ts('Team'),
      'Aerial' => E::ts('Aerial'),
    	);
 		return $goptions;
     } 
  	if ($optionType =="regComponents") {
    	$options = array(
      'Containers' => E::ts('Containers'),
      'Interior' => E::ts('Interior'),
      'Exterior-vehicles' => E::ts('Exterior-vehicles'),
      'Exterior-area' => E::ts('Exterior-area'),
    	);
 		return $options;	
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
