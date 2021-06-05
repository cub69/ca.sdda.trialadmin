{* HEADER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

  <table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialComponents" style='border-bottom: 1px solid black'><th>Trial Number</th><th>Trial Date</th><th>Judge</th><th>Started</th><th>Advanced</th><th>Excellent</th><th>Elite Offered</th><th>Games</th></tr>
  {crmAPI var='result' entity='TrialComponents' action='get' event_id = $form.event_id.value}

  {foreach from=$result.values item=component}
  <td>{$component.trial_number}</td>
  <td>{$component.trial_date}</td>
  <td>{$component.judge}</td>
  <td>{$component.started_components}</td>
  <td>{$component.advanced_components}</td>
  <td>{$component.excellent_components}</td>
  <td>{$component.elite_offered}</td>
  <td>{$component.games_components}</td>
  <td><a href='{crmURL p="civicrm/EditComponent" q="reset=1&action=update&id=`$component.id`"}' class="crm-popup"> Edit </a><a href="javascript:deleteComponent({$component.id})"> Delete </a></td></tr>
  {/foreach}
  <a title="Add a Component" class="button_name button crm-popup" href='{crmURL p="civicrm/EditComponent" q="reset=1&action=add&eventid=`$form.event_id.value`"}'>
    <span>Add Component</span>
  </a>
{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
