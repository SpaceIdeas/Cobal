<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
require_once('libs/Smarty.class.php');
require_once('config.php');
$smarty = new Smarty();
$smarty->display('index.tpl');