<?php
include_once '../modele/count.php';
include_once '../modele/list.php';
//$zero=lstGaPaStatutZero();
$val=countActionsParGaParStatut();
$lstStatut=array('ga'=>'ga', 'NOUVEAU'=>0, 'NOTFPRI'=>0, 'NOTFSEC'=>0, 'ACCPRI'=>0, 'ACCSEC'=>0, 'ATTCLOT'=>0, 'CLOTURE'=>0, 'ANNULE'=>0);
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