
<?php
session_start();

if (isset($_GET['usuario'])) {
    $user2 = $_GET['usuario'];
    $contrasena2 = $_GET['contrasena'];
    comprobar($user2, $contrasena2);
    $_SESSION['usuario'] = $_GET['usuario'];
    $usuario = $_SESSION['usuario'];
}

function comprobar($u, $c) {
    require_once("conexion.php");

    $usr = $con->real_escape_string($u);
    $pass = $con->real_escape_string($c);

    $sql = "SELECT * FROM usuarios WHERE name='$usr' ;";

    $reg = $con->query($sql) or die("**ERROR: $con->error.<br/>");

    $contar = $reg->num_rows;

    if ($contar == 0) {
        if (empty($_GET['usuario']) || empty($_GET['contrasena'])) {
            echo "<span style='font-weight:bold;color:red;'>Campos vacios.</span>";
        } else if (!empty($_GET['usuario']) || !empty($_GET['contrasena'])) {

            $datos = rand(0, 100);
            $total = 100;

            if (!empty($_GET['archivo'])) {
                $dir_subida = '/xampp/htdocs/TarjetasFelicitaciones/img/';
                $fichero_subido = $dir_subida . basename($_FILES['archivo']['name']);

                echo '<pre>';
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $fichero_subido)) {
                    echo "El fichero es válido y se subió con éxito.\n";
                } else {
                    echo "¡Posible ataque de subida de ficheros!\n";
                }

                echo 'Más información de depuración:';
                print_r($_FILES);

                print "</pre>";
            }


            $insert_value = 'INSERT INTO `felicitaciones`.`usuarios` (`email` ,`password` , `name`,`datosTotal`,`datosConsumidos`, `datosRestantes`, `cargo`, `imgPerfil`) VALUES ("","' . $_GET['contrasena'] . '", "' . $_GET['usuario'] . '","' . $total . '","' . $datos . '","' . ($total - $datos) . '",2,"' . $_GET['archivo'] . '")';

            $con->query($insert_value) or die("**ERROR: $con->error.<br/>");
            header("Location:inicio.php");
        }
    } else {
        echo "<span style='font-weight:bold;color:red;'>Usuario ocupado.</span>";
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registrate!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
    </head>
    <body>
        <div id="contenedor">
            <form enctype="multipart/form-data"   action="registro.php" method="GET">
                <div id="centro">
                    Usuario<input type="text" name="usuario">
                    Contraseña<input type="password" name="contrasena">
                    <label for="imagen">Imagen:</label>
                    <input   type="file"  id="archivo" name="archivo"/>
                    <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                    <button class="botones">Registrar</button>
                </div>
            </form>
        </div>
        <button class="botones"  onclick = "location = 'index.php'">inicio</button>
    </body>
</html>