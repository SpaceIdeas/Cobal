<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 13:56
 * All Rights Reserved
 */
/**
 * Dette scriptet viser slettede kommentarer til en administrator slik hat han kan gjenopprette de om ønskelig.
 */
require_once ('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
//Passer på sessionen ikke er kapret og at en admin er logget på
Verify::sessionAndAdminLoggedIn();
//Henter de kommentarene som er slettet fra databasen
if(isset($_GET['page'])){
    //Henter de neste 10 slettede kommentarene fra databasen
    $deletedComments = DeletedComment::getDeletedCommentsNextTenFrom($db, $_GET['page']*10);
    //Gjøre sidevalgeknappene synelige
    $smarty->assign('showPager', true);
}else{
    //Henter de 10 første slettede kommentarene fra databasen
    $deletedComments = DeletedComment::getDeletedCommentsNextTenFrom($db, 0);
}
//Passer på at det ihvertfall er en kommentar
if($deletedComments != null){
    $smarty->assign('deletedComments', $deletedComments);
}

$smarty->display('manageComments.tpl');