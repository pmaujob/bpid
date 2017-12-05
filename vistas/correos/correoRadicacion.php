<?php
date_default_timezone_set('America/Bogota');
session_start();

$raiz = $_SESSION['raiz'];
require_once $raiz . '/librerias/CambiarFormatos.php';

//$nomUsuario = $_POST['nomUsuario'];
//$nomProyecto = $_POST['nomProyecto'];
//$numBpid = $_POST['numBpid'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>BPID</title>
        <link type="text/css" rel="stylesheet" href="http://localhost/bpid/vistas/css/cssbpid/styles.css">
    </head>
    <body>
        <div>
            <img src="http://localhost/bpid/vistas/img/logoajax.png" width="20%">
            <img style="margin-right: 250px; margin-top: 20px;" align="right" src="http://localhost/bpid/vistas/img/logo-client.png" width="10%">
        </div>
        <br>
        <br>
        <div>
            <label align="bottom" style="color: #9E9E9E;">
                <?php echo CambiarFormatos::cambiarFecha(date("m/d/Y")); ?>
            </label>
        </div>        
        <br>
        <br>
        <div>
            <span><strong>Estimado <?php echo "NOMBRE DEL CLIENTE."; ?></strong></span>      
        </div>
        <div>
            <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo "NOMBRE DEL PROYECTO"; ?></strong> 
                con número de radicación <strong><?php echo "NUMERO BPID"; ?></strong> cumplió con 
                los requisitos de las listas de chequeo, y por ende, fue <strong>radicado con éxito.</strong>          
            </p>
            <br>
            <p>* Este es un email que se ha generado automáticamente, por favor no lo responda *</p>
        </div>
        <br>
        <div>
            <p style="color: #9E9E9E;">Sí no tiene conocimiento sobre el tema, por favor ignore este mensaje.</p>
        </div>
        <br>
    </body>
</html>

