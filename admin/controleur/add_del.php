<?php

require 'modele/modele_add_del.php';

add_article();
del_article();

if ( !empty($_POST['recherche'] ) ) {
	
	$_SESSION['recherche'] =  htmlspecialchars($_POST['recherche']) ;
}
	pagination();

	$articles = get_articles($depart,$articleParPage);

if ( empty($_SESSION['recherche']) ) {
		
	pagination(); 

	$articles = get_articles($depart,$articleParPage);

}else{

	$articles = get_articles_recherche($depart,$articleParPage);
}


require 'vue/vue_add_del.php';

?>  