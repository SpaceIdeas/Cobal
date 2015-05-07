<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 07/05/2015
 * Tid: 19:43
 * All Rights Reserved
 */
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
//Passer på sessionen ikke er kapret og at en admin er logget på
Verify::sessionAndAdminLoggedIn();

