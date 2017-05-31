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
</head>
