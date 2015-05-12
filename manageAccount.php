<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 30/04/2015
 * Tid: 09:40
 * All Rights Reserved
 */
/**
 * Dette skripter viser brukeren en side hvor han kan oppdatere passordet, brukernavnet og profilbildet sitt.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
//Sjekker at brukeren er logget inn og sessionen ikke er kapret. Metoden hånterer selv hvis en av de to situasjonene oppstår
Verify::sessionAndUserLoggedIn();

//Sjekker om brukeren prøver å bytte brukernavn
if (isset($_POST['btnNewUsername'])) {
    //Oppdatere brukerobjektet til brukeren sitt brukernavn
    $_SESSION['user']->setUsername($_POST['inputUsername']);
    //Oppdaterer brukernavnet i databasen
    $_SESSION['user']->updateUsername($db);
    $alert = new Alert(Alert::SUCCESS, "Din nye alias er nå klart");
    $alert->displayOnThisPage($smarty);

//True hvis bruker trykket på knapp for å bytte passord
}else if(isset($_POST['btnNewPassword'])){
    //Sant hvis passordene ikke er like
    if($_POST['inputPassword'] != $_POST['inputPasswordRepete']) {
        //Metoden som blir kalt passordene ikke er like
        //Setter smartyvariablene som skal bli satt når passordene ikke er like
        Alert::nonMatchingPasswords($smarty);

    }else{
        //Oppdaterer brukerens passord i databasen. Sant hvis oppdateringen var vellykket
        if(User::updatePassword($db, $_SESSION['user']->getEmail(), $_POST['inputPassword'])){
            //Suksess melding
            $alert = new Alert(Alert::SUCCESS, "Passordbytte var vellykket. Den skumle mannen kan ikke gjøre noe med deg nå.");
        }else{
            //Error melding
            $alert = new Alert(Alert::ERROR, "Noe gikk galt under passordbytte. Ikke bekymre deg. Det er helt sikkert ikke en nordkoreansk hacker som stjeler passordet ditt.");
        }
        //Viser meldingen
        $alert->displayOnThisPage($smarty);
    }
}else if(isset($_POST['btnUpdatePicture'])) {
    if ($_FILES['profileImage']['error'] != UPLOAD_ERR_NO_FILE) {

        // Hvis filen som er lastet opp er den som skulle lastes opp
        if (is_uploaded_file($_FILES['profileImage']['tmp_name'])) {
            $mimeType = $_FILES['profileImage']['type'];

            // Sjekker at filtypen faktisk er et bilde
            if($mimeType != "image/jpg" && $mimeType != "image/png" && $mimeType != "image/jpeg"
                && $mimeType != "image/gif" ) {
                $alert = new Alert(Alert::ERROR, 'Kun bilder tillatt');
                $alert->displayOnThisPage($smarty);
            }
            else {
                // Sjekker at støørelsen er under 100 kb
                if($_FILES["profileImage"]["size"] > 100000) {
                    $alert = new Alert(Alert::ERROR, 'Bildet må være under 100kb');
                    $alert->displayOnThisPage($smarty);
                }
                else {
                    // Sjekker at bildet ikke er en lurefil
                    if (getimagesize($_FILES["profileImage"]["tmp_name"]) <= 0) {
                        $alert = new Alert(Alert::ERROR, 'Bildet er en lurefil');
                        $alert->displayOnThisPage($smarty);
                    }
                    // Alt er i orden. Prøver å laste opp til databasen
                    else {
                        $newProfileImage = new ProfileImage(file_get_contents($_FILES['profileImage']['tmp_name']), $mimeType, $_SESSION['user']->getEmail());

                        // Oppdaterer profilbildet. Får true hvis vellykket.
                        if ($newProfileImage->updateDB($db)) {
                            $alert = new Alert(Alert::SUCCESS, 'Profilbildet ble oppdatert');
                            $alert->displayOnThisPage($smarty);
                        }
                        else {
                            $alert = new Alert(Alert::ERROR, 'En feil oppstod med databasen');
                            $alert->displayOnThisPage($smarty);
                        }
                    }
                }
            }
        }
        // Finner ikke riktig fil på serveren
        else {
            $alert = new Alert(Alert::ERROR, 'Filen som ble lastet opp er kanskje en del av et angrep. eller den var over 100 kb');
            $alert->displayOnThisPage($smarty);
        }
    }
    // Intet bilde er lastet opp
    else {
        $alert = new Alert(Alert::ERROR, 'Du har ikke lastet opp et bilde');
        $alert->displayOnThisPage($smarty);
    }
}
$smarty->display("manageAccount.tpl");