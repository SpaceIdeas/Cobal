<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('config.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);

if(isset($_GET['searchWord'])){
    $posts = Post::getPostsBySearch($db, $_GET['searchWord']);
} else if(isset($_GET['year']) && isset($_GET['month'])) {
    //Henter alle innleggene i fra den spesifike måneden og året.
    //array_search($_GET['month'], YearPostList::$norwegianMonth) gjør en måned i norske boks   taver om til tallet til måneden
    $posts = Post::getPostsByMonthYear($db, array_search($_GET['month'], YearPostList::$norwegianMonth), $_GET['year']);
}else if(isset($_GET['mostPopular'])) {
    //Henter de fem innleggene med mest treff
    $posts = Post::getTopFivePosts($db);
}else if(isset($_GET['page'])){
    //Henter de neste 10 innleggede fra databasen
    $posts = Post::getPostNextTenFrom($db, $_GET['page']*10);
    //Gjøre sidevalgeknappene synelige
    $smarty->assign('showPager', true);
}else{
    //Gjøre sidevalgeknappene synelige
    $posts = Post::getPostNextTenFrom($db, 0);
    $smarty->assign('showPager', true);
}
if (isset($_GET['verToken'])) {
    if (User::verifyUserEmail($db, $_GET ['verToken']) == 1) {
        $alert = new Alert(Alert::SUCCESS, 'Din epost er nå bekreftet. Du kan nå logge inn');
        $alert->displayOnOtherPage('login.php');
    } else {
        $alert = new Alert(Alert::ERROR, 'Din epost kunne ikke bekreftes.');
        $alert->displayOnThisPage($smarty);
    }
}


$smarty->assign('posts', $posts);

//Metoden henter ut elementene som gjør postList.tpl mulig å kjøre
$yearPostList = Post::getYearMonthCountFromPosts($db);
$smarty->assign('postList', $yearPostList);

$smarty->assign('db', $db);
$smarty->display('index.tpl');


