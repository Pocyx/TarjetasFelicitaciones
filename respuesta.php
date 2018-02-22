<?php

if (isset($_GET["comentar"])) {
    if (empty($_GET['tituloR']) || empty($_GET['textoR'])) {

    } else {
        $fecha_registro = date('Y-m-d H:i:s');
        $insert_value = 'INSERT INTO `felicitaciones`.`respuesta` (`fecha` ,`autor` , `titulo`, `tarjeta_id`) '
                . 'VALUES ("' . $fecha_registro . '","' . $_SESSION['usuario'] . '", "' . $_GET['tituloR'] . '", "' . $_GET['textoR'] . '","' . $obj->tarjeta_id . '")';


        $con->query($insert_value) or die("**ERROR (): $con->error.<br/>");

        header("Location:inicio.php");
    }
}
?>
