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
}

if (isset($_POST['btnUploadFile'])) {
    $userfile = $_FILES['userfile']['tmp_name'];
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        copy($userfile, "/tmp/");
        echo 'hello';}
    else {
        echo "Possible file upload attack: filename '$userfile'."; }
    /* ...or... */
    move_uploaded_file($userfile, "/tmp/");
}
$smarty->display('addPost.tpl');