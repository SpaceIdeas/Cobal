<?php
/**
 * Dette scriptet tar seg av å logge ut brukeren og sender han tilbake der han kom fra.
 */
require_once('config.php');
session_start();
//Logger brukeren ut
unset($_SESSION['user']);
//Hvis det er satt en returadresse vil bruker bli sendt ditt
if(isset($_GET['returnToPage'])){
	if($_GET['returnToPage'] == ""){
        $alert = new Alert(Alert::SUCCESS, 'Du er nå logget ut. Du trenger ikke å uroe deg for NSA lengere');
        $alert->displayOnIndex();
	}else{
        $alert = new Alert(Alert::SUCCESS, 'Du er nå logget ut. Du trenger ikke å uroe deg for NSA lengere');
        $alert->displayOnOtherPage($_GET['returnToPage']);
	}
}