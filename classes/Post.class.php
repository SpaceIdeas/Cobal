<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 23.04.2015
 * Time: 13:07
 */

class Post {
    private $ID;
    private $TITLE;
    private $TEXT;
    private $AUTHOR_EMAIL;
    private $TIME_CREATED;

    /*
    public function __construct($title, $text, $authorEmail) {
        $this->TITLE = $title;
        $this->TEXT = $text;
        $this->AUTHOR_EMAIL = $authorEmail;
    } */

    public function getID() {
        return $this->ID;
    }

    public function getTitle() {
        return $this->TITLE;
    }

    public function getText() {
        return $this->TEXT;
    }

    public function getAuthorEmail() {
        return $this->AUTHOR_EMAIL;
    }

    public function getTimeCreated() {
        return $this->TIME_CREATED;
    }


    public function getShortText() {
        return substr($this->TEXT, 0, 150) . '...';
    }

    public function addToDB(PDO $db) {
        try
        {
            $statement = $db->prepare("INSERT INTO POST (TITLE, TEXT, AUTHOR_EMAIL) VALUES (?, ?, ?)");
            return $statement->execute(array($this->TITLE, $this->TEXT, $this->$AUTHOR_EMAIL));
        }catch(Exception $e) {
            return false;
        }
    }

    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
    }

    public static function  getPost(PDO $db, $id) {
        $statement = $db->prepare("SELECT * FROM POST WHERE ID = ?");
        $statement->bindParam(1, $id);
        $statement->execute();
        return $statement->fetchObject('Post');
    }

    public static function  getAllPosts(PDO $db) {
        $statement = $db->prepare("SELECT * FROM POST");
        $statement->execute();
        $posts = [];
        while ($post = $statement->fetchObject('Post')) {
            $posts[] = $post;
        }
        return $posts;
    }

    public function getComments(PDO $db) {
        return Comment::getCommentsByPost($db, $this);
    }

    public function getCommentCount(PDO $db) {
        return Comment::getCommentCount($db, $this);
    }

    public function getNextPostID(PDO $db) {
        return $this->ID + 1;
    }

    public function getPreviousPostID(PDO $db) {
        return $this->ID - 1;
    }

    public function hasNextPostID(PDO $db) {
        return true;
    }

    public function hasPreviousPostID(PDO $db) {
        return false;
    }






}