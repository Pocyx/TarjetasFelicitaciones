<?php
require_once("constantes.php");
$con = new mysqli(HOST, USUARIO_DB,CLAVE_DB);

if ($con->connect_errno > 0) {
        echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
        die ("Error: " . $con->connect_error);
} else {
        $con->select_db(NOMBRE_DB);
        $con->set_charset("utf8");
        $con->query("SET NAMES 'utf8'");
}
?>