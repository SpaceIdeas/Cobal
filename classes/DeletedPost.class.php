<?php

/**
 * Class DeletedPost Representeret et slettet innlegg fra databasen
 */
class DeletedPost {
    /**
     * @var int $POST_ID                Den unike IDen til innlegget
     */
    private $POST_ID;
    /**
     * @var string $TITLE               Tittelen til innlegget
     */
    private $TITLE;
    /**
     * @var string $TEXT                Teksten til innlegget
     */
    private $TEXT;
    /**
     * @var string $AUTHOR_EMAIL        Email til forfatteren av innlegget
     */
    private $AUTHOR_EMAIL;
    /**
     * @var string $AUTHOR_USERNAME     Brukernavnet til forfatteren av innlegget
     */
    private $AUTHOR_USERNAME;
    /**
     * @var DateTime $TIME_CREATED      Tidspunktet innlegget ble laget
     */
    private $TIME_CREATED;
    /**
     * @var DateTime $TIME_DELETED      Tidspunktet innlegget ble slettet
     */
    private $TIME_DELETED;
    /**
     * @var int $HITS                   Antallet treff på innlegget
     */
    private $HITS;

    /**
     * Returnerer ID-en til innlegget
     *
     * @return int ID-en til innlegget
     */
    public function getPostID(){
        return $this->POST_ID;
    }

    /**
     * Setter den unike IDen til innlegget
     *
     * @param int $postID
     */
    public function setPostID($postID){
        $this->POST_ID = $postID;
    }
    /**
     * Returnerer Tittelen til inlegget.
     *
     * @return string Tittlen til inlegget
     */
    public function getTitle(){
        return $this->TITLE;
    }
    /**
     * Setter tittelen til innlegget
     *
     * @param string $title
     */
    public function setTitle($title) {
        $this->TITLE = $title;
    }
    /**
     * Returnerer teksten til innlegget
     *
     * @return string Teksten til inlegget
     */
    public function getText(){
        return $this->TEXT;
    }
    /**
     * Setter teksten til innlegget
     *
     * @param string $text
     */
    public function setText($text) {
        $this->TEXT = $text;
    }
    /**
     * Returnerer e-postadressen til forfatteren av innlegget.
     *
     * @return string E-postadressen til forfatteren av innlegget
     */
    public function getAuthorEmail(){
        return $this->AUTHOR_EMAIL;
    }
    /**
     * Setter email til forfatteren av innlegget
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail) {
        $this->AUTHOR_EMAIL = $authorEmail;
    }
    /**
     * Returnerer brukernavnet til forfatteren av innlegget.
     *
     * @return string Brukernavnet til forfatteren av innlegget
     */
    public function getAuthorUsername()
    {
        return $this->AUTHOR_USERNAME;
    }
    /**
     * Setter brukernavnet til forfatteren av innlegget
     *
     * @param string $authorUsername
     */
    public function setAuthorUsername($authorUsername)
    {
        $this->AUTHOR_USERNAME = $authorUsername;
    }

    /**
     * Returnerer tidspunktet innlegget ble opprettet.
     *
     * @return string
     */
    public function getTimeCreated(){
        return $this->TIME_CREATED;
    }
    /**
     * Setter tidspunktet innlegget ble laget
     *
     * @param DateTime $timeCreated
     */
    public function setTimeCreated($timeCreated){
        $this->TIME_CREATED = $timeCreated;
    }

    /**
     * Returnerer tidspunktet innlegget ble slettet.
     *
     * @return string
     */
    public function getTimeDeleted()
    {
        return $this->TIME_DELETED;
    }
    /**
     * Setter tidspunktet innlegget ble slettet
     *
     * @param DateTime $timeDeleted
     */
    public function setTimeDeleted($timeDeleted)
    {
        $this->TIME_DELETED = $timeDeleted;
    }

    /**
     * Returnerer antallet treff på innlegget
     *
     * @return int
     */
    public function getHits(){
        return $this->HITS;
    }
    /**
     * Setter antallet treff på innlegget
     *
     * @param int $hits
     */
    public function setHits($hits) {
        $this->HITS = $hits;
    }

    /**
     * Ignorerer et antall innlegg og returnerer de neste 10, fra databasen
     *
     * @param PDO $db Databasen SQL skal kjøres mot
     * @param int $offset Antallet innlegg som skal ignoreres
     * @return array|null Et array av innleggene som ble hentet
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