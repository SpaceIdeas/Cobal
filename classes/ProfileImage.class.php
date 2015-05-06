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
    private $mimeType;

    public function __construct($picture, $mimeType, $userEmail) {
        $this->picture = $picture;
        $this->userEmail = $userEmail;
        $this->mimeType = $mimeType;
    }

    public function getPicture() {
        return $this->picture;
    }

    public function getMIMEType() {
        return $this->mimeType;
    }

    public function updateDB (PDO $db) {
        try {
            $statement = $db->prepare("UPDATE USER SET PROFILE_IMAGE = ?, PROFILE_IMAGE_MIME_TYPE = ? WHERE EMAIL = ?");
            return $statement->execute(array($this->picture, $this->mimeType, $this->userEmail));
        }
        catch(PDOException $e) {
            return false;
        }
    }

    public static function getProfileImage(PDO $db, $userEmail) {
        try {
            $statement = $db->prepare("SELECT PROFILE_IMAGE, PROFILE_IMAGE_MIME_TYPE FROM USER WHERE EMAIL = ? AND PROFILE_IMAGE IS NOT NULL");

            if ($statement->execute(array($userEmail))) {
                $result = $statement->fetch();
                if($statement->rowCount() > 0) {
                    return new ProfileImage($result[0], $result[1], $userEmail);
                }
                else{
                    return null;
                }

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