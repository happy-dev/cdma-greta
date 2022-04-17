<?php
Trait DokelioDomainsTrait {

  public static function getDomains() {
    $buffer = array();
    $query_string = "SELECT DISTINCT domaine_libelle, slug, referent_domaine FROM formation ORDER BY domaine_libelle";

    if ($domains = Dokelio::$connection->query($query_string)) {
      while($domain = $domains->fetch_object()) {
	$buffer[] = clone $domain;
      }
    }
    $domains->close();

    return $buffer;
  }

  public static function getDomain($slug) {
    $query_string = "SELECT domaine_libelle FROM formation WHERE slug='". $slug ."' LIMIT 1";

    if ($domain = Dokelio::$connection->query($query_string))
      return $domain->fetch_object()->domaine_libelle;
  }

  public static function getFormations($slug=null) {
    $buffer = array();
    $where_str = $slug ?  " WHERE slug='". $slug ."'" : "";
    $query_string = "SELECT DISTINCT domaine_libelle, domaine_accroche, url_video_domaine, code_AF, flag_avant, synth_titre, synth_periode_de_formation, synth_formation_accroche, nom_image FROM formation". $where_str ." ORDER BY flag_avant DESC, SES_periode_debut";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }
}
