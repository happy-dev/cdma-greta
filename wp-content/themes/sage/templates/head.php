<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
    $formation_slug = get_query_var('formation');
    $domain_slug = get_query_var('domain');
    $email = get_query_var('email');

    echo '<meta property="og:url" content="'. home_url($_SERVER['REQUEST_URI']) .'" />';
    echo '<meta name="twitter:url" content="'. home_url($_SERVER['REQUEST_URI']) .'" />';

    if ($formation_slug && !$email) {
      $code_AF = substr($formation_slug, strrpos($formation_slug, '-') + 1);
      $formation = Dokelio::getMetaTags($code_AF);
      echo '<title>'. $formation->meta_titre .' - Greta CDMA</title>';
      echo '<meta name="description" content="'. $formation->meta_description .'">';
      echo '<meta property="og:image" content="'. site_url() .'/wp-content/themes/sage/images/'. $formation->nom_image_formation .'" />';
      echo '<meta name="twitter:image" content="'. site_url() .'/wp-content/themes/sage/images/'. $formation->nom_image_formation .'" />';
    }
    elseif ($domain_slug) {
      $formation = Dokelio::getDomain($domain_slug);
      echo '<title>'. $formation->meta_titre_domaine .'</title>';
      echo '<meta name="description" content="'. $formation->meta_description_domaine .'">';
      echo '<meta property="og:image" content="'. site_url() .'/wp-content/themes/sage/images/'. $formation->image_domaine .'" />';
      echo '<meta name="twitter:image" content="'. site_url() .'/wp-content/themes/sage/images/'. $formation->image_domaine .'" />';
    }
    elseif ($image = get_field('post_image')) {
      echo '<meta property="og:image" content="'. $image['url'] .'" />';
      echo '<meta name="twitter:image" content="'. $image['url'] .'" />';
    }
    else {
      echo '<meta property="og:image" content="'. site_url() .'/wp-content/uploads/filiere-chapelerie-3.jpg" />';
      echo '<meta name="twitter:image" content="'. site_url() .'/wp-content/uploads/filiere-chapelerie-3.jpg" />';
    }

    wp_head();
  ?>

  <!-- Global site tag (gtag.js) - Google Ads: 981902260 -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=AW-981902260"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'AW-981902260');
  </script>

  <?php // Tracking convertions of forms
   if (in_array($post->ID, array("755327", "754682"))) {
     $ga  = "<!-- Event snippet for Prospect conversion page";
     $ga .= "In your html page, add the snippet and call gtag_report_conversion when someone clicks on the chosen link or button. -->";
     $ga .= "<script>";
     $ga .= "function gtag_report_conversion(url) {";
     $ga .=    "var callback = function () {";
     $ga .=      "if (typeof(url) != 'undefined') {";
     $ga .=        "window.location = url;";
     $ga .=      "}";
     $ga .=    "};";
     $ga .=    "gtag('event', 'conversion', {";

     if ($post->ID == "755327") {
       $ga .= "'send_to': 'AW-981902260/jW5RCOjSwJkBELTHmtQD',";
     }
     else {
       $ga .= "'send_to': 'AW-981902260/2xBtCMvVpHsQtMea1AM',";
     }
     $ga .=        "'event_callback': callback";
     $ga .=    "});";
     $ga .=    "return false;";
     $ga .=  "}";
     $ga .=  "gtag_report_conversion();";
     $ga .=  "</script>";
     echo $ga;
   }
  ?>
</head>
