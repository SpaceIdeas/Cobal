<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 11:29
 */
require_once ('libs'. DIRECTORY_SEPARATOR . 'htmlpurefier' . DIRECTORY_SEPARATOR . 'HTMLPurifier.auto.php');


spl_autoload_extensions('.class.php');
function classLoader($class){
    $filename = $class . '.class.php';
    $file ='classes'. DIRECTORY_SEPARATOR . $filename;

    // Smarty ligger i libs-mappa.
    if ($class == 'Smarty') {
        $file = 'libs' . DIRECTORY_SEPARATOR . $filename;
    }
    if (!file_exists($file))
    {
        return false;
    }

    include $file;
}

spl_autoload_register('classLoader');
