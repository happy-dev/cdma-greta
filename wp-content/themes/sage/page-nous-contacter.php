<?php 
  $privacy_field = isset($privacy_field) ? $privacy_field : 'contact_privacy_agreement';
  $formation_slug = get_query_var('formation');
  $session_code = get_query_var('session');
  $code_AF = substr($formation_slug, strrpos($formation_slug, '-') + 1);
  $formations = Dokelio::getContactsInfo($code_AF);
  $formation = $formations[0];

  if (!$formation_slug || ($formation_slug && $formation)) :
    $email_addresses = array($formations[0]->contact_mel);

    foreach($formations as $formation) {
      $email_addresses[] = $formation->contact_mel_domaine;
    }
    $email_addresses = array_unique( array_map( 'trim', $email_addresses ) );

    while (have_posts()) {
      the_post();
      get_template_part('templates/page', 'header');
      echo '<span id="formation-title" style="display: none;">'. $formation->synth_titre .'</span>';
      echo '<span id="domain-name" style="display: none;">'. $formation->lib_domaine .'</span>';
      echo '<span id="code-af" style="display: none;" data-codeaf="'. $code_AF .'"></span>';
      echo '<span id="session-code" style="display: none;" data-sessioncode="'. $session_code .'"></span>';
      echo '<span id="formation-email-addresses" style="display: none;">'. implode(', ', $email_addresses) .'</span>';
?>
    <span id="privacy-agreement-content" style="display: none;"><?php the_field($privacy_field, 'option') ?></span>

<?php
    get_template_part('templates/content', 'page');
  }

  else:
?>
  <div class="container">
    <p class="formation-not-found">Cette formation n'est plus proposée actuellement.<br/> Veuillez utiliser la page <a href="/nous-contacter">Contact</a> pour trouver la formation qui correspond à vos attentes.</p>
  </div>
<?php
  endif;
