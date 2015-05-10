<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 06.05.2015
 * Time: 14:33
 */

/**
 * Class ProfileImage er en klasse som håndterer profilbilder til en bruker.
 *
 * Klassen inneholder e-postadressen til brukeren. Profilbilde-dataen samt mimetypen til bildet.
 */
class ProfileImage {
    private $picture;
    private $userEmail;
    private $mimeType;

    /**
     * Opretter et nytt ProfileImage
     *
     * @param blob $picture Bildetdataen
     * @param string $mimeType Mime-typen til bildet
     * @param string $userEmail E-postadressen til brukeren som bildet tilhører
     */
    public function __construct($picture, $mimeType, $userEmail) {
        $this->picture = $picture;
        $this->userEmail = $userEmail;
        $this->mimeType = $mimeType;
    }

    /**
     * Returnerer bildedataen
     *
     * @return blob Bildedataen
     */
    public function getPicture() {
        return $this->picture;
    }

    /**
     * Returnerer bildes mimetype
     *
     * @return string MIME-typen
     */
    public function getMIMEType() {
        return $this->mimeType;
    }

    /**
     * Legger til bildet (ProfileImage) i databasen. Instansmetode.
     *
     * @param PDO $db Databasen som SQL-setning skal utføres på.
     * @return bool Om insettingen av bildet var velykket eller ikke
     */
    public function updateDB (PDO $db) {
        try {
            $statement = $db->prepare("UPDATE USER SET PROFILE_IMAGE = ?, PROFILE_IMAGE_MIME_TYPE = ? WHERE EMAIL = ?");
            // Execute returnerer true eller false om vellykket eller ikke.
            return $statement->execute(array($this->picture, $this->mimeType, $this->userEmail));
        }
        catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Henter ut bildet fra databsen.
     *
     * @param PDO $db Databasen som som spørring skal utføres mot.
     * @param string $userEmail E-postadressen som tilhører brukren med profilbildet.
     * @return null|ProfileImage Hvis brukeren har profilbilde returneres et nytt ProfileImage. Hvis ikke null.
     */
    public static function getProfileImage(PDO $db, $userEmail) {
        try {
            $statement = $db->prepare("SELECT PROFILE_IMAGE, PROFILE_IMAGE_MIME_TYPE FROM USER WHERE EMAIL = ? AND PROFILE_IMAGE IS NOT NULL");

            if ($statement->execute(array($userEmail))) {
                $result = $statement->fetch();
                if($statement->rowCount() > 0) {
                    // Oppretter et nytt ProfileImage med bildedaten og MIME-Type
                    return new ProfileImage($result[0], $result[1], $userEmail);
                }
                // Brukeren har ikke profilbilde
                else{
                    return null;
                }

            }
            // Feil oppstod
            else {
                return null;
            }
        }
        catch(PDOException $e) {
            return null;
        }
    }
}