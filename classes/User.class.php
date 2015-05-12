<?php
/**
 * Created by PhpStorm.
 * User: Spaceslug
 * Date: 23/04/2015
 * Time: 10:54
 */

/**
 * Class User Håndterer alt som har med en brukerkonto å gjøre. Instansen av objektet inneholder relevant informasjone om brukeren.
 * Den har metoder for å hente mer. Klassen inneholder også statiske metoder som f.eks login og registrering
 * @todo Lage færre oppdate setninger
 */
class User {
    /**
     * @var string $email       Emailen til brukeren som også er den unike IDen
     * @var string $username    Brukernavnet til brukeren
     * @var string $IPAddress   Login IPadressen til brukeren
     * @var string $UserAgent   Login user agent (browser ID) til brukeren
     * @var bool $admin         Blir brukt for å finne ut om en bruker har administratorrettigheter, eller ikke
     */
    private $email;
    private $username;
    private $IPAddress;
    private $UserAgent;
    private $admin;

    /**
     * Konstruktøren til User
     *
     * @param string $email
     * @param string $username
     * @param bool $admin
     */
    function __construct($email, $username, $admin) {
        $this->email = $email;
        $this->username = $username;
        $this->admin = $admin;
        $this->IPAddress = $_SERVER["REMOTE_ADDR"];
        $this->UserAgent = $_SERVER['HTTP_USER_AGENT'];
    }

    /**
     * returnerer brukerens e-postadresse
     *
     * @return string Brukerens e-postadresse
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Returnerer brukerens brukernavn
     *
     * @return string Brukernavn
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Setter brukernavn (oppdater ikke databasen)
     *
     * @param string $newUsername Det nye brukernavnet
     */
    public function setUsername($newUsername){
        $this->username = $newUsername;
    }

    /**
     * Returnerer brukerens IP-adresse.
     *
     * @return string Brukerens IP-adresse
     */
    public function getIPAddress() {
        return $this->IPAddress;
    }

    /**
     * Returnerer om brukeren er admin
     *
     * @return bool
     */
    public function isAdmin(){
        return $this->admin;
    }

    /**
     * Sjekker om brukerens session har blit stjålet
     *
     * @return bool True hvis sessionen ikke er kapret
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
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return bool True hvis brukeren ble oppdatert
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
     * Tester om en bruker har vertifisert email sin enda
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return bool True hvis emailen er vertifisert. False ellers
     */
    public function isVerified(PDO $db){
        try{
            $stmt = $db->prepare("SELECT USERNAME FROM USER WHERE EMAIL = ? AND TIME_VERIFIED is not null");
            $stmt->bindParam(1, $this->email);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                return true;
            }
            else{
                return false;
            }
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Henter username fra databasen gitt email
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param String $email
     * @return null|String Returnerer brukernavnet. Null hvis noe gikk galt
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
        }catch(PDOException $e) {
            return null;
        }
    }

    /**
     * Bruker email og passord til å se om brukeren finnes i databasen. Returnerer brukeren hvis den finnes.
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param String $email
     * @param String $password
     * @return null|User Brukeren hvis login var vellyket
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
                    return new User($email , $row["USERNAME"], $row['ADMIN']==1?true:false);
                }
            }else {
                return null;
            }
        }catch(Exception $e) {
            return null;
        }


    }

    /**
     * Henter profilbilde til en bruker fra databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param $email
     * @return null|blob Bildet
     */
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
     * Returner et array med brukere som ikke er administratorer
     *
     * @param PDO $db Databasen det skal spørres mot
     * @return array|null Et array med normale brukere eller null ved feil
     */
    public static function getNonAdmins(PDO $db) {
        try {
            $statement = $db->prepare('SELECT EMAIL, USERNAME FROM USER WHERE ADMIN = 0');
            if ($statement->execute()) {
                $nonAdmins = [];
                while ($row = $statement->fetch()) {
                    $nonAdmins[] = new User($row['EMAIL'], $row['USERNAME'], 0 );
                }
                return $nonAdmins;
            }
            else {
                return null;
            }
        }
        catch(PDOException $e) {
            return null;
        }
    }

    /**
     * Returner et array med brukere som er administratorer
     *
     * @param PDO $db Databasen det skal spørres mot
     * @return array|null Et array med normale brukere eller null ved feil
     */
    public static function getAdmins(PDO $db) {
        try {
            $statement = $db->prepare('SELECT EMAIL, USERNAME FROM USER WHERE ADMIN = 1');
            if ($statement->execute()) {
                $admins = [];
                while ($row = $statement->fetch()) {
                    $admins[] = new User($row['EMAIL'], $row['USERNAME'], 1);
                }
                return $admins;
            }
            else {
                return null;
            }
        }
        catch(PDOException $e) {
            return null;
        }
    }

    /**
     * Gir en bruker administratorrettigheter ved å legge dette til i databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param $email
     * @return bool
     */
    public static function makeAdmin(PDO $db, $email){
        try{
            $stmt = $db->prepare("UPDATE USER SET ADMIN  = 1 WHERE EMAIL = ?");
            //Binder parametrene og utfører statmenten
            $result = $stmt->execute(array($email));
            //Returnerer om UPDATE setningen var vellyket
            return $result;

        }catch(PDOException $e) {
            return false;
        }
    }

    /**
     *
     *
     * @param PDO $db Databasen det skal utføres oppdateringer mot
     * @param string $email Brukerens e-postadresse
     * @return bool Om oppdateringen i databasen gikk bra
     */
    public static function makeNotAdmin(PDO $db, $email){
        try{
            $stmt = $db->prepare("UPDATE USER SET ADMIN = 0 WHERE EMAIL = ?");
            //Binder parametrene og utfører statmenten
            $result = $stmt->execute(array($email));
            //Returnerer om UPDATE setningen var vellyket
            return $result;

        }catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Legger en bruker til i databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param String $email Brukerens e-postadresse
     * @param String $password Brukereens valgte passord
     * @param String $username Brukerens valgte brukernavn
     * @return bool True hvis registreringen var vellykket
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

    /**
     * Metoden sender en epost til bruker slik at han kan vertifisere epostadressen sin og gjør nødvendiger i databasen.
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param string $userEmail E-postadressen til brukeren
     * @return bool Om alt gikk greit
     */
    public static function sendVerificationEmail (PDO $db, $userEmail) {
        try {
            $verificationToken = User::generateSalt();
            $statement = $db->prepare("UPDATE USER SET VERIFICATION_TOKEN  = ? WHERE EMAIL = ?");
            $statement->execute(array($verificationToken, $userEmail ));
            // Bruker selvlagt e-postklasse for sending av e-post om vertifisering av e-postadresse
            Email::send( $db, Email::VERIFY_EMAIL, $userEmail, $verificationToken);
            return true;
        }
        catch(PDOException $e) {
            return false;
        }

    }

    /**
     * Sjekker om tokenet som er gitt samsvarer med et vertifiseringstoken i databasen. Dersom treff i databasen
     * settes brukeren med treff som en vertifisert bruker.
     *
     * @param PDO $db Databasen som oppdateringen skal utføres på
     * @param string $verificationToken Tokenet som brukeren har gitt og forhåpentligvis fått på e-post
     * @return int Antallet rader som ble påvirket av oppdateringen i databasen. Skal være 1, -1 ved feil
     */
    public static function verifyUserEmail(PDO $db, $verificationToken) {
        $statement = $db->prepare("UPDATE USER SET TIME_VERIFIED  = CURRENT_TIMESTAMP WHERE VERIFICATION_TOKEN = ? AND TIME_VERIFIED IS NULL");
        if ($statement->execute(array($verificationToken))) {
            return $statement->rowCount();
        }
        else {
            return -1;
        }
    }

    /**
     * @param PDO $db Databasen som oppdateringen skal utføres mot
     * @param string $userEmail E-postadressen til brukeren som har glemt passordet sitt
     * @return bool Om brukeren ble funnet i databasen og om oppdatering er vellykket
     */
    public static function sendNewPasswordEmail (PDO $db, $userEmail) {
        try {
            $lostPwdToken = User::generateSalt();
            $statement = $db->prepare("UPDATE USER SET LOST_PWD_TOKEN  = ? WHERE EMAIL = ?");
            if ($statement->execute(array($lostPwdToken, $userEmail ))) {
                Email::send($db, Email::NEW_PASSWORD, $userEmail, $lostPwdToken);
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Oppdaterer passordet til brukeren i databasen ved hjelp av e-postadressen hans
     *
     * @param PDO $db
     * @param String $userEmail
     * @param String $password
     * @return bool True hvis oppdateringen var vellykket
     */
    public static function updatePassword(PDO $db, $userEmail, $password) {
        try{
            $salt = USER::generateSalt();
            $statement = $db->prepare("UPDATE USER SET PWD_HASH = ?, SALT = ?, LOST_PWD_TOKEN = NULL WHERE EMAIL = ?");
            return $statement->execute(array(sha1($password . $salt), $salt, $userEmail));
        }catch(PDOException $e) {
            return false;
        }

    }

    /**
     * Oppdaterer databasen med brukererens nye passord ved hjelp av tokenet han fikk på e-post
     *
     * @param PDO $db Databasen oppdateringe skal kjøres mot
     * @param string $token Tokenet for gjnnoppreting av passord som ble sendt til brukeren
     * @param string $password Det nye passordet brukeren har valgt
     * @return bool Om en bruker med et samsvarende token ble funnet og om oppdateringen var vellykket
     */
    public static function updatePasswordFromToken(PDO $db, $token, $password) {
        try {
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
        catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Genererer et salt på 15 karakterer
     *
     * @return string Salt på 15 karakterer
     */
     private static function generateSalt() {
        //Lengden på saltet
        $max = 15;
        //De forskjellige karakterene saltet kan bestå av
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%*?";
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