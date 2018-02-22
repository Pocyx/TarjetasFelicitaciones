
<?php
//phpinfo() ;
session_start();
if (isset($_GET["destroy"])) {
    $_SESSION[] = array();
    session_destroy();
    header("Location:index.php");
    exit();
}

if (!isset($_SESSION["usuario"])) {
    header("Location:sesionUsuario.php");
}

require_once("conexion.php");
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Logueado!</title>
        <link rel="stylesheet" type="text/css" href="css/usuarios3.css">
        <link rel="stylesheet" type="text/css" href="css/usuarios1.css">
        <link rel="stylesheet" type="text/css" href="css/usuarios2.css">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="jquery-2.1.4.min.js"></script>
        <script src="js/jquery-3.1.1.min.js" ></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script src="js/Chart.js"></script>

        <script>
            function titulo() {
                $(".cabeza").animate({opacity: 0}, 1000, 'linear');
                $(".cabeza").animate({opacity: 1}, 1000, 'linear');
            }
        </script>
    </head>
    
    <body onload="titulo()" class="table-dark">
        <div id="fijos" >
            <?php
            require_once("conexion.php");

            $UsuarioActual = "SELECT * FROM usuarios WHERE name = '" . $_SESSION['usuario'] . "'";
            $resultUsuarioActual = $con->query($UsuarioActual);
            $obj5 = $resultUsuarioActual->fetch_object();
            ?>

            <div  id="fijo"  >
                <div class="pos-f-t">
                    <div class="collapse" id="navbarToggleExternalContent">
                        <div class="bg-dark p-4">
                            <div id="controles">
                                <form method="post" action="inicio.php">
                                    <button class="cerrar">inicio</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <nav class="navbar navbar-dark bg-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span ><?= $_SESSION['usuario']; ?> </span>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
        <div  class="cabeza bg-dark">
            <div id="titulo">
                <h3>
                <?php
                require_once("conexion.php");

                $publicado = "SELECT * FROM usuarios WHERE name = '" . $_SESSION['usuario'] . "'";
                $resultPublicado = $con->query($publicado);
                $obj = $resultPublicado->fetch_object();
                if ($obj->cargo == 1)
                    echo 'Administración de usuarios';
                else
                    echo 'Amigos';
                ?>    
                </h3>
            </div>
        </div>
        <div class="contenedor">
            <div class="navegador item">
                <div style="text-align: center"><?= $_SESSION['usuario']; ?> </div>
                <div class="articulo">

                    Mensajes:
                    <?php
                    

                    echo $obj->datosConsumidos;

                    echo $obj->datosRestantes;
                    ?>
                    <div class="login-container" style="width: 300px">
                        <canvas id="datos2" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
            <div id="publico" class="articulo item">              
                <?php
                if ($obj->cargo == 1)
                    require_once("administrador.php");
                else
                    echo '<p>Tienes que ser administrador para ver el contenido</p>';
                ?>
            </div>
        </div>
        <div class="pie item">
            <p>&copy; 2018 feliceslosgatos.com<p>
        </div>
    </body>
</html>


<script>
    var consumoCanvas = document.getElementById("datos2");

    Chart.defaults.global.defaultFontFamily = "Lato";
    Chart.defaults.global.defaultFontSize = 18;

    var consumoData = {
        labels: [
            "Enviados",
            "Recividos"
        ],
        datasets: [
            {
                data: [<?= $obj->datosRestantes ?>, <?= $obj->datosConsumidos ?>],
                backgroundColor: [
                    "#63FF84",
                    "#c40003"
                ]
            }]
    };

    var pieChart = new Chart(consumoCanvas, {
        type: 'pie',
        data: consumoData
    });
</script>