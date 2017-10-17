<?php

function lstGaPa(){
	include('connexionPG.php');
	$reponse = $bdd->query('SELECT distinct(ga) FROM pa ORDER BY ga');
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}
//liste les acteurs des actions
function lstAffecteActions(){
	include('connexionPG.php');
	$reponse = $bdd->query('SELECT distinct(affecte) AS nom FROM actions ORDER BY affecte');
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}


//print_r(lstGaPa2());
//echo json_encode(lstGaPa2());
function lstGaPaStatutZero(){
	$result=array();
	$v=array();
	$lstGa=lstGaPa();
	$lstStatut=array('NOUVEAU'=>0, 'SOUMIS'=>0, 'NOTIFIE'=>0, 'APPROUVE'=>0);
	foreach ($lstGa as $ga) {
		$result[$ga['ga']]=$lstStatut;
	}
	return $result;
}

function lstGaEchZero(){
	$result=array();
	$v=array();
	$lstGa=lstGaPa();
	//$lstStatut=array('retard'=>0, '1m'=>0, '3m'=>0, 'plus3'=>0);
	foreach ($lstGa as $ga) {
		$v['ga']=$ga['ga'];
		$v['retard']=0;
		$v['m1']=0;
		$v['m3']=0;
		$v['plus3']=0;
		array_push($result, $v);
	}
	return $result;
}
//print_r(lstGaEchZero()[1]['ga']);

//liste les pa pour chaque GA
function lstPaGa($ga) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) ORDER BY echeance');
	$reponse->execute(array($ga));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les pa pour un mot clé
function lstPaMotCle($mot) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM pa WHERE (libelle LIKE ?) ORDER BY echeance');
	$reponse->execute(array("%".$mot."%"));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les pa pour chaque GA, pour une écheance donnée
function lstPaGaEch($ga, $nbMois) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance < ?) ORDER BY echeance');
		$reponse->execute(array($ga, $today));}
	elseif ($nbMois==1)	{
		$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
		$reponse->execute(array($ga, $today, $ech));	}
	elseif ($nbMois==3)	{
			$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
			$reponse->execute(array($ga, $oneMonth, $ech));	}
	else {
		$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance > ?) ORDER BY echeance');
		$reponse->execute(array($ga, $threeMonth));
	}
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les pa pour chaque GA, pour une écheance donnée
function lstPaMotCleEch($mot, $nbMois) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM pa WHERE (libelle LIKE ?) AND (echeance < ?) ORDER BY echeance');
		$reponse->execute(array("%".$mot."%", $today));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT * FROM pa WHERE (libelle LIKE ?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
			$reponse->execute(array("%".$mot."%", $today, $ech));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT * FROM pa WHERE (libelle LIKE ?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
				$reponse->execute(array("%".$mot."%", $oneMonth, $ech));	}
				else {
					$reponse = $bdd->prepare('SELECT * FROM pa WHERE (libelle LIKE ?) AND (echeance > ?) ORDER BY echeance');
					$reponse->execute(array("%".$mot."%", $threeMonth));
				}
				$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
				$reponse->closeCursor();
				return $lst;
}

//liste les pa pour chaque GA, pour une écheance donnée et pour un statut donné
function lstPaGaEchStatut($ga, $nbMois, $stat) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance < ?) AND (statut = ?) ORDER BY echeance');
		$reponse->execute(array($ga, $today, $stat));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance BETWEEN ? and ?) AND (statut = ?) ORDER BY echeance');
			$reponse->execute(array($ga, $today, $ech, $stat));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance BETWEEN ? and ?) AND (statut = ?) ORDER BY echeance');
				$reponse->execute(array($ga, $oneMonth, $ech, $stat));	}
				else {
					$reponse = $bdd->prepare('SELECT * FROM pa WHERE (ga=?) AND (echeance > ?) AND (statut = ?) ORDER BY echeance');
					$reponse->execute(array($ga, $threeMonth, $stat));
				}
				$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
				$reponse->closeCursor();
				return $lst;
}

//liste les actions pour chaque GA, pour une écheance donnée
function lstActionsGaEch($ga, $nbMois) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance < ?)  AND (active=TRUE) ORDER BY echeance');
		$reponse->execute(array($ga, $today));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance BETWEEN ? and ?) AND (active=TRUE) ORDER BY echeance');
			$reponse->execute(array($ga, $today, $ech));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance BETWEEN ? and ?) AND (active=TRUE) ORDER BY echeance');
				$reponse->execute(array($ga, $oneMonth, $ech));	}
				else {
					$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance > ?)  AND (active=TRUE) ORDER BY echeance');
					$reponse->execute(array($ga, $threeMonth));
				}
				$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
				$reponse->closeCursor();
				return $lst;
}

//liste les actions pour chaque GA, pour une écheance donnée et pour un statut donné
function lstActionsGaEchStatut($ga, $nbMois, $stat) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance < ?) AND (statut = ?) ORDER BY echeance');
		$reponse->execute(array($ga, $today, $stat));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance BETWEEN ? and ?) AND (statut = ?) ORDER BY echeance');
			$reponse->execute(array($ga, $today, $ech, $stat));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance BETWEEN ? and ?) AND (statut = ?) ORDER BY echeance');
				$reponse->execute(array($ga, $oneMonth, $ech, $stat));	}
				else {
					$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) AND (echeance > ?) AND (statut = ?) ORDER BY echeance');
					$reponse->execute(array($ga, $threeMonth, $stat));
				}
				$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
				$reponse->closeCursor();
				return $lst;
}

//liste les actions pour une personne, pour une écheance donnée et pour un statut donné
function lstActionsAffecteesEch($ga, $nbMois) {
	include('connexionPG.php');
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('SELECT * FROM actions WHERE (affecte=?) AND (echeance < ?) ORDER BY echeance');
		$reponse->execute(array($ga, $today));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT * FROM actions WHERE (affecte=?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
			$reponse->execute(array($ga, $today, $ech));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT * FROM actions WHERE (affecte=?) AND (echeance BETWEEN ? and ?) ORDER BY echeance');
				$reponse->execute(array($ga, $oneMonth, $ech));	}
				else {
					$reponse = $bdd->prepare('SELECT * FROM actions WHERE (affecte=?) AND (echeance > ?)ORDER BY echeance');
					$reponse->execute(array($ga, $threeMonth));
				}
				$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
				$reponse->closeCursor();
				return $lst;
}



//liste les actions pour chaque GA
function lstActionsGa($ga) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM actions WHERE (gaprimaire=?) ORDER BY echeance');
	$reponse->execute(array($ga));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}
//liste les actions pour chaque PA
function lstActionsPa($pa) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM actions WHERE (pa=?) ORDER BY num');
	$reponse->execute(array($pa));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les notes pour chaque PA
function lstNotesPa($pa) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM notes WHERE (pa=?)');
	$reponse->execute(array($pa));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les n derniers pa crées
function lstDerniersPa($nb) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM pa ORDER BY creation DESC LIMIT ?');
	$reponse->execute(array($nb));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

//liste les n actions les plus en retard
function lstActionsRetard($nb) {
	include('connexionPG.php');
	$reponse = $bdd->prepare('SELECT * FROM actions WHERE (active=TRUE) ORDER BY echeance ASC LIMIT ?');
	$reponse->execute(array($nb));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

