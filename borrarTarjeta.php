
<?php
require_once("conexion.php");

$update_values = "Delete From tarjeta  Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
    $con->query($update_values) or die("**ERROR (): $con->error.<br/>");


    header("Location:borrador.php");
?>