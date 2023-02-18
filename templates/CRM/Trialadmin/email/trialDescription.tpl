<hr />
<p>This is a sanctioned Sporting Detection Dogs Association trial.</p>

Location:
<strong><p>&nbsp;{$Location_name}<br>
{$Street_address}<br>
{$Location_city}<br>
{$province.name}<br></p>
</strong>

<p>&nbsp;Your trial chairperson is <strong>{$trial_chairperson.display_name}</strong> {mailto address=$trial_chairperson.email}, and the trial secretary is <strong>{$trial_secretary.display_name}</strong> {mailto address=$trial_secretary.email}.  Please contact them if you have any questions.</p>


<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialComponents" style='border-bottom: 1px solid black'><th>Trial Number</th><th>Trial Date</th><th>Judge</th><th>Started</th><th>Advanced</th><th>Excellent</th><th>Elite Offered</th><th>Games</th></tr>
{crmAPI var='result' entity='TrialComponents' action='get' event_id = $event_id}
<tbody>
	{foreach from=$result.values item=component}
		{crmAPI var='judge' entity='Contact' action='getsingle' contact_id = $component.judge}
		<tr><td>{$component.trial_number}</td>
		<td>{$component.trial_date}</td>
		<td>{$judge.display_name}</td>
		<td>{$component.started_components}</td>
		<td>{$component.advanced_components}</td>
		<td>{$component.excellent_components}</td>
		<td>{$component.elite_offered}</td>
		<td>{$component.games_components}</td></tr>
	{/foreach}
</tbody>
</table>

<p><span style="color: #0000ff;"><u><a href="mailto:info@sportingdetectiondogs.ca"><span>info@sportingdetectiondogs.ca</span></a></u></span></p>
