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

<div class="stage container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
        <li class="breadcrumb-item"><a href="#">Entreprise</a></li>
        <li class="breadcrumb-item active">Offres de stage</li>
    </ol>
    
    <section>
        <div class="content">
            <h1><?php the_title() ?></h1>
            <div class="row">
    <!-- THE QUERY -->
        <?php 
        $args=( array( 	'post_type' => 'stages' ,
                        'posts_per_page' => 12  ) );  
        $the_query = new WP_Query( $args ); 
            while ( $the_query->have_posts()) : $the_query->the_post(); ?>
                <article class="entry col-md-6">
                    <a href="<?php the_permalink(); ?>">

                    <h3><?php the_title(); ?></h3>
                    <span>Date de début : <?php the_field('debut_stage'); ?> - <?php the_field('nature_stage'); ?></span>
                    <p>
                        Profil recherché : <?php the_field('profil_stage'); ?><br/>
                        Personne à contacter : <?php the_field('contact_stage'); ?><br/>
                        Email : <?php the_field('email_stage'); ?><br/>
                        <?php the_excerpt(); ?></p>
                    </a>
                </article>
            <?php endwhile; ?>
        <?php wp_reset_postdata();?>
            </div>
        </div>
    </section>
</div>