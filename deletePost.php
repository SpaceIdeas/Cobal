<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 13:58
 * All Rights Reserved
 */

require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
//Sant hvis get har de variablene som er nødvendig
if(isset($_GET['id']) && isset($_GET['return']) && isset($_SESSION['user'])) {
    //Prøver å hente innlegget ut av databasen, basert på IDen gitt
    $post = Post::getPost($db, $_GET['id']);
    //Sant hvis innlegget ble funnet i databasen
    if ($post != null) {
        //Sletter innlegget og returnerer sant hvis innlegget ble vellykket slettet
        if ($post->deletePost($db)) {
            $alert = new Alert(Alert::SUCCESS, "Innlegget ble slettet.");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        } else {
            $alert = new Alert(Alert::ERROR, "En feil skjedde under slettingen. Jeg... hmm. Du kan kansje... nei. ");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        }
    } else {
        $alert = new Alert(Alert::ERROR, "Innlegget ble ikke funnet i databasen. Du får ta til takke med denne kommentaren");
        $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
    }
}else{
    header("Locaton: index.php");
    die();
}