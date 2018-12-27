<?php

require 'Bateau.php';

$trajet = new Trajet();
$trajet->addPointGPS(30.5,68.5);
$trajet->addPointGPS(45.6,56.9,"Paris");
$point = new Port(664,54,"blabla");

$bateau = new Bateau("mobidick",45,"ZODIAC","Downald Trump");
//echo $bateau->__toString();
echo json_encode($bateau)."</br></br>";
$bateau->addTrajet($trajet);
//echo $bateau->__toString();
$json = json_encode($bateau);
echo "</br>".$json;
$dejson = (json_decode($json,true));
$b2 = Bateau::JsonDeserialize($dejson);
//echo "</br>".$b2;
var_dump($b2);
var_dump($dejson['nom']);
var_dump($dejson['taille']);
var_dump($dejson['modele']);
var_dump($dejson['proprio']);
var_dump($dejson['carnetEntretien']);
var_dump($dejson['carnetBord']);
?>