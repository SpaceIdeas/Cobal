<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 26.04.2015
 * Time: 17:27
 */
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
session_start();
$smarty = new Smarty();
Verify::userLoggedIn();
Alert::displayAlertFromSession($smarty);
if (isset($_POST['btnAddPost']))
{
    $post = new Post();
    $post->setText($_POST['txtPost']);
    $post->setTitle($_POST['txtTitle']);
    $post->setAuthorEmail($_SESSION['user']->getEmail());
    $post->addToDB($db);
    $postID = $db->lastInsertId();
    $userfile = $_FILES['userfile']['tmp_name'];
    $type = $_FILES['userfile']['type'];
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        $attachment = new Attachment();
        $attachment->setData(file_get_contents($userfile));
        $attachment->setPostID($postID);
        $attachment->setMIMEType($type);
        $attachment->addToDB($db);
    }
    else {
        $alert = new Alert(Alert::ERROR, 'Filen som ble lastet opp er kanskje en del av et angrep...');
        $alert->displayOnIndex();
    }
    $alert = new Alert(Alert::SUCCESS, 'Ditt inlegg ble lagt til');
        $alert->displayOnOtherPage('post.php?id=' . $postID);
}

$smarty->display('addPost.tpl');