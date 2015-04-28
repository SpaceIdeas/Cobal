<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 23/04/2015
 * Tid: 16:43
 * All Rights Reserved
 */

require_once('libs/Smarty.class.php');
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);

//Blir kalt når bruker trykker på knapp for å logge inn
if (isset($_POST['btnLogin'])) {
    if (User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) {
        $alert = new Alert(Alert::SUCCESS, 'Du er nå logget inn. God fornøyelse!');
        // Bruker er innlogget
        //  Send brukeren til forespurt side dersom det ligger en slik lagret i session
        if (isset($_SESSION['returnPage'])) {
            $returnpage = $_SESSION['returnPage'];
            unset($_SESSION['returnPage']);
            $alert->displayAlertOnOtherPage($returnpage);
        } else {
            $alert->displayOnIndex();
        }
    }

    else {
        $smarty->assign('errorMessage', 'Login feilet. Kontakt ditt nærmeste kammskjell for mer hjelp');
    }
}
$smarty->display('login.tpl');
