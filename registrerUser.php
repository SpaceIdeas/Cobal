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
<?php
require_once ('db.php');
require_once('classes/User.class.php');
require_once('libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->display('registrerUser.tpl');
if (isset($_POST['btnRegisterUser'])) {
    echo 'hello';
   echo User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputName']);
}
?>