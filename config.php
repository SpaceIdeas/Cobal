<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 11:29
 */
function __autoload($class) {
    require_once(_DIR_ . 'classes' .  DIRECTORY_SEPARATOR . $class . 'class.php');
}