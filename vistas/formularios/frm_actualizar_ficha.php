<?php
@session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 2; //id 2 pertenece a lista de checkeo
const idEtapa = 1; //id 1 etapa para buscar proyectos ingresados para radicar
$sess = new SessionVars();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_actualizar_ficha.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <form id='frm_act_ficha' name='frm_act_ficha' onSubmit="return false"  enctype="multipart/form-data">    
                <div id="modal1" class="modal modal-fixed-footer">
                    <div class="modal-content">

                        <a href="#!" onclick="cerrarModal();" style="margin-left: 95%; color: black;">
                            <i class="material-icons">close</i>                            
                        </a>

                        <h4>Lista de opciones</h4>
                        <p>Seleccione los items y agregue observaciones si es necesario.</p>
                        <ul id="collapsible" class="collapsible" data-collapsible="accordion">
                            <div style="text-align: center; margin-left: auto; margin-right: auto;">
                                <img id="esperarListas" src="./../css/wait.gif" style="width: 275px; height: 174,5px;" >
                            </div>
                        </ul>
                    </div>                    
                    <div class="modal-footer">                                                      
                        <span id="msjInfo" style="display: none; margin: 10px; color: #616161"></span>
                        <img id="waitGuardarProgreso" src="./../css/wait.gif" style="width: 68px; height: 43px; display: none" >

                        <a id="modale" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="validar(true);">Guardar y Envíar</a>
                        <a id="modalg" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="validar(false);">Guardar Progreso</a>
                    </div>
                </div>
            </form>

            <?php require_once '../menu.php'; ?>
            <form id='frm_radicar_listas' name='frm_radicar_listas' onSubmit="return false"  enctype="multipart/form-data">

                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="col s12 m12 l12 center-align">
                                    <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                        <i class="material-icons small left">update</i>
                                        Actualizar Datos Ficha de Radicacíon
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
