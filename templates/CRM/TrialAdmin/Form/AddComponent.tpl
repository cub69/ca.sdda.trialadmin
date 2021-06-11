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
{/literal}</script>

{* FIELD EXAMPLE: OPTION 1 (AUTOMATIC LAYOUT) *}

{foreach from=$elementNames item=elementName}
  {if $elementName != 'id' && $elementName != 'event_id' && $elementName != 'trial_number'}
    <div class="crm-section">
    <div class="label">{$form.$elementName.label}</div>
    <div class="content">{$form.$elementName.html}</div>
    <div class="clear"></div>
    </div>
  {/if}
{/foreach}

{* FOOTER *}
<div class="crm-submit-buttons">
{include file="CRM/common/formButtons.tpl" location="bottom"}
</div>
