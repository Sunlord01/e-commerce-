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

function get_solde($var){

	$db = dbconnect();

		$req = $db->prepare('SELECT solde FROM articles WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$solde = $donne['solde'];
		$req->closeCursor();

		return $solde;	
}

function verify_like($id,$id_like){

	$db = dbconnect();

		$t_like=[];

		$rep = $db->prepare('SELECT likes FROM utilisateurs WHERE id = ?');
		$rep->execute( array($id) );

		while ($donnee=$rep->fetch()) {

			$t_like = explode(',', $donnee['likes']);
		}
		$rep->closeCursor();

		if(in_array($id_like, $t_like))
		{
			return 1;
		}else{
			return 0;
		}

}

function add_like()
{
	$db = dbconnect();

	if (!empty($_GET['id_like']) AND !empty($_SESSION['id'])) {

		$t_like=[];
		$like="";

		$rep = $db->prepare('SELECT likes FROM utilisateurs WHERE id = ?');
		$rep->execute(array($_SESSION['id']));
		while ($donnee=$rep->fetch()) {
			$t_like = explode(',', $donnee['likes']);
			$like = $donnee['likes'];
		}
		$rep->closeCursor();

		if(!in_array($_GET['id_like'], $t_like))
		{
		$reponse = $db->prepare('UPDATE  articles SET likes=likes+1 WHERE id=?');
		$reponse->execute(array($_GET['id_like']));

		$reponse = $db->prepare('UPDATE  utilisateurs SET likes=? WHERE id=?');
		$reponse->execute(array(''.$like.','.$_GET['id_like'],$_SESSION['id']));
		}
	
	}
}

function del_like()
{
	$db = dbconnect();

	if (!empty($_GET['id_dislike']) AND !empty($_SESSION['id'])) {

		$t_like=array();
		$like=array();

		$rep = $db->prepare('SELECT likes FROM utilisateurs WHERE id = ?');
		$rep->execute(array($_SESSION['id']));
		while ($donnee=$rep->fetch()) {

			$t_like = explode(',', $donnee['likes']);

		}
		$rep->closeCursor(); 

		if( in_array($_GET['id_dislike'], $t_like) )
		{
			$like[0] = $_GET['id_dislike'] ;

		$t_like = array_diff( $t_like, $like );
		$t_like = implode( ',' , $t_like ); 

		$reponse = $db->prepare('UPDATE  articles SET likes=likes-1 WHERE id=?');
		$reponse->execute(array($_GET['id_dislike']));

		$reponse = $db->prepare('UPDATE  utilisateurs SET likes=? WHERE id=?');
		$reponse->execute(array($t_like,$_SESSION['id']));
		}
	
	}

}   

function pagination() 
{
		global $articleParPage, $pageTotales, $depart, $pageCourante;

		$db = dbconnect();

	$articleParPage = 3;
	
	$articleTotalReq = $db->query('SELECT id FROM articles WHERE statut = "actif" AND lower(nom) like \'%'.$_SESSION['recherche'].'%\' ');

	$articleTotals = $articleTotalReq->rowCount();
	$pageTotales = ceil($articleTotals / $articleParPage);

	if (!empty($_GET['page']) AND $_GET['page'] > 0) {
		
		$_SESSION['page'] = intval($_GET['page']);

		$pageCourante = $_SESSION['page'];
	}else{

		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $articleParPage;
}

function recherche_articles()
{ 

	$db = dbconnect();

	$result=$db->query('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
						WHERE A.quantite >= 5 AND statut = "actif" 
						AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
	
	return $result;
}


/*$result=$db->query("SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article WHERE A.quantite >= 5 AND lower(A.nom) like '%".$_SESSION['recherche']."%' ");

	return $result;*/


function pagination_choix() 
{
		global $articleParPage, $pageTotales, $depart, $pageCourante;

		$db = dbconnect();

	$articleParPage = 3;

	if ( !empty($_SESSION['c_couleur']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND statut = "actif"
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);

	}

	elseif ( !empty($_SESSION['c_taille']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) )  ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? AND statut = "actif"
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_taille']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( !empty($_SESSION['c_prix']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.prix <= ? AND statut = "actif"
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( !empty($_SESSION['c_type']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_prix']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND statut = "actif"
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}



	// choix suivant deux criteres

	elseif ( (!empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) ) && ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);	

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type'], $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND M.couleur = ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_couleur']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);	

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.type = ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_type']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( ( !empty($_SESSION['c_couleur']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.type = ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_type']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	

	// choix suivant trois criteres


	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_taille']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.type = ? AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_type'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_type']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND M.taille = ? AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);	

	}

	elseif ( ( !empty($_SESSION['c_type']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_prix']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND M.taille = ? AND A.type = ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_type']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? 
							AND M.taille = ? AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);	

	}


	// choix suivant les 4 criteres


	elseif ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND M.taille = ? 
							AND M.couleur = ? AND A.prix <= ? AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);		

	}else{

		$result=$db->query('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
							WHERE A.quantite >= 5 AND statut = "actif" 
							AND lower(nom) like \'%'.$_SESSION['recherche'].'%\' ');
		
		$articleTotals = $result->rowCount();
		$pageTotales = ceil($articleTotals / $articleParPage);

	}


	if (!empty($_GET['page']) AND $_GET['page'] > 0) {
		
		$_SESSION['page'] = intval($_GET['page']);

		$pageCourante = $_SESSION['page'];
	}else{

		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $articleParPage;
}




function recherche_articles_choix(){

	$db = dbconnect();

	// choix suivant un seul critere

	if ( !empty($_SESSION['c_couleur']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_couleur']));

		return $result;

	}

	elseif ( !empty($_SESSION['c_taille']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) )  ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_taille']));

		return $result;		

	}

	elseif ( !empty($_SESSION['c_prix']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( !empty($_SESSION['c_type']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_prix']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_type']));

		return $result;		

	}



	// choix suivant deux criteres

	elseif ( (!empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) ) && ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_type'], $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND M.couleur = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_couleur']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.type = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_taille'] , $_SESSION['c_type']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_couleur']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.type = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_type']));

		return $result;		

	}

	

	// choix suivant trois criteres


	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_taille']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND A.type = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_type'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_type']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND M.taille = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_type']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_prix']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND M.taille = ? 
							AND A.type = ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_type']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND M.taille = ? 
							AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;		

	}


	// choix suivant les 4 criteres


	elseif ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND M.taille = ? 
							AND M.couleur = ? AND A.prix <= ? AND statut = "actif" 
							AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\'');
		$result->execute(array( $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		return $result;		

	}else{

		$result=$db->query('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
							WHERE A.quantite >= 5 AND statut = "actif" AND lower(A.nom) like \'%'.$_SESSION['recherche'].'%\' ');

		return $result;

	}

}


?>