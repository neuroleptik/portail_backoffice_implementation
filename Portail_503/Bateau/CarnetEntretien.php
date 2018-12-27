<?php

require 'PointEntretien.php';

class CarnetEntretien implements JsonSerializable{
	private $carnetEntretien;

	public function __construct($modele){
		if(is_array($modele)){
			foreach ($modele['carnetEntretien'] as $c => $v) {
				for($i = 0; $i < count($v); $i++){
					$tmp[] = new PointEntretien(NULL,NULL,$v[$i]);
				}
				$this->carnetEntretien[$c] = $tmp;
				unset($tmp);
			}
		}
		else{
			$enum = array('VOILIER' => array(Categorie::electricite,Categorie::circuiteau,Categorie::coque,Categorie::accastiage,Categorie::greement),
			'PAQUEBOT' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
			'YATCH' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
			'ZODIAC' => array(Categorie::moteur,Categorie::electronique,Categorie::accastiage),
			'FREGATE' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
			'PENICHE' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage));

			for($i = 0; $i < count($enum[$modele]); $i++){
				foreach($enum[$modele][$i] as $c => $v){
					foreach($v as $key => $value){
						$tmp[] = new PointEntretien($key,$value);
					}
					$this->carnetEntretien[$c] = $tmp;
					unset($tmp);
				}
			}
		}
	}

	public function getCarnet(){
		return $this->carnetEntretien;
	}

	public function __toString(){
		$r = "</br></br>carnet de maintanace:</br>";
		foreach($this->carnetEntretien as $k => $v){
			$r = $r.$k." :</br>";
			for($i = 0; $i < count($v); $i++){
				$r = $r.$v[$i]->__toString()."</br>";
			}
			$r = $r."</br>";
		}
		return $r;
	}

	public function JsonSerialize(){
		return ['carnetEntretien' => $this->carnetEntretien];
	}
}

?>