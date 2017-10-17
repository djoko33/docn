<?php
//include('list.php');
//Array ( [0] => Array ( [ga] => PAAUTPI [nb] => 8 )
//[{"ga":"PAAUTPI","nb":"8"}
function countPaParGa($statut){
	include('connexionPG.php');
	$reponse = $bdd->prepare('select ga, COUNT(ga) AS nb FROM pa WHERE (statut=?) GROUP BY ga ORDER BY ga');
	$reponse->execute(array($statut));
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}


function countPaParGaParStatut(){
	include('connexionPG.php');
	$reponse = $bdd->query('select ga, statut, COUNT(statut) AS nb FROM pa GROUP BY ga, statut ORDER BY ga');
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}

function countPaParEch($nbMois){
	include('connexionPG.php');
	$lst=array();
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonths = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	$ech = date("Y-m-d", mktime(0, 0, 0, date("m")+(int)$nbMois, date("d"), date("Y")));
	if ($nbMois==0) {
		$reponse = $bdd->prepare('select ga, COUNT(ga) AS nb FROM pa WHERE (echeance < ?) GROUP BY ga ORDER BY ga');
		$reponse->execute(array($today));}
		elseif ($nbMois==1)	{
			$reponse = $bdd->prepare('SELECT ga, COUNT(ga) AS nb FROM pa WHERE (echeance BETWEEN ? and ?) GROUP BY ga ORDER BY ga');
			$reponse->execute(array($today, $ech));	}
			elseif ($nbMois==3)	{
				$reponse = $bdd->prepare('SELECT ga, COUNT(ga) AS nb FROM pa WHERE (echeance BETWEEN ? and ?) GROUP BY ga ORDER BY ga');
				$reponse->execute(array($oneMonth, $ech));	}
				else {
					$reponse = $bdd->prepare('SELECT ga, COUNT(ga) AS nb FROM pa WHERE (echeance > ?) GROUP BY ga ORDER BY ga');
					$reponse->execute(array($threeMonths));
				}
				while ($donnees = $reponse->fetch())
				{
					$lst[$donnees['ga']]=$donnees['nb'];
				}

				$reponse->closeCursor();
				return $lst;
}

//indicateurs globaux
//PA
function countPaParEchGlob(){
	include('connexionPG.php');
	$lst=array();
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonths = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	//nb pa total
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE statut NOT IN (?, ?)');
	$reponse->execute(array('ANNULE', 'CLOTURE'));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['tot']=$l[0]['nb'];
	//nb pa en retard
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE (echeance < ?) AND (statut NOT IN (?, ?))');
	$reponse->execute(array($today, 'ANNULE', 'CLOTURE'));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['retard']=$l[0]['nb'];
	//nb pa d'ici 1 mois
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE (echeance BETWEEN ? and ?) AND (statut NOT IN (?, ?))');
	$reponse->execute(array($today, $oneMonth, 'ANNULE', 'CLOTURE'));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['m1']=$l[0]['nb'];
	//nb pa d'ici 3 mois et plus de 1 mois
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE (echeance BETWEEN ? and ?) AND (statut NOT IN (?, ?))');
	$reponse->execute(array($oneMonth, $threeMonths, 'ANNULE', 'CLOTURE'));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['m3']=$l[0]['nb'];
	//nb pa dont l'échéance est supérieure à 3 mois
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE (echeance > ?) AND (statut NOT IN (?, ?))');
	$reponse->execute(array($threeMonths, 'ANNULE', 'CLOTURE'));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['plus3']=$l[0]['nb'];
	
	return $lst;
}

//Actions
function countActionsParEchGlob(){
	include('connexionPG.php');
	$lst=array();
	$today = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
	$oneMonth = date("Y-m-d", mktime(0, 0, 0, date("m")+1, date("d"), date("Y")));
	$threeMonths = date("Y-m-d", mktime(0, 0, 0, date("m")+3, date("d"), date("Y")));
	//nb pa total
	$reponse = $bdd->query('select COUNT(num) AS nb FROM actions WHERE (active = TRUE)');
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['tot']=$l[0]['nb'];
	//nb pa en retard
	$reponse = $bdd->prepare('select COUNT(num) AS nb FROM actions WHERE (echeance < ?) AND (active = TRUE)');
	$reponse->execute(array($today));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['retard']=$l[0]['nb'];
	//nb pa d'ici 1 mois
	$reponse = $bdd->prepare('select COUNT(num) AS nb FROM actions WHERE (echeance BETWEEN ? and ?) AND (active = TRUE)');
	$reponse->execute(array($today, $oneMonth));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['m1']=$l[0]['nb'];
	//nb pa d'ici 3 mois et plus de 1 mois
	$reponse = $bdd->prepare('select COUNT(num) AS nb FROM actions WHERE (echeance BETWEEN ? and ?) AND (active = TRUE)');
	$reponse->execute(array($oneMonth, $threeMonths));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['m3']=$l[0]['nb'];
	//nb pa dont l'échéance est supérieure à 3 mois
	$reponse = $bdd->prepare('select COUNT(num) AS nb FROM actions WHERE (echeance > ?) AND (active = TRUE)');
	$reponse->execute(array($threeMonths));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['plus3']=$l[0]['nb'];
	return $lst;
}

//Analyse Impact
function countAnalyseImpact(){
	include('connexionPG.php');
	$lst=array();
	$twoMonths = date("Y-m-d", mktime(0, 0, 0, date("m")-2, date("d"), date("Y")));
	//nb analyse impact en retard total
	$reponse = $bdd->prepare('select COUNT(pa) AS nb FROM pa WHERE statut IN (?, ?, ?) AND (creation < ?)');
	$reponse->execute(array('NOUVEAU', 'SOUMIS', 'NOTIFIE', $twoMonths));
	$l=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$lst['tot']=$l[0]['nb'];	
	return $lst;
}

function countPaParEchTot(){
	include_once('list.php');
	$zero = lstGaEchZero();
	$retard = countPaParEch(0);
	$oneMonth = countPaParEch(1);
	$threeMonths = countPaParEch(3);
	$sup =  countPaParEch(6);
	$l=array();
	for ($i = 0; $i < count($zero); $i++) {
		if(isset($retard[$zero[$i]['ga']])){
			$zero[$i]['retard']=$retard[$zero[$i]['ga']];}
		if(isset($oneMonth[$zero[$i]['ga']])){
			$zero[$i]['m1']=$oneMonth[$zero[$i]['ga']];}
		if(isset($threeMonth[$zero[$i]['ga']])){
			$zero[$i]['m3']=$threeMonth[$zero[$i]['ga']];}
		if(isset($sup[$zero[$i]['ga']])){
			$zero[$i]['plus3']=$sup[$zero[$i]['ga']];}}
	return $zero;
}
//print_r(lstGaEchZero()[1]);
//print_r(countPaParEchTot());
//Nb d'actions par statut  GA Primaire'
function countActionsParGaParStatut(){
	include('connexionPG.php');
	$reponse = $bdd->query('select gaprimaire AS ga, statut, COUNT(statut) AS nb FROM actions GROUP BY gaprimaire, statut ORDER BY gaprimaire');
	$lst=$reponse->fetchAll(PDO::FETCH_ASSOC);
	$reponse->closeCursor();
	return $lst;
}
//print_r(countActionsParGaParStatut());
//echo json_encode(countPaParGa());
//count les pa pour chaque GA, pour une écheance donnée

