<?php
session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

        const idFormulario = 1;
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
            <script type="text/javascript" src="../js/formularios/frm_radicar.js"></script>
            <script type="text/javascript" src="../../modelo/fun_propias/validacion_campos.js"></script>
        </head>

        <body>
            <div id="dario"></div>
            <div id="cargando" class="frm_externo"><img src="../css/wait.gif"></div>
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
            <?php require_once '../menu.php'; ?>
            <form id='frm_radicar' name='frm_radicar' onSubmit="return false"  enctype="multipart/form-data">

                <input id="objetivos" name="objetivos" type="hidden" value="" />
                <input id="fuentes" name="fuentes" type="hidden" value="" />
                <input id="problema" name="problema" type="hidden" value="" />
                <input id="poblacion" name="poblacion" type="hidden" value="" />
                <input id="objetivog" name="objetivog" type="hidden" value="" />
                <input id="productos" name="productos" type="hidden" value="" />
                <input id="actividades" name="actividades" type="hidden" value="" />
                <input id="frm_eje" name="frm_eje" type="hidden"  readonly/>
                <input id="frm_programa" name="frm_programa" type="hidden" readonly/>
                <input id="frm_subprograma" name="frm_subprograma"  type="hidden" readonly/>
                <input id="total" name="total" type="hidden" value="" />
                <input id="resumen" name="resumen" type="hidden" value="" />

                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid">

                            <div class="row">
                                <div class="col s12 m12 l12 center-align" style="height: 100px;"></div>
                                <div class="col s12 m12 l12 center-align">
                                    <div class="chip white-text" style="background-color: #008643; font-size: 16px; height: 36px; margin-top: -16px; padding-top: 4px; padding-left: 46px; padding-right: 46px;">
                                        <i class="material-icons small left">description</i>
                                        Radicar Nuevo Proyecto
                                    </div>
                                </div>
                                <br><br>
                            </div>
                            <div class="row">
                                <div class="col s12 m2 l2"><div class="amarilla"></div><label id="lblamarilla">SELECCIONAR MGA XML</label></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="input-field col s12 m12 l12">
                                            <div class="opcionesbtn">
                                                <div class="file-field input-field">
                                                    <div class="btn">
                                                        <span>Subir Archivo MGA XML</span>
                                                        <input type="file" id="frm_archivo" name="frm_archivo" onchange="archivo_xml()" multiple
                                                               alt="Cargar Archivo MGA WEB">
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input class="file-path validate" type="text" placeholder="Seleccionar archivo XML">
                                                    </div>
                                                </div>
                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">NOMBRE PROYECTO</div></div></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="opcionesbtn">
                                            <div class="input-field col s12 m12 l12">
                                                <textarea class="materialize-textarea" id="frm_nom_proyecto" name="frm_nom_proyecto" ></textarea>
                                                <label for="textarea1">Nombre Proyecto</label>

                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">NUMERO PROYECTO</div></div></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="opcionesbtn">
                                            <div class="input-field col s12 m12 l12">
                                                <input id="frm_num_proyecto" name="frm_num_proyecto" type="text" readonly/>
                                                <label for="frm_num_proyecto">numero Proyecto</label>
                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">SECTOR PROYECTO</div></div></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="opcionesbtn">
                                            <div class="input-field col s12 m12 l12">
                                                <input id="frm_sector" name="frm_sector" type="text" readonly/>
                                                <label for="frm_sector" id="d_frm_sector">Sector de Proyecto</label>
                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">LOCALIZACION</div></div></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="opcionesbtn">
                                            <div class="input-field col s12 m12 l12">
                                                <input id="frm_localizacion" name="frm_localizacion" type="text" readonly/>
                                                <label for="frm_localizacion">Localizacion Proyecto</label>
                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s12 m2 l2"><div class="etiquetafrm"><div class="textofrm">VALOR</div></div></div>
                                <div class="col s12 m10 l10">
                                    <div class="row">
                                        <div class="opcionesbtn">
                                            <div class="input-field col s12 m12 l12">
                                                <input id="frm_valor" name="frm_valor" type="text" readonly/>
                                                <label for="frm_valor">Valor Proyecto</label>
                                                <div class="descripcion"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col s2 m2 l2"></div>
                                <div class="col s8 m8 l12 center-align">
                                    <br>
                                    <button class="btn waves-effect waves-light" onclick="validar()">Enviar
                                        <i class="material-icons right">send</i>
                                    </button>

                                    <button class="btn waves-effect waves-light" onclick="Borrar()">Borrar
                                        <i class="material-icons right">send</i>
                                    </button>

                                    <div class="col s2 m2 l2"></div>
                                </div>

                            </div>
                            <!-- MODAL-->
                            <div class="container">
                                <div class="row">
                                    <div id="modal1" class="modal modal-fixed-footer">
                                        <div class="modal-content" >
                                            <h5>DATOS COMPLEMENTARIOS</h5>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <select id="frm_poai" name="frm_poai">
                                                        <option value="" disabled selected>PERTENECE AL POAI</option>
                                                        <option value="1">SI</option>
                                                        <option value="2">NO</option>
                                                    </select>
                                                    <label>PERTENECE AL POAI</label>
                                                    <div id="d_frm_poai"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <select id="frm_poai" name="frm_programa">
                                                        <option value="" disabled selected>PERTENECE A UN PROGRAMA DE INVERSION</option>
                                                        <option value="1">NUMERO DE PROGRAMA 1</option>
                                                        <option value="2">NUMERO DE PROGRAMA 2</option>
                                                    </select>
                                                    <label>PERTENECE A UN PROGRAMA DE INVERSION</label>
                                                    <div id="d_frm_poai"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input id="frm_entidad" name="frm_entidad" type="text" class="validate">
                                                    <label for="frm_entidad" id="lbl_frm_entidad">ENTIDAD PROPONENTE</label>
                                                    <div id="d_frm_entidad"></div>
                                                </div>
                                            </div>
                                            <BR>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input  id="frm_entidad_ejecuta" name="frm_entidad_ejecuta" type="text" class="validate" >
                                                    <label for="frm_entidad_ejecuta" id="lbl_">ENTIDAD EJECUTANTE</label>
                                                    <div id="d_frm_entidad_ejecuta"></div>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row">
                                                <h6>RESPONSABLE DEL PROYECTO</h6>
                                                <div class="input-field col s6">
                                                    <input  id="frm_id_responsable" name="frm_id_responsable" type="text" class="validate"
                                                            onKeyPress="return solonum(event)" onchange="buscarUsuario(1)">
                                                    <label for="frm_id_responsable">No IDENTIFICACION</label>
                                                    <div id="d_frm_id_responsable"></div>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="frm_nom_responsable" name="frm_nom_responsable" type="text" class="validate"
                                                           >
                                                    <label for="frm_nom_responsable">NOMBRE RESPONSABLE</label>
                                                    <div id="d_frm_nom_responsable"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <br>
                                                <div class="input-field col s6">
                                                    <input  id="frm_cargo_responsable" name="frm_cargo_responsable" type="text" class="validate"                                >
                                                    <label for="frm_cargo_responsable">CARGO</label>
                                                    <div id="d_frm_cargo_responsable"></div>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="frm_dir_responsable" name="frm_dir_responsable" type="text" class="validate">
                                                    <label for="frm_dir_responsable">DIRECCION</label>
                                                    <div id="d_frm_dir_responsable"></div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <br>
                                                <div class="input-field col s6">
                                                    <input  id="frm_tel_responsable" name="frm_tel_responsable" type="text" class="validate"
                                                            onKeyPress="return solonum(event)" >
                                                    <label for="frm_tel_responsable">TELEFONO/FAX</label>
                                                    <div id="d_frm_tel_responsable"></div>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="frm_cel_responsable" name="frm_cel_responsable" type="text" class="validate"
                                                           onKeyPress="return solonum(event)" >
                                                    <label for="frm_cel_responsable">CELULAR</label>
                                                    <div id="d_frm_cel_responsable"></div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <input  id="frm_correo" name="frm_correo" type="email" class="validate">
                                                    <label for="frm_correo">CORREO ELECTRONICO</label>
                                                    <div id="d_frm_correo"></div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <h6>DATOS PERSONA QUE ENTREGA EL PROYECTO</h6>
                                                <div class="input-field col s6">
                                                    <input  id="frm_id_usuario" name="frm_id_usuario" type="text" class="validate"
                                                            onKeyPress="return solonum(event)" onchange="buscarUsuario(2)">
                                                    <label for="frm_id_usuario">No IDENTIFICACION</label>
                                                    <div id="d_frm_id_usuario"></div>
                                                </div>
                                                <div class="input-field col s6">
                                                    <input id="frm_nom_usuario" name="frm_nom_usuario" type="text" class="validate"
                                                           >
                                                    <label for="frm_nom_usuario">NOMBRE USUARIO</label>
                                                    <div id="d_frm_nom_usuario"></div>
                                                </div>
                                            </div>
                                            <br>
                                            <h6>OBSERVACIONES</h6>
                                            <div class="row">
                                                <div class="input-field col s12">
                                                    <textarea class="materialize-textarea" id="frm_observaciones" name="frm_observaciones">
                                                    </textarea>
                                                    <input id="frm_num_programa" name="frm_num_programa" type="hidden" value="000">
                                                    <label for="frm_observaciones">OBSERVACIONES</label>
                                                    <div id="d_frm_observaciones"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <img id="waitGuardarProgreso" src="./../css/wait.gif" style="width: 68px; height: 43px; display: none" >
                                            <a href="#!"  onClick="if (validar_campos_requeridos('frm_poai-frm_entidad-frm_entidad_ejecuta-frm_id_responsable-frm_nom_responsable-frm_cargo_responsable-frm_dir_responsable-frm_cel_responsable-frm_correo-frm_id_usuario-frm_nom_usuario', 11) == true)
                                                            almacenar()" class="modal-action  waves-effect waves-green btn-flat ">Guardar</a>
                                            <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>

                                        </div>
                                    </div>


                                </div>

                            </div>

                        </div>
                    </div>


                </div></div></form>

    </body>
    </html>

    <?php
} else {
    $ruta = $_SESSION['raiz'];
    //$ruta='https://www.google.com.co';
    $ruta = '../index.php';
    header("location: $ruta");

    echo $ruta;
}
?>