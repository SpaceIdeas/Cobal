<?php
/* Viser en blogpost hvis den finnes */
require_once('config.php');
if ($_GET ['id']) {
	$id = ( int ) $_GET ['id'];
	$article = dbConnection::getArticle($id);
	$smarty = new Smarty();
	if (isset($article)) {
		$smarty->assign('choosenArticle', $article);
		$smarty->assign('articleExists', true);
	}
	else {
		$smarty->assign('articleExists', false);
	}
}
else {
	$smarty->assign('articleExists', false);
}
$smarty->display('article.tpl');
?>
