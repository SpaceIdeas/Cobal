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
    private $HITS;


    public function __construct() {

    }

    public function getID() {
        return $this->ID;
    }

    public function getTitle() {
        return $this->TITLE;
    }

    public function setTitle($title) {
        $this->TITLE = $title;
    }

    public function getText() {
        return $this->TEXT;
    }

    public function setText($text) {
        $this->TEXT = $text;
    }

    public function getAuthorEmail() {
        return $this->AUTHOR_EMAIL;
    }

    public function setAuthorEmail($authorEmail) {
        $this->AUTHOR_EMAIL = $authorEmail;
    }

    public function getTimeCreated() {
        return $this->TIME_CREATED;
    }

    public function getHits(){
        return $this->HITS;
    }

    public function setHits($hits){
        $this->HITS = $hits;
    }

    public function getShortText() {
        return substr($this->TEXT, 0, 1000) . '...';
    }

    public function addToDB(PDO $db) {
        $purefier = new HTMLPurifier(HTMLPurifier_Config::createDefault());
        try
        {
            $statement = $db->prepare("INSERT INTO POST (TITLE, TEXT, AUTHOR_EMAIL, TIME_CREATED) VALUES (?, ?, ?, NOW())");
            return $statement->execute(array(htmlentities($this->TITLE), $purefier->purify($this->TEXT), $this->AUTHOR_EMAIL));
        }catch(Exception $e) {
            return false;
        }
    }

    public function getAuthorName(PDO $db) {
        return User::getUsernameFromDB($db, $this->AUTHOR_EMAIL);
    }

    public function deletePost(PDO $db){
        try
        {
            $statement = $db->prepare("DELETE FROM POST WHERE ID = ?");
            return $statement->execute(array($this->ID));
        }catch(Exception $e) {
            return false;
        }
    }

    /**
     * Oppdaterer databasen slik at innlegget får rett tekst og tittel
     * @param PDO $db
     * @return bool
     */
    public function updateDB(PDO $db){
        try
        {
            $statement = $db->prepare("UPDATE POST SET TITLE = ?, TEXT = ? WHERE ID = ?");
            return $statement->execute(array($this->TITLE, $this->TEXT, $this->ID));
        }catch(Exception $e) {
            return false;
        }
    }

    public static function getPost(PDO $db, $id) {
        $statement = $db->prepare("SELECT * FROM POST WHERE ID = ?");
        $statement->bindParam(1, $id);
        $statement->execute();
        // Returnerern null hvis en feil oppstår
        if ($post = $statement->fetchObject('Post')) {
            return $post;
        }
        else {
            return null;
        }
    }

    public static function  getAllPosts(PDO $db) {
        try{
            $statement = $db->prepare("SELECT * FROM POST ORDER BY TIME_CREATED DESC");
            $statement->execute();
            $posts = [];
            while ($post = $statement->fetchObject('Post')) {
                $posts[] = $post;
            }
            return $posts;
        }catch(PDOException $e) {
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
            $statement = $db->prepare("SELECT ID, TITLE, TEXT, AUTHOR_EMAIL, TIME_CREATED, HITS FROM POST ORDER BY TIME_CREATED DESC LIMIT 10 OFFSET ?");
            $statement->bindParam(1, $offset, PDO::PARAM_INT);
            $statement->execute();
            $posts = [];
            while ($post = $statement->fetchObject('Post')) {
                $posts[] = $post;
            }
            return $posts;
        }catch(PDOException $e) {
            return null;
        }
    }

    public function getComments(PDO $db) {
        return Comment::getCommentsByPost($db, $this);
    }

    public function getCommentCount(PDO $db) {
        return Comment::getCommentCount($db, $this);
    }

    public function getCommentCountAsString(PDO $db) {
        return NumberConverter::convert(Comment::getCommentCount($db, $this));
    }

    public function getNextPostID(PDO $db) {
        $statement = $db->prepare("SELECT MIN(ID) AS NEXT_ID FROM POST WHERE ID > ?");
        $statement->bindParam(1, $this->ID);
        $statement->execute();
        return $statement->fetch()['NEXT_ID'];
    }

    public function getPreviousPostID(PDO $db) {
        $statement = $db->prepare("SELECT MAX(ID) AS PREVIOUS_ID FROM POST WHERE ID < ?");
        $statement->bindParam(1, $this->ID);
        $statement->execute();
        return $statement->fetch()['PREVIOUS_ID'];
    }

    public function hasNextPostID(PDO $db) {
        $nextID = $this->getNextPostID($db);
        return isset($nextID);
    }

    public function hasPreviousPostID(PDO $db) {
        $previousID = $this->getPreviousPostID($db);
        return isset($previousID);
    }

    /**
     * Returnerer en array av YearPostList objekter som blir brukt til å generere en liste over hvor mange innlegg det er i hver måned i hvert år
     * @param $db
     * @return array|null
     */
    public static function getYearMonthCountFromPosts($db){
        try
        {
            $statement = $db->prepare("Select year(TIME_CREATED) as YEAR, month(TIME_CREATED) as MONTH, count(*) as COUNT FROM POST WHERE year(TIME_CREATED) in(select distinct year(TIME_CREATED) from POST)GROUP BY month(TIME_CREATED) ORDER BY TIME_CREATED desc");
            $statement->execute();
            $rows = $statement->fetchAll();
            //Blir et array med YearPostList items der YearPostList inneholder året og et
            // assosiativt array med navn på måned som key og antall innlegg denne måneden som value
            $yearPostList = array();
            //Kjører igjennom til alle radene er tatt ut og lagt til i en YearPostList som igjenn havner i $yearPostList
            while(!empty($rows)){
                //Tar ut den første raden i $rows
                $row = array_shift($rows);
                //Lager arrayet som holder på key=Måneden og value=antall innlegg denne måneden
                //Arrayet blir senere lagt til i et YearPostList objekt
                $month = array(YearPostList::$norwegianMonth[$row['MONTH']]=>$row['COUNT']);
                //I while løkken blir hver rad i $row som har årer lik det elementene i $month skal ha. Lagt til i $month
                while($row['YEAR'] == current($rows)['YEAR']){
                    $monthRow = array_shift($rows);
                    $month[YearPostList::$norwegianMonth[$monthRow['MONTH']]] = $monthRow['COUNT'];
                }
                //Legger til YearPostList objektet
                $yearPostList[] = new YearPostList($row['YEAR'], $month);
            }
            return $yearPostList;

        }catch(PDOException $e) {
            return null;
        }


    }

    /**
     * Returnerer alle blog innleggene hvor tittel eller tekst inneholder $searchWord
     * @param PDO $db
     * @param $searchWord
     * @return array
     */
    public static function  getPostsBySearch(PDO $db, $searchWord) {
        try
        {
            $searchWord = "%" . $searchWord . "%";
            $statement = $db->prepare("SELECT * FROM POST WHERE UPPER(TITLE) LIKE ? OR UPPER(TEXT) LIKE ? ORDER BY TIME_CREATED DESC");
            $statement->execute(array($searchWord, $searchWord));
            $posts = [];
            while ($post = $statement->fetchObject('Post')) {
                $posts[] = $post;
            }
            return $posts;
        }catch(PDOException $e) {
            return null;
        }
    }


    public static function getPostsByMonthYear(PDO $db, $month, $year){
        try
        {
            $statement = $db->prepare("SELECT * FROM POST where month(TIME_CREATED) = ? and year(TIME_CREATED) = ? ORDER BY TIME_CREATED DESC;");
            $statement->execute(array($month, $year));
            $posts = [];
            while ($post = $statement->fetchObject('Post')) {
                $posts[] = $post;
            }
            return $posts;
        }catch(PDOException $e) {
            return null;
        }
    }


    /**
     * Legger til en i antallet hits på det aktuelle innlegget
     * @param PDO $db
     * @return bool
     */
    public function iGotHit(PDO $db){
        try
        {
            $statement = $db->prepare("UPDATE POST SET HITS = HITS + 1 WHERE ID = ?");
            return $statement->execute(array($this->ID));
        }catch(PDOException $e) {
            return false;
        }
    }

    public function getAttachment($db) {
        return Attachment::getFromPostID($db, $this->ID);
    }

}