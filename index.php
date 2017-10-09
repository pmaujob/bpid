<?php
session_start();
$_SESSION['raiz'] = dirname(__FILE__);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login BPID</title>
        <?php include_once 'vistas/links.php'; ?>
        <link rel="stylesheet" href="vistas/css/cssbpid/login.css" type="text/css">
        <script type="text/javascript" src="vistas/js/formularios/frm_login.js"></script>
        <script type="text/javascript" src="vistas/js/IpAddress.js"></script>
        <script type="text/javascript" src="vistas/js/formularios/frm_login.js"></script>
    </head>
    <body>
        <div id="contenedor">
            <div id="izquierda">
                <div id="imglogin">
                    <div id="botones">
                        <label style="color: white;">Usuario</label><br>
                        <input class="btnslogin" type="text" id="correo" placeholder="tucorreo@dominio.com" onkeydown="ingresar(event);"><br>
                        <label style="color: white;">Contraseña</label><br>
                        <input class="btnslogin" type="password" id="contrasena" placeholder="123456" onkeydown="ingresar(event);"><br><br>
                        <a class="btn" id="btnenviar" style="width: 140px; height: 35px; font-size: 10px; margin-top: 5px;" onclick="ingresar(null);">Iniciar Sesión</a>
                    </div>
                </div>
            </div>

            <div id="derecha">
                <div id="imglogo"></div>
            </div>
        </div>
    </body>
</html>
