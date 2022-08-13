<?php

function get_carac_type(){

	$db = dbconnect();

	$result=$db->query('SELECT DISTINCT type FROM articles WHERE statut = "actif"');
	
	$tab = array();
	$count = 0;

	while ($donne = $result->fetch()) {
		
		$tab[$count] = $donne['type'];
		$count++;
	}

	return $tab;
}

function get_carac_couleur(){

	$db = dbconnect();

	$result=$db->query('SELECT DISTINCT couleur FROM melange M JOIN articles A ON M.id_article = A.id 
					WHERE A.statut = "actif" ORDER BY couleur ASC');
	
	$tab = array();
	$count = 0;

	while ($donne = $result->fetch()) {
		
		$tab[$count] = $donne['couleur'];
		$count++;
	}

	return $tab;
}

function get_carac_taille(){

	$db = dbconnect();

	$result=$db->query('SELECT DISTINCT taille FROM melange M JOIN articles A ON M.id_article = A.id 
					WHERE A.statut = "actif"  ORDER BY taille DESC');
	
	$tab = array();
	$count = 0;

	while ($donne = $result->fetch()) {
		
		$tab[$count] = $donne['taille'];
		$count++;
	}

	return $tab;
}

function add_article()
{

	$db = dbconnect();

if (!empty($_FILES['image']) && !empty($_POST['nom']) && !empty($_POST['prix'])) {

	$tmpName = $_FILES['image']['tmp_name'];
	$name = $_FILES['image']['name'];
	$size = $_FILES['image']['size'];
	$error = $_FILES['image']['error'];
	$names = explode('.', $name);
	$extension = strtolower(end($names)); 
	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];
	$maxSize = 400000;

	if ( (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) ) {
		
		copy($tmpName, 'image/'.$name);
		copy($tmpName, '../mboa shop/image/'.$name);
		
		$quantites = array_sum(explode(',', $_POST['quantite']));

		$req = $db->prepare('INSERT INTO articles (nom,description,image,prix,type,quantite,vendu,boutique,solde,likes,statut) 
							VALUES(:nom,:description,:image,:prix,:type,:quantite,:vendu,:boutique,:solde,:likes,:statut)');
		$req->execute(array(
			'nom' => $_POST['nom'],
			'description' => $_POST['description'],
			'image' => 'image/'.$name,
			'prix' => $_POST['prix'],
			'type' => $_POST['type'],
			'quantite' => $quantites,
			'vendu' => 0,
			'boutique' => $_POST['boutique'],
			'solde' => $_POST['solde'],
			'likes' => 0,
			'statut' => "actif"

		));

		$rep = $db->prepare('SELECT id FROM articles WHERE nom = ? AND description = ? AND image = ? AND vendu = 0 
							AND prix = ? AND type = ? AND quantite = ? AND boutique = ? AND solde = ? AND likes = ? AND statut = ? ');
		$rep->execute(array($_POST['nom'],$_POST['description'],'image/'.$name,$_POST['prix'],
					$_POST['type'],$quantites,$_POST['boutique'],$_POST['solde'],0,"actif"));

		while ($donne = $rep->fetch()) {
			$id = $donne['id'];
		}$rep->closeCursor();

		$couleur = array();
		$couleur = explode(',', $_POST['couleur']);
		$quantite = array();
		$quantite = explode(',', $_POST['quantite']);
		$taille = array();
		$taille = explode(',', $_POST['taille']);

		foreach ($quantite as $cle => $element) { 

		$tmpName = $_FILES['image'.$cle]['tmp_name'];
		$name = $_FILES['image'.$cle]['name'];
		$size = $_FILES['image'.$cle]['size'];
		$error = $_FILES['image'.$cle]['error'];
		$names = explode('.', $name);
		$extension = strtolower(end($names)); 
		$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];
		$maxSize = 400000;

		if ( (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) ) {
			
			copy($tmpName, 'image/'.$name);
			copy($tmpName, '../mboa shop/image/'.$name);

			$req = $db->prepare('INSERT INTO melange (id_article,image,couleur,taille,quantite) 
								VALUES(:id_article,:image,:couleur,:taille,:quantite)');
			$req->execute(array(
				'id_article' => $id,
				'image' => 'image/'.$name,
				'couleur' => $couleur[$cle],
				'taille' => $taille[$cle],
				'quantite' => $element
			));

			}

		}

	}else{
		echo "Mauvaise extension ou taille du fichier trop grande, une erreur c'est produite ";
	}
	
}

}

function get_solde($var){

	$db = dbconnect();

		$req = $db->prepare('SELECT solde FROM articles WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$solde = $donne['solde'];
		$req->closeCursor();

		return $solde;	
}

function get_melange($var) 
{

	$db = dbconnect();

	$result=$db->prepare('SELECT * FROM melange WHERE id_article = ? ');
	$result->execute(array($var));

	return $result;
}

function del_article()
{

	$db = dbconnect();

	if (!empty($_GET['id_article'])) {

		$req = $db->prepare('DELETE FROM articles WHERE id = ? ');
		$req->execute(array($_GET['id_article']));

		$req = $db->prepare('DELETE FROM melange WHERE id_article = ? ');
		$req->execute(array($_GET['id_article']));

	}

	if (!empty($_GET['id_melange']) ) {

		$result=$db->prepare('SELECT * FROM melange WHERE id = ?');
		$result->execute(array($_GET['id_melange']));
	
			$id = 0;
			$quantite = 0;
			$vendu = 0;
			while ($donne = $result->fetch()) {
				
				$id = $donne['id_article'];
				$quantite = $donne['quantite'];
				$vendu = $donne['vendu'];
			}

		$req = $db->prepare('DELETE FROM melange WHERE id = ? ');
		$req->execute(array($_GET['id_melange']));

		$req = $db->prepare('UPDATE articles SET quantite = quantite-? , vendu = vendu-? WHERE id = ?');
		$req->execute(array($quantite,$vendu,$id));

	}

}

function pagination() 
{
		global $articleParPage, $pageTotales, $depart, $pageCourante;

		$db = dbconnect();

	$articleParPage = 3;
	
	$articleTotalReq = $db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
									WHERE A.boutique = ? ');
	$articleTotalReq->execute(array($_SESSION['id']));

	$articleTotals = $articleTotalReq->rowCount(); 
	$pageTotales = ceil($articleTotals / $articleParPage);

	if (!empty($_GET['page']) AND $_GET['page'] > 0) {
		
		$_SESSION['page'] = intval($_GET['page']);

		$pageCourante = $_SESSION['page'];

	}elseif (!empty($_SESSION['page'])) {
		
		$pageCourante = $_SESSION['page'];
	}
	else{

		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $articleParPage;
}


function get_articles($depart,$articleParPage) 
{

	$db = dbconnect();

	$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
						WHERE A.boutique = ? ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
	$result->execute(array($_SESSION['id']));

	return $result;
}

function get_articles_recherche($depart,$articleParPage){

	$db = dbconnect();

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
							WHERE A.boutique = ? AND lower(A.nom) like "%'.$_SESSION['recherche'].'%"');
		$result->execute(array($_SESSION['id']));

		return $result;

}

