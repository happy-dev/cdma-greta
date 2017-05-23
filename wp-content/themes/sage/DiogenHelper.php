<?php
require_once('Diogen.php');

/**
 * Group of functions that make querying Diogen a breeze
 */ 
Class DiogenHelper {

  // Retrieve a formation object as defined in Diogen
  public static function getFormation($formationsIds) {
    $fqp = '';// Formation Query Part

    // Several formations
    if (is_array($formationsIds)) {
      $fis = implode(',', $formationsIds);// Formations Ids String
      $fqp = "offreformation.OFNoPermanent IN ({$fis})";
    }
    // Only one
    else {
      $fqp = "offreformation.OFNoPermanent = {$formationsIds}";
    }

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
      offreformation.OFReconduit IN ('V', 'K')						AND
      offreliaisonformationmotcle.LMCMotCle = offremotcle.MCNo				AND
      {$fqp}
    ");

    if (!is_array($formationsIds)) {
      return $qr->fetch();
    }
    else {
      return $qr->fetchAll();
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
      offreformation.OFNoPermanent = {$formationId}					AND
      offreformation.OFReconduit IN ('V', 'K')						AND
      offresession.SSPrestation = offreformation.OFNo					

     ORDER BY offresession.SSDateDeb ASC, offresession.SSDateFin ASC
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
      $first = true;

      foreach($ls->fetchAll() as $l) {
	if (!$first) {
	  $lcs .= '<br/>';
        }

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
          $lcs .= '<a href="mailto:'. Diogen::removeApostrophe($l->STMel) .'">'. Diogen::removeApostrophe($l->STMel) .'</a><br/>';
        }

	$first = false;
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
      	  offreformation.OFReconduit IN ('V', 'K')				AND
          offreliaisonformationcontact.LFTPersonne = personne.PENo		AND
          offreformation.OFNoPermanent = {$fID}
      ");
    }
    if ($cs->rowCount() > 0) {
      $o = '';// Output
      $first=true;
      foreach ($cs->fetchAll() as $c) {
        $o .= self::outputContact($c, $first);
        $first=false;
      }
      return $o;
    }		
  }

  // Output contact info
  private static function outputContact($c, $first=false) {
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
    $idc='';
    if ($first) { $idc= 'id="coordo-email"'; }
    if (isset($c->PEMel1) && $c->PEMel1 != '' ) {
      $o .= '<a '.$idc.' href="mailto:'.Diogen::removeApostrophe($c->PEMel1).'">'. Diogen::removeApostrophe($c->PEMel1) .'</a><br/>';
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
        offreliaisonformationmoyenpedagogique.LMPMoyenPedagogique = offremoyenpedagogique.MPCode	AND
        offreformation.OFNoPermanent = {$fID}
    ");	


    $o  = '';// Output
    $oa = [];// Output Array
    if ($mps->rowCount() > 0) {
      foreach($mps as $mp) {
        $oa[] = ucfirst(Diogen::removeApostrophe($mp->MPIntitule));
      }
      $o = implode(', ', $oa) .'.<br/>';
    } 

    if (isset($f->OFMoyens) AND $f->OFMoyens != '') {
      $o .= Diogen::removeApostrophe($f->OFMoyens);
    }

    return $o;
  }

  // Get Reco Acquis
  public static function getRecoAcquis($f, $fID) {
    $o = '';// Output

    if (isset($f->OFCertification) && $f->OFCertification > 0) {
      $ra = Diogen::runQuery("
        SELECT
          offrecertificationintitule.CIIntitule

        FROM
          offrecertificationintitule, 
          offreformation
          
        WHERE
          offrecertificationintitule.CINo = offreformation.OFCertificationIntitule AND
          offreformation.OFNoPermanent = {$fID}
      ");
      if ($ra->rowCount() > 0) {					
        if ($rao = $ra->fetch()) {// Reco Acquis Object
          $o .= $rao->CIIntitule .'<br/>';
        }
      }
    } 
    elseif (isset($f->OFCertification) && $f->OFCertification == 0) {
      $ra = Diogen::runQuery("
        SELECT
          offresanction.SAIntitule

        FROM
          offresanction, 
          offreformation
          
        WHERE
          offresanction.SANo = offreformation.OFSanction AND
          offreformation.OFNoPermanent = {$fID}
      ");
      if ($ra->rowCount() > 0) {					
        if ($rao = $ra->fetch()) {// Reco Acquis Object
          $o .= Diogen::removeApostrophe($rao->SAIntitule) .'<br/>';
        }
      }
    }

    if (isset($f->OFCommentaireReconnaissance) && $f->OFCommentaireReconnaissance != '') {
      $o .= Diogen::removeApostrophe($f->OFCommentaireReconnaissance);
    }

    return $o;
  }

  // Get Formacode
  public static function getFormacode($f, $fID) {
    $fcs = Diogen::runQuery("	
      SELECT DISTINCT
        offrefcformacode.FCCode,
        offrefcformacode.FCNomAcc

      FROM
        offrefcformacode, 
        offreformation,
        offreliaisonformationfc
        
      WHERE
        offreformation.OFNo = offreliaisonformationfc.LFFFormation	AND
        offreliaisonformationfc.LFFFCCode = offrefcformacode.FCCode	AND
        offreformation.OFNoPermanent = {$fID}
        
      ORDER BY offreliaisonformationfc.LFFOrdre
    ");
    $fca = [];// FormaCode Array
    if ($fcs->rowCount() > 0) {
      foreach($fcs as $fc) {
        $fca[] = $fc->FCCode .' - '. $fc->FCNomAcc.'<br/>';
      }
      return Diogen::removeApostrophe(implode('', $fca));
    }
  }

  // Get Code ROME
  public static function getCodeROME($f, $fID) {
    $crs = Diogen::runQuery("
      SELECT DISTINCT
        offreliaisonfcrome.LFRRomeCode,
        offreliaisonfcrome.LFRRomeIntitule

      FROM
        offreliaisonfcrome, 
        offreformation,
        offreliaisonformationrome
        
      WHERE
        offreformation.OFNo = offreliaisonformationrome.LFOFormation			      AND
        offreliaisonformationrome.LFORomeCode = offreliaisonfcrome.LFRRomeCode	AND
        offreformation.OFNoPermanent = {$fID}
    ");
    $cra = [];// Code ROME Array
    if ($crs->rowCount() > 0) {
      foreach($crs as $cr) {
        $cra[] = $cr->LFRRomeCode .' - '. $cr->LFRRomeIntitule.'<br/>';
      }
      return Diogen::removeApostrophe(implode('', $cra));
    }
  }

  // Get Matching Diogen Formation
  // Diogen ID, Diogen Formations Array
  public static function getMatchingDiogenFormation($di, $dfa) {
    foreach($dfa as $df) {// Diogen formation
      if ($df->OFNoPermanent == $di) {
        return $df;
      }
    }
  }

  // Get the HTML of the left column header of the formation's session
  public static function getLeftColumnHeader($ss, $fi) {// Sessions, Formation Id
    $class = 'active';
    $html  = '';

    $html .= '<h2>Dates</h2>';
    $html .= '<ul id="sessions-switch" class="" role="tablist">';

    foreach ($ss as $s) {
      $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
      $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
      
      if ($sd && $ed) { 
	$html .= '<li role="presentation" >';
        $html .=   '<a class="'. $class .'" href="#session-'. $s->SSNo .'" data-toggle="tab">Du '. $sd .' au '. $ed .'</a>';// dates de session
        $html .= '</li>';

 	$class = '';
      }
    }

    $html .= '</ul>';

    return $html;
  }


  // Get the HTML of the left column of the formation's session
  public static function getLeftColumn($s, $fi, $first) {// Session, Formation Id
    $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
    $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
    $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
    $ps   = ucfirst( DiogenHelper::getPublics($s->SSNo) );// Publics
    $pc   = Diogen::removeApostrophe($s->SSPublicCommentaire);// Publics Commentaire
    $ds   = DiogenHelper::getDuration($s);// Durations
    $cts  = DiogenHelper::getCounts($s);// Counts
    $pcs  = DiogenHelper::getPrices($s);// Prices 
    $cs   = DiogenHelper::getConditions($s);// Conditions 
    $ls   = DiogenHelper::getLocations($s);// Locations 
    $ct   = DiogenHelper::getContact($fi, $s);// Contact
    $html = '';

    $class = '';
    if ($first) {
      $class = 'in active';
    }

    $html .= '<div id="session-'. $s->SSNo .'" role="tabpanel" class="tab-pane fade '. $class .'">';
    // 1. DATES
      $html .= '<h2>Dates</h2>';
      $html .= '<pre>Du '. $sd .' au '. $ed . '</pre>';
      if ($dc) {
        $html .= '<pre>' . $dc . '</pre>';// commentaire de date
      }

    // 2. PUBLIC
    if ($ps || $pc) {
      $html .= '<h2>Public</h2>';
      $html .= '<pre>';

      if ($ps) {
        $html .= $ps;
      }
      if ($pc) {
        if ($ps) {
          $html .= '<br/>';
        }
        $html .= $pc;
      }

      $html .= '</pre>';
    }

    // 3. DUREE
    if ($ds) {
      $html .= '<h2>Durée</h2>';
      $html .= '<pre>';
      $html .=   $ds;
      $html .= '</pre>';
    }

    // 4. TARIF
    if ($pcs) {
      $html .= '<h2>Tarif(s)</h2>';
      $html .= '<pre>';
      $html .=   $pcs;
      $html .= '</pre>';
    }

    // 5. LIEU
    if ($ls) {
      $html .= '<h2>Lieu(x)</h2>';
      $html .= '<pre>';
      $html .= $ls;
      $html .= '</pre>';
    }

    // 6. MODALITE
    if ($cs) {
      $html .= '<h2>Modalité de formation</h2>';
      $html .= '<pre>';
      $html .= $cs;
      $html .= '</pre>';
    }

    // 7. EFFECTIF
    if ($cts) {
      $html .= '<h2>Effectif</h2>';
      $html .= '<pre>';
      $html .= $cts;
      $html .= '</pre>';
    }

    // 8. COORDONNEES GRETA
    $html .= '<h2>Coordonnées</h2>';
    $html .= '<pre>';
    $html .=   'GRETA CDMA<br/>';
    $html .=   'Agence administrative et commerciale<br/>';
    $html .=   '21 rue de Sambre et Meuse<br/>';
    $html .=   '75010 - PARIS<br/>';
    $html .=   '<a href="mailto:info@cdma.greta.fr">info@cdma.greta.fr</a>';
    $html .= '</pre>';

    // 9. CONTACT -->
    if ($ct) {
      $html .= '<h2>Contact(s)</h2>';
      $html .= '<pre>'. $ct .'</pre>';
    }
    $html .= '</div>';

    return $html;
  }


  // Get the description of a formation for search and domain pages
  public static function getDescription($tc, $f) {// The Content, Formation
    if (!nullOrEmpty($tc)) {
      return $tc;
    }
    else if (!nullOrEmpty($f->OFAccroche)) {
      return Diogen::removeApostrophe($f->OFAccroche);
    }
    else if (!nullOrEmpty($f->OFObjectif)) {
      return Diogen::removeApostrophe($f->OFObjectif);
    }
  }


  // Get the admission modalities
  public static function getAdmissionMod($fs, $fID) {
    $mar = '';// Méthodes d'Admission et de Recrutement

    $results = Diogen::runQuery("
      SELECT
        offreadmission.ADIntitule

      FROM
        offreadmission, 
        offreformation,
        offreliaisonformationadmission
        
      WHERE
        offreformation.OFNo=offreliaisonformationadmission.LFAFormation		AND
        offreliaisonformationadmission.LFAAdmission=offreadmission.ADCode	AND
  	offreformation.OFNoPermanent = {$fID}
    ");

    $arr = [];

    if ($results->rowCount() > 0) {
      foreach($results as $result) {
        $arr[] = ucfirst( Diogen::removeApostrophe($result->ADIntitule) );
      }
      $mar = implode(', ', $arr) .'.<br/>';
    } 


    if (!nullOrEmpty($fs->OFSelection)) {
      $mar .= Diogen::removeApostrophe($fs->OFSelection);
    }

    return $mar;
  }
}
