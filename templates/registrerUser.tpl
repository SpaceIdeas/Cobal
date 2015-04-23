{include file='header.tpl'}
<h1>Registrer deg som ny bruker</h1>
<div class="container">
    <div class="jumbotron">
        <h1>Øysteins CMS</h1>
        <p>When Wordpress isn't enough</p>
    </div>
</div>
<div class="container">
    <form method="POST">
        <input type="text" name="inputName" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input name="inputPassword" type="password"  class="form-control" placeholder="Password" required>
        <input type="submit" name="btnRegisterUser" value="Register"/>
    </form>

</div> <!-- /container -->
{include file='footer.tpl'}