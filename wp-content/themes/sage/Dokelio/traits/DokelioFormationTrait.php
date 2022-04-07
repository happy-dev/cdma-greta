<?php
Trait DokelioFormationTrait {
  public static function getSessions($code_AF) {
    $buffer = array();
    $query_string = "SELECT code_AF, synth_titre, synth_periode_de_formation, objectif_formation, url_video_formation, flag_diplomant, flag_eligible_cpf, synth_formation_accroche, code_SES, lib_onglet_session, Prerequis, FRM_contenu_formation, methodes_pedagogiques, moyens_pedago, modalites_accueil, reconnaissance_des_acquis, intervenants, codeFORMACODE, codeROME, taux_reussite, periode_session, Public_vise, detail_duree_de_formation, prix, lieu_de_formation, modalites_pedagogiques, effectif, contact, referent_handicap, rythme_formation FROM formation WHERE code_AF='IPAF_". $code_AF ."' ORDER BY SES_periode_debut";

    if ($sessions = Dokelio::$connection->query($query_string)) {
      while($session = $sessions->fetch_object()) {
        $buffer[] = clone $session;
      }
    }
    $sessions->close();

    return $buffer;
  }
}