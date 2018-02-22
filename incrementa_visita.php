<?php
include "conexion.php";

if (!empty($_POST["idinmueble"])){	
	$sql = "UPDATE inmueble SET
		visita = visita + 1  
		WHERE idinmueble=". $_POST["idinmueble"];
	$conexion->exec($sql);


$consulta = "SELECT visita 
			FROM inmueble
			WHERE idinmueble=". $_POST["idinmueble"];
$resultado = $conexion->query($consulta);
$fila = $resultado->fetchObject();
echo $fila-> visita;
}
?>