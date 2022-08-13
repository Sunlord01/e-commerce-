 <?php 

 function get_articles_livres($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE livraison="oui" AND statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {
	
				$sum_t[] = intval($quantites[$count][$counte]); 

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_restant($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM articles WHERE statut="actif" ');
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_inac_restant($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM articles WHERE statut="non-actif"');
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_present($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM articles ');
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['quantite']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++; 

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_totaux($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM articles');
	
	$sum_t[1]=array();
	$sum_t[2]=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") {

		$sum_t[1][$count] = $donne['quantite']*$donne['prix'];
		$sum_t[2][$count] = $donne['vendu']*$donne['prix'];

		}
		else{
		$sum_t[1][$count] = $donne[$var];
		$sum_t[2][$count] = $donne['vendu'];
		}

		$count++; 

	}$req->closeCursor();

	$sum_t[1] = array_sum($sum_t[1]);
	$sum_t[2] = array_sum($sum_t[2]);

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_livres_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE livraison="oui" 
					AND statut IN ("valider","livrer") AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

				$sum_t[] = intval($quantites[$count][$counte]); 

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_vendu_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE statut = "valider" AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {
	
				$sum_t[] = intval($quantites[$count][$counte]); 

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_receptionner_jour($jour,$var){

	$db = dbconnect();

	$req=$db->prepare('SELECT * FROM commande WHERE livraison="non" 
					AND statut IN ("valider","livrer") AND DATEDIFF(NOW() , date_livraison) < ? 
					ORDER BY statut DESC');
	$req->execute(array($jour));
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

				$sum_t[] = intval($quantites[$count][$counte]); 

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_receptionner($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE livraison="non" 
					AND statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$sum_t[] = intval($quantites[$count][$counte]); 
			$counte++;
			
			}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;
}

function get_articles_vendu($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM articles ');
	
	$sum_t=array();
	$count=0;
	$sum=0;

	while ($donne = $req->fetch()){
				
		if ($var == "prix_total") $sum_t[$count] = $donne['vendu']*$donne['prix'];
		else $sum_t[$count] = $donne[$var];
		$count++;  

	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

}

function get_articles_total_vendu($var){

	$db = dbconnect();

	$req=$db->query('SELECT * FROM commande WHERE statut IN ("valider","livrer") ORDER BY statut DESC');
	
	$articles=array();
	$quantites=array();
	$sum_t=array();
	$count=0;
	$counte=0;
	$boutique=0;
	$sum=0;

	while ($donne = $req->fetch()){

		$articles[$count] = explode(',', $donne['id_melange']);
		$quantites[$count] = explode(',', $donne[$var]);


		foreach ($articles[$count] as $element) {

			$sum_t[] = intval($quantites[$count][$counte]); 

			$counte++;

		}

		$count++;
		$counte=0;
	}$req->closeCursor();

	$sum = array_sum($sum_t);

	return $sum;

	}




////////////////////           add_del                ///////////////////////

function get_boutique(){

	$db = dbconnect();

	 $req = $db->query('SELECT * FROM boutique');

	 return $req;
}

function add_boutique(){ 

	$db = dbconnect();

if (!empty($_FILES['image']) && !empty($_POST['nom']) && !empty($_POST['tarif'])) {

	$tmpName = $_FILES['image']['tmp_name'];
	$name = $_FILES['image']['name'];
	$size = $_FILES['image']['size'];
	$error = $_FILES['image']['error'];
	$names = explode('.', $name);
	$extension = strtolower(end($names)); 
	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];
	$maxSize = 400000;

	if ( (in_array($extension, $extensions) && $size <= $maxSize && $error == 0) ) {
		
		copy($tmpName, 'image/'.$name);
		copy($tmpName, '../image/'.$name);
		
		$req = $db->prepare('INSERT INTO boutique (nom,description,image,proprietaire,tarif,validiter,statut) 
							VALUES(:nom,:description,:image,:proprietaire,:tarif,DATE_ADD(now(), interval 1 MONTH),:statut)');
		$req->execute(array(
			'nom' => $_POST['nom'],
			'description' => $_POST['description'],
			'image' => 'image/'.$name,
			'proprietaire' => $_POST['proprietaire'],
			'tarif' => $_POST['tarif'],
			'statut' => "actif"

		));

	}else{
		echo "Mauvaise extension ou taille du fichier trop grande, une erreur c'est produite ";
	}
	
}

}

function add_user_admin(){

	$db = dbconnect();

	if (!empty($_POST['id'])) {
	
		$pass = sha1($_POST['pass']);

		$req = $db->prepare('INSERT INTO utilisateurs_admin (id,nom,mail,pass,tel1,tel2,statut) 
								VALUES(:id,:nom,:mail,:pass,:tel1,:tel2,:statut)');
		$req->execute(array(
			'id' => $_POST['id'],
			'nom' => $_POST['nom'],
			'mail' => $_POST['mail'],
			'pass' => $pass,
			'tel1' => $_POST['tel1'],
			'tel2' => $_POST['tel2'],
			'statut' => "gerant"

		));

	}elseif (!empty($_POST['statut'])){

		$pass = sha1($_POST['pass']);

		$req = $db->prepare('INSERT INTO utilisateurs_admin (id,nom,mail,pass,tel1,tel2,statut) 
								VALUES(:id,:nom,:mail,:pass,:tel1,:tel2,:statut)');
		$req->execute(array(
			'id' => $_POST['id_user'],
			'nom' => $_POST['nom'],
			'mail' => $_POST['mail'],
			'pass' => $pass,
			'tel1' => $_POST['tel1'],
			'tel2' => $_POST['tel2'],
			'statut' => $_POST['statut']

		));

	}

}

function del_boutique(){

	$db = dbconnect();

	if (!empty($_POST['id_boutique'])) {
		
		$result = $db->prepare('SELECT id FROM articles WHERE boutique = ? ');
		$result->execute(array($_POST['id_boutique']));
		
		while ($donne = $result->fetch()) {
			
			del_article($donne['id']);

		}$result->closeCursor();

		$req = $db->prepare('DELETE FROM boutique WHERE id = ? ');
		$req->execute(array($_POST['id_boutique']));

	}
}

function del_article($var)
{

	$db = dbconnect();

		$req = $db->prepare('DELETE FROM articles WHERE boutique = ? ');
		$req->execute(array($_POST['id_boutique']));

		$req = $db->prepare('DELETE FROM melange WHERE id_article = ? ');
		$req->execute(array($var));

}



///////////////            gestion           ///////////////////


function get_statut($var){

	$db = dbconnect();

		$req = $db->prepare('SELECT statut FROM boutique WHERE id = ?');
		$req->execute(array($var));
		$donne = $req->fetch();
			$statut = $donne['statut'];
		$req->closeCursor();

		return $statut;	
}

function update(){

	$db = dbconnect();

	if (!empty($_POST['statut_up']) ) {
			
		$req = $db->prepare('UPDATE boutique SET statut = ? WHERE id = ?');
		$req->execute(array($_POST['statut_up'],$_POST['id_boutique']));

		if($_POST['statut_up'] == "non-actif"){
			$req = $db->prepare('UPDATE utilisateurs_admin SET action = "bloquer" WHERE id = ?');
			$req->execute(array($_POST['id_boutique']));
		}elseif($_POST['statut_up'] == "actif"){
			$req = $db->prepare('UPDATE utilisateurs_admin SET action = "actif" WHERE id = ?');
			$req->execute(array($_POST['id_boutique']));
		}
	}

	if (!empty($_POST['tarif']) ) {
			
		$req = $db->prepare('UPDATE boutique SET tarif = ? WHERE id = ?');
		$req->execute(array($_POST['tarif'],$_POST['id_boutique']));
	}
}

function annonces_bannieres(){

	if (  !empty($_FILES['banniere0']) && empty($_FILES['banniere1']['tmp_name']) && 
			empty($_FILES['banniere2']['tmp_name']) && empty($_FILES['banniere3']['tmp_name']) ) {
		
	$tmpName = $_FILES['banniere0']['tmp_name'];
	$name = $_FILES['banniere0']['name'];
	$size = $_FILES['banniere0']['size'];
	$error = $_FILES['banniere0']['error'];
	$names = explode('.', $name);
	$extension = strtolower(end($names)); 
	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];
	
		if ( in_array($extension, $extensions) && $error == 0 ) {
			
			copy($tmpName, 'image/'.$name);
			copy($tmpName, '../image/'.$name);

			file_put_contents('../contents/bannieres.txt',"\n",FILE_APPEND);
			file_put_contents('../contents/bannieres.txt',''.$_POST['link0'].'~'.$name,FILE_APPEND);

		}
	}

	elseif ( !empty($_FILES['banniere0']) && !empty($_FILES['banniere1']) && 
				empty($_FILES['banniere2']['tmp_name']) && empty($_FILES['banniere3']['tmp_name']) ) {
		
	$tmpName = $_FILES['banniere0']['tmp_name'];      $tmpName1 = $_FILES['banniere1']['tmp_name'];
	$name = $_FILES['banniere0']['name'];             $name1 = $_FILES['banniere1']['name'];
	$size = $_FILES['banniere0']['size'];             $size1 = $_FILES['banniere1']['size'];
	$error = $_FILES['banniere0']['error'];           $error1 = $_FILES['banniere1']['error'];
	$names = explode('.', $name);             		 $names1 = explode('.', $name1);
	$extension = strtolower(end($names));            $extension1 = strtolower(end($names1)); 
	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];           

		if ( (in_array($extension, $extensions) && in_array($extension1, $extensions) && ($error&&$error1) == 0) ) {
			
			copy($tmpName, 'image/'.$name);      copy($tmpName1, 'image/'.$name1);
			copy($tmpName, '../image/'.$name);	 copy($tmpName1, '../image/'.$name1);

			file_put_contents('../contents/bannieres.txt',"\n",FILE_APPEND);
			file_put_contents('../contents/bannieres.txt',$_POST['link0'].'~'.$name.'||'.$_POST['link1'].'~'.$name1,FILE_APPEND);
		} 
	}

	elseif ( !empty($_FILES['banniere0']) && !empty($_FILES['banniere1']) && 
				!empty($_FILES['banniere2']) && empty($_FILES['banniere3']['tmp_name']) ) {
		
	$tmpName = $_FILES['banniere0']['tmp_name'];      $tmpName1 = $_FILES['banniere1']['tmp_name'];  	$tmpName2 = $_FILES['banniere2']['tmp_name'];
	$name = $_FILES['banniere0']['name'];             $name1 = $_FILES['banniere1']['name'];         	$name2 = $_FILES['banniere2']['name'];
	$size = $_FILES['banniere0']['size'];             $size1 = $_FILES['banniere1']['size'];         	$size2 = $_FILES['banniere2']['size'];
	$error = $_FILES['banniere0']['error'];           $error1 = $_FILES['banniere1']['error'];       	$error2 = $_FILES['banniere2']['error'];
	$names = explode('.', $name);             		 $names1 = explode('.', $name1);                 	$names2 = explode('.', $name2);
	$extension = strtolower(end($names));            $extension1 = strtolower(end($names1));         	$extension2 = strtolower(end($names2)); 
	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];           

		if ( (in_array($extension, $extensions) && in_array($extension1, $extensions) && ($error&&$error1) == 0) ) {
			
			copy($tmpName, 'image/'.$name);      copy($tmpName1, 'image/'.$name1);         copy($tmpName2, 'image/'.$name2);
			copy($tmpName, '../image/'.$name);	 copy($tmpName1, '../image/'.$name1);      copy($tmpName2, '../image/'.$name2);

			file_put_contents('../contents/bannieres.txt',"\n",FILE_APPEND);
			file_put_contents('../contents/bannieres.txt',$_POST['link0'].'~'.$name.'||'.$_POST['link1'].'~'.$name1.'||'.$_POST['link2'].'~'.$name2,FILE_APPEND);
		} 
	}

	elseif ( !empty($_FILES['banniere0']) && !empty($_FILES['banniere1']) && 
				!empty($_FILES['banniere2']) && !empty($_FILES['banniere3']) ) {
		
	$tmpName = $_FILES['banniere0']['tmp_name'];      $tmpName1 = $_FILES['banniere1']['tmp_name'];
	$name = $_FILES['banniere0']['name'];             $name1 = $_FILES['banniere1']['name'];
	$size = $_FILES['banniere0']['size'];             $size1 = $_FILES['banniere1']['size'];
	$error = $_FILES['banniere0']['error'];           $error1 = $_FILES['banniere1']['error'];
	$names = explode('.', $name);             		  $names1 = explode('.', $name1);
	$extension = strtolower(end($names));             $extension1 = strtolower(end($names1)); 

	$tmpName2 = $_FILES['banniere2']['tmp_name'];     $tmpName3 = $_FILES['banniere3']['tmp_name'];
	$name2 = $_FILES['banniere2']['name'];        	  $name3 = $_FILES['banniere3']['name'];
	$size2 = $_FILES['banniere2']['size'];        	  $size3 = $_FILES['banniere3']['size'];
	$error2 = $_FILES['banniere2']['error'];          $error3 = $_FILES['banniere3']['error'];
	$names2 = explode('.', $name2);                   $names3 = explode('.', $name3);
	$extension2 = strtolower(end($names2));           $extension3 = strtolower(end($names3)); 	

	$extensions = ['jpg' , 'png' , 'jpeg' , 'gif'];           

		if ( (in_array($extension, $extensions) && in_array($extension1, $extensions) && ($error&&$error1) == 0) ) {
			
			copy($tmpName, 'image/'.$name);      copy($tmpName1, 'image/'.$name1);       
			copy($tmpName, '../image/'.$name);	 copy($tmpName1, '../image/'.$name1);   

			copy($tmpName2, 'image/'.$name2);    copy($tmpName3, 'image/'.$name3); 
			copy($tmpName2, '../image/'.$name2); copy($tmpName3, '../image/'.$name3); 

			file_put_contents('../contents/bannieres.txt',"\n",FILE_APPEND);
			file_put_contents('../contents/bannieres.txt',$_POST['link0'].'~'.$name.'||'.$_POST['link1'].'~'.$name1.'||'.$_POST['link2'].'~'.$name2.'||'.$_POST['link3'].'~'.$name3,FILE_APPEND);
		} 
	}

	if (!empty($_POST['annonces'])) {
		file_put_contents('../contents/annonces.txt',"\n",FILE_APPEND);
		file_put_contents('../contents/annonces.txt',$_POST['annonces'],FILE_APPEND);
		
	}
}


///////////////////////////                forum             //////////////////////



function get_nom($nom){

	$db = dbconnect();

	$req=$db->prepare('SELECT nom FROM utilisateurs WHERE id=?');
	$req->execute(array($nom));

	$info = "";

	while ($donne = $req->fetch()) {

	$info = $donne['nom'];

		}
	$req->closeCursor();

	return $info;

}

function get_forum($depart,$articleParPage)
{

	$db = dbconnect();

	$req=$db->query('SELECT * FROM forum ORDER BY dates DESC LIMIT '.$depart.','.$articleParPage);

	return $req; 

}

function pagination() 
{
		global $articleParPage, $pageTotales, $depart, $pageCourante;

		$db = dbconnect();

	$articleParPage = 3;
	
	$articleTotalReq = $db->query('SELECT id FROM forum ');

	$articleTotals = $articleTotalReq->rowCount();
	$pageTotales = ceil($articleTotals / $articleParPage);

	if (!empty($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0) {
		
		$_SESSION['page'] = intval($_GET['page']);

		$pageCourante = $_SESSION['page'];
	}else{

		$pageCourante = 1;
	}

	$depart = ($pageCourante - 1) * $articleParPage;
}

function add_msg()
{

	$db = dbconnect();

	if (!empty($_POST['nom']) AND !empty($_POST['message'])) {
	
			$req = $db->prepare('INSERT INTO forum (id_utilisateur,titre,message) VALUES(:id,:titre,:message)');
			$req->execute(array(
				'id' => $_SESSION['id'],
				'titre' => $_POST['titre'],
				'message' => $_POST['message']
				));

	}
}
