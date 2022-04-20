<?php
Trait DokelioSearchTrait {
  public static function search($str, $filter) {
    $str = Dokelio::$connection->real_escape_string($str);
    $buffer = array();
    $query_string = "SELECT code_AF, synth_titre, synth_periode_de_formation, synth_formation_accroche, MATCH (synth_titre) AGAINST ('$str' IN BOOLEAN MODE) AS titre, MATCH (synth_formation_accroche) AGAINST ('$str' IN BOOLEAN MODE) AS accroche, MATCH (contact) AGAINST ('$str' IN BOOLEAN MODE) AS coordo, MATCH (lieu_de_formation) AGAINST ('$str' IN BOOLEAN MODE) AS lieu, MATCH (domaine_libelle) AGAINST ('$str' IN BOOLEAN MODE) AS domaine FROM formation WHERE MATCH (synth_titre, synth_formation_accroche, contact, lieu_de_formation, domaine_libelle) AGAINST ('$str' IN BOOLEAN MODE) $filter ORDER BY (titre*4)+(accroche*2)+(coordo*1)+(lieu*1)+(domaine*1) DESC";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }
}
