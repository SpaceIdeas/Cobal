<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 14:34
 * All Rights Reserved
 */

class DeletedComment {
    /**
     * @var int $ID                     Den unike IDen til kommentaren
     * @var string $TEXT                Teksten til kommentaren
     * @var string $AUTHOR_EMAIL        Email til forfatteren av kommentaren
     * @var string $AUTHOR_USERNAME     Brukernavnet til forfatteren av kommentaren
     * @var DateTime $TIME_CREATED      Tidspunktet kommentaren ble laget
     * @var DateTime $TIME_DELETED      Tidspunktet kommentaren ble slettet
     * @var int $POST_ID                Den unike IDen til innlegget kommentaren ble skrevet til
     */
    private $ID;
    private $TEXT;
    private $AUTHOR_EMAIL;
    private $AUTHOR_USERNAME;
    private $TIME_CREATED;
    private $TIME_DELETED;
    private $POST_ID;

    public function getID(){
        return $this->ID;
    }

    public function setID($id){
        $this->ID = $id;
    }

    public function getText(){
        return $this->TEXT;
    }

    public function setText($text) {
        $this->TEXT = $text;
    }

    public function getAuthorEmail(){
        return $this->AUTHOR_EMAIL;
    }

    public function setAuthorEmail($authorEmail) {
        $this->AUTHOR_EMAIL = $authorEmail;
    }

    public function getAuthorUsername()
    {
        return $this->AUTHOR_USERNAME;
    }

    public function setAuthorUsername($AUTHOR_USERNAME)
    {
        $this->AUTHOR_USERNAME = $AUTHOR_USERNAME;
    }

    public function getTimeCreated(){
        return $this->TIME_CREATED;
    }

    public function setTimeCreated($timeCreated){
        $this->TIME_CREATED = $timeCreated;
    }

    public function getTimeDeleted()
    {
        return $this->TIME_DELETED;
    }

    public function setTimeDeleted($TIME_DELETED)
    {
        $this->TIME_DELETED = $TIME_DELETED;
    }

    public function getPostID(){
        return $this->POST_ID;
    }

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