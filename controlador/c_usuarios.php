<?php
#validar parametros antes de enviar ...crear funcion
#SE VERIFICA QUE LOS CAMPOS NO ESTEN VACIOS
if (isset($_POST['txt_parametro'])) {
    #SE VALIDA QUE SEA UN CORREO
    if (filter_var($_POST['txt_parametro'], FILTER_VALIDATE_EMAIL)) {
        $parametro = $_POST['txt_parametro'];
        //$contrasena = $_POST['txt_contrasena'];
        #A LA CONTRASEÑA SE LE QUITAN CARACTERES ESPECIALES PARA QUE NO AYA VULNERABILIDADES
        include_once "funciones.php";
        //$contrasena = tildes($contrasena);

        #UNA VEZ LIMPIOS LOS PARAMERTROS SE ENVIAN A CONSULTAR A LA BASE DE DATOS#
        #A TRAVES DE LA FUNCION iniciarSesion()
        #funcion que sirve para cargar automaticamente cualquier clase
        function autoload($clase)
        {
            require_once "../modelo/" . $clase . ".php";
        }
        spl_autoload_register('autoload');
        #SE LLAMA LA CLASE M_LOGIN Y SE ENVIAN LOS PARAMETROS A LA FUNCION iniciarSesion()
        $mensaje = m_usuarios::consultarUsuario($parametro);
        if ($mensaje == 1) {
            //header('location:../vistas/index.php');
        }if ($mensaje == 2) {
            echo "<script> alert('Error, Verifique su usuario o contraseña, vuelve a intentarlo')</script>";
            echo "<a href='../index.php'>Inicio</a>";
        }

    } else {
        echo ($_POST['txt_parametro'] . " Dirección de correo no válida");
    }
}
