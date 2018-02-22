<?php
    if ($obj->cargo == 1)
        require_once("borradorAdmin.php");
    else
    require_once("borradorUsuario.php");
?>