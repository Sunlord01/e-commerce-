<?php  

function get_boutique()
{

	$db = dbconnect();

	$result=$db->query('SELECT * FROM boutique WHERE statut = "actif" ');

	return $result;
}

?>