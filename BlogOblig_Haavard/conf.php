<?php
//Fikk denne koden av Silje Thune Hauknes
function Autoloader($class_name){
	require_once __DIR__ . DIRECTORY_SEPARATOR. $class_name . '.class' . '.php';
}

spl_autoload_register('Autoloader');
