<?php

function connexion(){

	$db = dbconnect();

	if ( !empty($_POST['pseudo']) && !empty($_POST['pass']) && !!empty($_POST['mail']) && !empty($_POST['statut']) ) {

		$pass =sha1($_POST['pass']);

		$rep=$db->prepare('SELECT * FROM utilisateurs_admin WHERE (lower(nom) OR lower(mail)) = ? AND pass = ? AND statut = "admin"');
		$rep->execute(array(strtolower($_POST['pseudo']),$pass));
		$result = $rep->fetch();

		if ($result) {
			
			$_SESSION['pseudo'] = $result['nom'];
			$_SESSION['id'] = $result['id']; 
			$_SESSION['statut'] = $result['statut'];

		$rep->closeCursor();

		header('location:index.php?un=accueil');

		}else{
		
			$req=$db->prepare('SELECT * FROM utilisateurs_admin WHERE (lower(nom) OR lower(mail)) = ? AND pass = ? AND statut = ?');
			$req->execute(array($_POST['pseudo'],$pass,$_POST['statut']));
			$resultat = $req->fetch();

			if ($resultat) {
				
				$_SESSION['pseudo'] = $resultat['nom'];
				$_SESSION['id'] = $resultat['id'];
				$_SESSION['statut'] = $resultat['statut'];

			$req->closeCursor();

			$req = $db->prepare('UPDATE utilisateurs_admin SET action = :action WHERE id = :id');
			$req->execute(array('action' => 'actif' , 'id' => $_SESSION['id']));

				header('location:index.php?un=accueil');

			}else{
				echo '<h1 class="error"> Adresse mail ou mot de passe INCORRECT </h1>';	

			}

		}
	}
}



?>