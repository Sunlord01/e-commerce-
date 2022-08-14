 <!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<title>MBOA SHOP ADMIN: Connexion</title>
</head>
<body>

<?php require 'header.php'; ?>

<section>

	<form method="post" action="index.php?un=gestion">
		<?php if (!empty($_SESSION['recherche'])) { $var = $_SESSION['recherche']; }else{ $var = NULL; }	 ?>
		<input type="search" name="recherche" <?php echo'value="'.$var.'"' ?> placeholder="recherche">

		<?php if (!empty($_SESSION['statut_article']) AND $_SESSION['statut_article'] == "actif"){ ?>
			<label>Actif</label><input type="radio" name="statut" value="actif" checked>
		<?php }else{ ?>
			<label>Actif</label><input type="radio" name="statut" value="actif">
		<?php } if (!empty($_SESSION['statut_article']) AND $_SESSION['statut_article'] == "non-actif"){ ?>
			<label>Non-Actif</label><input type="radio" name="statut" value="non-actif" checked>
		<?php }else{ ?>
			<label>Non-Actif</label><input type="radio" name="statut" value="non-actif">
		<?php } ?>
		<input type="submit" value="search">
	</form>

	<article id="liens" class="section">
		
		<?PHP while ($donne = $articles->fetch()) { ?>
		
		<aside class="colone">
			<form method="post" action="" >
				<input type="hidden" name="id_article" <?php echo 'value="'.$donne['id'].'"'; ?> >
				<img <?php echo 'src="'.$donne['image'].'"'; ?> <?php echo 'title="'.$donne['nom'].'"'; ?> width="100px" heigth="100" >
					
					<h4><?php echo $donne['nom']; ?></h4>
					<input type="text" name="nom">
					<h3 class="description" ><?php echo $donne['description']; ?></h3>
					<details><textarea name="description" id="description" placeholder="description" rows="2" cols="15"></textarea></details>
					<h4><?php echo $donne['quantite']; ?></h4>

					<div>

						<div> 
							<?php if ( get_solde($donne['id']) > 0 ) {
							$prix = $donne['prix'] - ( $donne['prix']*get_solde($donne['id']) ) ;

							echo '<span class="line">'.$donne['prix'].' FRS</span>';
							echo $prix.' FRS' ; 
							}else{ echo $donne['prix'].' FRS'; } ?>

							<input type="number" name="prix">

							<?php echo '<br>'.(get_solde($donne['id'])*100).'%';?> 

							<input type="text" name="solde">
						</div>

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

					</div>

					<input type="submit" value="Modifier">

				</form>

					<details>
						
						<?PHP $melange = get_melange($donne['id']); while ($donnee = $melange->fetch()) { ?>
						<form method="post" action="">
							<input type="hidden" name="id_melange" <?php echo 'value="'.$donnee['id'].'"'; ?> >
							<input type="hidden" name="id_article_melange" <?php echo 'value="'.$donne['id'].'"'; ?> >
							<h4>Couleur:<?php echo $donnee['couleur']; ?></h4>
							<input type="text" name="couleur">
							<h4>Taille:<?php echo $donnee['taille']; ?></h4>
							<input type="text" name="taille">
							<h4>Quantite:<?php echo $donnee['quantite']; ?></h4>
							<input type="number" name="quantite">
							<input type="submit" value="Modifier">
						</form>
						<?PHP } $melange->closeCursor(); ?>

					</details>

		</aside>
			<?PHP } $articles->closeCursor(); if( empty($_POST['recherche']) && empty($_POST['statut']) && empty($_GET['page_s'])){ ?>

			<div class="pagination">

			<?php   for ($i=1; $i <= $pageTotales ; $i++) { 
				
				if ($i == $pageCourante) {
					echo $i;						
				}else{
					echo '<button><a href="index.php?un=gestion&page='.$i.'#liens" class="page"> '.$i.' </a></button>   ';
				}
			} ?>

			</div>

			<?php }elseif (!empty($_POST['statut']) | !empty($_GET['page_s'])) { ?>
				
			<div class="pagination">

			<?php   for ($i=1; $i <= $pageTotales_s ; $i++) { 
				
				if ($i == $pageCourante_s) {
					echo $i;						
				}else{
					echo '<button><a href="index.php?un=gestion&page_s='.$i.'#liens" class="page"> '.$i.' </a></button>   ';
				}
			} ?>

			<?php }	?>

	</article>

</section>

<?php require 'footer.php'; ?>

</body>
</html>