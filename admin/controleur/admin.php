 <?php 

 require 'modele/modele_admin.php';

if (!empty($_GET['un']) AND $_GET['un'] == 'accueil') {

	require 'vue/vue_accueil_admin.php';
}

elseif (!empty($_GET['un']) AND $_GET['un'] == 'add_del') {
	
	add_boutique();
	add_user_admin();
	del_boutique(); 
	$boutique = get_boutique();

	require 'vue/vue_add_del_admin.php';
}

elseif (!empty($_GET['un']) AND $_GET['un'] == 'gestion') {

	update();
	annonces_bannieres();

	$boutique = get_boutique();
	
	require 'vue/vue_gestion_admin.php';
}

elseif (!empty($_GET['un']) AND $_GET['un'] == 'forum') {

	pagination();
	$msg = get_forum($depart,$articleParPage);
	
	require 'vue/vue_forum_admin.php';
}

elseif (!empty($_GET['un']) AND $_GET['un'] == 'deconnexion') {

	deconnexion();
}


else{

	require 'vue/vue_accueil_admin.php';
}