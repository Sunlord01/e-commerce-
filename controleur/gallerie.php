<?php
require 'modele/modele_gallerie.php';

add_like();
del_like();

if ( !empty($_POST['genre']) ) { $_SESSION['genre'] = $_POST['genre']; }
if ( !empty($_POST['c_couleur']) ) { $_SESSION['c_couleur'] = $_POST['c_couleur']; }
if ( !empty($_POST['c_taille']) ) { $_SESSION['c_taille'] = $_POST['c_taille']; }
if ( !empty($_POST['c_type']) ) { $_SESSION['c_type'] = $_POST['c_type']; }
if ( !empty($_POST['c_prix']) ) { $_SESSION['c_prix'] = $_POST['c_prix']; }

if (empty($_SESSION['genre'])) {
	
	if ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) {
			
		pagination();

		$articles = get_articles($depart,$articleParPage);

	}else{

		pagination_choix();

		$articles = get_articles_choix($depart,$articleParPage);
	}
}else{

	if ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) {
			
		pagination_genre();

		$articles = get_articles_genre($depart,$articleParPage);

	}else{

		pagination_choix_genre();

		$articles = get_articles_choix_genre($depart,$articleParPage);
	}
}



require 'vue/vue_gallerie.php';
?>    