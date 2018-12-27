<?php

require 'Port.php';

class Trajet implements JsonSerializable{
	private $coGPS;

	public function __construct(){
		$this->coGPS = NULL;
	}

	public function getTrajet(){
		return $this->coGPS;
	}

	public function addPointGPS($lat, $lon, $nom=NULL){
		if($nom == NULL){
			$this->coGPS[] = new PointGPS($lat,$lon);
		}
		else{
			$this->coGPS[] = new Port($lat,$lon,$nom);
		}
	}

	public function JsonSerialize(){
		return ['coGPS' => $this->coGPS];
	}

	public function __toString(){
		$r = "";
		for($i = 0; $i < count($this->coGPS); $i++){
			$r = $r.$this->coGPS[$i]->__toString()."</br>";
		}
		return $r;
	}
}

?>