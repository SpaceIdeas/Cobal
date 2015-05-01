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
if (isset($_GET ['id'])) {
    $smarty->assign('db', $db);
    $post = Post::getPost($db, ( int ) $_GET ['id']);
    if(!isset($_SESSION['lastHitPost'])){
        $_SESSION['lastHitPost'] = "-1";
    }

    //Sant hvis det innlegget brukeren sist så på ikke er dette innlegget
    if($_SESSION['lastHitPost'] != $post->getID()){
        //Øker hit telleren med en i databasen
        $post->iGotHit($db);
        //Øker hit telleren med en i objektet
        $post->setHits($post->getHits());
        //Setter variabelen for innlegget brukeren sist så på til dette innlegget
        $_SESSION['lastHitPost'] = $post->getID();
    }
    //Sender antallet treff dette innlegget har fått til smarty
    $smarty->assign('hits', $post->getHits());
    if (isset($post)) {
        $smarty->assign('post', $post);
        $comments = $post->getComments($db, $post);
        $smarty->assign('comments', $post->getComments($db));
        $attachment = $post->getAttachment($db);
        $smarty->assign('attachment', $attachment);

        if (isset($_POST['btnComment']))
        {
            $comment = new Comment();
            $comment->setText($_POST['txtComment']);
            $comment->setAuthorEmail($_SESSION['user']->getEmail());
            $comment->setPostID($post->getID());
            $comment->addToDB($db);
        }

        if (isset($_POST['btnShowAttachment'])) {
            header("Content-Type:" . $attachment->getMIMEType());
            echo $attachment->getData();
        }
        $smarty->display('post.tpl');
    }
    else {

    }
}else{
    $alert = new Alert(Alert::ERROR, "Et innlegg er ikke valgt. Prøv igjen hvis du tørr.");
    $alert->displayOnIndex();
}