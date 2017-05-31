<div class="article container" id="single-article-page">
    <?php get_template_part('templates/breadcrumb'); ?>
    <div class="row row-offcanvas row-offcanvas-left">
       <aside class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Actualité</h3>
                <ul>
                <?php wp_list_categories( array(
                                        'orderby' => 'name',
                                        'title_li' => '',
                                        'exclude'    => array( 6, 1 )
                                    ) ); ?>
                </ul>
        </aside>

        <section class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir les catégories</button>
                </div>
            </div>
            <?php if (have_posts()) : the_post(); ?>
            <div class="content">
                <article>
                    <header>
                        <h1><?php the_title(); ?></h1>
                        <?php get_template_part('templates/entry-meta'); ?>
                    </header>
                    <?php the_content(); ?>
                    <footer>
                        <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
                    </footer>
                </article>
            </div>
            <?php endif; ?>
        </section>
    </div>
</div>
