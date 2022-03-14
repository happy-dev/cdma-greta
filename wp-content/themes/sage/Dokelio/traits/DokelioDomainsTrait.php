<?php
include_once("DokelioConnectionTrait.php");

Trait DokelioDomainsTrait {
  use DokelioConnectionTrait;  

  public static function getDomains() {
    DokelioConnectionTrait::getConnection();

    $buffer = array();
    $query_string = "SELECT DISTINCT domaine_libelle FROM formation";

    if ($domains = DokelioConnectionTrait::$connection->query($query_string)) {
      while($domain = $domains->fetch_object()){
	$buffer[] = $domain->domaine_libelle;
      }
    }
    $domains->close();

    return $buffer;
  }
}
