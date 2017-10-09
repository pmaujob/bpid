<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/modelo/MGetMenu.php';

$modulos = MGetMenu::getMenu(2);
$funciones = MGetMenu::getMenu(1);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    </head>
    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="head-usuario col s12 m12 l12">
                    <div class="usuario">
                        <a id="btnUserMenu" href="#" data-activates="dropdown" class="dropdown-button" style="float: right; width: 230px;">
                            <img src="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid/vistas/img/usuario.png' ?>">
                        </a>
                        <ul class='dropdown-content' id="dropdown" style="float:right; margin-top: 65px;">
                            <li><a href="#!" style="color: #008643;"><i class="material-icons">vpn_key</i>Cambiar Contraseña</a></li>
                            <li><a href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid/controlador/CLogout.php' ?>" style="color: #008643;"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="contenedor-menu col s12 m4 l2">
                    <div class="logo">
                        <img src="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid/vistas/img/bpid.svg' ?>">
                    </div>
                    <a href="#" class="btn-menu">Menú<i class="icono small material-icons">dehaze</i></a>
                    <ul class="menu">
                        <?php
                        if (count($modulos) > 0) {
                            foreach ($modulos as $fila) {
                                ?>
                                <li><a href="#"><?php echo $fila[1]; ?></a>
                                    <ul>
                                        <?php
                                        $funciones = MGetMenu::getMenu(1);

                                        foreach ($funciones as $fila2) {
                                            if ($fila[0] == $fila2[0]) {
                                                ?>

                                                <li><a onclick="location.href = '<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid' . $fila2[3]; ?>'" href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . '/bpid' . $fila2[3]; ?>"><?php echo $fila2[2]; ?></a></li>

                                                <?php
                                            }
                                        }
                                        ?>

                                    </ul>        
                                </li>  
                                <?php
                            }
                        } else {

                            echo "Este usuario no tiene acceso a ningun modulo";
                        }
                        ?>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4 l2">

                </div>

                </body>
                </html>