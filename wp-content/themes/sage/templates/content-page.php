<section class="page-greta article container">
<?php 
$int = get_field('international_link');
$int_url = get_field('international_url');
if (!empty($int)) {
	if ($int == 'french') {
		echo '<a href="'.$int_url.'">Lire cette page en français</a>';
	}
	if ($int == 'english') {
		echo '<a href="'.$int_url.'">Read this content in english</a>';
	}
}
?>
    <?php the_content(); ?>
</section>
<?php //wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
