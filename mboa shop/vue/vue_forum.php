<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<title>MBOA SHOP Online: forum</title>
</head>
<body>
	<?php	require 'header.php';  ?>

	<section class="section" id="liens">

		<h1 class="nom">FORUM</h1>

		<?php	while ($donnees=$msg->fetch()) {

				$donnees['message'] = nl2br($donnees['message']);
				$donnees['message'] = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $donnees['message']);
				$donnees['message'] = preg_replace('#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#i', '<a href="mailto:$0">$0</a>', $donnees['message']);
				$donnees['message'] = preg_replace('#6[957]([0-9]{2}){3}([0-9])#i', '<a href="telephone:$0">$0</a>', $donnees['message']);

				?> 

				<div class="contenair">
					<div id="name" class="elemnt" class="cadre">
						<h3><?php echo get_nom($donnees['id_utilisateur']); ?>:</h3>
						<h5><?php echo $donnees['dates']; ?></h5>
					</div>
					<div id="message" class="elemnt" class="cadre">
						<h4><?php echo $donnees['titre']; ?></h4>
						<p><?php echo $donnees['message']; ?></p>
					</div>

				</div>

			<?php  }$msg->closeCursor();	?>

			<div class="pagination">

		<?php   for ($i=1; $i <= $pageTotales ; $i++) { 
				
					if ($i == $pageCourante) {
						echo $i;						
					}else{
						echo '<button><a href="index.php?un=forum&page='.$i.'#liens"> '.$i.' </a></button>   ';
					}
				}
		?> </div>

	<?php if(!empty($_SESSION['id'])){ ?>

		<form method="post" action="index.php?un=forum#insertion" id="insertion">
			<fieldset>
				<legend>Poster Un Message</legend>
				<p><label for="nom"></label><input type="text" name="nom" id="nom" 
					<?php
					if (!empty($_SESSION['pseudo'])) {
							echo 'value="'.$_SESSION['pseudo'].'"' ;
						}
					else {
							echo 'placeholder="Nom"';# code...
						}
					?>
				required ></p>
				<label for="titre"></label><input type="text" name="titre" id="titre" placeholder="Titre" >
				<p>      </p>
				<textarea name="message" id="message" placeholder="Commentaire" rows="10" cols="50" required></textarea>
				<p class="nj"><input type="submit" value="poster" id="submit"></p>
			</fieldset>
		</form>

	<?php }else{ ?>

			<h3>vous devez etre connecter a votre compte pour poster des commentaire.<a href="index.php?un=connexion" title="Connexion">se connecter...</a>

	<?php } ?>

	</section>

	<?php require 'footer.php';	?>
</body>
</html>