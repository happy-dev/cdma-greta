<?php
Trait DokelioSearchTrait {
  public static function search($str) {
    $str = Dokelio::$connection->real_escape_string($str);
    $buffer = array();
    $query_string = "SELECT code_AF, synth_titre, synth_periode_de_formation, synth_formation_accroche, MATCH (synth_titre) AGAINST ('$str' IN BOOLEAN MODE) AS titre, MATCH (synth_formation_accroche) AGAINST ('$str' IN BOOLEAN MODE) AS accroche FROM formation WHERE MATCH (synth_titre, synth_formation_accroche) AGAINST ('$str' IN BOOLEAN MODE) ORDER BY (titre*2)+(accroche*1) DESC";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }
}
