<?php
require_once('Diogen.php');

/**
 * Group of functions that make querying Diogen a breeze
 */ 
Class DiogenHelper {

  // Retrieve a formation object as defined in Diogen
  public static function getFormation($formationId) {
    // Query Result
    $qr = DIOGEN::runQuery("SELECT 
      offreformation.OFNo,
      offreformation.OFNoPermanent,
      offreformation.OFIntituleComplet,
      offreformation.OFCommentaireIntitule,
      offreformation.OFAccroche,
      offreformation.OFDuree,
      offreformation.OFObjectif,
      offreformation.OFPrerequisMaxi,
      offreformation.OFContenu,
      offreformation.OFMethode,
      offreformation.OFCommentaireReconnaissance,
      offreformation.OFCertification,
      offreformation.OFMoyens,
      offreformation.OFSelection,
      offreformation.OFIntervenant,
      offreformation.OFMAJDate,
      offremotcle.MCNo
    
    FROM 
      offreformation,
      offremotcle,
      offreliaisonformationmotcle
                          
    WHERE
      offreformation.OFNo = offreliaisonformationmotcle.LMCFormation			AND
      offreliaisonformationmotcle.LMCMotCle = offremotcle.MCNo						AND
      offreformation.OFNo = {$formationId}
    ");
    $f = $qr->fetch();


    // If no error, and not empty
    if (!is_string($f) && !empty($f)) {		  
      return $f;
    }
    else if (empty($f)) {
      return 'Formation not found.';
    }
    else {
      return $f;
    }
  }


  // Retrieve sessions 
  public static function getSessions($formationId) {
    $qr = DIOGEN::runQuery("SELECT 
      offresession.SSDateDeb,
      offresession.SSDateFin,
      offresession.SSDateCommentaire,
      offresession.SSPublicCommentaire,
      offresession.SSDureeCentre,
      offresession.SSDureeEntreprise,
      offresession.SSEn2,
      offresession.SSEn1Ou2,
      offresession.SSDureeP,
      offresession.SSDureeCommentaire,
      offresession.SSEffectifMin,
      offresession.SSEffectifMax,
      offresession.SSEffectifCommentaire,
      offresession.SSRythme,
      offresession.SSTarifCommentaire,
      offresession.SSLieuCommentaire,
      offresession.SSModalitesFormation,
      offresession.SSPrestation,
      offresession.SSNo

     FROM 	
      offreformation,
      offresession
     
     WHERE	
      offreformation.OFNo = {$formationId}														AND
      offresession.SSPrestation = offreformation.OFNo					
    ");

    return $qr->fetchAll();
  }


  // Retrieve publics 
  public static function getPublics($SSNo) {
    $publicStr  = '';
    $public     = DIOGEN::runQuery("	SELECT
        offrefcpublic.FPNomAcc

      FROM
        offrefcpublic, 
        offresession,
        offreliaisonsessionpublic
        
      WHERE
        offresession.SSNo = offreliaisonsessionpublic.LSPSession	AND
        offreliaisonsessionpublic.LSPPublic = offrefcpublic.FPNo	AND
        offresession.SSNo = {$SSNo}
        
      ORDER BY 
        offrefcpublic.FPOrdre ASC
    ");

    if (!is_string($public)) {
      foreach($public as $a_public) {
        $publicStr .= $a_public->FPNomAcc .', ';
      }
      $publicStr = substr($publicStr, 0, strlen($publicStr) - 2);	
    } 
    else {
      $publicStr = $public;
    }

    return Diogen::removeApostrophe($publicStr);
  }


  // Get duration
  public static function getDuration($s) {// Session
    $ds = '';// Duration String

    if (isset($s->SSDureeCentre) && $s->SSDureeCentre != '' && $s->SSDureeCentre != '0') {
      $ds .= $s->SSDureeCentre .'h (en centre) <br/>';
    }
    if (isset($s->SSDureeEntreprise) && $s->SSDureeEntreprise != '' && $s->SSDureeEntreprise != '0') {
      $ds .= $s->SSDureeEntreprise .'h (en entreprise) <br/>';
    }
    if (isset($s->SSEn2) && $s->SSEn2 == 'V') {
      $ds .= 'La formation se fait en 2 ans <br/>';
    }
    elseif (isset($s->SSEn1Ou2) && $s->SSEn1Ou2 == 'V') {
      $ds .= 'La formation se fait en 1 an <br/>';
    }
    elseif (isset($s->SSDureeP) && $s->SSDureeP == 'V') {
      $ds .= 'La durée de la formation est personnalisée <br/>';
    }
    if (isset($s->SSDureeCommentaire) && $s->SSDureeCommentaire != '') {
      $ds .= $s->SSDureeCommentaire;
    }

    return Diogen::removeApostrophe($ds);
  }


  // Get students counts
  public static function getCounts($s) {// Session
    $cs = '';

    if (isset($s->SSEffectifMin) && $s->SSEffectifMin != '' && $s->SSEffectifMin != '0') {
      $cs .= 'Minimum : '. DIOGEN::removeApostrophe($s->SSEffectifMin) .'<br/>';
    }
    if (isset($s->SSEffectifMax) && $s->SSEffectifMax != '' && $s->SSEffectifMax != '0') {
      $cs .= 'Maximum : '. DIOGEN::removeApostrophe($s->SSEffectifMax) .'<br/>';
    }
    if (isset($s->SSEffectifCommentaire) && $s->SSEffectifCommentaire != '') {
      $cs .= DIOGEN::removeApostrophe($s->SSEffectifCommentaire);
    }

    return $cs;
  }


  // Get prices
  public static function getPrices($s) {
    $ps = '';// Price String
    
    // Formation Price
    $fp = DIOGEN::runQuery("	
      SELECT
        offreliaisonsessiontarif.LSTTarifTTC

      FROM
        offreliaisonsessiontarif, 
        offresession
        
      WHERE
        offreliaisonsessiontarif.LSTSession = offresession.SSNo	AND
        offreliaisonsessiontarif.LSTCategorieTarif = 1			    AND
        offresession.SSNo = {$s->SSNo}
    ");
    if (!is_string($fp)) {								
      if ($fp = $fp->fetch()) {
        $ps = DIOGEN::removeApostrophe($fp->LSTTarifTTC) .' € <br/>';
      }
    }	

    // Hourly Price
    $hp = DIOGEN::runQuery("	
      SELECT
        offreliaisonsessiontarifhoraire.LSHTarifTTC

      FROM
        offreliaisonsessiontarifhoraire, 
        offresession
        
      WHERE
        offreliaisonsessiontarifhoraire.LSHSession = offresession.SSNo	AND
        offreliaisonsessiontarifhoraire.LSHCategorieTarif = 1			      AND
        offresession.SSNo = {$s->SSNo}
    ");
    if (!is_string($hp)) {
      if ($hp = $hp->fetch()) {
        $ps .= DIOGEN::removeApostrophe($hp->LSHTarifTTC) .' €/h <br/>';
      }
    }									

    if (isset($s->SSTarifCommentaire) AND $s->SSTarifCommentaire != '') {
      $ps .= DIOGEN::removeApostrophe($s->SSTarifCommentaire);
    }

    return $ps;
  }
}
