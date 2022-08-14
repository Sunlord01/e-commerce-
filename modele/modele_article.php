<?php 

function nom_article(){

	$db = dbconnect();

	$result=$db->prepare('SELECT nom FROM articles WHERE id = ?');
	$result->execute(array($_SESSION['id_article']));

	$nom="";

	while ($donne = $result->fetch()) {
		
		$nom = $donne['nom'];
		
	}$result->closeCursor();

	return $nom;
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

function get_article()
{
	
	$db = dbconnect();
		
	$result=$db->prepare('SELECT * FROM articles WHERE id = ? AND quantite >= 5');
	$result->execute( array($_SESSION['id_article']) );

	return $result;

}

function get_couleurs_article($var){

	$db = dbconnect();

	$result=$db->prepare('SELECT couleur FROM melange WHERE id_article = ? AND quantite >= 5');
	$result->execute( array($var) );

	$couleurs = array();
	$count = 0;

	while ($donne = $result->fetch() ) {
		
		$couleurs[''.$count.''] = $donne['couleur'];
		$count++;

	}$result->closeCursor();

	$couleurs=array_filter($couleurs);
	$couleurs=array_unique($couleurs);
	

	return $couleurs;

}

function get_tailles_couleur_article($var,$vare){

	$db = dbconnect();

	$result=$db->prepare('SELECT taille FROM melange WHERE id_article = ? AND couleur = ? AND quantite >= 5 ');
	$result->execute( array($var,$vare) );

	$tailles = array();
	$count = 0;

	while ($donne = $result->fetch() ) {
		
		$tailles[''.$count.''] = $donne['taille'];
		$count++;

	}$result->closeCursor();

	$tailles=array_filter($tailles);
	$tailles=array_unique($tailles);
	

	return $tailles;

}

function get_img_articles($var){

	$db = dbconnect();

	$result=$db->prepare('SELECT image FROM melange WHERE id_article = ? AND quantite >= 5 ');
	$result->execute( array($var) );

	return $result;
}
 
?>
