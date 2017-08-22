<?php
@session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 4; //id 4 pertenece a consultar radicacion
const idEtapa = 2; //id 2 pertenece a los archivos ya radicados
$sess = new SessionVars();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_meta_producto.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">

            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <div id="modalm" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Lista de metas</h4>
                    <ul id="metaContainer" class="collapsible" style="height: auto; padding: 20px;">
                        <p>&nbsp;Cargando datos, por favor espere...</p>
                        <div style="text-align: center; margin-left: auto; margin-right: auto;">
                            <img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
                        </div>
                    </ul>
                </div>
                <div class="modal-footer">          
                    <span id="msjInfo" style="display: none; margin: 10px; color: #616161"></span>
                    <a id="modalg" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="insertarDatosPrograma();">Guardar Cambios</a>
                </div>
            </div>

            <?php require_once '../menu.php'; ?>
            <form id='frm_meta_producto' name='frm_meta_producto' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align">
                                    <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                    <div class="titulofrm">METAS DE PRODUCTO</div>
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
                                                    <div class="btn" onclick="buscarProyectos();">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeydown="buscarProyectos();">
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
    </html>
    <?php
}
?>
