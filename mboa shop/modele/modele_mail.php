<?php  

function get_commande_non_valide()
{
    $db = dbconnect();

    if (!empty($_SESSION['id'])) {
       
    $req=$db->prepare('SELECT * FROM commande WHERE id_utilisateur=? AND statut="non-valider" AND id_melange=? ORDER BY date_commande DESC LIMIT 0,1');
    $req->execute(array($_SESSION['id'],$_SESSION['id_melange']));

    return $req;

    }else{

    $req=$db->prepare('SELECT * FROM commande WHERE nom=? AND statut="non-valider" AND id_melange=? ORDER BY date_commande DESC LIMIT 0,1');
    $req->execute(array($_SESSION['nom'],$_SESSION['id_melange']));

    return $req;

    }

}

function get_mail($var){

    $db = dbconnect();

    $req=$db->prepare('SELECT mail FROM utilisateurs_admin WHERE id = ?');
    $req->execute(array($var));

    $mail="";

    while ($donne = $req->fetch()) {

    $mail = $donne['mail'];

        }
    $req->closeCursor();

    return $mail;

}

function get_bout_art($info,$var){

    $db = dbconnect();

    $req=$db->prepare('SELECT B.* FROM boutique B JOIN articles A ON B.id = A.boutique WHERE A.id=?');
    $req->execute(array($var));

    $nom="";

    while ($donne = $req->fetch()) {

    $nom = $donne[$info];

        }
    $req->closeCursor();

    return $nom;

}

function get_info($info){

    $db = dbconnect();

    $req=$db->prepare('SELECT * FROM utilisateurs WHERE id=?');
    $req->execute(array($_SESSION['id']));

    while ($donne = $req->fetch()) {

    $info_r = $donne[$info];

        }
    $req->closeCursor();

    return $info_r;

}

function get_nom_id_art($info,$var)
{
    $nom = "article non present";

    $db = dbconnect();

    $rep = $db->prepare('SELECT A.nom,A.id FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
    $rep->execute(array($var));
            
    while ($donne = $rep->fetch()) {

    $nom = $donne[$info];

        }
    $rep->closeCursor();

    return $nom;
}

function get_prix($var)
{
    $db = dbconnect();

    $rep = $db->prepare('SELECT A.prix,A.solde FROM articles A JOIN melange M  ON A.id = M.id_article WHERE M.id = ? ');
    $rep->execute(array($var));
            
    while ($donne = $rep->fetch()) {

    $prix = $donne['prix'] - ($donne['prix'] * $donne['solde']);

        }
    $rep->closeCursor();

    return $prix;
}

function get_couleur($var){

    $db = dbconnect();

    $req = $db->prepare('SELECT couleur FROM melange WHERE id = ? ');
    $req->execute(array($var));

    while ($donne = $req->fetch()) {

    $couleur = $donne['couleur'];

        }
    $req->closeCursor();

    return $couleur;
}

function get_taille($var){

    $db = dbconnect();

    $req = $db->prepare('SELECT taille FROM melange WHERE id = ? ');
    $req->execute(array($var));

    while ($donne = $req->fetch()) {

    $taille = $donne['taille'];

        }
    $req->closeCursor();

    return $taille;
}