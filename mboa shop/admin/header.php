<header>
	<div id="logo" >
		<a href="index.php?un=accueil"><h1>MBOA SHOP Online</h1></a>
	</div>
	<ul class="nav_liste">
		<a href="index.php?un=accueil"><li>Accueil</li></a>
		<a href="index.php?un=add_del"><li>Ajouts/Suppression</li></a>
		<a href="index.php?un=gestion"><li>Gestion</li></a>
		<a href="index.php?un=forum"><li>Forum</li></a>
	</ul>
	<div class="float">

		<?php if (empty($_SESSION['id'])) { ?>

		<a href="index.php?un=connexion"><img src="image/user.png" class="iconHeader"></a>

		<?php }else{ ?>

		<a href="index.php?un=compte" id="iconHeader" <?php echo'title="'.$_SESSION['pseudo'].'"'; ?> ><?php echo strtoupper( $_SESSION['pseudo'][0] ); ?></a>

		<mark><?php echo $_SESSION['statut']; ?></mark>

		<a href="index.php?un=deconnexion">OFF</a>
			
		<a href="index.php?un=choix">Changer de Mode de Connexion</a>

		<?php } ?>

		<ul>
			<div class="toogle"> </div>
			<div class="toogle"> </div>
			<div class="toogle"> </div>
		</ul>
	</div>
</header>
