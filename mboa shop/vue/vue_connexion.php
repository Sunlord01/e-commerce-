<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<title>MBOA SHOP: Connexion</title>
</head>
<body>

	<a href="index.php"><img src="image/home.png"></a>

	<?php if (!empty($_GET['i']) && $_GET['i'] == "1") {	?>

	<section>
		<mark>Inscription</mark>
		<img src="image/user.png">

		<form method="post" action="index.php?un=connexion&i=1">
			<label>Nom:</label><input type="text" name="nom" required>
			<label>Prenom:</label><input type="text" name="prenom" required>
			<label>Mail:</label><input type="mail" name="mail" required>
			<label>Pseudo:</label><input type="text" name="pseudo" required>
			<label>Telephone:</label><input type="number" name="tel" required>
			<label>Mot de passe:</label><input type="password" name="pass" required>
			<label>Rester connecter</label><input type="checkbox" name="choix">
			<input type="submit" value="S'inscrire" class="liens" >
		</form>

		<span>Vous possedez deja un compte?<a href="index.php?un=connexion">se connecter.</a></span>
	</section>
 
	<?php } 

	elseif (!empty($_GET['m']) && $_GET['m'] == "1") {	?>

	<section>
		<mark>mot de passe oublier</mark>

		<form method="post" action="index.php?un=connexion">
			<input type="hidden" name="mpo" value="ok" >
			<label>Mail:</label><input type="mail" name="mail" required>
			<p>OU</p>
			<label>Telephone:</label><input type="text" name="tel" required> 
			<a onclick="history.back()">Retour</a>
			<input type="submit" value="Changer de mot de passe" class="liens" >
		</form>

		<span>Vous allez recevoir un email vous permettant de modifier votre mot de passe.</span>
	</section>	

	<?php }

	elseif (!empty($_GET['i']) && $_GET['i'] == "o") {   ?>
		
	<section>
		<mark>modifier le mot de passe</mark>
		<img src="image/user.png">

		<form method="post" action="">
			<input type="hidden" name="mpw" value="1" >
			<p>Pseudo:<?php echo $_SESSION['pseudo']; ?></p>
			<p>Mail:<?php echo $_SESSION['mail']; ?></p>
			<label>Nouveau MDP:</label><input type="password" name="pass" required> 
			<input type="submit" value="Changer de mot de passe" class="liens" >
		</form>

		<span>votre mot de passe sera modifier.</span>
	</section>

	<?php }

	 else{	?>

	<section>
		<mark>Connexion</mark>
		<img src="image/user.png">

		<form method="post" action="index.php?un=connexion">
			<label>Pseudo/Mail:</label><input type="text" name="pseudo" required>
			<label>Mot de passe:</label><input type="password" name="pass" required>
			<label>Rester connecter</label><input type="checkbox" name="choix">
			<span>Mot de passe <a href="index.php?un=connexion&m=1">Oublier?</a></span>
			<input type="submit" value="Ce Connecter" class="liens" >
		</form>

		<span>Vous ne possedez pas de compte?<a href="index.php?un=connexion&i=1">s'inscrire.</a></span>
	</section>

	<?php } ?>

</body>
</html>