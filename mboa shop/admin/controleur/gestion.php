<?php

require 'modele/modele_gestion.php';

update();

if ( !empty($_POST['recherche'] ) ) {
    
    $_SESSION['recherche'] =  htmlspecialchars($_POST['recherche']) ;
}

if ( !empty($_POST['statut'] ) ) {
    
    $_SESSION['statut_article'] =  htmlspecialchars($_POST['statut']) ;
}

if (empty($_POST['recherche']) && empty($_POST['statut']) && empty($_GET['page_s']) ) {
    
    pagination();
    $articles = get_article($depart,$articleParPage);

}elseif (!empty($_POST['statut']) | !empty($_GET['page_s'])) {
    
    pagination_statut($_SESSION['statut_article']);
    $articles = get_article_statut($_SESSION['statut_article'],$depart_s,$articleParPage_s);

}elseif (!empty($_SESSION['recherche'])) {
   
   $articles = get_article_recherche();
}

require 'vue/vue_gestion.php';

?> 