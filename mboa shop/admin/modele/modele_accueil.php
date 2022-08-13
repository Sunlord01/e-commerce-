<?php

function auto_delaisse(){

	$db = dbconnect();
		
	$req = $db->prepare('UPDATE commande SET statut = :statut WHERE statut = "en cour" AND (DATEDIFF(NOW(), date_livraison)*1440) >= 1 ');
	$req->execute(array('statut' => 'non-valider'));

}


//////////////////////////      livreur       ////////////////////////////////////////

function get_somme_journaliere(){

	$db = dbconnect(); 

	$req=$db->prepare('SELECT prix_total,livraison FROM commande WHERE statut="livrer" AND livreur=? AND DATEDIFF(NOW() , date_livraison) = 0');
	$req->execute(array($_SESSION['id']));

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

function pagination_non_livrer() 
{
		global $articleParPage_nv, $pageTotales_nv, $depart_nv, $pageCourante_nv;

		$db = dbconnect();

	$articleParPage_nv = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ORDER BY date_commande ASC ');

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

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ORDER BY region ASC AND date_commande ASC LIMIT '.$depart_nv.','.$articleParPage_nv);
	
	return $req;

}

function get_commande_retard()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" AND DATEDIFF(NOW() , date_commande) >= 3  ');
	
	return $req;

}

function get_commandetotal_non_livrer()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="oui" ');
	
	return $req;

}

function get_commande_prise()
{
	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE statut="en cour" AND livreur=?');
	$req->execute(array($_SESSION['id']));
	
	return $req;

}

function get_commande_livrer()
{
	$db = dbconnect();

	$req=$db->prepare('SELECT id FROM commande WHERE livreur=? ');
	$req->execute(array($_SESSION['id']));
	
	return $req->rowCount();

}

function get_info($var,$info){

	$db = dbconnect();

	$req=$db->prepare('SELECT U.* FROM utilisateurs U JOIN commande C ON U.id = c.id_utilisateur WHERE c.id = ?');
	$req->execute(array($var));

		$info_r ="";
	while ($donne = $req->fetch()) {

	$info_r = $donne[$info];

		}
	$req->closeCursor();

	return $info_r;

}

function get_nom_article($var)
{
	$nom = "non present";

	$db = dbconnect();

	$rep = $db->prepare('SELECT A.nom FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
	$rep->execute(array($var));
			
	while ($donne = $rep->fetch()) {
			if($donne){
	$nom = $donne['nom'];
				}
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

		$couleur = "DEL";
	while ($donne = $req->fetch()) {
			if($donne){
	$couleur = $donne['couleur'];
				}
		}
	$req->closeCursor();

	return $couleur;
}

function get_taille($var){

	$db = dbconnect();

	$req = $db->prepare('SELECT taille FROM melange WHERE id = ? ');
	$req->execute(array($var));

		$taille = "DEL";
	while ($donne = $req->fetch()) {
			if($donne){
	$taille = $donne['taille'];
				}
		}
	$req->closeCursor();

	return $taille;
}

function prendre(){

	if (!empty($_GET['prise'])) {

		$db = dbconnect();
		
		$req = $db->prepare('UPDATE utilisateurs_admin SET action = :action WHERE id = :id');
		$req->execute(array('action' => 'en cour:'.$_GET['prise'], 'id' => $_SESSION['id']));

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "en cour", 'id' => $_GET['prise']));

		$req = $db->prepare('UPDATE commande SET livreur = :livreur WHERE id = :id');
		$req->execute(array('livreur' => $_SESSION['id'], 'id' => $_GET['prise']));

		$req = $db->prepare(' UPDATE commande SET date_livraison = current_timestamp() WHERE id = :id ');
		$req->execute(array( 'id' => $_GET['prise'] ));

		$_SESSION['action'] = "en cour";


	}

}

function delaisser(){

	if (!empty($_GET['delaisser'])) {

		$db = dbconnect();
		
		$req = $db->prepare('UPDATE utilisateurs_admin SET action = :action WHERE id = :id');
		$req->execute(array('action' => 'libre', 'id' => $_SESSION['id']));

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "non-valider", 'id' => $_GET['delaisser']));

		$req = $db->prepare('UPDATE commande SET livreur = :livreur WHERE id = :id');
		$req->execute(array('livreur' => "aucun", 'id' => $_GET['delaisser']));

		$req = $db->prepare(' UPDATE commande SET date_livraison = 0 WHERE id = :id ');
		$req->execute(array( 'id' => $_GET['delaisser'] ));

		$_SESSION['action'] = "libre";

	}

}

function valider(){

	if (!empty($_GET['valider'])) {

		$db = dbconnect();
		
		$req = $db->prepare('UPDATE utilisateurs_admin SET action = :action WHERE id = :id');
		$req->execute(array('action' => 'libre', 'id' => $_SESSION['id']));

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "livrer", 'id' => $_GET['valider']));

		$req = $db->prepare('UPDATE commande SET livreur = :livreur WHERE id = :id');
		$req->execute(array('livreur' => $_SESSION['id'], 'id' => $_GET['valider']));

		$req = $db->prepare(' UPDATE commande SET date_livraison = current_timestamp() WHERE id = :id ');
		$req->execute(array( 'id' => $_GET['valider'] ));

		$_SESSION['action'] = "libre";

	}

}



/////////////////////////////////////           FIN des function propre au livreur         /////////////////////////////////



/////////////////////////////////////          SECRETAIRE          ///////////////////////////////////////


function paginationrecep_non_valider() 
{
		global $articleParPage_tnv, $pageTotales_tnv, $depart_tnv, $pageCourante_tnv;

		$db = dbconnect();

	$articleParPage_tnv = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="non" ORDER BY id ASC ');

	$articleTotals_tnv = $articleTotalReq->rowCount();
	$pageTotales_tnv = ceil($articleTotals_tnv / $articleParPage_tnv);

	if (!empty($_GET['page_tnv']) AND $_GET['page_tnv'] > 0) {
		
		$_SESSION['page_tnv'] = intval($_GET['page_tnv']);

		$pageCourante_tnv = $_SESSION['page_tnv'];
	}else{

		$pageCourante_tnv = 1;
	}

	$depart_tnv = ($pageCourante_tnv - 1) * $articleParPage_tnv;
}

function get_commande_recep_non_valider( $depart_tnv,$articleParPage_tnv )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="non" ORDER BY id ASC LIMIT '.$depart_tnv.','.$articleParPage_tnv);
	
	return $req;

}

function get_commandetotal_recep_non_valider()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="non-valider" AND livraison="non" ORDER BY id ASC ');
	
	return $req;

}


function paginationrecep_valider() 
{
		global $articleParPage_tv, $pageTotales_tv, $depart_tv, $pageCourante_tv;

		$db = dbconnect();

	$articleParPage_tv = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" ORDER BY id ASC ');

	$articleTotals_tv = $articleTotalReq->rowCount();
	$pageTotales_tv = ceil($articleTotals_tv / $articleParPage_tv);

	if (!empty($_GET['page_tv']) AND $_GET['page_tv'] > 0) {
		
		$_SESSION['page_tv'] = intval($_GET['page_tv']);

		$pageCourante_tv = $_SESSION['page_tv'];
	}else{

		$pageCourante_tv = 1;
	}

	$depart_tv = ($pageCourante_tv - 1) * $articleParPage_tv;
}

function get_commande_recep_valider( $depart_tv,$articleParPage_tv )
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" ORDER BY id ASC LIMIT '.$depart_tv.','.$articleParPage_tv);
	
	return $req;

}

function get_commandetotal_recep_valider()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" ORDER BY id ASC ');
	
	return $req;

}

function validation_definitive(){

	if (!empty($_GET['definitif'])) {

		$db = dbconnect();

		$req = $db->prepare('UPDATE commande SET statut = :statut WHERE id = :id');
		$req->execute(array('statut' => "valider", 'id' => $_GET['definitif']));

		$req = $db->prepare(' UPDATE commande SET date_livraison = current_timestamp() WHERE id = :id ');
		$req->execute(array( 'id' => $_GET['definitif'] ));

	}

}

function get_vente()
{
	$db = dbconnect();

	$req=$db->query('SELECT prix_total,livraison FROM commande WHERE livraison="non" AND statut = "valider" AND DATEDIFF(NOW() , date_livraison) = 0');

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

function pagination_valider() 
{
		global $articleParPage_v, $pageTotales_v, $depart_v, $pageCourante_v;

		$db = dbconnect();

	$articleParPage_v = 2;
	
	$articleTotalReq = $db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" ORDER BY id ASC');

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

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" 
					ORDER BY id ASC LIMIT '.$depart_v.','.$articleParPage_v);
	
	return $req;

}

function get_commandetotal_valider()
{
	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut="valider" AND livraison="non" ');
	
	return $req;

}



//////////////////////////////////////     Fin des fonction propre a la secretaire      ///////////////////////////////


/////////////////////////////          GERANT            ///////////////////////////////

function get_articles_livres($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE livraison="oui" AND statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_restant($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM articles WHERE statut="actif" AND boutique=?');
	$req->execute(array($_SESSION['id']));
	
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_inac_restant($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM articles WHERE statut="non-actif" AND boutique=?');
	$req->execute(array($_SESSION['id']));
	
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_present($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM articles WHERE boutique=?');
	$req->execute(array($_SESSION['id']));
	
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_totaux($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM articles WHERE boutique=?');
	$req->execute(array($_SESSION['id']));
	
	
	$sum_t[1]=array();
	$sum_t[2]=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") {

		$sum_t[1][$count] = $donne['quantite']*$donne['prix'];
		$sum_t[2][$count] = $donne['vendu']*$donne['prix'];

		}
		else{
		$sum_t[1][$count] = $donne[$var];
		$sum_t[2][$count] = $donne['vendu'];
		}

		$count++; 

	}$req->closeCursor();

	$sum_t[1] = array_sum($sum_t[1]);
	$sum_t[2] = array_sum($sum_t[2]);

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_livres_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE livraison="oui" 
					AND statut IN ("valider","livrer") AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_vendu_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE statut = "valider" AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_receptionner_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE livraison="non" 
					AND statut IN ("valider","livrer") AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_receptionner($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE livraison="non" 
					AND statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_vendu($var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM articles WHERE boutique=?');
	$req->execute(array($_SESSION['id']));
	
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['vendu']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++;  

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_total_vendu($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$rep=$db->prepare('SELECT boutique FROM articles WHERE id = ?');
			$rep->execute(array($element));

			while ($donner = $rep->fetch()){
				$boutique = $donner['boutique'];
			}$rep->closeCursor();
			
			if ($boutique == $_SESSION['id']) {
				
				$sum_t[] = intval($quantites[$count][$counte]); 

			}

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

	}

	function get_info_boutique($var){		
		
		$db = dbconnect();

		$req = $db->prepare('SELECT * FROM boutique WHERE id = ?');
		$req->execute(array($_SESSION['id']));

		$info = "";

		while ($donne = $req->fetch()) {

			$info = $donne[$var];
		
		}$req->closeCursor();

		return $info;
	}

	function get_info_gerant($var){		
		
		$db = dbconnect();

		$req = $db->prepare('SELECT * FROM utilisateurs_admin WHERE id = ?');
		$req->execute(array($_SESSION['id']));

		$info = "";

		while ($donne = $req->fetch()) {

			$info = $donne[$var];
		
		}$req->closeCursor();

		return $info;
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

function update(){

	$db = dbconnect();

	if (!empty($_POST['statut_up']) ) {
			
		$req = $db->prepare('UPDATE boutique SET statut = ? WHERE id = ?');
		$req->execute(array($_POST['statut_up'],$_SESSION['id']));

		$req = $db->prepare('UPDATE articles SET statut = ? WHERE boutique = ?');
		$req->execute(array($_POST['statut_up'],$_SESSION['id']));		
	}

	if (!empty($_POST['boutique_up'])) {
		
		
		if (!empty($_POST['nom']) ) { var_dump($_POST);
			
			$req = $db->prepare('UPDATE boutique SET nom = ? WHERE id = ?');
			$req->execute(array($_POST['nom'],$_SESSION['id']));
		}
		
		if (!empty($_POST['description']) ) {
			
			$req = $db->prepare('UPDATE boutique SET description = ? WHERE id = ?');
			$req->execute(array($_POST['description'],$_SESSION['id']));
		}

		if (!empty($_POST['proprietaire'])) {
			
			$req = $db->prepare('UPDATE boutique SET proprietaire = ? WHERE id = ?');
			$req->execute(array($_POST['proprietaire'],$_SESSION['id']));
		}

		if (!empty($_FILES['image'])) { 

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
			
			$req = $db->prepare('UPDATE boutique SET image = ? WHERE id = ?');
			$req->execute(array('image/'.$name,$_SESSION['id']));
			
		}else{ echo '<div class="error"> ERREUR D\'ENREGISTREMENT DE L\'image </div>';}

		}
	}
}