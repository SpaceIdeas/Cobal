<?php
session_start();
unset($_SESSION['loggedin']);
if(isset($_GET['return'])){
	if($_GET['return'] == ""){
		header("Location: " . "index.php");
	}else{
		header("Location: " . $_GET['return']);
	}
}