<?php 
// Breadcrumb navigation
if (is_page() && !is_front_page() || is_single() || is_category()) {
wp_reset_postdata();

echo '<ol class="breadcrumb hidden-md-dow" id="breadcrumb">';
echo '<li class="breadcrumb-item hidden-md-down"><a title="GRETA CDMA - Accueil" rel="nofollow" href="/">Accueil</a></li>';


	if (is_page()) {
	$ancestors = get_post_ancestors($post);

		if ($ancestors) {
		$ancestors = array_reverse($ancestors);

		foreach ($ancestors as $crumb) {
		echo '<li class="breadcrumb-item"><a href="'.get_permalink($crumb).'">'.get_the_title($crumb).'</a></li>';
		}
	}
}

// Actu single
if (is_singular('post')) {
	$category = get_the_category();
	echo '<li class="breadcrumb-item"><a href="/actualite">Actualités</a></li>';
}

if (is_singular('stages')) {
	echo '<li class="breadcrumb-item"><a href="/entreprise">Entreprise</a></li>';
	echo '<li class="breadcrumb-item"><a href="/entreprise/offres-de-stage/">Offres de stage</a></li>';
}

$domain = get_query_var('domain');
if ($domain) {
	echo '<li class="breadcrumb-item"><a href="/domaine-offres">Formations</a></li>';
}

// Actu category
if (is_category()) {
	$category = get_category($cat);
	echo '<li class="breadcrumb-item"><a href="/actualite">Actualités</a></li>';
	echo '<li class="breadcrumb-item hidden-md-down">'. $category->name .'</li>';
}



// Current page
if (!$domain && (is_page() || is_single())) {
  $title = get_the_title();
  if ($title == 'Domaine offres') {
    echo '<li class="breadcrumb-item active">Formations</li>';
  }
  if ($title == 'Fiche formation') {
    echo '<li class="breadcrumb-item"><a href="/domaine-offres">Formations</a></li>';
  }
  else {
    echo '<li class="breadcrumb-item active">'.$title.'</li>';
  }
} else {
  echo '<li class="breadcrumb-item active">'.Dokelio::getDomain($domain).'</li>';
}

echo '</ol>';
} elseif (is_page() && !is_front_page()) {
echo '<ol class="breadcrumb">';
echo '<li class="breadcrumb-item"><a title="GRETA CDMA - Accueil" rel="nofollow" href="a href="/">Accueil</a></li>';


	if (is_page()) {
	$ancestors = get_post_ancestors($post);

		if ($ancestors) {
		$ancestors = array_reverse($ancestors);

		foreach ($ancestors as $crumb) {
		echo '<li class="breadcrumb-item"><a href="'.get_permalink($crumb).'">'.get_the_title($crumb).'</a></li>';
		}
	}
}

if (is_single()) {
	$category = get_the_category();
	echo '<li class="breadcrumb-item"><a href="'.get_category_link($category[0]->cat_ID).'">'.$category[0]->cat_name.'</a></li>';
}

if (is_category()) {
	$category = get_the_category();
	echo '<li class="breadcrumb-item">'.$category[0]->cat_name.'</li>';
}

// Current page
if (is_page() || is_single()) {
	echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';
}
echo '</ol>';

}

?>
