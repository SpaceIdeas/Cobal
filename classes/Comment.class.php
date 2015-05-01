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


    public function getID(){
    $this->ID;
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

    public function getPostID(){
        return $this->POST_ID;
    }

    public function setPostID($postID) {
        $this->POST_ID = $postID;
    }

    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
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

    public function deleteComment(PDO $db){
        try
        {
            $statement = $db->prepare("INSERT INTO COMMENT_DELETE_LOG (COMMENT_ID, TIME_DELETED, TEXT) VALUES (?, NOW(), ?)");
            $insertResult = $statement->execute(array($this->ID, $this->TEXT));
            $statement = $db->prepare("UPDATE COMMENT SET TEXT = ? WHERE ID = ?");
            $deleteResult = $statement->execute(array("Denne kommentaren ble slettet " . new DateTime, $this->ID));
            if($insertResult && $deleteResult){
                return true;
            }
            return false;
        }catch(Exception $e) {
            return false;
        }
    }

    public static function  getCommentsByPost(PDO $db, Post $post) {
        $statement = $db->prepare("SELECT * FROM COMMENT WHERE POST_ID = ? ORDER BY TIME_CREATED DESC");
        $statement->bindParam(1, $post->getID());
        $statement->execute();
        $comments = [];
        while ($comment = $statement->fetchObject('Comment')) {
            $comments[] = $comment;
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