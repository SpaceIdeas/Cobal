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
$smarty = new Smarty();
if(isset($_GET['searchWord'])){
    $smarty->assign('posts',Post::getAllPostsWhere($db, $_GET['searchWord']));
} else {
    $smarty->assign('posts',Post::getAllPosts($db));
}
if (isset($_GET['verToken'])) {
    if (User::verifyUserEmail($db, $_GET ['verToken']) == 1) {
        $smarty->assign('successMessage', 'Din epost er nå bekreftet. Takk.');
    } else {
        $smarty->assign('errorMessage', 'Din epost kunne ikke bekreftes.');
    }
}
$smarty->assign('db', $db);
$smarty->display('index.tpl');
