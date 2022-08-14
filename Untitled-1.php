<?php 

function get_articles_choix_genre($depart,$articleParPage)
{

	$db = dbconnect();

	// choix suivant un seul critere

	if ( !empty($_SESSION['c_couleur']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? AND statut = "actif" 
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur']));

		return $result;

	}

	elseif ( !empty($_SESSION['c_taille']) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) )  ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_taille']));

		return $result;		

	}

	elseif ( !empty($_SESSION['c_prix']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND A.prix <= ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( !empty($_SESSION['c_type']) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_couleur']) && empty($_SESSION['c_prix']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_type']));

		return $result;		

	}



	// choix suivant deux criteres

	elseif ( (!empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) ) && ( empty($_SESSION['c_couleur']) && empty($_SESSION['c_type']) ) ) {
		
		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.prix <= ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_taille']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.prix <= ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? 
							AND A.prix <= ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_type'], $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_type']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND M.couleur = ? AND statut = "actif"  
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_taille'] , $_SESSION['c_couleur']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_couleur']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.taille = ? 
							AND A.type = ? AND statut = "actif" 
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_taille'] , $_SESSION['c_type']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_couleur']) && !empty($_SESSION['c_type']) ) && ( empty($_SESSION['c_prix']) && empty($_SESSION['c_taille']) ) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.type = ? AND statut = "actif" 
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur'] , $_SESSION['c_type']));

		return $result;		

	}

	

	// choix suivant trois criteres


	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_taille']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND A.type = ? AND A.prix <= ? AND statut = "actif"
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur'] , $_SESSION['c_type'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_type']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND M.taille = ? AND A.prix <= ? AND statut = "actif" 
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_type']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_couleur']) ) && empty($_SESSION['c_prix']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND M.couleur = ? 
							AND M.taille = ? AND A.type = ? AND statut = "actif"
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_couleur'] , $_SESSION['c_taille'] , $_SESSION['c_type']));

		return $result;		

	}

	elseif ( ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) ) && empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? 
							AND M.taille = ? AND A.prix <= ? AND statut = "actif" 
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_prix']));

		return $result;		

	}


	// choix suivant les 4 criteres


	elseif ( !empty($_SESSION['c_prix']) && !empty($_SESSION['c_taille']) && !empty($_SESSION['c_type']) && !empty($_SESSION['c_couleur']) ) {

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M 
							ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND M.quantite >= 5 AND A.quantite >= 5 AND A.type = ? AND statut = "actif" 
							AND M.taille = ? AND M.couleur = ? AND A.prix <= ?
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique'] , $_SESSION['c_type'] , $_SESSION['c_taille'] , $_SESSION['c_couleur'] , $_SESSION['c_prix']));

		return $result;		

	}else{

		$result=$db->prepare('SELECT DISTINCT A.* FROM articles A JOIN melange M ON A.id = M.id_article 
							WHERE A.genre = ? AND A.boutique = ? AND A.quantite >= 5  AND statut = "actif"
							ORDER BY date_entree ASC LIMIT '.$depart.','.$articleParPage);
		$result->execute(array($_SESSION['genre'],$_SESSION['id_boutique']));

		return $result;

	}

}
?>