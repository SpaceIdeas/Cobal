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

// Sjekker om det er gitt et token for tapt passord (sendt på epost)
if (isset($_GET['lostPwdToken'])) {
    if (isset($_POST['btnNewPassword'])) {

        //Tester om passordene er like
        if ($_POST['inputPassword'] == $_POST['inputPasswordRepeat']) {

            // Oppdater brukerens passord ved å kjøre metoden under. Denne returner tru hvis alt er OK.
            if (User::updatePasswordFromToken($db, $_GET['verToken'], $_POST['inputPassword'])) {
                // Sender brukern til Login slik at han kan logge på med sitt nye passord. Viser Alert også.
                $alert = new Alert(Alert::SUCCESS, "Ditt nye passord er nå lagret. Du kan nå logge inn.");
                $alert->displayOnOtherPage('login.php');

            } else {
                // Noe gikk galt. Holder brukeren på siden. Viser Alert.
                $alert = new Alert(Alert::ERROR, 'Noe gikk galt');
                $alert->displayOnThisPage($smarty);
            }
        }
    }
}
$smarty->display('newpassword.tpl');

