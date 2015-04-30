<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 30/04/2015
 * Tid: 09:40
 * All Rights Reserved
 */

require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
//Sjekker at brukeren er logget inn og sessionen ikke er kapret. Metoden hånterer selv vis en av de to situasjonene oppstår
Verify::sessionAndUserLoggedIn();
$smarty = new Smarty();