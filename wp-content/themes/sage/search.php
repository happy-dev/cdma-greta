<div class="secondary-navbar">
    <nav class="navbar container">
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
            <?php get_search_form(); ?>
      </div>
    </nav>
</div>

<div class="search-domaine">

<?php if (!have_posts()) { ?>
  <div class="alert alert-warning">
    <?php _e('Aucun résultat ne correspond à la recherche', 'sage'); ?>
  </div>
<?php 
} 
else { ?>
    
<section class="container">
    <div class="row row-offcanvas row-offcanvas-left">
        <div class="column col-md-3 sidebar-offcanvas" id="sidebar">
        </div>
        
        <div class="content col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir la liste des domaines</button>
                    <h2>Formations pour "<?php the_search_query(); ?>"</h2>
                </div>
            </div>
            
            <div class="row">
            <?php 
                while (have_posts()) : the_post(); 
                    if ( 'formations' == get_post_type() ) { 
                        get_template_part('templates/content', 'search');
                    }
                    elseif ( 'post' == get_post_type()){
                    }
                    else {
                            echo 'Aucune formation ne correspond à la recherche';
                        }
                endwhile; 
            ?>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <h2>Actualités pour "<?php the_search_query(); ?>"</h2>
                </div>
            </div>
            
            <div class="row">
            <?php 
                while (have_posts()) : the_post(); 
                    if ( 'post' == get_post_type() ) { 
                        get_template_part('templates/content', 'search');
                    }
                    elseif ( 'formations' == get_post_type()){
                    }
                    else {
                            echo 'Aucune actualité ne correspond à la recherche';
                    }
                endwhile; 
            } ?>
            </div>

        <?php the_posts_navigation(); ?>
        </div>
    </div>
</section>