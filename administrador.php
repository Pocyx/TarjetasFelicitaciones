<!DOCTYPE html>

<?php
require_once("conexion.php");

    $publicado2 = "SELECT * FROM usuarios ";
    $resultPublicado2 = $con->query($publicado2) or die("**ERROR : $con->error.<br/>");

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <script src="js/Chart.js"></script>
    </head>

    <body>
        
        <table class="table table-hover table-dark">
            <thead>
                <tr >
                <th scope="col"><kbd>ID</kbd></th>
                <th scope="col">Nombre</th>
                <th scope="col">Datos Restantes</th>
                <th scope="col">Datos Consumidos</th>
                </tr>
            </thead>

            <tbody>
                <?php
                    while ($obj2 = $resultPublicado2->fetch_object()) {
                ?> 
                <tr>
                    <th scope="row"><?= $obj2->id; ?></th>
                    <td><?= $obj2->name; ?></td>
                    <td>    
                        <div id="total" style="backgroundColor: green; width:100px; height:25px; z-index: 5" >
                            <div id="restantes" style="backgroundColor: red; width:<?= $obj2->datosRestantes; ?>px; height:25px; z-index: 5" >
                                <?= $obj2->datosRestantes; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div id="total" style="backgroundColor: green; width:100px; height:25px; z-index: 5" >
                            <div id="consumidos" style="backgroundColor: red; width:<?= $obj2->datosConsumidos; ?>px; height:25px; z-index: 5" >
                                    <?= $obj2->datosConsumidos; ?>
                            </div>
                        </div>
                    </td>
               </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </body>    
</html>

