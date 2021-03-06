
<article class="entry col-md-12">
    <?php $image = get_field('post_image');
    if( !empty($image) ): 
        $url = $image['url'];
        $title = $image['title'] ? $image['title'] : "" ;
        $alt = $title;
        $size = 'news';
        $thumb = $image['sizes'][ $size ];
    endif; ?>
    <a class="row row-entry" href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
        <div class="col-md-3">
	  <img style="width:100%;" src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>" />
        </div>
        <div class="col-md-9">
            <h3><?php the_title(); ?></h3>
            <span>Du 03/11/2016 au 31/01/2017 <br/>
        Session de formation conventionnée par la Région IDF pour les demandeurs d'emploi.</span>
            <?php the_excerpt(); ?>
        </div>
    </a>
</article>
