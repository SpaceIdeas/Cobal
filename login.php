<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 23/04/2015
 * Tid: 16:43
 * All Rights Reserved
 */

// TODO: Validere input før postback i login.tpl
require_once('libs/Smarty.class.php');
require_once('config.php');
require_once('classes/User.class.php');
require_once('db.php');
$smarty = new Smarty();

if (isset($_POST['action'])) {

    // Sjekk bruker mot databasen
    if (!User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) {
        $smarty->assign('loginSucsess', false);
    } else {
        // Bruker er innlogget
        //  Send brukeren til forespurt side dersom det ligger en slik lagret i session
        if(isset($_SESSION['returnPage'])) {
            header("Location: " . $_SESSION['returnPage']);
            unset($_SESSION['page']);
            exit;
        }
        $smarty->assign('loginSucsess', true);
        $smarty->assign('message', "Login sucsessfull");
    }
}

$smarty->display('login.tpl');
