<?php
require 'modele/modele_article.php';

if (!empty($_POST['id_article'])) {
	 $_SESSION['id_article'] = $_POST['id_article']; 
}elseif (!empty($_GET['id_article'])){
	 $_SESSION['id_article'] = $_GET['id_article']; 
}

if (empty($_SESSION['id_article'])) {
	header('location:index.php?un=accueil');
}

add_like();
del_like();

$article = get_article();

require 'vue/vue_article.php';
?>    