{include file='header.tpl'}
<h1>Administrer brukerkontoer</h1>
<h3>Administratorer</h3>
<table class="table-bordered">
    <tr>
        <th>Brukernavn</th><th>E-postadresse</th><th>Gjør normal</th>
    </tr>
    {foreach from=$admins item=admin}
        {include file = 'admin.tpl'}
    {/foreach}
</table>
<h3>Ikke-administratorer</h3>
<table class="table-bordered">
    <tr>
        <th>Brukernavn</th><th>E-postadresse</th><th>Gjør administrator</th>
    </tr>
    {foreach from=$nonAdmins item=nonAdmin}
        {include file = 'nonAdmin.tpl'}
    {/foreach}
</table>
{include file='footer.tpl'}