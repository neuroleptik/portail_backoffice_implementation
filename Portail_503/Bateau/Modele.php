<?php

require 'Categorie.php';

class Modele {
	public static $enum = array('voilier' => array(Categorie::electricite,Categorie::circuiteau,Categorie::coque,Categorie::accastiage,Categorie::greement),
		'paquebot' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
		'yatch' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
		'zodiac' => array(Categorie::moteur,Categorie::electronique,Categorie::accastiage),
		'fregate' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage),
		'peniche' => array(Categorie::moteur,Categorie::electricite,Categorie::electronique,Categorie::circuiteau,Categorie::coque,Categorie::accastiage));
}

?>