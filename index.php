<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('libs/Smarty.class.php');
require_once('Database.class.php');
require_once('classes/Post.class.php');
require_once('classes/User.class.php');
$smarty = new Smarty();
$smarty->assign('posts', Post::getAllPosts(Database::getDatabase()));
$smarty->assign('db', Database::getDatabase());
$smarty->display('index.tpl');