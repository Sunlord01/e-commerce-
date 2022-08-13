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

</section>

<?php require 'footer.php'; ?>

</body>
</html>