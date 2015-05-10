<?php
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['user']);
if(isset($_GET['returnToPage'])){
	if($_GET['returnToPage'] == ""){
        $alert = new Alert(Alert::SUCCESS, 'Du er nå logget ut. Du trenger ikke å uroe deg for NSA lengere');
        $alert->displayOnIndex();
	}else{
		header("Location: " . $_GET['returnToPage']);
	}
}