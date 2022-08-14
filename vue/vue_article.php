<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<link rel="stylesheet" type="text/css" href="css/article.css">
	<title>MBOA SHOP Online: <?php echo nom_article(); ?> </title>
</head> 
<body>

	<?php require 'header.php' ?> 

	<section class="section">

		<h2> <?php echo nom_article(); ?>  </h2>

			<?PHP  while ( $donne = $article->fetch() ) { ?>

				<form method="post" <?php echo 'action="index.php?un=panier"'; ?> class="cadre" id="liens">

					<img <?php echo 'src="'.$donne['image'].'"'; ;echo 'title="'.$donne['nom'].'"'; ?> class="img_article" >
					<ul>
						<?PHP $couleurs = get_couleurs_article($_SESSION['id_article']);

						foreach ($couleurs as $element) {

							echo '<input type="radio" name="couleur" value="'.$element.'" class="liens" required>'.$element.'';
							$tailles = get_tailles_couleur_article($_SESSION['id_article'],$element);

							foreach ($tailles as $elemente) {

								echo '<input type="radio" name="taille" value="'.$elemente.'" class="liens" required>'.$elemente.'';
							}
								
						} ?>
					</ul>

					<input type="number" value="1" name="quantite" min="1" max="5" required>
					
					<div class="description"> <?php echo $donne['description']; ?> 
					</div>

					<div> 
						<?php if ( get_solde($donne['id']) > 0 ) {
							$prix = $donne['prix'] - ( $donne['prix']*get_solde($donne['id']) ) ;

							 echo '<span class="line">'.$donne['prix'].' FRS</span>';
							 echo $prix.' FRS' ;
						}else{ echo $donne['prix'].' FRS'; } ?> 

					</div>

							<?php $like = !empty($_SESSION['id']) ? verify_like($_SESSION['id'],$donne['id']) : NULL;
							
							 if(!$like){ 
							 	echo'<a href="index.php?un=article&id_like='.$donne['id'].'#liens" class="like"><img src="image/like.png" >'.$donne['likes'].'</a>' ; 
							 }else{ 
							 	echo'<a href="index.php?un=article&id_dislike='.$donne['id'].'#liens" class="like"><img src="image/likerouge.jpg" >'.$donne['likes'].'</a>' ;
							 } ?>
							
						<input type="hidden" name="id_article" <?php echo 'value="'.$donne['id'].'"'; ?> >
						<input type="hidden" name="prix" <?php echo 'value="'.$donne['prix'].'"'; ?> >
						<input type="submit" value="ajouter" class="liens" >

				</form>
		
			<?PHP } $article->closeCursor(); ?>

	</section>

	<?php require 'navigation.php'; ?>

	<?php require 'footer.php'; ?>

</body> 
</html>