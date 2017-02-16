<?php
require_once('DiogenHelper.php');

while (have_posts()) { 
  the_post(); 

  $fs   = get_field('formations_dom');// Formations
  $fdia = [];// Formations DIOGEN IDs Array

  foreach($fs as $f) {// Formation
    $fdia[$f->ID] = get_field('id_diogen', $f->ID);
  }
  $dfs = DiogenHelper::getFormation($fdia);// Diogen Formations

  foreach($fs as $f) {
    $df   = DiogenHelper::getMatchingDiogenFormation($fdia[$f->ID], $dfs);
    $ss   = DiogenHelper::getSessions($fdia[$f->ID]);// Sessions

    $ft   = $f->post_title;// Formation Title
    $obj  = $df->OFObjectif;// Objectif

    // Iterating through each session
    foreach ($ss as $s) {
      $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
      $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
      $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
    }
    
    
  }
}
