<?php
include_once '../modele/list.php';
if(isset($_GET['statut']))
{
	if($_GET['statut']!="")
	{
		echo json_encode(lstActionsGaEchStatut($_GET['ga'], $_GET['ech'], $_GET['statut']));
	}
	else
	{
		echo json_encode(lstActionsGaEch($_GET['ga'], $_GET['ech']));
	}
}
?>