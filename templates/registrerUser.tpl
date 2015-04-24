{include file='header.tpl'}
<h1>Registrer deg som ny bruker</h1>
<br/>

{if isset($successMessage)}
    <div class="alert alert-success" role="alert">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        {$successMessage}
    </div>
{/if}
{if isset($errorMessage)}
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        {$errorMessage}
    </div>
{/if}


    <form method="POST">
        <div class="form-group">
            <input type="text" name="inputUsername" class="form-control" value="{$inputUsername|default:''}" placeholder="Brukernavn" maxlength="45" required autofocus>
        </div>
        <div class="form-group {$emailCSS|default:''}">
            <input type="email" name="inputEmail" class="form-control" value="{$inputEmail|default:''}" placeholder="E-post" maxlength="45" required>
        </div>
        <div class="form-group {$passwordCSS|default:''}">
            <input type="password" name="inputPassword"  class="form-control" placeholder="Passord" pattern=".{literal}{5,45}{/literal}" required>
        </div>
        <div class="form-group {$passwordCSS|default:''}">
             <input type="password" name="inputPasswordRepete"  class="form-control" placeholder="Gjenta passord" maxlength="45" required>
        </div>
        <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnRegisterUser" value="Register" />
    </form>

{include file='footer.tpl'}