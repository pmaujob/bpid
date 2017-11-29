<?php
session_start();
$_SESSION['raiz'] = dirname(__FILE__);
$_SESSION['raizHtml'] = 'http://' . $_SERVER['SERVER_NAME'] . '/bpid';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Login BPID</title>
        <?php include_once 'vistas/links.php'; ?>
        <link rel="stylesheet" href="vistas/css/cssbpid/login.css" type="text/css">
        <script type="text/javascript" src="vistas/js/IpAddress.js"></script>
        <script type="text/javascript" src="vistas/js/formularios/frm_login.js"></script>
    </head>
    <body onload="onLoad();">
        <div id="loading" class="loading">
            <div class="logo-load">
                <div class="preloader-wrapper big active valign-wrapper">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div><div class="gap-patch">
                            <div class="circle"></div>
                        </div><div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col m3 l4"></div>
            <div class="frm-login col s12 m6 l4 center-align">
                <div class="row">
                    <form>
                        <div class="row">
                            <div class="col s12">
                                <img class="imgFormLogin" src="vistas/img/logoajax.png">
                            </div>
                            <div class="input-field col s12">
                                <input id="correo" type="text" class="validate">
                                <label for="correo">Usuario</label>
                            </div>
                            <div class="input-field col s12">
                                <input id="contrasena" type="password" class="validate" onkeydown="ingresar(event);">
                                <label for="contrasena">Contraseña</label>
                            </div>
                            <div class="col s12">
                                <a class="waves-effect waves-light btn btnLogin" onclick="ingresar(null);">Iniciar Sesión</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>                        
            <div class="col m3 l4"></div>
            <div id="logoc" class="logo-client">
                <img src="vistas/img/logo-client.png">
            </div>
        </div>
    </body>    
</html>
