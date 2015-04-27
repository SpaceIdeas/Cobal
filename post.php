<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 24.04.2015
 * Time: 09:00
 */
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
$smarty = new Smarty();
session_start();
if ($_GET ['id']) {
    $smarty->assign('db', $db);
    $post = Post::getPost($db, ( int ) $_GET ['id']);
    if(!isset($_SESSION['lastHitPost'])){
        $_SESSION['lastHitPost'] = "-1";
    }
    if($_SESSION['lastHitPost'] != $post->getID()){
        $post->iGotHit($db);
        $_SESSION['lastHitPost'] = $post->getID();
    }
    if (isset($post)) {
        $smarty->assign('post', $post);
        $comments = $post->getComments($db, $post);
        $smarty->assign('comments', $post->getComments($db));
        $smarty->display('post.tpl');

        if (isset($_POST['btnComment']))
        {
            $comment = new Comment();
            $comment->setText($_POST['txtComment']);
            $comment->setAuthorEmail($_SESSION['user']->getEmail());
            $comment->setPostID($post->getID());
            $comment->addToDB($db);
            echo 'hello';
        }
    }
    else {

    }
}