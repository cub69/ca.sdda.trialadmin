{* HEADER *}
{literal}
<script language="JavaScript" type="text/javascript">
function inactivateDog(id){
  var nowDate = new Date(); 
  var date = nowDate.getFullYear()+'-'+(nowDate.getMonth())+'-'+nowDate.getDate();
  CRM.api3('RegisteredDogs', 'create', {
    "id": id,
    "inactive_date": date(),
  }).then(function(result) {
    console.log("Inactivated")
  }, function(error) {
    // oops
  });
  
}
</script>
{/literal}

<div class="help">
      <p><strong>Registered Dogs and Cards</strong></p>
      <br>
      <p> Welcome to your registered dogs listing.  We have added a feature for you to inactivate a dog.  There are many reasons you would want to do this, the dog is retired from the sport, or has passed away.  Inactivating will prevent the dog from being listed on these pages, but does not ever delete the dog and their earned titles.</p>
      
    </div>

<h3>Registered Dogs</h3>
<table border='1' cellpadding='5' cellspacing='5'><tr class="crm-entity" id="Dogs" style='border-bottom: 1px solid black'><th>Dog Number</th><th>Registered Name</th><th>Call Name</th><th>Date of Birth</td></tr>
{crmAPI var='dogs' entity='RegisteredDogs' action='get' contact_id = $contactid}

{foreach from=$dogs.values item=dog}
  {if $dog.inactive_date == ''}
    <tr><td>{$dog.id}</td>
    <td>{$dog.registered_name}</td>
    <td>{$dog.call_name}</td>
    <td>{$dog.date_of_birth}</td>
    <td><a href='siteUrl("/dog-card")' class="crm-popup"><small> Inactivate </small></a></td></tr>
  {/if}
{/foreach}
</table>
{* FOOTER *}
