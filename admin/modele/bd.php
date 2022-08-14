<?php

function dbconnect()
{

	try
	{
	// On se connecte à MySQL
	$db = new PDO('mysql:host=localhost;dbname=mboa shop;charset=utf8', 'root');
	}
	catch(PDOException $e)
	{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('impossible de se connecter a la base de donnee');
	}

	return $db; 

}   

function connec_up(){

	$db = dbconnect();

		$req=$db->prepare('SELECT * FROM utilisateurs_admin WHERE id = ?');
		$req->execute(array($_SESSION['id']));
		$resultat = $req->fetch();

		if ($resultat) {
			
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['statut'] = $resultat['statut'];
			$_SESSION['mail'] = $resultat['mail'];
			$_SESSION['action'] = $resultat['action'];

			$req->closeCursor();
		}else{ $req->closeCursor(); }
}
