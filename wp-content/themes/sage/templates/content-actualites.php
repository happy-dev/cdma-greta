<article class="entry col-md-12">
    <a class="row row-entry" href="<?php the_permalink(); ?>" title="#">
        <div class="col-md-4">
            <?php 
    $image = get_field('post_image');
        $url = $image['url'];
        $title = $image['title'];
        $alt = $image['alt'];
        $size = 'single_f';
        $thumb = $image['sizes'][ $size ]; 
    ?>
    <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" style='width:100%' />
        </div>
        <div class="col-md-8">
            <h3><?php the_title(); ?></h3>
            <span><?php echo get_the_date() ?></span>
            <?php the_excerpt(); ?>
        </div>
    </a>
</article>