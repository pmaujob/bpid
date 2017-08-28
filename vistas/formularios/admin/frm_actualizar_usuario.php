
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BPID</title>
        <?php require_once '../../links.php'; ?>
        <script type="text/javascript" src="../../js/formularios/admin/frm_actualizar_usuario.js"></script>
        <script type="text/javascript" src="../../../modelo/fun_propias/validacion_campos.js"></script>
        <link type="text/css" rel="stylesheet" href="../../css/cssbpid/styles.css">
    </head>

    <body onload="onLoadBody();">
        <div id="mas" class="frm_externo"><img src="../../css/ajax-loader.gif"></div>
        <div id="d_error" title="ALERTA"></div>
        <div id="d_ingreso" title="INFORMACION"></div>
        <?php require_once '../../menu.php'; ?>

        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <h4>Permisos a funciones del sistema</h4>
                <p>Asigne permisos al usuario.</p>
                <div id="funciones" class="contenedor_tabla">

                </div>
            </div>
            <div class="modal-footer">
                <a id="modalg" class="modal-action modal-close waves-effect waves-green btn-flat " onclick="actualizarPermisosUsuario();">Ok</a>
            </div>
        </div>

        <div class="col s12 m11 l9">
            <div class="bajar">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                        <div class="col s12 m12 l12 center-align"><div class="titulofrm">ACTUALIZAR USUARIO</div></div>
                        <br><br>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m12 l12">
                            <div class="opcionesbtn">
                                <div class="file-field input-field">
                                    <div class="btn" onclick="buscarUsuarios();">
                                        <span>Buscar usuario</span>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeyup="buscarUsuarios();">
                                    </div>
                                </div>
                                <div class="descripcion">&nbsp;&nbsp;&nbsp;Realice la búsqueda por número de cédula o nombre de usuario.</div>
                            </div>
                        </div>
                    </div>
                    <br><br>
                    
                    <div class="row">
                        <div class="col s12 m12 l12">
                            <div id="respuesta">
                                
                            </div>
                        </div>
                    </div>

                </div>
                <?php //require_once "../../footer.php"; ?>
            </div>
        </div>

    </body>
</html>