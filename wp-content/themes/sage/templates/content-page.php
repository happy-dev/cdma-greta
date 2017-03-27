<section class="page-greta article container">
<?php 
    $int = get_field('international_link');
    $int_url = get_field('international_url');
    
    $int_text = ($int == 'french') ? 'Lire cette page en français' : 'Read this content in english';
?>
    
    <?php if (!empty($int)) : ?>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-international <?php echo $int; ?>" href="<?php echo $int_url; ?>"><?php echo $int_text; ?></a>
        </div>
    </div>
    <?php endif; ?>
    
    <?php the_content(); ?>
</section>
<?php //wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
