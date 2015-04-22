<?php
require_once 'auth_pdo.php';
require 'libs/Smarty.class.php';
require 'conf.php';
session_start();
require_once 'sessionTest.php'; // Passer på en bruker er logget inn og redirecter til login.php hvis ikke

$smarty = new Smarty();

if(isset($_POST['newBlogPost'])){
	$blogPost = new blogPost();
	$blogPost->setTitle($_POST['title']);
	$blogPost->setText($_POST['blogText']);
	$blogPost->setAuthor($_SESSION['user']->getEmail());
	$result = $blogPost->insertBlogPost($db);
	if($result == 1)$smarty->assign('message', "Blog Post added to database");
}


$smarty->display('addPost.tpl');