{include file="header.tpl"}

{if isset($loginSucsess) && $loginSucsess == false}
    <div class="alert alert-danger" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="sr-only">Error:</span>
        Login failed
    </div>
{/if}
<div class="row">
    <div class="col-sm-3 col-md-6 col-lg-4">
        <form class="form-signin" method="post">
            <h2 class="form-signin-heading">Please log in</h2>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus >
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" class="form-control" placeholder="Password" required>
            <input class="btn btn-lg btn-primary btn-block" type="submit" name="action"  value="Login" />
        </form>
    </div>
</div>
{include file="footer.tpl"}

