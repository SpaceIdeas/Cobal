<?php
/**
 * Dette skriptet viser brukeren en side hvor han kan opprette en bruker.
 * Dette skriptet tar seg av ting slik som å sjekke at begge passordene
 * er like, at brukernavnet ikke er tatt eller at e-postadressen ikke er registrert fra før av. Scriptet sender også
 *brukeren en e-post med link til å vertifisere e-posten sin.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();

//Sjekker om brukeren prøver å registrere en bruker
if (isset($_POST['btnRegisterUser'])) {
    //Tester om passordene er like
    if($_POST['inputPassword'] != $_POST['inputPasswordRepete']){
        //Metoden som blir kalt passordene ikke er like
        //Setter smartyvariablene som skal bli satt når passordene ikke er like
        Alert::nonMatchingPasswords($smarty);
    //Tester om emailen allerede exsisterer i databasen
    }else if(User::getUsernameFromDB($db, $_POST['inputEmail']) != null){
        //Metoden setter smartyvariablene som skal bli satt når emailen allerede eksisterer
        Alert::userAlreadyExists($smarty);
    //Prøver å registrere brukeren. Retirnerer sant vis det går bra
    }else if(User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputUsername'])){
        //Setter suksess meldingen i smarty
        $smarty->assign("successMessage", "Din bruker er nå opprettet. Du har blitt tilsendt en verifiserings email. Du MÅ verifisere email før du kan logge inn");
        User::sendVerificationEmail($db, $_POST['inputEmail']);
    }else{
        //Noe gikk gale så vi forteller smarty dette med unknownError metoden
        unknownError($smarty);
    }

}
//Blir kjørt når bruker har trykket på link for å vertifisere eposten sin
if (isset($_GET['verToken'])) {
    if (User::verifyUserEmail($db, $_GET['verToken'])) {
        $alert = new Alert(Alert::SUCCESS, 'Din epost er nå bekreftet. Du kan nå logge inn');
        $alert->displayOnOtherPage('login.php');
    } else {
        $alert = new Alert(Alert::ERROR, 'Din epost kunne ikke bekreftes.');
        $alert->displayOnThisPage($smarty);
    }
}

$smarty->display('registrerUser.tpl');

/**
 * Metoden som blir kalt når brukeren allerede eksisterer
 * Setter smartyvariablene som passer til situasjonen
 *
 * @param Smarty $smarty
 */
function unknownError(Smarty $smarty){
    //Sender brukernavn og email som brukeren har sendt inn, tilbake til smarty slik at de automatisk blir fylt inn for brukeren
    $smarty->assign("inputUsername", $_POST['inputUsername']);
    $smarty->assign("inputEmail", $_POST['inputEmail']);
    //Varselbeskjeden til smarty når noe er galt
    $alert = new Alert(Alert::ERROR, "Noe gikk galt og brukeren ble ikke dannet");
    $alert->displayOnThisPage($smarty);

}