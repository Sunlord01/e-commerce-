<?php

session_start();
session_regenerate_id();

try{

	if (!empty($_GET['un']) && !empty($_GET['un'])) { if (!empty($_GET['error'])) { echo '<h1 class="error">'.$_GET['error'].'</h1>'; }

		require 'modele/bd.php';

		function deconnexion(){

				session_destroy();

				header('location:index.php');
		}
		

		if ($_GET['un'] == "accueil") {      //************chargement de la page d'accueil 
			
			require 'controleur/accueil.php';

		}

		elseif ($_GET['un'] == "boutique" ) {
			
			require 'controleur/boutique.php';
		}

		elseif ($_GET['un'] == "article" ) {
			 
			require 'controleur/article.php';
		}

		elseif ($_GET['un'] == "gallerie") {
			
			require 'controleur/gallerie.php';
		}

		elseif ($_GET['un'] == "panier") {
			 
			require 'controleur/panier.php';
		}

		elseif ($_GET['un'] == "forum") {
			 
			require 'controleur/forum.php';
		}

		elseif ($_GET['un'] == "recherche" && ( !empty($_SESSION['recherche']) OR !empty($_POST['recherche']) ) ) {
			 
			require 'controleur/recherche.php';
		}

		elseif ($_GET['un'] == "connexion") {
			 
			require 'controleur/connexion.php';
		}

		elseif ($_GET['un'] == "compte" && !empty($_SESSION['id']) ) {
			 
			require 'controleur/compte.php';
		}

		elseif ($_GET['un'] == "mail") {

			require 'controleur/mail.php';
		}

		elseif ($_GET['un'] == "deconnexion") {
			 
			deconnexion();
		}

		else{                       
		            
		require 'controleur/accueil.php';
	}


	}
	
	else{                                   //**********affiche initial et en cas de soucis de la page d'accueil

		require 'modele/bd.php';
		
		require 'controleur/accueil.php';
	}

} catch (Exception $e) {

	die('Erreur a la racine:'.$e->getMessage());
}

?>



