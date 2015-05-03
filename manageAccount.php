<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 30/04/2015
 * Tid: 09:40
 * All Rights Reserved
 */

require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
//Sjekker at brukeren er logget inn og sessionen ikke er kapret. Metoden hånterer selv vis en av de to situasjonene oppstår
Verify::sessionAndUserLoggedIn();

//Sjekker om brukeren prøver å bytte brukernavn
if (isset($_POST['btnNewUsername'])) {
    //Oppdatere brukerobjektet til brukeren sitt brukernavn
    $_SESSION['user']->setUsername($_POST['inputUsername']);
    //Oppdaterer brukernavnet i databasen
    $_SESSION['user']->updateUsername($db);
}
if(isset($_POST['btnNewPassword'])){
    //Sant hvis passordene ikke er like
    if($_POST['inputPassword'] != $_POST['inputPasswordRepete']) {
        //Metoden som blir kalt passordene ikke er like
        //Setter smartyvariablene som skal bli satt når passordene ikke er like
        Validate::nonMatchingPasswords($smarty);

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
}




$smarty->display("manageAccount.tpl");