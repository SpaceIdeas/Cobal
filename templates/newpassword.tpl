{include file='header.tpl'}
<div class="row">
    <div class="col-sm-3 col-md-6 col-lg-4">
        <form method="POST">
            <div class="form-group">
                <input type="password" name="inputPassword"  class="form-control" placeholder="Passord" pattern=".{literal}{5,45}{/literal}" required>
            </div>
            <div class="form-group">
                <input type="password" name="inputPasswordRepeat"  class="form-control" placeholder="Gjenta passord" pattern=".{literal}{5,45}{/literal}" required>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="btnNewPassword" value="Opprett nytt passord" />
        </form>
    </div>
</div>
{include file='footer.tpl'}