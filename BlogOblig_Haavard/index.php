<?php
require_once 'libs/Smarty.class.php';
require_once 'auth_pdo.php';
require_once 'conf.php';
session_start();
$smarty = new Smarty();


$blogPosts = blogPost::getAllPost($db);
$smarty->assign('blogPosts', $blogPosts);


$smarty->display('index.tpl');

