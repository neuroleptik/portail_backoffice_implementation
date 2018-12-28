<?php 
	session_start();
?>
<!doctype HTML>
		<html>
			<head>
				<title>Mon tableau de bord</title>
				<link rel='stylesheet'  type='text/css' href='style.css'/>
				<script src='jquery.js'></script>
				<script src='https://code.jquery.com/jquery-1.10.2.js'></script>		
			</head>	
			<body>	
					<div id='div_principale_tableau_de_bord'>
						<center><h1>Mon port</h1></center>
						<?php
							if ($_SESSION['type_utilisateur'] == "proprietaire")
								include 'menu_proprietaire.php';
							else
								include 'menu_gestionaire.php';
							
							echo "<id ='message_bonjour'>Bonjour ".$_SESSION['civilite']." ".$_SESSION['nom']." ".$_SESSION['prenom'].".</p>"
						?>
						<center><h2>Mes bateaux</h2></center>
						<?php
							echo "<p id =nombre_bateaux>Vous avez ".count($_SESSION['liste_bateaux'])." bateau(x).</p>";

							echo "<p>ATTENTION PAGE A CONSTRUIRE</p>";
						?>
						<div id="map"></div>
					</div>
					
				
				<!-- <script src='carte.js'></script>
				<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAt_tUjODadjJJjaycP4DeMfxRML34ils&callback=initMap"async defer></script> -->
				<script type='text/javascript' src='getJsonUtilisateur.js'></script>
			</body>
		</html>