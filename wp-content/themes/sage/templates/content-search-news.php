<article class="entry col-md-4">
    <a href="<?php the_permalink(); ?>" title="<?php echo $title; ?>">
        <?php $image = get_field('post_image');
	    $alt = '';

            if( !empty($image) ): 
                $url = $image['url'];
                $title = $image['title'];
                $alt = $image['alt'];
                $size = 'news';
                $thumb = $image['sizes'][ $size ]; ?>
            <?php endif; ?>
        <img style="width:100%;" src="<?php echo $thumb ?>" alt="<?php echo $alt; ?>" />
        <h3><?php the_title(); ?></h3>
        <span>
	<?php 
	  $cats = get_the_category();
	  $arr  = [];
	  foreach($cats as $cat) {
	    $arr[] = $cat->name;
	  }
	  
	  echo implode(', ', $arr);
	?>
	</span>
        <?php the_excerpt(); ?>
    </a>
</article>
