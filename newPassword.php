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
                $alert = new Alert(Alert::SUCCESS, "Ditt nye passord er nå lagret. Du kan nå logge inn.");
                $alert->displayAlertOnOtherPage('login.php');
            } else {
                $alert = new Alert(Alert::ERROR, 'Noe gikk galt');
                $alert->displayOnThisPage($smarty);
            }
        }
    }
}
$smarty->display('newpassword.tpl');

