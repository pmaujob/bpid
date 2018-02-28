<?php
session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 4; //id 2 pertenece a lista de checkeo
const idEtapa = 3;
$sess = new SessionVars();
if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_viabilidad.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div class="row">
                <div class="col s12 m4"></div>
                <div id="cargando" class="frm_externo col s12 m4 center-align"><img src="../css/wait.gif"></div>
            </div>
            <div id="d_ingreso" title="Información" style="display:none">

            </div>

            <div id="d_confirmacion" title="Información" style="display:none">
                <pre>El número de metas no puede ser mayor al número de actividades. 
                    ¿Desea regresar a la etapa de Metas de Producto?</pre>             
            </div>

            <div id="modal1" class="modal">
                <div class="modal-content" id="titulo">
                    <h5>Discriminación de Montos por Fuente de Financiación</h5>
                    <p></p>
                    <div id="respuestaact"></div>
                </div>
                <div id="cargando" class="frm_externo"><img src="../css/wait.gif"></div>
                <div class="modal-footer">
                    <span id="msjInfo" style="display: none; margin: 10px; color: #616161"></span>
                    <a  class="modal-action waves-effect waves-green btn-flat " onclick="guardarActividades()">Enviar</a>
                </div>
            </div>

            <?php require_once '../menu.php'; ?>
            <form id='frm_viabilidad' name='frm_viabilidad' onSubmit="return false"  enctype="multipart/form-data">
                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid" >
                            <div class="row">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="col s12 m12 l12 center-align">
                                    <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                        <i class="material-icons small left">insert_chart</i>
                                        Viabilidad del Proyecto
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>
                            <div class="row" >
                                <div class="col s12 m12 l12">
                                    <div class="row" id="buscador">
                                        <div class="input-field col s12 m12 l12">
                                            <div class="opcionesbtn">
                                                <div class="file-field input-field">
                                                    <div class="btn" onclick="buscarProyectos(<?php echo idEtapa; ?>, null);">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeyup="buscarProyectos(<?php echo idEtapa; ?>, event);">
                                                    </div>
                                                </div>
                                                <div class="descripcion">&nbsp;&nbsp;&nbsp;Realice la búsqueda por número o nombre del proyecto.</div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="wait" style="text-align: center; margin-left: auto; margin-right: auto; display: none;">
                                        <img src="./../css/wait.gif" style="width: 25%; height: 25%;" >
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
