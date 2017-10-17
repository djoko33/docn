<?php
include '../modele/list.php';
if(isset($_GET['statut']))
	{
		if($_GET['statut']!="")
			{
				echo json_encode(lstPaGaEchStatut($_GET['ga'], $_GET['ech'], $_GET['statut']));
			}
			else
			{
				echo json_encode(lstPaGaEch($_GET['ga'], $_GET['ech']));
			}
	}
?>