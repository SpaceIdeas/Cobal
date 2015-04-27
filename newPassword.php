<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 27.04.2015
 * Time: 18:55
 */
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
$smarty = new Smarty();
if (isset($_GET['lostPwdToken'])) {
    if (isset($_POST['btnNewPassword'])) {
        //Tester om passordene er like
        if ($_POST['inputPassword'] == $_POST['inputPasswordRepeat']) {
            if (User::updatePasswordFromToken($db, $_GET['verToken'], $_POST['inputPassword'])) {
                $smarty->assign('successMessage', 'Ditt passord er nå endret. Velkommen tilbake.');
            } else {
                $smarty->assign('errorMessage', 'Noe gikk galt');
            }
        }
    }
}
$smarty->display('newPassword.tpl');

