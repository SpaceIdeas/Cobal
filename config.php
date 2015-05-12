<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 11:29
 */
/**
 * Denne filen inneholder autoladeren slik at vi slipper å laste inn klassene manuelt.
 */

// Autoloader for HTMLPurefier
require_once ('libs'. DIRECTORY_SEPARATOR . 'htmlpurefier' . DIRECTORY_SEPARATOR . 'HTMLPurifier.auto.php');


spl_autoload_extensions('.class.php');
/**
 * Autoloader som laster inn dan classen som trengs
 *
 * @param $class
 * @return bool
 */
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
