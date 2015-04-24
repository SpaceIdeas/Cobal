<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('libs/Smarty.class.php');
require_once('config.php');
require_once('db.php');
require_once('index.php');

$smarty = new Smarty();
$smarty->assign('posts', Post::getAllPosts(Database::getDatabase()));
$smarty->assign('db', Database::getDatabase());
$smarty->display('index.tpl');