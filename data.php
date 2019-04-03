<?php
session_start();

	//echo $_SERVER["REQUEST_URI"] . "<br />";

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/modele.php"; 

	$data["action"] = valider("action");
	$data["status"] = false;

	// si on a une action, on devrait avoir un message classique
	$data["feedback"] = "action en échec";


	switch($data["action"])
	{

		// Users //////////////////////////////////////////////////
/*
http://localhost/ctp_2019/data.php?action=connexion&pseudo=toto&passe=toto
{"action":"connexion","status":true,"feedback":"connect\u00e9","id":"1","pseudo":"toto","initiales":"TB","fullname":"Thomas Bou"}

http://localhost/ctp_2019/data.php?action=logout
{"action":"logout","status":false,"feedback":"d\u00e9connect\u00e9"}

http://localhost/ctp_2019/data.php?action=getUsers
{"action":"getUsers","status":true,"feedback":"ok","users":[{"id":"1","pseudo":"toto","initiales":"TB"}]}
*/
		case 'connexion' :			
			if ($pseudo = valider("pseudo")) 
			if ($passe = valider("passe")) {
				if ($data["id"] = validerUser($pseudo, $passe)) { 
					$dataU = getUser($data["id"]); 	
					$data["pseudo"] = $pseudo; 
					$data["initiales"] = $dataU[0]["initiales"]; 
					$data["fullname"] = $dataU[0]["fullname"]; 
					$data["status"] = true;
					$data["feedback"] = "connecté";


					$_SESSION["connecte"] = true; 
					$_SESSION["fullname"] = $data["fullname"];
					$_SESSION["initiales"] = $data["initiales"];
					$_SESSION["id"] = $data["id"];
					$_SESSION["pseudo"] = $pseudo;
				}
			}
		break;

		case 'logout' : case 'Logout' : 
			session_destroy();
			$data["feedback"] = "déconnecté";
		break; 

		case 'getUsers' : 
			$data["users"] = getUsers(); 
			$data["status"] = true;
			$data["feedback"] = "ok";
		break; 

		// Boards //////////////////////////////////////////////////
/*
http://localhost/ctp_2019/data.php?action=getBoards
{"action":"getBoards","status":true,"feedback":"ok","boards":[]}

http://localhost/ctp_2019/data.php?action=mkBoard&label=Board%201
{"action":"mkBoard","status":true,"feedback":"ok","boards":[{"id":"1","label":"Board 1","ordre":"1"}]}

http://localhost/ctp_2019/data.php?action=getBoards
{"action":"getBoards","status":true,"feedback":"ok","boards":[{"id":"1","label":"Board 1","ordre":"1"}]}

http://localhost/ctp_2019/data.php?action=majBoard&id=1&label=Board%20modifie
{"action":"majBoard","status":true,"feedback":"ok","boards":[{"id":"1","label":"Board modifie","ordre":"1"}]}
*/
		case 'mkBoard' : 
			if ($label = valider("label")) {
				mkBoard($label); 
				$data["boards"] = getBoards();
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
			
		break; 

		case 'getBoards' : 
			$data["boards"] = getBoards();
			$data["status"] = true;
			$data["feedback"] = "ok";
		break; 

		case 'majBoard' : 
			if ($id = valider("id"))
			if ($label = valider("label")) {
				majBoard($id,$label); 
				$data["boards"] = getBoards();
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break; 

		// Colonnes //////////////////////////////////////////////////
/*
http://localhost/ctp_2019/data.php?action=getCols&idBoard=1
{"action":"getCols","status":true,"feedback":"ok","colonnes":[]}

http://localhost/ctp_2019/data.php?action=mkCol&idBoard=1&label=TODO
{"action":"mkCol","status":true,"feedback":"ok","colonnes":[{"id":"1","label":"TODO","ordre":"1","idBoard":"1"}]}

http://localhost/ctp_2019/data.php?action=majCol&id=1&label=A%20faire
{"action":"majCol","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getCols&idBoard=1
{"action":"getCols","status":true,"feedback":"ok","colonnes":[{"id":"1","label":"A faire","ordre":"1","idBoard":"1"}]}

http://localhost/ctp_2019/data.php?action=delCol&id=1
{"action":"delCol","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getCols&idBoard=1
{"action":"getCols","status":true,"feedback":"ok","colonnes":[]}
*/
		case 'mkCol' : 
			if ($idBoard = valider("idBoard"))
			if ($label = valider("label")) {
				mkCol($label, $idBoard);
				$data["colonnes"] = getCols($idBoard);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
			
		break; 

		case 'getCols' : 
			if ($idBoard = valider("idBoard")) {
				$data["colonnes"] = getCols($idBoard);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
		break; 

		case 'majCol' : 
			if ($id = valider("id"))
			if ($label = valider("label")) {
				majCol($id,$label); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break; 

		case 'delCol' : 
			if ($id = valider("id")) {
				delCol($id); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break; 


		// Postits //////////////////////////////////////////////////
/*
http://localhost/ctp_2019/data.php?action=mkPostit&idBoard=1&numColonne=1&label=Colonne%201
{"action":"mkPostit","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"1","idBoard":"1","label":"Colonne 1","avancement":"0"}]}

http://localhost/ctp_2019/data.php?action=getPostits&idBoard=1
{"action":"getPostits","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"1","idBoard":"1","label":"Colonne 1","avancement":"0"}]}

http://localhost/ctp_2019/data.php?action=getColPostits&idBoard=1&numColonne=1
{"action":"getColPostits","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"1","idBoard":"1","label":"Colonne 1","avancement":"0"}]}

http://localhost/ctp_2019/data.php?action=getColPostits&idBoard=1&numColonne=2
{"action":"getColPostits","status":true,"feedback":"ok","postits":[]}

http://localhost/ctp_2019/data.php?action=majColPostit&id=1&numColonne=2
{"action":"majColPostit","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getColPostits&idBoard=1&numColonne=2
{"action":"getColPostits","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"2","idBoard":"1","label":"Colonne 1","avancement":"0"}]}

http://localhost/ctp_2019/data.php?action=majAvancementPostit&id=1&avancement=40
{"action":"majAvancementPostit","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getColPostits&idBoard=1&numColonne=2
{"action":"getColPostits","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"2","idBoard":"1","label":"Colonne 1","avancement":"40"}]}

http://localhost/ctp_2019/data.php?action=majLabelPostit&id=1&label=Nouveau
{"action":"majLabelPostit","status":true,"feedback":"ok"}

{"action":"getColPostits","status":true,"feedback":"ok","postits":[{"id":"1","numColonne":"2","idBoard":"1","label":"Nouveau","avancement":"40"}]}

http://localhost/ctp_2019/data.php?action=delPostit&id=1
{"action":"delPostit","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getColPostits&idBoard=1&numColonne=2
{"action":"getColPostits","status":true,"feedback":"ok","postits":[]}
*/

		case 'mkPostit' : 
			if ($idBoard = valider("idBoard"))
			if ($numColonne = valider("numColonne"))
			if ($label = valider("label")) {
				mkPostit($idBoard, $label,0,$numColonne); 
				$data["postits"] = getPostits($idBoard);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}	
		break; 

		case 'getPostits' : 
			if ($idBoard = valider("idBoard")) {
				$data["postits"] = getPostits($idBoard);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
		break; 

		case 'getColPostits' : 
			if ($idBoard = valider("idBoard"))
			if ($numColonne = valider("numColonne")) {
				$data["postits"] = getPostits($idBoard,$numColonne);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
		break; 

		case 'delPostit' : 
			if ($id = valider("id")) {
				delPostit($id); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break;

		case 'majAvancementPostit' : 
			if ($id = valider("id"))
			if ($avancement = valider("avancement")) {
				majAvancementPostit($id, $avancement);  
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break;

		case 'majLabelPostit' : 
			if ($id = valider("id"))
			if ($label = valider("label")) {
				majLabelPostit($id, $label); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break;

		case 'majColPostit' : 
			if ($id = valider("id"))
			if ($numColonne = valider("numColonne")) {
				majColPostit($id, $numColonne); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}			
		break;

/*
http://localhost/ctp_2019/data.php?action=getMarqueurs&idPostit=1
{"action":"getMarqueurs","status":true,"feedback":"ok","marqueurs":[]}

http://localhost/ctp_2019/data.php?action=mkMarqueur&idPostit=1&type=user&valeur=1
{"action":"mkMarqueur","status":true,"feedback":"ok","marqueurs":[{"id":"1","type":"user","valeur":"1","idPostit":"1"}]}

http://localhost/ctp_2019/data.php?action=getMarqueurs&idPostit=1
{"action":"getMarqueurs","status":true,"feedback":"ok","marqueurs":[{"id":"1","type":"user","valeur":"1","idPostit":"1"}]}

http://localhost/ctp_2019/data.php?action=delMarqueur&id=1
{"action":"delMarqueur","status":true,"feedback":"ok"}

http://localhost/ctp_2019/data.php?action=getMarqueurs&idPostit=1
{"action":"getMarqueurs","status":true,"feedback":"ok","marqueurs":[]}
*/

		case 'mkMarqueur' : 
			if ($idPostit = valider("idPostit"))
			if ($type = valider("type"))
			if ($valeur = valider("valeur")) {
				mkMarqueur($idPostit, $type,$valeur);
				$data["marqueurs"] = getMarqueurs($idPostit);
				$data["status"] = true;
				$data["feedback"] = "ok";
			}	
		break; 

		case 'delMarqueur' : 
			if ($id = valider("id")) {
				delMarqueur($id); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
		break; 

		case 'getMarqueurs' : 
			if ($idPostit = valider("idPostit")) {
				$data["marqueurs"] = getMarqueurs($idPostit); 
				$data["status"] = true;
				$data["feedback"] = "ok";
			}
		break; 


		// Defaut //////////////////////////////////////////////////
		default : 				
			$data["action"] = "default";
			$data["status"] = false;
			$data["feedback"] = "action inconnue";
	}

		
	 
	echo json_encode($data);

?>










