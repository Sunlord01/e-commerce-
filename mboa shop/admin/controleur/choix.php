<?php

if (!empty($_POST['choisir']) AND $_POST['choisir'] == "utilisateur" ) {

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM utilisateurs WHERE pseudo = ? AND statut = ?');
	$req->execute(array($_SESSION['pseudo'],$_SESSION['statut']));
	$resultat = $req->fetch();

		if ($resultat) {
			
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['mail'] = $resultat['mail'];
			
			$req->closeCursor();

			header('location:../index.php?un=compte');

		}else{ $req->closeCursor(); 
			session_destroy();
			header('location:../index.php?un=connexion');
		}

}
elseif (!empty($_POST['choisir']) AND $_POST['choisir'] == "administrateur" ) {

		$db = dbconnect();

		$req=$db->prepare('SELECT * FROM utilisateurs_admin WHERE pseudo = ? AND statut = ?');
		$req->execute(array($_SESSION['pseudo'],$_SESSION['statut']));
		$resultat = $req->fetch();

		if ($resultat) {
			
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['statut'] = $resultat['statut'];
			$_SESSION['mail'] = $resultat['mail'];
			$_SESSION['action'] = $resultat['action'];

			$req->closeCursor();

		}else{ $req->closeCursor(); }

		header('location:index.php?un=accueil');
	
}

require 'vue/vue_choix.php';

?>