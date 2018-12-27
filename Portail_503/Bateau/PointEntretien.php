<?php

class PointEntretien implements JsonSerializable{
	private $libellele;
	private $periodicite;
	private $lastverif;
	private $nextverif;

	public function __construct($libellele, $n, $pointEntretien = NULL){
		if($pointEntretien == NULL){

			$this->libellele = $libellele;
			$this->periodicite = $n;
			$this->lastverif = time();
			$this->nextverif = $this->lastverif + $this->periodicite*31536000;
		}
		else{
			$this->libellele = $pointEntretien['libellele'];
			$this->periodicite = $pointEntretien['periodicite'];
			$this->lastverif = $pointEntretien['lastverif'];
			$this->nextverif = $pointEntretien['nextverif'];
		}
	}

	public function getLibellele(){
		return $this->libellele;
	}

	public function getLastverif(){
		return $this->lastverif;
	}

	public function getNextverif(){
		return $this->nextverif;
	}

	public function __toString(){
		return $this->libellele.", last verif= ".Date("d/m/Y",$this->lastverif).", next verif= ".Date("d/m/Y",$this->nextverif);
	}

	public function JsonSerialize(){
		return ['libellele' => $this->libellele,
				'periodicite' => $this->periodicite,
				'lastverif' => $this->lastverif,
				'nextverif' => $this->nextverif];
	}
}

?>