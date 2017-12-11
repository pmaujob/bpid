<?php
@session_start();

$raiz = $_SESSION['raiz'];

require_once $raiz . '/librerias/SessionVars.php';
require_once $raiz . '/modelo/MPermisos.php';

        const idFormulario = 9;
        const idEtapa = 5;

$sess = new SessionVars();

if ($sess->exist() && $sess->varExist('cedula') && MPermisos::tienePermiso($sess->getValue('cedula'), idFormulario)) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>BPID</title>
            <?php require_once '../links.php'; ?>
            <script type="text/javascript" src="../js/formularios/frm_finalizar_viabilidad.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>

            <link type="text/css" rel="stylesheet" href="../css/cssbpid/styles.css">
        </head>

        <body onload="onLoadBody();">
            <div class="row">
                <div class="col s12 m4"></div>
                <div id="cargando" class="frm_externo col s12 m4 center-align"><img src="../css/wait.gif"></div>
            </div>
            <div id="semaforo" class="semaforo">
                <div id="bonbilla" class="bonbilla">

                </div>
            </div>
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>

            <div id="modal1" class="modal modal-fixed-footer">
                <a href="#!" onclick="cerrarModal();" style="margin-left: 95%; color: black;">
                    <i class="material-icons" style="margin-top: 16px;">close</i>                            
                </a>
                <div class="modal-content">
                    <h4>Resultado de la viabilidad</h4>
                    <p>Agregue los responsables del proyecto y verifique información.</p>
                    <ul class="collapsible popout" data-collapsible="accordion">
                        <li>
                            <div class="collapsible-header" style="background: #008643; color: white;"><i class="material-icons">receipt</i>Resultado Criterios de Viabilidad</div>
                            <div id="respuestainfo" class="collapsible-body"></div>
                        </li>
                        <li>
                            <div class="collapsible-header" style="background: #F9C000; color: white;"><i class="material-icons">account_circle</i>Responsables</div>
                            <div class="collapsible-body">
                                <div class="col s12">
                                    <br>
                                    <div class="input-field col s12">
                                        <i class="material-icons prefix">search</i>
                                        <input id="txtBuscarUsuarios" type="text" class="validate" onkeyup="encontrar();">
                                        <label for="txtSearchUsers">Realice la búsqueda por nombre o número de cedula.</label><br><br><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="margin-left: 16px; max-height: 140px; max-width: 96%; overflow: scroll; overflow-x: hidden;" id="respuestab" class="col s12">

                                    </div>
                                </div>
                                <hr>
                                <br>
                                <div id="usua">

                                </div>
                            </div>
                        </li>
                    </ul>
                    <div style="height: 100px;">
                        <!-- espacio -->
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="modale" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="registrarResponsables();">Guardar enviar</a>
                </div>
            </div>

            <?php require_once '../menu.php'; ?>
            <form id='frm_radicar_listas' name='frm_criterios_viabilidad' onSubmit="return false"  enctype="multipart/form-data">

                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="col s12 m12 l12 center-align">
                                    <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                        <i class="material-icons small left">account_box</i>
                                        Responsables
                                    </div>
                                    <br><br>
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
                                                    <div class="btn" onclick="buscarProyectos('<?php echo idEtapa; ?>');">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeydown="buscarProyectos('<?php echo idEtapa; ?>');">
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
