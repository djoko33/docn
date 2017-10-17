<?php
include '../modele/count.php';
include '../modele/list.php';
//$zero=lstGaPaStatutZero();
$val=countPaParGaParStatut();
$lstStatut=array('ga'=>'ga', 'NOUVEAU'=>0, 'SOUMIS'=>0, 'NOTIFIE'=>0, 'APPROUVE'=>0);
$tot=array();
$t=array();
foreach ($val as $v) {
	if (!isset($tot[$v['ga']])) {
		$tot[$v['ga']]=$lstStatut;
	}
	$tot[$v['ga']][$v['statut']]=$v['nb'];
	$tot[$v['ga']]['ga']=$v['ga'];
}


echo json_encode($tot);
?>