<?php
Trait DokelioFrontpageTrait {
  public static function getHighlights() {
    $buffer = array();
    $query_string = "SELECT DISTINCT code_AF, synth_titre, synth_periode_de_formation FROM formation WHERE flag_une = 1";

    if ($highlights = Dokelio::$connection->query($query_string)) {
      while($formation = $highlights->fetch_object()){
        $buffer[] = clone $formation;
      }
    }
    $highlights->close();

    return $buffer;
  }
}
