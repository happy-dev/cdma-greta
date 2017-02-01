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
    echo $f->post_title .'<br/>';
    $df   = DiogenHelper::getMatchingDiogenFormation($fdia[$f->ID], $dfs);
    $ss   = DiogenHelper::getSessions($fdia[$f->ID]);// Sessions

    // Iterating through each session
    foreach ($ss as $s) {
      $sd   = Diogen::dateFromDiogenToHtml($s->SSDateDeb);// Start Date 
      $ed   = Diogen::dateFromDiogenToHtml($s->SSDateFin);// End Date
      $dc   = Diogen::removeApostrophe($s->SSDateCommentaire);// Date Comment
    }

    echo $sd .'<br/>';
    echo $ed .'<br/>';
    echo $dc .'<br/>';
    echo $df->OFIntervenant .'<br/>';
    echo $df->OFObjectif .'<br/>';
    echo '<br/><br/>';
  }
}
