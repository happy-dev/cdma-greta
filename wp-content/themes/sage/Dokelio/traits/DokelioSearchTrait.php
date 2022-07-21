<?php
Trait DokelioSearchTrait {
  public static function search($str, $filter, $page) {
    $buffer = array();
    $and = 'AND';
    $where = 'WHERE';

    switch ($filter) {
      case 'formation-diplomantes-cpf':
        $filter = '(formation_flag_diplomant=1 OR flag_eligible_cpf=1)';
      break;

      case 'formation-diplomante':
        $filter = 'formation_flag_diplomant=1';
      break;

      case 'formation-eligible-au-cpf':
        $filter = 'flag_eligible_cpf=1';
      break;

      case 'toute-formation':
        $and = '';
        $where = '';
        $filter = '';
      break;
    }

    if ($page)
      $offset = 'OFFSET '. (CDMA_LIMIT * ($page - 1)); 
    else 
      $offset = '';

    if (!$str) {
      $query_string = "SELECT code_AF, synth_titre, slug_formation, synth_periode_de_formation, synth_formation_accroche, nom_image_formation FROM formation $where $filter GROUP BY synth_titre ORDER BY synth_titre LIMIT ". CDMA_LIMIT ." $offset";
    }
    else {
      $str_arr = explode(' ', $str);
      foreach ($str_arr as $idx => $word) {// Remonving short words
	if (strlen($word) <= 2)
	  unset($str_arr[$idx]);
      }
      foreach ($str_arr as $idx => $word)
	$str_arr[$idx] = dokelio::$connection->real_escape_string($word);
      $str = implode(' ', $str_arr);
      $query_string = "SELECT code_AF, synth_titre, slug_formation, synth_periode_de_formation, synth_formation_accroche, nom_image_formation, MATCH (synth_titre) AGAINST ('$str' IN NATURAL LANGUAGE MODE) AS titre, MATCH (synth_formation_accroche) AGAINST ('$str' IN NATURAL LANGUAGE MODE) AS accroche, MATCH (contact) AGAINST ('$str' IN NATURAL LANGUAGE MODE) AS coordo, MATCH (lieu_de_formation) AGAINST ('$str' IN NATURAL LANGUAGE MODE) AS lieu, MATCH (lib_domaine) AGAINST ('$str' IN NATURAL LANGUAGE MODE) AS domaine FROM formation WHERE MATCH (synth_titre, synth_formation_accroche, contact, lieu_de_formation, lib_domaine) AGAINST ('$str' IN NATURAL LANGUAGE MODE) $and $filter GROUP BY synth_titre ORDER BY (titre*8)+(accroche*2)+(coordo*1)+(lieu*1)+(domaine*1) DESC LIMIT ". CDMA_LIMIT ." $offset";
    }

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }

  public static function countSearchResults($str, $filter) {
    $buffer = array();
    $and = 'AND';
    $where = 'WHERE';

    switch ($filter) {
      case 'formation-diplomantes-cpf':
        $filter = '(formation_flag_diplomant=1 OR flag_eligible_cpf=1)';
      break;

      case 'formation-diplomante':
        $filter = 'formation_flag_diplomant=1';
      break;

      case 'formation-eligible-au-cpf':
        $filter = 'flag_eligible_cpf=1';
      break;

      case 'toute-formation':
        $and = '';
        $where = '';
        $filter = '';
      break;
    }

    if (!$str) {
      $query_string = "SELECT COUNT(DISTINCT synth_titre) AS count FROM formation $where $filter";
    }
    else {
      $str = Dokelio::$connection->real_escape_string($str);
      $query_string = "SELECT COUNT(DISTINCT synth_titre) AS count FROM formation WHERE MATCH (synth_titre, synth_formation_accroche, contact, lieu_de_formation, lib_domaine) AGAINST ('$str' IN NATURAL LANGUAGE MODE) $and $filter LIMIT ". CDMA_LIMIT;
    }

    if ($counts = Dokelio::$connection->query($query_string)) {
      $buffer = $counts->fetch_object();
      $count = $buffer->count;
    }
    $counts->close();

    return $count;
  }
}
