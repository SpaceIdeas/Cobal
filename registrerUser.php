<?php
require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();

//Sjekker om brukeren prøver å registrere en bruker
if (isset($_POST['btnRegisterUser'])) {
    //Tester om passordene er like
    if($_POST['inputPassword'] != $_POST['inputPasswordRepete']){
        //Metoden som blir kalt passordene ikke er like
        //Setter smartyvariablene som skal bli satt når passordene ikke er like
        Validate::nonMatchingPasswords($smarty);
    //Tester om emailen allerede exsisterer i databasen
    }else if(User::getUsernameFromDB($db, $_POST['inputEmail']) != null){
        //Metoden setter smartyvariablene som skal bli satt når emailen allerede eksisterer
        Validate::userAlreadyExists($smarty);
    //Prøver å registrere brukeren. Retirnerer sant vis det går bra
    }else if(User::registerUser($db, $_POST['inputEmail'], $_POST['inputPassword'], $_POST['inputUsername'])){
        //Setter suksess meldingen i smarty
        $smarty->assign("successMessage", "Din bruker er nå opprettet");
        User::sendVerificationEmail($db, $_POST['inputEmail']);
    }else{
        //Noe gikk gale så vi forteller smarty dette med unknownError metoden
        unknownError($smarty);
    }

}

$smarty->display('registrerUser.tpl');

//TODO: oppdatere unknownError med alert objekt
/**
 * Metoden som blir kalt når brukeren allerede eksisterer
 * Setter smartyvariablene som passer til situasjonen
 * @param $smarty
 */
function unknownError(Smarty $smarty){
    //Varselbeskjeden til smarty når noe er galt
    $smarty->assign("errorMessage", "Noe gikk galt og brukeren ble ikke dannet");
    //Sender brukernavn og email som brukeren har sendt inn, tilbake til smarty slik at de automatisk blir fylt inn for brukeren
    $smarty->assign("inputUsername", $_POST['inputUsername']);
    $smarty->assign("inputEmail", $_POST['inputEmail']);

}