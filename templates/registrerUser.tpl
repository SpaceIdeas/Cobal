{include file='header.tpl'}
<h1>Registrer deg som ny bruker</h1>
<br/>
<div class="row">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <form method="POST">
            <div class="form-group">
                <input type="text" name="inputUsername" class="form-control" value="{$inputUsername|default:''}" placeholder="Brukernavn" maxlength="45" required autofocus>
            </div>
            <div class="form-group {$emailCSS|default:''}">
                <input type="email" name="inputEmail" class="form-control" value="{$inputEmail|default:''}" placeholder="E-post" maxlength="45" required>
            </div>
            <div class="form-group {$passwordCSS|default:''}">
                <input type="password" name="inputPassword"  class="form-control" placeholder="Passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn" required>
            </div>
            <div class="form-group {$passwordCSS|default:''}">
                 <input type="password" name="inputPasswordRepete"  class="form-control" placeholder="Gjenta passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn" required>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnRegisterUser" value="Register" />
        </form>
    </div>
</div>
{include file='footer.tpl'}