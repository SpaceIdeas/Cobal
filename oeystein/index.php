<?php
/* Dette er hovedisden. Poster hentes og sendes til smarty */

require_once 'config.php';
$smarty = new Smarty();
$articles = dbConnection::getArticles();
$smarty->assign('articles', $articles);
$smarty->display('index.tpl');
?>