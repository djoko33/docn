
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Mise à jour des tables</title>
	    <script src="../../assets/js/jquery-2.2.3.min.js"></script>
		<script src="../../assets/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
		<script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="../../assets/bootstrap-table/bootstrap-table.min.js"></script>
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap-theme.min.css">
		<link rel="stylesheet" href="../../assets/bootstrap-select/dist/css/bootstrap-select.min.css">
    	<link rel="stylesheet" href="../../assets/bootstrap-table/bootstrap-table.min.css">

		<style type="text/css">
		    .bs-example{
		    	margin: 20px;
		    }
		</style>
    </head>
    <style>
    form
    {
        text-align:left;
    }
    </style>
<body>
<h1>Mise &agrave; jour des donn&eacute;es</h1><br>
<p id="result">
<?php
include('../modele/connexionPG.php');
include '../modele/import.php';
?></p>
<p></p>
<br>
<div class="container">
	<div class="row">
		<div class="col-lg-2">
			<a href="vueAdmin.php" class="btn btn-default" role="button">Retour Admin</a>

		</div>
		<div class="col-lg-2">
			<button id="traitementCvt" class="btn btn-primary">Traitement CVT</button>
		</div>
		<div class="col-lg-2">
			<button id="traitementCodes" class="btn btn-primary">Traitement Codes</button>
		</div>
		<div class="col-lg-2">
			<button id="traitementPci" class="btn btn-primary">Traitement Pci</button>
		</div>		
		<div class="col-lg-2">
			<button id="traitementIndex" class="btn btn-primary">Traitement Index</button>
		</div>
		<div class="col-lg-2">
			<button id="traitementSp" class="btn btn-primary">Traitement SP</button>
		</div>		
	</div>
	<br>
	<div class="row">
		<div class="col-lg-2">
			<button id="resetImportCVT" class="btn btn-primary">Vider ImportCVT</button>
		</div>
		<div class="col-lg-2">
			<button id="resetCVT" class="btn btn-primary">Vider CVT</button>
		</div>
		<div class="col-lg-2">
			<button id="resetcodesCVT" class="btn btn-primary">Vider codesCVT</button>
		</div>
		<div class="col-lg-2">
			<button id="resetPci" class="btn btn-primary">Vider PCI</button>
		</div>					
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function(){
        $('#resetImportCVT').click(function(){
            $.ajax({
                type: 'POST',
                url: 'bddResetImportCVT.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});

	$(document).ready(function(){
		$('#resetCVT').click(function(){
        	$.ajax({
	            type: 'POST',
	            url: 'bddResetCVT.php',
	            success: function(data) {
	                $('#result').text(data);  }
        	});
		});
	});

	$(document).ready(function(){
		$('#resetcodesCVT').click(function(){
		    $.ajax({
		        type: 'POST',
		        url: 'bddResetcodesCVT.php',
		        success: function(data) {
		            $('#result').text(data);  }
		    	});
			});
		});
	$(document).ready(function(){
		$('#resetPci').click(function(){
		    $.ajax({
		        type: 'POST',
		        url: 'bddResetPci.php',
		        success: function(data) {
		            $('#result').text(data);  }
		    	});
			});
		});

	
    $(document).ready(function(){
        $('#importCvt').click(function(){
            $.ajax({
                type: 'POST',
                url: 'import.php',
                success: function(data) {
                    $("#result").text(data);  }
            });
   		});
	});
    $(document).ready(function(){
        $('#traitementCvt').click(function(){
            $.ajax({
                type: 'POST',
                url: 'traitementCvt.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});
    $(document).ready(function(){
        $('#traitementCodes').click(function(){
            $.ajax({
                type: 'POST',
                url: 'traitementCodes.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});
    $(document).ready(function(){
        $('#traitementPci').click(function(){
            $.ajax({
                type: 'POST',
                url: 'traitementPci.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});
    $(document).ready(function(){
        $('#traitementIndex').click(function(){
            $.ajax({
                type: 'POST',
                url: 'traitementIndex.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});
    $(document).ready(function(){
        $('#traitementSp').click(function(){
            $.ajax({
                type: 'POST',
                url: 'traitementSp.php',
                success: function(data) {
                    $('#result').text(data);  }
            });
   		});
	});

</script>



</body>
</html>
