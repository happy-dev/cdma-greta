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
    if (!is_string($f) AND !empty($f)) {		  
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
}
