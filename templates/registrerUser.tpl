{include file='header.tpl'}
<h1>Registrer deg som ny bruker</h1>
<div class="container">
    <form method="POST">
        <input type="text" name="inputName" class="form-control" placeholder="Brukernavn" required autofocus>
        <label for="inputEmail" class="sr-only">E-post</label>
        <input type="email" name="inputEmail" class="form-control" placeholder="E-post" required>
        <label for="inputPassword" class="sr-only">Passord</label>
        <input name="inputPassword" type="password"  class="form-control" placeholder="Password" required>
        <input type="submit" name="btnRegisterUser" value="Register"/>
    </form>
</div> <!-- /container -->
{include file='footer.tpl'}