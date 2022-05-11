<?php 
  date_default_timezone_set('Europe/Paris');

  $env = explode('/', __FILE__)[3];// Path to prod or staging environment
  include($env .'/wp-config.php');
  chdir('dokelio_db/');

  if (array_key_exists(1, $argv))// If filename passed as argument of the command line
    $file_name = $argv[1];
  else {
    $todays_exports = glob('export_cdma_'. date('Ymd') .'_*.txt'); 
    $file_name = $todays_exports[count($todays_exports)-1];
  }

  if (file_exists($file_name)) {// Today's import file found successfully
    echo 'Importing '. date('d-m-Y') ." data from Dokelio\n";

    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, 'cdma_dokelio');

    if ($db->connect_error) {// Database connection issue
      die("Dokelio database connection error : ". $db->connect_error);
    }
    else {// Connected to the database
      $db->begin_transaction();
      $db->query('DELETE FROM formation');

      if (($handle = fopen($file_name, "r")) !== FALSE) {
	$header = fgetcsv($handle, null, "\t");

        while (($row = fgetcsv($handle, null, "\t")) !== FALSE) {
	  foreach($row as &$data) {// Escaping before injecting
	    $data = $db->real_escape_string($data);
	  }

	  if (!$db->query("INSERT INTO formation (". implode(", ", $header) .") VALUES ('". implode("', '", $row) ."')")) {
            echo("INSERT query error : ". $db->error ."\n");
            $db->rollback();
	    die();
	  }
        }
        $db->commit();
        fclose($handle);
      }
    }
  } 
  else {// Today's import file is nowhere to be found
    die("No data from Dokelio to import on the ". date('d-m-Y') ." \n");
  }
