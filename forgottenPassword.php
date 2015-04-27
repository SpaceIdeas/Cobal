<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 26/04/2015
 * Tid: 17:42
 * All Rights Reserved
 */
require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
$smarty = new Smarty();

if (isset($_POST['btnNewPassword'])) {
    // Sjekk bruker mot databasen. Returnerer sant hvis bruker ikke blir logget inn
    if (isset($_POST['inputEmail'])) {
        if (User::getUsernameFromDB($db, $_POST['inputEmail']) != null) {
            if (User::sendNewPasswordEmail($db, $_POST['inputEmail'])) {
                $smarty->assign('successMessage', 'Du har nå fått tilsendt en e-post med instruksjoner for gjenoppretting av passord');
            }
            else {
                $smarty->assign('errorMessage', 'Feil: Noe gikk galt med databasen vår');
            }
        }
        else {
            $smarty->assign('errorMessage', 'Ingen bruker med din e-postadresse er registrert');
        }
    }
}

$smarty->display('forgottenPassword.tpl');