<?php

/**
 * Class Attachment Inneholder dataen, mimetypen, samt ID-en til Post-en som vedlegget hører til.
 *
 * klassen inneholder metoder for å legge til et vedlegg i databasen samt og hente ut et vedlegg fra databasen.
 */
class Attachment {
    /**
     * @var blob $DATA Dataen til vedlegget
     */
    private $DATA;
    /**
     * @var string $MIME_TYPE MIME-typen til vedlegget
     */
    private $MIME_TYPE;
    /**
     * @var int $POST_ID Den unike IDen til innlegget vedlegget hører til
     */
    private $POST_ID;

    /**
     * Metoden legger et Attachment-objekt til i databasen.
     *
     * @param PDO $db Databsen som Sql-setningen skal gjøres mot.
     * @return bool Om insettingen i databasen var vellykket eller ikke.
     */
    public function addToDB(PDO $db) {
        try
        {
            $statement = $db->prepare("INSERT INTO ATTACHMENT (DATA, MIME_TYPE, POST_ID) VALUES (?, ?, ?)");
            return $statement->execute(array($this->DATA, $this->MIME_TYPE, $this->POST_ID));
        }catch(PDOException $e) {
            return false;
        }
    }

    /**
     * Returnerer vedleggets data.
     *
     * @return blob Vedleggets data
     */
    public function getData() {
        return $this->DATA;
    }

    /**
     * Returnerer ID-en til inleggget som vedlegget hører til.
     *
     * @return int ID-en til inleggget som vedlegget hører til.
     */
    public function getPostID() {
        return $this->POST_ID;
    }

    /**
     * Returnerer MIME-typen til vedlegget.
     *
     * @return string MIME-typen
     */
    public function getMIMEType() {
        return $this->MIME_TYPE;
    }

    /**
     * Setter dataen som et vedlegg skal inneholde. Eks: fra getFileContents()
     *
     * @param blob $data
     */
    public function setData($data) {
        $this->DATA = $data;
    }

    /**
     * Setter ID-en til innlegget som attachmentet tilhører.
     *
     * @param int $postID ID-en til innlegget som attachmentet tilhører.
     */
    public function setPostID($postID) {
        $this->POST_ID = $postID;
    }

    /**
     * Setter MIME-typen til vedlegget.
     *
     * @param string $mimeType MIME-typen til vedlegget.
     */
    public function setMIMEType($mimeType) {
        $this->MIME_TYPE = $mimeType;
    }

    /**
     * Henter ut vedlegg ved hjelp av database og ID til innlegg.
     *
     * @param PDO $db Databasen som det skal spørres mot.
     * @param int $postID ID-en til inlegget som man ønsker å hente ut vedlegget til.
     * @return Attachment|null Returnere vedlegget hvis det finnes. Hvis ikke eller feil returneres null.
     */
    public static function getFromPostID(PDO $db, $postID) {
        try {
            $statement = $db->prepare("SELECT * FROM ATTACHMENT WHERE POST_ID = ?");
            $statement->bindParam(1, $postID);
            $statement->execute();
            if ($attachment = $statement->fetchObject('Attachment')) {
                return $attachment;
            }
            // Det finnes ikke et vedlegg
            else {
                return null;
            }
        }
        catch(PDOException $e) {
            return null;
        }
    }
}