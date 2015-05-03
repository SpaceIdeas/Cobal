<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 27.04.2015
 * Time: 18:55
 */
/**
 *  Dette scriptet / denne siden er det man skal komme tilbake til etter at man har fått en e-post med instruksjoner
 * for å oprette et nytt passord etter at det gamle passordet har blitt glemt. Denne siden lar brukeren i hovedsak
 * skrive inn et nytt passord for så bli bedt om å logge inn. Et $_POST parameter benyttes for å holde styr på hvem som
 * har glemt hva.
 */
require_once('config.php');
require_once('db.php');
session_start();

// Sjekker om det er gitt et token for tapt passord (sendt på epost)
if (isset($_GET['lostPwdToken'])) {
    $smarty = new Smarty();
    if (isset($_POST['btnNewPassword'])) {

        //Tester om passordene er like
        if ($_POST['inputPassword'] == $_POST['inputPasswordRepeat']) {

            // Oppdater brukerens passord ved å kjøre metoden under. Denne returner tru hvis alt er OK.
            if (User::updatePasswordFromToken($db, $_GET['verToken'], $_POST['inputPassword'])) {
                // Sender brukern til Login slik at han kan logge på med sitt nye passord. Viser Alert også.
                $alert = new Alert(Alert::SUCCESS, "Ditt nye passord er nå lagret. Du kan nå logge inn.");
                $alert->displayOnOtherPage('login.php');

            } else {
                // Noe gikk galt. Sender brukern til index med feilmelding.
                $alert = new Alert(Alert::ERROR, 'Noe gikk galt');
                $alert->displayOnIndex();
            }
        }
    }
    $smarty->display('newpassword.tpl');
}
// Tokenet for glemt passord er ikke satt sender brukeren til index.php med feilmelding.
else {
    $alert = new Alert(Alert::ERROR, 'Noe er feil. Har du trykket på riktig link?');
    $alert->displayOnIndex();
}


