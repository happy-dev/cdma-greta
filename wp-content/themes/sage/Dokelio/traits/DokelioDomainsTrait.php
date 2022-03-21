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

  public static function getDomain($slug) {
    $query_string = "SELECT domaine_libelle FROM formation WHERE domaine_slug='". $slug ."' LIMIT 1";

    if ($domain = Dokelio::$connection->query($query_string))
      return $domain->fetch_object()->domaine_libelle;
  }

  public static function getFormations($slug) {
    $buffer = array();
    $query_string = "SELECT DISTINCT domaine_libelle, domaine_accroche, url_video_domaine, code_AF, flag_avant, synth_titre, synth_periode_de_formation, objectif_formation FROM formation WHERE domaine_slug='". $slug ."' ORDER BY flag_avant DESC";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()){
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }
}
