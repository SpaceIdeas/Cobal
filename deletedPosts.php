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
if(isset($_GET['page'])){
    //Henter de neste 10 innleggede fra databasen
    $posts = DeletedPost::getPostNextTenFrom($db, $_GET['page']*10);
    //Gjøre sidevalgeknappene synelige
    $smarty->assign('showPager', true);
}else{
    //Gjøre sidevalgeknappene synelige
    $posts = DeletedPost::getPostNextTenFrom($db, 0);
    $smarty->assign('showPager', true);
}
$smarty->assign('deletedPosts', $posts);
$smarty->display('deletedPosts.tpl');

