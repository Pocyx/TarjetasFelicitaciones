<!DOCTYPE html>
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Logueado!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/estilo2.css">
        <link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css" href="js/jquery-ui/jquery-ui.theme.min.css"/>
        <script src="js/jquery.js"></script>
        <script src="js/jquery-3.1.1.min.js" ></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/arbol.js"></script>


        <style>
            #commentForm {
                width: 500px;
            }
            #commentForm label {
                width: 250px;
            }
            #commentForm label.error, #commentForm input.submit {
                margin-left: 253px;
            }
            #signupForm {
                width: 670px;
            }
            #signupForm label.error {
                margin-left: 10px;
                width: auto;
                display: inline;
            }
            #newsletter_topics label.error {
                display: none;
                margin-left: 103px;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function () {




                $("#commentForm").validate({
                    rules: {
                        vtitulo: "required"
                    },
                    messages: {
                        vtitulo: "Please enter your titulo"
                    }
                });
                var idTarjeta;
                //---------------------------------------------------
                //DIALOGO DE BORRADO
                $("#dialogoborrar").dialog({
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    buttons: {
                        //BOTON DE BORRAR
                        "Borrar": function () {
                            //Ajax con get
                            $.post("borrarTarjeta.php", {"idTarjeta": idTarjeta}, function () {
                                console.log(idTarjeta);
                                $("#" + idTarjeta).fadeOut(500, function () {
                                    $(this).remove();
                                });
                            })//get			
                            //Cerrar la ventana de dialogo				
                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            //Cerrar la ventana de dialogo
                            $(this).dialog("close");
                        }
                    }//buttons
                });

                //Evento click que pulsa el boton borrar
                $(document).on("click", ".borrar", function () {
                    //Obtenemos el idinmueble a eliminar
                    //a traves del atributo idrecord del tr
                    idTarjeta = $(this).data("page");
                    //Accion para mostrar el dialogo de borrar
                    $("#dialogoborrar").dialog("open");
                });
                
                
                //---------------------------------------------------
        //MODIFICAR
                $("#dialogomodificar").dialog({
                    autoOpen: false,
                    resizable: false,
                    modal: true,
                    buttons: {
                        "Guardar": function () {
                            $.post("tarjeta_modificar.php", {
                                idtarjetamodificar: idTarjeta,
                                titulomodificar: $("#titulomodificar").val()
                            
                             
                            }, function (data, status) {
                                $("#contenedor77").html(data);
                            })//get			

                            $(this).dialog("close");
                        },
                        "Cancelar": function () {
                            $(this).dialog("close");
                        }
                    }//buttons
                });

        //Boton Modificar	
                $(document).on("click", ".modificar", function () {
                    //Obtenemos la tarjeta de la fila
                    idTarjeta = $(this).parents("tr").data("idtarjeta");
                    //Para que ponga el campo titulo con su valor
                    $("#titulomodificar").val($(this).parent().siblings("td.titulo").html());

                 

                    //Muestro el dialogo
                    $("#dialogomodificar").dialog("open")

                });

            });//ready
        </script>


        <script>
            $(function () {
                $("#fecha_envio").datepicker();
            });
        </script>


    </head>

    <body>
        <?php
        
        if (isset($_GET["destroy"])) {
            $_SESSION[] = array();
            session_destroy();
            header("Location:sesionUsuario.php");
            exit();
        }

        if (!isset($_SESSION["usuario"])) {

            header("Location:sesionUsuario.php");
        }
        ?>

        <div class="cabeza">
            <div id="titulo"><h3>Borrador de tarjetas</h3></div>
        </div>

        <div class="contenedor">
            <div class="navegador item">

                <div id="openweathermap-widget-15"></div>
                <script>window.myWidgetParam ? window.myWidgetParam : window.myWidgetParam = [];
                    window.myWidgetParam.push({id: 15, cityid: '6359472', appid: '64020258dc7aaf5fae45e5aa74a8300e', units: 'metric', containerid: 'openweathermap-widget-15', });
                    (function () {
                        var script = document.createElement('script');
                        script.async = true;
                        script.charset = "utf-8";
                        script.src = "//openweathermap.org/themes/openweathermap/assets/vendor/owm/js/weather-widget-generator.js";
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(script, s);
                    })();</script>


                <p>Feliz Navidad 
                    <?php
                    echo $_SESSION['usuario'];
                    ?>
                </p>
                <form method="post" action="inicio.php?destroy">
                    <button class="cerrar">Cerrar sesión</button>
                </form>
                <div id="controles">
                    <form method="post" action="mistarjetas.php">
                        <button id="misTarjetas" class="botones">Mis tarjetas</button>
                    </form>
                    <form method="post" action="inicio.php">
                        <button id="crearTarjeta" class="botones">Volver inicio</button>
                    </form>
                </div>
            </div>
            <?php
            require_once("conexion.php");
            if (isset($_GET["borrar"])) {
                $update_values = "Delete From tarjeta  Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
                header("Location:borrador.php");
            }
            if (isset($_GET["editar"])) {
                $update_values = "Update tarjeta Set titulo='" . $_POST['vtitulo'] . "', texto='" . $_POST['texto'] . "' Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
                $fecha_registro = date('Y-m-d H:i:s'); // establecemos la fecha actual
                $update_fecha = "UPDATE tarjeta SET fecha='$fecha_registro' where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_fecha) or die("**ERROR (): $con->error.<br/>");
            }
            if (isset($_GET["publicar"])) {
                $update_values = "Update tarjeta Set publicado='si' Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
                $fecha_registro = date('Y-m-d H:i:s'); // establecemos la fecha actual
                $update_fecha = "UPDATE tarjeta SET fecha='$fecha_registro' where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_fecha) or die("**ERROR (): $con->error.<br/>");
            } else {
                if (empty($_POST['vtitulo']) || empty($_POST['texto']) || empty($_POST['fecha_envio'])) {
                    
                } else {
                    $fecha_registro = date('Y-m-d H:i:s');
                    $insert_value = 'INSERT INTO `felicitaciones`.`tarjeta` (`fecha`,`fecha_envio` ,`autor` , `titulo`, `texto`, `publicado`, `destinatario`, `imgTarjeta`, `votos`) '
                            . 'VALUES ("' . $fecha_registro . '","' . $_POST['fecha_envio'] . '","' . $_SESSION['usuario'] . '", "' . $_POST['vtitulo'] . '", "' . $_POST['texto'] . '","no","","","")';
                    $con->query($insert_value) or die("**ERROR (): $con->error.<br/>");
                }
            }
            ?>
            <div class="articulo item">
                <section  style="background-color: greenyellow;  color: black; max-width: 40%">
                    <form class="cmxform" id="commentForm" method="post" action="borrador.php" name="graba">

                        <p>
                            <label for="fecha_envio">Fecha de envio:</br>
                                <input type="text" id="fecha_envio" value="" name="fecha_envio"/>
                            </label> 
                        </p>

                        <label for="vtitulo">Título:</label></br>
                        <input style="max-width: 60% "type="text" id="submit vtitulo" name="vtitulo" size="50" required></br>
                        <label for="vtitulo">Felicitación:</label></br>
                        <textarea id="submit" name="texto" rows="10" cols="40" style=" padding: 7px 6px; max-width: 50%; height: 150px; border: 1px solid #4b8f29; resize: vertical; box-shadow: 0 0 0 3px #3e7327; margin: 5px 0;"></textarea></br>
                        <input type="submit" name="submit" id="submit" value="Guardar"/>       
                    </form>
                </section>
                <div id="contenedor77">

                <?php
                    $usuarios = "SELECT * FROM usuarios WHERE name = '" . $_SESSION['usuario'] . "'";
                    $resultadoUsuario = $con->query($usuarios);
                    $objUsuario = $resultadoUsuario->fetch_object();
                    if ($objUsuario->cargo == 1){
                        require_once("tarjeta_lista_tabla.php");
                        require_once("lista_cabecera.php");
                    }    
                        
                ?>

                </div>
           
                <?php
                   
                    if ($objUsuario->cargo == 1){
               
                        require_once("lista_cabecera.php");
                    }    
                        
                ?>


                <?php
                $i = 0;
                $publicado = "SELECT * FROM tarjeta WHERE publicado = 'no' AND autor = '" . $_SESSION['usuario'] . "'ORDER by fecha DESC;";
                $resultPublicado = $con->query($publicado) or die("**ERROR (): $con->error.<br/>");

                while ($obj = $resultPublicado->fetch_object()) {
                    ?> 
                    <div class="tarjeta" style="max-width: 600px;" id="<?= $obj->tarjeta_id; ?>">
                        <form method="post" action="borrador.php?editar">
                            <div>
                                <FONT COLOR=RED>
                                <input style="max-width: 80% "type="text" id="submit vtitulo" name="vtitulo" size="50" value="<?= $obj->titulo; ?>" required>
                                </FONT>
                            </div>
                            <div id="mensaje">
                                <textarea id="submit" name="texto" rows="10" cols="40" style=" padding: 7px 6px; max-width: 100%; height: 150px; border: 1px solid #4b8f29; resize: vertical; box-shadow: 0 0 0 3px #3e7327; margin: 5px 0;">
                                    <?= $obj->texto; ?>
                                </textarea>
                            </div>
                            <div>
                                <?php
                                echo $obj->tarjeta_id;
                                ?>
                            </div>
                            <input type="hidden" name="idTarjeta" value="<?= $obj->tarjeta_id; ?>">
                            <button id="editar" class="botones">Editar</button>
                        </form>
                        <div id="modificarbtn">
                            <form method="post" action="borrador.php?publicar">
                                <input type="hidden" name="idTarjeta" value="<?= $obj->tarjeta_id; ?>">
                                <button id="publicar" class="botones">Publicar</button>
                            </form>
                            <button id="borrar" class="botones borrar" data-page="<?= $obj->tarjeta_id; ?>">Borrar</button>
                            <!--<form method="post" action="borrador.php?borrar=borrar">
                                <input type="hidden" name="idTarjeta" value="<?= $obj->tarjeta_id; ?>">
                                <button id="borrar2" class="botones borrar">Borrar</button>-->
                            </form>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="pie item">
            <div>
            </div>

        </div>
        
        <!-- CAPA DE DIALOGO MODIFICAR INMUEBLE -->
        <div id="dialogomodificar" title="Modificar Tarjeta">
            <?php include "tarjeta_formulario_modificar.php" ?>
        </div>

        <!-- CAPA DE DIALOGO ELIMINAR TARJETA -->
        <div id="dialogoborrar" title="Eliminar Tarjeta">
            <p>¿Esta seguro que desea eliminar la tarjeta?</p>
        </div>

    </body>
</html>

<script type="text/javascript">
    $(document).ready(function () {

        // FILTRAR				
        $(document).on("click", "#filtrar", function () {		//Cargo en la vble global el tipo seleccionado			
            idtipo = $("#idtipo").val();
            //Llamo Ajax con la función ajax
            $.ajax({
                url: "tarjeta_lista_tabla.php",
                data: {idtipo: idtipo},
                type: "post",
                beforeSend: cargar,
                success: filtratabla,
                complete: fin,
                cache: false
            });//ajax														

        });

        //Se ejecuta en el tiempo de espera del servidor
        function cargar() {
            //Muestra el gráfico de cargar
            $("#cargando").show();
        }

        //Cargar en el contenedor el resultado de la tabla con filtro				
        function filtratabla(data) {
            $("#contenedor77").html(data);
        }

        //Una vez cargado vuelve a ocultar el gif animado			
        function fin() {
            $("#cargando").hide();
        }
    });
</script>