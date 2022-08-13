<?php
  
function inscription(){ 

	$db = dbconnect();

	if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mail']) && !empty($_POST['pseudo']) &&
		 !empty($_POST['tel']) && !empty($_POST['pass']) ){

		$pass =sha1($_POST['pass']);

		$req=$db->prepare('SELECT * FROM utilisateurs WHERE lower(mail)=?');
		$req->execute( array( strtolower($_POST['mail']) ) );
		$result = $req->fetch();

		if (!$result) {
			
		
			$reqe=$db->prepare('INSERT INTO utilisateurs (nom,prenom,mail,pseudo,tel,pass,statut,likes) 
								VALUES(?,?,?,?,?,?,?,?)');
			$reqe->execute(array($_POST['nom'],$_POST['prenom'],$_POST['mail'],$_POST['pseudo'],
								$_POST['tel'],$pass,"actif","0"));

			$_SESSION['pseudo'] = $_POST['pseudo'];

			$reqs=$db->prepare('SELECT id FROM utilisateurs WHERE pseudo=? AND pass=?');
			$reqs->execute(array($_POST['pseudo'],$pass));

			$resultat = $reqs->fetch();
			$_SESSION['id'] = $resultat['id'];

			$reqs->closeCursor();

			header('location:index.php?un=compte');

		}else{
			echo '<h1 class="error"> L\'email saisi est deja utilisée, veuillez en utiliser une autre </h1>';
		}
	}
}

function connexion(){

	$db = dbconnect();

	if (!empty($_GET['choisir'])) {
		
		$rep=$db->prepare('SELECT * FROM utilisateurs WHERE pseudo = ? AND statut = ?');
			$rep->execute(array($_SESSION['pseudo'],$_SESSION['statut']));
			$result = $rep->fetch();

		if ($result) {
			
			$_SESSION['pseudo'] = $result['pseudo'];
			$_SESSION['id'] = $result['id'];
			$_SESSION['mail'] = $result['mail'];

			$rep->closeCursor();

			header('location:index.php?un=compte');
			
		}else{ $rep->closeCursor(); }
	}

	elseif ( !empty($_POST['pseudo']) && !empty($_POST['pass']) && empty($_POST['mail']) ) {

		$pass =sha1($_POST['pass']);

		if (!empty($_POST['choix'])) {
			setcookie('pseudo_ms',$_POST['pseudo'],time() + 365*24*3600,null,null,false,true);
			setcookie('pass_ms',$pass,time() + 365*24*3600,null,null,false,true);
		}
		
		$req=$db->prepare('SELECT * FROM utilisateurs_admin WHERE (pseudo OR mail) = ? AND pass = ? AND action != "bloquer"');
		$req->execute(array($_POST['pseudo'],$pass));
		$resultat = $req->fetch();

		if ($resultat) {
			
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['statut'] = $resultat['statut'];
			$_SESSION['mail'] = $resultat['mail'];
			$_SESSION['action'] = $resultat['action'];

			$req->closeCursor();

			header('location:admin/index.php?un=choix');

		}else{ $req->closeCursor(); 

				$rep=$db->prepare('SELECT * FROM utilisateurs WHERE (pseudo OR mail) = ? AND pass = ?');
				$rep->execute(array($_POST['pseudo'],$pass));
				$result = $rep->fetch();

			if ($result) {
				
				$_SESSION['pseudo'] = $result['pseudo'];
				$_SESSION['id'] = $result['id'];
				$_SESSION['mail'] = $result['mail'];

				$rep->closeCursor();

				header('location:index.php?un=compte');
				
			}else{ $rep->closeCursor(); }

		}

		if (!$result AND !$resultat) {
			
			echo '<h2 class="error"> NOM OU MOT DE PASSE INCORRECT </h2>';
		}
	}
}

function connexion_auto(){

	$db = dbconnect();

	if ( !empty($_COOKIE['pseudo_ms']) && !empty($_COOKIE['pass_ms']) && empty($_GET['raison'])) {
		
		$req=$db->prepare('SELECT * FROM utilisateurs WHERE (pseudo OR mail) = ? AND pass=?');
		$req->execute(array($_COOKIE['pseudo_ms'],$_COOKIE['pass_ms']));
		$resultat = $req->fetch();

		if ($resultat) {
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['mail'] = $resultat['mail'];
			
		$req->closeCursor();

			header('location:index.php?un=compte');
		}
	}
}

function oublier()
{

	$db = dbconnect();
	
	if (!empty($_GET['m_t']) AND !empty($_GET['m_m']) ) {
		
		$req=$db->prepare('SELECT * FROM utilisateurs WHERE mail = ? AND tel = ? ');
		$req->execute(array($_GET['m_m'],$_GET['m_t']));
		$resultat = $req->fetch();
		
		if ($resultat) {
			$_SESSION['pseudo'] = $resultat['pseudo'];
			$_SESSION['mail'] = $resultat['mail'];
			$_SESSION['pass'] = $resultat['pass'];
			
			$req->closeCursor();

			unset($_COOKIE['pseudo_ms']);
			unset($_COOKIE['pass_ms']);
			header('location:index.php?un=connexion&i=o');
		}else{
			$req->closeCursor();

			unset($_COOKIE['pseudo_ms']);
			unset($_COOKIE['pass_ms']);
			echo '<h2 class="error"> LES INFORMATIONS RECUES N\'ETAIT PAS COHERANTES </h2>';
			
		}

	}
	elseif (!empty($_POST['mpw'])) {
		
		if (!empty($_POST['pass']) AND ( sha1($_POST['pass']) != $_SESSION['pass'])) {

			$pass = sha1($_POST['pass']);
			
			$req = $db->prepare('UPDATE utilisateurs SET pass = :pass WHERE mail = :mail');
			$req->execute(array('pass' => $pass , 'mail' => $_SESSION['mail']));

			session_destroy();
			header('location:index.php?un=connexion');
		}else{
			echo '<h2 class="error"> LE MOT DE PASSE EST LE MEME, VEUILLEZ LE MODIFIER... </h2>';
		}
	}
	
}

function send_mail()
{
	if (!empty($_POST['mpo'])){

		$destinataire = $_POST['mail'];

		ob_start(); ?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8" http-equiv="refresh">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<link rel="stylesheet" type="text/css" href="css/mail.css">
			<title></title>
		</head>
		<body>
		
		<div class="body"> 

		<h1 class="logo"><a href="index.php?un=accueil">MBOA SHOP Online...</a></h1>

			<article>
			<p>vous avez effectuer une requete afin de pouvoir changer de mot de passe.<br>
				si cette demande n'emane pas de vous,vous ete prier d'ignorez voir meme de suprimmer ce message.<br>
				<mark>Cliquer sur le boutton afin de modifier votre mot de passe.</mark>
				<a href="index.php?un=connexion&i=o&m_m=<?php echo $destinataire;?>&m_t=<?php echo $_POST['tel'];?>">Modifier</a>
			</p>
			</article>
		</body>
		</html>

		<?php $message = ob_get_clean();

		$sujet = "Recuperation Compte MBOA SHOP"; // sujet du mail
		$header = "From: mboashop@gmail.com\r\n"; 
		$header .= "Disposition-Notification-To:mboashop@gmail.com"; // c'est ici que l'on ajoute la directive

		//mail($destinataires, $sujet, $message, $header);

		header('location:index.php?un=connexion');

	}

}

?>