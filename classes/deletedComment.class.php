<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 03/05/2015
 * Tid: 14:34
 * All Rights Reserved
 */

class deletedComment {
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

    /**
     * @return mixed
     */
    public function getAuthorUsername()
    {
        return $this->AUTHOR_USERNAME;
    }

    /**
     * @param mixed $AUTHOR_USERNAME
     */
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

    /**
     * @return mixed
     */
    public function getTimeDeleted()
    {
        return $this->TIME_DELETED;
    }

    /**
     * @param mixed $TIME_DELETED
     */
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

    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
    }

    public static function rowToDeletedComment($row){
        $deletedComment = new Comment();
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
     * Henter alle slettede kommentarer ved å bruke view-en DELETED_COMMENT
     * @param PDO $db
     * @return array|null
     */
    public static function getAllDeletedComments(PDO $db){
        try{
            $statement = $db->prepare("SELECT COMMENT_ID, TEXT, AUTHOR_EMAIL, AUTHOR_USERNAME, TIME_CREATED, TIME_DELETED, POST_ID FROM DELETED_COMMENT");
            $statement->execute();
            $deletedComments = [];
            while ($row = $statement->fetch()){
                $deletedComments[] = DeletedComment::rowToDeletedComment($row);
            }
            return $deletedComments;
        }catch(Exception $e) {
            return null;
        }
    }



    /**
     * Henter en kommentar fra databasen basert på en kommentar id
     * @param $db
     * @param $id
     * @return mixed
     *//*
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
    */
}