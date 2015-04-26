<!-- For å bruke alert beskjeder er det pare å includere denne templeten hvor du vil ha beskjedene
  og bare assigne beskjeden du vil komme med i successMessage eller errorMessage-->
{if isset($successMessage)}
    <div class="alert alert-success alert-dismissible" role="alert">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        {$successMessage}
    </div>
{/if}
{if isset($errorMessage)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        {$errorMessage}
    </div>
{/if}