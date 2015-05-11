<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 10.05.2015
 * Time: 20:33
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