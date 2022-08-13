 <?php  

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

function get_article($depart,$articleParPage) 
{

	$db = dbconnect();

	$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
						WHERE A.boutique = ? ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
	$result->execute(array($_SESSION['id']));

	return $result;
}

function pagination_statut($var) 
{
		global $articleParPage_s, $pageTotales_s, $depart_s, $pageCourante_s;

		$db = dbconnect();

	$articleParPage_s = 3;
	
	$articleTotalReq = $db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
									WHERE A.boutique = ? AND statut = ? ');
	$articleTotalReq->execute(array($_SESSION['id'],$var));

	$articleTotals_s = $articleTotalReq->rowCount(); 
	$pageTotales_s = ceil($articleTotals_s / $articleParPage_s);

	if (!empty($_GET['page_s']) AND $_GET['page_s'] > 0) {
		
		$_SESSION['page_s'] = intval($_GET['page_s']);

		$pageCourante_s = $_SESSION['page_s'];

	}elseif (!empty($_SESSION['page_s'])) {
		
		$pageCourante_s = $_SESSION['page_s'];
	}
	else{

		$pageCourante_s = 1;
	}

	$depart_s = ($pageCourante_s - 1) * $articleParPage_s;
}


function get_article_statut($var,$depart_s,$articleParPage_s){

	$db = dbconnect();

	$req = $db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
						WHERE A.boutique = ? AND statut = ? ORDER BY date_entree ASC LIMIT '.$depart_s.','.$articleParPage_s);
	$req->execute(array($_SESSION['id'],$var));

	return $req;
}

function get_article_recherche(){

	$db = dbconnect();

	$req = $db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
						WHERE A.boutique = ? AND lower(nom) like "%'.$_SESSION['recherche'].'%" ');
	$req->execute(array($_SESSION['id']));

	return $req;
}

function get_melange($var){

	$db = dbconnect();

	$req = $db->prepare('SELECT * FROM melange WHERE id_article = ? ');
	$req->execute(array($var));

	return $req;
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

function get_statut($var){

	$db = dbconnect();

		$req = $db->prepare('SELECT statut FROM articles WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$statut = $donne['statut'];
		$req->closeCursor();

		return $statut;	
}

function update(){

	$db = dbconnect();

	if (!empty($_POST['statut_up']) ) {
			
			$req = $db->prepare('UPDATE articles SET statut = ? WHERE id = ?');
			$req->execute(array($_POST['statut_up'],$_POST['id_article']));
		}

	if (!empty($_POST['id_article'])) { //////////////////////  4 parametres
		
		
		if (!empty($_POST['nom']) ) {
			
			$req = $db->prepare('UPDATE articles SET nom = ? WHERE id = ?');
			$req->execute(array($_POST['nom'],$_POST['id_article']));
		}
		
		if (!empty($_POST['description']) ) {
			
			$req = $db->prepare('UPDATE articles SET description = ? WHERE id = ?');
			$req->execute(array($_POST['description'],$_POST['id_article']));
		}

		if (!empty($_POST['prix'])) {
			
			$req = $db->prepare('UPDATE articles SET prix = ? WHERE id = ?');
			$req->execute(array($_POST['prix'],$_POST['id_article']));
		}

		if (!empty($_POST['solde'])) {
			
			$req = $db->prepare('UPDATE articles SET solde = ? WHERE id = ?');
			$req->execute(array($_POST['solde'],$_POST['id_article']));
		}
	}

	elseif (!empty($_POST['id_melange'])) {
		
					
		if (!empty($_POST['couleur']) ) {
			
			$req = $db->prepare('UPDATE melange SET couleur = ? WHERE id = ?');
			$req->execute(array($_POST['couleur'],$_POST['id_melange']));
		}

		if (!empty($_POST['taille']) ) {
			
			$req = $db->prepare('UPDATE melange SET taille = ? WHERE id = ?');
			$req->execute(array($_POST['taille'],$_POST['id_melange']));
		}

		if (!empty($_POST['quantite'])) {
			
			$result=$db->prepare('SELECT * FROM melange WHERE id = ?');
			$result->execute(array($_POST['id_melange']));
	
			$id;
			$quantite = 0;

			while ($donne = $result->fetch()) {
				
				$id = $donne['id_article'];
				$quantite = $donne['quantite'];
			}

			$req = $db->prepare('UPDATE articles SET quantite = (quantite - ?) + ? WHERE id = ?');
			$req->execute(array($quantite,$_POST['quantite'],$id));

			$req = $db->prepare('UPDATE melange SET quantite = ? WHERE id = ?');
			$req->execute(array($_POST['quantite'],$_POST['id_melange']));

		}

	}
}