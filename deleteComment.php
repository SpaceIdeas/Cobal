<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 01/05/2015
 * Tid: 11:59
 * All Rights Reserved
 */

require_once ('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
//Sant hvis get har de variablene som er nødvendig
if(isset($_GET['id']) && isset($_GET['return'])){
    //Prøver å hente kommentaren ut av databasen, basert på IDen gitt
    $comment = Comment::getCommentByID($db, $_GET['id']);
    //Sant hvis kommentaren ble funnet i databasen
    if($comment != null){
        //Sant hvis kommentaren ble vellykket slettet
        if($comment->deleteComment($db)){
            $alert = new Alert(Alert::SUCCESS, "Kommentaren ble slettet. Du kan nå sove trygt");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        }else{
            $alert = new Alert(Alert::ERROR, "En feil skjedde under slettingen. Jeg... hmm. Du kan kansje... nei. ");
            $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
        }
    }else{
        $alert = new Alert(Alert::ERROR, "Kommentaren ble ikke funnet i databasen. Du får ta til takke med denne kommentaren");
        $alert->displayOnOtherPage($_SERVER['HTTP_REFERER']);
    }
}