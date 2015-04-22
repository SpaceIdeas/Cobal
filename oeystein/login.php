<?php
require_once ('config.php');
$smarty = new Smarty();
$smarty->assign('isLoggedIn', isset($_SESSION['name']));
$smarty->display('login.tpl');
if (isset($_POST['btnRegisterUser'])){
	/*Henter ut brukernavn. Hvis e-post og hash ikke har et brukernavn er passordet eller brukernavnet feil. */
	$passwordHash = md5(htmlentities($_POST['inputPassword']));
	$executeQuery =  Database::getDatabase()->prepare("SELECT NAME FROM USER WHERE EMAIL = ? AND HASH = ?");
	$executeQuery->bindParam(1, htmlentities($_POST['inputEmail']));
	$executeQuery->bindParam(2, $passwordHash);
	$executeQuery->execute();
	$row = $executeQuery->fetch();
	$name = $row['NAME'];
	if (isset($name)) {
		printf('Velkommen tilbake %s!', $name);
		$_SESSION['name'] = $name;	
		$_SESSION['email'] = $_POST['inputEmail'];
	}
	else {
		echo 'Beklager, passordet eller brukernavnet ditt var feil';	
	}
}
?>
