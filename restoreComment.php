<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 17:42
 * All Rights Reserved
 */
/**
 * Denne siden sletter kommentaren med ID-en som er gitt i paramaeteren dersom brukeren er administrator, det sender
 * deretter brukeren tilbake der han kom fra.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Verify::sessionAndAdminLoggedIn();
//Sant hvis get har de variablene som er nødvendig
if(isset($_GET['id']) && isset($_GET['return'])){
    //Prøver å hente den slettede kommentaren ut av databasen, basert på IDen gitt
    $comment = DeletedComment::getDeletedCommentByID($db, $_GET['id']);
    //Sant hvis den slettede kommentaren ble funnet i databasen
    if($comment != null){
        //Sant hvis kommentaren ble vellykket gjenopprettet
        if($comment->restoreComment($db)){
            $alert = new Alert(Alert::SUCCESS, "Kommentaren ble gjenopprettet. Det gode har seiret igjen!");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        }else{
            $alert = new Alert(Alert::ERROR, "En feil skjedde under gjenoppretting. Jeg... hmm. Du kan kansje... nei. ");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        }
    }else{
        $alert = new Alert(Alert::ERROR, "Den Slettede kommentaren ble ikke funnet i databasen. Du får ta til takke med denne kommentaren");
        $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
    }
}else{
    $alert = new Alert(Alert::ERROR, "Hva gjorde du der borte? Du skal ikke være der.");
    $alert->displayOnIndex();
}