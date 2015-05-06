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

    public function __construct($picture, $userEmail) {
        $this->picture = $picture;
        $this->userEmail = $userEmail;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function updateDB (PDO $db) {
        try {
            $statement = $db->prepare("UPDATE USER SET PROFILE_IMAGE = ? WHERE EMAIL = ?");
            return $statement->execute(array($this->picture, $this->userEmail));
        }
        catch(PDOException $e) {
            return false;
        }
    }

    public static function getProfileImage(PDO $db, $userEmail) {
        try {
            $statement = $db->prepare("SELECT PROFILE_IMAGE FROM USER WHERE EMAIL = ?");

            if ($statement->execute(array($userEmail))) {
                $result = $statement->fetch();
                return new ProfileImage($result[0], $userEmail);
            }
            else {
                return null;
            }
        }
        catch(PDOException $e) {
            return null;
        }
    }
}