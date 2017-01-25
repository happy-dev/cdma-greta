<?php
require_once('Diogen.php');

/**
 * Group of functions that make querying Diogen a breeze
 */ 
Class DiogenHelper {

  // Retrieve a formation object as defined in Diogen
  public static function getFormation($formationId) {
    // Query Result
    $qr = Diogen::runQuery("SELECT 
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

    if ($qr->rowCount() > 0) {		  
      return $qr->fetch();
    }
  }


  // Retrieve sessions 
  public static function getSessions($formationId) {
    $qr = Diogen::runQuery("SELECT 
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

    if ($qr->rowCount() > 0) {		  
      return $qr->fetchAll();
    }
  }


  // Retrieve publics 
  public static function getPublics($SSNo) {
    $publicStr  = '';
    $public     = Diogen::runQuery("	SELECT
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

    if ($public->rowCount() > 0) {
      foreach($public->fetchAll() as $a_public) {
        $publicStr .= $a_public->FPNomAcc .', ';
      }
      return Diogen::removeApostrophe(substr($publicStr, 0, strlen($publicStr) - 2));
    } 
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
      $cs .= 'Minimum : '. Diogen::removeApostrophe($s->SSEffectifMin) .'<br/>';
    }
    if (isset($s->SSEffectifMax) && $s->SSEffectifMax != '' && $s->SSEffectifMax != '0') {
      $cs .= 'Maximum : '. Diogen::removeApostrophe($s->SSEffectifMax) .'<br/>';
    }
    if (isset($s->SSEffectifCommentaire) && $s->SSEffectifCommentaire != '') {
      $cs .= Diogen::removeApostrophe($s->SSEffectifCommentaire);
    }

    return $cs;
  }


  // Get prices
  public static function getPrices($s) {
    $ps = '';// Price String
    
    // Formation Price
    $fp = Diogen::runQuery("	
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
    if ($fp->rowCount() > 0) {								
      if ($fp = $fp->fetch()) {
        $ps = Diogen::removeApostrophe($fp->LSTTarifTTC) .' € <br/>';
      }
    }	

    // Hourly Price
    $hp = Diogen::runQuery("	
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
    if ($hp->rowCount() > 0) {
      if ($hp = $hp->fetch()) {
        $ps .= Diogen::removeApostrophe($hp->LSHTarifTTC) .' €/h <br/>';
      }
    }									

    if (isset($s->SSTarifCommentaire) AND $s->SSTarifCommentaire != '') {
      $ps .= Diogen::removeApostrophe($s->SSTarifCommentaire);
    }

    return $ps;
  }


  // Get conditions of the formation
  public static function getConditions($s) {// Session
    $css  = '';// Conditions String
    $csa  = [];// Conditions Array
    $cs   = Diogen::runQuery(" 
      SELECT 
        offreorganisation.ORIntitule

       FROM 	
        offreorganisation,
        offresession,
        offreliaisonsessionorganisation
       
       WHERE	
        offresession.SSNo = offreliaisonsessionorganisation.LSOSession				AND
        offreliaisonsessionorganisation.LSOOrganisation = offreorganisation.ORNo	AND
        offresession.SSNo = {$s->SSNo}	
        
       ORDER BY
        offreorganisation.ORNo ASC
    ");	

    if ($cs->rowCount() > 0) {
      foreach($cs as $c) {
        $csa[] = $c->ORIntitule;
      }
      $css = implode(', ', $csa) .'<br/>';
    } 

    if (isset($s->SSModalitesFormation) AND  $s->SSModalitesFormation != '') {
      $css .= DIOGEN::removeApostrophe($s->SSModalitesFormation);
    }

    return $css;
  }


  // Get location of the formation
  public static function getLocations($s) {// Session
    $lcs = '';// Localtion String

    $ls = Diogen::runQuery("	
      SELECT
        structure.STNom,
        structure.STLabelLycMet,
        structure.STAdresse,
        structure.STCP,
        structure.STVille,
        structure.STTel,
        structure.STFax,
        structure.STMel

      FROM
        structure, 
        offresession,
        offreliaisonsessionlieu
        
      WHERE
        offreliaisonsessionlieu.LSLSession = offresession.SSNo	AND
        offreliaisonsessionlieu.LSLLieu = structure.STNo		AND
        offresession.SSNo = {$s->SSNo}
    ");

    if ($ls->rowCount() > 0) {
      foreach($ls->fetchAll() as $l) {
        if (isset($l->STNom) AND $l->STNom != '') {
          $lcs .= Diogen::removeApostrophe($l->STNom);
          
          if (isset($l->STLabelLycMet) AND $l->STLabelLycMet != '') {
            $lcs .= ' : '. Diogen::removeApostrophe($l->STLabelLycMet);
          }
          $lcs .= '<br/>';
        }
        if (isset($l->STAdresse) AND $l->STAdresse != '') {
          $lcs .= Diogen::removeApostrophe($l->STAdresse) .'<br/>';
        }
        if (isset($l->STCP) AND $l->STCP != '') {
          $lcs .= Diogen::removeApostrophe($l->STCP);
          
          if (isset($l->STVille) AND $l->STVille != '') {
            $lcs .= ' - '. Diogen::removeApostrophe($l->STVille);
          }
          $lcs .= '<br/>';
        }
        if (isset($l->STTel) AND $l->STTel != '') {
          $lcs .= 'Tel : '. Diogen::removeApostrophe($l->STTel) .'<br/>';
        }
        if (isset($l->STFax) AND $l->STFax != '') {
          $lcs .= 'Fax : '. Diogen::removeApostrophe($l->STFax) .'<br/>';
        }
        if (isset($l->STMel) AND $l->STMel != '') {
          $lcs .= Diogen::removeApostrophe($l->STMel) .'<br/>';
        }
      }
    }

    if (isset($s->SSLieuCommentaire) AND $s->SSLieuCommentaire != '') {
      $lcs .= Diogen::removeApostrophe($s->SSLieuCommentaire) .'<br/>';
    }

    return $lcs;
  }


  // Get contact info
  public static function getContact($fID, $s) {// formation ID
    // Contact
    $c = Diogen::runQuery("
      SELECT
        personne.PENom,
        personne.PEPrenom,
        personne.PETel1,
        personne.PETel2,
        personne.PEMel1

      FROM
        offresession,
        personne,
        offreliaisonsessioncontact
        
      WHERE
        offresession.SSNo = offreliaisonsessioncontact.LSCSession AND
        offreliaisonsessioncontact.LSCPersonne = personne.PENo    AND
        offresession.SSNo = {$s->SSNo}
    ");
    
    if ($c->rowCount() > 0) {
      return self::outputContact($c->fetch());
    }
    else {
      $cs = Diogen::runQuery("
        SELECT
          personne.PENom,
          personne.PEPrenom,
          personne.PETel1,
          personne.PETel2,
          personne.PEMel1

        FROM
          personne, 
          offreformation,
          offreliaisonformationcontact
          
        WHERE
          offreformation.OFNo = offreliaisonformationcontact.LFTFormation	AND
          offreliaisonformationcontact.LFTPersonne = personne.PENo		AND
          offreformation.OFNo = {$fID}
      ");
    }
    if ($cs->rowCount() > 0) {
      $o = '';// Output
      foreach ($cs->fetchAll() as $c) {
        $o .= self::outputContact($c);
      }
      return $o;
    }		
  }

  // Output contact info
  private static function outputContact($c) {
    $o = '';// Output

    if (isset($c->PEPrenom) && $c->PEPrenom != '') {
      $o .= Diogen::removeApostrophe($c->PEPrenom);
      if (isset($c->PENom) && $c->PENom != '') {
        $o .= ' '. Diogen::removeApostrophe($c->PENom);
      }
      $o .= '<br/>';
    }
    if (isset($c->PETel1) && $c->PETel1 != '') {
      $tel = trim( Diogen::removeApostrophe($c->PETel1) );
      if (strlen($c->PETel1) < 14) {
        $tel = chunk_split($tel, 2, ' ');
      }
      $o .= 'Tel: '. $tel .'<br/>';
    }
    if (isset($c->PETel2) && $c->PETel2 != '') {
      $tel = trim( Diogen::removeApostrophe($c->PETel2) );
      if (strlen($c->PETel2) < 14) {
        $tel = chunk_split($tel, 2, ' ');
      }
      $o .= 'Mob:'. $tel .'<br/>';
    }
    if (isset($c->PEMel1) && $c->PEMel1 != '') {
      $o .= '<a href="mailto:'.Diogen::removeApostrophe($c->PEMel1).'">'. Diogen::removeApostrophe($c->PEMel1) .'</a>';
    }

    return $o;
  }

  // Get Moyens Pédagogiques
  public static function getMoyPeda($f, $fID) {
    $mps = Diogen::runQuery("
      SELECT
        offremoyenpedagogique.MPIntitule

      FROM
        offreformation,
        offremoyenpedagogique,
        offreliaisonformationmoyenpedagogique
        
      WHERE
        offreformation.OFNo = offreliaisonformationmoyenpedagogique.LMPFormation				        AND
        offreliaisonformationmoyenpedagogique.LMPMoyenPedagogique = offremoyenpedagogique.MPNo	AND
        offreformation.OFNo = {$fID}
    ");	

    $o  = '';// Output
    $oa = [];// Output Array
    if ($mps->rowCount() > 0) {
      foreach($mps as $mp) {
        $oa[] = $mp->MPIntitule;
      }
      $o = implode(',', $oa) .'<br/>';
    } 

    if (isset($f->OFMoyens) AND $f->OFMoyens != '') {
      $o .= Diogen::removeApostrophe($f->OFMoyens);
    }

    return $o;
  }
}
