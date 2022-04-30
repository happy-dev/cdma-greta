<?php
Trait DokelioDomainsTrait {

  public static function getDomains() {
    $buffer = array();
    $query_string = "SELECT DISTINCT lib_domaine, slug_domaine, referent_domaine FROM formation ORDER BY lib_domaine";

    if ($domains = Dokelio::$connection->query($query_string)) {
      while($domain = $domains->fetch_object()) {
	$buffer[] = clone $domain;
      }
    }
    $domains->close();

    return $buffer;
  }

  public static function getDomain($domain_slug) {
    $query_string = "SELECT lib_domaine FROM formation WHERE slug_domaine='". $domain_slug ."' LIMIT 1";

    if ($domain = Dokelio::$connection->query($query_string))
      return $domain->fetch_object()->lib_domaine;
  }

  public static function getFormations($domain_slug=null, $page=null) {
    $buffer = array();
    $where_str = $domain_slug ?  " WHERE slug_domaine='". $domain_slug ."'" : "";
    $limit = 20;

    if ($page)
      $offset = 'OFFSET '. ($limit * ($page - 1)); 
    else 
      $offset = '';

    $query_string = "SELECT lib_domaine, accroche_domaine, url_video_domaine, code_AF, flag_avant, synth_titre, slug_formation, synth_periode_de_formation, synth_formation_accroche, nom_image FROM formation". $where_str ." GROUP BY synth_titre ORDER BY flag_avant DESC, SES_periode_debut LIMIT $limit $offset";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }

  public static function getFormationsCount($domain_slug=null) {
    $count = 0;
    $where_str = $domain_slug ?  "WHERE slug_domaine='". $domain_slug ."'" : "";
    $query_string = "SELECT COUNT(DISTINCT synth_titre) AS count FROM formation $where_str" ;

    if ($counts = Dokelio::$connection->query($query_string)) {
      $buffer = $counts->fetch_object();
      $count = $buffer->count;
    }
    $counts->close();

    return $count;
  }
}
