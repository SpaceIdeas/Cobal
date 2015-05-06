{include file='header.tpl'}

<h1>Ikke fornøyd med din bruker?</h1>
<p>
    <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-4">
            <div class="panel panel-default">
                <form method="POST">
                    <div class="form-group">
                        <input type="text" name="inputUsername" class="form-control" placeholder="Nytt Brukernavn" maxlength="45" required autofocus>
                    </div>
                    <input class="btn btn-primary btn-block" type="submit" name="btnNewUsername" value="Bytt Brukernavn" />
                </form>
            </div>
            <div class="panel panel-default">
                <form method="POST">
                    <div class="form-group {$passwordCSS|default:''}">
                        <input type="password" name="inputPassword"  class="form-control" placeholder="Nytt Passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn" required>
                    </div>
                    <div class="form-group {$passwordCSS|default:''}">
                        <input type="password" name="inputPasswordRepete"  class="form-control" placeholder="Gjenta Nytt passord" pattern=".{literal}{6,45}{/literal}" title="Passordet må være minst 6 tegn" required>
                    </div>
                    <input class="btn btn-primary btn-block" type="submit" name="btnNewPassword" value="Bytt Passord" />
                </form>
            </div>
            <div class="panel panel-default">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" name="MAX_FILE_SIZE" value="100000000000000">
                        <label for="profileImage">Profilbilde:</label>
                        <input name="profileImage" id="profileImage" TYPE="file" accept="image/*" >
                    </div>
                    <input class="btn btn-primary btn-block" type="submit" name="btnUpdatePicture" value="Oppdater profilbilde" />
                </form>
            </div>
        </div>
    </div>
</p>


{include file='footer.tpl'}