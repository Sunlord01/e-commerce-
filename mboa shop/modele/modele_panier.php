 <?php

function ajout_au_panier(){

	$db = dbconnect();

	if ( !empty($_POST['id_article'])  AND !empty($_POST['couleur'])  AND  !empty($_POST['taille'])  AND  !empty($_POST['quantite'])  ) {
		
		$req = $db->prepare('SELECT * FROM melange WHERE id_article = ? AND couleur = ? AND taille = ?');
		$req->execute( array( $_POST['id_article'],$_POST['couleur'],$_POST['taille'] ) );

		while( $donne = $req->fetch() ) {

		 if ( get_solde($donne['id_article']) > 0) {
					
				$solde = get_solde($donne['id_article']) * 100 ;
				
			$_SESSION['panier'][''.$donne['id'].''] = $donne['id'];
			$_SESSION['couleur'][''.$donne['id'].''] = $donne['couleur'];
			$_SESSION['taille'][''.$donne['id'].''] = $donne['taille'];
			$_SESSION['quantite'][''.$donne['id'].''] = $_POST['quantite'];
			$_SESSION['prix'][''.$donne['id'].''] = $_POST['prix'] - ( $_POST['prix'] * get_solde($donne['id_article']) );
			$_SESSION['prix_total'][''.$donne['id'].''] = $_SESSION['quantite'][ $donne['id'] ] * $_SESSION['prix'][''.$donne['id'].''];

		}else{

			$_SESSION['panier'][''.$donne['id'].''] = $donne['id'];
			$_SESSION['couleur'][''.$donne['id'].''] = $donne['couleur'];
			$_SESSION['taille'][''.$donne['id'].''] = $donne['taille'];
			$_SESSION['quantite'][''.$donne['id'].''] = $_POST['quantite'];
			$_SESSION['prix'][''.$donne['id'].''] = $_POST['prix'];
			$_SESSION['prix_total'][''.$donne['id'].''] = $_POST['prix'] * $_SESSION['quantite'][ $donne['id'] ];
		}
		
		}$req->closeCursor();
	}

}

function del_article_panier(){

	if (!empty($_GET['del'])) {
		
		unset($_SESSION['panier'][$_GET['del']]);
	}
}

function set_quantite(){

	if (!empty($_POST['quantite']) AND !empty($_POST['id'])) {
		
		$_SESSION['quantite'][$_POST['id']] = $_POST['quantite'];

		$_SESSION['prix_total'][''.$_POST['id'].''] = $_SESSION['prix'][''.$_POST['id'].''] * $_SESSION['quantite'][ $_POST['id'] ];
	}
}

function get_articles_panier(){ // fonctione avec les fonctions get_nom/img()

	if (!empty($_SESSION['panier'])) {
			
		$db = dbconnect();

		$panier = implode(',', $_SESSION['panier'] );

		$req = $db->query('SELECT * FROM melange WHERE id IN ('.$panier.')');

		return $req;

	}

}

function get_info($info,$var){ //prend en parametre id_article

	$db = dbconnect();

		$req = $db->prepare('SELECT * FROM articles WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$nom = $donne[$info];
		$req->closeCursor();

		return $nom;	
}

function get_info_user($info,$var){ //prend en parametre id_article

	$db = dbconnect();

		$req = $db->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$nom = $donne[$info];
		$req->closeCursor();

		return $nom;	
}

function get_img($var){

	$db = dbconnect();

		$req = $db->prepare('SELECT image FROM articles WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$image = $donne['image'];
		$req->closeCursor();

		return $image;	
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



function enregistrement(){

	$db = dbconnect();

	if ( !empty($_POST['tel']) AND !empty($_POST['region']) AND !empty($_POST['ville']) AND !empty($_POST['quartier']) AND !empty($_POST['livraison'])
	AND empty($_POST['nom']) ) {
		
		$tel = htmlspecialchars($_POST['tel']);
		$region = htmlspecialchars($_POST['region']);
		$ville = htmlspecialchars($_POST['ville']);
		$quartier = htmlspecialchars($_POST['quartier']);

		$id_melange = implode(',', $_SESSION['panier']);
		$prix = implode(',', $_SESSION['prix_total']);
		$quantite = implode(',', $_SESSION['quantite']);

		if (!empty($_POST['livraison'])) {
			$livraison = "oui";
		}else{
			$livraison = "non";
		}

		$req = $db->prepare('INSERT INTO commande(id_utilisateur,tel,region,ville,quartier,id_melange,quantite,prix_total,livraison) VALUES(:id_utilisateur,:tel,:region,:ville,:quartier,:id_melange,:quantite,:prix_total,:livraison)');
		$req->execute(array(
				'id_utilisateur' => $_SESSION['id'],
				'tel' => $tel,
				'region' => $region,
				'ville' => $ville,
				'quartier' => $quartier,
				'id_melange' => $id_melange,
				'quantite' => $quantite,
				'prix_total' => $prix,
				'livraison' => $livraison
		));

		//ajustement du nombre d'article

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE  articles JOIN melange ON articles.id = melange.id_article SET articles.quantite=articles.quantite-? WHERE melange.id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE melange SET quantite=quantite-? WHERE id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE  articles JOIN melange ON articles.id = melange.id_article SET articles.vendu=articles.vendu+? WHERE melange.id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE melange SET vendu=vendu+? WHERE id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		//suppression des variables de session comptenant les details du panier.

		$_SESSION['id_melange'] = $id_melange;

	header('location:index.php?un=mail');


	}elseif ( !empty($_POST['tel']) AND !empty($_POST['region']) AND !empty($_POST['ville']) AND !empty($_POST['quartier']) AND !empty($_POST['livraison'])
	AND !empty($_POST['nom']) ) {

		$nom = htmlspecialchars($_POST['nom']);
		$mail = htmlspecialchars($_POST['mail']);
		$tel = htmlspecialchars($_POST['tel']);
		$region = htmlspecialchars($_POST['region']);
		$ville = htmlspecialchars($_POST['ville']);
		$quartier = htmlspecialchars($_POST['quartier']);

		$id_melange = implode(',', $_SESSION['panier']);
		$prix = implode(',', $_SESSION['prix_total']);
		$quantite = implode(',', $_SESSION['quantite']);

		if (!empty($_POST['livraison'])) {
			$livraison = "oui";
		}else{
			$livraison = "non";
		}

		$rep = $db->prepare('INSERT INTO commande(nom,mail,tel,region,ville,quartier,id_melange,quantite,prix_total,livraison) VALUES(:nom,:mail,:tel,:region,:ville,:quartier,:id_melange,:quantite,:prix_total,:livraison)');
		$rep->execute(array(
				'nom' => $nom,
				'mail' => $mail,
				'tel' => $tel,
				'region' => $region,
				'ville' => $ville,
				'quartier' => $quartier,
				'id_melange' => $id_melange,
				'quantite' => $quantite,
				'prix_total' => $prix,
				'livraison' => $livraison
		));

		//ajustement du nombre d'article

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE  articles JOIN melange ON articles.id = melange.id_article SET articles.quantite=articles.quantite-? WHERE melange.id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE melange SET quantite=quantite-? WHERE id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE  articles JOIN melange ON articles.id = melange.id_article SET articles.vendu=articles.vendu+? WHERE melange.id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		foreach ($_SESSION['panier'] as $value) {
			$reponse = $db->prepare('UPDATE melange SET vendu=vendu+? WHERE id=?');
			$reponse->execute(array($_SESSION['quantite'][$value],$value));
		}

		$_SESSION['id_melange'] = $id_melange;
		$_SESSION['nom'] = $nom;
		$_SESSION['mail'] = $mail;

	header('location:index.php?un=mail');

	}



}

?>