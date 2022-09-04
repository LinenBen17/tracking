<?php 
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

	require 'conexion.php';

	$sql = "SELECT * FROM reclamos";

	$seleccion = $mysqli->prepare($sql);
	$seleccion->execute();

	$a = $seleccion->get_result();

	while ($resultado = $a->fetch_array()) {
	    $arreglo["data"][] = $resultado;
	}

	echo json_encode($arreglo);

	$seleccion->close();
?>