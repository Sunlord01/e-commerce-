<?php

if ( !empty($_SESSION['panier']) ) {

	require 'modele/modele_mail.php';

	$get_commande_non_valide = get_commande_non_valide();

	if (!$get_commande_non_valide) {
	header('location:index.php?un=panier&error=impossible d\'effectuer la commande');
	}

	require 'vue/vue_mail.php';

}else{
	header('location:index.php?un=panier&error=impossible d\'effectuer la commande');
}


?>