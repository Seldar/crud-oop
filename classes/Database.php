<?php 
class Database {
	private static $hostname = "localhost";
	private static $username = "root";
	private static $password = "";
	private static $database = "test";
	private static $initialized = false;

	private function __construct() {}
	
    public static function initialize()
    {
        if (self::$initialized)
            return;
		self::$initialized = true;
	    $mysqli = new mysqli(self::$hostname, self::$username, self::$password, self::$database);
		if (mysqli_connect_errno()) {
			return false;
		}
		
		return $mysqli;

	   
    }
}
?>