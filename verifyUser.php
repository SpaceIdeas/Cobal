<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 27.04.2015
 * Time: 10:30
 */
echo 'hello2';
require_once('config.php');
require_once('libs/Smarty.class.php');
require_once('db.php');
echo 'hello1';
if ($_GET ['token']) {
    User::verifyUserEmail($db, $_GET ['token']);
}

