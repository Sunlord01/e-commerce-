<?php

session_start();
session_regenerate_id(); 

try{

	if ( !empty($_GET['un']) && !empty($_SESSION['statut']) && $_GET['un'] == "choix" && $_SESSION['action'] != "bloquer") {

		require 'modele/bd.php';
		
		require 'controleur/choix.php';
	}

	elseif ( !empty($_GET['un']) && !empty($_SESSION['statut'])  && $_SESSION['action'] != "bloquer") {

		require 'modele/bd.php';
		connec_up();

		function deconnexion(){

				session_destroy();
				
				header('location:index.php');
		}
		
		if ( $_SESSION['statut'] == "admin") {

			require 'controleur/admin.php';
		}

		elseif ( $_GET['un'] == "accueil" && $_SESSION['statut'] != "admin"  && $_SESSION['action'] != "bloquer") {

			require 'controleur/accueil.php';
		}
		
		elseif ( $_GET['un'] == "gestion" AND $_SESSION['statut'] == "gerant"  && $_SESSION['action'] != "bloquer") {

			require 'controleur/gestion.php';
		}

		elseif ( $_GET['un'] == "add_del" AND $_SESSION['statut'] == "gerant"  && $_SESSION['action'] != "bloquer" ) {

			require 'controleur/add_del.php';
		}

		elseif ( $_GET['un'] == "forum" AND $_SESSION['statut'] == "gerant"  && $_SESSION['action'] != "bloquer" ) {

			require 'controleur/forum.php';
		}

		elseif ( $_GET['un'] == "connexion"  && $_SESSION['action'] != "bloquer") {

			require 'controleur/connexion.php';
		}
		
		elseif ($_GET['un'] == "deconnexion"  && $_SESSION['action'] != "bloquer") {
			 
			deconnexion();
		}

		else{                       
		            
		require 'controleur/accueil.php';
		}


	}
	
	else{                            //**********affiche initial et en cas de soucis de la page d'accueil

		require 'modele/bd.php';
		
		require 'controleur/connexion.php';
	}

} catch (Exception $e) {

	die('Erreur a la racine:'.$e->getMessage());
}

?>



