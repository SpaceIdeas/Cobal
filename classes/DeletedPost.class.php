<?php
/**
 * Laget i PhpStorm.
 * Laget av: Håvard Stien
 * Dato: 10/05/2015
 * Tid: 18:57
 * All Rights Reserved
 */

class DeletedPost {
    private $POST_ID;
    private $TITLE;
    private $TEXT;
    private $AUTHOR_EMAIL;
    private $AUTHOR_USERNAME;
    private $TIME_CREATED;
    private $TIME_DELETED;
    private $HITS;

    public function getPostID(){
        return $this->POST_ID;
    }

    public function setPostID($postID){
        $this->POST_ID = $postID;
    }

    public function getTitle(){
        return $this->TITLE;
    }

    public function setTitle($title) {
        $this->TITLE = $title;
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

    public function getHits(){
        return $this->HITS;
    }

    public function setHits($hits) {
        $this->HITS = $hits;
    }


    /**
     * Henter alle innleggene i log over slettede innlegg
     *
     * @param PDO $db
     * @return array|null
     */
    public static function getAllDeletedPosts(PDO $db){
        try{
            $statement = $db->prepare("SELECT POST_ID, TITLE, TEXT, AUTHOR_EMAIL, USERNAME as AUTHOR_USERNAME, POST_DELETE_LOG.TIME_CREATED, TIME_DELETED, HITS FROM POST_DELETE_LOG JOIN USER ON AUTHOR_EMAIL = EMAIL ORDER BY TIME_DELETED DESC");
            $statement->execute();
            $deletedPosts = [];
            while ($deletedPost = $statement->fetchObject('DeletedPost')){
                $deletedPosts[] = $deletedPost;
            }
            return $deletedPosts;
        }catch(Exception $e) {
            return null;
        }
    }

    /**
     * Ignorerer et antall innlegg og returnerer de neste 10, fra databasen
     * @param PDO $db
     * @param int $offset Antallet innlegg som skal ignoreres
     * @return array|null
     */
    public static function getPostNextTenFrom(PDO $db, $offset){
        try{
            $statement = $db->prepare("SELECT POST_ID, TITLE, TEXT, AUTHOR_EMAIL, USERNAME as AUTHOR_USERNAME, POST_DELETE_LOG.TIME_CREATED, TIME_DELETED, HITS FROM POST_DELETE_LOG JOIN USER ON AUTHOR_EMAIL = EMAIL ORDER BY TIME_DELETED DESC LIMIT 10 OFFSET ?");
            $statement->bindParam(1, $offset, PDO::PARAM_INT);
            $statement->execute();
            $deletedPosts = [];
            while ($deletedPost = $statement->fetchObject('DeletedPost')){
                $deletedPosts[] = $deletedPost;
            }
            return $deletedPosts;
        }catch(PDOException $e) {
            return null;
        }
    }

}