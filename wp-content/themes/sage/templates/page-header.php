<?php use Roots\Sage\Titles; ?>

<?php
    $imageArray = get_field('page_header_img');
    if( !empty($imageArray) ): 
    $image = $imageArray['url']; 
    endif; ?> 

<section class="presentation presentation-page" style="background-image: url(<?php echo $image; ?>); background-size:cover; ">
    <div class="container">
        <div class="row row-intro">
            <div class="col-md-3"></div>
            <div class="intro col-md-6 col-sm-12 col-xs-12">
                <h1><?= Titles\title(); ?></h1>
                <?php the_field('page_header_text') ?>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php get_template_part('templates/breadcrumb'); ?>
</section>