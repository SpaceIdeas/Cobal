<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 23/04/2015
 * Tid: 16:43
 * All Rights Reserved
 */

require_once('libs/Smarty.class.php');
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();

//Blir kalt når bruker trykker på knapp for å logge inn
if (isset($_POST['action'])) {

    // Sjekk bruker mot databasen. Returnerer sant hvis bruker ikke blir logget inn
    if (!User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) {
        $smarty->assign('errorMessage', 'Login feilet. Kontakt ditt nærmeste kammskjell for mer hjelp');
    } else if(isset($_SESSION['returnPage'])){
        // Bruker er innlogget
        //  Send brukeren til forespurt side dersom det ligger en slik lagret i session
        header("Location: " . $_SESSION['returnPage']);
        unset($_SESSION['returnPage']);
        exit;
    } else {
        $smarty->assign('successMessage', 'Gratulerer! Du er nå logget inn');
    }
}

$smarty->display('login.tpl');
