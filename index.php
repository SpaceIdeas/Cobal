<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
if(isset($_GET['searchWord'])){
    $posts = Post::getPostsBySearch($db, $_GET['searchWord']);
} else if(isset($_GET['year']) && isset($_GET['month'])) {
    //Henter alle innleggene i fra den spesifike måneden og året.
    //array_search($_GET['month'], YearPostList::$norwegianMonth) gjør en måned i norske bokstaver om til tallet til måneden
    $posts = Post::getPostsByMonthYear($db, array_search($_GET['month'], YearPostList::$norwegianMonth), $_GET['year']);
}else {
    $posts = Post::getAllPosts($db);
}
if (isset($_GET['verToken'])) {
    if (User::verifyUserEmail($db, $_GET ['verToken']) == 1) {
        $smarty->assign('successMessage', 'Din epost er nå bekreftet. Takk.');
    } else {
        $smarty->assign('errorMessage', 'Din epost kunne ikke bekreftes.');
    }
}



$smarty->assign('posts', $posts);

//Metoden henter ut elementene som gjør postList.tpl mulig å kjøre
$yearPostList = Post::getYearMonthCountFromPosts($db);
$smarty->assign('postList', $yearPostList);

$smarty->assign('db', $db);
$smarty->display('index.tpl');


