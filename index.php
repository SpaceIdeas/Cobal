<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 22/04/2015
 * Time: 17:40
 */
include('libs/Smarty.class.php');
echo "hello world<br/>";
echo " This is a unix system<br/>";
echo "Also Tennesi burger<br/>";
echo "hello my name is macintosh<br/>";
$smarty = new Smarty();
$smarty->display('index.tpl');