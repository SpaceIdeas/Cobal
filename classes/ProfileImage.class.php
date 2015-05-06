<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 06.05.2015
 * Time: 14:33
 */

class ProfileImage {
    private $picture;
    private $userEmail;

    function __construct($picture, $userEmail) {
        $this->picture = $picture;
        $this->userEmail = $userEmail;
    }

    function updateDB (PDO $db) {
        try {
            $statement = $db->prepare("UPDATE USER SET PROFILE_IMAGE = ? WHERE EMAIL = ?");
            $statement->execute(array($this->picture, $this->userEmail));
        }
        catch(PDOException $e)


    }
}