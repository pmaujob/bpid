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
        <meta charset="UTF-8">
        <title>BPID</title>
        <?php require_once $raiz . '/vistas/links.php'; ?>
        <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
    </head>
    <body>
        <div class="row">
            <div class="col s4 m4 l4">

            </div>
            <div class="col s4 m4 l4">
                <div class="col s12 m8 l12 center-align">
                    <div><img src="/img/logoajax.png" width="50%"></div>
                </div>
            </div>
            <div class="col s4 m4 l4">

            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col s2 m3 l3">

            </div>
            <div class="col s8 m6 l6">
                <span><strong>Estimado <?php echo "NOMBRE DEL CLIENTE."; ?></strong></span>      
            </div>
            <div class="col s2 m3 l3">

            </div>
        </div>
        <div class="row">
            <div class="col s2 m3 l3">

            </div>
            <div class="col s8 m6 l6">
                <p style="text-align: justify;">Informamos que su proyecto <strong><?php echo "NOMBRE DEL PROYECTO"; ?></strong> 
                    con número de radicación <strong><?php echo "NUMERO BPID"; ?></strong> cumplió con 
                    los requisitos de las listas de chequeo, y por ende, fue <strong>radicado con éxito.</strong>          
                </p>
                <br>
                <p>* Este es un email que se ha generado automáticamente, por favor no lo responda *</p>
            </div>
            <div class="col s2 m3 l3">

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col s2 m3 l3">

            </div>
            <div class="col s8 m6 l6">
                <p>Sí no tiene conocimiento sobre el tema, por favor ignore este mensaje.</p>
            </div>
            <div class="col s2 m3 l3">

            </div>            
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col s2 m3 l3">

            </div>
            <div class="col s4 m3 l3">
                <label>
                    <?php echo CambiarFormatos::cambiarFecha(date("m/d/Y")); ?>
                </label>
            </div>
            <div class="col s2 m3 l3 right-align">
                <img src="../vistas/img/logo-client.png" width="20%">
            </div>                
            <div class="col s4 m3 l3">
            </div>        
        </div>
    </body>
</html>

