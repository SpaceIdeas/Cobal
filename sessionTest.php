<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 26/04/2015
 * Tid: 13:36
 * All Rights Reserved
 */

/** Depricated */
require_once('config.php');
session_start();

if (!isset($_SESSION['user']) ) {   //Hvis en bruker ikke er logget inn, vil han bli sent til login.php
    //Lagrer siden brukeren er på nå slik at han kan bli redirigert hit etter han har logget inn
    $_SESSION['returnPage'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}else if(!$_SESSION['user']->verifyUser()){//Hvis verifyUser() returnerer falskt er sessionene kapret
    echo "Session Hijacked.... consider using protection";
    exit;
}