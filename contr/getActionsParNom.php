<?php
include '../modele/list.php';
echo json_encode(lstActionsAffecteesEch($_GET['nom'], $_GET['ech']));
?>