{assign var="trialname" value=$form.trialname}
{assign var='logged' value=$form.logged}
<h3>Trial Log for {$trialname}</h3>
<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialLog" style='border-bottom: 1px solid black'><th>ID</th><th>Trial ID</th><th>Entity ID</th><th>Entity</th><th>Data</th><th>Modified ID</th><th>Modified Date</th></tr>

{foreach from=$logged.values item=value}
<td>{$value.id}</td>
<td>{$value.trial_id}</td>
<td>{$value.entity_id}</td>
<td>{$value.entity}</td>
<td>{$value.data}</td>
<td>{$value.modified_id}</td>
<td>{$value.modified_date}</td></tr>
{/foreach}
</table>
