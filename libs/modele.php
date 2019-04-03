<?php
include_once("maLibSQL.pdo.php"); 
// définit les fonctions SQLSelect, SQLUpdate... 

// USERS ////////////////////////////////////////////////////////////////////////

function validerUser($pseudo, $passe){
	$SQL = "SELECT id FROM users WHERE pseudo='$pseudo' AND passe='$passe'";
	return SQLGetChamp($SQL);
}

function getUser($idUser) {
	$SQL = "SELECT pseudo,initiales,fullname FROM users WHERE id='$idUser'";
	return parcoursRs(SQLSelect($SQL));
}

function getUsers(){
	// Cette fonction crée un nouvel utilisateur et renvoie l'identifiant de l'utilisateur créé
	$SQL = "SELECT id,pseudo,initiales FROM users";
	return parcoursRs(SQLSelect($SQL));
}

// BOARDS ////////////////////////////////////////////////////////////////////////

function mkBoard($label)
{
	$SQL = "SELECT MAX(ordre) FROM boards"; 
	$max = SQLGetChamp($SQL)+1;
	$SQL = "INSERT INTO boards(label,ordre) VALUES('$label', $max)";
	return SQLInsert($SQL);
}

function getBoards()
{
	// liste tous les boards disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM boards ORDER BY ordre ASC"; 
	return parcoursRs(SQLSelect($SQL));
}

function majBoard($id,$label)
{
	$SQL = "UPDATE boards SET label='$label' WHERE id='$id'";
	return SQLUpdate($SQL);
}


// COLONNES ////////////////////////////////////////////////////////////////////////
function mkCol($label, $idBoard)
{
	$SQL = "SELECT MAX(ordre) FROM colonnes WHERE idBoard='$idBoard'"; 
	$max = SQLGetChamp($SQL)+1;
	$SQL = "INSERT INTO colonnes(label,ordre, idBoard) VALUES('$label', $max,'$idBoard')";
	return SQLInsert($SQL);
}

function getCols($idBoard)
{
	// liste tous les boards disponibles, triés par valeur du champ 'ordre' croissant
	$SQL = "SELECT * FROM colonnes WHERE idBoard='$idBoard' ORDER BY ordre ASC"; 
	return parcoursRs(SQLSelect($SQL));
}

function majCol($id,$label)
{
	$SQL = "UPDATE colonnes SET label='$label' WHERE id='$id'";
	return SQLUpdate($SQL);
}

function delCol($id)
{
	$SQL = "DELETE FROM colonnes WHERE id='$id'";
	return SQLUpdate($SQL);
}

// POSTS-ITS ////////////////////////////////////////////////////////////////////////

function getPostits($idBoard,$numColonne=false)
{
	$SQL = "SELECT * FROM postits WHERE idBoard='$idBoard'"; 
	if ($numColonne) $SQL .= " AND numColonne='$numColonne'";
	return parcoursRs(SQLSelect($SQL));
}

function delPostit($id)
{	
	$SQL = "DELETE FROM postits WHERE id='$id'"; 
	SQLDelete($SQL);
	
	$SQL = "DELETE FROM marqueurs WHERE idPostit='$id'"; 
	SQLDelete($SQL);
}

function mkPostit($idBoard, $label="Nouveau Post-It",$avancement=0, $numColonne=1)
{
	$SQL = "INSERT INTO postits(idBoard, label, avancement, numColonne) VALUES('$idBoard', '$label', '$avancement', '$numColonne')"; 
	return SQLInsert($SQL);
}

function majLabelPostit($id, $label)
{
	$SQL = "UPDATE postits SET label='$label' WHERE id='$id'"; 
	return SQLUpdate($SQL);
}

function majAvancementPostit($id, $avancement)
{
	$SQL = "UPDATE postits SET avancement='$avancement' WHERE id='$id'"; 
	return SQLUpdate($SQL);
}

function majColPostit($id, $numColonne)
{
	$SQL = "UPDATE postits SET numColonne='$numColonne' WHERE id='$id'"; 
	return SQLUpdate($SQL);
}

// MARQUEURS ////////////////////////////////////////////////////////////////////////


function getMarqueurs($idPostit)
{
	$SQL = "SELECT * FROM marqueurs WHERE idPostit='$idPostit'";	
	return parcoursRs(SQLSelect($SQL));
}

function delMarqueur($id)
{	
	$SQL = "DELETE FROM marqueurs WHERE idPostit='$id'"; 
	SQLDelete($SQL);
}

function mkMarqueur($idPostit, $type,$valeur)
{
	$SQL = "INSERT INTO marqueurs(idPostit, type, valeur) VALUES('$idPostit', '$type', '$valeur')"; 
	return SQLInsert($SQL);
}


?>
