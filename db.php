<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 12:44
 */
/**
 * Dette er filen som oppretter et nytt databaseobjekt og inneholder brukernavn og passord til databasen.
 */


/**
 * @var string $host Adressen til databasen
 * @var string $dbname Navenet til databasen
 * @var string $username brukernavnet til databasen
 * @var string $password  passordet til databasen
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