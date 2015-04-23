<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 12:44
 */

    $host = "kark.hin.no";
    $dbname = "stud_v15_stien";
    $username = "stien";
    $password = "etnyttogbrapassord";

	try
    {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }
    catch(PDOException $e)
    {
        throw new Exception($e->getMessage(), $e->getCode);
    }
?>