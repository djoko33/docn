<?php
include '../modele/list.php';
echo json_encode(lstActionsPa($_GET['pa']));
?>