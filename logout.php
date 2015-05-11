<?php
require_once('config.php');
session_start();
unset($_SESSION['user']);
//Hvis deet
if(isset($_GET['returnToPage'])){
	if($_GET['returnToPage'] == ""){
        $alert = new Alert(Alert::SUCCESS, 'Du er nå logget ut. Du trenger ikke å uroe deg for NSA lengere');
        $alert->displayOnIndex();
	}else{
		header("Location: " . $_GET['returnToPage']);
	}
}