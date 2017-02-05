<?php
require_once('Diogen.php');
require_once('DiogenHelper.php');

$fi = get_field('formation_id');// Formation Id
//$fi = 29877;// Single session
//$fi = 30143;// Multiple sessions
$fi = 27494;// Date commented
$fs = DiogenHelper::getFormation($fi);// Formations
print_r($fs);
die();
$ss = DiogenHelper::getSessions($fi);// Sessions
$ms = count($ss) > 1;// Multiple Sessions ? true or false

//print_r( $fs ); 
//print_r( $ss ); 

// Iterating through each session
foreach ($ss as $s) {
  $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
  $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
  $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
  $ps   = DiogenHelper::getPublics($s->SSNo);// Publics
  $pc   = Diogen::removeApostrophe($s->SSPublicCommentaire);// Publics Commentaire
  $ds   = DiogenHelper::getDuration($s);// Durations
  $cts  = DiogenHelper::getCounts($s);// Counts
  $pcs  = DiogenHelper::getPrices($s);// Prices 
  $cs   = DiogenHelper::getConditions($s);// Conditions 
  $ls   = DiogenHelper::getLocations($s);// Locations 
  $ct   = DiogenHelper::getContact($fi, $s);// Contact
}

$ctn    = Diogen::removeApostrophe($fs->OFContenu);// Contenu
$obj    = Diogen::removeApostrophe($fs->OFObjectif);// Objectifs
$prm    = Diogen::removeApostrophe($fs->OFPrerequisMaxi);// Prérequis
$metp   = Diogen::removeApostrophe($fs->OFMethode);// Méthodes pédagogiques
$mop    = DiogenHelper::getMoyPeda($fs, $fi);// Moyens pédagogiques
$rcac   = DiogenHelper::getRecoAcquis($fs, $fi);// Reconnaissance des acquis
$int    = Diogen::removeApostrophe($fs->OFIntervenant);// Intervenant
$forc   = DiogenHelper::getFormacode($fs, $fi);// Formacode
$corm   = DiogenHelper::getCodeROME($fs, $fi);// Code ROME
