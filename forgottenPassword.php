<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 26/04/2015
 * Tid: 17:42
 * All Rights Reserved
 */
/* Denne siden er ment vist for
 */
require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();

if (isset($_POST['btnNewPassword'])) {

    if (isset($_POST['inputEmail'])) {

        // Sjekker at brukeren eksister i databasen
        if (User::getUsernameFromDB($db, $_POST['inputEmail']) != null) {

            // Sender brukeren e-post med instruksjoner for å få nytt passord. Metoden blir true hvis dette blir gjort.
            if (User::sendNewPasswordEmail($db, $_POST['inputEmail'])) {
                // Gir beskjed til brukeren om at han får epost på index.php
                $alert = new Alert(Alert::SUCCESS, 'Du har nå fått tilsendt en e-post med instruksjoner for gjenoppretting av passord');
                $alert->displayOnIndex();
            }
            else {
                // Eneste grunn til false over er databasefeil. Sender bruker til index.php med feilmelding.
                $alert = new Alert(Alert::ERROR, 'Databasefeil. Prøv igjen senere.');
                $alert->displayOnIndex();
            }
        }
        // E-postadressen / brukeren er ikke registrert i systemet. Gir beskjed om dette på samme side.
        else {
            $smarty->assign('errorMessage', 'Ingen bruker med din e-postadresse er registrert');
        }
    }
}
$smarty->display('forgottenPassword.tpl');