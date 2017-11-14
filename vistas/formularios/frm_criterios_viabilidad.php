<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/MPermisos.php';

        const idFormulario = 7;
        const idEtapa = 4;

$sess = new SessionVars();

if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_criterios_viabilidad.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div id="semaforo" class="semaforo">
                <div id="bonbilla" class="bonbilla">

                </div>
            </div>
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <form id="frm_listas" action="../../controlador/ControladorArchivosRadicacion.php" method="POST" enctype="multipart/form-data">
                <div id="modal1" class="modal modal-fixed-footer">
                    <a href="#!" onclick="cerrarModal();" style="margin-left: 95%; color: black;">
                        <i class="material-icons" style="margin-top: 16px;">close</i>                            
                    </a>
                    <div class="modal-content">
                        <h4>Lista de criterios</h4>
                        <p>Seleccione los items y agregue observaciones si es necesario.</p>
                        <ul id="collapsible" class="collapsible" data-collapsible="accordion">
                            <div style="text-align: center; margin-left: auto; margin-right: auto;">
                                <img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
                            </div>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a id="modale" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="registrarCriterios(1);">Guardar y Enviar</a>
                        <a id="modale" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="registrarCriterios(2);">Guardar Progreso</a>
                    </div>
                </div>
            </form>

            <?php require_once '../menu.php'; ?>
            <form id='frm_radicar_listas' name='frm_criterios_viabilidad' onSubmit="return false"  enctype="multipart/form-data">

                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div id="container" class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="col s12 m12 l12 center-align">
                                    <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                        <i class="material-icons small left">storage</i>
                                        Metas de Producto
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
