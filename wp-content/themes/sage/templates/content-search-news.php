<article class="entry col-md-12">
    <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
        <div class="col-md-4">
        <?php $image = get_field('post_image');
            if( !empty($image) ): 
                $url = $image['url'];
                $title = $image['title'];
                $alt = $image['alt'];
                $size = 'news';
                $thumb = $image['sizes'][ $size ]; ?>
            <?php endif; ?>
                <img style="width:100%;" src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>" />
        </div>
        <div class="col-md-8">
            <h3><?php the_title(); ?></h3>
            <span><?php the_date() ?></span>
            <?php the_excerpt(); ?>
        </div>
    </a>
</article>
