<?php include "conexion.php"; ?>

<h4 align="center">Listado de mis borradores
	<span id="carga"><img src="img/ajax-loader.gif" id="cargando" /></span>
<select id="idtipo">
<option value="">------</option>
<?php
$consulta2 = "SELECT * FROM tarjeta WHERE publicado = 'no' ;";
$resultado2 = $con->query($consulta2) or die("**ERROR (): $con->error.<br/>");
while ($fila2 = $resultado2->fetch_Object()){?>
<option value="<?=$fila2->tarjeta_id?>"><?=$fila2->titulo?></option>
<?php } ?>
</select>
<input id="filtrar" type="button" value="filtrar" />
</h4>
