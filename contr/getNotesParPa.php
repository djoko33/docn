<?php
include '../modele/list.php';
echo json_encode(lstNotesPa($_GET['pa']));
?>