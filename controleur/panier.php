<?php

if (!empty($_GET['mail'])) {
	
	unset($_SESSION['panier']);
  	unset($_SESSION['taille']);
  	unset($_SESSION['couleur']);
  	unset($_SESSION['quantite']);
  	unset($_SESSION['prix_total']);
}

if ( empty($_SESSION['panier']) ) {

	$_SESSION['panier']=array();
	$_SESSION['couleur']=array();
	$_SESSION['taille']=array(); 
	$_SESSION['quantite']=array();
	$_SESSION['prix']=array();
	$_SESSION['prix_total']=array();

}else{} 
 
require 'modele/modele_panier.php';

ajout_au_panier();

del_article_panier();

set_quantite();

enregistrement();

if ( !empty($_SESSION['panier']) ) {

	$articles = get_articles_panier();

}

require 'vue/vue_panier.php';
?>