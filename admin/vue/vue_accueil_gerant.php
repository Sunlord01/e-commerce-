<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<title>MBOA SHOP ADMIN: Connexion</title>
</head>
<body>

<?php require 'header.php'; ?>

<section>

	<article id="section">
 
		<aside> <h1><b><mark>ARTICLES:</mark></b></h1>

			<h1>NOMBRE D'ARTICLE ACTIFS RESTANT :<?php echo get_articles_restant("quantite");?></h1> <br> 
			<span>Somme:</span> <?php echo get_articles_restant("prix_total");?></h1> <br>

			<h1>NOMBRE D'ARTICLE INACTIFS RESTANT :<?php echo get_articles_inac_restant("quantite");?></h1> <br> 
			<span>Somme:</span> <?php echo get_articles_inac_restant("prix_total");?></h1> <br>
		
			<h1>ARTICLE TOTAUX PRENSENT :<?php echo get_articles_present("quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_present("prix_total");?></h1> <br>

			<h1>ARTICLE AVANT VENTES :<?php echo get_articles_totaux("quantite");?></h1> <br>   
			<span>Somme:</span> <?php echo get_articles_totaux("prix_total");?></h1> <br>

		</aside>

		<aside> <h1><b><mark>ARTICLES RECEPTIONNES:</mark></b></h1>

			<h1>RECEPTION JOURNALIERE :<?php echo get_articles_receptionner_jour(1,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_receptionner_jour(1,"prix_total");?></h1> <br>

			<h1>RECEPTION HEBDOMADAIRE :<?php echo get_articles_receptionner_jour(7,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_receptionner_jour(7,"prix_total");?></h1> <br>

			<h1>RECEPTION MENSUELLE :<?php echo get_articles_receptionner_jour(30,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_receptionner_jour(30,"prix_total");?></h1> <br>

			<h1>NOMBRE TOTAL D'ARTICLE RECEPTIONNES :<?php echo get_articles_receptionner("quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_receptionner("prix_total");?></h1> <br>

		</aside>

		<aside> <h1><b><mark>ARTICLES LIVRES:</mark></b></h1>

			<h1>LIVRAISON JOURNALIERE :<?php echo get_articles_livres_jour(1,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_livres_jour(1,"prix_total");?></h1> <br>

			<h1>LIVRAISON HEBDOMADAIRE :<?php echo get_articles_livres_jour(7,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_livres_jour(7,"prix_total");?></h1> <br>

			<h1>LIVRAISON MENSUELLE :<?php echo get_articles_livres_jour(30,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_livres_jour(30,"prix_total");?></h1> <br>

			<h1>NOMBRE TOTAL D'ARTICLE LIVRES :<?php echo get_articles_livres("quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_livres("prix_total");?></h1> <br>

		</aside>

		<aside> <h1><b><mark>ARTICLES VENDU:</mark></b></h1>
		
			<h1>VENTE JOURNALIERE :<?php echo get_articles_vendu_jour(1,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_vendu_jour(1,"prix_total");?></h1> <br>

			<h1>VENTE HEBDOMADAIRE :<?php echo get_articles_vendu_jour(7,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_vendu_jour(7,"prix_total");?></h1> <br>

			<h1>VENTE MENSUELLE :<?php echo get_articles_vendu_jour(30,"quantite");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_vendu_jour(30,"prix_total");?></h1> <br>

			<h1>VENTE TOTAL :<?php echo get_articles_vendu("vendu");?></h1> <br>  
			<span>Somme:</span> <?php echo get_articles_vendu("prix_total");?></h1> <br>

		</aside>

		<aside>
			<h1>NOMBRE TOTAL D'ARTICLE LIVRES/RECEPTIONNES :<?php echo get_articles_total_vendu("quantite");?></h1> </br>  
			<span>Somme:</span> <?php echo get_articles_total_vendu("prix_total");?></h1> <br>
		</aside>

	</article>

	<article>
		<form method="post" action="index.php?un=accueil#up" enctype="multipart/form-data" id="up">
			<fieldset>
				<legend>Modification Info Boutique:</legend>

				<input type="hidden" name="boutique_up" value="1">
				<h4>NOM: <?php echo get_info_boutique("nom"); ?> </h4>
				<input type="text" name="nom">
				<label for="image">
					<h4>IMAGE:<img <?php echo 'src="'.get_info_boutique("image").'"'; 
						echo 'title="'.get_info_boutique("image").'"'; ?> height="100px" width="300px" > 
					</h4>
				</label><input type="file" name="image">
				<h4>DESCRIPTION: <?php echo get_info_boutique("description"); ?> </h4>
				<input type="text" name="description">
				<h4>PROPRIETAIRE: <?php echo get_info_boutique("proprietaire"); ?> </h4>
				<input type="text" name="proprietaire">
				<h4>STATUT: <?php echo get_info_boutique("statut"); ?> </h4>
				<?php if ( get_info_boutique("statut") == "actif"){ ?>
					<label>Actif</label><input type="radio" name="statut_up" value="actif" checked>
				<?php }else{ ?>
					<label>Actif</label><input type="radio" name="statut_up" value="actif">
				<?php } if ( get_info_boutique("statut") == "non-actif"){ ?>
					<label>Non-Actif</label><input type="radio" name="statut_up" value="non-actif" checked>
				<?php }else{ ?>
					<label>Non-Actif</label><input type="radio" name="statut_up" value="non-actif">
				<?php } ?>

				<input type="submit" value="Modifier">
			</fieldset>
		</form>
	</article>

	<article>
		<form method="post" action="index.php?un=accueil#up" enctype="multipart/form-data" id="up">
			<fieldset>
				<legend>Modification Info Gerant:</legend>

				<input type="hidden" name="info_up" value="1">
                <h4>NOM: <?php echo get_info_gerant("nom"); ?> </h4>
                <h4>MAIL: <?php echo get_info_gerant("mail"); ?> </h4>
                <input type="text" name="mail">
                <h4>MOT DE PASSE: <?php echo get_info_gerant("mot"); ?> </h4>
                <input type="text" name="pass">
                <h4>TEL: <?php echo get_info_gerant("tel"); ?> </h4>
                <input type="number" name="tel">

				<input type="submit" value="Modifier">
			</fieldset>
		</form>
	</article>

</section>

<?php require 'footer.php'; ?>

</body>
</html>