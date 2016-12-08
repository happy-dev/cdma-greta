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

<div class="article container">
    <ol class="breadcrumb hidden-md-down">
        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
        <li class="breadcrumb-item ">Actualité</li>
        <li class="breadcrumb-item active">Nos formations sur les logiciels en design d’espace et design intérieur</li>
    </ol>
    <section>
        <div class="row row-offcanvas row-offcanvas-left">
            <div class="column col-md-3 sidebar-offcanvas" id="sidebar">
                <h3>Actualité</h3>
                <ul>
                    <li><a href="#">Actualié Formations</a></li>
                    <li><a href="#">Actualié Greta</a></li>
                    <li><a href="#">Presse</a></li>
                </ul>
            </div>

            <div class="content col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn hidden-md-up navbar-toggle" data-toggle="offcanvas">Voir les catégories</button>
                    </div>
                </div>
                <?php while (have_posts()) : the_post(); ?>
                  <article <?php post_class(); ?>>
                    <header>
                      <h1><?php the_title(); ?></h1>
                      <?php get_template_part('templates/entry-meta'); ?>
                    </header>
                    <div>
                      <?php the_content(); ?>
                    </div>
                    <footer>
                      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
                    </footer>
                    <?php //comments_template('/templates/comments.php'); ?>
                  </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
</div>
