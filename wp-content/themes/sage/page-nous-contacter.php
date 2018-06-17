<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <span id="privacy-agreement-content" style="display: none;"><?php the_field('contact_privacy_agreement', 'option'); ?></span>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
