<?php
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['user']);
if(isset($_GET['returnToPage'])){
	if($_GET['returnToPage'] == ""){
		header("Location: " . "index.php");
	}else{
		header("Location: " . $_GET['returnToPage']);
	}
}