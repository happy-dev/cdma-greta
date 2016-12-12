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
                <div class="row row-checkbox">
                    <div class="col-lg-12">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox1" value="option1">
                        Formations diplomantes
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox2" value="option2">
                        Formations éligibles au CPF
                        </label>
                    </div>
                </div>
            </form>
      </div>
    </nav>
</div>

<?php while (have_posts()) : the_post(); ?>
<div class="presentation presentation-page">
    <div class="container">
        <div class="row row-intro">
            <div class="col-md-3"></div>
            <div class="intro col-md-6 col-sm-12 col-xs-12">
                <h1><?php the_title(); ?></h1>
                <span>Date de début : <?php the_field('debut_stage'); ?> - <?php the_field('nature_stage'); ?></span>
                <p>
                    Profil recherché : <?php the_field('profil_stage'); ?><br/>
                    Personne à contacter : <?php the_field('contact_stage'); ?><br/>
                    Email : <?php the_field('email_stage'); ?><br/>
                    <?php the_excerpt(); ?></p>
            </div>
            <div class="col-md-3"></div>

        </div>
    </div>
</div>
<?php endwhile; ?>
