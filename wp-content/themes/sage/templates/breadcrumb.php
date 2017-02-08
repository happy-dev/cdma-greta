<?php 
// Breadcrumb navigation

if (is_page() && !is_front_page() || is_single() || is_category()) {

echo '<ol class="breadcrumb hidden-md-dow">';
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

if (is_single()) {
	$category = get_the_category();
	echo '<li class="breadcrumb-item"><a href="/actualites">Actualités</a></li>';
	echo '<li class="breadcrumb-item"><a href="'.get_category_link($category[0]->cat_ID).'">'.$category[0]->cat_name.'</a></li>';
}

if (is_category()) {
	echo '<li class="breadcrumb-item"><a href="/actualites">Actualités</a></li>';
	$category = get_the_category();
	echo '<li class="breadcrumb-item hidden-md-down">'.$category[0]->cat_name.'</li>';
}

// Current page
if (is_page() || is_single()) {
	echo '<li class="breadcrumb-item active">'.get_the_title().'</li>';
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
