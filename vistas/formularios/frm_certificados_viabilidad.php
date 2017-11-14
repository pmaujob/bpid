<?php
@session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 8; //id 8 pertenece a certificados viabilidad
const idEtapa = -6; //id 6 pertenece a los proyectos ya viabilizados
$sess = new SessionVars();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_certificados_viabilidad.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <?php require_once '../menu.php'; ?>            
            <form id='frm_meta_producto' name='frm_meta_producto' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="row">
                            <div class="col s12 m12 l12 center-align">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="titulofrm">CERTFICADOS DE VIABILIDAD</div>
                            </div>                            
                        </div>

                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="row">
                                    <div class="input-field col s12 m12 l12">
                                        <div class="opcionesbtn">
                                            <div class="file-field input-field">
                                                <div class="btn" onclick="buscarProyectos('<?php echo idEtapa; ?>', null);">
                                                    <span>Buscar proyecto</span>
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeyup="buscarProyectos('<?php echo idEtapa; ?>', event);">
                                                </div>
                                            </div>
                                            <div class="descripcion">&nbsp;&nbsp;&nbsp;Realice la búsqueda por número o nombre del proyecto.</div>
                                        </div>
                                    </div>
                                </div>
                                <div id="resultado" class="row">

                                </div>
                                <div id="esperarListas" style="text-align: center; margin-left: auto; margin-right: auto; display: none;">
                                    <img src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
                                </div>
                            </div>
                        </div>

                        <div id="divCertificados" style="display: none;">
                            <div class="row">
                                <div class="col s2 m4 l4">

                                </div>
                                <div class="col s8 m4 l4 center-align">
                                    <span id="txtCertificate">
                                        Certificado de NO viabilidad
                                    </span>
                                </div>
                                <div class="col s2 m2 l2">

                                </div>                            
                            </div>
                            <br>
                            <div class="row">
                                <div class="col s2 m4 l4">

                                </div>
                                <div class="col s8 m4 l4 center-align">
                                    <a href="#!" target="_blank" title="Ver Más" onclick="creteCertificate();">
                                        <img style="width: 25%; height: 25%;" src="../../vistas/img/pdf.png">
                                    </a>
                                </div>
                                <div class="col s2 m4 l4">

                                </div>
                            </div>
                        </div>

                    </div>      
                </div>
            </form>
        </body>

    </html>
    <?php
}
?>
