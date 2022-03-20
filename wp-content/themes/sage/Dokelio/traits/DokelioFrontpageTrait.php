<?php
Trait DokelioFrontpageTrait {
  public static function getHighlights() {
    $buffer = '';
    $query_string = "SELECT DISTINCT code_AF, synth_titre, synth_periode_de_formation FROM formation WHERE flag_une = 1";

    if ($highlights = Dokelio::$connection->query($query_string)) {
      while($formation = $highlights->fetch_object()){
	$buffer .= '<article class="entry col-md-4">';
        $buffer .=   '<a href="https://cdma.happy-dev.fr/fiches/formation-wordpress-concevoir-un-site-vitrine/" title="'. $formation->synth_titre .'">';
        $buffer .=     '<img src="https://cdma.happy-dev.fr/wp-content/uploads/Creer_un_site_wordpress-500x282.jpg" alt="" />';
        $buffer .=     '<h3>'. $formation->synth_titre .'</h3>';
        $buffer .=     '<span>'. $formation->synth_periode_de_formation .'</span>';
        $buffer .=   '</a>';
        $buffer .= '</article>';
      }
    }
    $highlights->close();

    return $buffer;
  }
}
