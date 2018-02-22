
<?php
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
$pag = isset($_GET["p"]) ? $_GET["p"] : 1;
$ini = ($pag - 1) * NREG;
$publicado = "SELECT * FROM tarjeta WHERE publicado = 'si' ORDER by votos DESC ";
$resultPublicado = $con->query($publicado) or die("**ERROR (): $con->error.<br/>");

if (isset($_GET["votar"])) {
    $update_values = "Update tarjeta Set votos =votos+1 Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
    $resultPublicado = $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
    header("Location:inicio.php");
}
if (isset($_GET["votar2"])) {
    $update_values2 = "Update tarjeta Set votos =votos+1 Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
    $resultPublicado2 = $con->query($update_values2) or die("**ERROR (): $con->error.<br/>");
    header("Location:inicio.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Logueado!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/estilo2.css">
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <script src="js/jquery-ui-1.10.3.custom.js"></script>
        <script src="js/jquery.js"></script>
        <script src="js/jquery-3.1.1.min.js" ></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script src="js/arbol.js"></script>
        <script src="js/phaser.min.js"></script>
        <script src="js/level1.js"></script>
        <script>
            $(document).ready(function () {
                
                console.log("Funciona query  ");
                //--- PAGINACION -----
                $(document).on("click", "#paginacion", function () {
                    console.log("Funciona onclick  ");
                    var numpage = $(this).data("page");
                    $.ajax({
                        url: "publico.php",
                        type: "get",
                        data: {p: numpage},
                        success: function (data) {
                            console.log("Data  " + data);
                            $("#publico").append(data);
                        }
                    });
                });
            });
        </script>
        <script>
            function titulo() {
                $(".cabeza").animate({opacity: 0}, 1000, 'linear');
                $(".cabeza").animate({opacity: 1}, 1000, 'linear');
            }
        </script>
    </head>

    <body onload="titulo()">
        <div id="fijos" >
            <?php
            require_once("conexion.php");
            $publicado5 = "SELECT * FROM usuarios WHERE name = '" . $_SESSION['usuario'] . "'";
            $resultPublicado5 = $con->query($publicado5);
            $obj5 = $resultPublicado5->fetch_object();
            ?>
            <div  id="fijo"  >
                <img class="materialboxed" style="border-radius: 20%" height="100" src="
                    <?php
                if ($obj5->imgPerfil !== '') {
                    echo 'img/' . $obj5->imgPerfil;
                } else
                    echo "imagen/sesion.png"
                    ?>">
                <div id="controles">
                    <form method="post" action="borrador.php">
                        <button id="crearTarjeta" class="botones">Crear Tarjeta</button>
                    </form>
                    <form method="post" action="amigos.php">
                        <button id="listarUsuarios" class="botones">Amigos</button>
                    </form>
                    <form method="post" action="inicio.php?destroy">
                        <button class="cerrar">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="cabeza">
            <div id="titulo"><h3>
                    <?php
                    echo $_SESSION['usuario'];
                    ?>    
                </h3>
            </div>
        </div>
        <div class="contenedor">
            <div class="navegador item">
            
                <div id="contenedor2">
                    <div class="" id="juego2"></div>
                </div>
                <div style="text-align: center">Top 3:</div>
                <div class="articulo">
                    <?php
                    $ranking = 0;
                    while ($obj = $resultPublicado->fetch_object()) {
                        if ($ranking < 3) {
                            ?> 
                            <div class="tarjetacol card-content" style="max-width: 300px; ">
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
            <div id="publico" class="articulo item">
                <?php require_once("publico.php"); ?>
            </div>
        </div>
        <div class="pie item">
            <p>&copy; 2018 feliceslosgatos.com<p>
        </div>
    </body>
</html>

<script>
    $(document).ready(function () {
        $('.materialboxed').materialbox();
        var options2 = [
            {selector: '#publico', offset: 600, callback: function () {
                    console.log("bien illo");
                }},
        ];
        Materialize.scrollFire(options2);

        //obtenemos la altura del documento
        var altura = $(document).height();
        var intervalo;

        function limpia() {
            clearInterval(intervalo);
        }

        function scrolling() {
            altura = $(document).height();
            console.log("aiva");
        }

        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() == altura) {
                console.log("Funciona onclick  ");
                var numpage = <?= $pag + 1 ?>;
                $.ajax({
                    url: "publico.php",
                    type: "get",
                    data: {p: numpage},
                    success: function (data) {
                        console.log("Data  " + data);
                        $("#publico").append(data);
                    }
                });
            }
        });
    });
</script>