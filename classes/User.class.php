<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 23/04/2015
 * Time: 10:54
 */

class User {

    private $email;          // Holds the users username
    private $full_name;       // Holds the users full name
    private $IPAddress;         // Holds the users login IP address
    private $UserAgent;         // Holds the users user agent (browser ID)

    function __construct($email, $full_name) {
        $this->email = $email;
        $this->full_name = $full_name;
        $this->IPAddress = $_SERVER["REMOTE_ADDR"];
        $this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    public function getEmail() {
        return $this->email;
    }
    public function getFullName() {
        return $this->full_name;
    }
    public function getIPAddress() {
        return $this->IPAddress;
    }
    public function verifyUser() {
        if(($this->IPAddress == $_SERVER["REMOTE_ADDR"]) && ($this->UserAgent == $_SERVER['HTTP_USER_AGENT'] )){
            return true;
        }
        else
            return false;
    }


    public static function login($db, $email, $password) {
        try{
            $stmt = $db->prepare("SELECT email, password, full_name FROM blog_user WHERE email = ?");
            $stmt->bindParam(1, $email);
            $stmt->execute();
            if ($row = $stmt->fetch() )
            {
                $hashpassord = $row["password"];
                if($hashpassord == sha1($password)){
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user'] = new User($email , $row["full_name"]);
                    return true;
                }
            }else {
                return false;
            }
        }catch(Exception $e) {
            throw($e);
        }

        return false;
    }
}