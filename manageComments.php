<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 13:56
 * All Rights Reserved
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
//Passer på sessionen ikke er kapret og at en admin er logget på
Verify::sessionAndAdminLoggedIn();
//Henter de kommentarene som er slettet fra databasen
$deletedComments = DeletedComment::getAllDeletedComments($db);
//Passer på at det ihvertfall er en kommentar
if($deletedComments != null){
    $smarty->assign('deletedComments', $deletedComments);
}

$smarty->display('manageComments.tpl');


/*
$smarty->assign('deletedComment', $deletedComments[0]);
$smarty->display('deletedComment.tpl');
*/