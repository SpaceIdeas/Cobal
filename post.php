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
session_start();
$smarty = new Smarty();
Alert::displayAlertFromSession($smarty);
if (isset($_GET ['id'])) {
    $smarty->assign('db', $db);
    $post = Post::getPost($db, ( int ) $_GET ['id']);

    if (isset($post)) {
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

        $smarty->assign('post', $post);
        $comments = $post->getComments($db, $post);
        $smarty->assign('comments', $post->getComments($db));
        $attachment = $post->getAttachment($db);
        $smarty->assign('attachment', $attachment);

        // Når beukeren trykker på kommenter
        if (isset($_POST['btnComment']))
        {
            // Oppretter en ny kommentar og legger denne til i databasen
            $comment = new Comment();
            $comment->setText($_POST['txtComment']);
            $comment->setAuthorEmail($_SESSION['user']->getEmail());
            $comment->setPostID($post->getID());
            $comment->addToDB($db);
        }

        // Brukeren har valgt å vise vedlegg
        if (isset($_POST['btnShowAttachment'])) {
            header("Content-Type:" . $attachment->getMIMEType());
            echo $attachment->getData();
        }
        // Brukeren har ikke valgt å vise vedlegg
        else {
            $smarty->display('post.tpl');
        }
    }
    else {
        $alert = new Alert(Alert::ERROR, "Et innlegg er ikke valgt. Prøv igjen hvis du tørr.");
        $alert->displayOnIndex();
    }
}

