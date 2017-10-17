<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Administration</title>
	    <script src="../../assets/js/jquery-2.2.3.min.js"></script>
		<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap-theme.min.css">  
    <style>
    form
    {
        text-align:left;
    }
    </style>
    </head>
<body>

<h1>Administration</h1><br>
<h2>Mise &agrave; jour des bases</h2><br>
<div class="container">
	<div class="row">
		<form action="vueImport.php" method="post" enctype="multipart/form-data">
		    <label class="btn btn-primary" for="fileToUpload">
		    	<input type="file" name="fileToUpload" class="btn btn-default btn-sm" id="fileToUpload" style="display:none;">
				Choisir Export Terrain
			</label>
		 
		    <input type="submit" class="btn btn-primary" value="MAJ importCVT" name="submit" class="btn btn-primary">
		</form>
	</div>
</div>

<br><h2>Mise &agrave; jour des options</h2><br>

<div class="container">
		<div class="row">
			<div class="col-lg-4"> 
				<div class="input-group">
					<span  class="input-group-addon">Debut Session</span>
					<input type="text" class="form-control" id="dateDebut" value="<?php echo $_SESSION["debut"];?>">
				</div>
			</div>
			<div class="col-lg-4"> 
				<div class="input-group">
					<span  class="input-group-addon">Fin Session</span>
					<input type="text" class="form-control" id="dateFin" value="<?php echo $_SESSION["fin"];?>">
					<span class="input-group-btn">
        				<button id="majDateSession" class="btn btn-primary">MAJ</button>
      				</span>									
				</div>
			</div>
			<div class="col-lg-4"> 
        			<span class="label label-success" id="result"></span>
        	</div>
      				
		</div>
	<br>
	<div class="row">
			<div class="col-lg-4"> 
				<div class="input-group">
					<span  class="input-group-addon">Debut CVT   </span>
					<input type="text" class="form-control" id="dateDebutCvt" value="<?php echo $_SESSION["cvtDebut"];?>">
				</div>
			</div>
			<div class="col-lg-4"> 
				<div class="input-group">
					<span  class="input-group-addon">Fin CVT   </span>
					<input type="text" class="form-control" id="dateFinCvt" value="<?php echo $_SESSION["cvtFin"];?>">
					<span class="input-group-btn">
        				<button id="majDateCvt" class="btn btn-primary">MAJ</button>
      				</span>									
				</div>
			</div>
			<div class="col-lg-4"> 
        			<span class="label label-success" id="resultCvt"></span>
        	</div>
      				
		</div>
	
</div>
<h2>Mise &agrave; jour du pci</h2><br>
<div class="container">
	<div class="row">
		<div class="col-lg-2">
			<button id="importPciCible" class="btn btn-primary">Import Cibles PCI</button>
		</div>
		<div class="col-lg-2">
			<button id="importPciFiches" class="btn btn-primary">Import Fiches PCI</button>
		</div>
				<div class="col-lg-2">
					<div class="dropdown">
  						<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" >
						    MAJ Fiche PCI
						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						  <?php
						include('../modele/connexionPG.php');
						$rep = $bdd->prepare('SELECT DISTINCT(code), titre FROM pci_fiches ORDER BY code');
						$rep->execute();
						while ($don = $rep->fetch())
							{											
									echo '<li><a href="../vue/editTramePci.php?code='.$don['code'].'">'.$don['code'].' : '.$don['titre'].'</a></li>';
							}		
						$rep->closeCursor();
						?>
					  </ul>
				</div>
		</div>
		<div class="col-lg-4"> 
        			<span class="label label-success" id="resultPci"></span>
        	</div>
	</div>
</div>


<script type="text/javascript">

	$(document).ready(function(){
		$("#majDateSession").click(function(){
			var dateDebut = $("#dateDebut").val();
			var dateFin = $("#dateFin").val();
			var dataString = 'dateDebut='+ dateDebut + '&dateFin='+ dateFin;
			$.ajax({
				type: "POST",
				url: "bddMajDateSession.php",
				data: dataString,
				cache: false,
				success: function(data){
					 $('#result').text(data);		}
			});
		
		});
	});

	$(document).ready(function(){
		$("#majDateCvt").click(function(){
			var dateDebut = $("#dateDebutCvt").val();
			var dateFin = $("#dateFinCvt").val();
			var dataString = 'dateDebut='+ dateDebut + '&dateFin='+ dateFin;
			$.ajax({
				type: "POST",
				url: "bddMajDateCvt.php",
				data: dataString,
				cache: false,
				success: function(data){
					 $('#resultCvt').text(data);		}
			});
		
		});
	});
	$(document).ready(function(){
        $('#importPciCible').click(function(){
            $.ajax({
                type: 'POST',
                url: 'importPciCible.php',
                success: function(data) {
                    $('#resultPci').text(data);  }
            });
   		});
	});
	$(document).ready(function(){
        $('#importPciFiches').click(function(){
            $.ajax({
                type: 'POST',
                url: 'importPciFiches.php',
                success: function(data) {
                    $('#resultPci').text(data);  }
            });
   		});
	});
	
</script>
</body>
</html>