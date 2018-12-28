<?php
	session_start();
	$champ = array('','');

	function afficher_form($tab_erreur=''){
	echo "<form action='index.php?type=0' method='post' id='form'>
		 				<table id ='tab_connexion'  class='tab_connexion'><tr><td>
		 						<center><h2 class='titre'>Connexion</h2><center>
		 						<hr width='90%' />
								 <tr ><td id='tr_input_connexion'>
		 								<input class='input_connexion' name='email' id='email' placeholder='Adresse email' type='email'   />
		 								<input class='input_connexion' type='password' id='password' name='password' placeholder='Mot de passe'/> </br></br>
		 								</td></tr><tr><td>
		 								<input type='hidden' name='verif'  value='1'></input>
		 								<input type='submit' id='input_submit' value='Se connecter'></input>
		 								</td></tr><tr><td>
		 								<hr width='50%' />
		 								<p style='text-align:center'>Vous n'avez pas de compte ? <a id='lien_inscription'>Inscrivez-vous</a></p>";
										if ($tab_erreur!=null){
											foreach ($tab_erreur as $key => $value) {
											echo "<ul><li>";
											echo $tab_erreur[$key];
											echo "</li></ul>";
										};
							echo "</td></tr>
						</table>
				</form>";
	}
}
	function verifier_form($type=""){


		if ($type == "connexion") {

			if ($_POST['password'] && $_POST['email']) {
				$url = "http://localhost:8080/demandeUtilisateur.html";
				$fields = [
    			'id_utilisateur'  => $_POST['email']
				];
				//mise sous forme URL
				$fields_string = http_build_query($fields);
				//on ouvre la connection
				$ch = curl_init();

				// on construit l'url
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

				//execute le post
				$result = curl_exec($ch);
				$result = json_decode($result,true);
				if ($result) {
			 		if (hash("sha256",$_POST['password'])==$result['mot_de_passe']) {
			 			$_SESSION['adresse_email']=$result['adresse_email'];
			 			$_SESSION['nom']=$result['nom'];
			 			$_SESSION['prenom']=$result['prenom'];
			 			$_SESSION['civilite']=$result['civilite'];
			 			$_SESSION['liste_bateaux']=$result['liste_bateaux'];
			 			$_SESSION['type_utilisateur']=$result['type_utilisateur'];
			 			header("Location: tableau_bord.php");
						exit();
			 		}
					else{
						$tab_erreur['identifiant_mdp']="Erreur de mot de passe";
			 			afficher_form($tab_erreur);
			 			afficher_form_inscripton();
			 			
			 			echo "<script>document.getElementById('password').style.border='1px solid red';document.getElementById('email').style.border='1px solid red';</script>";
					}
			 	}
			 	else
			 	{
			 		$tab_erreur['identifiant_mdp']="Ce compte n'existe pas";
			 		afficher_form($tab_erreur);
			 		afficher_form_inscripton();
			 		
			 		echo "<script>document.getElementById('password').style.border='1px solid red';document.getElementById('email').style.border='1px solid red';</script>";
			 	}
			}
			else{
				$tab_erreur['identifiant_mdp']="Erreur : champs vide";
			 	afficher_form($tab_erreur);
			 	afficher_form_inscripton();
			 	
			 	echo "<script>document.getElementById('password').style.border='1px solid red';document.getElementById('email').style.border='1px solid red';</script>";
			}
		}
		else
		{

			$script="<script type='text/javascript'>";
			if($_POST['nom']!=null && preg_match("#^[a-zA-Z- ]{2,}$#",trim($_POST["nom"]))){
				$v[]=true;
				$champ[0]=$_POST['nom'];
			}
			else{
				$v[]=false;
				$tab_erreur[]="Votre nom ne doit pas comporter de chiffre et dois faire plus de deux caractères.";
				$script.="document.getElementById('nom').style.border='1px solid red';";
			}
			if($_POST['prenom']!=null && preg_match("#^[a-zA-Z- ]{2,}$#",trim($_POST["prenom"]))){
				$v[]=true;
				$champ[1]=$_POST['prenom'];
			}
			else{
				$v[]=false;
				$tab_erreur[]="Votre prenom ne doit pas comporter de chiffre et doit faire plus de deux caractères.";
				$script .=" document.getElementById('prenom').style.border='1px solid red';";
			}
			
			if($_POST['email']!=null && $_POST['email']==$_POST['email2']){
				if(preg_match ( " #^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$# " , $_POST['email'] )){
					$v[]=true;
				}
				else{
					$v[]=false;
					$tab_erreur[]="Vous devez renseigner une adresse valide.";
					$script.=" document.getElementById('email').style.border='1px solid red';document.getElementById('email2').style.border='1px solid red';";
				}
			}
			else{
				$v[]=false;
				$tab_erreur[]="Vous devez renseigner deux adresses identiques.";
				$script.=" document.getElementById('email').style.border='1px solid red';document.getElementById('email2').style.border='1px solid red';";
			}
			if($_POST['password']!=null && trim($_POST['password'])==trim($_POST['password2'])){
				if(strlen(trim($_POST['password']))>=5){
					$v[]=true;
				}
				else{
					$v[]=false;
					$tab_erreur[]="Votre mot de passe doit comporter au moins 5 caractères";
					$script.=" document.getElementById('password').style.border='1px solid red';document.getElementById('password2').style.border='1px solid red';";
				}
			}
			else{
				$v[]=false;
				$tab_erreur[]="Vous devez renseigner deux mots de passe identiques";
				$script.=" document.getElementById('password').style.border='1px solid red';document.getElementById('password2').style.border='1px solid red';";
			}
			$script.="</script>";
			$i=0;
			while($i < count($v) && $v[$i]==true){
				$i++;
			}
			if($i==4){ // nombre de true dans le tableau , si tout est a true toutes les condition sont verifiés
				$url = "http://localhost:8080/demandeExistance.html";
				$fields = [
    			'id_utilisateur'  => $_POST['email']
				];
				//mise sous forme URL
				$fields_string = http_build_query($fields);
				//on ouvre la connection
				$ch = curl_init();

				// on construit l'url
				curl_setopt($ch,CURLOPT_URL, $url);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
				//execute le post
				$result = curl_exec($ch);
				if ($result) {
					$v[]=false;
					$tab_erreur[]="Cette adresse email est déjà attribué à un utilisateur";
					afficher_form_inscripton($tab_erreur);
					afficher_form();
				}
				else {
					$url = "http://localhost:8080/demandeInscription.html";
					$fields = [
						'civilite' => $_POST['civilite'],
    					'nom' => $_POST['nom'],
    					'prenom' => $_POST['prenom'],
    					'adresse_email'  => $_POST['email'],
    					'mot_de_passe' => hash('sha256', $_POST['password']),
    					'type_utilisateur' => $_POST['type_utilisateur']
					];
					//mise sous forme URL
					$fields_string = http_build_query($fields);
					//on ouvre la connection
					$ch = curl_init();
					// on construit l'url
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
	
						//execute le post
					$result = curl_exec($ch);
	
					$_SESSION['adresse_email']=$_POST['email'];
			 		$_SESSION['nom']=$_POST['nom'];
			 		$_SESSION['prenom']=$_POST['prenom'];
			 		$_SESSION['civilite']=$_POST['civilite'];
			 		$_SESSION['type_utilisateur']=$_POST['type_utilisateur'];
			 		$_SESSION['liste_bateaux'] = null;

			 		header("Location: tableau_bord.php");
					exit();
				}
			}
			else{
				afficher_form_inscripton($tab_erreur);
				afficher_form();
				echo $script;
				
			}
		}
		
									
	}
	
	
	
	function afficher_form_inscripton($tab_erreur=''){
	
	global $champ;
	echo "<form action='index.php?type=1' id='form' method='post'>
			<table  id='tab_inscription' class='tab_inscription'>
					<tr><td colspan ='2'>
							<center><h2 class='titre'>Inscription</h2><center>
					</td></tr><tr><td colspan ='2'>
							<hr width='90%' />
					</td ></tr>
					<tr><td>
							<input id='genre1' type='radio' name='civilite' value='Monsieur' checked />
							<label for='genre1'>Monsieur</label>
					</td><td>
							<input type='radio' id='genre2' name='civilite' value='Madame'/>
							<label for='genre2'>Madame</label>
					</td></tr><tr><td>
							<input id='type1' type='radio' name='type_utilisateur' value='proprietaire' checked />
							<label for='type1'>Proprietaire de bateaux</label>
					</td><td>
							<input type='radio' id='type2' name='type_utilisateur' value='directeur'/>
							<label for='type2'>Directeur de port</label>
					</td></tr><tr><td>
							<input placeholder='Nom' id='nom' value='".$champ[0]."' name='nom' maxlength='30'  />
					</td><td>
							<input type='name' name='prenom' id='prenom' value='".$champ[1]."' maxlength='30' placeholder='Prenom'/>
					</td></tr><tr><td>
							<input type='password' name='password' id='password' placeholder='Mot de passe' />
					</td><td>
							<input type='password' name='password2' id='password2' placeholder='Confirmez votre mot de passe' />
					</td></tr><tr><td>
							<input type='email' name='email' id='email'  placeholder='Adresse email'/>
					</td><td>
							<input type='email' name='email2' id='email2' placeholder='Confirmez adresse email' />
					</td></tr><tr><td colspan ='2'>
							<input type='hidden' name='verif' id='input_submit' value='1'/>
							<input type='submit' id='input_submit' value=S'inscrire />
					</td></tr><tr><td colspan ='2'>
							<hr width='50%' />
							<p style='text-align:center;'>Vous avez déjà un compte ? <a id='lien_connexion'>Connectez-vous</a></p>";
					if ($tab_erreur!=null){
						foreach ($tab_erreur as $key => $value)
						{
							echo "<ul><li>";
							echo $tab_erreur[$key];
							echo "</li></ul>";
						};
					}

			echo "</td></tr>
			</table>
		</form>";

	}
	
?>

<!doctype HTML>
		<html>
			<head>
				<title>Portail d'Authentification</title>
				<link rel='stylesheet'  type='text/css' href='style.css'/>
				<script src='jquery.js'></script>
				<script src='https://code.jquery.com/jquery-1.10.2.js'></script>
				<script src='main_animation.js'></script>
			</head>	
			<body>
				<center><h1>La Fameuse application de gestionnaire de port</h1></center>

					<?php
						if(isset($_POST['verif'])){
							if ($_GET['type']==0) {
								echo "<script type='text/javascript'>
									$( 'html' ).ready(function() {
									$('	#tab_inscription').hide();});
								</script>";
								verifier_form("connexion");
							}
							else{
								echo "<script type='text/javascript'>
									$( 'html' ).ready(function() {
									$('	#tab_connexion').hide();});
								</script>";
								verifier_form("inscription");
							}	
						}
						else{
							afficher_form_inscripton();
							afficher_form();
							echo "<script type='text/javascript'>$( 'html' ).ready(function() {
							$('body').hide();
							$('	#tab_connexion').hide();
							$('#tab_inscription').hide();
							$('body' ).fadeIn(2000);
							$( '#tab_connexion').fadeIn(3000);});</script>";
							
						}

					?>

			
			</body>
		</html>


