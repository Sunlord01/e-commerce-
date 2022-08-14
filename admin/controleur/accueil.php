<?php

if ($_SESSION['statut'] == "gerant"){

require 'modele/modele_accueil.php';

auto_delaisse();
update();
update_info();

 require 'vue/vue_accueil_gerant.php';

}
 



elseif ($_SESSION['statut'] == "secretaire"){

    if (empty($_GET['deux'])) {

        require 'modele/modele_accueil.php';
        
        auto_delaisse();
        validation_definitive();
        update_info();
           
        paginationrecep_non_valider();
        $get_commande_recep_non_valider = get_commande_recep_non_valider( $depart_tnv,$articleParPage_tnv );

        paginationrecep_valider();
        $get_commande_recep_valider = get_commande_recep_valider( $depart_tv,$articleParPage_tv );

        pagination_valider();
        $get_commande_valider = get_commande_valider( $depart_v,$articleParPage_v );

         require 'vue/vue_accueil_secretaire.php';
    }
    elseif (!empty($_GET['deux']) && $_GET['deux'] == "livraison") {


        require 'modele/modele_secretaire.php';
        
        update_info();
        auto_delaisse();

        pagination_non_livrer();
        $get_commande_non_livrer = get_commande_non_livrer($depart_nv,$articleParPage_nv);

        pagination_livrees();
        $get_commande_livrees = get_commande_livrees($depart_l,$articleParPage_l);

        pagination_encour();
        $get_commande_encour = get_commande_encour($depart_en,$articleParPage_en);

        pagination_valider();
        $get_commande_valider = get_commande_valider( $depart_v,$articleParPage_v );

        require 'vue/vue_secretaire_livraison.php';
    }

    elseif (!empty($_GET['deux']) && $_GET['deux'] == "livreur") {

        require 'modele/modele_secretaire.php';
    
        $get_livreur = get_livreur();

        require 'vue/vue_secretaire_livreur.php';
    }
}

elseif ($_SESSION['statut'] == "livreur"){

    require 'modele/modele_accueil.php';

    auto_delaisse();
	prendre();
	delaisser();
	valider();

    if( !get_commande_retard()->fetch() ){
    pagination_non_livrer();
     $get_commande_non_livrer = get_commande_non_livrer( $depart_nv,$articleParPage_nv );
    }else{
     $get_commande_non_livrer = get_commande_retard();
    }

     $get_commande_prise = get_commande_prise();

     require 'vue/vue_accueil_livreur.php';

}


else{
    header('location:index.php?un=connexion');
}
	
?> 