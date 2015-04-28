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

if (isset($_POST['btnAddPost']))
{
    $post = new Post();
    $post->setText($_POST['txtPost']);
    $post->setTitle($_POST['txtTitle']);
    $post->setAuthorEmail($_SESSION['user']->getEmail());
    $post->addToDB($db);
}
$smarty->display('addPost.tpl');