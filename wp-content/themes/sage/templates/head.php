<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php 
    wp_head();

    if ($image = get_field('post_image')) {
      echo '<meta property="og:image" content="'. $image['url'] .'" />';
    }
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
