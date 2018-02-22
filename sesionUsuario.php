<?php
session_start();

// Comprobar si existe una sesión previa
if (isset($_SESSION["usuario"])) {

    header("Location:inicio.php");
}//

if (isset($_GET['usuario'])) {
    $user = $_GET['usuario'];
    $contrasena = $_GET['contrasena'];
    comprobar($user, $contrasena);
    $_SESSION['usuario'] = $_GET['usuario'];
    $usuario = $_SESSION['usuario'];
}

function comprobar($u, $c) {
    require_once("conexion.php");

    $usr = $con->real_escape_string($u);
    $pass = $con->real_escape_string($c);
    //AND password='$pass'
    $sql = "SELECT * FROM usuarios WHERE name='$usr' ;";
    $pswd = "SELECT password FROM usuarios WHERE name='$usr';";
    $reg = $con->query($sql) or die("**ERROR: $con->error.<br/>");
    $reg2 = $con->query($pswd) or die("**ERROR: $con->error.<br/>");

    $contar = $reg->num_rows;

    if ($contar == 0) {
        echo "<span style='font-weight:bold;color:green;'><a href='registro.php'>Registrate</a></span>";
        session_destroy();
    } else {

        if ($row = $reg2->fetch_array()) {
            //Guardo los datos de la BD en las variables de php
            $var1 = $row["password"];
        }
        if ($pass == $var1) {

            header("Location:inicio.php");
        } else {
            echo "<span style='font-weight:bold;color:red;'>Contraseña incorrecta.</span>";
            session_destroy();
        }
    }
    $con->close();
}
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Logueate!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>

        <div id="contenedor">
            <form action="sesionUsuario.php" method="GET">
                <div id="centro">
                    Usuario<input type="text" name="usuario">
                    Contraseña<input type="password" name="contrasena">
                    <button class="botones">Iniciar</button>
                </div>
            </form>
        </div>
        <button class="botones"  onclick = "location = 'index.php'">inicio</button>
    </body>
</html>