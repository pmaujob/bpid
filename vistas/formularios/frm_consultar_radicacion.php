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
            <script type="text/javascript" src="../js/formularios/frm_consultar_radicacion.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>
        <body onload="onLoadBody();">

            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div><
            <div id="modal1" class="modal modal-fixed-footer">
                <div class="modal-content">
                    <h4>Información del Proyecto</h4>
                    <p>A continuación se mostrará la información de radicación del proyecto</p>
                    <ul id="collapsible" class="collapsible" data-collapsible="accordion"> 
                        <div style="text-align: center; margin-left: auto; margin-right: auto;">
                            <img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
                        </div>
                    </ul>
                </div>
                <div class="modal-footer">          
                    <a id="modalg" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="cerrar();">Cerrar</a>
                </div>
            </div>

            <?php require_once '../menu.php'; ?>
            <form id='frm_consultar_radicacion' name='frm_consultar_radicacion' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align">
                                    <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                    <div class="titulofrm">CONSULTAR RADICACIÓN</div>
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
                                                    <div class="btn" onclick="buscarProyectosRadicados('<?php echo idEtapa; ?>');">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeydown="buscarProyectosRadicados('<?php echo idEtapa; ?>');">
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
} else {
    $ruta = $_SESSION['raiz'];
    $ruta = '../index.php';
    header("location: $ruta");

    echo $ruta;
}
?>

