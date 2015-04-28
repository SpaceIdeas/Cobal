<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 28.04.2015
 * Time: 10:15
 */
require_once('config.php');
session_start();
$alert = new Alert(Alert::ERROR, 'hello');
$alert->displayOnIndex();