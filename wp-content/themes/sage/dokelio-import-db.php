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
      $row = 1;

      if (($handle = fopen($file_name, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, null, "\t")) !== FALSE) {
          $fields_count = count($data);
          $row++;

          for ($c=0; $c<$fields_count; $c++) {// $c == column
            echo $data[$c] . "\n";
          }
        }
        fclose($handle);
      }
    }
  } 
  else {// Today's import file is nowhere to be found
    die("No data from Dokelio to import on the ". date('d-m-Y') ." \n");
  }
