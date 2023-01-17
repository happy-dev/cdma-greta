<?php
Trait DokelioFormationTrait {
  public static function getSessions($code_AF) {
    $buffer = array();
    $query_string = "SELECT code_AF, synth_titre, synth_periode_de_formation, objectif_formation, nom_image, url_video_formation, flag_diplomant, flag_eligible_cpf, flagFOAD, synth_formation_accroche, code_SES, lib_onglet_session, Prerequis, FRM_contenu_formation, methodes_pedagogiques, moyens_pedago, modalites_accueil, reconnaissance_des_acquis, intervenants, codeFORMACODE, codeROME, taux_reussite, periode_session, Public_vise, detail_duree_de_formation, comment_duree, prix, comment_tarif, lieu_de_formation, modalites_pedagogiques, effectif, contact, referent_handicap, rythme_formation, slug_domaine, lib_domaine, url_mcf, contact_mel FROM formation WHERE code_AF='IPAF_". $code_AF ."' GROUP BY code_SES ORDER BY SES_periode_debut";

    if ($sessions = Dokelio::$connection->query($query_string)) {
      while($session = $sessions->fetch_object()) {
        $buffer[] = clone $session;
      }
    }
    $sessions->close();

    return $buffer;
  }

  public static function getMetaTags($code_AF) {
    $query_string = "SELECT meta_titre, meta_description, nom_image FROM formation WHERE code_AF='IPAF_". $code_AF ."' LIMIT 1";

    if (($formations = Dokelio::$connection->query($query_string)) && $formations->num_rows > 0) {
      $formation = clone $formations->fetch_object();
      $formations->close();
    }

    return $formation;
  }

  public static function getContactsInfo($code_AF) {
    $buffer = array();
    $query_string = "SELECT code_AF, synth_titre, contact_mel, contact_mel_domaine, lib_domaine FROM formation WHERE code_AF='IPAF_". $code_AF ."'";

    if ($formations = Dokelio::$connection->query($query_string)) {
      while($formation = $formations->fetch_object()) {
        $buffer[] = clone $formation;
      }
    }
    $formations->close();

    return $buffer;
  }

  public static function cleanSessionCode($code_SES) {
    return substr($code_SES, 5);
  }

  public static function dirtySessionCode($code_SES) {
    return 'IPSE_'. $code_SES;
  }
}
