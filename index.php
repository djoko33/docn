<!DOCTYPE html>
<html lang="fr">
<head>
  <title>PA DOCN</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=9">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
	<!-- jQuery -->
	<script src="../assets/js/jquery-2.2.3.min.js"></script>
	
	<!-- Bootstrap -->
	<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
	<!--link rel="stylesheet" href="css/main.css" type="text/css"-->
	
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left">
        <li>
        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ILD<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
					<li><a href="">Indicateurs</a></li>
					<li><a href="">Notes</a></li>
				</ul>
        </li>
        <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Groupes<span class="caret"></span></a>
                <ul class="dropdown-menu my-new-list" role="menu" id="dropGroups">
                	<li><a href="vue/service.php?serv=AUT">G1</a></li>
                	<li><a href="vue/service.php?serv=AUT">G2</a></li>
                </ul> 
        </li>			
      	<li>
      		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Actions<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
					<li class="dropdown-submenu"><a href="#"></a>
								<ul class="dropdown-menu">
									<li><a href=""></a></li>
								</ul>
					</li>                
                </ul>
      	</li>
        <li><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mon Sous-Processus<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li class="dropdown-submenu"><a href="#"></a>
								<ul class="dropdown-menu">
									<li><a href=""></a></li>
								</ul>
					</li>
				</ul>
		</li>
		<li><a href="vue/mot.php" >Mon Mot Cl&eacute;</a>
		</li>
		<li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Titre<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                	<li><a href="">Sous Titre</a></li>
                </ul>
		</li>
      </ul>
    </div>
  </div>
</nav>

<div class="jumbotron text-center">
  <h1>EVT</h1> 
  <p>EnVie de Terrain ?</p> 
</div>

<!-- Container (About Section) -->
<div id="about" class="container-fluid">
  <div class="row">
    <div class="col-sm-8">
      <h2>5 axes d'exploitation des CVT</h2><br>
      <h4>Une approche globale Site</h4><br>
      <h4>Une approche par service</h4><br>
      <h4>Une approche par code</h4><br>
      <h4>Une approche par sous-processus</h4><br>
      <h4>Une approche par famille </h4><br>
      <br>
    </div>
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-signal logo"></span>
    </div>
  </div>
</div>

<div class="container-fluid bg-grey">
  <div class="row">
    <div class="col-sm-4">
      <span class="glyphicon glyphicon-link logo slideanim"></span>
    </div>
    <div class="col-sm-8">
      <h2>Les liens</h2><br>
      <h4>Les plans d'actions Suret&eacute; du site</h4><br>
      <h4>La d&eacute;marche MQME</h4><br>
      <h4>Le SMI</h4><br>
    </div>
  </div>
</div>


<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Site fait &agrave; la main, bienveillance et patience pour les bugs...</p>
</footer>
<script src="../../assets/js/jquery-2.2.4.min.js"></script>
<script>
$(document).ready(function(){
	$.getJSON('contr/getGaResponsPA.php', function(data) {
	    $.each(data, function(index, element) {
	        $('#dropGroups').append('<li><a href="">'+element.ga+'</a></li>');
			  });
	});
  
  });
  
</script>
<!-- jQuery -->

</body>
</html>
  