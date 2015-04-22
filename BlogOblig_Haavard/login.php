<?php
//email admin@adminhaven.edu
//passord adminpassord
require 'libs/Smarty.class.php';
require_once 'auth_pdo.php';
require_once ('conf.php');
session_start();

$smarty = new Smarty();

if (isset($_POST['action'])) {

	// sjekk bruker mot databasen
	if (!User::login($db, $_POST['inputEmail'], $_POST['inputPassword'])) { 
		$smarty->assign('loginSucsess', false);
	} else {
		// Bruker er innlogget
		//  Send brukeren til forespurt side dersom det ligger en slik lagret i session
		if(isset($_SESSION['page'])) {
			header("Location: " . $_SESSION['page']);
			unset($_SESSION['page']);
			exit;
		}
		$smarty->assign('loginSucsess', true);
		$smarty->assign('message', "Login sucsessfull");
	}
}

$smarty->display('login.tpl');