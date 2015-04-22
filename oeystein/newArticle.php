<?php
/* Denne filen legger til i databasen et nytt bloginlegg. Smarty brukes for å skille på tilgang. */
require_once 'config.php';
$smarty = new Smarty();
$smarty->assign('isLoggedIn', isset($_SESSION['name']));
$smarty->display('newArticle.tpl');
if (isset($_SESSION['name'])) {
	if (isset($_POST['btnAddArticle']))
	{
		dbConnection::addArticle(htmlentities($_POST['title']),htmlentities($_POST['articleText']), $_SESSION['email']);
		echo "Innlegget ble publisert";
	}
}
?>