<?php
require_once("conexion.php");
$publicado = "SELECT * FROM tarjeta WHERE publicado = 'si' ORDER by votos DESC;";
$resultPublicado = $con->query($publicado) or die("**ERROR (): $con->error.<br/>");
?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Logueado!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/estilo2.css">
        <script src="js/jquery-ui-1.10.3.custom.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/jquery-3.1.1.min.js" ></script>
        <script src="js/arbol.js"></script>
        <script>
            function titulo() {
                $(".cabeza").animate({opacity: 0}, 1000, 'linear');
                $(".cabeza").animate({opacity: 1}, 1000, 'linear');
            }
        </script>
        <script>
            $(document).ready(function () {
                $("#capaoculta").toggle();
                $("#registro").on("click", function () {
                    $("#capaoculta").toggle();
                });
            });
        </script>
    </head>

    <body onload="titulo()">
        <div class="cabeza">
            <div id="titulo"><h3>Tarjetas de felicitaciones</h3></div>
        </div>
        <div class="contenedor">
            <div class="navegador item">
                <div id="contenedor">
                    <form action="sesionUsuario.php" method="GET">
                        <div id="centro">
                            Usuario<input type="text" name="usuario">
                            Contraseña<input type="password" name="contrasena">
                            <button class="botones">Iniciar</button>
                        </div>
                    </form>
                </div>
                <br>
                <div id="controles">
                    <button id="registro" class="botones">No tengo cuenta!</button>
                </div>
                <div id="capaoculta">
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
                </div>
            </div>
            <div class="articulo item">
                <div style="text-align: center">Top 3:</div>
                <div class="articulo">
                    <?php
                    $ranking = 0;
                    while ($obj = $resultPublicado->fetch_object()) {
                        if ($ranking < 3) {
                            ?>                                                
                            <div class="tarjetacol" style="max-width: 700px; ">
                                <div id="mensaje">
                                    <?= $obj->texto; ?>
                                </div>
                                <div>
                                    <form method="post" action="inicio.php?votar">
                                        <!--$datos -> fecha??'' -->
                                        <input type="hidden" name="idTarjeta" value="<?= $obj->tarjeta_id; ?>">
                                        <button id="votar" class="botones cora"><span class="incrementavisita" ><?= $obj->votos; ?></span></button>
                                    </form>  
                                </div>
                            </div>
                            <?php
                            $ranking++;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="pie item">
            <p>&copy; 2018 feliceslosgatos.com<p>
        </div>
    </body>
</html>
