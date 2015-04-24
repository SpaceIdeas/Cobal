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
if ($_GET ['id']) {
    $smarty->assign('db', $db);
    $post = Post::getPost($db, ( int ) $_GET ['id']);
    if (isset($post)) {
        $smarty->assign('post', $post);
        $smarty->assign('comments', $post->getComments());
    }
}
$smarty->display('post.tpl');