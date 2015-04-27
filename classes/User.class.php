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

    function __construct($email, $username) {
        $this->email = $email;
        $this->username = $username;
        $this->IPAddress = $_SERVER["REMOTE_ADDR"];
        $this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function getEmail() {
        return $this->email;
    }
    public function getUsername() {
        return $this->username;
    }
    public function getIPAddress() {
        return $this->IPAddress;
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
               return htmlentities($row["USERNAME"]);
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
            $stmt = $db->prepare("SELECT EMAIL, PWD_HASH, SALT, USERNAME FROM USER WHERE EMAIL = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch() )
            {
                $hashpassord = $row["PWD_HASH"];
                $salt = $row["SALT"];
                if($hashpassord == sha1($password . $salt)){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = new User(htmlentities($email) , htmlentities($row["USERNAME"]));
                    return true;
                }
            }else {
                return false;
            }
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
            //Binder parametrene og lager passord hashen
            //$stmt->bindParam(array($email, sha1($password . $salt),$salt, $username);
            $result = $stmt->execute(array($email, sha1($password . $salt), $salt, $username));
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