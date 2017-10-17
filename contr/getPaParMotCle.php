<?php
include_once '../modele/list.php';
echo json_encode(lstPaMotCleEch($_GET['mot'], $_GET['ech']));
?>