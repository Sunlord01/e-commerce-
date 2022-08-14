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
        <h1>Somme livraison journaliere actuelle: <?PHP echo get_livraison_journaliere(); ?></h1>
        <h1>Somme vente journalier actuelle: <?PHP echo get_vente_journaliere(); ?></h1>
        <h1>Somme Journaliere actuelle: <?PHP echo get_vente(); ?></h1>
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


<section>VALIDATION FINALE DES COMMANDES:
    <cite>NB:cette action doit etre faite en presence de la facture et de l'argent correspondant</br>Sans quoi la dite action de doit etre effectuer.</br>LA secretaire se porte entierement responsable de toutes sanctions ...</cite>
</section>
<section id="section">


    <article>          
        
        <h2 id="liens_nv"> 
            Commandes disponible: <?php  echo get_commandetotal_non_livrer()->rowCount();   ?>
        </h2>

        <?php
        if ($get_commande_non_livrer) {
        }            
            while ($donnees=$get_commande_non_livrer->fetch())
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
                        
        $get_commande_non_livrer->closeCursor();

    ?>

    <div class="pagination">

    <?php  for ($i=1; $i <= $pageTotales_nv ; $i++) { 
                
        if ($i == $pageCourante_nv) {
            echo $i;                        
        }else{
            echo '<button><a href="index.php?un=gestion&deux=livraison&page_nv='.$i.'#liens_nv"> '.$i.' </a></button>   ';
        }
    }
    ?>
    </div>   

    </article>   

    <article>
        
        <h2 id="liens_l"> Commandes Livrees: <?php echo get_commandetotal_livrees()->rowCount(); ?></h2>

        <?php
        if ($get_commande_livrees) {
        }else{
            echo'AUCUNE COMMANDE LIVRER .....';
        }
            
            while ($donnees=$get_commande_livrees->fetch())
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
        <a <?php echo 'href="index.php?un=gestion&deux=livraison&definitif='.$donnees['id'].'"'; ?> > <button>VALIDER DEFINITIVEMENT LA COMMANDE</button> </a>
    </div>

    <div>
        <a <?php echo 'href="index.php?un=gestion&deux=livraison&annulation='.$donnees['id'].'"'; ?> > <button>ANNULER LA LIVRAISON</button> </a>
    </div>

    <span class="texte">
        <i>LIVRER LE... <?php echo $donnees['date_livraison']; ?></i>
    </span> 

    </div>
    </div>

    <?php
        }
                        
        $get_commande_livrees->closeCursor();
    ?>

    <div class="pagination">

    <?php  for ($i=1; $i <= $pageTotales_l ; $i++) { 
                
        if ($i == $pageCourante_l) {
            echo $i;                        
        }else{
            echo '<button><a href="index.php?un=gestion&deux=livraison&page_l='.$i.'#liens_l"> '.$i.' </a></button>   ';
        }
    }
    ?>
    </div>

    </article>

    <article>
        
        <h2 id="liens_en"> Commandes encours: <?php echo get_commandetotal_encour()->rowCount(); ?></h2>

        <?php
        if ($get_commande_encour) {
        }else{
            echo'AUCUN COMMANDE EN COURS .....';
        }
            
            while ($donnees=$get_commande_encour->fetch())
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

    <?php $var = datedif($donnees['date_livraison']); ?>

    <span class="texte"><i>COMMANDE EN COUR, depuis 
    <?php
        foreach ($var as $key => $value) {
            echo $value.''.$key;
         } 
    ?> </i>
    </span> 
    <cite>Au dela de 30min, </br> la secretaire est prier de contacter le livreur</br> et en cas de necessiter de DELAISSER la commande...</cite>

    <div>
        <a <?php echo 'href="index.php?un=gestion&deux=livraison&delaisser='.$donnees['id'].'"'; ?> > <button>DELAISSER!!!</button> </a>
    </div>

    </div>
    </div>

    <?php
        }
                        
        $get_commande_encour->closeCursor();
    ?>

    <div class="pagination">

    <?php  for ($i=1; $i <= $pageTotales_en ; $i++) { 
                
        if ($i == $pageCourante_en) {
            echo $i;                        
        }else{
            echo '<button><a href="index.php?un=gestion&deux=livraison&page_en='.$i.'#liens_en"> '.$i.' </a></button>   ';
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
            echo '<button><a href="index.php?un=gestion&deux=livraison&page_v='.$i.'#liens_v"> '.$i.' </a></button>   ';
        }
    }
    ?>
    </div>

    </article>


</section>



<?php require 'footer.php'; ?>

</body>
</html>