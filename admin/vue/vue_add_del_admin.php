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

	<article class="service">
	<form method="post" action="index.php?un=add_del#add" enctype="multipart/form-data" id="add">

		<fieldset class="entrer" class="section">
			<legend>Nouvelle Boutique:</legend>

			<label for="nom">Nom:</label><input type="text" name="nom" required>
			<label for="proprietaire">Proprietaire:</label><input type="text" name="proprietaire" required>
			<label for="description">Description:</label><textarea name="description" placeholder="........." rows="10" cols="50" required></textarea>
			<label for="tarif">Tarif:</label><input type="number" name="tarif" required>
			<label for="image">Image:</label><input type="file" name="image" required>

			<input type="submit" value="Enregistrer">
		</fieldset>

	</form>
	</article>

	<article class="service">
	<form method="post" action="index.php?un=add_del#add" enctype="multipart/form-data" id="add">

		<fieldset class="entrer" class="section">
			<legend>Nouveau Gerant:</legend>

			<label for="nom">Nom:</label><input type="text" name="nom" required>
			<label for="mail">mail:</label><input type="text" name="mail" required>
			<label for="pass">mot de passe:</label><input type="password" name="pass" required>
			<label for="tel1">tel1:</label><input type="number" name="tel1" required>
			<label for="tel2">tel2:</label><input type="number" name="tel2" required>
			<select name="id">
				<?php while ($donne = $boutique->fetch()) { ?>
					<option <?php echo 'value="'.$donne['id'].'"'; ?> > <?php echo $donne['nom']; ?> </option>
				<?php }$boutique->closeCursor(); ?>
			</select>
			<input type="submit" value="Enregistrer">
		</fieldset>

	</form>
	</article>

	<article class="service">
	<form method="post" action="index.php?un=add_del#add" enctype="multipart/form-data" id="add">

		<fieldset class="entrer" class="section">
			<legend>Nouvel utilisateur:</legend>

			<label for="id_user">Identifient:</label><input type="text" name="id_user" required>
			<label for="nom">Nom:</label><input type="text" name="nom" required>
			<label for="mail">mail:</label><input type="text" name="mail" required>
			<label for="pass">mot de passe:</label><input type="password" name="pass" required>
			<label for="tel1">tel1:</label><input type="number" name="tel1" required>
			<label for="tel2">tel2:</label><input type="number" name="tel2" required>
			<select name="statut">
				<option value="secretaire" > Secretaire </option>
				<option value="livreur"> Livreur </option>
			</select>
			<input type="submit" value="Enregistrer">
		</fieldset>

	</form>
	</article>

	<article class="section">
		<?php while ($donne = $boutique->fetch()) { ?>
			
			<form method="post" action="index.php?un=add_del">
				<input type="hidden" name="id_boutique" <?php echo 'value="'.$donne['id'].'"'; ?> >
				<h3>NOM: <?php echo $donne['nom']; ?> </h3>
				<h3>PROPRIETAIRE: <?php echo $donne['proprietaire']; ?> </h3>
				<h3>DESCRIPTION: <?php echo $donne['description']; ?> </h3>
				<h3>TARIF: <?php echo $donne['tarif']; ?> FRS</h3>
				<img <?php echo 'src="'.$donne['image'].'"'; ?> <?php echo 'title="'.$donne['nom'].'"'; ?> width="100px" heigth="100" >

				<input type="submit" value="Supprimer">
			</form>

		<?php }$boutique->closeCursor(); ?>
			
	</article>

</section>

<?php require 'footer.php'; ?>

</body>
</html>