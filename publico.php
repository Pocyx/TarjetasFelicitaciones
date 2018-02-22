<!DOCTYPE html>

<?php
require_once("conexion.php");
$pag = isset($_GET["p"]) ? $_GET["p"] : 1;
$ini = ($pag - 1) * NREG;
$publicado2 = "SELECT *,DATE_FORMAT(fecha,'%d-%m-%Y || %H:%i:%S') AS fecha FROM tarjeta WHERE publicado = 'si' ORDER by tarjeta_id DESC limit " . $ini . ", " . NREG . ";";
$resultPublicado2 = $con->query($publicado2) or die("**ERROR : $con->error.<br/>");
$numTarjeta = 0;
$numRespuesta = 0;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        if (empty($_GET['tituloR']) || empty($_GET['textoR'])) {
            
        } else {
            session_start();
            $obj2 = $resultPublicado2->fetch_object();
            $fecha_registro = date('Y-m-d H:i:s');
            $insert_value = 'INSERT INTO `felicitaciones`.`respuesta` (`fecha` ,`autor` , `titulo`,`texto`, `tarjeta_id`)  '
                    . 'VALUES ("' . $fecha_registro . '","' . $_SESSION['usuario'] . '", "' . $_GET['tituloR'] . '", "' . $_GET['textoR'] . '","' . $obj2->tarjeta_id . '")';


            $con->query($insert_value) or die("**ERROR (): $con->error.<br/>");

            header("Location:inicio.php");
        }
        while ($obj2 = $resultPublicado2->fetch_object()) {
            ?> 
            <div class="tarjetacol card" style="max-width: 700px;">
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a href="#">Compartir</a></li>
                        <li class="tab">
                            <form method="post" action="inicio.php?votar2">
                                <input type="hidden" name="idTarjeta" value="<?= $obj2->tarjeta_id; ?>">
                                <button id="votar" class="botones cora"><span class="incrementavisita" ><?= $obj2->votos; ?></span></button>
                            </form> 
                        </li>
                        <li class="tab"><a href="#comentarios<?= $numTarjeta ?>">Comentar</a></li>
                    </ul>
                </div>
                <ul class="collapsible popout" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header active">
                            <ul class="tabs tabs-fixed-width">
                                <li class="tab"><a href="#test4">Hilo: <?= $obj2->titulo; ?></a></li>
                                <li class="tab"><a class="active" href="#test5">Autor: <?= $obj2->autor; ?></a></li>
                                <li class="tab"><a href="#test6">Fecha: <?= $obj2->fecha; ?></a></li>
                            </ul>
                        </div>
                        <div class="collapsible-body">
                            <?= $obj2->texto; ?>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header">Comentarios</div>
                        <div id="comentarios<?= $numTarjeta ?>" class="collapsible-body">
                            <div style="display: flex; flex-direction: column;">
                                <form method="get" action="publico.php" class="col s12 card" style="background: wheat">
                                    <div class="row">
                                        <div class="input-field col s6">
                                            <input id="icon_prefix" name="tituloR" type="text" class="validate">
                                            <label for="icon_prefix">Titulo</label>
                                        </div>
                                        <div class="input-field col s12">
                                            <input id="email" name="textoR" type="text" class="validate">
                                            <label for="email" data-error="wrong" data-success="right">Texto</label>
                                        </div>
                                    </div>
                                    <div><input type="submit" name="comentar" /></div>       
                                </form>
                                <?php
                                $publicadoR = "SELECT *,DATE_FORMAT(fecha,'%d-%m-%Y || %H:%i:%S') AS fecha FROM respuesta WHERE tarjeta_id = '" . $obj2->tarjeta_id . "' ORDER by respuesta_id DESC ;";
                                $resultPublicadoR = $con->query($publicadoR) or die("**ERROR : $con->error.<br/>");
                                while ($objR = $resultPublicadoR->fetch_object()) {
                                    ?> 
                                    <div class="tarjetacol card" style="max-width: 700px;">
                                        <ul class="collapsible popout" data-collapsible="accordion">
                                            <li>
                                                <div class="collapsible-header active">
                                                    <ul class="tabs tabs-fixed-width">
                                                        <li class="tab"><a href="#test4">Hilo: <?= $objR->titulo; ?></a></li>
                                                        <li class="tab"><a class="active" href="#test5">Autor: <?= $objR->autor; ?></a></li>
                                                        <li class="tab"><a href="#test6">Fecha: <?= $objR->fecha; ?></a></li>
                                                    </ul>
                                                </div>
                                                <div class="collapsible-body">
                                                    <?= $objR->texto; ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <?php
                                    $numRespuesta++;
                                }
                                ?>
                            </div>
                        </div>
                    </li>
                </ul>

            </div>
            <?php
            $numTarjeta++;
        }
        ?>
        <button id="paginacion" data-page= <?= $pag + 1 ?>>Mostrar mas <?= $pag + 1 ?></button>
    </body>
</html>


<script>
    $(document).ready(function () {
        $('.collapsible').collapsible();
    });
</script>