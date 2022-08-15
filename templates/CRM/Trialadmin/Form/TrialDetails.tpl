{* HEADER *}
<script language="JavaScript" type="text/javascript">
{literal}
CRM.$(function($) {
  var active = 'a.button, a.action-item:not(.crm-enable-disable), a.crm-popup';
  $('#crm-main-content-wrapper')
    // Widgetize the content area
    .crmSnippet()
    // Open action links in a popup
    .off('.crmLivePage')
    .on('click.crmLivePage', active, CRM.popup)
    .on('crmPopupFormSuccess.crmLivePage', active, CRM.refreshParent);
});
{/literal}
</script>

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="top"}
</div>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}
{foreach from=$elementNames item=elementName}
    {if $elementName != 'id' && $elementName != 'event_id'} 
      <div class="crm-section">
      <div class="label">{$form.$elementName.label}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
      </div>
    {/if}  
{/foreach}
{literal}
  <script language="JavaScript" type="text/javascript">
  function deleteComponent(id){
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

{if !empty($form.event_id.value)}
<h3>Trial Components</h3>
<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialComponents" style='border-bottom: 1px solid black'><th>Trial Number</th><th>Trial Date</th><th>Judge</th><th>Started</th><th>Advanced</th><th>Excellent</th><th>Elite Offered</th><th>Games</th></tr>
{crmAPI var='result' entity='TrialComponents' action='get' ta_id = $form.id.value}
{foreach from=$result.values item=component}
{crmAPI var='judge' entity='Contact' action='getsingle' contact_id = $component.judge}
<tr><td>{$component.trial_number}</td>
<td>{$component.trial_date}</td>
<td>{$judge.display_name}</td>
<td>{$component.started_components}</td>
<td>{$component.advanced_components}</td>
<td>{$component.excellent_components}</td>
<td>{$component.elite_offered}</td>
<td>{$component.games_components}</td>
<td><a href='{crmURL p="civicrm/EditComponent" q="reset=1&action=update&eventid=`$form.event_id.value`&id=`$component.id`"}' class="crm-popup"> Edit </a><a href="javascript:deleteComponent({$component.id})"> Delete </a></td></tr>
{/foreach}
{/if}
<a title="Add a Component" class="button_name button crm-popup" href='{crmURL p="civicrm/EditComponent" q="reset=1&action=add&eventid=`$form.event_id.value`&id=`$form.id.value`"}'>
  <span>Add Component</span>
</a>

{* FOOTER *}
