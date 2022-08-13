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
        <h1>Somme Vente Journaliere actuelle: <?PHP echo get_vente(); ?></h1>
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
    
    <article>          
        
        <h2 id="liens_tnv"> 
            <?php  echo 'Commandes disponible:'.get_commandetotal_recep_non_valider()->rowCount();   ?>
        </h2>

        <?php
        if ($get_commande_recep_non_valider) {
        }            
            while ($donnees=$get_commande_recep_non_valider->fetch())
            { 
                $produits = explode(',', $donnees['id_melange']);
                $count = count($produits);
                $quantites = explode(',', $donnees['quantite']);
                $prix = explode(',',$donnees['prix_total']);
                $prix_total = array_sum($prix);

                ?>

<div class="body"> 

 <div class="affichage">
        
            <div class="commande">              
                <table>
                    <caption><b><h3> COMMANDE N°<?php echo $donnees['id']; ?> </h3></b></caption>

                <?php if (!empty($donnees['id_utilisateur'])) { ?>
                    
                    <caption> 
                        <p> <b>Nom:</b> <?php echo get_info($donnees['id'],'nom'); ?>&nbsp<b>Tel:</b> <?php if($donnees['tel'] != get_info($donnees['id'],'tel')){ 
                            echo $donnees['tel'].'/'.get_info($donnees['id'],'tel'); }else{ echo get_info($donnees['id'],'tel');} ?><br>
                        <b>Mail:</b> <?php echo get_info($donnees['id'],'mail'); ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
                        <p><b>Region:</b> <?php echo $donnees['region']; ?> &nbsp<b>Ville:</b> <?php echo $donnees['ville']; ?> 
                        &nbsp<b>Quartier:</b> <?php echo $donnees['quartier']; ?> </p>
                    </caption>

                <?php }else{ ?>    

                    <caption> 
                        <p> <b>Nom:</b> <?php echo $donnees['nom']; ?>&nbsp<b>Tel:</b> <?php echo $donnees['tel']; ?><br><b>Mail:</b> <?php echo $donnees['mail']; ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
                        <p><b>Region:</b> <?php echo $donnees['region']; ?> &nbsp<b>Ville:</b> <?php echo $donnees['ville']; ?> 
                        &nbsp<b>Quartier:</b> <?php echo $donnees['quartier']; ?> </p>
                    </caption>

                <?php } ?>   

                    <tr>
                        <th> Produits </th>
                        <th> Couleur </th>
                        <th> Taille </th>
                        <th> Prix_Unit </th>
                        <th> Quantités </th>
                        <th> prix_Total </th>
                    </tr>

                    <?php
                    for ($i=0; $i < $count ; $i++) { 
                    ?>

                    <tr>
                        <td> <?php echo get_nom_article($produits[$i]); ?> </td>
                        <td> <?php echo get_couleur($produits[$i]); ?> </td>
                        <td> <?php echo get_taille($produits[$i]); ?> </td>
                        <td> <?php echo get_prix($produits[$i]); ?> </td>
                        <td> <?php echo $quantites[$i]; ?> </td>
                        <td> <?php echo $prix[$i]; ?> </td>
                    </tr>

                    <?php
                    }
                    ?>

                    <tr>
                        <td colspan="5">TOTAL  </td>
                        <td> <?php echo $prix_total; ?> </td>
                    </tr>

                </table>

            </div>


    <div class="option_commande">

        <h2>Livraison(2000 FRS): <?php echo $donnees['livraison']; ?> </h2> 

       <?php
        $livraison = $donnees['livraison'];

       if ($donnees['livraison'] == "oui") {
            
            $prix_total += 2000;
        }

        ?>
        <h2>TOTAL : <?php echo $prix_total; ?> FRS </h2>

    </div>

    <div>
        <a <?php echo 'href="index.php?un=accueil&definitif='.$donnees['id'].'"'; ?> > <button>VALIDER DEFINITIVEMENT LA COMMANDE</button> </a>
    </div>

    <span class="texte">
        <i> A LIVRER AVANT LE... 

        <?php 

        $date1 = date("d-m-Y", strtotime($donnees['date_commande'].'+ 3 days'));

        echo $date1; ?><br>

        </br>CONTACT: 693775420</i>
    </span> 

    </div>
    </div>

    <?php
        }
                        
        $get_commande_recep_non_valider->closeCursor();

    ?>

    <div class="pagination">

    <?php  for ($i=1; $i <= $pageTotales_tnv ; $i++) { 
                
        if ($i == $pageCourante_tnv) {
            echo $i;                        
        }else{
            echo '<button><a href="index.php?un=accueil&page_tnv='.$i.'#liens_tnv"> '.$i.' </a></button>   ';
        }
    }
    ?>
    </div>   

    </article>  

    <article>
        
        <h2 id="liens_v"> Commandes valider: <?php echo get_commandetotal_valider()->rowCount(); ?></h2>

        <?php
        if ($get_commande_valider) {
        }else{
            echo'AUCUN COMMANDE valider .....';
        }
            
            while ($donnees=$get_commande_valider->fetch())
            { 
                $produits = explode(',', $donnees['id_melange']);
                $count = count($produits);
                $quantites = explode(',', $donnees['quantite']);
                $prix = explode(',',$donnees['prix_total']);
                $prix_total = array_sum($prix);

                ?>

<div class="body"> 

 <div class="affichage">
        
            <div class="commande">              
                <table>
                    <caption><b><h3> COMMANDE N°<?php echo $donnees['id']; ?> </h3></b></caption>

                <?php if (!empty($donnees['id_utilisateur'])) { ?>
                    
                    <caption> 
                        <p> <b>Nom:</b> <?php echo get_info($donnees['id'],'nom'); ?>&nbsp<b>Tel:</b> <?php if($donnees['tel'] != get_info($donnees['id'],'tel')){ 
                            echo $donnees['tel'].'/'.get_info($donnees['id'],'tel'); }else{ echo get_info($donnees['id'],'tel');} ?><br>
                        <b>Mail:</b> <?php echo get_info($donnees['id'],'mail'); ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
                        <p><b>Region:</b> <?php echo $donnees['region']; ?> &nbsp<b>Ville:</b> <?php echo $donnees['ville']; ?> 
                        &nbsp<b>Quartier:</b> <?php echo $donnees['quartier']; ?> </p>
                    </caption>

                <?php }else{ ?>    

                    <caption> 
                        <p> <b>Nom:</b> <?php echo $donnees['nom']; ?>&nbsp<b>Tel:</b> <?php echo $donnees['tel']; ?><br><b>Mail:</b> <?php echo $donnees['mail']; ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
                        <p><b>Region:</b> <?php echo $donnees['region']; ?> &nbsp<b>Ville:</b> <?php echo $donnees['ville']; ?> 
                        &nbsp<b>Quartier:</b> <?php echo $donnees['quartier']; ?> </p>
                    </caption>

                <?php } ?>    

                    <tr>
                        <th> Produits </th>
                        <th> Couleur </th>
                        <th> Taille </th>
                        <th> Prix_Unit </th>
                        <th> Quantités </th>
                        <th> prix_Total </th>
                    </tr>

                    <?php
                    for ($i=0; $i < $count ; $i++) { 
                    ?>

                    <tr>
                        <td> <?php echo get_nom_article($produits[$i]); ?> </td>
                        <td> <?php echo get_couleur($produits[$i]); ?> </td>
                        <td> <?php echo get_taille($produits[$i]); ?> </td>
                        <td> <?php echo get_prix($produits[$i]); ?> </td>
                        <td> <?php echo $quantites[$i]; ?> </td>
                        <td> <?php echo $prix[$i]; ?> </td>
                    </tr>

                    <?php
                    }
                    ?>

                    <tr>
                        <td colspan="5">TOTAL  </td>
                        <td> <?php echo $prix_total; ?> </td>
                    </tr>

                </table>

            </div>


    <div class="option_commande">

        <h2>Livraison(2000 FRS): <?php echo $donnees['livraison']; ?> </h2> 

       <?php
        $livraison = $donnees['livraison'];

       if ($donnees['livraison'] == "oui") {
            
            $prix_total += 2000;
        }

        ?>
        <h2>TOTAL : <?php echo $prix_total; ?> FRS </h2>

    </div>

    <b>Date de livraison:</b> <?php echo $donnees['date_livraison']; ?>

    </div>
    </div>

    <?php
        }
                        
        $get_commande_valider->closeCursor();
    ?>

    <div class="pagination">

    <?php  for ($i=1; $i <= $pageTotales_v ; $i++) { 
                
        if ($i == $pageCourante_v) {
            echo $i;                        
        }else{
            echo '<button><a href="index.php?un=accueil&page_v='.$i.'#liens_v"> '.$i.' </a></button>   ';
        }
    }
    ?>
    </div>

    </article>
 

</section>

<section>
    <article>
        <form method="post" action="index.php?un=accueil#up" enctype="multipart/form-data" id="up">
            <fieldset>
                <legend>Modification Info Gerqnt:</legend>

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