 <?php 

 $destinataires = array();

 ob_start(); ?>
 <!DOCTYPE html>
 <html>
 <head>
     <meta charset="utf-8" http-equiv="refresh">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" type="text/css" href="css/mail.css">
     <title></title>
 </head>
 <body>
 
<div class="body"> 

<h1 class="logo"><a href="index.php?un=accueil">MBOA SHOP Online...</a></h1>

 <article>
      
        <?php while ($donnees=$get_commande_non_valide->fetch())
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

                    <?php  for ($i=0; $i < $count ; $i++) { 

                        if (!in_array(get_mail( get_bout_art( "id",get_nom_id_art("id",$produits[$i]) ) ), $destinataires)){ $destinataires[] = get_mail(get_bout_art("id",$produits[$i])); } 
                      ?>

                    <tr>
                        <td> <?php echo get_nom_id_art("nom",$produits[$i]); ?> <h5> <?php echo get_bout_art("nom",get_nom_id_art("id",$produits[$i]) ); ?> </h5> </td>
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
</body>
</html>

<?php $message = ob_get_clean();

$destinataires[] = $_SESSION['mail']; // adresse mail du destinataire
$destinataires = implode(',', $destinataires);
$sujet = "Commande MBOA SHOP"; // sujet du mail
$header = "From: mboashop@gmail.com\r\n"; 
$header .= "Disposition-Notification-To:mboashop@gmail.com"; // c'est ici que l'on ajoute la directive

//mail($destinataires, $sujet, $message, $header);

header('location:index.php?un=panier&mail=ok#liens');

?>