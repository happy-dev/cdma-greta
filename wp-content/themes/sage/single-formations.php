<?php
  require_once('DiogenHelper.php');

  the_post();

  // IMAGE / VIDEO
  $image = get_field('post_image');

  if( !empty($image) ): 
    $url = $image['url'];
    $title = $image['title'];
    $alt = $image['alt'];
    $size = 'thumbnail';
    $thumb = $image['sizes'][ $size ]; 
?>
  <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" />
<?php endif; ?>

  <!-- TEXTE -->
<h1><?php the_title(); ?></h1>

<?php the_content();

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
    $dc = $s->SSDateCommentaire;// Date Comment
    if (isNotNull($dc)) {
      $dc = Diogen::removeApostrophe($dc);
    }

    //print_r($dc);


    // If multiple sessions...
    if ($ms) {
    }
    else {
    }
  }
