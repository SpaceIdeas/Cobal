<?php
require_once ('User.class.php');
require_once ('conf.php');

if (!isset($_SESSION['loggedin']) ) {   //Hvis en bruker ikke er logget inn, vil han bli sent til login.php 
	$_SESSION['page'] = $_SERVER['REQUEST_URI'];
	header("Location: login.php");
	throw (new ErrorException("Ble redirektet til login"));
	exit;
}else if($_SESSION['loggedin']){
	if(!$_SESSION['user']->verifyUser()){ //Hvis verifyUser() returnerer falskt er sessionene kapret
		echo "Session Hijacked.... consider using protection";
		exit;
	}
}