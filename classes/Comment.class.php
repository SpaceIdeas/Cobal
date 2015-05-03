<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 15:01
 */

class Comment {
    private $ID;
    private $TEXT;
    private $AUTHOR_EMAIL;
    private $TIME_CREATED;
    private $POST_ID;
    private $DELETED;


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

    public function getTimeCreated(){
        return $this->TIME_CREATED;
    }

    public function setTimeCreated($timeCreated){
        $this->TIME_CREATED = $timeCreated;
    }

    public function getPostID(){
        return $this->POST_ID;
    }

    public function setPostID($postID) {
        $this->POST_ID = $postID;
    }

    public function isDeleted(){
        return $this->DELETED;
    }

    public function setDeleted($deleted) {
        $this->DELETED = $deleted;
    }


    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
    }

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
     * @param PDO $db
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
     * @param $db
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

    public static function  getCommentCount(PDO $db, Post $post) {
        $statement = $db->prepare("SELECT COUNT(ID) FROM COMMENT WHERE POST_ID = ?");
        $statement->bindParam(1, $post->getID());
        $statement->execute();
        return $statement->fetch()['COUNT(ID)'];
    }
}