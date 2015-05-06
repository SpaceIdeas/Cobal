<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 23/04/2015
 * Time: 10:54
 */

class User {

    private $email;          // Holds the users username
    private $username;       // Holds the users full name
    private $IPAddress;         // Holds the users login IP address
    private $UserAgent;         // Holds the users user agent (browser ID)
    private $admin;       // Blir brukt for å finne ut om en bruker har administratorrettigheter

    function __construct($email, $username, $admin) {
        $this->email = $email;
        $this->username = $username;
        $this->admin = $admin;
        $this->IPAddress = $_SERVER["REMOTE_ADDR"];
        $this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function getEmail() {
        return $this->email;
    }
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($newUsername){
        $this->username = $newUsername;
    }

    public function getIPAddress() {
        return $this->IPAddress;
    }
    public function isAdmin(){
        return $this->admin;
    }

    /**
     * Sjekker om brukerens session har blit stjålet
     * @return bool
     */
    public function verifyUser() {
        if(($this->IPAddress == $_SERVER["REMOTE_ADDR"]) && ($this->UserAgent == $_SERVER['HTTP_USER_AGENT'] )){
            return true;
        }
        else
            return false;
    }

    /**
     * Setter brukernavnet til brukeren inn i databasen
     * @param PDO $db
     * @return bool
     */
    public function updateUsername(PDO $db){
        try{
            $stmt = $db->prepare("UPDATE USER SET USERNAME  = ? WHERE EMAIL = ?");
            //Binder parametrene og utfører statmenten
            $result = $stmt->execute(array(htmlentities($this->username), $this->email));
            //Returnerer om UPDATE setningen var vellyket
            return $result;

        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Henter username fra databasen gitt email
     * @param PDO $db
     * @param $email
     * @return String username
     * @throws Exception
     */
    public static function getUsernameFromDB(PDO $db, $email){
        try{
            $stmt = $db->prepare("SELECT USERNAME FROM USER WHERE EMAIL = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch() )
            {
               return $row["USERNAME"];
            }else {
                return null;
            }
        }catch(Exception $e) {
            throw ($e);
        }
    }

    /**
     * Logger en bruker på siden
     * @param $db
     * @param $email
     * @param $password
     * @return bool
     * @throws Exception
     */
    public static function login(PDO $db, $email, $password) {
        try{
            $stmt = $db->prepare("SELECT EMAIL, PWD_HASH, SALT, USERNAME, ADMIN FROM USER WHERE EMAIL = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch() )
            {
                $hashpassord = $row["PWD_HASH"];
                $salt = $row["SALT"];
                if($hashpassord == sha1($password . $salt)){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = new User($email , $row["USERNAME"], $row['ADMIN']==1?true:false);
                    return true;
                }
            }else {
                return false;
            }
        }catch(Exception $e) {
            return false;
        }


    }

    public static function getProfileImage(PDO $db, $email) {
        try{
            $stmt = $db->prepare("SELECT PROFILE_IMAGE FROM USER WHERE EMAIL = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch()) {
                return $profileImage = $row["PROFILE_IMAGE"];
                }
            else{
                return null;
            }
        }catch(Exception $e) {
            return null;
        }




    }






    /**
     * Gir en bruker administratorrettigheter ved å legge dette til i databasen
     * @param PDO $db
     * @param $email
     * @return bool
     */
    public static function makeAdmin(PDO $db, $email){
        try{
            $stmt = $db->prepare("UPDATE USER SET ADMIN  = ? WHERE EMAIL = ?");
            //Binder parametrene og utfører statmenten
            $result = $stmt->execute(array(1, $email));
            //Returnerer om UPDATE setningen var vellyket
            return $result;

        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Legger en bruker til i databasen
     * @param $db
     * @param $email
     * @param $password
     * @param $username
     * @return bool
     * @throws Exception
     */
    public static function registerUser(PDO $db, $email, $password, $username) {
        try{

            //Generere saltet
            $salt = USER::generateSalt();

            $stmt = $db->prepare("INSERT INTO USER (EMAIL, PWD_HASH, SALT, USERNAME) VALUES (?, ?, ?, ?)");
            //Binder parametrene og utfører statmenten
            $result = $stmt->execute(array(htmlentities($email), sha1($password . $salt), $salt, htmlentities($username)));
            //Returnerer om INSERT setningen var vellykket
            return $result;

        }catch(Exception $e) {
            return false;
        }

    }

    public static function sendVerificationEmail (PDO $db, $userEmail) {
        $verificationToken = User::generateSalt();
        $statement = $db->prepare("UPDATE USER SET VERIFICATION_TOKEN  = ? WHERE EMAIL = ?");
        $statement->execute(array($verificationToken, $userEmail ));
        $verificationURL = "Token: " . $verificationToken;
        mail($userEmail, "Godkjenn din bruker på bloggen", $verificationURL, "From:danielsen.oeystein@gmail.com\r\n");
    }



    public static function verifyUserEmail(PDO $db, $verificationToken) {
        $statement = $db->prepare("UPDATE USER SET TIME_VERIFIED  = CURRENT_TIMESTAMP WHERE VERIFICATION_TOKEN = ? AND TIME_VERIFIED IS NULL");
        if ($statement->execute(array($verificationToken))) {
            return $statement->rowCount();
        }
        else {
            return -1;
        }
    }

    public static function sendNewPasswordEmail (PDO $db, $userEmail) {
        $lostPwdToken = User::generateSalt();
        $statement = $db->prepare("UPDATE USER SET LOST_PWD_TOKEN  = ? WHERE EMAIL = ?");
        if ($statement->execute(array($lostPwdToken, $userEmail ))) {
            $lostPwdnURL = "Token: " . $lostPwdToken;
            mail($userEmail, "Få et nytt passord", $lostPwdnURL, "From:danielsen.oeystein@gmail.com\r\n");
            return true;
        }
        else {
            return false;
        }
    }

    public static function updatePassword(PDO $db, $userEmail, $password) {
        $salt = USER::generateSalt();
        $statement = $db->prepare("UPDATE USER SET PWD_HASH = ?, SALT = ?, LOST_PWD_TOKEN = NULL WHERE EMAIL = ?");
        return $statement->execute(array(sha1($password . $salt), $salt, $userEmail));
    }

    public static function updatePasswordFromToken(PDO $db, $token, $password) {
        $statement = $db->prepare("SELECT EMAIL FROM USER WHERE LOST_PWD_TOKEN = ?");
        $statement->bindParam(1, $token);
        $statement->execute();
        $row = $statement->fetch();
        if ($row != null) {
            return User::updatePassword($db, $row['EMAIL'], $password );
        }
        else {
            return false;
        }
    }

    /**
     * Genererer et salt på 15 karakterer
     * @return string
     */
     private static function generateSalt() {
        //Lengden på saltet
        $max = 15;
        //De forskjellige karakterene saltet kan bestå av
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            //Henter en tilfeldig karakter fra $characterList
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }
}