<?php

function datedif($var){ 
	$date1 = time();
	$date2 = strtotime($var);

    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();
 
    $tmp = $diff-3600;
    $retour['seconde'] = ($tmp % 60);
 
    $tmp = floor( ($tmp - $retour['seconde']) /60 );
    $retour['minute'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['minute'])/60 );
    $retour['heur'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['heur'])  /24 );
    $retour['jour'] = $tmp;
 
    return $retour;
}

function auto_delaisse(){

	$db = dbconnect();
		
	$req = $db->prepare('UPDATE commande SET statut = :statut WHERE statut = "en cour" AND (DATEDIFF(NOW(), date_livraison)*1440) >= 1 ');
	$req->execute(array('statut' => 'non-valider'));

}

function get_info($var,$info){

	$db = dbconnect();

	$req=$db->prepare('SELECT U.* FROM utilisateurs U JOIN commande C ON U.id = c.id_utilisateur WHERE c.id = ?');
	$req->execute(array($var));

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

	$rep = $db->prepare('SELECT A.prix FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
	$rep->execute(array($var));
	
		$prix = 0;		

	while ($donne = $rep->fetch()) {

	$prix = $donne['prix'];

		}
	$rep->closeCursor();

	return $prix;
}

function get_couleur($var){

	$db = dbconnect();

	$req = $db->prepare('SELECT couleur FROM melange WHERE id = ? ');
	$req->execute(array($var));

	$couleur = "";

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
	$taille = "";
	
	while ($donne = $req->fetch()) {

	$taille = $donne['taille'];

		}
	$req->closeCursor();

	return $taille;
}

function pagination_non_livrer() 
{
		global $articleParPage_nv, $pageTotales_nv, $depart_nv, $pageCourante_nv;

		$db = dbconnect();

	$articleParPage_nv = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ');

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

function get_commande_non_livrer( $depart_nv,$articleParPage_nv )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ORDER BY date_commande ASC LIMIT '.$depart_nv.','.$articleParPage_nv);
	
	return $req;

}

function get_commandetotal_non_livrer()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ');
	
	return $req;

}

function pagination_livrees() 
{
		global $articleParPage_l, $pageTotales_l, $depart_l, $pageCourante_l;

		$db = dbconnect();

	$articleParPage_l = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="livrer" AND livraison="oui" ');

	$articleTotals_l = $articleTotalReq->rowCount();
	$pageTotales_l = ceil($articleTotals_l / $articleParPage_l);

	if (!empty($_GET['page_l']) AND $_GET['page_l'] > 0) {
		
		$_SESSION['page_l'] = intval($_GET['page_l']);

		$pageCourante_l = $_SESSION['page_l'];
	}else{

		$pageCourante_l = 1;
	}

	$depart_l = ($pageCourante_l - 1) * $articleParPage_l;
}

function get_commande_livrees( $depart_l,$articleParPage_l )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="livrer" AND livraison="oui"
					ORDER BY date_livraison ASC LIMIT '.$depart_l.','.$articleParPage_l);
	
	return $req;

}

function get_commandetotal_livrees()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="livrer" AND livraison="oui" ');
	
	return $req;

}

function pagination_valider() 
{
		global $articleParPage_v, $pageTotales_v, $depart_v, $pageCourante_v;

		$db = dbconnect();

	$articleParPage_v = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="oui" ');

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

function get_commande_valider( $depart_v,$articleParPage_v )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="oui" 
					ORDER BY date_livraison ASC LIMIT '.$depart_v.','.$articleParPage_v);
	
	return $req;

}

function get_commandetotal_valider()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="oui" ');
	
	return $req;

}

function pagination_encour() 
{
		global $articleParPage_en, $pageTotales_en, $depart_en, $pageCourante_en;

		$db = dbconnect();

	$articleParPage_en = 2;
	
	$articleTotalReq = $db->prepare('SELECT * FROM commande WHERE statut="en cour" AND livraison="oui" ');
	
	$articleTotals_en = $articleTotalReq->rowCount();
	$pageTotales_en = ceil($articleTotals_en / $articleParPage_en);

	if (!empty($_GET['page_en']) AND $_GET['page_en'] > 0) {

		$_SESSION['page_en'] = intval($_GET['page_en']);

		$pageCourante_en = $_SESSION['page_en'];
	}else{

		$pageCourante_en = 1;
	}

	$depart_en = ($pageCourante_en - 1) * $articleParPage_en;
}

function get_commande_encour( $depart_en,$articleParPage_en )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="en cour" AND livraison="oui" 
					ORDER BY date_livraison DESC LIMIT '.$depart_en.','.$articleParPage_en );
	
	return $req;

}

function get_commandetotal_encour()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="en cour" AND livraison="oui" ');
	
	return $req;

}

function validation_definitive(){

	if (!empty($_GET['definitif'])) {

		$db = dbconnect();

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "valider", 'id' => $_GET['definitif']));

	}

}

function annulation(){

	if (!empty($_GET['annulation'])) {

		$db = dbconnect();

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "non-valider", 'id' => $_GET['annulation']));

	}

}

function get_vente_journaliere()
{
	$db = dbconnect();

	$req=$db->query('SELECT prix_total,livraison FROM commande WHERE livraison="oui" AND statut="valider" AND DATEDIFF(NOW() , date_livraison) = 0 ');

	$tab = array();
	$somme = array();
	$som = 0;
	$count = 0;

	while ($donne = $req->fetch()) {
		
		$tab[$count] = $donne['prix_total'];
		$tab[$count] = explode(',', $tab[$count]);
		if($donne['livraison'] == "oui") $somme[$count] = array_sum($tab[$count])+2000;
		else $somme[$count] = array_sum($tab[$count]);
		$count++;
	}

	$som = array_sum($somme);

	return $som;

}

function get_livraison_journaliere()
{
	$db = dbconnect();

	$req=$db->query('SELECT prix_total,livraison FROM commande WHERE livraison="oui" AND statut IN ("en cour","livrer") AND DATEDIFF(NOW() , date_livraison) = 0 ');

	$tab = array();
	$somme = array();
	$som = 0;
	$count = 0;

	while ($donne = $req->fetch()) {
		
		$tab[$count] = $donne['prix_total'];
		$tab[$count] = explode(',', $tab[$count]);
		if($donne['livraison'] == "oui") $somme[$count] = array_sum($tab[$count])+2000;
		else $somme[$count] = array_sum($tab[$count]);
		$count++;
	}

	$som = array_sum($somme);

	return $som;

}

function get_vente()
{
	$db = dbconnect();

	$req=$db->query('SELECT prix_total,livraison FROM commande WHERE livraison="oui" AND statut IN ("valider","livrer","en cour") AND DATEDIFF(NOW() , date_livraison) = 0');

	$tab = array();
	$somme = array();
	$som = 0;
	$count = 0;

	while ($donne = $req->fetch()) {
		
		$tab[$count] = $donne['prix_total'];
		$tab[$count] = explode(',', $tab[$count]);
		if($donne['livraison'] == "oui") $somme[$count] = array_sum($tab[$count])+2000;
		else $somme[$count] = array_sum($tab[$count]);
		$count++;
	}

	$som = array_sum($somme);

	return $som;

}

function delaisser(){

	if (!empty($_GET['delaisser'])) {

		$db = dbconnect();

		$rep = $db->prepare('SELECT livreur FROM commande WHERE id = :id');
		$rep->execute(array($_GET['delaisser']));

		$count = 0;

		while ($donne = $rep->fetch()) {
			
			$count = $donne['livreur'];
		}$rep->closeCursor();
		
		$req = $db->prepare('UPDATE utilisateurs_admin SET action = :action WHERE id = :id');
		$req->execute(array('action' => 'libre' , 'id' => $count));

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "non-valider", 'id' => $_GET['delaisser']));

		$req = $db->prepare('UPDATE commande SET livreur = :livreur WHERE id = :id');
		$req->execute(array('livreur' => "aucun", 'id' => $_GET['delaisser']));

		$req = $db->prepare(' UPDATE commande SET date_livraison = 0 WHERE id = :id ');
		$req->execute(array( 'id' => $_GET['delaisser'] ));

	}

}

//////////////////////////////////////////////////////////////////

function get_livreur(){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM utilisateurs_admin WHERE statut="livreur" ');

	return $req;
}

function get_livreur_actif(){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM utilisateurs_admin WHERE statut="livreur" AND action NOT IN ("libre","","actif")');

	return $req->rowCount();
}

function get_info_livreur($var,$info){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM utilisateurs_admin WHERE id = ?');
	$req->execute(array($var));

	while ($donne = $req->fetch()) {

	$info_r = $donne[$info];

		}
	$req->closeCursor();

	return $info_r;

}

function get_somme_journaliere($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT prix_total,livraison FROM commande WHERE statut="livrer" AND livreur=? AND DATEDIFF(NOW() , date_livraison) = 0');
	$req->execute(array($var));

	$tab = array();
	$somme = array();
	$som = 0;
	$count = 0;

	while ($donne = $req->fetch()) {
		
		$tab[$count] = $donne['prix_total'];
		$tab[$count] = explode(',', $tab[$count]);
		if($donne['livraison'] == "oui") $somme[$count] = array_sum($tab[$count])+2000;
		else $somme[$count] = array_sum($tab[$count]);
		$count++;
	}

	$som = array_sum($somme);

	return $som;

}

function get_commande_livrer($var)
{
	$db = dbconnect();

	$req=$db->prepare('SELECT id FROM commande WHERE livreur=? AND statut="livrer" AND DATEDIFF(NOW() , date_livraison) = 0 ');
	$req->execute(array($var));
	
	return $req->rowCount();

}

function get_commande_livreur_valider($var)
{
	$db = dbconnect();

	$req=$db->prepare('SELECT id FROM commande WHERE livreur=? AND statut="valider" AND DATEDIFF(NOW() , date_livraison) = 0 ');
	$req->execute(array($var));
	
	return $req->rowCount();

}

function update_info(){

		if (!empty($_POST['info_up'])) {
		
		$db = dbconnect();
		
			if (!empty($_POST['nom']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs_admin SET nom = ? WHERE id = ?');
				$req->execute(array($_POST['nom'],$_SESSION['id']));
			}

			if (!empty($_POST['mail']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs_admin SET mail = ? WHERE id = ?');
				$req->execute(array($_POST['mail'],$_SESSION['id']));
			}

			if (!empty($_POST['pass']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs_admin SET mot = ? WHERE id = ?');
				$req->execute(array($_POST['pass'],$_SESSION['id']));

				$req = $db->prepare('UPDATE utilisateurs_admin SET pass = ? WHERE id = ?');
				$req->execute(array(sha1($_POST['pass']),$_SESSION['id']));
			}

			if (!empty($_POST['tel1']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs_admin SET tel1 = ? WHERE id = ?');
				$req->execute(array($_POST['tel1'],$_SESSION['id']));
			}
		
			if (!empty($_POST['tel2']) ) {
				
				$req = $db->prepare('UPDATE utilisateurs_admin SET tel2 = ? WHERE id = ?');
				$req->execute(array($_POST['tel2'],$_SESSION['id']));
			}

		}
	}