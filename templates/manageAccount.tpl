{include file='header.tpl'}

<h1>Ikke fornøyd med din bruker?</h1>

<div class="row">
    <div class="col-sm-8 col-md-6 col-lg-4">
        <form method="POST">
            <div class="form-group">
                <input type="text" id="inputUsername" class="form-control" placeholder="Nytt Brukernavn" maxlength="45" required autofocus>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnChangeUsername" value="Bytt Brukernavn" />
        </form>
        <form method="POST">
            <div class="form-group">
                <div class="form-group {$passwordCSS|default:''}">
                    <input type="password" name="inputPassword"  class="form-control" placeholder="Nytt Passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn required>
                </div>
                <div class="form-group {$passwordCSS|default:''}">
                    <input type="password" name="inputPasswordRepete"  class="form-control" placeholder="Gjenta Nytt passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn" required>
                </div>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnNewPassword" value="Bytt Passord" />
        </form>
    </div>
</div>



{include file='footer.tpl'}