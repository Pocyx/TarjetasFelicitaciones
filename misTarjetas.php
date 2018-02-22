<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Logueado!</title>
        <link rel="stylesheet" type="text/css" href="css/estilo.css">
        <link rel="stylesheet" type="text/css" href="css/estilo2.css">
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="js/arbol.js"></script>
        <script src="js/jquery-ui-1.10.3.custom.js"></script>
    </head>

    <body>
        <?php
        session_start();
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
            <div id="titulo"><h3>Mis tarjetas publicadas</h3></div>
        </div>

        <div class="contenedor">
            <div class="navegador item">
                <p>Feliz Navidad 
                    <?php
                    require_once("conexion.php");
                    $publicado5 = "SELECT * FROM usuarios WHERE name = '" . $_SESSION['usuario'] . "'";
                    $resultPublicado5 = $con->query($publicado5);
                    $obj5 = $resultPublicado5->fetch_object();
                    echo $obj5->imgPerfil;
                    echo $_SESSION['usuario'];
                    ?>
                </p>
                <form method="post" action="inicio.php?destroy">
                    <button class="cerrar">Cerrar sesión</button>
                </form>
                <div id="controles">
                    <form method="post" action="borrador.php">
                        <button id="misTarjetas" class="botones">Borrador</button>
                    </form>
                    <form method="post" action="inicio.php">
                        <button id="crearTarjeta" class="botones">Volver inicio</button>
                    </form>
                    <form enctype="multipart/form-data"   action="misTarjetas.php?foto" method="POST">
                        <input type="file"  id="archivo" name="archivo"/>
                        <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                        <button class="botones">Cambiar foto perfil</button>
                    </form>
                    <?php ?>
                </div>
            </div>
            <?php
            require_once("conexion.php");
            if (isset($_GET["foto"])) {
                $update_values = "Update usuarios Set imgPerfil='" . $_FILES['archivo']['name'] . "' Where name='" . $_SESSION['usuario'] . "'";
                $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
                $dir_subida = '/xampp/htdocs/PROYECTOMSQLIFELICITACIONES/img/';
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
                header("Location:inicio.php");
            }
            if (isset($_GET["modificar"])) {
                echo '---------' . $i;
                $update_values = "Update tarjeta Set publicado='no' Where tarjeta_id='" . $_POST['idTarjeta'] . "'";
                $con->query($update_values) or die("**ERROR (): $con->error.<br/>");
                header("Location:borrador.php");
            } else {
                if (empty($_GET['titulo']) || empty($_GET['texto'])) {
                    
                } else {
                    
                }
            }
            ?>
            <div class="articulo item">
                <?php
                $publicado = "SELECT * FROM tarjeta WHERE publicado = 'si' AND autor = '" . $_SESSION['usuario'] . "' ORDER by fecha DESC;";
                $resultPublicado = $con->query($publicado) or die("**ERROR (): $con->error.<br/>");
                while ($obj = $resultPublicado->fetch_object()) {
                    ?> 
                    <div class="tarjeta" style="max-width: 600px;" >
                        <div>
                            <FONT COLOR=RED>
                            <B><?= $obj->titulo; ?></B>
                            </FONT>
                        </div>
                        <div id="mensaje">
                            <?= $obj->texto; ?>
                        </div>
                        <div>
                            <?php
                            echo $obj->votos;
                            ?>
                        </div>
                        <form method="post" action="misTarjetas.php?modificar">
                            <input type="hidden" name="idTarjeta" value="<?= $obj->tarjeta_id; ?>">
                            <button id="publicar" class="botones">Modificar</button>
                        </form>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="pie item">
         

            

        </div>
    </body>
</html>
