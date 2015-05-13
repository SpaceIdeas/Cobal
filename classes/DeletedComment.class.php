<?php

/**
 * Class DeletedComment Representerer en slettet kommentar fra databasen
 */
class DeletedComment {

    /**
     * @var int $ID                     Den unike IDen til kommentaren
     */
    private $ID;
    /**
     * @var string $TEXT                Teksten til kommentaren
     */
    private $TEXT;
    /**
     * @var string $AUTHOR_EMAIL        Email til forfatteren av kommentaren
     */
    private $AUTHOR_EMAIL;
    /**
     * @var string $AUTHOR_USERNAME     Brukernavnet til forfatteren av kommentaren
     */
    private $AUTHOR_USERNAME;
    /**
     * @var DateTime $TIME_CREATED      Tidspunktet kommentaren ble laget
     */
    private $TIME_CREATED;
    /**
     * @var DateTime $TIME_DELETED      Tidspunktet kommentaren ble slettet
     */
    private $TIME_DELETED;
    /**
     * @var int $POST_ID                Den unike IDen til innlegget kommentaren ble skrevet til
     */
    private $POST_ID;

    /**
     * Henter IDen til kommentaren
     *
     * @return int
     */
    public function getID(){
        return $this->ID;
    }

    /**
     * Setter den unike IDen til kommentaren
     *
     * @param int $id
     */
    public function setID($id){
        $this->ID = $id;
    }

    /**
     * Henter teksten til kommentaren
     *
     * @return string
     */
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

    /**
     * Henter emailen til forfatteren av kommentaren
     *
     * @return string
     */
    public function getAuthorEmail(){
        return $this->AUTHOR_EMAIL;
    }

    /**
     * Setter email til forfatteren av kommentaren
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail) {
        $this->AUTHOR_EMAIL = $authorEmail;
    }

    /**
     * Henter brukernavnet til forfatteren av kommentaren
     *
     * @return string
     */
    public function getAuthorUsername()
    {
        return $this->AUTHOR_USERNAME;
    }

    /**
     * Setter brukernavnet til forfatteren av kommentaren
     *
     * @param string $AUTHOR_USERNAME
     */
    public function setAuthorUsername($AUTHOR_USERNAME)
    {
        $this->AUTHOR_USERNAME = $AUTHOR_USERNAME;
    }

    /**
     * Henter tidspunktet kommentaren ble opprettet
     *
     * @return DateTime
     */
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

    /**
     * Henter tidspunktet kommentaren ble slettet
     *
     * @return DateTime
     */
    public function getTimeDeleted()
    {
        return $this->TIME_DELETED;
    }

    /**
     * Setter tidspunktet kommentaren ble slettet
     *
     * @param DateTime $timeDeleted
     */
    public function setTimeDeleted($timeDeleted)
    {
        $this->TIME_DELETED = $timeDeleted;
    }

    /**
     * Henter den unike IDen til innlegget kommentaren ble skrevet til
     *
     * @return int
     */
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

    /**
     * Gjennoppretter en slettet kommentar
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @return bool True hvis kommentaren ble gjenopprettet
     */
    public function restoreComment(PDO $db){
        try
        {
            $statement = $db->prepare("UPDATE COMMENT SET TEXT = ?, DELETED = 0 WHERE ID = ?");
            $updateResult = $statement->execute(array($this->TEXT, $this->ID));
            $statement = $db->prepare("DELETE FROM COMMENT_DELETE_LOG WHERE COMMENT_ID = ?");
            $deleteResult = $statement->execute(array($this->ID));
            if($updateResult && $deleteResult){
                return true;
            }
            return false;
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Gjør en PDO rad om til et DeletedComment objekt
     *
     * @param array $row Raden hentet ut en PDO spørring
     * @return DeletedComment Objektet laget ut fra verdiene i raden
     */
    public static function rowToDeletedComment($row){
        $deletedComment = new DeletedComment();
        $deletedComment->setID($row['COMMENT_ID']);
        $deletedComment->setText($row['TEXT']);
        $deletedComment->setAuthorEmail($row['AUTHOR_EMAIL']);
        $deletedComment->setAuthorUsername($row['AUTHOR_USERNAME']);
        $deletedComment->setTimeCreated($row['TIME_CREATED']);
        $deletedComment->setTimeDeleted($row['TIME_DELETED']);
        $deletedComment->setPostID($row['POST_ID']);
        return $deletedComment;
    }

    /**
     * Ignorerer et antall kommentarer og returnerer de neste 10, fra databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param int $offset Antallet kommentarer som skal ignoreres
     * @return array|null Et array av kommentarene som ble hentet
     */
    public static function getDeletedCommentsNextTenFrom(PDO $db, $offset){
        try{
            $statement = $db->prepare("SELECT COMMENT_ID, TEXT, AUTHOR_EMAIL, AUTHOR_USERNAME, TIME_CREATED, TIME_DELETED, POST_ID FROM DELETED_COMMENT LIMIT 10 OFFSET ?");
            $statement->bindParam(1, $offset, PDO::PARAM_INT);
            $statement->execute();
            $deletedComments = [];
            while ($row = $statement->fetch()){
                $deletedComments[] = DeletedComment::rowToDeletedComment($row);
            }
            return $deletedComments;
        }catch(PDOException $e) {
            return null;
        }
    }

    /**
     * Henter en slettet kommentar fra databasen basert på en kommentar id
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param $id
     * @return DeletedComment
     */
    public static function getDeletedCommentByID(PDO $db, $id){
        try{
            $statement = $db->prepare("SELECT COMMENT_ID, TEXT, AUTHOR_EMAIL, AUTHOR_USERNAME, TIME_CREATED, TIME_DELETED, POST_ID FROM DELETED_COMMENT WHERE COMMENT_ID = ?");
            $statement->execute(array($id));
            $row = $statement->fetch();
            $deletedComment = DeletedComment::rowToDeletedComment($row);
            return $deletedComment;
        }catch(Exception $e) {
            return null;
        }
    }
}