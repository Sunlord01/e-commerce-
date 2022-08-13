<header>
	<div id="logo" >
		<a href="index.php?un=accueil"><h1>MBOA SHOP Online</h1></a>
	</div>
	<ul class="nav_liste">
		<a href="index.php?un=accueil"><li>Accueil</li></a>
		<a href="index.php?un=gallerie"><li>Gallerie</li></a>
		<a href="index.php?un=forum"><li>Forum</li></a>
	</ul>
	<div class="float">

		<?php if (empty($_SESSION['id'])) { ?>

		<a href="index.php?un=connexion"><img src="image/user.png" class="iconHeader"></a>

		<?php }elseif (!empty($_GET['un']) && $_GET['un'] == "compte"){ ?>

			<a href="index.php" id="iconHeader"><?php echo strtoupper( $_SESSION['pseudo'][0] ); ?></a>

			<a href="index.php?un=deconnexion">OFF</a>

			<a href="index.php?un=connexion&raison=re">Changer de Compte</a>

			<?php if (!empty($_SESSION['statut'])) {  ?>

				<a href="admin/index.php?un=choix">Changer de Mode de Connexion</a>

			<?php } ?>

		<?php }elseif (!empty($_SESSION['id'])){ ?>

		<a href="index.php?un=compte" id="iconHeader"><?php echo strtoupper( $_SESSION['pseudo'][0] ); ?></a>

		<a href="index.php?un=deconnexion">OFF</a>

		<?php } ?>

		<a href="index.php?un=panier"><img src="image/panier.png" class="iconHeader">
			<h3 id="nbr_panier"> <?php if(!empty($_SESSION['quantite'])) echo array_sum($_SESSION['quantite']); else echo'0'; ?> </h3>
		</a>
		<form method="post" action="index.php?un=recherche">
			<?php if (!empty($_SESSION['recherche'])) { $var = $_SESSION['recherche']; }else{ $var = NULL; }	 ?>
			<input type="search" name="recherche" <?php echo'value="'.$var.'"' ?> id="recherche">
			<input type="submit" value="search" id="re">
		</form>
		<ul>
			<div class="toogle"> </div>
			<div class="toogle"> </div>
			<div class="toogle"> </div>
		</ul>
	</div>
</header>

<article id="baniere_defilante">
	<div class="baniere">
<?php 
	$timg = file_get_contents('contents/bannieres.txt');
	$img = explode("\n", $timg);
	$end = end($img);
	$tbanniere = explode('||', $end);
?>


<?php
	foreach ($tbanniere as $value) {
		$val = explode('~', $value);
		echo '<a href="'.$val['0'].'" > <img src="image/'.end($val).'"> </a>';
	}
?>
	</div>

<?php
	$texte = file_get_contents('contents/annonces.txt');
	$text = explode("\n", $texte);
	$end = end($text);
		$end = nl2br($end);
		$end = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $end);
		$end = preg_replace('#https://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $end);
		$end = preg_replace('#[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}#i', '<a href="mailto:$0">$0</a>', $end);
		$end = preg_replace('#6[957]([0-9]{2}){3}([0-9])#i', '<a href="telephone:$0">$0</a>', $end);
	$tannonce = explode('||', $end);
?>
	
	<div class="message">

<?php
	foreach ($tannonce as $value) {
		echo '<p>'.$value.'</p>';
	}
?>

	</div>
</article>