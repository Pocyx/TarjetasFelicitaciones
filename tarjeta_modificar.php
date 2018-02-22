<?php 
include "conexion.php";


$update_values = "Update tarjeta Set titulo='" . $_POST['titulomodificar'] . "' Where tarjeta_id='" . $_POST['idtarjetamodificar'] . "'";
                $con->query($update_values) ;

include "tarjeta_lista_tabla.php";
?>
