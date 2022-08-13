<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<link rel="stylesheet" type="text/css" href="css/panier.css">
	<title>MBOA SHOP Online: Accueil</title>
</head> 
<body>

	<?php require 'header.php' ?> 

	<section id="contenair">
  
		<h2>Panier</h2> 

		<?php if (!empty($articles)) { ?>

		<div id="row_panier" > <span class="figure_rp" id="liens">Article</span> <span class="couleur_rp">Couleur</span> <span class="taille_rp">Taille</span> <span class="quantite_rp">Quantite</span> <span class="prix_rp"> Prix.U</span> <span class="prixt_rp">Prix.T</span></div>

		<?PHP

		while($donne = $articles->fetch()){ ?> 

			<form method="post" action="index.php?un=panier#liens" class="row_panier">

				<figure class="figure_rp"><img <?php echo 'src="'.get_img($donne['id_article']).'"'; ?> class="img_rp">
					<?php if ( get_solde($donne['id_article']) > 0 ) {
						$solde = get_solde($donne['id_article']) * 100 ;

						echo '-'.$solde.'%' ;
					}
					?>
					<figcaption class="nom_rp"> <?php echo '<a href="index.php?un=article&id_article='.$donne['id_article'].'&article='.get_info('nom',$donne['id_article']).'#liens" >'.get_info('nom',$donne['id_article']).'</a>'; ?> </figcaption>
				</figure>

				<div class="couleur_rp"> <?php echo $donne['couleur']; ?> </div>

				<div class="taille_rp"> <?php echo $donne['taille']; ?> </div>

				<div class="quantite_rp">
					<input type="number" name="quantite" <?php echo 'placeholder="'.$_SESSION['quantite'][''.$donne['id'].''].'"'; ?> min="1" max="5">
					<input type="hidden" name="id" <?php echo 'value="'.$donne['id'].'"'; ?>>
					<input type="submit" value="+" class="maj">
				</div>

				<div class="prix_rp"> <?php echo $_SESSION['prix'][''.$donne['id'].''].' FRS'; ?> </div>

				<div class="prixt_rp"> <?php echo $_SESSION['prix_total'][''.$donne['id'].''].' FRS'; ?> </div>

				<?php echo '<a href="index.php?un=panier&del='.$donne['id'].'#liens" class="del" >DEL</a>'; ?>

			</form>

		<?PHP }$articles->closeCursor(); ?>




				<div class="row">
					<button class="bouton"><?php echo'Nombre d"article:'.array_sum($_SESSION['quantite']).''; 
 					?></button>
 					<button  class="bouton"><?php echo'Prix Total:'.array_sum($_SESSION['prix_total']).' FRS'; ?></button>
 				</div>





 		<form action="index.php?un=panier#encre" method="post" id="Enregistrer">
 			<fieldset>

 				<legend class="nom_panier">Veuiller entrer vous informations afin de pouvoir valider la commande...</legend>

 			<?php

				if (empty($_SESSION['pseudo'])) {
						echo '<label for="nom">NOM/PSEUDO:</label><input type="text" name="nom" id="nom" class="input" placeholder="Pseudo" required>' ;
				 }

				if (empty($_SESSION['mail'])) {
						echo '<label for="mail"> EMAIL:</label><input type="mail" name="mail" id="mail" class="input" placeholder="MonAdresse@gmail.com" required>' ;
				 }
			
			?>

 			<label for="tel">NUMERO:</label><input type="tel" name="tel" id="tel" 
			<?php if (!empty($_SESSION['id'])) {
						echo 'value="'.get_info_user('tel',$_SESSION['id']).'"';
				 }else{
						echo 'placeholder="6 99 99 99 99"';
				 }
			?>
			 required class="input">

 			<label for="region">REGION:</label>
 			<select name="region" id="region" placeholder=" NGOUSSO" required class="input" >
 				<option value="centre">Centre</option>
 				<option value="littoral">Littoral</option>
 				<option value="ouest">Ouest</option>
 				<option value="est">Est</option>
 			</select>

 			<label for="ville">VILLE:</label>
 			<select name="ville" id="ville" placeholder=" NGOUSSO" required class="input" >
 				<option value="yaounde">Yaounde</option>
 				<option value="douala">Douala</option>
 				<option value="bafoussam">Bafoussam</option>
 				<option value="edea">Edea</option>
 			</select>

 			<label for="quartier">QUARTIER:</label><input type="text" name="quartier" id="quartier" placeholder=" NGOUSSO" required class="input" >

 			<label for="livraison">LIVRAISON(2000 FRS):</label><input type="checkbox" name="livraison" >

 			<input type="submit" value="Valider" class="bouton">

 			</fieldset>
 		</form>

		<?php	}elseif (!empty($_GET['mail']) AND $_GET['mail'] == "ok") {
							echo "UN EMAIL DE CONFIRMATION VOUS A ETE ENVOYER...";
		}else{ echo "VOTRE PANIER EST VIDE..."; } ?>

	</section>

	<?php require 'navigation.php'; ?>

	<?php require 'footer.php'; ?>

</body>
</html>