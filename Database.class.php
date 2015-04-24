<?php
class Database {
	// Statisk funskjon som returnerer database
	static function getDatabase(){
		$host = "kark.hin.no";
		$dbname = "stud_v15_stien";
		$username = "stien";
		$password = "etnyttogbrapassord";
		try
		{
			return new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
		}
		catch(PDOException $e)
		{
			//throw new Exception($e->getMessage(), $e->getCode);
			print($e->getMessage());
			return null;
		}
	}
}
?>