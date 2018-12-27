<?php

require 'PointGPS.php';

class Port extends PointGPS implements JsonSerializable{
	private $nom;

	public function __construct($lat,$lon,$nom){
		parent::__construct($lat,$lon);
		$this->nom = $nom;
	}

	public function JsonSerializable(){
		$obj = parent::JsonSerializable();
		$obj["nom"] = $this->nom;
		return $obj;
	}

	public function __toString(){
		return "Port= ".$this->nom.", ".parent::__toString();
	}
}

?>