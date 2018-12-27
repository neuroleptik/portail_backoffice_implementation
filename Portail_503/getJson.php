<?php
header("Content-type: application/json");

	$num = intval($_GET['id']);
	$listeNews = json_decode(file_get_contents("Json_temp/".$num.".json"));
echo json_encode($listeNews);
?>