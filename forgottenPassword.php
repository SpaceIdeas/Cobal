<?php
/**
 *  Dette scriptet / denne siden er det man skal kunne skrive inn sin e-postadrresse (registrerte) og få tilsendt en
 * e-post med en link hvor man kan oprette et nytt passord hvis man har glemt det.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();

if (isset($_POST['btnNewPassword']) && isset($_POST['inputEmail'])) {


    // Sjekker at brukeren eksister i databasen
    if (User::getUsernameFromDB($db, $_POST['inputEmail']) != null) {

        /*Sender brukeren e-post med instruksjoner for å få nytt passord. Metoden blir true hvis dette blir gjort.
        endringer i databse håndters også vha. denne metoden */
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
//Kalt når bruker trykker på link for å få nytt passord
if (isset($_GET['lostPwdToken'])) {
    $alert = new Alert(Alert::SUCCESS, "Sktiv inn ditt nye passord");
    $alert->displayOnOtherPage("newPassword.php?lostPwdToken=".$_GET['lostPwdToken']);
}

$smarty->display('forgottenPassword.tpl');