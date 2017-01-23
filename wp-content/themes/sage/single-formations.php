<?php
require_once('Diogen.php');
require_once('DiogenHelper.php');

$fi = get_field('formation_id');// Formation Id
//$fi = 29877;// Single session
//$fi = 30143;// Multiple sessions
$fi = 27494;// Date commented
$fs = DiogenHelper::getFormation($fi);// Formations
$ss = DiogenHelper::getSessions($fi);// Sessions
$ms = count($ss) > 1;// Multiple Sessions ? true or false

//print_r( $fs ); 
//print_r( $ss ); 

// Iterating through each session
foreach ($ss as $s) {
  $sd = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
  $ed = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
  $dc = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
  $ps = DiogenHelper::getPublics($s->SSNo);// Publics
}

print_r($ps);
