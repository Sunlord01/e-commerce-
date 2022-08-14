<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/accueil.css">
	<title>MBOA SHOP Online: Accueil</title>
</head> 
<body>

	<?php require 'header.php' ?> 

	<section class="section" #liens>

		<h2>Nos Differentes Boutiques</h2> 

		<article id="service">

			<?php while ($donne = $boutique->fetch() ) { ?>

			<aside class="row">
				<img <?php echo 'src="'.$donne['image'].'"'; ?> >
				<div class="box">
					<h3><?php echo$donne['nom']; ?></h3>
					<h4 class="description"> <?php echo$donne['description']; ?> </h4>
					
					<form method="post" <?php echo 'action="index.php?un=boutique"'; ?> >
						<input type="hidden" name="id_boutique" <?php echo 'value="'.$donne['id'].'"'; ?> >
						<input type="hidden" name="boutique" <?php echo 'value="'.$donne['nom'].'"'; ?> >
						<input type="submit" value="aller a" class="liens" >
					</form>
				</div>
			</aside>

			<?php } $boutique->closeCursor(); ?>

		</article>
	</section>

	<?php require 'footer.php' ?>

</body>
</html>