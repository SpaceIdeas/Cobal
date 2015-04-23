<?php
require_once ('db.php');
require_once ('config.php');
require_once('classes/User.class.php');
require_once('libs/Smarty.class.php');
$smarty = new Smarty();
$smarty->display('registrerUser.tpl');
if (isset($_POST['btnRegisterUser'])) {
    User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputName']);
}
?>