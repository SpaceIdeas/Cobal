<?php
/**
 * Created by PhpStorm.
 * User: Øystein
 * Date: 30.04.2015
 * Time: 19:49
 */

class Attachment {
    private $ID;
    private $DATA;
    private $MIME_TYPE;
    private $POST_ID;

    public function addToDB(PDO $db) {
        try
        {
            $statement = $db->prepare("INSERT INTO ATTACHMENT (DATA, MIME_TYPE, POST_ID) VALUES (?, ?, ?)");
            return $statement->execute(array($this->DATA, $this->MIME_TYPE, $this->POST_ID));
        }catch(Exception $e) {
            return false;
        }
    }

    public function getData() {
        return $this->DATA;
    }

    public function getPostID() {
        return $this->POST_ID;
    }

    public function getMIMEType() {
        return $this->MIME_TYPE;
    }

    public function setData($data) {
        $this->DATA = $data;
    }

    public function setPostID($postID) {
        $this->POST_ID = $postID;
    }

    public function setMIMEType($mimeType) {
        $this->MIME_TYPE = $mimeType;
    }

    public static function getFromPostID(PDO $db, $postID) {
        $statement = $db->prepare("SELECT * FROM ATTACHMENT WHERE POST_ID = ?");
        $statement->bindParam(1, $postID);
        $statement->execute();
        if ($statement->fetchObject('Attachment')) {
            return $statement;
        }
        else {
            return null;
        }
    }
}