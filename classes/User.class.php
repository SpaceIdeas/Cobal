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
            $stmt = $db->prepare("SELECT USERNAME FROM 'USER' WHERE EMAIL = ?");
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

/** TODO: sammenligner hashen i databasen */
    /**
     * Logger en bruker på siden
     * @param $db
     * @param $email
     * @param $password
     * @return bool
     * @throws Exception
     */
    public static function login($db, $email, $password) {
        try{
            $stmt = $db->prepare("SELECT EMAIL, PWD_HASH, SALT, USERNAME FROM 'USER' WHERE EMAIL = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch() )
            {
                $hashpassord = $row["PWS_HASH"];
                $salt = $row["SALT"];
                if($hashpassord == sha1($password + $salt)){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = new User($email , $row["USERNAME"]);
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
    public static function registerUser($db, $email, $password, $username) {
        try{

            //Generere saltet
            $salt = generateSalt();

            $stmt = $db->prepare("INSERT INTO 'USER' (EMAIL, PWD_HASH, SALT, USERNAME) VALUES (?, ?, ?, ?)");
            //Binder parametrene og lager passord hashen
            $stmt->bindParam(1, $email, 2, sha1($password . $salt), 3, $salt, 4, $username);
            $result = $stmt->execute();
            //Returnerer om INSERT setningen var vellykket
            return $result;

        }catch(Exception $e) {
            return false;
        }

    }


    /**
     * Genererer et salt på 15 karakterer
     * @return string
     */
    function generateSalt() {
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