<?php

function dbconnect()
{

	try
	{
	// On se connecte à MySQL
	$db = new PDO('mysql:host=localhost;dbname=mboa shop;charset=utf8', 'root');
	}
	catch(PDOException $e)
	{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('impossible de se connecter a la base de donnee');
	}

	return $db;

} 