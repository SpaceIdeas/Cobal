{include file="header.tpl"}

<h1>Vennligst log inn</h1>
<br/>

{include file="alert.tpl"}

<div class="row">
    <div class="col-sm-3 col-md-6 col-lg-4">
        <form class="form-signin" method="post">
            <div class="form-group">
                <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus >
            </div>
            <div class="form-group">
                <input type="password" name="inputPassword" class="form-control" placeholder="Password" pattern=".{literal}{5,45}{/literal}" required>
            </div>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="action"  value="Login" />
        </form>
    </div>
</div>
{include file="footer.tpl"}

