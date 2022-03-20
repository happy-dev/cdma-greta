<?php
Trait DokelioDomainsTrait {

  public static function getDomains() {
    $buffer = array();
    $query_string = "SELECT DISTINCT domaine_libelle FROM formation ORDER BY domaine_libelle";

    if ($domains = Dokelio::$connection->query($query_string)) {
      while($domain = $domains->fetch_object()){
	$buffer[] = $domain->domaine_libelle;
      }
    }
    $domains->close();

    return $buffer;
  }

  public static function getFormations($slug) {
    Dokelio::getConnection();

    $buffer = array();
    $query_string = "SELECT DISTINCT domaine_libelle, domaine_accroche, code_AF, flag_avant, synth_titre, synth_periode_de_formation, objectif_formation FROM formation WHERE domaine_slug='". $slug ."' ORDER BY flag_avant DESC";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()){
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }
}
