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
  }
{/literal}
</script>

<script language="JavaScript" type="text/javascript">
{literal}
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
{/literal}
</script>

<div class="help">
      <p><strong>Welcome to the new Trial Application process!</strong></p>
      
      <p><strong>Please read these instructions completely before continuing.</strong><br>
      Please review the "Hosting a Trial" page for valuable information before you apply.<br>
      1. Complete the information on the screen about you, the location where you intend on holding the trial, and who is running it.<br>
      2. Click Add Component and tell us about each day you intend on having a trial - date, judge, and component.<br>
         For a multi day or multi judge trial, you would add a new component for each.<br>
         NOTE: It can take a moment to open the Add Component screen - please be patient!<br>
      3. When completed, click on the "Submit" button to finish up.<br>
      4. Submit payment either through email transfer to stacey@sdda.ca or via the store at https://www.sdda.ca/product/trial-application-fee-for-trial-hosts/<br>
         Please remember the fee is the number of trial days x $50.<br>
         An SDDA trial is defined as a single offering of any Level within a 12-hour period and will be assigned a unique trial number.<br>
      5. Wait for the SDDA To get back to you on your approvals</p>
    </div>

<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
  {foreach from=$elementNames item=elementName}
    {if $form.$elementName.label != ''} 
      <div class="crm-section">
      <div class="label">{$form.$elementName.label}</div>
      <div class="content">{$form.$elementName.html}</div>
      <div class="clear"></div>
      </div>
    {/if}
  {/foreach}
{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}
{if $form.id.value != ''}
  <h3>Trial Components</h3>
  <table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="TrialComponents" style='border-bottom: 1px solid black'><th>Trial Date</th><th>Judge</th><th>Started</th><th>Advanced</th><th>Excellent</th><th>Elite Offered</th><th>Games</th></tr>
  {crmAPI var='result' entity='TrialComponents' action='get' ta_id = $form.id.value}
  {foreach from=$result.values item=component}
    {crmAPI var='judge' entity='Contact' action='getsingle' contact_id = $component.judge}
    <tr><td>{$component.trial_date}</td>
    <td>{$judge.display_name}</td>
    <td>{$component.started_components}</td>
    <td>{$component.advanced_components}</td>
    <td>{$component.excellent_components}</td>
    <td>{$component.elite_offered}</td>
    <td>{$component.games_components}</td>
    <td><a href='{crmURL p="civicrm/addcomponent" q="reset=1&action=update&id=`$component.id`"}' class="crm-popup"> Edit </a><a href="javascript:deleteComponent({$component.id})"> Delete </a></td></tr>
  {/foreach}
  </a>
  </table>
{/if}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
