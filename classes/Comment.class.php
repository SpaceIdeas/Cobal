<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 15:01
 */

class Comment {
    /**
     * @var int $ID                     Den unike IDen til kommentaren
     * @var string $TEXT                Teksten til kommentaren
     * @var string $AUTHOR_EMAIL        Email til forfatteren av kommentaren
     * @var DateTime $TIME_CREATED      Tidspunktet kommentaren ble laget
     * @var int $POST_ID                Den unike IDen til innlegget kommentaren ble skrevet til
     * @var bool $DELETED               Angir om kommentaren er slettet
     */
    private $ID;
    private $TEXT;
    private $AUTHOR_EMAIL;
    private $TIME_CREATED;
    private $POST_ID;
    private $DELETED;


    public function getID(){
        return $this->ID;
    }

    /**
     * Setter den unike Iden til kommentaren
     *
     * @param int $id
     */
    public function setID($id){
        $this->ID = $id;
    }

    public function getText(){
        return $this->TEXT;
    }

    /**
     * Setter teksten til kommentaren
     *
     * @param string $text
     */
    public function setText($text) {
        $this->TEXT = $text;
    }

    public function getAuthorEmail(){
        return $this->AUTHOR_EMAIL;
    }

    /**
     * Setter emailen til forfatteren av kommentaren
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail) {
        $this->AUTHOR_EMAIL = $authorEmail;
    }

    public function getTimeCreated(){
        return $this->TIME_CREATED;
    }

    /**
     * Setter tidspunktet kommentaren ble laget
     *
     * @param DateTime $timeCreated
     */
    public function setTimeCreated($timeCreated){
        $this->TIME_CREATED = $timeCreated;
    }

    public function getPostID(){
        return $this->POST_ID;
    }

    /**
     * Setter den unike IDen til innlegget kommentaren ble skrevet til
     *
     * @param int $postID
     */
    public function setPostID($postID) {
        $this->POST_ID = $postID;
    }

    public function isDeleted(){
        return $this->DELETED;
    }

    /**
     * Setter en bool som angir om kommentaren er slettet
     *
     * @param bool $deleted
     */
    public function setDeleted($deleted) {
        $this->DELETED = $deleted;
    }

    /**
     * Henter brukernavnet til forfatteren fra databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return null|String Brukernavnet til forfatteren. Null hvis noe går feil
     */
    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
    }

    /**
     * Gjør en rad fra en sql spørring om til et Comment objekt
     *
     * @param array $row
     * @return Comment
     */
    public static function rowToComment($row){
        $comment = new Comment();
        $comment->setID($row['ID']);
        $comment->setText($row['TEXT']);
        $comment->setAuthorEmail($row['AUTHOR_EMAIL']);
        $comment->setTimeCreated($row['TIME_CREATED']);
        $comment->setPostID($row['POST_ID']);
        $comment->setDeleted($row['DELETED'] == 0?false:true);
        return $comment;
    }

    /**
     * Legger kommentaren til i databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return bool True hvis kommentaren ble lagt til
     */
    public function addToDB(PDO $db) {
        try
        {
            $statement = $db->prepare("INSERT INTO COMMENT (TEXT, AUTHOR_EMAIL, POST_ID, TIME_CREATED) VALUES (?, ?, ?, NOW())");
            return $statement->execute(array(htmlentities($this->TEXT), $this->AUTHOR_EMAIL, $this->POST_ID));
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Sletter en kommentar
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return bool
     */
    public function deleteComment(PDO $db){
        try
        {
            //Først blir kommentaren satt inn i loggen for slettede kommentarer
            $statement = $db->prepare("INSERT INTO COMMENT_DELETE_LOG (COMMENT_ID, TIME_DELETED, TEXT) VALUES (?, NOW(), ?)");
            $insertResult = $statement->execute(array($this->ID, $this->TEXT));
            //Deretter blir kommentaren satt som slettet i tabellen for kommentarer
            $statement = $db->prepare("UPDATE COMMENT SET TEXT = 'Slettet', DELETED = 1  WHERE ID = ?");
            $deleteResult = $statement->execute(array($this->ID));
            if($insertResult && $deleteResult){
                return true;
            }
            return false;
        }catch(Exception $e) {
            return false;
        }
    }



    /**
     * Henter en kommentar fra databasen basert på en kommentar id
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param $id
     * @return mixed
     */
    public static function getCommentByID(PDO $db, $id){
        try{
            $statement = $db->prepare("SELECT ID, TEXT, AUTHOR_EMAIL, TIME_CREATED, POST_ID, DELETED FROM COMMENT WHERE ID = ?");
            $statement->execute(array($id));
            $row = $statement->fetch();
            $comment = Comment::rowToComment($row);
            return $comment;
        }catch(Exception $e) {
            return null;
        }
    }

    /**
     * Henter alle kommenratene til et innlegg fra databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param Post $post Den unike IDen til innlegget kommentarene skal hentes fra.
     * @return array
     */
    public static function  getCommentsByPost(PDO $db, Post $post) {
        $statement = $db->prepare("SELECT ID, TEXT, AUTHOR_EMAIL, TIME_CREATED, POST_ID, DELETED FROM COMMENT WHERE POST_ID = ? ORDER BY TIME_CREATED DESC");
        $statement->bindParam(1, $post->getID());
        $statement->execute();
        $comments = [];
        while ($row = $statement->fetch()) {
            $comments[] = Comment::rowToComment($row);
        }
        return $comments;
    }

    /**
     * Henter antallet kommentarer i et innlegg
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param Post $post Den unike IDen til innlegget informasjonen skal hentes fra.
     * @return int Antallet kommentarer i innlegget
     */
    public static function  getCommentCount(PDO $db, Post $post) {
        $statement = $db->prepare("SELECT COUNT(ID) FROM COMMENT WHERE POST_ID = ?");
        $statement->bindParam(1, $post->getID());
        $statement->execute();
        return $statement->fetch()['COUNT(ID)'];
    }
}