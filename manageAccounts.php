<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 10.05.2015
 * Time: 20:33
 */
/**
 * Dette scriptet viser en administrator en side hvor han kan gjøre registrerte brukere til administratorer eller
 * administratorer til normale brukere.
 */
require_once('config.php');
require_once('db.php');
session_start();
Verify::adminLoggedIn();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
$smarty->assign('admins', User::getAdmins($db));
$smarty->assign('nonAdmins', User::getNonAdmins($db));
$smarty->display('manageAccounts.tpl');