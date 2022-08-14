<?php

function pagination_non_valide() 
{
		global $articleParPage_nv, $pageTotales_nv, $depart_nv, $pageCourante_nv;

		$db = dbconnect();

	$articleParPage_nv = 2;
	
	$articleTotalReq = $db->prepare('SELECT * FROM commande WHERE id_utilisateur=? AND statut="non-valider"  ');
	$articleTotalReq->execute(array( $_SESSION['id'] ));

	$articleTotals_nv = $articleTotalReq->rowCount();
	$pageTotales_nv = ceil($articleTotals_nv / $articleParPage_nv);

	if (!empty($_GET['page_nv']) AND $_GET['page_nv'] > 0) {
		
		$_SESSION['page_nv'] = intval($_GET['page_nv']);

		$pageCourante_nv = $_SESSION['page_nv'];
	}else{

		$pageCourante_nv = 1;
	}

	$depart_nv = ($pageCourante_nv - 1) * $articleParPage_nv;
}


function get_commande_non_valide( $depart_nv,$articleParPage_nv )
{

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE id_utilisateur=? AND statut="non-valider" ORDER BY date_commande DESC LIMIT '.$depart_nv.','.$articleParPage_nv);
	$req->execute(array($_SESSION['id']));

	return $req;

}

function pagination_valide() 
{
		global $articleParPage_v, $pageTotales_v, $depart_v, $pageCourante_v;

		$db = dbconnect();

	$articleParPage_v = 2;
	
	$articleTotalReq = $db->prepare('SELECT * FROM commande WHERE id_utilisateur=? AND statut="valider" ');
	$articleTotalReq->execute(array( $_SESSION['id'] ));

	$articleTotals_v = $articleTotalReq->rowCount();
	$pageTotales_v = ceil($articleTotals_v / $articleParPage_v);

	if (!empty($_GET['page_v']) AND $_GET['page_v'] > 0) {
		
		$_SESSION['page_v'] = intval($_GET['page_v']);

		$pageCourante_v = $_SESSION['page_v'];
	}else{

		$pageCourante_v = 1;
	}

	$depart_v = ($pageCourante_v - 1) * $articleParPage_v;
}

function get_commande_valide( $depart_v,$articleParPage_v )
{

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE id_utilisateur=? AND statut="valider" ORDER BY date_commande DESC LIMIT '.$depart_v.','.$articleParPage_v);
	$req->execute(array($_SESSION['id']));

	return $req;

}

function get_info($info){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM utilisateurs WHERE id=?');
	$req->execute(array($_SESSION['id']));

	$info_r = "";

	while ($donne = $req->fetch()) {

	$info_r = $donne[$info];

		}
	$req->closeCursor();

	return $info_r;

}

function get_nom_article($var)
{
	$nom = "article non present";

	$db = dbconnect();

	$rep = $db->prepare('SELECT A.nom FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
	$rep->execute(array($var));
			
	while ($donne = $rep->fetch()) {

	$nom = $donne['nom'];

		}
	$rep->closeCursor();

	return $nom;
}

function get_prix($var)
{
    $db = dbconnect();

    $rep = $db->prepare('SELECT A.prix,A.solde FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
    $rep->execute(array($var));
            
    $prix = 0;
    while ($donne = $rep->fetch()) {

    $prix = $donne['prix'] - ($donne['prix'] * $donne['solde']);

        }
    $rep->closeCursor();

    return $prix;
}


function get_couleur($var){

	$db = dbconnect();

	$req = $db->prepare('SELECT couleur FROM melange WHERE id = ? ');
	$req->execute(array($var));

	$couleur = "!";
	while ($donne = $req->fetch()) {

	$couleur = $donne['couleur'];

		}
	$req->closeCursor();

	return $couleur;
}

function get_taille($var){

	$db = dbconnect();

	$req = $db->prepare('SELECT taille FROM melange WHERE id = ? ');
	$req->execute(array($var));

	$taille = "!";
	while ($donne = $req->fetch()) {

	$taille = $donne['taille'];

		}
	$req->closeCursor();

	return $taille;
}

function annul_commande()
{
	$db = dbconnect();

	if (!empty($_GET['statut_annuler'])) {

		$rep = $db->prepare('SELECT * FROM commande WHERE id=?');
		$rep->execute(array($_GET['statut_annuler']));

		while ($donnes=$rep->fetch()) {

				$produits = explode(',', $donnes['id_melange']);
				$quantites = explode(',', $donnes['quantite']);
		
			}
		$rep->closeCursor();

		$nbr = 0;
		foreach ($produits as $value) {
			$reponse = $db->prepare('UPDATE  articles SET quantite=quantite+? WHERE id=?');
			$reponse->execute(array($quantites[$nbr],$value));

			$nbr++;
		}

		$reponse = $db->prepare('DELETE FROM commande WHERE id=?');
		$reponse->execute(array($_GET['statut_annuler']));
	}

}


function modif_compte()
{

	$db = dbconnect();

	if ( !empty($_POST['pseudo_compte']) | !empty($_POST['mail_compte']) | !empty($_POST['pass_compte']) | !empty($_POST['tel'])  ) { 


		if (!empty($_POST['pseudo_compte']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs SET pseudo = :pseudo WHERE id = :id');
				$req->execute(array('pseudo' => $_POST['pseudo_compte'] , 'id' => $_SESSION['id']));

				$_SESSION['pseudo'] = $_POST['pseudo_compte'];
			 	
			}
 

		if (!empty($_POST['mail_compte']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs SET mail = :mail WHERE id = :id');
				$req->execute(array('mail' => $_POST['mail_compte'] , 'id' => $_SESSION['id']));

				$_SESSION['mail'] = $_POST['mail_compte'];
			 	
			}


		if (!empty($_POST['pass_compte']) ) {


			$pass = sha1($_POST['pass_compte']);
				
				$req = $db->prepare('UPDATE utilisateurs SET pass = :pass WHERE id = :id');
				$req->execute(array('pass' => $pass ,'id' => $_SESSION['id']));

				$_SESSION['pass'] = $pass;
			 	
			}

		if (!empty($_POST['tel_compte']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs SET tel = :tel WHERE id = :id');
				$req->execute(array( 'tel' => $_POST['tel_compte'] ,'id' => $_SESSION['id']));
			 	
			}

	}

}

