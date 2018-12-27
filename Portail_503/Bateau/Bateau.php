<?php

require 'Categorie.php';
require 'CarnetEntretien.php';
require 'Trajet.php';

class Bateau implements JsonSerializable{
	private $nom;
	private $taille;
	private $modele;
	private $proprio;
	private $carnetEntretien;
	private $carnetBord;
	private $lien_image;

	public function __construct($nom, $taille, $modele, $proprio, $carnetEntretien = NULL, $carnetBord = NULL){

		
		$this->nom = $nom;
		$this->taille = $taille;
		$this->modele = $modele;
		$this->proprio = $proprio;
		$this->lien_image = "./images/".$modele.".jpg";
		if($carnetEntretien == NULL){
			$this->carnetEntretien = new CarnetEntretien($modele);
		}
		else{
			if(is_array($carnetEntretien)){
				$this->carnetEntretien = new CarnetEntretien($carnetEntretien);
			}
			$this->carnetEntretien = $carnetEntretien;
		}
		$this->carnetBord = $carnetBord;
		
	}

	public function getNom(){
		return $this->nom;
	}

	public function getTaille(){
		return $this->taille;
	}

	public function getModele(){
		return $this->modele;
	}

	public function getProprio(){
		return $this->proprio;
	}

	public function getCarnetEntretien(){
		return $this->carnetEntretien;
	}

	public function getCarnetBord(){
		return $this->carnetBord;
	}

	public function addTrajet($trajet){
		$this->carnetBord[] = $trajet; 
	}

	public function __toString(){

		$r = 
		"<hr/><h3>".$this->nom."</h3>
		<img class='photo_type' src='".$this->lien_image."' alt='bateau'>
		<ul>
				<li><b> Modèle : </b> ".$this->modele."</li>
				<li><b>Taille : </b>".$this->taille."M</li>
		</ul>";
		if($this->carnetBord == NULL){}
		else{
			$r = $r."carnet de bord</br>";
			for($i = 0; $i < count($this->carnetBord); $i++){
				$r = $r.$this->carnetBord[$i]->__toString();
			}
			$r = $r."<br/>";
		}
		$r.="<hr/>";
		return $r;
	}

	public function JsonSerialize(){
		return ['nom' => $this->nom,
				'taille' => $this->taille,
				'modele' => $this->modele,
				'proprio' => $this->proprio,
				'carnetEntretien' => $this->carnetEntretien,
				'carnetBord' => $this->carnetBord];
	}

	public static function JsonDeserialize($json){
		return new Bateau($json['nom'], $json['taille'], $json['modele'], $json['proprio'], $json['carnetEntretien'], $json['carnetBord'] );
	}
}

?>