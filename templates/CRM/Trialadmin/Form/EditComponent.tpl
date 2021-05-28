{* HEADER *}

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>
<h3>Trial Components</h3>
{literal}
<script language="JavaScript" type="text/javascript">
function deleteComponent(id){
//   CRM.alert("The dog number is\n" + id,"Delete Dog")
   CRM.confirm()
  .on('crmConfirm:yes', function() {
  		CRM.api3('TrialComponents', 'delete', {
  "id": id
	}).done(function(result) {
  		CRM.alert("Component is deleted");
		CRM.refresh;
	});
  })
  .on('crmConfirm:no', function() {
    // Don't do something
  });
}
</script>
{/literal}
<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialComponents" style='border-bottom: 1px solid black'><th>id</th><th>Event ID</th><th>Trial Number</th><th>Trial Date</th><th>Judge</th><th>Started</th><th>Advanced</th><th>Excellent</th><th>Elite Offered</th><th>Games</th></tr>
{crmAPI var='result' entity='TrialComponents' action='get' event_id = $event_id}
{foreach from=$result.values item=component}
<td>{$component.id}</td>
<td >{$component.event_id}</td>
<td>{$component.trial_number}</td>
<td>{$component.trial_date}</td>
<td>{$component.judge}</td>
<td>{$component.started_components}</td>
<td>{$component.advanced_components}</td>
<td>{$component.excellent_components}</td>
<td>{$component.elite_offered}</td>
<td>{$component.games_components}</td>
<td><a href="https://www.sportingdetectiondogs.ca/wp-admin/admin.php?page=CiviCRM/civicrm/EditComponent?reset=1&action=update&id={$component.id}" class="crm-popup"> Edit </a><a href="javascript:deleteComponent({$component.id})"> Delete </a></td></tr>
{/foreach}
<a title="Add a Component" class="button_name button crm-popup" href="https://www.sportingdetectiondogs.ca/wp-admin/admin.php?page=CiviCRM/civicrm/EditComponent?reset=1&action=add&id={$event_id}">
  <span>Add Component</span>
</a>


{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
