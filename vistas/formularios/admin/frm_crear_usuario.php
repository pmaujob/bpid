
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>BPID</title>
        <?php require_once '../../links.php'; ?>
        <script type="text/javascript" src="../../js/formularios/admin/frm_crear_usuario.js"></script>
        <script type="text/javascript" src="../../../modelo/fun_propias/validacion_campos.js"></script>
        <link type="text/css" rel="stylesheet" href="../../css/cssbpid/styles.css">
    </head>

    <body>
        <div id="mas" class="frm_externo"><img src="../../css/ajax-loader.gif"></div>
        <div id="d_error" title="ALERTA"></div>
        <div id="d_ingreso" title="INFORMACION"></div>
        <?php require_once '../../menu.php'; ?>
        <form id='frm_crear' name='frm_crear_usuario'>

            <div class="col s12 m11 l9">
                <div class="bajar">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col s12 m12 l12 center-align"><div class="titulofrm">CREAR USUARIO</div></div>
                            <br><br>
                        </div>

                        <div class="row">
                            <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">CÉDULA</div></div></div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="opcionesbtn">
                                        <div class="input-field col s12 m12 l12">
                                            <input id="frm_cedula" type="text" class="validate" onkeyup="validar();">
                                            <label for="frm_cedula">Cédula</label>
                                            <div class="descripcion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">CORREO USUARIO</div></div></div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="opcionesbtn">
                                        <div class="input-field col s12 m12 l12">
                                            <input id="frm_correo" type="email" readonly>
                                            <label for="frm_correo">Correo usuario</label>
                                            <div class="descripcion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">NOMBRE</div></div></div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="opcionesbtn">
                                        <div class="input-field col s12 m12 l12">
                                            <input id="frm_nombre" type="text" readonly>
                                            <label for="frm_nombre">Nombre usuario</label>
                                            <div class="descripcion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">APELLIDOS</div></div></div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="opcionesbtn">
                                        <div class="input-field col s12 m12 l12">
                                            <input id="frm_apellido" type="text" readonly>
                                            <label for="frm_apellido">Apellido usuario</label>
                                            <div class="descripcion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">DEPENDENCIA</div></div></div>
                            <div class="col s12 m10 l10">
                                <div class="row">
                                    <div class="opcionesbtn">
                                        <div class="input-field col s12 m12 l12">
                                            <input id="frm_dependencia" type="text"readonly>
                                            <label for="frm_dependencia">Dependencia</label>
                                            <div class="descripcion"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <br><br>
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="card-panel teal">
                                    <span id="respuesta" class="white-text"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s2 m2 l2"></div>
                            <div class="col s8 m8 l12 center-align">
                                <br>
                                <button class="btn waves-effect waves-light" onclick="validar()">
                                    Crear <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>

                    </div>
                    <?php //require_once "../../footer.php"; ?>
                </div>
            </div>
        </form>

    </body>
</html>