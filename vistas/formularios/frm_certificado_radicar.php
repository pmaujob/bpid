<?php
session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

        const idFormulario = 3;
        const idEtapa = -2;
$sess = new SessionVars();
$sess->init();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>
    <!DOCTYPE html>

    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_certificado_radicar.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>
            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">

            <div id="mas" class="frm_externo">
                <div class="cerrar" onclick="cerrarFrmExterno('mas');"></div>
                <div class="form_ext">


                    <hr>
                    <div class="row">
                        <div class="col s6 m4 l4 lab"><div class="lab">FUENTES DE FINANCIAZIÓN</div></div>
                        <label>Proyecto 1</label>
                    </div>
                </div>

            </div>

            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>

            <?php require_once '../menu.php'; ?>
            <form id='frm_consultar_radicacion' name='frm_consultar_radicacion' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align">
                                    <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                    <div class="col s12 m12 l12 center-align">
                                        <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                            <i class="material-icons small left">library_books</i>
                                            Generar Ficha Radicación
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div class="input-field col s12 m12 l12">
                                            <div class="opcionesbtn">
                                                <div class="file-field input-field">
                                                    <div class="btn" onclick="buscarCertificaciones(<?php echo idEtapa; ?>, null);">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeyup="buscarCertificaciones(<?php echo idEtapa; ?>, event);">
                                                    </div>
                                                </div>
                                                <div class="descripcion">&nbsp;&nbsp;&nbsp;Realice la búsqueda por número o nombre del proyecto.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="resultado" class="row">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </body>

    </body>
    <?php
} else {
    $ruta = $_SESSION['raiz'];
    $ruta = '../index.php';
    header("location: $ruta");

    echo $ruta;
}
?>