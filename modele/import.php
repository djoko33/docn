<?php
include('connexionPG.php');

function convertDate($d) {
	$exp=explode('/', $d);
	return date('Y-m-d', mktime(0, 0, 0, intval($exp[1]), intval($exp[0]), intval($exp[2])));
	;
}


$target_dir = "uploads/";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
//$importFileType = pathinfo($target_file,PATHINFO_EXTENSION);


//n'autorise que du csv
//if ($importFileType == "csv")
//{
	//move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
	//$file =  basename( $_FILES["fileToUpload"]["name"]);
	$reponse = $bdd->query("DELETE FROM pa");
	
	$req = $bdd->prepare('INSERT INTO pa (
			num, disc, libelle, creation, echeance, ga, statut, datestatut)
			VALUES 
			(?, ?, ?, ?, ?, ?, ?, ?)');
	//if (($handle = fopen($target_file, "r")) !== FALSE)
	if (($handle = fopen('PA.csv', "r")) !== FALSE)
		{
			$i=0;
			while (($data = fgetcsv($handle, 5000, ";")) !== FALSE) 
			{
				$u = array_map("utf8_encode", $data);
				if ($i>1){
					$req->execute(array($u[0], $u[2], $u[3], convertDate($u[4]), convertDate($u[5]), $u[10], $u[14], convertDate($u[15])));
				} //saute la premiere ligne avec les titres et la premiere ligne vide
				
				$i++;
			}
			fclose($handle);
		}
	$reponse = $bdd->query("UPDATE pa SET statut = REPLACE(statut, 'APPROUVÉ', 'APPROUVE')");
	$reponse = $bdd->query("UPDATE pa SET statut = REPLACE(statut, 'NOTIFIÉ', 'NOTIFIE')");
	echo 'import r&eacute;ussi de '.$i.' PA';
//}
//else 
//{
//	echo "Choisir un fichier csv";
//}
$reponse = $bdd->query("DELETE FROM actions");
$req = $bdd->prepare('INSERT INTO actions (
			pa, disc, num, libelle, echeance, gaprimaire, gasecondaire, affecte, statut, datestatut, active)
			VALUES
			(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
//if (($handle = fopen($target_file, "r")) !== FALSE)
if (($handle = fopen('PA_Actions.csv', "r")) !== FALSE)
{
	$i=0;
	while (($data = fgetcsv($handle, 10000, ";")) !== FALSE)
	{
		$u = array_map("utf8_encode", $data);
		if ($i>1){
			$n=explode('-', $u[9]);//01234 - 01
			if ($u[20]=='Active') 
				{$etat='y';}
			if ($u[20]=='Close')
				{$etat='n';}
				$req->execute(array($u[0], $u[2], trim($n[1]), $u[10], convertDate($u[11]), $u[15], $u[16], $u[17], $u[18], convertDate($u[19]), $etat));
		} //saute la premiere ligne avec les titres
		$i++;
	}
	fclose($handle);
}
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'ANNULÉ', 'ANNULE')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'CLÔTURÉ', 'CLOTURE')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'ACC/PRI', 'ACCPRI')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'NOTF/PRI', 'NOTFPRI')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'ACC/SEC', 'ACCSEC')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'NOTF/SEC', 'NOTFSEC')");
$reponse = $bdd->query("UPDATE actions SET statut = REPLACE(statut, 'ATT/CLÔT', 'ATTCLOT')");
echo 'import r&eacute;ussi de '.$i.' actions';

$reponse = $bdd->query("DELETE FROM notes");
$req = $bdd->prepare('INSERT INTO notes (
			pa, type, note)
			VALUES
			(?, ?, ?)');
//if (($handle = fopen($target_file, "r")) !== FALSE)
if (($handle = fopen('PA_Notes.csv', "r")) !== FALSE)
{
	$i=0;
	while (($data = fgetcsv($handle, 10000, ";")) !== FALSE)
	{
		$u = array_map("utf8_encode", $data);
		if ($i>1){
			$req->execute(array($u[0], $u[14], $u[15]));
		} //saute la premiere ligne avec les titres
		//echo $i;
		$i++;
	}
	fclose($handle);
}

?>
