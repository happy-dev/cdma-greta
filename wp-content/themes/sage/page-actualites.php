<div class="secondary-navbar">
    <nav class="navbar container">
        <!-- button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button -->
        <div class="row">
            <ul class="nav navbar-nav col-lg-8 hidden-md-down">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="formations-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Formations</a>
                    <div class="dropdown-menu" aria-labelledby="formations-dropdown">
                        
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Certifications et VAE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Financez votre formation</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="http://example.com" id="entreprise-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Entreprise</a>
                    <div class="dropdown-menu" aria-labelledby="entreprise-dropdown">
                       
                    </div>
                </li>
            </ul>
            <form class="form-inline col-sm-12 col-xs-12 col-md-12 col-lg-4">
                <div class="row">
                    <div class="col-sm-11 col-xs-10">
                        <input class="form-control"
                               type="text"
                               placeholder="Chercher une formation" />
                    </div>
                    <div class="col-sm-1 col-xs-2">
                        <button class="btn btn-outline-success" type="submit">OK</button>
                    </div>
                </div>
            </form>
      </div>
    </nav>
</div>

<div class="actualite">
    <section class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item hidden-md-down"><a href="#">Accueil</a></li>
            <li class="breadcrumb-item hidden-md-down"><a href="#">Formations</a></li>
            <li class="breadcrumb-item hidden-md-down"><a href="#">Art du bois</a></li>
            <li class="breadcrumb-item hidden-md-down active">Dessin d'ornement lié au patrimoine</li>
        </ol>

        <div class="row row-offcanvas row-offcanvas-left">
            <div class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Actualité</h3>
                <ul>
                    <li><a href="#" >Actualité Greta</a></li>
                    <li><a href="#" >Actualité Formations</a></li>
                    <li><a href="#" >Presse</a></li>
                </ul>
            </div>

            <div class="content col-md-9">
                <!-- THE QUERY -->

                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir les domaines</button>
                        <h2><?php the_title() ?></h2>
                        <?php //the_content() ?>
                    </div>
                </div>

                <div class="row">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?> 

                <!-- THE QUERY -->
                <?php 
                $args=( array( 	'post_type' => 'post' ,
                                'posts_per_page' => 12  ) );  
                $the_query = new WP_Query( $args ); 
                    while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                        <article class="entry col-md-12">
                            <a class="row row-entry" href="<?php the_permalink(); ?>" title="#">
                                <div class="col-md-4">
                                    <img
                                         src="<?php echo get_site_url().'/wp-content/uploads/formation-default.jpg'; ?>"
                                         alt="<?php echo $alt; ?>" />
                                </div>
                                <div class="col-md-8">
                                    <h3><?php the_title(); ?></h3>
                                    <?php the_excerpt(); ?>
                                </div>
                            </a>
                        </article>
                    <?php endwhile; ?>
                <?php wp_reset_postdata();?>
        <?php endwhile; ?>
    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</div>