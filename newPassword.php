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
session_start();
$smarty = new Smarty();
if (isset($_GET['lostPwdToken'])) {
    if (isset($_POST['btnNewPassword'])) {
        //Tester om passordene er like
        if ($_POST['inputPassword'] == $_POST['inputPasswordRepeat']) {
            if (User::updatePasswordFromToken($db, $_GET['verToken'], $_POST['inputPassword'])) {
                $alert = new Alert(Alert::SUCCESS, "Ditt nye passord er nå lagret");
                $alert->displayOnIndex();
            } else {
                $smarty->assign('errorMessage', 'Noe gikk galt');
            }
        }
    }
}
$smarty->display('newPassword.tpl');

