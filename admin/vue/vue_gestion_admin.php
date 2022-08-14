 <!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<title>MBOA SHOP ADMIN: Connexion</title>
</head>
<body>

<?php require 'header.php'; ?>

<section id="section">

	<article class="section">
		<?php while ($donne = $boutique->fetch()) { ?>
			
			<form method="post" action="index.php?un=gestion#up" id="up">
				<input type="hidden" name="id_boutique" <?php echo'value="'.$donne['id'].'"'; ?> >
				
				<h3>NOM: <?php echo $donne['nom']; ?> </h3>
				<h3>PROPRIETAIRE: <?php echo $donne['proprietaire']; ?> </h3>
				<h3>DESCRIPTION: <?php echo $donne['description']; ?> </h3>
				<h3>TARIF: <?php echo $donne['tarif']; ?> FRS</h3>
				<input type="number" name="tarif">

				<img <?php echo 'src="'.$donne['image'].'"'; ?> <?php echo 'title="'.$donne['nom'].'"'; ?> width="100px" heigth="100" >

				<h4> Statut:<?php echo $donne['statut']; ?></h4>
				<?php if ( get_statut($donne['id']) == "actif"){ ?>
					<label>Actif</label><input type="radio" name="statut_up" value="actif" checked>
				<?php }else{ ?>
					<label>Actif</label><input type="radio" name="statut_up" value="actif">
				<?php } if ( get_statut($donne['id']) == "non-actif"){ ?>
					<label>Non-Actif</label><input type="radio" name="statut_up" value="non-actif" checked>
				<?php }else{ ?>
					<label>Non-Actif</label><input type="radio" name="statut_up" value="non-actif">
				<?php } ?>

				<input type="submit" value="modifier">
			</form>

		<?php }$boutique->closeCursor(); 
		if ( !empty($_FILES['banniere0']) && empty($_FILES['banniere1']['tmp_name']) ) echo "pass test";else echo "lost test"  
		?>
			
	</article>

	<form method="post" action="index.php?un=gestion#ab" enctype="multipart/form-data" id="ab" >
		<fieldset>
			<legend>Banniere et annonces:</legend>
			<label>Banniere 0:</label><input type="file" name="banniere0">
			<label>liens 0:</label><input type="text" name="link0">
			<label>Banniere 1:</label><input type="file" name="banniere1">
			<label>liens 1:</label><input type="text" name="link1">
			<label>Banniere 2:</label><input type="file" name="banniere2">
			<label>liens 2:</label><input type="text" name="link2">
			<label>Banniere 3:</label><input type="file" name="banniere3">
			<label>liens 3:</label><input type="text" name="link3">
			<label>Annonces:</label><textarea name="annonces" rows="5" cols="15"></textarea>
			<cite>s'il y a plusieurs annoces, il faudra separer chacun d'elle avec le caractere "||"</cite>
			<input type="submit" value="Enregistrer">
		</fieldset>
	</form>

</section>

<?php require 'footer.php'; ?>

</body>
</html>