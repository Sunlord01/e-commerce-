<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="css/connexion.css">
	<title>MBOA SHOP ADMIN: Connexion</title>
</head>
<body>

<header>
	<div id="logo" >
		<h1>MBOA SHOP Online</h1>		
	</div>

    <ul class="nav_liste">
        <a href="index.php?un=accueil"><li>Reception</li></a>
        <a href="index.php?un=accueil&deux=livraison"><li>Livraison</li></a>
        <a href="index.php?un=accueil&deux=livreur"><li>Livreur</li></a>
    </ul>

    <div>
        <h1>Nombre livreur actifs: <?php echo get_livreur_actif(); ?> </h1>
    </div>
	
	<div class="float">

		<?php if (empty($_SESSION['id'])) { ?>
		<a href="index.php?un=connexion"><img src="image/user.png" class="iconHeader"></a>
		<?php }else{ ?>
		<a href="index.php?un=compte" id="iconHeader" <?php echo'title="'.$_SESSION['pseudo'].'"'; ?> ><?php echo strtoupper( $_SESSION['pseudo'][0] ); ?></a>
		<mark><?php echo $_SESSION['statut']; ?></mark>
        <a href="index.php?un=choix">Changer de Mode de Connexion</a>
		<a href="index.php?un=deconnexion">OFF</a>
		<?php } ?>
	</div>
</header>



<section id="section">
    <span>LIVREUR:</span>

    <?php while ($donne=$get_livreur->fetch())
            { 
    ?>

    <article>
        <h1>NOM: <?php echo get_info_livreur($donne['id'],"nom"); ?> </h1> 
        <h1>TEL1: <?php echo get_info_livreur($donne['id'],"tel1"); ?> </h1> 
        <h1>TEL2: <?php echo get_info_livreur($donne['id'],"tel2"); ?> </h1> 
        <h2>Nombre de livraison journaliere: <?php echo get_commande_livrer($donne['id']); ?> </h2>
        <h2>Somme livraison journaliere: <?php echo get_somme_journaliere($donne['id']); ?>FRS </h2>
        <h2>Nombre de livraison journaliere Valider: <?php echo get_commande_livreur_valider($donne['id']); ?> </h2>
        <h1>STATUT: <?php if( get_info_livreur($donne['id'],"action") != ("libre" AND "actif" AND " ") ) {echo "Actif"; }else{ echo "Non-Actif";} ; ?> </h1> 
        
    </article>

	<?php } $get_livreur->closeCursor(); ?>
    

</section>


<?php require 'footer.php'; ?>

</body>
</html>