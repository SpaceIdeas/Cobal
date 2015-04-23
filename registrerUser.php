<?php
require_once('libs/Smarty.class.php');
require_once ('config.php');
require_once ('db.php');
$smarty = new Smarty();
$smarty->display('registrerUser.php');
if (isset($_POST['btnRegisterUser']))
{

    User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputName']);
}
?>