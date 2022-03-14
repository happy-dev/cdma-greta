<?php
Trait DokelioConnectionTrait {
  public static $connection = null; // Database connection object
	
  // Singleton pattern to ensure there is only one databse connection at a time
  public static function getConnection() {
    if (self::$connection === null) {
      self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, 'cdma_dokelio');

      if ($connection->connect_error) {// Database connection issue
        die("Dokelio database connection error : ". $connection->connect_error);
      }
    }

    return self::$connection;
  } 
}
