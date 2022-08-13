 <?php

function get_nom($nom){

	$db = dbconnect();

	$req=$db->prepare('SELECT nom FROM utilisateurs WHERE id=?');
	$req->execute(array($nom));

	$info = "";

	while ($donne = $req->fetch()) {

	$info = $donne['nom'];

		}
	$req->closeCursor();

	return $info;

}

function get_nom_boutique(){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM boutique WHERE id=?');
	$req->execute(array($_SESSION['id']));

	$info = "";

	while ($donne = $req->fetch()) {

	$info = $donne['nom'];

		}
	$req->closeCursor();

	return $info;

}

function get_forum($depart,$articleParPage)
{

	$db = dbconnect();

	$req=$db->query('SELECT * FROM forum ORDER BY dates DESC LIMIT '.$depart.','.$articleParPage);

	return $req; 

}

function pagination() 
{
		global $articleParPage, $pageTotales, $depart, $pageCourante;

		$db = dbconnect();

	$articleParPage = 3;
	
	$articleTotalReq = $db->query('SELECT id FROM forum ');

	$articleTotals = $articleTotalReq->rowCount();
	$pageTotales = ceil($articleTotals / $articleParPage);

	if (!empty($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0) {
		
		$_SESSION['page'] = intval($_GET['page']);

		$pageCourante = $_SESSION['page'];
	}else{

		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $articleParPage;
}

function add_msg()
{

	$db = dbconnect();

	if (!empty($_POST['nom']) AND !empty($_POST['message'])) {
	
		if (strtolower($_POST['nom']) != "administrateur" && strtolower($_POST['nom']) != "administrateur mboa shop" && strtolower($_POST['nom']) != "administrateur mboa") {
		
			$req = $db->prepare('INSERT INTO forum (id_utilisateur,titre,message) VALUES(:id,:titre,:message)');
			$req->execute(array(
				'id' => $_SESSION['id'],
				'titre' => $_POST['titre'],
				'message' => $_POST['message']
				));
		}

	}
}

