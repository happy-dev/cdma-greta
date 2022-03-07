<?php 
  date_default_timezone_set('Europe/Paris');

  set_include_path('~/cdma.happy-dev.fr/');
  include('wp-config.php');
  chdir('wp-content/themes/sage/dokelio_db_exports/');

  $file_name = 'dokelio_db_export_'. date('Y-m-d') .'.txt';

  if (file_exists($file_name)) {// Today's import file found successfully
    echo 'Importing '. date('d-m-Y') ." data from Dokelio\n";

    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, 'cdma_dokelio');

    if ($db->connect_error) {// Database connection issue
      die("Dokelio database connection error : ". $db->connect_error);
    }
    else {// Connected to the database
      $db->query('TRUNCATE TABLE formation');

      if (($handle = fopen($file_name, "r")) !== FALSE) {
	$header = fgetcsv($handle, null, "\t");

        while (($row = fgetcsv($handle, null, "\t")) !== FALSE) {
	  foreach($row as &$data) {// Escaping before injecting
	    $data = $db->real_escape_string($data);
	  }

	  if (!$db->query("INSERT INTO formation (". implode(", ", $header) .") VALUES ('". implode("', '", $row) ."')")) {
            die("INSERT query error : ". $db->error);
	  }
        }
        fclose($handle);
      }
    }
  } 
  else {// Today's import file is nowhere to be found
    die("No data from Dokelio to import on the ". date('d-m-Y') ." \n");
  }
