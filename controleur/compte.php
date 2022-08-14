<?php
require 'modele/modele_compte.php';

annul_commande();

modif_compte();
 
pagination_non_valide();
$get_commande_non_valide = get_commande_non_valide( $depart_nv,$articleParPage_nv );

pagination_valide();
$get_commande_valide = get_commande_valide( $depart_v,$articleParPage_v );

require 'vue/vue_compte.php';
?> 