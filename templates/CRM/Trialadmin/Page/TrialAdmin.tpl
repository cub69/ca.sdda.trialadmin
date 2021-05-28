<h3>Trial Administration</h3>
<a title="Add Trial Details" class="button_name button crm-popup" href="{$url}&reset=1">
  <span>Add Trial Details</span>
</a>
{literal}
<script language="JavaScript" type="text/javascript">
function deleteTrialDetails(id){
   CRM.alert("We are deleting the trial details!")
   CRM.confirm()
  .on('crmConfirm:yes', function() {
  		CRM.api4('Trialadmin', 'delete', {
  "id": id
	}).done(function(result) {
  		CRM.alert("Trial Details are deleted");
		CRM.refresh;
	});
  })
  .on('crmConfirm:no', function() {
  // Don't do something
  });
}
</script>

{/literal} 

<p>The current time is {$currentTime}</p>
{crmAPI var='result' entity='TrialAdmin' action='get' event_id=$id}

{foreach from=$result.values item=trialdetails}
<p>Event ID {$trialdetails.event_id}</p>
<h3>Requester and Location Details</h3>
<p>Hosting Club:    {$trialdetails.hosting_club}</p>

{/foreach}

