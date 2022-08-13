<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" http-equiv="refresh">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/accueil.css">
    <link rel="stylesheet" type="text/css" href="css/Compte.css">
	<title>MBOA SHOP Online : Compte</title>
</head>
<body> 

	<?php require 'header.php'; ?>

    <section>
        
        <h2>COMPTE MBOA</h2>

        <article>
        
        <h2 id="liens_nv"> Commandes en cours:</h2>

        <?php
        if ($get_commande_non_valide) {
        }else{
            echo'AUCUN COMMANDE EN COURS .....';
        }
            
            while ($donnees=$get_commande_non_valide->fetch())
            { 
                $produits = explode(',', $donnees['id_melange']);
                $count = count($produits);
                $quantites = explode(',', $donnees['quantite']);
                $prix = explode(',',$donnees['prix_total']);
                $prix_total = array_sum($prix);

                ?>

<div class="body"> 

 <div class="affichage">
        
            <div class="commande" id="liens">              
                <table>
                    <caption><b><h3> COMMANDE N°<?php echo $donnees['id']; ?> </h3></b></caption>
                    
                    <?php if (!empty($donnees['id_utilisateur'])) { ?>
                    
                        <caption> 
                            <p> <b>Nom:</b> <?php echo get_info('nom'); ?>&nbsp<b>Tel:</b> <?php if($donnees['tel'] != get_info('tel')){ 
                                echo $donnees['tel'].'/'.get_info('tel'); }else{ echo get_info('tel');} ?><br>
                            <b>Mail:</b> <?php echo get_info('mail'); ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
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
    
    <span class="texte">
        <i> VOTRE COMMANDE SERA DISPONNIBLE D'ICI LE 

        <?php 

        $date1 = date("d-m-Y", strtotime($donnees['date_commande'].'+ 3 days'));

        echo $date1; ?><br>

        <?php if ($livraison == "non") {
            echo 'Vous aurez 2 jours pour passer recuperez vos articles <br> A la " TOTAL FOUDA ( YAOUNDE )" !!!';
        }
        ?>

        </br>CONTACT: 693775420</i>
    </span> 

    </div>
    </div>

    <?php
        }
                        
        $get_commande_non_valide->closeCursor();
    ?>

    </article>

    <div class="pagination">

        <?php   for ($i=1; $i <= $pageTotales_nv ; $i++) { 
                
                    if ($i == $pageCourante_nv) {
                        echo $i;                        
                    }else{
                        echo '<button><a href="index.php?un=compte&page_nv='.$i.'#liens_nv"> '.$i.' </a></button>   ';
                    }
                }
        ?> </div>



    <article>
        
        <h2 id="liens_v"> Commandes terminer:</h2>

        <?php
        if ($get_commande_valide) {
        }else{
            echo'AUCUN COMMANDE EN COURS .....';
        }
            
            while ($donnees=$get_commande_valide->fetch())
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
                            <p> <b>Nom:</b> <?php echo get_info('nom'); ?>&nbsp<b>Tel:</b> <?php if($donnees['tel'] != get_info('tel')){ 
                                echo $donnees['tel'].'/'.get_info('tel'); }else{ echo get_info('tel');} ?><br>
                            <b>Mail:</b> <?php echo get_info('mail'); ?>&nbsp<b>Date:</b> <?php echo $donnees['date_commande']; ?> </p> 
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


    <span class="texte"><i>COMMANDE SOLDEE ... </i></span> 

    </div>
    </div>

    <?php
        }
                        
        $get_commande_valide->closeCursor();
    ?>

    </article>

    <div class="pagination">

        <?php   for ($i=1; $i <= $pageTotales_v ; $i++) { 
                
                    if ($i == $pageCourante_v) {
                        echo $i;                        
                    }else{
                        echo '<button><a href="index.php?un=compte&page_v='.$i.'#liens_v"> '.$i.' </a></button>   ';
                    }
                }
        ?> </div>

    <article>
        
        <form method="post" action="#forum" id="forum">
    
            <h2>Modifier Les Infos Du Compte:</h2>

            <div>
                Nom:<?php echo get_info('nom');?><br>
                
                Prenom:<?php echo get_info('prenom');?><br>

                <label for="pseudo_compte"> Nom/Pseudo:<?php echo $_SESSION['pseudo'];?> </label> <br> <input type="text" name="pseudo_compte" id="pseudo_compte"> <br>

                <label for="mail_compte"> Email:<?php echo $_SESSION['mail'];?> </label> <br> <input type="text" name="mail_compte" id="mail_compte"><br>

                <label for="pass_compte"> Mot de passe: </label> <br> <input type="password" name="pass_compte" id="pass_compte"><br>

                <label for="tel_compte"> Telephone:<?php echo get_info('tel');?> </label> <br> <input type="text" name="tel" id="tel"><br>

                <input type="submit" value="MODIFIER">

            </div>

        </form>

    </article>

    </section>

	<?php require 'footer.php'; ?>

</body>
</html>