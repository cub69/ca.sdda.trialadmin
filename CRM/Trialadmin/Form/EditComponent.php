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
public $_event_id;

  public function preProcess() {
	// do prep work  
//$this->preventAjaxSubmit();

	CRM_Utils_System::setTitle(E::ts('Edit Component'));
	$this->_action = CRM_Utils_Request::retrieve('action', 'String', $this);	
	error_log($this->_action);
  if ($this->_action == 2) {
		$this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
		$components = civicrm_api3('TrialComponents', 'get', ['id' => $this->_id,]);
		$component = $component['values'][$this->_id];

		$this->setDefaults(array( 
        'event_id' => $component('event_id'),
        'trial_number' => $component('trial_number'),
        'trial_date' => $component('trial_date'),
        'judge' => $component('judge'),
//        'started_components' => $component('started_components'),
//        'advanced_components' => $component('advanced_components'),
//        'excellent_components' => $component('excellent_components'),
//        'elite_offered' => $component('elite_offered'),
//        'games_components' => $component('games_components'),
		));
	} elseif ($this->_action == 1) {
		$this->_id = CRM_Utils_Request::retrieve('id', 'Positive', $this, TRUE);
	}
}

  public function buildQuickForm() {
	  
	 // add form elements
   $this->add(
		'int unsigned',
		'trial_number',
		ts('Component Date'),
      TRUE
	  );
   $this->add(
		'date',
		'Trial_Date',
		ts('Trial Date'),
      CRM_Core_SelectValues::date(NULL, 'Y M d',15,1)
	  );
    $this->add(
      'text',
      'judge',
      'Judge',
      TRUE
    );
/*    $this->add(
      'multiselect',
      'started_components',
      'Started Components',
      $this->getOptions("Reg_components"),
      TRUE
    );
    $this->add(
      'multiselect',
      'advanced_components',
      'Advanced Components',
      $this->getOptions("Reg_components"),
      TRUE
    );
    $this->add(
      'multiselect',
      'excellent_components',
      'Excellent Components',
      $this->getOptions("Reg_components"),
      TRUE
    );
    $this->add(
      'checkbox',
      'elite_offered',
      'Elite Offered',
      TRUE
    );
    $this->add(
      'multiselect',
      'games_components',
      'Games Components',
      $this->getOptions("Game_components"),
      TRUE
    );  
	*/
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

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  public function postProcess() {
      $values = $this->exportValues();
      var_error_log($values);
        
    if ($values["_qf_EditComponent_submit"] = "Submit") {
		error_log("Executing a save/update of data");
	  if ($this->_action == 2){
    	$values["id"] = $this->_id;
		$result = civicrm_api3('TrialComponents', 'create', [
		'id' 	=> $values['id'],
    'event_id' => $values['event_id'],
		'trial_number' => $values['trial_number'],
		'trial_date' => $values['trial_date'],
    'judge' => $values['judge'],
 //   'started_components' => $values['started_components'],
 //   'advanced_components' => $values['advanced_components'],
 //   'excellent_components' => $values['excellent_components'],
 //   'elite_offered' => $values['elite_offered'],
 //   'games_components' => $values['games_components'],
		
		]); 
		var_error_log($result);
	 } elseif ($this->_action == 1) {
    $result = civicrm_api3('TrialComponents', 'create', [
      'id' 	=> $values['id'],
      'event_id' => $values['event_id'],
      'trial_number' => $values['trial_number'],
      'trial_date' => $values['trial_date'],
      'judge' => $values['judge'],
 //     'started_components' => $values['started_components'],
 //     'advanced_components' => $values['advanced_components'],
 //     'excellent_components' => $values['excellent_components'],
 //     'elite_offered' => $values['elite_offered'],
 //     'games_components' => $values['games_components'],
    ]) ;
		var_error_log($result);

   }
}

     parent::postProcess();
  }

  public function getOptions($optionType) {
  	if ($optionType =="regComponents") {
    	$options = array(
      '' => E::ts('- select -'),
      'Containers' => E::ts('Containers'),
      'Interior' => E::ts('Interior'),
      'Exterior-vehicles' => E::ts('Exterior-vehicles'),
      'Exterior-area' => E::ts('Exterior-area'),
    	);
 		return $options;
   
   	if ($optionType =="GamesComponents") {
    	$options = array(
      '' => E::ts('- select -'),
      'Distance' => E::ts('Distance'),
      'Speed' => E::ts('Speed'),
      'Team' => E::ts('Team'),
      'Aerial' => E::ts('Aerial'),
    	);
 		return $options;
     }
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
