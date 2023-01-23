<?php
//You Must Design Your Own Database
class connection{
	public $db;
	public function __construct(){
		$host = "localhost";
		$port = "****";
		$dbname = "****";
		$user = "****";
		$pass = "****";
		$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;";
		try {
			$this->db=new PDO($dsn, $user, $pass);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
		} catch (Exception $e) {
			echo $e->getmessage();
		}
	}
}
?>
