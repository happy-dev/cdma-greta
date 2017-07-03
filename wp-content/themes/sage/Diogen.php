<?php
require_once('diogenConfig.php');

/**
 * This class handles all interactions between Wordpress and DIOGEN
 * It implements the Singleton pattern to ensure there is only one databse connection at a time
 */
Class Diogen {
	
	// Database connection object, or "false" if Wordpress failed to connect to DIOGEN
	// PDO::ATTR_DRIVER_NAME is 'mysql'
	private static $diogenConnection = null; 
	
	
	/** 
	 * Initializes the $diogenConnection singleton, or returns it
	 */ 
	public static function getDiogenConnection() {
    // Ensures we always work with the same instance of the database connection
    if (self::$diogenConnection === null) {

      // If the connection to DIOGEN is successful...
      self::$diogenConnection = new PDO(
        DIOGEN_HOST,// Host
        DIOGEN_USERNAME,// Username
        DIOGEN_PASSWORD,// Password
        array(
          PDO::ATTR_TIMEOUT => 20,// seconds
        )
      );
    }

    return self::$diogenConnection;
	} 
	
	
	/** 
	 * Queries DIOGEN
	 * In PHP, absent parameters are set to null
	 * 
	 * @param $query_string: 	string		The query string
	 * 
	 * @return A database object containing the results, or a string containing an error message
	 */
	public static function runQuery($queryString, $prepare_params = null) {
		try {
			$diogenBdd = self::getDiogenConnection();
			
			// If something else than a PDO object was returned...
			if (!is_a($diogenBdd, 'PDO')) {
				throw new Exception('diogen_inaccessible');
			}
			
			// Prepared query are more efficient and auto escape parameters
			$query_results = $diogenBdd->prepare($queryString);
			
			// We bind the parameters of the prepared query (if any)
			if (isset($prepare_params)) {
				// I did not quite get why bindParam didn't work on this, but it does not :)
				foreach($prepare_params as $param_name => $param_value) {
					if ($param_value != '') {
						// If :text parameter from the advanced search query, we pre/append wildcard for FULLTEXT search with MATCH AGAINST
						if ($param_name == ':text') {
							$query_results->bindValue($param_name, '%'. $param_value .'%', PDO::PARAM_STR);
						}
						else {
							$query_results->bindValue($param_name, $param_value, PDO::PARAM_STR);
						}
					}
				}
			}
			
			$query_results->execute();
			$query_results->setFetchMode(PDO::FETCH_OBJ);
			
			return $query_results;
			
		// This block gets executed if an exception is thrown
		} catch(Exception $e) {
			if (WP_DEBUG) {
				$error_message = 'DIOGEN connection: ' . $e->getMessage() . '<br/>';
			} else {
				$error_message = '<span class="alert">DIOGEN est inaccessible. Veuillez en aviser le webmaster: xavier.bernabeu@ac-paris.fr &nbsp;&nbsp; OU &nbsp;&nbsp; 01.44.62.39.29</span>';
			}
			
			return $error_message;
		} 
	}
	
	
	// Apostrophe is encrypted as ¤ within DIOGEN, to avoid any injection attack. We need to encrypt it back to output it correctly
	public static function removeApostrophe($db_string) {
		$db_string = str_replace('¤','\'',$db_string);
		$db_string = str_replace('µ',';',$db_string);
		
		return $db_string ;
	}
	
	
	public static function apostropheBack($db_string) {
		$db_string = str_replace('\'','¤',$db_string);
		$db_string = str_replace(';','µ',$db_string);
		
		return $db_string ;
	}
	
	
	public static function stringToURL($url_string) {
		$url_string = str_replace(' ','--',$url_string);
		$url_string = str_replace('/','__',$url_string);
		
		return $url_string ;
	}
	
	
	public static function urlToString($url_string) {
		$url_string = str_replace('--','+',$url_string);
		$url_string = str_replace('__','/',$url_string);
		
		return $url_string ;
	}
	
	
	public static function dateFromDiogenToHtml($date_string) {
		$date_buffer 	= explode('-', $date_string);
		$nd 		      = [];// New Date
		
		foreach(array_reverse($date_buffer) as $date_part) {
			//if ($date_part == '00') {
			//	$start_date_str = '';
			//	break;
			//}
			$nd[] = $date_part;
		}
		
		return implode('/', $nd);
	}
}
