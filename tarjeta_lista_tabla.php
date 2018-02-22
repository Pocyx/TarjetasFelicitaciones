<?php
include "conexion.php";
//Solo en el caso de que se pulse para buscar por idtipo se duerme un segundo el servidor
if (!empty($_POST["idtipo"]) && empty($_POST["idinmueble"]))
    sleep(1);



$i = 0;
$consulta = "SELECT * FROM tarjeta WHERE publicado = 'no' ";


//Consulta en función de fecha
if (!empty($_GET["busquedadfecha"])) {
    $consulta.= " AND i.autor LIKE '%" . $_GET["busquedadireccion"] . "%' ";
}

//Si llega el parametro ordenapor se ordena por ese campo
if (!empty($_POST["idtipo"]))
    $consulta .= " AND tarjeta_id=" . $_POST["idtipo"];

$resultado = $con->query($consulta) or die("**ERROR (): $con->error.<br/>");
?>




<table id="tabladatos" align="center" >
    <tr align="center">
        <th>Autor</th>	
        <th>Titulo</th>
        <th>Publico</th>  
        <th>Acción</th>                              
    </tr>
    <?php while ($fila = $resultado->fetch_Object()) { ?>
        <tr id="<?= $fila->tarjeta_id ?>" align="center" data-idtarjeta="<?= $fila->tarjeta_id ?>">
            <td class="autor"><?= $fila->autor ?></td>
            <td class="titulo" name="<?= $fila->titulo ?>"><?= $fila->titulo?></td>
            <td class="visita">
                <span class="incrementavisita" >
                    <a href="#"><?= $fila->publicado; ?></a></span> 
            </td>
            <td> <button id="borrar" class="botones borrar" data-page="<?= $fila->tarjeta_id; ?>">Borrar</button>
                &nbsp;<button id="modificar" class="botones modificar">Modificar</button>
            </td>
        </tr>
    <?php }//while  ?>
</table>
<?php //} //if   ?>


