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
	<form method="post" action="index.php?un=add_del" enctype="multipart/form-data" id="add">

		<fieldset class="entrer" class="section">
			<legend>Entrer les nouveau produit</legend>
			<select name="type" required>
				<option value="chapeau"> chapeau </option>
				<option value="pull over"> pull over </option>
				<option value="haut"> haut </option>
				<option value="short"> short </option>
				<option value="pantalon"> pantalon </option>
				<option value="chaussure"> chaussure </option>
			</select>

			<label for="image">Image:</label><input type="file" name="image" required>

			<label for="nom">Nom:</label><input type="text" name="nom" required>
			<label for="description">Description:</label><textarea name="description" placeholder="........." rows="10" cols="50" required></textarea>
			<label for="prix">Prix:</label><input type="number" name="prix" required>
			<label for="solde">Solde:</label><input type="text" name="solde" required>
			<label for="taille">Taille:</label><input type="text" name="taille" required>
			<label for="couleur">Couleur:</label><input type="text" name="couleur" required>
			<label for="quantite">Quantite:</label><input type="text" name="quantite" required>
			<details id="section">
				<label for="image">Image 0:</label><input type="file" name="image0" >
				<label for="image">Image 1:</label><input type="file" name="image1" >
				<label for="image">Image 2:</label><input type="file" name="image2" >
				<label for="image">Image 3:</label><input type="file" name="image3" >
				<label for="image">Image 4:</label><input type="file" name="image4" >
				<label for="image">Image 5:</label><input type="file" name="image5" >
				<label for="image">Image 6:</label><input type="file" name="image6" >
				<label for="image">Image 7:</label><input type="file" name="image7" >
				<label for="image">Image 8:</label><input type="file" name="image8" >
				<label for="image">Image 9:</label><input type="file" name="image9" >
				<label for="image">Image 10:</label><input type="file" name="image10" >
			</details>

			<input type="hidden" name="boutique" <?php echo 'value="'.$_SESSION['id'].'"'; ?>> 
			
			<input type="submit" value="Enregistrer">
		</fieldset>

	</form>
	</article>

	<article id="liens" class="section">

			<form method="post" action="index.php?un=add_del#liens" >
				<label>Recherche:</label>
				<?php if (!empty($_SESSION['recherche'])) { $var = $_SESSION['recherche']; }else{ $var = NULL; }	 ?>
				<input type="search" name="recherche" <?php echo'value="'.$var.'"' ?> placeholder="recherche">
				<input type="submit" value="Rechercher">
			</form>

			<?PHP while ($donne = $articles->fetch()) { ?>
				
			<aside class="colum">
				<img <?php echo 'src="'.$donne['image'].'"'; ?> <?php echo 'title="'.$donne['nom'].'"'; ?> width="100px" heigth="100" >
					
					<h4><?php echo $donne['nom']; ?></h4>
					<h3 class="description" width="500px"><?php echo $donne['description']; ?></h3>
					<h4><?php echo $donne['quantite']; ?></h4>

					<div>

						<div> 
							<?php if ( get_solde($donne['id']) > 0 ) {
							$prix = $donne['prix'] - ( $donne['prix']*get_solde($donne['id']) ) ;

							echo '<span class="line">'.$donne['prix'].' FRS</span>';
							echo $prix.' FRS' ; 
							}else{ echo $donne['prix'].' FRS'; } 
							echo '<br>'.(get_solde($donne['id'])*100).'%';	?> 
						</div>

						<?php echo'<a href="index.php?un=add_del&id_article='.$donne['id'].'#liens" class="liens" >Del</a>'; ?>

					</div>

					<details>
						
						<?PHP $melange = get_melange($donne['id']); while ($donnee = $melange->fetch()) { ?>
						<div>
							<h4>Couleur:<?php echo $donnee['couleur']; ?></h4>
							<h4>Taille:<?php echo $donnee['taille']; ?></h4>
							<h4>Quantite:<?php echo $donnee['quantite']; ?></h4>
							<?php echo'<a href="index.php?un=add_del&id_melange='.$donnee['id'].'#liens" class="liens" >Del</a>'; ?>
						</div>
						<?PHP } $melange->closeCursor(); ?>

					</details>

			</aside>

			<?PHP } $articles->closeCursor(); if(empty($_POST['recherche'])){ ?>

			<div class="pagination">

			<?php   for ($i=1; $i <= $pageTotales ; $i++) { 
				
				if ($i == $pageCourante) {
					echo $i;						
				}else{
					echo '<button><a href="index.php?un=add_del&page='.$i.'#liens" class="page"> '.$i.' </a></button>   ';
				}
			}

			}
			?> </div>

		</article>

</section>

<?php require 'footer.php'; ?>

</body>
</html>