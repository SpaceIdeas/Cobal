<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 10.05.2015
 * Time: 20:37
 */
/**
 * Skriptet tar inn en brukers e-postadresse som en get-parameter og en get-parameter om brukeren skal
 * gjøres til en administrator eller tas fra administratorrettigheter.
 */
require_once('config.php');
require_once('db.php');
session_start();
Verify::adminLoggedIn();

if ($_GET['email'] && $_GET['makeAdmin']) {
    // Hvis 1 så skal brukeren gjøres til administrator.
    if ($_GET['makeAdmin'] == 1 ) {
        // Metoden returnerer true hvis vellykket
        if (User::makeAdmin($db, $_GET['email'])) {
            $alert = new Alert(Alert::SUCCESS, 'Brukeren er nå administrator');
            $alert->displayOnOtherPage('manageAccounts.php');
        }
        // Omgjøring til administrator var ikke vellykket
        else {
            $alert = new Alert(Alert::ERROR, 'En feil oppstod');
            $alert->displayOnOtherPage('manageAccounts.php');
        }
    }
    // Hvis 0 så skal brukeren gjøres til en normal bruker.
    elseif($_GET['makeAdmin'] == 0) {
        // Metoden returnerer true hvis vellykket
        if (User::makeNotAdmin($db, $_GET['email'])) {
            $alert = new Alert(Alert::SUCCESS, 'Brukeren er nå en normal bruker');
            $alert->displayOnOtherPage('manageAccounts.php');
        }
        // Omgjøring til normal bruker var ikke vellykket
        else {
            $alert = new Alert(Alert::ERROR, 'En feil oppstod');
            $alert->displayOnOtherPage('manageAccounts.php');
        }
    }
    // Feile parametre er ikke gitt
    else {
        $alert = new Alert(Alert::ERROR, 'Feile parametere gitt');
        $alert->displayOnIndex();
    }
}