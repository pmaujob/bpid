<?php
session_start();
require_once '../../librerias/SessionVars.php';
require_once '../../modelo/MPermisos.php';

const idFormulario = 4; //id 2 pertenece a lista de checkeo
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

        <body>

<!-- Modal Trigger -->
  
  <div id="modal1" class="modal">
    <div class="modal-content" id="titulo">
      <h4>Detalle Valor</h4>
      <p></p>
      <div id="respuestaact"></div>
    </div>
     <div id="cargando" class="frm_externo"><img src="../css/wait.gif"></div>
    <div class="modal-footer">
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Enviar</a>
    </div>
  </div>
  <!-- Modal Structure -->
            <div id="d_error" title="ALERTA"></div>
            <div id="d_ingreso" title="INFORMACION"></div>
          
            <?php require_once '../menu.php'; ?>
            <form id='frm_viabilidad' name='frm_viabilidad' onSubmit="return false"  enctype="multipart/form-data">


                <div class="col s12 m11 l9">
                    <div class="bajar">
                        <div class="container-fluid" >
                            <div class="row">
                                <div class="col s12 m12 l12 center-align"><div class="titulofrm">VIABILIDAD DE PROYECTO</div></div>
                                <br>
                                <br>
                            </div>
                            <div class="row" >
                                <div class="col s12 m12 l12">
                                    <div class="row" id="buscador">
                                        <div class="input-field col s12 m12 l12">
                                            <div class="opcionesbtn">
                                                <div class="file-field input-field">
                                                    <div class="btn" onclick="buscarProyectos();">
                                                        <span>Buscar proyecto</span>
                                                    </div>
                                                    <div class="file-path-wrapper">
                                                        <input id="input_buscar" class="file-path validate" type="text" placeholder="Buscar..." onkeydown="buscarProyectos(2);">
                                                    </div>
                                                </div>
                                                <div class="descripcion">&nbsp;&nbsp;&nbsp;Realice la búsqueda por número o nombre del proyecto.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="resultado" class="row"></div>
                                    <!--div class="col s12 m12 l12">
                                    <?php require_once "footer.php"; ?>
                                    </div-->
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
