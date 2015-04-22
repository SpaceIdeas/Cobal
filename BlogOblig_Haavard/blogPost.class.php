<?php
class blogPost {

	private $Title;         // Holds the blog posts title
	private $Date;        	// Holds the blog posts date
	private $Text;      	// Holds the blog posts content text
	private $Author;    	// Holds the blog posters email
	private $AuthorName;    // Holds the blog posters full name

	function __construct() {
	}
	
	public function getTitle() {
		return $this->Title;
	}
	public function getDate() {
		return $this->Date;
	}
	public function getText() {
		return $this->Text;
	}
	public function getAuthor() {
		return $this->Author;
	}
	public function getAuthorName() {
		return $this->AuthorName;
	}
	
	public function setTitle($Title){
		$this->Title = htmlspecialchars($Title);
	}
	
	public function setText($Text){
		$this->Text = htmlspecialchars($Text);
	}
	
	public function setAuthor($Author){
		$this->Author = $Author;
	}
	
	//Inserts the blog post into the database
	public function insertBlogPost($db){
		try
		{
			$stmt = $db->prepare("INSERT INTO blog_post (Title, Date, Text, Author) VALUES (?, now(), ?, ?)");
			$result = $stmt->execute(array($this->Title, $this->Text, $this->Author));
			return $result;
		}catch(Exception $e) {
			    throw($e); 
		}
	}
	
	//Henter AuthorName fra databasen og setter det i blog objektet
	public function fetchAuthorName($db){
		$stmt = $db->prepare("SELECT full_name FROM blog_user WHERE email = ?");
		$stmt->bindParam(1, $this->Author);
		$stmt->execute();
		$row = $stmt->fetch(); 
		$this->AuthorName = $row["full_name"];
	}
	
	
	public static function getAllPost($db) {
		$blogPosts = array();
		try
		{
			$stmt = $db->prepare("SELECT Title, Date, Text, Author, full_name \"AuthorName\" FROM blog_post INNER JOIN blog_user ON blog_user.email = blog_post.Author ORDER BY Date DESC");
			$stmt->execute();
			while ($blogPost = $stmt->fetchObject('blogPost') )
			{
				$blogPosts[] = $blogPost;
			}
		}catch(Exception $e) { 
			throw($e); 
		}
		
		return $blogPosts;
	}
}