<?php

class PointGPS implements JsonSerializable{
	private $lat;
	private $lon;

	public function __construct($lat, $lon){
		$this->lat = $lat;
		$this->lon = $lon;
	}

	public function getLat(){
		return $this->lat;
	}

	public function getLon(){
		return $this->lon;
	}

	public function JsonSerialize(){
		return ['lat' => $this->lat,
				'lon' => $this->lon];
	}

	public function __toString(){
		return "latitude= ".$this->lat.", longitude= ".$this->lon;
	}
}

?>