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
                        <form>
                            <label>Usuario</label><br>
                            <input class="btnslogin" type="text" id="correo" placeholder="tucorreo@dominio.com"><br>
                            <label>Contraseña</label><br>
                            <input class="btnslogin" type="password" id="contrasena" placeholder="123456"><br><br>
                            <input type="button" id="btnenviar" value="Iniciar sesión" onclick="ingresar();">
                        </form>
                    </div>
                </div>
            </div>

            <div id="derecha">
                <div id="imglogo"></div>
            </div>
        </div>
    </body>
</html>
