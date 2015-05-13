<?php
/**
 * Dette scriptet tar seg av å logge en bruker inn og sender brukeren dit han skal etter innlogging. Det tar seg også
 * av feilmeldinger.
 */
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
//Blir kalt når bruker trykker på knapp for å logge inn
if (isset($_POST['btnLogin'])) {
    //True hvis brukeren er i databasen.
    if (($user = User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) != null) {
        //True hvis eposten til brukeren er verifisert
        if($user->isVerified($db)){
            //Legger brukeren til sessionen. Det gjør at siden oppfatter brukeren som loggen inn
            $_SESSION['user'] = $user;
            $alert = new Alert(Alert::SUCCESS, 'Du er nå logget inn. God fornøyelse!');
            //  Send brukeren til forespurt side dersom det ligger en slik lagret i session
            if (isset($_SESSION['returnPage'])) {
                $returnpage = $_SESSION['returnPage'];
                unset($_SESSION['returnPage']);
                $alert->displayOnOtherPage($returnpage);
            } else if(isset($_GET['returnToPage'])){
                $alert->displayOnOtherPage($_GET['returnToPage']);
            }else{
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
