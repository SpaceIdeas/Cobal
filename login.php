<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 23/04/2015
 * Tid: 16:43
 * All Rights Reserved
 */

require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);

//Blir kalt når bruker trykker på knapp for å logge inn
if (isset($_POST['btnLogin'])) {

    if (($user = User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) != null) {
        if($user->isVerified($db)){
            $alert = new Alert(Alert::SUCCESS, 'Du er nå logget inn. God fornøyelse!');
            // Bruker er innlogget
            //  Send brukeren til forespurt side dersom det ligger en slik lagret i session
            if (isset($_SESSION['returnPage'])) {
                $returnpage = $_SESSION['returnPage'];
                unset($_SESSION['returnPage']);
                $alert->displayOnOtherPage($returnpage);
            } else {
                $alert->displayOnIndex();
            }
        //Brukeren har ikke verifisert emailen enda og kan dermed ikke logge inn
        }else{
            $alert = new Alert(Alert::ERROR, 'Innloggingsinformasjonen er korrekt, men! Du MÅ vertifiser emailen din før du kan logge inn');
            $alert->displayOnThisPage($smarty);
        }

    }
    //Gir beskjed at login feilet
    else {
        $alert = new Alert(Alert::ERROR, 'Login feilet. Kontakt ditt nærmeste kammskjell for mer hjelp');
        $alert->displayOnThisPage($smarty);
    }
}
$smarty->display('login.tpl');
